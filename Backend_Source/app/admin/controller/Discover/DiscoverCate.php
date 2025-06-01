<?php 
/*
 module:		分类管理
 create_time:	2022-01-16 12:13:35
 author:		
 contact:		
*/

namespace app\admin\controller\Discover;

use app\admin\service\Discover\DiscoverCateService;
use app\admin\model\Discover\DiscoverCate as DiscoverCateModel;
use app\admin\controller\Admin;
use think\facade\Db;

class DiscoverCate extends Admin {


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

			$field = 'discover_cate_id,cate_name,status,sort';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'sort desc,discover_cate_id desc';

			$res = DiscoverCateService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}

	/*修改排序开关按钮操作*/
	function updateExt(){
		$postField = 'discover_cate_id,status,sort';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['discover_cate_id']) $this->error('参数错误');
		try{
			DiscoverCateModel::update($data);
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
			$postField = 'cate_name,is_under,status,sort';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$res = DiscoverCateService::add($data);
			if($res && empty($data['sort'])){
				DiscoverCateModel::update(['sort'=>$res,'discover_cate_id'=>$res]);
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$discover_cate_id = $this->request->get('discover_cate_id','','serach_in');
			if(!$discover_cate_id) $this->error('参数错误');
			$this->view->assign('info',checkData(DiscoverCateModel::find($discover_cate_id)));
			return view('update');
		}else{
			$postField = 'discover_cate_id,cate_name,is_under,status,sort';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$res = DiscoverCateService::update($data);
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('discover_cate_id', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			DiscoverCateModel::destroy(['discover_cate_id'=>explode(',',$idx)],true);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}



}

