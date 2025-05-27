<?php 
/*
 module:		会员列表
 create_time:	2022-03-08 22:38:11
 author:		
 contact:		
*/

namespace app\admin\controller\Member;

use app\admin\service\Member\MemberService;
use app\admin\model\Member\Member as MemberModel;
use app\admin\controller\Admin;
use think\facade\Db;

class Member extends Admin {


	/*首页数据列表*/
	function index(){
		if (!$this->request->isAjax()){
			return view('index');
		}else{
			$limit  = $this->request->post('limit', 20, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['nickname'] = $this->request->param('nickname', '', 'serach_in');
			$where['email'] = $this->request->param('email', '', 'serach_in');
			$where['sex'] = $this->request->param('sex', '', 'serach_in');
			$where['mobile'] = $this->request->param('mobile', '', 'serach_in');

			$create_time_start = $this->request->param('create_time_start', '', 'serach_in');
			$create_time_end = $this->request->param('create_time_end', '', 'serach_in');

			$where['create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$field = 'member_id,avatar,nickname,email,sex,mobile,area,human_desc,status,create_time,integral,all_integral,member_level,member_level_exp,invitation_code';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'member_id desc';

			$res = MemberService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}

	/*修改排序开关按钮操作*/
	function updateExt(){
		$postField = 'member_id,status,member_permission_status';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['member_id']) $this->error('参数错误');
		try{
			MemberModel::update($data);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*添加*/
	function add(){
		if (!$this->request->isPost()){
			return view('add');
		}else{
			$postField = 'avatar,nickname,email,sex,mobile,area,human_desc,status,create_time,password,integral,all_integral,member_level,member_level_exp,invitation_code';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$res = MemberService::add($data);
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$member_id = $this->request->get('member_id','','serach_in');
			if(!$member_id) $this->error('参数错误');
			$this->view->assign('info',checkData(MemberModel::find($member_id)));
			return view('update');
		}else{
			$postField = 'member_id,avatar,nickname,email,sex,mobile,area,human_desc,status,create_time,integral,all_integral,member_level,member_level_exp,invitation_code';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$res = MemberService::update($data);
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('member_id', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			MemberModel::destroy(['member_id'=>explode(',',$idx)],true);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看详情*/
	function view(){
		$member_id = $this->request->get('member_id','','serach_in');
		if(!$member_id) $this->error('参数错误');
		$this->view->assign('info',MemberModel::find($member_id));
		return view('view');
	}

	/*重置密码*/
	function uppass(){
		if (!$this->request->isPost()){
			$info['member_id'] = $this->request->get('member_id','','serach_in');
			return view('uppass',['info'=>$info]);
		}else{
			$postField = 'member_id,password';
			$data = $this->request->only(explode(',',$postField),'post',null);
			if(empty($data['member_id'])) $this->error('参数错误');
			MemberService::uppass($data);
			return json(['status'=>'00','msg'=>'操作成功']);
		}
	}

	/*加积分*/
	function Add_integral(){
        if (!$this->request->isPost()){
            $info['member_id'] = $this->request->get('member_id','','serach_in');
            return view('Add_integral',['info'=>$info]);
        }else{
            $postField = 'member_id,integral';
            $data = $this->request->only(explode(',',$postField),'post',null);

            if(empty($data['member_id'])) $this->error('参数错误');
            if(empty($data['integral'])) $this->error('参数错误');

            $res = MemberService::Add_integral(['member_id'=>explode(',',$data['member_id'])],$data);
            return json(['status'=>'00','msg'=>'操作成功']);
        }
	}

	/*减积分*/
	function Reduction_integral(){
		if (!$this->request->isPost()){
			$info['member_id'] = $this->request->get('member_id','','serach_in');
			return view('Reduction_integral',['info'=>$info]);
		}else{
			$postField = 'member_id,integral';
			$data = $this->request->only(explode(',',$postField),'post',null);
			if(empty($data['member_id'])) $this->error('参数错误');
			$res = MemberService::Reduction_integral(['member_id'=>explode(',',$data['member_id'])],$data);
			return json(['status'=>'00','msg'=>'操作成功']);
		}
	}



}

