<?php
/*
 module:		Community评论
 create_time:	2021-07-12 14:21:14
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\service\V1\CommunityCommentService;
use app\api\model\V1\CommunityComment as CommunityCommentModel;
use app\api\controller\Common;
use app\api\service\V1\IntegerService;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class CommunityComment extends Common
{


    /*start*/
    /**
     * @api {get} /V1.CommunityComment/index 01、Community评论列表
     * @apiGroup CommunityComment
     * @apiVersion 1.0.0
     * @apiDescription  Community评论列表
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (输入参数：) {int}            [community_article_id] 文章id
     * @apiParam (输入参数：) {int}            [pid] 父级评论id 查看二级回复传入
     * @apiParam (输入参数：) {int}            [limit] 每页数据条数（默认20）
     * @apiParam (输入参数：) {int}            [page] 当前页码
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码 201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.data 返回数据
     * @apiParam (成功返回参数：) {string}        array.data.list 返回数据列表
     * @apiParam (成功返回参数：) {string}        array.data.count 返回数据总数
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","data":""}
     * @apiErrorExample {json} 02 失败示例
     * {"status":" 201","msg":"查询失败"}
     */
    function index()
    {
        $limit = $this->request->get('limit', 20, 'intval');
        $page = $this->request->get('page', 1, 'intval');
        $pid = $this->request->get('pid', 0);

        $where = [
            'auth_status' => 1,
            'status' => 1,
            'pid' => $pid,
        ];

        $where['community_article_id'] = $this->request->get('community_article_id', '', 'serach_in');


        $field = 'community_comment_id,member_id,community_article_id,nickname,to_member_id,content,to_nickname,create_time,like_sum';
        $orderby = 'community_comment_id desc';

        $res = CommunityCommentService::indexList(formatWhere($where), $field, $orderby, $limit, $page);


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

        return $this->ajaxReturn($this->successCode, '返回成功', htmlOutList($res));
    }
    /*end*/

    /*start*/
    /**
     * @api {post} /V1.CommunityComment/add 02、Community评论
     * @apiGroup CommunityComment
     * @apiVersion 1.0.0
     * @apiDescription  添加
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (输入参数：) {int}                community_article_id 文章id
     * @apiParam (输入参数：) {string}            content 评论内容
     * @apiParam (输入参数：) {int}                pid 父级id
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","data":"操作成功"}
     * @apiErrorExample {json} 02 失败示例
     * {"status":" 201","msg":"操作失败"}
     */
    function add()
    {

        $commentStatus = \db('config')->where(['name' => 'community_comment_status'])->value('data');
        if ($commentStatus == 0) {
            return $this->ajaxReturn($this->errorCode, '评论已被关闭');
        }

        $postField = 'community_article_id,content,pid';
        $data = $this->request->only(explode(',', $postField), 'post', null);

        $article = (new \app\api\model\V1\CommunityArticle())->find($data['community_article_id']);
        if (!$article) return $this->ajaxReturn($this->errorCode, '该文章不存在');

        $member = (new \app\api\model\V1\Member())->find($this->request->uid);

        if ($data['pid']) {
            $pInfo = CommunityCommentModel::find($data['pid']);
            if (!$pInfo) return $this->ajaxReturn($this->errorCode, '回复对象不存在');

            $toMemberId = $pInfo['member_id'];
            $toNickname = $pInfo['nickname'];
            $pid = $data['pid'];
        } else {
            $member_ = \app\api\model\V1\CommunityArticle::where('community_article_id', $data['community_article_id'])->find();
            $toMemberId = $member_['member_id'];
            $toNickname = $member_['nickname'];
            $pid = 0;
        }

        $authStatus = \db('config')->where(['name' => 'community_comment_auth_status'])->value('data');


        $defaultData = [
            'member_id' => $this->request->uid,
            'community_article_id' => $data['community_article_id'],
            'community_article_title' => $article['title'],
            'nickname' => $member['nickname'],
            'to_member_id' => $toMemberId,
            'content' => $data['content'],
            'to_nickname' => $toNickname,
            'create_time' => time(),
            'auth_status' => $authStatus == 1 ? 2 : 1,
            'status' => 1,
            'pid' => $pid,
            'is_read' => 0,
        ];
        $res = CommunityCommentService::add($defaultData);

        $commentCount = CommunityCommentModel::where(['community_article_id' => $data['community_article_id'], 'auth_status' => 1])->count();

        //更新文章下评论数量
        \app\api\model\V1\CommunityArticle::where(['community_article_id' => $data['community_article_id']])->update([
            'comment_sum' => $commentCount
        ]);
//        //添加消息
//        \app\api\model\V1\Notification::create([
//            'member_id' => $data['pid']?$toMemberId:
//                \app\api\model\V1\CommunityArticle::where('community_article_id', $data['community_article_id'])->value('member_id'),
//            'title' => $article['title'],
//            'is_read' => 0,
//            'comment_body' => $data['content'],
//            'type' => 1,
//            'article_id' => $data['community_article_id'],
//            'comment_id' => $res,
//            'comment_member_id' => $this->request->uid,
//            'create_time' => time(),
//        ]);
//
//
        IntegerService::plus(2, $this->request->uid);
        return $this->ajaxReturn($this->successCode, '操作成功', htmlOutList($res));
    }
    /*end*/


}

