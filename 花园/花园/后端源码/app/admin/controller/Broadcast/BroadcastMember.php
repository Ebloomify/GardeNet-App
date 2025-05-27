<?php 
/*
 module:		广播用户历史记录
 create_time:	2021-12-19 20:18:55
 author:		
 contact:		
*/

namespace app\admin\controller\Broadcast;

use app\admin\service\Broadcast\BroadcastMemberService;
use app\admin\model\Broadcast\BroadcastMember as BroadcastMemberModel;
use app\admin\controller\Admin;
use think\facade\Db;

class BroadcastMember extends Admin {


	/*首页数据列表*/
	function index(){
		if (!$this->request->isAjax()){
			return view('index');
		}else{
			$limit  = $this->request->post('limit', 20, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$field = 'b.nickname,b.avatar,a.broadcast_id,a.is_read,a.read_time,b.email,c.msg_title,a.broadcast_member_id';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'broadcast_member_id desc';

			$res = BroadcastMemberService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}

	/*修改排序开关按钮操作*/
	function updateExt(){
		$postField = 'broadcast_member_id,is_read';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['broadcast_member_id']) $this->error('参数错误');
		try{
			BroadcastMemberModel::where('broadcast_member_id',$data['broadcast_member_id'])->update($data);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}



}

