<?php 
/*
 module:		分类管理
 create_time:	2022-01-16 13:01:20
 author:		
 contact:		
*/

namespace app\admin\controller\QA;

use app\admin\service\QA\QuestionCateService;
use app\admin\model\QA\QuestionCate as QuestionCateModel;
use app\admin\controller\Admin;
use think\facade\Db;

class QuestionCate extends Admin {


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

			$field = 'question_cate_id,cate_name,status,sort';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'sort desc,question_cate_id desc';

			$res = QuestionCateService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}

	/*修改排序开关按钮操作*/
	function updateExt(){
		$postField = 'question_cate_id,status,sort';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['question_cate_id']) $this->error('参数错误');
		try{
			QuestionCateModel::update($data);
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
			$res = QuestionCateService::add($data);
			if($res && empty($data['sort'])){
				QuestionCateModel::update(['sort'=>$res,'question_cate_id'=>$res]);
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$question_cate_id = $this->request->get('question_cate_id','','serach_in');
			if(!$question_cate_id) $this->error('参数错误');
			$this->view->assign('info',checkData(QuestionCateModel::find($question_cate_id)));
			return view('update');
		}else{
			$postField = 'question_cate_id,cate_name,is_under,status,sort';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$res = QuestionCateService::update($data);
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('question_cate_id', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			QuestionCateModel::destroy(['question_cate_id'=>explode(',',$idx)],true);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}



}

