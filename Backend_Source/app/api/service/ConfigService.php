<?php 
/*
 module:		基础信息
 create_time:	2021-11-16 00:49:37
 author:		
 contact:		
*/

namespace app\api\service;
use app\api\model\Config;
use think\facade\Log;
use think\exception\ValidateException;
use xhadmin\CommonService;

class ConfigService extends CommonService {


	/*start*/
	public static function listList($where,$field,$orderby){
		try{
			$res = Config::where($where)->field($field)->select()->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return $res;
	}
/*end*/



}

