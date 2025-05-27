<?php 
/*
 module:		会员点赞
 create_time:	2021-07-12 12:04:02
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\service\V1\IntegerService;
use app\api\service\V1\MemberLikeService;
use app\api\model\V1\MemberLike as MemberLikeModel;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class MemberLike extends Common {


	/**
	* @api {get} /V1.MemberLike/index 01、首页数据列表
	* @apiGroup MemberLike
	* @apiVersion 1.0.0
	* @apiDescription  首页数据列表
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
	* {"status":"200","data":""}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"查询失败"}
	*/
	function index(){
		$limit  = $this->request->get('limit', 20, 'intval');
		$page   = $this->request->get('page', 1, 'intval');

		$where = [];

		$field = '*';
		$orderby = 'member_like_id desc';

		$res = MemberLikeService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
		return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($res));
	}

	/*start*/
	/**
	* @api {post} /V1.MemberLike/addAndRemove 02、添加or取消点赞
	* @apiGroup MemberLike
	* @apiVersion 1.0.0
	* @apiDescription  添加

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {int}				type 类型 discover|1,community|2,qa|3,discover评论|4,community评论|5,qa评论|6
	* @apiParam (输入参数：) {int}				object_id 对象id 

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
	function addAndRemove(){
        $postField = 'type,object_id';
        $data = $this->request->only(explode(',',$postField),'post',null);
        //点赞后 需要在对象的like_sum +1
        //取消点赞后 需要在对象啊的like_sum -1

        //对象集合
        $object = [
            1   => (new  \app\api\model\V1\DiscoverArticle()),
            2   => (new  \app\api\model\V1\CommunityArticle()),
            3   => (new  \app\api\model\V1\Question()),
            4   => (new  \app\api\model\V1\DiscoverComment()),
            5   => (new  \app\api\model\V1\CommunityComment()),
            6   => (new  \app\api\model\V1\QuestionAnswer()),
        ];
        if (isset($object[$data['type']])){
            $model = $object[$data['type']];
            $isExists = $model->find($data['object_id']);
            if (!$isExists)   return $this->ajaxReturn($this->errorCode,'点赞对象不存在');
            $like = \app\api\model\V1\MemberLike::where([
                'member_id' => $this->request->uid,
                'type'      => $data['type'],
                'object_id' => $data['object_id'],
            ])->find();
            if ($like){ //取消点赞
                $like->delete();
                $likeSum = $isExists['like_sum'] - 1;
                $isExists->save(['like_sum'=>$likeSum]);
                $msg = '取消点赞成功';
            }else{    //点赞
                \app\api\model\V1\MemberLike::insert([
                    'member_id' => $this->request->uid,
                    'type'      => $data['type'],
                    'object_id' => $data['object_id'],
                    'create_time' => time(),
                ]);
                $likeSum = $isExists['like_sum'] + 1;
                $isExists->save(['like_sum'=>$likeSum]);
                $msg = '点赞成功';
                //添加积分
                if($data['type']==1 ||$data['type']==2){
                    IntegerService::plus(3,$this->request->uid);
                }
            }
        }else{
            return $this->ajaxReturn($this->errorCode,'参数错误');
        }
        return $this->ajaxReturn($this->successCode,$msg);
	}
    /*end*/



}

