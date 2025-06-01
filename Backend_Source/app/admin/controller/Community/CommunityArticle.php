<?php 
/*
 module:		文章管理
 create_time:	2022-01-18 00:22:33
 author:		
 contact:		
*/

namespace app\admin\controller\Community;

use app\admin\service\Community\CommunityArticleService;
use app\admin\model\Community\CommunityArticle as CommunityArticleModel;
use app\admin\controller\Admin;
use app\api\service\V1\IntegerService;
use think\facade\Db;

class CommunityArticle extends Admin {


	/*首页数据列表*/
	function index(){
		if (!$this->request->isAjax()){
			return view('index');
		}else{
			$limit  = $this->request->post('limit', 20, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['community_cate_id'] = $this->request->param('community_cate_id', '', 'serach_in');
			$where['auth_status'] = $this->request->param('auth_status', '', 'serach_in');
            $where['m.nickname'] = ['like',$this->request->param('nickname', '', 'serach_in')];

			$create_time_start = $this->request->param('create_time_start', '', 'serach_in');
			$create_time_end = $this->request->param('create_time_end', '', 'serach_in');

			$where['create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];
			$where['is_re'] = $this->request->param('is_re', '', 'serach_in');

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$field = 'c.community_article_id,c.title,c.cate_name,c.tags,c.pics,c.member_id,c.like_sum,c.comment_sum,c.see_sum,c.auth_status,c.auth_msg,c.status,c.sort,c.create_time,c.is_re,m.nickname,m.avatar,c.update_date';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'sort desc,community_article_id desc';

			$res = CommunityArticleService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('community_article_id', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			CommunityArticleModel::destroy(['community_article_id'=>explode(',',$idx)],true);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看详情*/
	function view(){
		$community_article_id = $this->request->get('community_article_id','','serach_in');
		if(!$community_article_id) $this->error('参数错误');
		$this->view->assign('info',CommunityArticleModel::find($community_article_id));
		return view('view');
	}

	/*批量编辑数据*/
	function auth(){
		if (!$this->request->isPost()){
			$community_article_id = $this->request->get('community_article_id','','serach_in');
			if(!$community_article_id) $this->error('参数错误');
			$this->view->assign('info',['community_article_id'=>$community_article_id]);
			return view('auth');
		}else{
			$postField = 'community_article_id,auth_status,auth_msg';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$where['community_article_id'] = explode(',',$data['community_article_id']);
			unset($data['community_article_id']);
			try {
				db('community_article')->where($where)->update($data);
			} catch (\Exception $e) {
				abort(config('my.error_log_code'),$e->getMessage());
			}
			return json(['status'=>'00','msg'=>'操作成功']);
		}
	}

	/*start*/
	/*修改排序开关按钮操作*/
	function updateExt(){
		$postField = 'community_article_id,status,sort,is_re';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['community_article_id']) $this->error('参数错误');
		db()->startTrans();
		try{
		    if(array_key_exists('is_re',$data)&&$data['is_re']==1){
		        $member_id = CommunityArticleModel::where('community_article_id',$data['community_article_id'])->value('member_id');
                IntegerService::plus(7,$member_id);
            }
			CommunityArticleModel::update($data);
			db()->commit();
		}catch(\Exception $e){
		    db()->rollback();
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
	/*end*/

	/*start*/
	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$community_article_id = $this->request->get('community_article_id','','serach_in');
			if(!$community_article_id) $this->error('参数错误');
			$this->view->assign('info',checkData(CommunityArticleModel::find($community_article_id)));
			return view('update');
		}else{
			$postField = 'community_article_id,title,community_cate_id,tags,content,pics,sort,is_re';
			$data = $this->request->only(explode(',',$postField),'post',null);
            $cate = (new \app\admin\model\Community\CommunityCate())->find($data['community_cate_id']);
            $data['cate_name'] = $cate['cate_name'];
			$res = CommunityArticleService::update($data);
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}
	/*end*/



}

