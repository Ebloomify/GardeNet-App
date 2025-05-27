<?php 
/*
 module:		积分任务设置
 create_time:	2021-08-03 09:51:27
 author:		
 contact:		
*/

namespace app\admin\service\Integer;
use app\admin\model\Integer\ConfigInteger;
use think\exception\ValidateException;
use xhadmin\CommonService;

class ConfigIntegerService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$order,$limit,$page){
		try{
			$res = ConfigInteger::where($where)->field($field)->order($order)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['rows'=>$res['data'],'total'=>$res['total']];
	}


	/*
 	* @Description  修改
 	*/
	public static function update($data){
		try{
			$res = ConfigInteger::update($data);
		}catch(ValidateException $e){
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		if(!$res){
			throw new ValidateException ('操作失败');
		}
		return $res;
	}




}

