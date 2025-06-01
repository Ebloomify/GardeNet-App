<?php 
/*
 module:		评论管理
 create_time:	2022-01-16 23:21:03
 author:		
 contact:		
*/

namespace app\admin\service\Discover;
use app\admin\model\Discover\DiscoverComment;
use think\exception\ValidateException;
use xhadmin\CommonService;

class DiscoverCommentService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$order,$limit,$page){
		try{
			$res = DiscoverComment::where($where)->field($field)->order($order)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['rows'=>$res['data'],'total'=>$res['total']];
	}




}

