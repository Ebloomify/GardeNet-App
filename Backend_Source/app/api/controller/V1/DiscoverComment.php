<?php 
/*
 module:		Discover评论
 create_time:	2021-07-12 14:10:17
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\service\V1\DiscoverCommentService;
use app\api\model\V1\DiscoverComment as DiscoverCommentModel;
use app\api\controller\Common;
use app\api\service\V1\IntegerService;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class DiscoverComment extends Common {


 /*start*/
    /**
     * @api {get} /V1.DiscoverComment/index 01、Discover评论列表
     * @apiGroup DiscoverComment
     * @apiVersion 1.0.0
     * @apiDescription  Discover评论列表

     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

     * @apiParam (输入参数：) {int}     		[discover_article_id] 文章id
     * @apiParam (输入参数：) {int}     		[pid] 父级评论id 查看二级回复传入
     * @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
     * @apiParam (输入参数：) {int}     		[page] 当前页码


     * @apiSuccessExample {json} 01 成功示例
     *  {
    "discover_comment_id": 6, 评论id
    "member_id": 3,  用户id
    "discover_article_id": 1,
    "avatar": "/uploads/admin/202101/5ff40b8d7fbd2.jpg", 头像
    "nickname": "无限的画笔", 昵称
    "to_member_id": 0,  回复对象id
    "content": "评论一下",
    "to_nickname": "",   回复对象昵称
    "create_time": 1626062513,
    "like_sum": 1,      点赞数量
    "back_sum": 0,      回复数量

    "is_like": true
    },
     * @apiErrorExample {json} 02 失败示例
     * {"status":" 201","msg":"查询失败"}
     */
    function index(){
        $limit  = $this->request->get('limit', 20, 'intval');
        $page   = $this->request->get('page', 1, 'intval');
        $pid =  $this->request->get('pid',0);

        $where = [
            'auth_status' => 1,
            'status' => 1,
            'pid' => $pid,
        ];
        $where['discover_article_id'] = $this->request->get('discover_article_id', '', 'serach_in');


        $field = 'discover_comment_id,member_id,discover_article_id,nickname,to_member_id,content,to_nickname,create_time,like_sum';
        $orderby = 'discover_comment_id desc';

        $res = DiscoverCommentService::indexList(formatWhere($where),$field,$orderby,$limit,$page);

        $list = $res['list'];
        foreach ($list as $k => $v){
            $list[$k]['back_sum'] = \app\api\model\V1\DiscoverComment::where(['pid'=>$list[$k]['discover_comment_id']])->count();
            $list[$k]['avatar'] = \app\api\model\V1\Member::where(['member_id'=>$list[$k]['member_id']])->value('avatar');
            if ($this->request->uid){
                $like = \app\api\model\V1\MemberLike::where([
                    'type'=>4,
                    'member_id'=>$this->request->uid,
                    'object_id'=>$list[$k]['discover_comment_id']
                ])->find();
                $like ? $list[$k]['is_like'] = true : $list[$k]['is_like'] = false;
            }else{
                $list[$k]['is_like'] = false;
            }
        }
        $res['list'] = $list;

        return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($res));
    }
    /*end*/

	/*start*/
	/**
	* @api {post} /V1.DiscoverComment/add 02、Discover评论
	* @apiGroup DiscoverComment
	* @apiVersion 1.0.0
	* @apiDescription  添加

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {int}				discover_article_id 文章id 
	* @apiParam (输入参数：) {string}			content 评论内容
	* @apiParam (输入参数：) {int}				pid 父级id 可空

	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function add(){
        $commentStatus = \db('config')->where(['name'=>'discover_comment_status'])->value('data');
        if ($commentStatus == 0) {
            return $this->ajaxReturn($this->errorCode,'评论已被关闭');
        }

        $postField = 'discover_article_id,content,pid';
		$data = $this->request->only(explode(',',$postField),'post',null);

        $article = (new \app\api\model\V1\DiscoverArticle())->find($data['discover_article_id']);
        if (!$article)	return $this->ajaxReturn($this->errorCode,'该文章不存在');

        $member = (new \app\api\model\V1\Member())->find($this->request->uid);

        if ($data['pid']){
            $pInfo = DiscoverCommentModel::find($data['pid']);
            if (!$pInfo) return $this->ajaxReturn($this->errorCode,'回复对象不存在');

            $toMemberId = $pInfo['member_id'];
            $toNickname = $pInfo['nickname'];
            $pid = $data['pid'];
        }else{
            $toMemberId = 0;
            $toNickname = '';
            $pid = 0;
        }

        $authStatus = \db('config')->where(['name'=>'discover_comment_auth_status'])->value('data');



        $defaultData = [
		    'member_id' => $this->request->uid,
            'discover_article_id' => $data['discover_article_id'],
            'discover_article_title' => $article['title'],
            'nickname'  => $member['nickname'],
            'to_member_id' => $toMemberId,
            'content' => $data['content'],
            'to_nickname' => $toNickname,
            'create_time' => time(),
            'auth_status' => $authStatus == 1 ? 2 : 1,
            'status' => 1,
            'pid' => $pid,
            'is_read' => 0,
        ];
		$res = DiscoverCommentService::add($defaultData);

        $commentCount = DiscoverCommentModel::where(['discover_article_id'=>$data['discover_article_id'],'auth_status'=>1])->count();

        //更新文章下评论数量
        \app\api\model\V1\DiscoverArticle::where(['discover_article_id'=>$data['discover_article_id']])->update([
            'comment_sum' => $commentCount
        ]);
        IntegerService::plus(2,$this->request->uid);
		return $this->ajaxReturn($this->successCode,'操作成功',htmlOutList($res));
	}
    /*end*/



}

