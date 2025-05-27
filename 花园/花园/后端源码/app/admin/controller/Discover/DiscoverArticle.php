<?php 
/*
 module:		文章管理
 create_time:	2022-01-16 23:01:32
 author:		
 contact:		
*/

namespace app\admin\controller\Discover;

use app\admin\service\Discover\DiscoverArticleService;
use app\admin\model\Discover\DiscoverArticle as DiscoverArticleModel;
use app\admin\controller\Admin;
use think\facade\Db;

class DiscoverArticle extends Admin {


	/*首页数据列表*/
	function index(){
		if (!$this->request->isAjax()){
			return view('index');
		}else{
			$limit  = $this->request->post('limit', 20, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['discover_cate_id'] = $this->request->param('discover_cate_id', '', 'serach_in');

			$create_time_start = $this->request->param('create_time_start', '', 'serach_in');
			$create_time_end = $this->request->param('create_time_end', '', 'serach_in');

			$where['create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];
			$where['is_re'] = $this->request->param('is_re', '', 'serach_in');

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$field = 'discover_article_id,title,cate_name,pic,video,like_sum,see_sum,comment_sum,sort,status,create_time,is_re';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'sort desc,discover_article_id desc';

			$res = DiscoverArticleService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}

	/*修改排序开关按钮操作*/
	function updateExt(){
		$postField = 'discover_article_id,sort,status,is_re';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['discover_article_id']) $this->error('参数错误');
		try{
			DiscoverArticleModel::update($data);
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
			$postField = 'title,discover_cate_id,pic,content,video,status,create_time,sort,see_sum,comment_sum,is_re';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$res = DiscoverArticleService::add($data);
			if($res && empty($data['sort'])){
				DiscoverArticleModel::update(['sort'=>$res,'discover_article_id'=>$res]);
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$discover_article_id = $this->request->get('discover_article_id','','serach_in');
			if(!$discover_article_id) $this->error('参数错误');
			$this->view->assign('info',checkData(DiscoverArticleModel::find($discover_article_id)));
			return view('update');
		}else{
			$postField = 'discover_article_id,title,discover_cate_id,pic,content,video,status,sort,see_sum,comment_sum,is_re';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$res = DiscoverArticleService::update($data);
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('discover_article_id', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			DiscoverArticleModel::destroy(['discover_article_id'=>explode(',',$idx)],true);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看详情*/
	function view(){
		$discover_article_id = $this->request->get('discover_article_id','','serach_in');
		if(!$discover_article_id) $this->error('参数错误');
		$this->view->assign('info',DiscoverArticleModel::find($discover_article_id));
		return view('view');
	}



}

