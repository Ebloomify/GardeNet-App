<?php
/*
 module:		花园
 create_time:	2021-12-23 23:46:57
 author:		
 contact:		
*/

namespace app\api\service\V1;

use app\api\model\V1\Garden;
use app\api\model\V1\Remind;
use app\api\service\RedisService;
use think\facade\Log;
use think\exception\ValidateException;
use xhadmin\CommonService;

class GardenService extends CommonService
{


    /*
     * @Description  列表数据
     */
    public static function listList($where, $field, $orderby, $limit, $page)
    {
        try {
            $res = Garden::where($where)->field($field)->order($orderby)->paginate(['list_rows' => $limit, 'page' => $page])->toArray();
        } catch (\Exception $e) {
            abort(config('my.error_log_code'), $e->getMessage());
        }
        return ['list' => $res['data'], 'count' => $res['total']];
    }


    /*
     * @Description  创建数据
     */
    public static function add($data)
    {
        try {
            validate(\app\api\validate\V1\Garden::class)->scene('add')->check($data);
            $data['create_time'] = time();

            $img = [];
            foreach (explode(',', $data['img']) as $k => $v) {
                $img[] = ['url' => $v, 'title' => ''];
            }
            $data['img'] = json_encode($img, 256);

            $res = Garden::create($data);
        } catch (ValidateException $e) {
            throw new ValidateException ($e->getError());
        } catch (\Exception $e) {
            abort(config('my.error_log_code'), $e->getMessage());
        }
        return $res->id;
    }


    /*
     * @Description  编辑数据
     */
    public static function update($where, $data)
    {
        try {
            validate(\app\api\validate\V1\Garden::class)->scene('update')->check($data);
            !is_null($data['create_time']) && $data['create_time'] = strtotime($data['create_time']);
            $data['update_time'] = time();
            if (array_key_exists('img', $data)) {
                $img = [];
                foreach (explode(',', $data['img']) as $k => $v) {
                    $img[] = ['url' => $v, 'title' => ''];
                }
                $data['img'] = json_encode($img, 256);
            }

            $res = Garden::where($where)->update($data);
        } catch (ValidateException $e) {
            throw new ValidateException ($e->getError());
        } catch (\Exception $e) {
            abort(config('my.error_log_code'), $e->getMessage());
        }
        return $res;
    }


    /*
     * @Description  编辑数据
     */
    public static function setRemind($data)
    {
        try {
            //查询花园提醒名称和图标
            $garden_icon = db('garden_icon')->where('id', $data['id'])->find();
            //`type` tinyint DEFAULT NULL COMMENT '0单次 1每日 2每月 3每年',
            //  `remind_num` int DEFAULT '1',
            //  `start_time` int DEFAULT NULL,
            //  `end_time` int DEFAULT NULL,
            if (!$garden_icon) {
                throw new ValidateException ('提醒类型不存在');
            }
            $client_id = '';
            if (array_key_exists('client_id', $data) && $data['client_id']) {
                $client_id = $data['client_id'];
            } else {
                if ($id = db('member')->where('member_id', $data['member_id'])->value('client_id')) {
                    $client_id = $id;
                }
            }
            if (!$client_id) {
                return false;
            }
            $remind_data = [
                'remind_name' => $garden_icon['name'],
                'remind_icon' => $garden_icon['icon'],
                'member_id' => $data['member_id'],
                'day' => $data['day'] ?: 0,
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'create_time' => time(),
                'client_id' => $client_id,
                'remind_num' => 0,
                'garden_id' => $data['garden_id'],
                'garden_name'=>db('garden')->where('id',$data['garden_id'])->value('plant_name')
            ];
            //设置的结束时间与现在时间相差天数
            $day = self::diffBetweenTwoDays($data['end_time'], date('Y-m-d H:i:s'));
            //计算提醒次数
            if ($remind_data['day'] == 0) {
                $remind_data['num'] = 1;
            } else {
                $day_ = $day / $data['day'];
                if ($day < 1 || $day < $data['day']) {
                    throw new ValidateException ('时间设置错误!');
                } else {
                    $remind_data['num'] = (int)($day_);
                }
            }
            $res = db('remind')->insertGetId($remind_data);
            //设置redis

            if ($remind_data['day'] == 0) {
                RedisService::connect()->zadd('Garden:remind', strtotime($remind_data['start_time']), strtotime($remind_data['start_time']) . '.' . $res);
            } else {
                $date = $remind_data['start_time'];
                $time = '';
                for ($i = 0; $i < $remind_data['num']; $i++) {
                    if ($i == 0) {
                        $time = strtotime($date);
                        RedisService::connect()->zadd('Garden:remind', $time, $time . '.' . $res);
                    } else {

                        $time = strtotime(date('Y-m-d H:i:s', $time) . ' +' . $remind_data['day'] . ' days');
                        RedisService::connect()->zadd('Garden:remind', $time, $time . '.' . $res);
                    }
                    $date = date('Y-m-d H:i:s', $time);
                }
            }

            return $res;
        } catch (ValidateException $e) {
            throw new ValidateException ($e->getError());
        } catch (\Exception $e) {
            abort(config('my.error_log_code'), $e->getMessage());
        }
        return false;
    }

    public static function diffBetweenTwoDays($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return (int)round(($second1 - $second2) / 86400, 0);
    }

