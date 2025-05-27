<?php
/*
 module:		会员关注关系
 create_time:	2021-07-12 12:47:58
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\service\V1\MemberFollowService;
use app\api\model\V1\MemberFollow as MemberFollowModel;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class MemberFollow extends Common
{

    /*start*/
    /**
     * @api {get} /V1.MemberFollow/index 01、首页数据列表
     * @apiGroup MemberFollow
     * @apiVersion 1.0.0
     * @apiDescription  首页数据列表
     * @apiParam (输入参数：) {int}            [limit] 每页数据条数（默认20）
     * @apiParam (输入参数：) {int}            [page] 当前页码
     * @apiParam (输入参数：) {int}            [fans] 1 我的关注 0我的粉丝
     * @apiParam (输入参数：) {int}            [search] 搜索
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
     * {"status":"200","data":{
            "list": [
                {
                    "member_follow_id": "3",
                    "create_time": "",
                    "all_follow": "1",
                    "me_id": "9",
                    "me_nickname": "幸福的麦片",
                    "me_avatar": "/uploads/admin/202101/5ff40b8d7fbd2.jpg",
                    "ta_id": "3",
                    "ta_nickname": "2222222",
                    "ta_avatar": "/uploads/admin/202101/5ff40b8d7fbd2.jpg"
                }
            ],
            "count": 1
     * }}
     * @apiErrorExample {json} 02 失败示例
     * {"status":" 201","msg":"查询失败"}
     */
    function index()
    {
        $limit = $this->request->get('limit', 20, 'intval');
        $page = $this->request->get('page', 1, 'intval');
        $fans = $this->request->get('fans');
        $search = $this->request->get('search');
        $where = [];
        
        $member_id = $this->request->uid;

        if ($fans == 0) {
            $where['mf.follow_member_id'] = $member_id;
        }else{
            $where['mf.member_id'] = $member_id;
        }

        if ($search) {
            if ($member = \app\api\model\V1\Member::where('nickname', 'like', '%' . $search . '%')
                ->field('member_id')->find()) {
                if ($fans == 0) {
                    $where['mf.member_id'] = $member['member_id'];
                }else{
                    $where['mf.follow_member_id'] = $member['member_id'];
                }
            }else{
                return $this->ajaxReturn($this->successCode, '返回成功', ['list'=>[],'count'=>0]);
            }
        }

        $field = 'mf.*,m1.nickname,m1.avatar,m2.nickname as follow_nickname,m2.avatar as follow_avatar';
        $orderby = 'member_follow_id desc';

        $res = MemberFollowService::indexList(formatWhere($where), $field, $orderby, $limit, $page);
        foreach($res['list'] as $k=>$v){
            if($fans==0){
                $res['list'][$k]['me_id'] = $v['follow_member_id'];
                $res['list'][$k]['me_nickname'] = $v['follow_nickname'];
                $res['list'][$k]['me_avatar'] = $v['follow_avatar'];
                $res['list'][$k]['ta_id'] = $v['member_id'];
                $res['list'][$k]['ta_nickname'] = $v['nickname'];
                $res['list'][$k]['ta_avatar'] = $v['avatar'];
            }else{
                $res['list'][$k]['me_id'] = $v['member_id'];
                $res['list'][$k]['me_nickname'] = $v['nickname'];
                $res['list'][$k]['me_avatar'] = $v['avatar'];
                $res['list'][$k]['ta_id'] = $v['follow_member_id'];
                $res['list'][$k]['ta_nickname'] = $v['follow_nickname'];
                $res['list'][$k]['ta_avatar'] = $v['follow_avatar'];
            }
            unset($res['list'][$k]['member_id']);
            unset($res['list'][$k]['nickname']);
            unset($res['list'][$k]['avatar']);
            unset($res['list'][$k]['follow_member_id']);
            unset($res['list'][$k]['follow_nickname']);
            unset($res['list'][$k]['follow_avatar']);
        }


        return $this->ajaxReturn($this->successCode, '返回成功', htmlOutList($res));
    }
    /*end*/

    /*start*/
    /**
     * @api {post} /V1.MemberFollow/addAndRemove 02、关注or取消关注用户
     * @apiGroup MemberFollow
     * @apiVersion 1.0.0
     * @apiDescription  添加
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (输入参数：) {int}                follow_member_id 关注对象id
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","data":"操作成功"}
     * @apiErrorExample {json} 02 失败示例
     * {"status":" 201","msg":"操作失败"}
     */
    function addAndRemove()
    {
        $postField = 'follow_member_id';
        $data = $this->request->only(explode(',', $postField), 'post', null);

        $followMember = \app\api\model\V1\Member::find($data['follow_member_id']);
        if (!$followMember) return $this->ajaxReturn($this->errorCode, '关注用户不存在');

        //是否存在关注记录  存在则取消 不存在则新增

        $isExists = MemberFollowModel::where([
            'member_id' => $this->request->uid,
            'follow_member_id' => $data['follow_member_id'],
        ])->find();

        if ($isExists) { //取消关注
            if ($isExists['all_follow'] == 1) {
                MemberFollowModel::where([
                    'follow_member_id' => $this->request->uid,
                    'member_id' => $data['follow_member_id'],
                ])->update(['all_follow' => 0]);
            }
            $isExists->delete();
            $msg = '取消关注成功';
        } else { //新增关注
            $insert = [];
            $follows = MemberFollowModel::where([
                'follow_member_id' => $this->request->uid,
                'member_id' => $data['follow_member_id'],
            ])->find();
            if ($follows) {
                $follows->save(['all_follow' => 1]);
                $insert['all_follow'] = 1;
            }
            $insert['member_id'] = $this->request->uid;
            $insert['follow_member_id'] = $data['follow_member_id'];
            $insert['create_time'] = time();
            MemberFollowModel::insert($insert);

            $msg = '关注成功';
        }
        return $this->ajaxReturn($this->successCode, $msg);
    }
    /*end*/


}

