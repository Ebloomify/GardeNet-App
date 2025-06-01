<?php
/*
 module:		Community
 create_time:	2021-07-12 13:50:05
 author:		
 contact:		
*/

namespace app\api\service\V1;

use app\api\model\ConfigMemberInteger;
use app\api\model\V1\CommunityArticle;
use app\api\model\V1\ConfigInteger;
use app\api\model\V1\Member;
use app\api\model\V1\MemberIntegral;
use think\Exception;
use think\facade\Db;
use think\facade\Log;
use think\exception\ValidateException;
use xhadmin\CommonService;

class IntegerService extends CommonService
{

    public static function plus($config_integer_id, $member_id, $add_integer = 0)
    {
        \db()->startTrans();
        try {
            if ($config_integer_id != 0) {
                if (!$res = ConfigInteger::where('config_integer_id', $config_integer_id)->find())
                    Throw new Exception('服务器错误');

                //查询今日积分完成数量石佛已满
                $member_integer_finish_num = MemberIntegral::where('member_id', $member_id)
                    ->where('config_integer_id', $config_integer_id)->where('type', 1);
                if ($res['is_once']==0) {
                    $member_integer_finish_num = $member_integer_finish_num->whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')");
                }

                $member_integer_finish_num = $member_integer_finish_num->count();
                if ($member_integer_finish_num >= $res['finish_sum']) {
                    \db()->rollback();
                    return false;
                }
            } else {
                $res = [
                    'add_integer' => $add_integer,
                    'config_integer_id' => $config_integer_id,
                    'name' => 'Q&A'
                ];
            }

            //增加积分
            Member::where('member_id', $member_id)
                ->inc('all_integral', $res['add_integer'])->inc('integral', $res['add_integer'])->update();
            $member_level_exp = db('member')->where('member_id',$member_id)->value('member_level_exp');
            $max_integer = db('config_member_integer')->max('max');
            if($member_level_exp+$res['add_integer']>$max_integer){
               Member::where('member_id',$member_id)->update(['member_level_exp'=>$max_integer]);
            }else{
                Member::where('member_id',$member_id)->inc('member_level_exp', $res['add_integer'])->update();
            }
            MemberIntegral::create([
                'member_id' => $member_id,
                'config_integer_id' => $res['config_integer_id'],
                'type' => 1,
                'create_time' => time(),
                'integral' => $res['add_integer'],
                'inte_desc' => $res['name']
            ]);
            //计算经验值，满足升级要求升级并减少相应经验

            $member = Member::where('member_id', $member_id)->field('member_level,member_level_exp')->find();


            $config_member_integer = ConfigMemberInteger::where('min','<=',$member['member_level_exp'])
                ->order('min','desc')->limit(1)->value('level');

                $member->member_level=$config_member_integer;
                $member->save();
            \db('integer_log')->insert([
                'member_id'=>$member_id,'integer'=>$res['add_integer'],'type'=>2,'create_time'=>time()
            ]);
            \db()->commit();
            return true;
        } catch (\Exception $e) {
            \db()->rollback();
            abort(config('my.error_log_code'), $e->getMessage());
        }
        return true;
    }


    public static function minus($integer, $member_id,$desc)
    {
        \db()->startTrans();
        try {
//            if (!$res = ConfigInteger::where('config_integer_id', $config_integer_id)->find())
//                Throw new Exception('服务器错误');

            //增加积分
            Member::where('member_id', $member_id)->where('integral','>=',$integer)
                ->dec('integral', $integer)->update();
            MemberIntegral::create([
                'member_id' => $member_id,
//                'config_integer_id' => 0,
                'type' => 0,
                'create_time' => time(),
                'integral' => $integer,
                'inte_desc' => $desc
            ]);
            \db('integer_log')->insert([
                'member_id'=>$member_id,'integer'=>$integer,'type'=>1,'create_time'=>time()
            ]);
            //增加经验
            \db()->commit();
            return true;
        } catch (\Exception $e) {
            \db()->rollback();
            abort(config('my.error_log_code'), $e->getMessage());
        }
        return true;
    }

}

