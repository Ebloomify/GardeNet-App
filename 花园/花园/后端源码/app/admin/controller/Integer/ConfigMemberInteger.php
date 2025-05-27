<?php 
/*
 module:		会员积分等级设置
 create_time:	2021-07-09 13:21:53
 author:		
 contact:		
*/

namespace app\admin\controller\Integer;

use app\admin\service\Integer\ConfigMemberIntegerService;
use app\admin\model\Integer\ConfigMemberInteger as ConfigMemberIntegerModel;
use app\admin\controller\Admin;
use think\facade\Db;

class ConfigMemberInteger extends Admin {


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

			$field = 'config_member_integer_id,level,min,max,content,sort';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'sort desc,config_member_integer_id desc';

			$res = ConfigMemberIntegerService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}

	/*修改排序开关按钮操作*/
	function updateExt(){
		$postField = 'config_member_integer_id,sort';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['config_member_integer_id']) $this->error('参数错误');
		try{
			ConfigMemberIntegerModel::update($data);
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
			$postField = 'icon,level,min,max,content,sort';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$res = ConfigMemberIntegerService::add($data);
			if($res && empty($data['sort'])){
				ConfigMemberIntegerModel::update(['sort'=>$res,'config_member_integer_id'=>$res]);
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$config_member_integer_id = $this->request->get('config_member_integer_id','','serach_in');
			if(!$config_member_integer_id) $this->error('参数错误');
			$this->view->assign('info',checkData(ConfigMemberIntegerModel::find($config_member_integer_id)));
			return view('update');
		}else{
			$postField = 'config_member_integer_id,icon,level,min,max,content,sort';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$res = ConfigMemberIntegerService::update($data);
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('config_member_integer_id', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			ConfigMemberIntegerModel::destroy(['config_member_integer_id'=>explode(',',$idx)],true);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}



}

