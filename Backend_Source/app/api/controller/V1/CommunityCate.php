<?php 
/*
 module:		Community分类
 create_time:	2021-07-09 18:46:52
 author:		
 contact:		
*/

namespace app\api\controller\V1;

use app\api\service\V1\CommunityCateService;
use app\api\model\V1\CommunityCate as CommunityCateModel;
use app\api\controller\Common;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Log;

class CommunityCate extends Common {


    /*start*/
	/**
	* @api {get} /V1.CommunityCate/index 01、分类列表
	* @apiGroup CommunityCate
	* @apiVersion 1.0.0
	* @apiDescription  分类列表
	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码
	* @apiParam (输入参数：) {int}			[is_under] 是否推荐栏目 推荐|1,非推荐|0 ,全部|2


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

// 		if ($where['is_under'] == 2) unset($where['is_under']);

		$field = '*';
		$orderby = 'sort desc';

		$res = CommunityCateService::indexList(formatWhere($where),$field,$orderby,$limit,$page);
		foreach($res['list'] as $k=>$v){
		       $res['list'][$k]['cate_id'] = $v['community_cate_id'];
		}
		return $this->ajaxReturn($this->successCode,'返回成功',htmlOutList($res));
	}
    /*end*/


}

