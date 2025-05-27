<?php 
/*
 module:		QA问题_回答
 create_time:	2021-11-17 00:32:52
 author:		
 contact:		
*/

namespace app\api\service\V1;
use app\api\model\V1\QuestionAnswer;
use think\facade\Log;
use think\exception\ValidateException;
use xhadmin\CommonService;

class QuestionAnswerService extends CommonService {


	/*
 	* @Description  编辑数据
 	*/
	public static function pitchOn($where,$data){
		try{
			$res = QuestionAnswer::where($where)->update($data);
		}catch(ValidateException $e){
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return $res;
	}




}

