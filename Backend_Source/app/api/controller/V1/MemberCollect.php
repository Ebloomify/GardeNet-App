<?php
/*
 module:		会员收藏
 create_time:	2021-11-14 04:38:54
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\model\V1\CommunityArticle as CommunityArticleModel;
use app\api\model\V1\Question as QuestionModel;
use app\api\service\V1\DiscoverArticleService;
use app\api\service\V1\MemberCollectService;
use app\api\model\V1\MemberCollect as MemberCollectModel;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class MemberCollect extends Common
{

    /*start*/
    /**
     * @api {get} /V1.MemberCollect/index 01、我的收藏
     * @apiGroup MemberCollect
     * @apiVersion 1.0.0
     * @apiDescription  Discover列表
     * @apiParam (输入参数：) {int}            [limit] 每页数据条数（默认20）
     * @apiParam (输入参数：) {int}            [page] 当前页码
     * @apiParam (输入参数：) {string}        [discover_cate_id] 所属分类
     * @apiParam (输入参数：) {string}        [type] 类型 (1 discover 2 community 3qa)
     * @apiParam (输入参数：) {string}        [sort] QA排序
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
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
        $type = $this->request->get('type', '');

        $where = [
            'status' => 1,
        ];
        $memberId = $this->request->uid;
        $res = \app\api\model\V1\MemberCollect::where('type', $type)->where('member_id', $memberId)
            ->field('object_id')
            ->order('create_time desc')
            ->paginate(['list_rows' => $limit, 'page' => $page])
            ->toArray();
        $res['data'] = array_column($res['data'], 'object_id');

        if ($type == 1) {
            $field = 'discover_article_id as id,title,discover_cate_id,pic,content,see_sum,create_time';
            $data = \app\api\model\V1\DiscoverArticle::where('discover_article_id', 'in', $res['data'])
                ->where($where)->field($field)->select()->toArray();
            foreach ($res as $k => $v) {
                $res[$k]['pic'] = json_decode(json(html_out($res[$k]['pic']))->getData(), true);
            }
            $data = [
                "total" => $res['total'],
                "per_page" => $res['per_page'],
                "current_page" => $res['current_page'],
                "last_page" => $res['last_page'],
                "list" => $data
            ];
            return $this->ajaxReturn($this->successCode, '返回成功', htmlOutList($data));
        } else if ($type == 2) {
            $field = 'c.community_article_id as id,c.title,c.tags,c.content,c.pics,c.member_id,c.like_sum,c.comment_sum,c.see_sum,c.create_time';
            $data = CommunityArticleModel::alias('c')->join('member m', 'c.member_id = m.member_id')
                ->leftJoin('member_like l', 'l.type = 2 and l.object_id = c.community_article_id and l.member_id = ' . $memberId)
                ->leftJoin('member_follow f', 'f.member_id = ' . $memberId . ' and f.follow_member_id = c.member_id')
                ->field($field)
                ->field('m.avatar,m.nickname,m.member_level')
                ->field('l.member_like_id is_like')
                ->field('f.member_follow_id is_follow')
                ->where('c.status', 1)
                ->where('c.community_article_id', 'in', $res['data'])
                ->select()->toArray();
            $list = $data;
            foreach ($list as $k => $v) {
                $list[$k]['pics'] = json_decode(json(html_out($list[$k]['pics']))->getData(), true);
                $list[$k]['is_like'] ? $list[$k]['is_like'] = true : $list[$k]['is_like'] = false;
                $list[$k]['is_follow'] ? $list[$k]['is_follow'] = true : $list[$k]['is_follow'] = false;
            }
            $data = [
                "total" => $res['total'],
                "per_page" => $res['per_page'],
                "current_page" => $res['current_page'],
                "last_page" => $res['last_page'],
                "list" => $data
            ];
            return $this->ajaxReturn($this->successCode, '返回成功', htmlOutList($data));

        } else {
            $sort = $this->request->get('sort', '0');

            $where = [
                'c.status' => 1,
                'c.auth_status' => 1,
            ];
            $where['c.question_cate_id'] = $this->request->get('question_cate_id', '', 'serach_in');

            if ($this->request->uid) {
                $memberId = $this->request->uid;
            } else {
                $memberId = 0;
            }

            if ($sort == 0 || $sort == 1) {
                //最新
                $orderby = 'c.create_time desc';
            } elseif ($sort == 2) {
                //高分
                $orderby = 'c.integer_sum desc';
            } else {
                //已解决
                $orderby = 'c.resolved_status desc';
            }


            $field = 'c.resolved_status,c.question_id as id,c.title,c.question_cate_id,c.cate_name,c.content,c.pics,c.integer_sum,c.like_sum,c.answer_sum,c.see_sum,c.create_time';

            $data = QuestionModel::alias('c')->join('member m', 'c.member_id = m.member_id')
                ->leftJoin('member_like l', 'l.type = 3 and l.object_id = c.question_id and l.member_id = ' . $memberId)
                ->leftJoin('member_follow f', 'f.member_id = ' . $memberId . ' and f.follow_member_id = c.member_id')
                ->join('cd_member_collect mc',"mc.type = 3 and mc.member_id={$memberId} and mc.object_id = c.question_id")
                ->field($field)
                ->field('m.avatar,m.nickname,m.member_level')
                ->field('l.member_like_id is_like')
                ->field('f.member_follow_id is_follow')
                ->where(formatWhere($where))
                ->order($orderby)
                ->paginate(['list_rows' => $limit, 'page' => $page])->toArray();
            $list = $data['data'];
            foreach ($list as $k => $v) {
                $list[$k]['pics'] = json_decode(json(html_out($list[$k]['pics']))->getData(), true);
                $list[$k]['is_like'] ? $list[$k]['is_like'] = true : $list[$k]['is_like'] = false;
                $list[$k]['is_follow'] ? $list[$k]['is_follow'] = true : $list[$k]['is_follow'] = false;
            }

            $data = [
                "total" => $res['total'],
                "per_page" => $res['per_page'],
                "current_page" => $res['current_page'],
                "last_page" => $res['last_page'],
                "list" => $list
            ];
            return $this->ajaxReturn($this->successCode, '返回成功', htmlOutList($data));
        }

    }
    /*end*/

    /*start*/
    /**
     * @api {post} /V1.MemberCollect/addAndRemove 02、添加or取消收藏
     * @apiGroup MemberCollect
     * @apiVersion 1.0.0
     * @apiDescription  添加
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (输入参数：) {int}                type 类型 discover|1,community|2,qa|3
     * @apiParam (输入参数：) {int}                object_id 对象id
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","data":"操作成功"}
     * @apiErrorExample {json} 02 失败示例
     * {"status":" 201","msg":"操作失败"}
     */
    function addAndRemove()
    {
        $postField = 'type,object_id';
        $data = $this->request->only(explode(',', $postField), 'post', null);

        if (!isset($data['type'])) return $this->ajaxReturn($this->errorCode, '缺少参数');
        if (!isset($data['object_id'])) return $this->ajaxReturn($this->errorCode, '缺少参数');

        $where = [
            'member_id' => $this->request->uid,
            'type' => $data['type'],
            'object_id' => $data['object_id'],
        ];
        //查找是否存在
        $isExists = MemberCollectModel::where($where)->find();
        if ($isExists) {
            MemberCollectModel::where($where)->delete();
            $msg = '取消收藏成功';
        } else {
            $insert = $where;
            $insert['create_time'] = time();
            MemberCollectModel::insert($insert);
            $msg = '收藏成功';
        }
        return $this->ajaxReturn($this->successCode, $msg);
    }
    /*end*/


}

