<?php 
/*
 module:		文章管理验证器
 create_time:	2022-01-16 23:01:32
 author:		
 contact:		
*/

namespace app\admin\validate\Discover;
use think\validate;

class DiscoverArticle extends validate {


	protected $rule = [
		'title'=>['require'],
		'discover_cate_id'=>['require'],
		'is_re'=>['require'],
	];

	protected $message = [
		'title.require'=>'标题不能为空',
		'discover_cate_id.require'=>'所属分类不能为空',
		'is_re.require'=>'是否推荐不能为空',
	];

	protected $scene  = [
		'add'=>['title','discover_cate_id','is_re'],
		'update'=>['title','discover_cate_id','is_re'],
	];



}

