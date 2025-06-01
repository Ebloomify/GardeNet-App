<?php 
/*
 module:		Discover分类
 create_time:	2021-07-09 18:15:50
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\service\V1\DiscoverCateService;
use app\api\model\V1\DiscoverCate as DiscoverCateModel;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class DiscoverCate extends Common {


	/**
	* @api {get} /V1.DiscoverCate/index 01、Discover分类
	* @apiGroup DiscoverCate
	* @apiVersion 1.0.0
	* @apiDescription  Discover分类
	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码

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

		$where = [];

		$field = '*';
		$orderby = 'sort desc';

		$res = DiscoverCateService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
		foreach($res['list'] as $k=>$v){
		       $res['list'][$k]['cate_id'] = $v['discover_cate_id'];
		}
		return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($res));
	}
	/*end*/



}

