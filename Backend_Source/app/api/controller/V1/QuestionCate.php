<?php 
/*
 module:		QA分类
 create_time:	2021-08-04 10:31:02
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\service\V1\QuestionCateService;
use app\api\model\V1\QuestionCate as QuestionCateModel;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class QuestionCate extends Common {


	/**
	* @api {get} /V1.QuestionCate/index 01、QA分类列表
	* @apiGroup QuestionCate
	* @apiVersion 1.0.0
	* @apiDescription  QA分类列表
	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码
	* @apiParam (输入参数：) {int}			[is_under] 是否推荐栏目 开启|1,关闭|0

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
// 		$where['is_under'] = $this->request->get('is_under', '', 'serach_in');

		$field = 'question_cate_id,cate_name';
		$orderby = 'sort desc';

		$res = QuestionCateService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
		foreach($res['list'] as $k=>$v){
		       $res['list'][$k]['cate_id'] = $v['question_cate_id'];
		}
		return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($res));
	}
    /*end*/


}

