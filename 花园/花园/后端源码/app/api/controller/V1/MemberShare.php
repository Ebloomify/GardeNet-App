<?php 
/*
 module:		我的分享
 create_time:	2021-11-16 17:26:57
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\model\Config;
use app\api\service\V1\MemberShareService;
use app\api\model\V1\MemberShare as MemberShareModel;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class MemberShare extends Common {

/*start*/
	/**
	* @api {get} /V1.MemberShare/info 01、详情
	* @apiGroup MemberShare
	* @apiVersion 1.0.0
	* @apiDescription  详情

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码 201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.data 返回数据详情
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":""}
	* @apiErrorExample {json} 02 失败示例
	* {"status":"201","msg":"没有数据"}
	*/
	function info(){
		if(!$member_id = $this->request->uid){
		    return $this->ajaxReturn($this->errorCode,'请登录后重试');
        }

		//查询分享文本
        $res['config'] = Config::where('name','share_body')->value('data');
        //查询我的分享数量
        $res['member_share_today_num'] = \app\api\model\V1\MemberShare::where('member_id',$member_id)
            ->whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')")
            ->count();
        $res['member_share_total_num'] = \app\api\model\V1\MemberShare::where('member_id',$member_id)
            ->count();
        $res['invitation_code'] = \app\api\model\V1\Member::where('member_id',$member_id)->value('invitation_code');
		return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($res));
	}
/*end*/


}