    public static function getParam($data, $config,$id)
    {
        $push = new \GTPushRequest();
        $push->setRequestId(micro_time());
        //设置setting
        $set = new \GTSettings();
        $set->setTtl(3600000);
//    $set->setSpeed(1000);
//    $set->setScheduleTime(1591794372930);
        $strategy = new \GTStrategy();
        $strategy->setDefault(\GTStrategy::STRATEGY_THIRD_FIRST);
//    $strategy->setIos(GTStrategy::STRATEGY_GT_ONLY);
//    $strategy->setOp(GTStrategy::STRATEGY_THIRD_FIRST);
//    $strategy->setHw(GTStrategy::STRATEGY_THIRD_ONLY);
        $set->setStrategy($strategy);
        $push->setSettings($set);
        //设置PushMessage，
        $message = new \GTPushMessage();
        //通知
        $notify = new \GTNotification();
        $notify->setTitle($data['title']);
        $notify->setBody($data['body']);
//        $notify->setBigText("bigTdext");
        //与big_text二选一
//    $notify->setBigImage("BigImage");

        $notify->setLogo("push.png");
        $notify->setLogoUrl("LogoUrl");
        $notify->setChannelId("Default");
        $notify->setChannelName("Default");
        $notify->setChannelLevel(3);

        $notify->setClickType("intent");
        $android_package_name = config('my.uni_push.android_package_name');
        //intent://com.getui.push/detail?#Intent;scheme=gtpushscheme;launchFlags=0x4000000;package=com.getui.demo;component=com.getui.demo/com.getui.demo.DemoActivity;S.payload=payloadStr;end
        $notify->setIntent("intent:#Intent;component=$android_package_name/pages/center/garden/info;S.id=$id;end");
//        $notify->setUrl("url");
//        $notify->setPayload("Payload");
//        $notify->setNotifyId(22334455);
//        $notify->setRingName("ring_name");
        $notify->setBadgeAddNum(1);
        $message->setNotification($notify);
        //透传 ，与通知、撤回三选一
//        $message->setTransmission("试试透传");
        //撤回
//        $revoke = new \GTRevoke();
//        $revoke->setForce(true);
//        $revoke->setOldTaskId("taskId");
//    $message->setRevoke($revoke);
        $push->setPushMessage($message);
//        $message->setDuration("1590547347000-1590633747000");
        //厂商推送消息参数
        $pushChannel = new \GTPushChannel();
        //ios
        $ios = new \GTIos();
        $ios->setType("notify");
        $ios->setAutoBadge("1");
        $ios->setPayload("ios_payload");
        $ios->setApnsCollapseId("apnsCollapseId");
        //aps设置
        $aps = new \GTAps();
        $aps->setContentAvailable(0);
        $aps->setSound("com.gexin.ios.silenc");
        $aps->setCategory("category");
        $aps->setThreadId("threadId");

        $alert = new \GTAlert();
        $alert->setTitle("alert title");
        $alert->setBody("alert body");
        $alert->setActionLocKey("ActionLocKey");
        $alert->setLocKey("LocKey");
        $alert->setLocArgs(array("LocArgs1", "LocArgs2"));
        $alert->setLaunchImage("LaunchImage");
        $alert->setTitleLocKey("TitleLocKey");
        $alert->setTitleLocArgs(array("TitleLocArgs1", "TitleLocArgs2"));
        $alert->setSubtitle("Subtitle");
        $alert->setSubtitleLocKey("SubtitleLocKey");
        $alert->setSubtitleLocArgs(array("subtitleLocArgs1", "subtitleLocArgs2"));
        $aps->setAlert($alert);
        $ios->setAps($aps);

        $multimedia = new \GTMultimedia();
        $multimedia->setUrl("url");
        $multimedia->setType(1);
        $multimedia->setOnlyWifi(false);
        $multimedia2 = new \GTMultimedia();
        $multimedia2->setUrl("url2");
        $multimedia2->setType(2);
        $multimedia2->setOnlyWifi(true);
        $ios->setMultimedia(array($multimedia));
        $ios->addMultimedia($multimedia2);
        $pushChannel->setIos($ios);
        //安卓
        $android = new \GTAndroid();
        $ups = new \GTUps();
//    $ups->setTransmission("ups Transmission");
        $thirdNotification = new \GTThirdNotification();
        $thirdNotification->setTitle($data['title']);
        $thirdNotification->setBody($data['body']);
        $thirdNotification->setClickType(\GTThirdNotification::CLICK_TYPE_INTENT);
        $thirdNotification->setIntent("intent:#Intent;component=$config[android_package_name]/pages/center/garden/info;S.id=$id;end");
//        $thirdNotification->setIntent("intent:#Intent;action=android.intent.action.oppopush;launchFlags=0x14000000;component=$config[android_package_name]/pages/center/garden/info?id=$id;S.UP-OL-SU=true;S.title=$data[title];S.content=$data[body];S.payload=test;end");
        $thirdNotification->setUrl("http://docs.getui.com/getui/server/rest_v2/push/");
//        $thirdNotification->setPayload("payload");
//        $thirdNotification->setNotifyId(456666);
        $ups->addOption("HW", "badgeAddNum", 1);
        $ups->addOption("OP", "channel", "Default");
        $ups->addOption("OP", "aaa", "bbb");
        $ups->addOption(null, "a", "b");

        $ups->setNotification($thirdNotification);
        $android->setUps($ups);
        $pushChannel->setAndroid($android);
        $push->setPushChannel($pushChannel);

        return $push;
    }


}

