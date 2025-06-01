<?php 
/*
 module:		回答列表
 create_time:	2022-01-16 23:38:57
 author:		
 contact:		
*/

namespace app\admin\service\QA;
use app\admin\model\QA\QuestionAnswer;
use think\exception\ValidateException;
use xhadmin\CommonService;

class QuestionAnswerService extends CommonService {


 /*start*/
	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$order,$limit,$page){
		try{
			$res = QuestionAnswer::where($where)->alias('c')->field($field)->order($order)
                ->join('member m','m.member_id=c.member_id')
                ->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['rows'=>$res['data'],'total'=>$res['total']];
	}
    /*end*/



}

