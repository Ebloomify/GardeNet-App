<?php 
/*
 module:		意见反馈
 create_time:	2021-11-16 01:09:36
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\service\V1\FeedbackService;
use app\api\model\V1\Feedback as FeedbackModel;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class Feedback extends Common {


	/**
	* @api {post} /V1.Feedback/save 01、意见反馈
	* @apiGroup Feedback
	* @apiVersion 1.0.0
	* @apiDescription  创建数据

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}			body 反馈内容 (必填)

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
		$postField = 'body';
		$data = $this->request->only(explode(',',$postField),'post',null);
        if (!$data['member_id'] = $this->request->uid) {
            throw new ValidateException('参数错误');
        }

		$res = FeedbackService::save($data);
		return $this->ajaxReturn($this->successCode,'操作成功',htmlOutList($res));
	}



}

