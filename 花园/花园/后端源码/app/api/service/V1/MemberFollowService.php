<?php 
/*
 module:		会员关注关系
 create_time:	2021-07-12 12:47:58
 author:		
 contact:		
*/

namespace app\api\service\V1;
use app\api\model\V1\MemberFollow;
use think\facade\Log;
use think\exception\ValidateException;
use xhadmin\CommonService;

class MemberFollowService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$orderby,$limit,$page){
		try{
			$res = MemberFollow::alias('mf')->where($where)->field($field)
			->join('member m1','m1.member_id=mf.member_id')
			->join('member m2','m2.member_id=mf.follow_member_id')
			->order($orderby)
			->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['list'=>$res['data'],'count'=>$res['total']];
	}




}

