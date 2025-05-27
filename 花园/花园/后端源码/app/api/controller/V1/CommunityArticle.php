<?php
/*
 module:		Community
 create_time:	2021-07-12 13:50:05
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\service\V1\CommunityArticleService;
use app\api\model\V1\CommunityArticle as CommunityArticleModel;
use app\api\controller\Common;
use app\api\service\V1\IntegerService;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class CommunityArticle extends Common
{


    /*start*/
    /**
     * @api {get} /V1.CommunityArticle/view 05、Community详情
     * @apiGroup CommunityArticle
     * @apiVersion 1.0.0
     * @apiDescription  查看详情
     * @apiParam (输入参数：) {string}            community_article_id 主键ID
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","data":""}
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"没有数据"}
     */
    function view()
    {
        $data['community_article_id'] = $this->request->get('community_article_id', '', 'serach_in');
        $field = 'community_article_id,community_cate_id,title,tags,content,pics,member_id,like_sum,comment_sum,see_sum,create_time';
        $res = checkData(CommunityArticleModel::field($field)->where($data)->find());
        CommunityArticleModel::where($data)->update(['see_sum' => $res['see_sum'] + 1]);
        //用户相关信息
        $member = \app\api\model\V1\Member::find($res['member_id']);

        $res['pics'] = json_decode(json(html_out($res['pics']))->getData(), true);
        $res['avatar'] = $member['avatar'];
        $res['nickname'] = $member['nickname'];
        $res['member_level'] = $member['member_level'];


        //是否关注 收藏 点赞
        if ($this->request->uid) {
            $follow = \app\api\model\V1\MemberFollow::where([
                'member_id' => $this->request->uid,
                'follow_member_id' => $res['member_id'],
            ])->find();
            $like = \app\api\model\V1\MemberLike::where([
                'member_id' => $this->request->uid,
                'type' => 2,
                'object_id' => $data['community_article_id'],
            ])->find();
            $collect = \app\api\model\V1\MemberCollect::where([
                'type' => 2,
                'member_id' => $this->request->uid,
                'object_id' => $data['community_article_id'],
            ])->find();

            $follow ? $res['is_follow'] = true : $res['is_follow'] = false;
            $like ? $res['is_like'] = true : $res['is_like'] = false;
            $collect ? $res['is_collect'] = true : $res['is_collect'] = false;
        } else {
            $res['is_follow'] = false;
            $res['is_like'] = false;
            $res['is_collect'] = false;
        }
        $res['id'] = $res['community_article_id'];
        $res['cate_id'] = $res['community_cate_id'];
        $res['comment_status'] = db('config')->where('name','community_comment_status')->value('data');
        $res['cate_name'] = db('community_cate')->where('community_cate_id',$res['cate_id'])->value('cate_name');
        return $this->ajaxReturn($this->successCode, '返回成功', htmlOutList($res));
    }
    /*end*/

    /*start*/
    /**
     * @api {get} /V1.CommunityArticle/index 01、Community列表
     * @apiGroup CommunityArticle
     * @apiVersion 1.0.0
     * @apiDescription  Community列表
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (输入参数：) {int}            [limit] 每页数据条数（默认20）
     * @apiParam (输入参数：) {int}            [page] 当前页码
     * @apiParam (输入参数：) {string}        [community_cate_id] 所属分类
     * @apiParam (输入参数：) {string}        [search] 搜索内容
     * @apiParam (输入参数：) {string}        [member_id] 查询用户的文章
     * @apiParam (输入参数：) {string}		[is_re] 1 显示推荐分类 0显示普通 传1时 member_id和community_cate_id无效
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
     *    {
     * "community_article_id": 7,
     * "title": "测试1",
     * "tags": "标签1,标签2",
     * "content": "我是内容我是内容我是内容我是内容我是内容我是内容我是内容我是内容我是内容",
     * "pics": [
     * {
     * "title": "",
     * "url": "xxx.jpg"
     * },
     * {
     * "title": "",
     * "url": "xxx.jpg"
     * }
     * ],
     * "member_id": 3,
     * "avatar": "/uploads/admin/202101/5ff40b8d7fbd2.jpg",  头像
     * "nickname": "无限的画笔", 昵称
     * "member_level": 1, 用户等级
     * "like_sum": 1, 点赞数
     * "comment_sum": 0, 评论数
     * "see_sum": 0,  浏览量
     * "create_time": 1625828729,
     * "is_like": true, 是否点赞 true 是 false 否
     * "is_follow": true  关注
     * },
     * @apiErrorExample {json} 02 失败示例
     * {"status":" 201","msg":"查询失败"}
     */
    function index()
    {
        $limit = $this->request->get('limit', 20, 'intval');
        $page = $this->request->get('page', 1, 'intval');
        $search = $this->request->get('search', '');
        $member_id = $this->request->get('member_id');
        $is_re =  $this->request->get('is_re', '');

        $where = [
            'c.status' => 1,
            'c.auth_status' => 1,
        ];
        if($is_re){
            $where['is_re'] = 1;
        }else {
            if ($member_id) {
                $where['c.member_id'] = $member_id;
            }

            $where['c.community_cate_id'] = $this->request->get('community_cate_id', '', 'serach_in');
        }
        $search && $where['c.title'] = ['like',"%".$search."%"];
        $field = 'c.community_article_id,c.community_cate_id,c.title,c.tags,c.content,c.pics,c.member_id,c.like_sum,c.comment_sum,c.see_sum,c.create_time';
        $orderby = 'c.community_article_id desc';

        if ($this->request->uid) {
            $memberId = $this->request->uid;
        } else {
            $memberId = 0;
        }

        $data = CommunityArticleModel::alias('c')->join('member m', 'c.member_id = m.member_id')
            ->leftJoin('member_like l', 'l.type = 2 and l.object_id = c.community_article_id and l.member_id = ' . $memberId)
            ->leftJoin('member_follow f', 'f.member_id = ' . $memberId . ' and f.follow_member_id = c.member_id')
            ->field($field)
            ->field('m.avatar,m.nickname,m.member_level')
            ->field('l.member_like_id is_like')
            ->field('f.member_follow_id is_follow')
            ->where(formatWhere($where))
            ->order($orderby)
            ->paginate(['list_rows' => $limit, 'page' => $page])->toArray();


        $return = [];

        $list = $data['data'];
        foreach ($list as $k => $v) {
            $list[$k]['id'] = $v['community_article_id'];
            $list[$k]['cate_id'] = $v['community_cate_id'];
            $list[$k]['pics'] = json_decode(json(html_out($list[$k]['pics']))->getData(), true);
            $list[$k]['is_like'] ? $list[$k]['is_like'] = true : $list[$k]['is_like'] = false;
            $list[$k]['is_follow'] ? $list[$k]['is_follow'] = true : $list[$k]['is_follow'] = false;
        }
        $return['list'] = $list;
        $return['count'] = $data['total'];

        return $this->ajaxReturn($this->successCode, '返回成功', htmlOutList($return));
    }
    /*end*/

    /*start*/
    /**
     * @api {post} /V1.CommunityArticle/delete 04、Community删除
     * @apiGroup CommunityArticle
     * @apiVersion 1.0.0
     * @apiDescription  删除
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (输入参数：) {string}            community_article_id 主键id
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码 201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.msg 返回成功消息
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","msg":"操作成功"}
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"操作失败"}
     */
    function delete()
    {
        $idx = $this->request->post('community_article_id', '', 'serach_in');
        if (empty($idx)) {
            throw new ValidateException('参数错误');
        }
        $memberId = $this->request->uid;
        $data['community_article_id'] = $idx;
        try {
            CommunityArticleModel::where(['member_id' => $memberId])->delete($data);
        } catch (\Exception $e) {
            abort(config('my.error_log_code'), $e->getMessage());
        }
        return $this->ajaxReturn($this->successCode, '操作成功');
    }
    /*end*/

    /*start*/
    /**
     * @api {post} /V1.CommunityArticle/update 03、Community修改
     * @apiGroup CommunityArticle
     * @apiVersion 1.0.0
     * @apiDescription  修改
     * @apiParam (输入参数：) {string}            community_article_id 主键ID (必填)
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (输入参数：) {string}            title 标题
     * @apiParam (输入参数：) {string}            community_cate_id 所属分类
     * @apiParam (输入参数：) {string}            tags 标签
     * @apiParam (输入参数：) {string}            content 内容
     * @apiParam (输入参数：) {string}            pics 图片上传
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","msg":"操作成功"}
     * @apiErrorExample {json} 02 失败示例
     * {"status":" 201","msg":"操作失败"}
     */
    function update()
    {
        $postField = 'community_article_id,title,community_cate_id,tags,content,pics';
        $data = $this->request->only(explode(',', $postField), 'post', null);
        if (empty($data['community_article_id'])) {
            throw new ValidateException('参数错误');
        }
        $cate = (new \app\api\model\V1\CommunityCate())->find($data['community_cate_id']);
        if (!$cate) return $this->ajaxReturn($this->errorCode, '添加的分类不存在');

        $authStatus = \db('config')->where(['name' => 'community_auth_status'])->value('data');
        $data['auth_status'] = $authStatus == 1 ? 2 : 1;
        $data['cate_name'] = $cate['cate_name'];

        $where['community_article_id'] = $data['community_article_id'];
        $data['update_date'] = date('Y-m-d H:i:s');
        $res = CommunityArticleService::update($where, $data);
        return $this->ajaxReturn($this->successCode, '操作成功',['id'=>$data['community_article_id']]);
    }
    /*end*/

    /*start*/
    /**
     * @api {post} /V1.CommunityArticle/add 02、Community新增
     * @apiGroup CommunityArticle
     * @apiVersion 1.0.0
     * @apiDescription  添加
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (输入参数：) {string}            title 标题
     * @apiParam (输入参数：) {string}            community_cate_id 所属分类
     * @apiParam (输入参数：) {string}            tags 标签
     * @apiParam (输入参数：) {string}            content 内容
     * @apiParam (输入参数：) {string}            pics 图片上传
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
    function add()
    {
        $postField = 'title,community_cate_id,tags,content,pics';
        $data = $this->request->only(explode(',', $postField), 'post', null);

        $cate = (new \app\api\model\V1\CommunityCate())->find($data['community_cate_id']);
        if (!$cate) return $this->ajaxReturn($this->errorCode, '添加的分类不存在');

        $authStatus = \db('config')->where(['name' => 'community_auth_status'])->value('data');
        $defaultData = [
            'cate_name' => $cate['cate_name'],
            'member_id' => $this->request->uid,
            'like_sum' => 0,
            'see_sum' => 0,
            'collect_sum' => 0,
            'auth_status' => $authStatus == 1 ? 2 : 1,
            'auth_msg' => '',
            'status' => 1,
            'sort' => 1,
            'create_time' => time(),
        ];
        $insert = array_merge($data, $defaultData);

        $id = CommunityArticleModel::insertGetId($insert);
        //添加积分
        IntegerService::plus(1,$this->request->uid);
        return $this->ajaxReturn($this->successCode, '操作成功',['id'=>$id]);
    }
    /*end*/


}

