<?php 
/*
 module:		问题列表
 create_time:	2022-01-16 23:36:37
 author:		
 contact:		
*/

namespace app\admin\controller\QA;

use app\admin\service\QA\QuestionService;
use app\admin\model\QA\Question as QuestionModel;
use app\admin\controller\Admin;
use app\api\service\V1\IntegerService;
use think\facade\Db;

class Question extends Admin {


	/*首页数据列表*/
	function index(){
		if (!$this->request->isAjax()){
			return view('index');
		}else{
			$limit  = $this->request->post('limit', 20, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['question_cate_id'] = $this->request->param('question_cate_id', '', 'serach_in');
			$where['auth_status'] = $this->request->param('auth_status', '', 'serach_in');
			$where['resolved_status'] = $this->request->param('resolved_status', '', 'serach_in');
			$where['is_re'] = $this->request->param('is_re', '', 'serach_in');
            $where['m.nickname'] = ['like',$this->request->param('nickname', '', 'serach_in')];

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$field = 'c.question_id,c.member_id,c.title,c.cate_name,c.pics,c.integer_sum,c.like_sum,c.answer_sum,c.see_sum,c.auth_status,c.auth_msg,c.status,c.create_time,c.resolved_status,c.is_re,m.nickname,m.avatar,c.update_date';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'question_id desc';

			$res = QuestionService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}

 /*start*/
	/*修改排序开关按钮操作*/
	function updateExt(){
		$postField = 'question_id,status,is_re';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['question_id']) $this->error('参数错误');
		try{
            if(array_key_exists('is_re',$data)&&$data['is_re']==1){
                $member_id = QuestionModel::where('question_id',$data['question_id'])->value('member_id');
                IntegerService::plus(7,$member_id);
            }
			QuestionModel::update($data);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
    /*end*/

 /*start*/
	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$question_id = $this->request->get('question_id','','serach_in');
			if(!$question_id) $this->error('参数错误');
			$this->view->assign('info',checkData(QuestionModel::find($question_id)));
			return view('update');
		}else{
			$postField = 'question_id,title,question_cate_id,content,pic,integer_sum,auth_status,auth_msg,status,resolved_status,is_re';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$res = QuestionService::update($data);
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}
    /*end*/

 /*start*/
	/*删除*/
	function delete(){
		$idx =  $this->request->post('question_id', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			QuestionModel::destroy(['question_id'=>explode(',',$idx)],true);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
    /*end*/

 /*start*/
	/*查看详情*/
	function view(){
		$question_id = $this->request->get('question_id','','serach_in');
		if(!$question_id) $this->error('参数错误');
		$this->view->assign('info',QuestionModel::find($question_id));
		return view('view');
	}
    /*end*/

 /*start*/
	/*批量编辑数据*/
	function auth(){
		if (!$this->request->isPost()){
			$question_id = $this->request->get('question_id','','serach_in');
			if(!$question_id) $this->error('参数错误');
			$this->view->assign('info',['question_id'=>$question_id]);
			return view('auth');
		}else{
			$postField = 'question_id,auth_status,auth_msg';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$where['question_id'] = explode(',',$data['question_id']);
			unset($data['question_id']);
			try {
				db('question')->where($where)->update($data);
			} catch (\Exception $e) {
				abort(config('my.error_log_code'),$e->getMessage());
			}
			return json(['status'=>'00','msg'=>'操作成功']);
		}
	}
    /*end*/



}

