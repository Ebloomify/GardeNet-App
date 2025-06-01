<?php 
/*
 module:		花园列表
 create_time:	2022-03-06 23:26:14
 author:		
 contact:		
*/

namespace app\admin\controller;

use app\admin\service\GardenService;
use app\admin\model\Garden as GardenModel;
use think\facade\Db;

class Garden extends Admin {


	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$id = $this->request->get('id','','serach_in');
			if(!$id) $this->error('参数错误');
			$this->view->assign('info',checkData(GardenModel::find($id)));
			return view('update');
		}else{
			$postField = 'id,common_name,member_id,plant_name,plant_introduction,duration,flower_color,fertilization,water,exposure,soil,minimum_tempature,blooming,create_time,update_time,img,member';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$res = GardenService::update($data);
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('id', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			GardenModel::destroy(['id'=>explode(',',$idx)],true);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看详情*/
	function view(){
		$id = $this->request->get('id','','serach_in');
		if(!$id) $this->error('参数错误');
		$this->view->assign('info',GardenModel::find($id));
		return view('view');
	}

	/*列表*/
	function index(){
		if (!$this->request->isAjax()){
			return view('index');
		}else{
			$limit  = $this->request->post('limit', 20, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
            $plant_name = $this->request->param('plant_name', '', 'serach_in');
			if($plant_name!='') {
                $plant_name = strtolower($plant_name);
			    $where['LOWER(a.plant_name)'] = ['exp'," like '%{$plant_name}%'"];
            }

			$create_time_start = $this->request->param('create_time_start', '', 'serach_in');
			$create_time_end = $this->request->param('create_time_end', '', 'serach_in');

			$where['a.create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];
			$where['a.nickname'] = $this->request->param('nickname', '', 'serach_in');

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$field = '';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'id desc';

			$sql = 'select a.*,b.nickname from cd_garden as a inner join cd_member as b on a.member_id=b.member_id';
			$limit = ($page-1) * $limit.','.$limit;
			$res = \xhadmin\CommonService::loadList($sql,formatWhere($where),$limit,$orderby);
			return json($res);
		}
	}

	/*start*/
	/*查看发布用户*/
	function showUser(){
		$id = $this->request->get('id','','serach_in');
		if(!$id) $this->error('参数错误');
        $g = GardenModel::find($id);

        $this->view->assign('info',\app\admin\model\Member::find($g['member_id']));

		return view('showUser');
	}
	/*end*/



}

