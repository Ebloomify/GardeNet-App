<?php
/*
 module:		QA问题_回答
 create_time:	2021-11-17 00:32:52
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\service\V1\IntegerService;
use app\api\service\V1\QuestionAnswerService;
use app\api\model\V1\QuestionAnswer as QuestionAnswerModel;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class QuestionAnswer extends Common
{

    /*start*/
    /**
     * @api {post} /V1.QuestionAnswer/pitchOn 03、选择答案
     * @apiGroup QuestionAnswer
     * @apiVersion 1.0.0
     * @apiDescription  编辑数据
     * @apiParam (输入参数：) {string}            question_answer_id 主键ID (必填)
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
    function pitchOn()
    {
        $postField = 'question_answer_id,is_accept';
        $data = $this->request->only(explode(',', $postField), 'post', null);
        if (empty($data['question_answer_id'])) {
            throw new ValidateException('参数错误');
        }
        if (!$member_id = $this->request->uid)
            return $this->ajaxReturn($this->errorCode, '请登录后重试');
        db()->startTrans();
        try{
            //查询答案是否存在
            if (!$question_answer = \app\api\model\V1\QuestionAnswer::where('question_answer_id', $data['question_answer_id'])
                ->where('status', 1)->where('auth_status', 1)->find())
                return $this->ajaxReturn($this->errorCode, '当前答案不存在');
            //问题是否存在
            if (!$question = \app\api\model\V1\Question::where('question_id', $question_answer['question_id'])
                ->where('status', 1)->where('auth_status', 1)->find())
                return $this->ajaxReturn($this->errorCode, '当前问题不存在');
            //是否已经选中其他答案
            if (QuestionAnswerModel::where('question_id', $question_answer['question_id'])->where('status', 1)
                    ->where('auth_status', 1)->where('is_accept', 1)->count() > 0)
                return $this->ajaxReturn($this->errorCode, '已选中其他答案');

            $data['is_accept'] = 1;
            $where['question_answer_id'] = $data['question_answer_id'];
            $res = QuestionAnswerService::pitchOn($where, $data);
            //增加用户积分
            IntegerService::plus(0, $question_answer['member_id'],$question['integer_sum']);
            $question->resolved_status = 2;
            $question->save();
            db()->commit();
            return $this->ajaxReturn($this->successCode, '操作成功');
        }catch(\Exception $e){
            db()->rollback();
            return $this->ajaxReturn($this->errorCode, '系统错误');
        }

    }
    /*end*/

    /*start*/
    /**
     * @api {post} /V1.QuestionAnswer/save 02、回答问题
     * @apiGroup QuestionAnswer
     * @apiVersion 1.0.0
     * @apiDescription  创建数据
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (输入参数：) {int}                question_id 问题id (必填)
     * @apiParam (输入参数：) {string}            content 回答内容 (必填)
     * @apiParam (输入参数：) {string}            pid 回复评论ID question_answer_id (可选)
     *
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码  201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.msg 返回成功消息
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","data":"操作成功"}
     * @apiErrorExample {json} 02 失败示例
     * {"status":" 201","msg":"操作失败"}
     */
    function save()
    {
        $commentStatus = \db('config')->where(['name' => 'qa_comment_status'])->value('data');
        if ($commentStatus == 0) {
            return $this->ajaxReturn($this->errorCode, '评论已被关闭');
        }
        if (!$question_id = $this->request->param('question_id'))
            return $this->ajaxReturn($this->errorCode, '参数丢失');
        if (!$content = $this->request->param('content'))
            return $this->ajaxReturn($this->errorCode, '参数丢失');
        if (!$member_id = $this->request->uid)
            return $this->ajaxReturn($this->errorCode, '请登录后重试');
        if (!$question = \app\api\model\V1\Question::where('question_id', $question_id)->find())
            return $this->ajaxReturn($this->errorCode, '问题不存在');
        $pid = $this->request->param('pid');
        $member = \app\api\model\V1\Member::where('member_id', $member_id)->find();
        $qa_comment_auth_status = \db('config')->where(['name' => 'qa_comment_auth_status'])->value('data') == 1 ? 2 : 1;
        db()->startTrans();
        try{
            $res = \app\api\model\V1\QuestionAnswer::create([
                'member_id' => $member_id,
                'avatar' => $member['avatar'],
                'nickname' => $member['nickname'],
                'like_sum' => 0,
                'is_accept' => 0,
                'create_time' => time(),
                'auth_status' => $qa_comment_auth_status,
                'status' => 1,
                'auth_msg' => '',
                'question_id' => $question_id,
                'pid' => $pid?$pid:0,
                'is_read' => 0,
                'content' => $content,
                'to_member_id'=>$question['member_id']
            ]);

            \app\api\model\V1\Question::where('question_id',$question_id)->inc('answer_sum')->update();
            db()->commit();
            return $this->ajaxReturn($this->successCode, '操作成功', htmlOutList($res));

        }catch(\Exception $e){
            db()->rollback();
            return $this->ajaxReturn($this->errorCode, '系统错误');
        }
    }
    /*end*/

    /*start*/
    /**
     * @api {get} /V1.QuestionAnswer/myList 01、QA问题_我的回答
     * @apiGroup QuestionAnswer
     * @apiVersion 1.0.0
     * @apiDescription  QA问题_我的回答
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
    function myList()
    {
        $limit = $this->request->get('limit', 20, 'intval');
        $page = $this->request->get('page', 1, 'intval');

        $memberId = $this->request->uid;
        $where = [
            'a.member_id' => $memberId,
        ];

        $field = 'a.question_id,a.content a_content,a.create_time,a.is_accept';
        $field2 = 'q.content q_content,q.integer_sum,q.resolved_status';
        $orderby = 'a.question_answer_id desc';

        $result = QuestionAnswerModel::alias('a')->join('question q', 'a.question_id = q.question_id')
            ->where($where)
            ->field($field)
            ->field($field2)
            ->order($orderby)
            ->paginate(['list_rows' => $limit, 'page' => $page])->toArray();

        foreach ($result['data'] as $k => $v){
            $result['data'][$k]['id'] = $v['question_id'];
            $result['data'][$k]['content'] = html_out($v['content']);
        }
        $return = ['list' => $result['data'], 'count' => $result['total']];
        return $this->ajaxReturn($this->successCode, '返回成功', htmlOutList($return));
    }
    /*end*/

    /*start*/
    /**
     * @api {get} /V1.QuestionAnswer/list 04、QA回答列表
     * @apiGroup QuestionAnswer
     * @apiVersion 1.0.0
     * @apiDescription  QA回答列表
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (输入参数：) {int}            [limit] 每页数据条数（默认20）
     * @apiParam (输入参数：) {int}            [page] 当前页码
     * @apiParam (输入参数：) {int}                question_id 问题id (必填)
     * @apiParam (输入参数：) {int}                pid 父级id (可选)
     *
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
    "question_answer_id": 2,
    "member_id": 9,
    "avatar": "/uploads/admin/202101/5ff40b8d7fbd2.jpg",
    "nickname": "幸福的麦片",
    "like_sum": 0,
    "is_accept": 0, 是否选为答案 1是 0否
    "create_time": 1640189517,
    "auth_status": 1, 审核状态 1通过 2未审核 0未通过
    "status": 1,
    "auth_msg": "", 审核未通过信息
    "question_id": 1,
    "pid": 1,
    "is_read": 0, 是否已读 1是 0否
    "content": "2222222231sasdasdasd",
    "to_member_id": 3,
    "user_id": 9,
    "id": 1, question id
    "reply_num": 0, 回复数量
    "is_like": true 是否点赞
    }
    ],
    "count": 1
     * }}
     * @apiErrorExample {json} 02 失败示例
     * {"status":" 201","msg":"查询失败"}
     */
    function list()
    {
        $limit = $this->request->get('limit', 20, 'intval');
        $page = $this->request->get('page', 1, 'intval');
        $postField = 'question_id,pid';
        $data = $this->request->only(explode(',', $postField), 'get', null);
        if (empty($data['question_id'])) {
            throw new ValidateException('参数错误');
        }
        $memberId = $this->request->uid;

        $where = [
            'a.question_id' => $data['question_id'],
            'a.status'=>1,
            'a.auth_status'=>1,
            'pid'=>$data['pid']?$data['pid']:0
        ];

        $field = 'a.*';
        $field2 = 'm.nickname,m.avatar,m.member_id as user_id';
        $orderby = 'a.question_answer_id desc';

        $result = QuestionAnswerModel::alias('a')->join('member m', 'a.member_id = m.member_id')
            ->where($where)
            ->field($field)
            ->field($field2)
            ->order($orderby)
            ->paginate(['list_rows' => $limit, 'page' => $page])->toArray();

        foreach ($result['data'] as $k => $v){
            $result['data'][$k]['id'] = $v['question_id'];
            $result['data'][$k]['content'] = html_out($v['content']);
            $result['data'][$k]['reply_num'] = QuestionAnswerModel::where('question_id',$data['question_id'])
                ->where('status',1)->where('auth_status',1)->where('pid',$v['question_answer_id'])
                ->count();
            //是否点赞
            $like = \app\api\model\V1\MemberLike::where([
                'member_id' => $this->request->uid,
                'type'      =>  6,
                'object_id' => $v['question_answer_id'],
            ])->find();
            $like ?  $result['data'][$k]['is_like'] = true :  $result['data'][$k]['is_like'] = false;
        }
        $return = ['list' => $result['data'], 'count' => $result['total']];
        return $this->ajaxReturn($this->successCode, '返回成功', htmlOutList($return));
    }
    /*end*/


}

