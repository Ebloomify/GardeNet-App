<?php 
/*
 module:		花园图标设置
 create_time:	2021-12-26 23:05:01
 author:		
 contact:		
*/

namespace app\admin\controller;

use app\admin\service\GardenIconService;
use app\admin\model\GardenIcon as GardenIconModel;
use think\facade\Db;

class GardenIcon extends Admin {


	/*首页数据列表*/
	function index(){
		if (!$this->request->isAjax()){
			return view('index');
		}else{
			$limit  = $this->request->post('limit', 20, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['name'] = $this->request->param('name_s', '', 'serach_in');

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$field = 'id,name,icon';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'id desc';

			$res = GardenIconService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}

	/*添加*/
	function add(){
		if (!$this->request->isPost()){
			return view('add');
		}else{
			$postField = 'name,icon';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$res = GardenIconService::add($data);
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$id = $this->request->get('id','','serach_in');
			if(!$id) $this->error('参数错误');
			$this->view->assign('info',checkData(GardenIconModel::find($id)));
			return view('update');
		}else{
			$postField = 'id,name,icon';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$res = GardenIconService::update($data);
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}



}

