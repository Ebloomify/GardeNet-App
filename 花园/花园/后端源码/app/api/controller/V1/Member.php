<?php 
/*
 module:		会员列表
 create_time:	2021-12-19 19:57:51
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\model\V1\CommunityArticle as CommunityArticleModel;
use app\api\model\V1\Question;
use app\api\service\V1\IntegerService;
use app\api\service\V1\MemberService;
use app\api\model\V1\Member as MemberModel;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class Member extends Common {


	/**
	* @api {get} /V1.Member/personal_center 08、个人中心
	* @apiGroup Member
	* @apiVersion 1.0.0
	* @apiDescription  个人中心

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
	function personal_center(){
		$data['member_id'] = $this->request->uid;
		$field='member_id,avatar,nickname,sex,integral,member_level';
		$res  = checkData(MemberModel::field($field)->where($data)->find());
        //查找用户关注与被关注数量
        $res['follows_num'] = \db('member_follow')->where(['member_id' => $res['member_id']])->count();
        $res['fans_num'] = \db('member_follow')->where(['follow_member_id' => $res['member_id']])->count();
        $res['notification_num'] = db('broadcast')->whereRaw(Db::raw("FIND_IN_SET('{$this->request->uid}',to_member_id)"))
            ->whereOr('to_member_id',0)->count();
        $res['notification_num'] = $res['notification_num']-db('broadcast_member')->alias('a')
                ->where('member_id',$this->request->uid)->join('broadcast b','a.broadcast_id = b.broadcast_id')->count();
        //花园
        $res['garden'] = db('garden')->where('member_id',$data['member_id'])->order('create_time desc')
        ->limit(3)->field('id,plant_name,img')->select()->toArray();
        foreach($res['garden'] as $k=>$v){
            $v['img'] = json_decode(json(html_out($v['img']))->getData(), true);
            $img = [];
            foreach($v['img'] as $vv){
                $img[]=$vv['url'];
            }
//            $img = explode(',',$v['img']);
            $res['garden'][$k]['img'] = count($img)>0?$img[0]:'';
        }

		return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($res));
	}


/*start*/
	/**
	* @api {post} /V1.Member/resetPassword 07、修改密码
	* @apiGroup Member
	* @apiVersion 1.0.0
	* @apiDescription  编辑数据

	* @apiParam (输入参数：) {string}     		code 邮箱验证码 (必填)
	* @apiParam (输入参数：) {string}			email 邮箱 (必填)
	* @apiParam (输入参数：) {string}			password 密码 (必填)
	* @apiParam (输入参数：) {string}			re_password 密码 (必填)

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","msg":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function resetPassword(){
        $postField = 'email,code,password,re_password';
        $data = $this->request->only(explode(',', $postField), 'post', null);
        if (!isset($data['email'])) {
            return $this->ajaxReturn($this->errorCode, 'email非法');
        }
        if (!isset($data['code'])) {
            return $this->ajaxReturn($this->errorCode, 'code必须填写');

        }

        $cache = cache($data['email']);
        if ($cache != $data['code']) {
            return $this->ajaxReturn($this->errorCode, '验证码不正确');
        }

        $isExists = MemberModel::where(['email' => $data['email']])->find();
        if (!$isExists) {
            return $this->ajaxReturn($this->errorCode, '该账户不存在');
        }

        if ($data['password'] != $data['re_password']) {
            return $this->ajaxReturn($this->errorCode, '两次密码填写不一致');
        }

		$where['email'] = $data['email'];
		$res = MemberService::resetPassword($where,$data['password']);
		return $this->ajaxReturn($this->successCode,'操作成功');
	}
/*end*/

 /*start*/
    /**
     * @api {post} /V1.Member/permissionStatus 06、个人信息开关
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  编辑数据
     * @apiParam (输入参数：) {string}            member_id 主键ID (必填)
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (输入参数：) {int}                member_permission_status 个人信息开关 开启|1,关闭|0
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
    function permissionStatus()
    {
        if (!$where['member_id'] = $this->request->uid) {
            throw new ValidateException('参数错误');
        }
        if (!$member = MemberModel::where('member_id', $where['member_id'])->find())
            throw new ValidateException('用户不存在');
        if ($member['member_permission_status'] == 1) {
            $data = ['member_permission_status' => 0];
        } else {
            $data = ['member_permission_status' => 1];
        }
        $res = MemberService::permissionStatus($where, $data);
        return $this->ajaxReturn($this->successCode, '操作成功');
    }
    /*end*/

 /*start*/
    /**
     * @api {get} /V1.Member/info 05、用户详情
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  用户详情
     * @apiParam (输入参数：) {string}            member_id 主键ID
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码 201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.data 返回数据详情
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","data":""}
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"没有数据"}
     */
    function info()
    {
        $data['member_id'] = $this->request->get('member_id', '', 'serach_in');

        $field = 'member_id,avatar,nickname,human_desc,member_level,member_permission_status';
        $res = checkData(MemberModel::field($field)->where($data)->find());
        //查询是否关注
        $is_follow = \app\api\model\V1\MemberFollow::where([
            'follow_member_id' => $this->request->uid,
            'member_id' => $data['member_id'],
        ])->count();
        $res['is_follow'] = $is_follow;
        //查找用户关注与被关注数量
        $res['follows'] = \db('member_follow')->where(['member_id' => $res['member_id']])->count();
        $res['fans'] = \db('member_follow')->where(['follow_member_id' => $res['member_id']])->count();
        //用户发布的 Community QA 花园
        $field = 'c.community_article_id,c.community_cate_id,c.title,c.tags,c.content,c.pics,c.member_id,c.like_sum,c.comment_sum,c.see_sum,c.create_time';
        $orderby = 'c.community_article_id desc';
        $where = [
            'c.status' => 1,
            'c.auth_status' => 1,
            'c.member_id'=>$data['member_id']
        ];
        $community = CommunityArticleModel::alias('c')->join('member m', 'c.member_id = m.member_id')
            ->leftJoin('member_like l', 'l.type = 2 and l.object_id = c.community_article_id and l.member_id = ' . $this->request->uid)
            ->leftJoin('member_follow f', 'f.member_id = ' . $data['member_id'] . ' and f.follow_member_id = c.member_id')
            ->field($field)
            ->field('m.avatar,m.nickname,m.member_level')
            ->field('l.member_like_id is_like')
            ->field('f.member_follow_id is_follow')
            ->where(formatWhere($where))
            ->order($orderby)
            ->select()->toArray();

        foreach ($community as $k => $v) {
            $community[$k]['id'] = $v['community_article_id'];
            $community[$k]['cate_id'] = $v['community_cate_id'];
            $community[$k]['pics'] = json_decode(json(html_out($community[$k]['pics']))->getData(), true);
            $community[$k]['is_like'] ? $community[$k]['is_like'] = true : $community[$k]['is_like'] = false;
            $community[$k]['is_follow'] ? $community[$k]['is_follow'] = true : $community[$k]['is_follow'] = false;
        }
        $res['community'] = $community;
        $where = [
            'member_id' => $data['member_id'],
            'status' => 1,
            'auth_status' => 1,
        ];

        $field = 'question_id,title,question_cate_id,cate_name,content,pics,integer_sum,resolved_status,create_time,see_sum,answer_sum,like_sum';
        $orderby = 'question_id desc';
        $question = Question::where(formatWhere($where))->field($field)->order($orderby)->select()->toArray();
        foreach ($question as $k => $v){
            $question[$k]['id'] = $v['question_id'];
            $question[$k]['cate_id'] = $v['question_cate_id'];
            $question[$k]['pics'] = json_decode(json(html_out($question[$k]['pics']))->getData(),true);
//            $question[$k]['create_time'] = date('d/m/Y H:i:s',$v['create_time']);
        }
        $res['qa'] = $question;

        $res['garden'] = db('garden')->where('member_id',$data['member_id'])->order('create_time desc')
            ->limit(3)->field('id,plant_name,plant_introduction,img')->select()->toArray();
        foreach($res['garden'] as $k=>$v){
            $v['img'] = json_decode(json(html_out($v['img']))->getData(), true);
            $img = [];
            foreach($v['img'] as $vv){
                $img[]=$vv['url'];
            }
//            $img = explode(',',$v['img']);
            $res['garden'][$k]['img'] = count($img)>0?$img[0]:'';
        }

        return $this->ajaxReturn($this->successCode, '返回成功', htmlOutList($res));
    }
    /*end*/

 /*start*/
    /**
     * @api {post} /V1.Member/update 04、个人信息修改
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  编辑数据
     * @apiParam (输入参数：) {string}            member_id 主键ID (必填)
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (输入参数：) {string}            avatar 头像 (必填)
     * @apiParam (输入参数：) {string}            nickname 用户昵称 (必填)
     * @apiParam (输入参数：) {int}                sex 性别 (必填) 男|1|success,女|2|warning
     * @apiParam (输入参数：) {string}            mobile 手机号 (必填)
     * @apiParam (输入参数：) {string}            area 地区
     * @apiParam (输入参数：) {string}            human_desc 我的简介
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
    function update()
    {
        $postField = 'member_id,avatar,nickname,sex,mobile,area,human_desc';
        $data = $this->request->only(explode(',', $postField), 'post', null);
        if ($this->request->uid) {
            $data['member_id'] = $this->request->uid;
        } else {
            $data['member_id'] = 0;
        }
        if (empty($data['member_id'])) {
            throw new ValidateException('参数错误');
        }
        $where['member_id'] = $data['member_id'];
        $res = MemberService::update($where, $data);
        return $this->ajaxReturn($this->successCode, '操作成功');
    }
    /*end*/

 /*start*/
    /**
     * @api {get} /V1.Member/edit 03、个人信息展示
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  个人信息
     * @apiParam (输入参数：) {string}            member_id 主键ID
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码 201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.data 返回数据详情
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","data":""}
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"没有数据"}
     */
    function edit()
    {
        if ($this->request->uid) {
            $data['member_id'] = $this->request->uid;
        } else {
            $data['member_id'] = 0;
        }
        $field = 'member_id,avatar,nickname,email,sex,mobile,area,human_desc';
        $res = checkData(MemberModel::field($field)->where($data)->find());
        return $this->ajaxReturn($this->successCode, '返回成功', htmlOutList($res));
    }
    /*end*/

 /*start*/
    /**
     * @api {post} /V1.Member/emailLogin 02、邮箱登录
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  账号密码登录
     * @apiParam (输入参数：) {string}            email 登录用户名
     * @apiParam (输入参数：) {string}            password 登录密码
     * @apiParam (输入参数：) {string}            client_id 客户端id
     * @apiSuccessExample {json} 01 成功示例
     * {
     * "status": "200",
     * "msg": "登陆成功",
     * "data": {
     * "member_id": "3",
     * "nickname": "无限的画笔",
     * "sex": "1",
     * "mobile": "",
     * "email": "790353029@qq.com",
     * "avatar": "/uploads/admin/202101/5ff40b8d7fbd2.jpg",
     * "status": "1",
     * "create_time": "1625802137",
     * "area": "",
     * "human_desc": "",
     * "all_integral": "0",
     * "integral": "0",
     * "member_level": "1",
     * "member_level_exp": "0",
     * "member_permission_status": "0",
     * "follows": 0,       关注数量
     * "fans": 0           粉丝数量
     * },
     * "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJjbGllbnQueGhhZG1pbiIsImF1ZCI6InNlcnZlci54aGFkbWluIiwiaWF0IjoxNjI1ODAzNTA4LCJleHAiOjE2MjU4MTA3MDgsInVpZCI6IjMifQ.d9MuV-pupJzWzJIbdOGPQgskdknrxKGmcHEMW3DGE2Y"
     * }
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"操作失败"}
     */
    function emailLogin()
    {
        $postField = 'email,password,client_id';
        $data = $this->request->only(explode(',', $postField), 'post', null);
        if (empty($data['email']) || empty($data['password'])) throw new ValidateException('账号或密码不能为空');
        $returnField = '*';
        $res = MemberService::emailLogin($data, $returnField);
        unset($res['password']);

        //查找用户关注与被关注数量
        $res['follows'] = \db('member_follow')->where(['member_id' => $res['member_id']])->count();
        $res['fans'] = \db('member_follow')->where(['follow_member_id' => $res['member_id']])->count();
        $res['invite_today'] = db('member_share')->where('member_id',$res['member_id'])
        ->whereRaw("TO_DAYS(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s'))=TO_DAYS(NOW())")->count();
        $res['invite_total'] = db('member_share')->where('member_id',$res['member_id'])->count();
        //增加积分
        IntegerService::plus(5,$res['member_id']);
        return $this->ajaxReturn($this->successCode, '登陆成功', htmlOutList($res), $this->setToken($res['member_id']));
    }
    /*end*/

 /*start*/
    /**
     * @api {post} /V1.Member/register 01、注册账户
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  创建数据
     * @apiParam (输入参数：) {string}            email 邮箱 (必填)
     * @apiParam (输入参数：) {string}            code 验证码 (必填)
     * @apiParam (输入参数：) {string}            password 密码 (必填)
     * @apiParam (输入参数：) {string}            re_password 重复密码 (必填)
     * @apiParam (输入参数：) {string}            invitation_code 邀请码 (选填)
     * @apiSuccessExample {json} 01 成功示例
     *  {
     * "status": "200",
     * "msg": "操作成功",
     * "data": {
     * "avatar": "/uploads/admin/202101/5ff40b8d7fbd2.jpg", 头像
     * "nickname": "无限的画笔", 昵称
     * "email": "790353029@qq.com",
     * "sex": 1, 性别 1男 2女
     * "mobile": "", 手机号
     * "area": "", 地区
     * "human_desc": "", 自我介绍
     * "status": 1, 状态 1 开启 0禁用
     * "create_time": 1625802137, 创建时间
     * "integral": 0, 积分
     * "all_integral": 0, 累计积分
     * "member_level": 1, 等级
     * "member_level_exp": 0, 当前等级经验
     * "member_permission_status": 0  个人信息可见  1开启 0关闭
     * }
     * }
     * @apiErrorExample {json} 02 失败示例
     * {"status":" 201","msg":"操作失败"}
     */
    function register()
    {
        $postField = 'email,code,password,re_password,invitation_code';
        $data = $this->request->only(explode(',', $postField), 'post', null);
        if (!isset($data['email'])) {
            return $this->ajaxReturn($this->errorCode, 'email非法');
        }
        if (!isset($data['code'])) {
            return $this->ajaxReturn($this->errorCode, 'code必须填写');

        }

        $cache = cache($data['email']);
        if ($cache != $data['code']) {
            return $this->ajaxReturn($this->errorCode, '验证码不正确');
        }

        $isExists = MemberModel::where(['email' => $data['email']])->find();
        if ($isExists) {
            return $this->ajaxReturn($this->errorCode, '该账户已注册');

        }


        if ($data['password'] != $data['re_password']) {
            return $this->ajaxReturn($this->errorCode, '两次密码填写不一致');

        }
        $res = MemberService::createDefaultData($data['email'], $data['password']);
        if($data['invitation_code']){
            $member_id = \app\api\model\V1\Member::where('invitation_code',$data['invitation_code'])->value('member_id');
            \app\api\model\V1\MemberShare::create([
                'member_id'=>$member_id,
                'member_invited_id'=>$res['member_id'],
                'create_time'=>time(),
            ]);
            IntegerService::plus(4,$member_id);
        }

        return $this->ajaxReturn($this->successCode, '操作成功');
    }
    /*end*/



}

