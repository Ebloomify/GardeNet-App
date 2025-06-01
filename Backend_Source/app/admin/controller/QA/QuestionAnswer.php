<?php 
/*
 module:		回答列表
 create_time:	2022-01-16 23:38:57
 author:		
 contact:		
*/

namespace app\admin\controller\QA;

use app\admin\service\QA\QuestionAnswerService;
use app\admin\model\QA\QuestionAnswer as QuestionAnswerModel;
use app\admin\controller\Admin;
use think\facade\Db;

class QuestionAnswer extends Admin {
    
 /*start*/
	/*批量编辑数据*/
	function auth(){
		if (!$this->request->isPost()){
			$question_answer_id = $this->request->get('question_answer_id','','serach_in');
			if(!$question_answer_id) $this->error('参数错误');
			$this->view->assign('info',['question_answer_id'=>$question_answer_id]);
			return view('auth');
		}else{
			$postField = 'question_answer_id,auth_status';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$where['question_answer_id'] = explode(',',$data['question_answer_id']);
			unset($data['question_answer_id']);
			try {
				db('question_answer')->where($where)->update($data);
                //批量更新文章评论数量
                $artIds = array_unique(db('question_answer')->where($where)->column('question_answer_id'));

                foreach ($artIds as $k => $v){
                    $commentCount =db('question_answer')->where(['question_answer_id'=>$v,'auth_status'=>1])->count();

                    //更新文章下评论数量
                    db('question')->where(['question_id'=>$v])->update([
                        'answer_sum' => $commentCount
                    ]);
                }
			} catch (\Exception $e) {
				abort(config('my.error_log_code'),$e->getMessage());
			}
			return json(['status'=>'00','msg'=>'操作成功']);
		}
	}
	/*end*/


/*start*/
	/*首页数据列表*/
	function index(){
		if (!$this->request->isAjax()){
			return view('index');
		}else{
			$limit  = $this->request->post('limit', 20, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['auth_status'] = $this->request->param('auth_status', '', 'serach_in');
            $where['m.nickname'] = ['like',$this->request->param('nickname', '', 'serach_in')];

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$field = 'c.question_answer_id,c.member_id,m.avatar,m.nickname,c.like_sum,c.is_accept,c.auth_status,c.auth_msg,c.status,c.create_time,c.question_id,c.pid,c.is_read,c.content';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'question_answer_id desc';

			$res = QuestionAnswerService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}
	/*end*/

 /*start*/
	/*修改排序开关按钮操作*/
	function updateExt(){
		$postField = 'question_answer_id,is_accept,status,is_read';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['question_answer_id']) $this->error('参数错误');
		try{
			QuestionAnswerModel::update($data);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
    /*end*/



}

