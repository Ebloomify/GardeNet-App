<?php 
/*
 module:		增减积分
 create_time:	2021-11-16 16:57:40
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\model\V1\ConfigInteger;
use app\api\service\V1\IntegerService;
use app\api\service\V1\PlusMinusIntegerService;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class PlusMinusInteger extends Common {


	/**
	* @api {post} /V1.PlusMinusInteger/save 01、加减积分
	* @apiGroup PlusMinusInteger
	* @apiVersion 1.0.0
	* @apiDescription  创建数据

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}			type  (必填) 1 增加 2减少
	* @apiParam (输入参数：) {string}			integer  (必填) 积分值
	* @apiParam (输入参数：) {string}			[integer_dec]  积分说明

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function save(){
		$postField = 'type,integer,integer_dec';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!isset($data['integer'])||!$data['integer']){
            return $this->ajaxReturn($this->errorCode, '参数丢失');
        }
        if(!$member_id = $this->request->uid)
            return $this->ajaxReturn($this->errorCode, '请登录后重试');

		if($data['type']==1){
		    //增加积分
            IntegerService::plus(6,$member_id);
        }else{
		    //减少积分
            IntegerService::minus($data['integer'],$member_id,$data['integer_dec']?:'');
        }
		return $this->ajaxReturn($this->successCode,'操作成功','');
	}



}

