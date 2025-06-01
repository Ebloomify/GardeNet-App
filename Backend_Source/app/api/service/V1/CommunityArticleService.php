<?php 
/*
 module:		Community
 create_time:	2021-07-12 13:50:05
 author:		
 contact:		
*/

namespace app\api\service\V1;
use app\api\model\V1\CommunityArticle;
use think\facade\Log;
use think\exception\ValidateException;
use xhadmin\CommonService;

class CommunityArticleService extends CommonService {


	/*
 	* @Description  添加
 	*/
	public static function add($data){
		try{
			$res = CommunityArticle::create($data);
		}catch(ValidateException $e){
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return $res->community_article_id;
	}


	/*
 	* @Description  修改
 	*/
	public static function update($where,$data){
		try{
			$res = CommunityArticle::where($where)->update($data);
		}catch(ValidateException $e){
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return $res;
	}




}

