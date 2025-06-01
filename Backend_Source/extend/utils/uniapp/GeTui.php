<?php
/**
 * Created by : PhpStorm
 * User: fk
 * Date: 19/1/2022
 * Time: 上午10:56
 */

namespace utils\uniapp;

use GTClient;
use Redis\RedisPackage;
use GTPushRequest;
use GTPushMessage;
use GTNotification;
use GTSettings;
use GTStrategy;
use GTPushChannel;
use GTIos;
use GTAndroid;
use GTAps;
use GTAlert;
use GTUps;

class GeTui
{
    const APPID         = 'a';
    const APPKEY        = 'b';
    const MASTERSECRET  = 'c';

    const GT_TOKEN_NAME = 'getui_token'; //redis存储token的名

    private static $token      = '';

    private static $gtObject   = '';


    //关于一些推送的消息的设置
    public static $messageData = [];

    public static function getObject()
    {
        self::$gtObject = new GTClient("https://restapi.getui.com",config('my.uni_push.app_key'),config('my.uni_push.app_id'),config('my.uni_push.master_secret'));
    }

    /**
     * Name [[关于推送消息的设置]]
     * User: fk
     * @param $data
     * $data 19/1/2022 下午4:01
     */
    public static function setMessageData($data)
    {
        self::$messageData = $data;
    }

    /**
     * Name [[获取鉴权token，并存储redis,官方封装了并没有给主动赋值token不再次鉴权的方法；所以此方法目前不用]]
     * User: fk
     * $data 19/1/2022 上午10:59
     */
    public static function getToken()
    {
        $redis = new RedisPackage();

        $token = $redis::get(self::GT_TOKEN_NAME);

        if($token == ''){
            $gtObject = new GTClient("https://restapi.getui.com",config('my.uni_push.app_key'),config('my.uni_push.app_id'),config('my.uni_push.master_secret'));

            $token = $gtObject->getAuthToken();

            $redis::set(self::GT_TOKEN_NAME,$token,3600);
        }
    }

    /**
     * Name [[生成一个]]
     * User: fk
     * $data 19/1/2022 下午1:31
     */
    public static function getRequestId()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 't', 'U', 'V', 'W', 'X', 'Y', 'Z');
        return strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
    }

    public static function setIntent()
    {
        $messageData = self::$messageData;

        //-------------------------------- 个推的（透传） ----------------------------------------------------
        $gt_page_type = 1;   //1:正常页面   2：tabBar页面
        if(
            stristr($messageData['urlStr'],'pages/center/center')
        ){
            $gt_page_type = 2;
        }

        self::$messageData['gt_transmission']['urlStr'] = urlencode(self::$messageData['urlStr']);
        self::$messageData['gt_transmission']['urlType'] = $gt_page_type;
        if(array_key_exists('intent_arr',$messageData) && !empty($messageData['intent_arr'])){
            foreach ($messageData['intent_arr'] as $intentArrKey => $intentArrVal)
            {
                self::$messageData['gt_transmission'][$intentArrKey] = $intentArrVal;
            }
        }

        //-------------------------------- 厂商的（安卓的普通消息） ---------------------------------------------------
        $azParam = "";
        if(!empty(self::$messageData['gt_transmission'])){
            foreach (self::$messageData['gt_transmission'] as $gtTransmissionKey => $gtTransmissionVal)
            {
                $azParam.="S.$gtTransmissionKey=$gtTransmissionVal;";
            }
        }
//        $url = "intent:#Intent;action=android.intent.action.oppopush;launchFlags=0x14000000;component=uni.UNIC85EB52/io.dcloud.PandoraEntry;S.UP-OL-SU=true;{$azParam}end";
        $payload = json_encode(self::$messageData['gt_transmission']);
        $url = "intent:#Intent;action=android.intent.action.oppopush;launchFlags=0x14000000;component=uni.UNIE8286B1/io.dcloud.PandoraEntry;S.UP-OL-SU=true;S.payload={$payload};end";
        self::$messageData['cs_az_intent'] = $url;
    }

    /**
     * Name [[单推]]
     * User: fk
     * $data 19/1/2022 下午1:27
     */
    public static function pushOneMessage($cid,$requestId = '')
    {
        self::setIntent();
        $messageData = self::$messageData;

        if($requestId == '') $requestId = self::getRequestId();

        //设置setting
        $set = new \GTSettings();
        $set->setTtl(3600000);
//    $set->setSpeed(1000);
//    $set->setScheduleTime(1591794372930);
        $strategy = new \GTStrategy();
        $strategy->setDefault(\GTStrategy::STRATEGY_THIRD_FIRST);
        $set->setStrategy($strategy);


        //设置推送参数
        $push = new GTPushRequest();
        $push->setRequestId($requestId);
        $push->setSettings($set);

        $message = new GTPushMessage();

        //个推的（透传）-----------------------------------------------------------------------
        $message->setTransmission(json_encode($messageData['gt_transmission']));
        $push->setPushMessage($message);

        //厂商的（普通消息）-------------------------------------------------------------------
        $GTPushChannel = new GTPushChannel();

        $GTIos = new GTIos();
        $GTAps = new GTAps();
        $GTAlert = new GTAlert();
        $GTIos->setType('notify');
        $GTAlert->setTitle($messageData['title']);
        $GTAlert->setBody($messageData['body']);
        $GTAps->setAlert($GTAlert);
        $GTIos->setAps($GTAps);
        $GTIos->setPayload(json_encode($messageData['gt_transmission']));
        $GTIos->setAutoBadge('+1');
        $GTPushChannel->setIos($GTIos);

        $GTAndroid = new GTAndroid();
        $GTUps = new GTUps();
        $csAzNotify = new GTNotification();
        $csAzNotify->setTitle($messageData['title']);
        $csAzNotify->setBody($messageData['body']);
        $csAzNotify->setClickType('intent');
        $csAzNotify->setIntent($messageData['cs_az_intent']);
        $GTUps->setNotification($csAzNotify);
        $GTAndroid->setUps($GTUps);
        $GTPushChannel->setAndroid($GTAndroid);

        $push->setPushChannel($GTPushChannel);
        //结束--------------------------------------------------------------------------------

        $push->setCid($cid);
        //处理返回结果
        $result = self::$gtObject->pushApi()->pushToSingleByCid($push);

        echo "<pre>";
        print_r($result);
        echo "</pre>";
    }
}