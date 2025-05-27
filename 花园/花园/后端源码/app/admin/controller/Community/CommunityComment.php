<?php 
/*
 module:		评论管理
 create_time:	2022-01-16 23:30:19
 author:		
 contact:		
*/

namespace app\admin\controller\Community;

use app\admin\service\Community\CommunityCommentService;
use app\admin\model\Community\CommunityComment as CommunityCommentModel;
use app\admin\controller\Admin;
use think\facade\Db;

class CommunityComment extends Admin {


	/*首页数据列表*/
	function index(){
		if (!$this->request->isAjax()){
			return view('index');
		}else{
			$limit  = $this->request->post('limit', 20, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];

            $where['m.nickname'] = ['like',$this->request->param('nickname', '', 'serach_in')];
			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$field = 'c.community_comment_id,c.member_id,c.community_article_id,c.community_article_title,m.nickname,c.content,c.to_nickname,c.create_time,c.auth_status,c.status,c.like_sum,m.avatar';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'c.community_comment_id desc';

			$res = CommunityCommentService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
			return json($res);
		}
	}

	/*修改排序开关按钮操作*/
	function updateExt(){
		$postField = 'community_comment_id,status,is_read';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['community_comment_id']) $this->error('参数错误');
		try{
			CommunityCommentModel::update($data);
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*start*/
	/*批量编辑数据*/
	function auth(){
		if (!$this->request->isPost()){
			$community_comment_id = $this->request->get('community_comment_id','','serach_in');
			if(!$community_comment_id) $this->error('参数错误');
			$this->view->assign('info',['community_comment_id'=>$community_comment_id]);
			return view('auth');
		}else{
			$postField = 'community_comment_id,auth_status';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$where['community_comment_id'] = explode(',',$data['community_comment_id']);
			unset($data['community_comment_id']);
			try {
				db('community_comment')->where($where)->update($data);

                //批量更新文章评论数量
                $artIds = array_unique(db('community_comment')->where($where)->column('community_article_id'));

                foreach ($artIds as $k => $v){
                    $commentCount =db('community_comment')->where(['community_article_id'=>$v,'auth_status'=>1])->count();

                    //更新文章下评论数量
                    db('community_article')->where(['community_article_id'=>$v])->update([
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

