<?php 
/*
 module:		反馈列表
 create_time:	2021-11-13 23:22:44
 author:		
 contact:		
*/

namespace app\admin\service\Feedback;
use app\admin\model\Feedback\Index;
use think\exception\ValidateException;
use xhadmin\CommonService;

class IndexService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$order,$limit,$page){
		try{
			$res = Index::where($where)->field($field)->order($order)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['rows'=>$res['data'],'total'=>$res['total']];
	}




}

