<?php 
/*
 module:		评论管理
 create_time:	2022-01-16 23:21:03
 author:		
 contact:		
*/

namespace app\admin\controller\Discover;

use app\admin\service\Discover\DiscoverCommentService;
use app\admin\model\Discover\DiscoverComment as DiscoverCommentModel;
use app\admin\controller\Admin;
use think\facade\Db;

class DiscoverComment extends Admin {


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

			$field = 'discover_comment_id,member_id,discover_article_id,discover_article_title,nickname,content,to_nickname,create_time,auth_status,status,like_sum';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'discover_comment_id desc';

			$res = DiscoverCommentService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}

	/*修改排序开关按钮操作*/
	function updateExt(){
		$postField = 'discover_comment_id,status,is_read';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['discover_comment_id']) $this->error('参数错误');
		try{
			DiscoverCommentModel::update($data);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*start*/
	/*批量编辑数据*/
	function auth(){
		if (!$this->request->isPost()){
			$discover_comment_id = $this->request->get('discover_comment_id','','serach_in');
			if(!$discover_comment_id) $this->error('参数错误');
			$this->view->assign('info',['discover_comment_id'=>$discover_comment_id]);
			return view('auth');
		}else{
			$postField = 'discover_comment_id,auth_status';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$where['discover_comment_id'] = explode(',',$data['discover_comment_id']);
			unset($data['discover_comment_id']);
			try {
				db('discover_comment')->where($where)->update($data);

				//批量更新文章评论数量
                $artIds = array_unique(db('discover_comment')->where($where)->column('discover_article_id'));

                foreach ($artIds as $k => $v){
                    $commentCount =db('discover_comment')->where(['discover_article_id'=>$v,'auth_status'=>1])->count();

                    //更新文章下评论数量
                    db('discover_article')->where(['discover_article_id'=>$v])->update([
                        'comment_sum' => $commentCount
                    ]);
                }



            } catch (\Exception $e) {
				abort(config('my.error_log_code'),$e->getMessage());
			}
			return json(['status'=>'00','msg'=>'操作成功']);
		}
	}
    /*end*/



}

