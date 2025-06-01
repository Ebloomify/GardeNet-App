<?php 
/*
 module:		Discover
 create_time:	2021-07-09 18:19:17
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\service\V1\DiscoverArticleService;
use app\api\model\V1\DiscoverArticle as DiscoverArticleModel;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class DiscoverArticle extends Common {


    /*start*/
	/**
	* @api {get} /V1.DiscoverArticle/view 02、Discover详情
	* @apiGroup DiscoverArticle
	* @apiVersion 1.0.0
	* @apiDescription  Discover详情
	
	* @apiParam (输入参数：) {string}     		discover_article_id 主键ID

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":""}
	* @apiErrorExample {json} 02 失败示例
	* {"status":"201","msg":"没有数据"}
	*/
	function view(){


		$data['discover_article_id'] = $this->request->get('discover_article_id','','serach_in');
		$field='discover_article_id,discover_cate_id,title,discover_cate_id,pic,content,video,see_sum,like_sum,create_time';
		$res  = checkData(DiscoverArticleModel::field($field)->where($data)->find());
        $res['pic'] = json_decode(json(html_out($res['pic']))->getData(),true);
        DiscoverArticleModel::where($data)->update(['see_sum'=>$res['see_sum'] + 1]);
        if ($this->request->uid){ //登录

            $isCollect = \app\api\model\V1\MemberCollect::where([
                'type' => 1,
                'member_id' => $this->request->uid,
                'object_id' => $data['discover_article_id']
            ])->find();
            $isCollect ? $res['is_collect'] = true : $res['is_collect'] = false;

            $isLike = \app\api\model\V1\MemberLike::where([
                'type' => 1,
                'member_id' => $this->request->uid,
                'object_id' => $data['discover_article_id']
            ])->find();
            $isLike ? $res['is_like'] = true : $res['is_like'] = false;

        }else{//未登录
            $res['is_collect'] = false;
            $res['is_like'] = false;
        }
        $res['id'] = $res['discover_article_id'];
        $res['cate_id'] = $res['discover_cate_id'];
        $res['comment_status'] = db('config')->where('name','discover_comment_status')->value('data');
        $res['cate_name'] = db('discover_cate')->where('discover_cate_id',$res['cate_id'])->value('cate_name');
		return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($res));
	}
	/*end*/

    /*start*/
	/**
	* @api {get} /V1.DiscoverArticle/index 01、Discover列表
	* @apiGroup DiscoverArticle
	* @apiVersion 1.0.0
	* @apiDescription  Discover列表
	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码
     * @apiParam (输入参数：) {string}		[discover_cate_id] 所属分类
     * @apiParam (输入参数：) {string}		[search] 搜索关键字
     * @apiParam (输入参数：) {string}		[member_id] 查询用户的文章
     * @apiParam (输入参数：) {string}		[is_re] 1 显示推荐分类 0显示普通 传1时 member_id和discover_cate_id无效

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码 201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.data 返回数据
	* @apiParam (成功返回参数：) {string}     	array.data.list 返回数据列表
	* @apiParam (成功返回参数：) {string}     	array.data.count 返回数据总数
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":""}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"查询失败"}
	*/
	function index(){
		$limit  = $this->request->get('limit', 20, 'intval');
		$page   = $this->request->get('page', 1, 'intval');
		$search =  $this->request->get('search', '');
		$is_re =  $this->request->get('is_re', '');
        $member_id = $this->request->get('member_id');

		$where = [
		    'status' => 1,
        ];
		if($is_re){
		    $where['is_re'] = 1;
        }else{
            if($member_id){
                $where['c.member_id']=$member_id;
            }
            $where['discover_cate_id'] = $this->request->get('discover_cate_id', '', 'serach_in');
        }

		$search && $where['title'] = ['like',"%".$search."%"];

		$field = 'discover_article_id,title,discover_cate_id,pic,content,see_sum,create_time';
		$orderby = 'discover_article_id desc';

		$res = DiscoverArticleService::indexList(formatWhere($where),$field,$orderby,$limit,$page);


        $list = $res['list'];
        foreach ($list as $k => $v){
            $list[$k]['id'] = $v['discover_article_id'];
            $list[$k]['cate_id'] = $v['discover_cate_id'];
            $list[$k]['pic'] = json_decode(json(html_out($list[$k]['pic']))->getData(),true);
        }
        $res['list'] = $list;
		return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($res));
	}
    /*end*/



}

