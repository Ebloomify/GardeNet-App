<?php 
/*
 module:		花园列表
 create_time:	2022-03-06 23:26:14
 author:		
 contact:		
*/

namespace app\admin\service;
use app\admin\model\Garden;
use think\exception\ValidateException;
use xhadmin\CommonService;

class GardenService extends CommonService {


	/*
 	* @Description  修改
 	*/
	public static function update($data){
		try{
			$data['create_time'] = strtotime($data['create_time']);
			$data['update_time'] = time();
			$res = Garden::update($data);
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

