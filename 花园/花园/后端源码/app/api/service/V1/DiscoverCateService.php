<?php 
/*
 module:		Discover分类
 create_time:	2021-07-09 18:15:50
 author:		
 contact:		
*/

namespace app\api\service\V1;
use app\api\model\V1\DiscoverCate;
use think\facade\Log;
use think\exception\ValidateException;
use xhadmin\CommonService;

class DiscoverCateService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$orderby,$limit,$page){
		try{
			$res = DiscoverCate::where($where)->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['list'=>$res['data'],'count'=>$res['total']];
	}




}

