<?php
/*
 module:		消息
 create_time:	2021-11-17 01:38:26
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\model\V1\Broadcast;
use app\api\model\V1\BroadcastMember;
use app\api\service\V1\NotificationService;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class Notification extends Common
{

    /*start*/
    /**
     * @api {get} /V1.Notification/read 03、读消息
     * @apiGroup Notification
     * @apiVersion 1.0.0
     * @apiDescription  编辑数据
     * @apiParam (输入参数：) {string}            id 主键ID (必填)
     * @apiParam (输入参数：) {string}            type 文章类型 (必填 1 community 2 qa 3系统)
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码  201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.msg 返回成功消息
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","msg":"操作成功"}
     * @apiErrorExample {json} 02 失败示例
     * {"status":" 201","msg":"操作失败"}
     */
    function read()
    {
        $postField = 'id,type';
        $data = $this->request->only(explode(',', $postField), 'get', null);
        if (!array_key_exists('type', $data))
            return $this->ajaxReturn($this->errorCode, '参数丢失');
        if (!array_key_exists('id', $data))
            return $this->ajaxReturn($this->errorCode, '参数丢失');
        if (!$member_id = $this->request->uid)
            return $this->ajaxReturn($this->errorCode, '请登录后重试');
        //type=1 community
        if ($data['type'] == 1) {
            \app\api\model\V1\CommunityComment::where('community_comment_id', $data['id'])
                ->where('member_id', $member_id)->update(['is_read' => 1]);

        }
        if ($data['type'] == 2) {
            \app\api\model\V1\QuestionAnswer::where('question_answer_id', $data['id'])
                ->where('member_id', $member_id)->update(['is_read' => 1]);
        }
        if ($data['type'] == 3) {
            if (!$bro = Broadcast::where('broadcast_id', $data['id'])->find()) {
                return $this->ajaxReturn($this->errorCode, '消息不存在');
            }

            if (!$bro_member = BroadcastMember::where('member_id', $member_id)->where('broadcast_id', $data['id'])->find()) {
                BroadcastMember::create([
                    'member_id' => $member_id,
                    'broadcast_id' => $bro['broadcast_id'],
                    'is_read' => 1,
                    'read_time' => time()
                ]);
            }
        }

        return $this->ajaxReturn($this->successCode, '操作成功');
    }
    /*end*/

    /*start*/
    /**
     * @api {get} /V1.Notification/articleNotification 02、文章消息
     * @apiGroup Notification
     * @apiVersion 1.0.0
     * @apiDescription  文章消息
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (输入参数：) {int}            [limit] 每页数据条数（默认10,会×2）
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
     * {"status":"200","data":{
            "list": [
            {
            "id": "3", 文章ID
            "member_id": "9",用户ID
            "article_id": "2",
            "pid": "2",
            "title": "2222222231sasdasdasd", 右侧标题 回复文章的是文章的标题 回复评论的是被回复的评论消息
            "create_time": "1640189578",
            "content": "2222222231sasdasdasd", 评论内容
            "nickname": "幸福的麦片",
            "avatar": "/uploads/admin/202101/5ff40b8d7fbd2.jpg",
            "is_read": "0",
            "type": "2" 1 community 2 qa
            },
            {
            "id": "2",
            "member_id": "9",
            "article_id": "1",
            "pid": "1",
            "title": "qweqweqweqweqwe",
            "create_time": "1640189517",
            "content": "2222222231sasdasdasd",
            "nickname": "幸福的麦片",
            "avatar": "/uploads/admin/202101/5ff40b8d7fbd2.jpg",
            "is_read": "0",
            "type": "2"
            },
            {
            "id": "8",
            "member_id": "9",
            "article_id": "7",
            "pid": "6",
            "title": "1111",
            "create_time": "1637071918",
            "content": "333",
            "nickname": "幸福的麦片",
            "avatar": "/uploads/admin/202101/5ff40b8d7fbd2.jpg",
            "is_read": "0",
            "type": "1"
            },
            {
            "id": "7",
            "member_id": "9",
            "article_id": "7",
            "pid": "6",
            "title": "1111",
            "create_time": "1637071878",
            "content": "222",
            "nickname": "幸福的麦片",
            "avatar": "/uploads/admin/202101/5ff40b8d7fbd2.jpg",
            "is_read": "0",
            "type": "1"
            },
            {
            "id": "6",
            "member_id": "9",
            "article_id": "7",
            "pid": "5",
            "title": "测试1",
            "create_time": "1637071729",
            "content": "1111",
            "nickname": "幸福的麦片",
            "avatar": "/uploads/admin/202101/5ff40b8d7fbd2.jpg",
            "is_read": "0",
            "type": "1"
            }
            ],
            "count": 5
     * }}
     * @apiErrorExample {json} 02 失败示例
     * {"status":" 201","msg":"查询失败"}
     */
    function articleNotification()
    {
        $limit = $this->request->get('limit', 10, 'intval');
        $page = $this->request->get('page', 1, 'intval');
        if (!$member_id = $this->request->uid)
            return $this->ajaxReturn($this->errorCode, '请登录后重试');
        $community_comment_member_ = \app\api\model\V1\CommunityComment::where('member_id', $member_id)
            ->where('auth_status', 1)->where('status', 1)->field('community_comment_id,content')
            ->select()->toArray();
        $community_comment_member = implode(',', array_column($community_comment_member_, 'community_comment_id'));
        $community_comment = \app\api\model\V1\CommunityComment::alias('c')->join('member m', 'm.member_id=c.member_id');
        if (!empty($community_comment_member)) {
            $community_comment = $community_comment->whereRaw("(to_member_id = $member_id or pid in ($community_comment_member)) and c.auth_status=1 and c.status=1 and is_read=0");
        } else {
            $community_comment = $community_comment->whereRaw("c.auth_status=1 and c.status=1 and is_read=0");
        }
        $community_comment = $community_comment->join('community_article q', 'q.community_article_id=c.community_article_id')
            ->field('community_comment_id as id,c.member_id,c.community_article_id as article_id,c.pid,q.title,c.create_time,c.content,m.nickname,m.avatar,c.is_read,1 as type')
            ->order('is_read', 'asc')->order('create_time', 'asc')
            ->paginate(['list_rows' => $limit, 'page' => $page])->toArray();
        foreach ($community_comment['data'] as $kk => $vv) {
            foreach ($community_comment_member_ as $v) {
                if ($vv['pid'] == $v['community_comment_id']) {
                    $community_comment['data'][$kk]['title'] = $v['content'];
                }
            }
        }

        $qa_comment_member_ = \app\api\model\V1\QuestionAnswer::where('member_id', $member_id)
            ->where('auth_status', 1)->where('status', 1)->field('question_answer_id,content')
            ->select()->toArray();
        $qa_comment_member = implode(',', array_column($qa_comment_member_, 'community_comment_id'));

        $qa_comment = \app\api\model\V1\QuestionAnswer::alias('c')->join('member m', 'm.member_id=c.member_id');
        if (!empty($qa_comment_member)) {
            $qa_comment = $qa_comment->whereRaw("(to_member_id = $member_id or pid in ($qa_comment_member)) and c.auth_status=1 and c.status=1 and is_read=0");
        } else {
            $qa_comment = $qa_comment->whereRaw("c.auth_status=1 and c.status=1 and is_read=0");
        }
        $qa_comment=$qa_comment->join('question q', 'q.question_id=c.question_id')
            ->field('question_answer_id as id,c.member_id,c.question_id as article_id,c.pid,q.title,c.create_time,c.content,m.nickname,m.avatar,c.is_read,2 as type')
            ->order('is_read', 'asc')->order('create_time', 'asc')
            ->paginate(['list_rows' => $limit, 'page' => $page])->toArray();

        foreach ($qa_comment['data'] as $kk => $vv) {
            foreach ($qa_comment_member_ as $v) {
                if ($vv['pid'] == $v['question_answer_id']) {
                    $qa_comment['data'][$kk]['title'] = $v['content'];
                }
            }
        }

        //头像 昵称时间 文章标题 消息维度 评论内容 回复评论按钮
        //合并数据
        $res = array_merge($community_comment['data'], $qa_comment['data']);
        //重新排序
        array_multisort(array_column($res, 'create_time'), SORT_DESC, $res);

        $res = [
            'list' => $res,
            'count' => $qa_comment['total'] + $community_comment['total']
        ];

        return $this->ajaxReturn($this->successCode, '返回成功', htmlOutList($res));
    }
    /*end*/

    /*start*/
    /**
     * @api {get} /V1.Notification/systemNotification 01、系统消息
     * @apiGroup Notification
     * @apiVersion 1.0.0
     * @apiDescription  系统消息
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
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
    function systemNotification()
    {
        $limit = $this->request->get('limit', 20, 'intval');
        $page = $this->request->get('page', 1, 'intval');

        if (!$member_id = $this->request->uid)
            return $this->ajaxReturn($this->errorCode, '请登录后重试');
        $broadcast_member = BroadcastMember::where('member_id', $member_id)->column('broadcast_id');
        $broadcast_member_str = implode(',', $broadcast_member);
        $broadcast_member_str = $broadcast_member_str ? $broadcast_member_str : 0;

        $res = Broadcast::whereRaw(Db::raw("FIND_IN_SET('{$member_id}',to_member_id)"))->whereOr('to_member_id', 0)
            ->order('create_time', 'desc')->orderRaw("field(broadcast_id,$broadcast_member_str) asc")
            ->paginate(['list_rows' => $limit, 'page' => $page])->toArray();
        foreach ($res['data'] as $k => $v) {
            $res['data'][$k]['is_read'] = 0;
            foreach ($broadcast_member as $vv) {
                if ($vv == $v['broadcast_id']) {
                    $res['data'][$k]['is_read'] = 1;
                }
            }
        }
        $data = ['list' => $res['data'], 'count' => $res['total']];
        return $this->ajaxReturn($this->successCode, '返回成功', htmlOutList($data));
    }
    /*end*/


}

