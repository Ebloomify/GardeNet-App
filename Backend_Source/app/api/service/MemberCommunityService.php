<?php 
/*
 module:		我的Community
 create_time:	2021-12-19 19:14:18
 author:		
 contact:		
*/

namespace app\api\service;
use app\api\model\MemberCommunity;
use think\facade\Log;
use think\exception\ValidateException;
use xhadmin\CommonService;

class MemberCommunityService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function listList($where,$field,$orderby,$limit,$page){
		try{
			$res = MemberCommunity::where($where)->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['list'=>$res['data'],'count'=>$res['total']];
	}


	/*
 	* @Description  列表数据
 	*/
	public static function commentListList($where,$field,$orderby,$limit,$page){
		try{
			$res = MemberCommunity::where($where)->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['list'=>$res['data'],'count'=>$res['total']];
	}




}

