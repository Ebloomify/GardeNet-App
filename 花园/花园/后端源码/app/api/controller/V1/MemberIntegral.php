<?php 
/*
 module:		会员积分记录
 create_time:	2021-11-16 04:26:51
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\model\V1\ConfigInteger;
use app\api\service\V1\MemberIntegralService;
use app\api\model\V1\MemberIntegral as MemberIntegralModel;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class MemberIntegral extends Common {


	/**
	* @api {get} /V1.MemberIntegral/index 01、首页数据列表
	* @apiGroup MemberIntegral
	* @apiVersion 1.0.0
	* @apiDescription  首页数据列表

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码 201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.data 返回数据
	* @apiParam (成功返回参数：) {string}     	array.data.list 返回数据列表
	* @apiParam (成功返回参数：) {string}     	array.data.count 返回数据总数
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":{
    "member_level": {
    "nickname": "幸福的麦片",
    "avatar": "/uploads/admin/202101/5ff40b8d7fbd2.jpg",
    "member_level": "1",当前等级
    "all_integral": "168", 累积积分
    "integral": "144", 当前积分
    "member_level_exp": "0" 当前等级经验值
    },"config_member_integer": [
    {
    "level": "1", level
    "min": "0", 积分下限
    "max": "100", 积分上限
    "content": "0-100 points", 文字描述
    "sort": "1"
    }
    ,"member_integer": {
    "list": [
    {
    "member_integral_id": "35",
    "member_id": "9",
    "config_integer_id": "1",
    "type": "1", 增减类型 1加 0减
    "create_time": "1641208179", 创建时间
    "integral": "5", 积分数量
    "inte_desc": "Post in Community" 说明内容
    }]},
     "config_integer": [
    {
    "config_integer_id": "1",
    "name": "Post in Community", 任务名称
    "add_integer": "5", 增加的积分
    "finish_sum": "5", 任务数量
    "sort": "1",
    "is_once": "0", 是否只能完成一次
    "member_finish_num": "1" 我当前完成次数
    }
     }
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"查询失败"}
	*/
    function index(){
        $limit  = $this->request->get('limit', 20, 'intval');
        $page   = $this->request->get('page', 1, 'intval');


        $field = 'level,min,max,content,sort';
        $orderby = 'sort asc';

        $config_member_integer = \app\api\model\ConfigMemberInteger::order($orderby)->field($field)->select()->toArray();

        $where = [];
        if(!$where['member_id']=$this->request->uid){
            return $this->ajaxReturn($this->errorCode, '请登录后重试');
        }
        $field = '*';
        $orderby = 'member_integral_id desc';

        $member_integer = MemberIntegralService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
        $member = \app\api\model\V1\Member::where('member_id',$where['member_id'])
            ->field('nickname,avatar,member_level,all_integral,integral,member_level_exp')->find();

        //积分任务
        $config_integer = ConfigInteger::order('sort','asc')->select()->toArray();
        //我当前完成的积分
        $member_integer_finish = \app\api\model\V1\MemberIntegral::where('member_id',$where['member_id'])
            ->field('max(config_integer_id) as config_integer_id,count(config_integer_id) as num')
            ->where('config_integer_id','>',0)->where('type',1)
            ->whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')")
            ->group('config_integer_id')
            ->select()->toArray();

        foreach($config_integer as $k=>$v){
            $config_integer[$k]['member_finish_num'] = 0;
            $member_integer_finish = \app\api\model\V1\MemberIntegral::where('member_id',$where['member_id'])
                ->field('max(config_integer_id) as config_integer_id,count(config_integer_id) as num')
                ->where('type',1)->where('config_integer_id',$v['config_integer_id']);
            if($v['is_once']==0){
                $member_integer_finish = $member_integer_finish
                    ->whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')");
            }
            $member_integer_finish = $member_integer_finish->group('config_integer_id')->find();
            if($member_integer_finish){
                $config_integer[$k]['member_finish_num'] = $member_integer_finish['num'];
            }
//            $config_integer[$k]['member_finish_num'] = 0;
//            foreach($member_integer_finish as $vv){
//                if($vv['config_integer_id']==$v['config_integer_id']){
//                    $config_integer[$k]['member_finish_num']=$vv['num'];
//                }
//            }
        }
        
        $res = [
            'member_level'=>$member,
		    'config_member_integer'=>$config_member_integer,
            'member_integer'=>$member_integer,
            'config_integer'=>$config_integer
        ];

        return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($res));
    }



}

