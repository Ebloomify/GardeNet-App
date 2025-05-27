<?php 
/*
 module:		积分任务设置
 create_time:	2021-08-03 09:51:27
 author:		
 contact:		
*/

namespace app\admin\controller\Integer;

use app\admin\service\Integer\ConfigIntegerService;
use app\admin\model\Integer\ConfigInteger as ConfigIntegerModel;
use app\admin\controller\Admin;
use think\facade\Db;

class ConfigInteger extends Admin {


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

			$field = 'config_integer_id,name,add_integer,finish_sum,sort,is_once';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'sort desc,config_integer_id desc';

			$res = ConfigIntegerService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}

	/*修改排序开关按钮操作*/
	function updateExt(){
		$postField = 'config_integer_id,sort,is_once';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['config_integer_id']) $this->error('参数错误');
		try{
			ConfigIntegerModel::update($data);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$config_integer_id = $this->request->get('config_integer_id','','serach_in');
			if(!$config_integer_id) $this->error('参数错误');
			$this->view->assign('info',checkData(ConfigIntegerModel::find($config_integer_id)));
			return view('update');
		}else{
			$postField = 'config_integer_id,add_integer,finish_sum,sort,is_once';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$res = ConfigIntegerService::update($data);
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}



}

