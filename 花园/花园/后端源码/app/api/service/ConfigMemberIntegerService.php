<?php 
/*
 module:		会员积分说明
 create_time:	2021-11-16 01:38:35
 author:		
 contact:		
*/

namespace app\api\service;
use app\api\model\ConfigMemberInteger;
use think\facade\Log;
use think\exception\ValidateException;
use xhadmin\CommonService;

class ConfigMemberIntegerService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function listList($where,$field,$orderby,$limit,$page){
		try{
			$res = ConfigMemberInteger::where($where)->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['list'=>$res['data'],'count'=>$res['total']];
	}




}

