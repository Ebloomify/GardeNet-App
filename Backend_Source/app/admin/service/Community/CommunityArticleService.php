<?php 
/*
 module:		文章管理
 create_time:	2022-01-18 00:22:33
 author:		
 contact:		
*/

namespace app\admin\service\Community;
use app\admin\model\Community\CommunityArticle;
use think\exception\ValidateException;
use xhadmin\CommonService;

class CommunityArticleService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$order,$limit,$page){
		try{
			$res = CommunityArticle::where($where)->alias('c')->field($field)->order($order)
                ->join('member m','m.member_id=c.member_id')
                ->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['rows'=>$res['data'],'total'=>$res['total']];
	}


 /*start*/
	/*
 	* @Description  修改
 	*/
	public static function update($data){
		try{
			$res = CommunityArticle::update($data);
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
    /*end*/



}

