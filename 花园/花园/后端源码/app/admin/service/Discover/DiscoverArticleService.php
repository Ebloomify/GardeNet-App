<?php 
/*
 module:		文章管理
 create_time:	2022-01-16 23:01:32
 author:		
 contact:		
*/

namespace app\admin\service\Discover;
use app\admin\model\Discover\DiscoverArticle;
use think\exception\ValidateException;
use xhadmin\CommonService;

class DiscoverArticleService extends CommonService {


	/*
 	* @Description  列表数据
 	*/
	public static function indexList($where,$field,$order,$limit,$page){
		try{
			$res = DiscoverArticle::where($where)->field($field)->order($order)->paginate(['list_rows'=>$limit,'page'=>$page])->toArray();
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		return ['rows'=>$res['data'],'total'=>$res['total']];
	}


	/*start*/
	/*
 	* @Description  添加
 	*/
	public static function add($data){
		try{
			validate(\app\admin\validate\Discover\DiscoverArticle::class)->scene('add')->check($data);

            //查找分类名
            $cateInfo =  \app\admin\model\Discover\DiscoverCate::find($data['discover_cate_id']);
            $data['cate_name'] = $cateInfo['cate_name'];

			$data['create_time'] = time();
			$res = DiscoverArticle::create($data);
		}catch(ValidateException $e){
			throw new ValidateException ($e->getError());
		}catch(\Exception $e){
			abort(config('my.error_log_code'),$e->getMessage());
		}
		if(!$res){
			throw new ValidateException ('操作失败');
		}
		return $res->discover_article_id;
	}
    /*end*/

 /*start*/
	/*
 	* @Description  修改
 	*/
	public static function update($data){
		try{
			validate(\app\admin\validate\Discover\DiscoverArticle::class)->scene('update')->check($data);

            //查找分类名
            $cateInfo =  \app\admin\model\Discover\DiscoverCate::find($data['discover_cate_id']);
            $data['cate_name'] = $cateInfo['cate_name'];


			$res = DiscoverArticle::update($data);
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

