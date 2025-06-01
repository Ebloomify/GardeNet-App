<?php 
/*
 module:		我的Community
 create_time:	2021-12-19 19:27:53
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\service\V1\MemberCommunityService;
use app\api\model\V1\MemberCommunity as MemberCommunityModel;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class MemberCommunity extends Common {

    /*start*/
	/**
	* @api {get} /V1.MemberCommunity/commentList 02、我评论的Community
	* @apiGroup MemberCommunity
	* @apiVersion 1.0.0
	* @apiDescription  我评论的Community

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
	* {"status":"200","data":""}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"查询失败"}
	*/
	function commentList(){
		$limit  = $this->request->get('limit', 20, 'intval');
		$page   = $this->request->get('page', 1, 'intval');

		$where = [
		    'member_id'=>$this->request->uid,
        ];

		$field = '*';
		$orderby = 'create_time desc';

		$res = MemberCommunityService::commentListList(formatWhere($where),$field,$orderby,$limit,$page);
        $list = $res['list'];
        foreach ($list as $k => $v) {
            $list[$k]['back_sum'] = \app\api\model\V1\CommunityComment::where(['pid' => $list[$k]['community_comment_id']])->count();
            $list[$k]['avatar'] = \app\api\model\V1\Member::where(['member_id' => $list[$k]['member_id']])->value('avatar');
            if ($this->request->uid) {
                $like = \app\api\model\V1\MemberLike::where([
                    'type' => 5,
                    'member_id' => $this->request->uid,
                    'object_id' => $list[$k]['community_comment_id']
                ])->find();
                $like ? $list[$k]['is_like'] = true : $list[$k]['is_like'] = false;
            } else {
                $list[$k]['is_like'] = false;
            }
        }
        $res['list'] = $list;

		return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($res));
	}
	/*end*/

 /*start*/
	/**
	* @api {get} /V1.MemberCommunity/list 01、我发布的Community
	* @apiGroup MemberCommunity
	* @apiVersion 1.0.0
	* @apiDescription  我发布的Community

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
    {
    "list": [
    {
    "community_article_id": 8,
    "title": "111", 标题
    "tags": "12", 标签
    "content": null,
    "pics": 1,
    "community_cate_id": 1,
    "cate_name": "分类1",
    "member_id": 9,
    "like_sum": 0,
    "comment_sum": 0,
    "see_sum": 1,
    "auth_status": 1, 审核状态 1 通过 0未通过 2未审核
    "status": 1,
    "sort": 1,
    "create_time": "15/12/2021 23:08:24",
    "auth_msg": "", 审核未通过消息
    "id": 8,
    "cate_id": 1,
    "is_like": false,
    "is_follow": false
    }
    ],
    "count": 1
     * }
     * }}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"查询失败"}
	*/
	function list(){
		$limit  = $this->request->get('limit', 20, 'intval');
		$page   = $this->request->get('page', 1, 'intval');

		$where = [
		    'member_id'=>$this->request->uid,
        ];

		$field = '*';
		$orderby = 'create_time desc';

		$res = MemberCommunityService::listList(formatWhere($where),$field,$orderby,$limit,$page);
        $list = $res['list'];
        foreach ($list as $k => $v) {
            $list[$k]['id'] = $v['community_article_id'];
            $list[$k]['cate_id'] = $v['community_cate_id'];
            $list[$k]['pics'] = json_decode(json(html_out($list[$k]['pics']))->getData(), true);
            $list[$k]['is_like'] ? $list[$k]['is_like'] = true : $list[$k]['is_like'] = false;
            $list[$k]['is_follow'] ? $list[$k]['is_follow'] = true : $list[$k]['is_follow'] = false;
            $list[$k]['create_time'] = date('d/m/Y H:i:s',$v['create_time']);
//            $list[$k]['content'] = htmlOutList($list[$k]['content']);
        }

        $return['list'] = $list;
        $return['count'] = $res['count'];
		return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($return));
	}
	/*end*/



}

