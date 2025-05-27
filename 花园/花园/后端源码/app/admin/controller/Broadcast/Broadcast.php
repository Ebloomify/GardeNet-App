<?php 
/*
 module:		公告管理
 create_time:	2021-08-03 09:25:29
 author:		
 contact:		
*/

namespace app\admin\controller\Broadcast;

use app\admin\model\Member;
use app\admin\service\Broadcast\BroadcastService;
use app\admin\model\Broadcast\Broadcast as BroadcastModel;
use app\admin\controller\Admin;
use think\facade\Db;

class Broadcast extends Admin {


	/*首页数据列表*/
	function index(){
		if (!$this->request->isAjax()){
			return view('index');
		}else{
			$limit  = $this->request->post('limit', 20, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['to_member_id'] = $this->request->param('to_member_id', '', 'serach_in');

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$field = 'b.broadcast_id,b.type,b.to_member_id,b.create_time,b.msg_title,m.email';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'broadcast_id desc';

			$res = BroadcastService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}

	/*添加*/
	function add(){
		if (!$this->request->isPost()){
		    $memberData = Member::field('member_id as value,email as name')->select()->toArray();

			return view('add',['memberData'=>urlencode(json_encode($memberData))]);
		}else{
			$postField = 'type,to_member_id,message,create_time,msg_title,msg_content';
			$data = $this->request->only(explode(',',$postField),'post',null);
			if($data['type'] == 1){
                $data['to_member_id'] = 0;
            }
			$res = BroadcastService::add($data);
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$broadcast_id = $this->request->get('broadcast_id','','serach_in');
			if(!$broadcast_id) $this->error('参数错误');

			$info = checkData(BroadcastModel::find($broadcast_id));

            $memberData = Member::field('member_id as value,email as name')->select()->toArray();
            if(!empty($memberData) && $info['to_member_id']!=''){
                $to_member_id = explode(',',$info['to_member_id']);
                foreach ($memberData as $memberDataKey => &$memberDataVal)
                {
                    if(in_array($memberDataVal['value'],$to_member_id)){
                        $memberDataVal['selected'] = true;
                    }
                }
            }

            $this->view->assign('info',checkData(BroadcastModel::find($broadcast_id)));
            $this->view->assign('memberData',urlencode(json_encode($memberData)));
			return view('update');
		}else{
			$postField = 'broadcast_id,type,to_member_id,message,create_time,msg_title,msg_content';
			$data = $this->request->only(explode(',',$postField),'post',null);
            if($data['type'] == 1){
                $data['to_member_id'] = 0;
            }
			$res = BroadcastService::update($data);
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('broadcast_id', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			BroadcastModel::destroy(['broadcast_id'=>explode(',',$idx)],true);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
    /*end*/


}

