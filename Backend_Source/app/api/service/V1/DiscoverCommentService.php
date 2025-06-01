<?php 
/*
 module:		Discover评论
 create_time:	2021-07-12 14:10:17
 author:		
 contact:		
*/

namespace app\api\service\V1;
use app\api\model\V1\DiscoverComment;
use think\facade\Log;
use think\exception\ValidateException;
use xhadmin\CommonService;

class DiscoverCommentService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$orderby,$limit,$page){
		try{
			$res = DiscoverComment::where($where)->field($field)->order($orderby)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['list'=>$res['data'],'count'=>$res['total']];
	}


	/*
 	* @Description  添加
 	*/
	public static function add($data){
		try{
			$data['pid'] = !is_null($data['pid']) ? $data['pid'] : '0';
			$res = DiscoverComment::create($data);
		}catch(ValidateException $e){
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return $res->discover_comment_id;
	}




}

