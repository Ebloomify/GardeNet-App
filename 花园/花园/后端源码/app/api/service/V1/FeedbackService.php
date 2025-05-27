<?php 
/*
 module:		意见反馈
 create_time:	2021-11-16 01:09:36
 author:		
 contact:		
*/

namespace app\api\service\V1;
use app\api\model\V1\Feedback;
use think\facade\Log;
use think\exception\ValidateException;
use xhadmin\CommonService;

class FeedbackService extends CommonService {


	/*
 	* @Description  创建数据
 	*/
	public static function save($data){
		try{
			validate(\app\api\validate\V1\Feedback::class)->scene('save')->check($data);
			$res = Feedback::create($data);
		}catch(ValidateException $e){
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return $res;
	}




}

