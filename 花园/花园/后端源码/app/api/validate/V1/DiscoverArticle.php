<?php 
/*
 module:		Discover验证器
 create_time:	2021-07-09 18:19:17
 author:		
 contact:		
*/

namespace app\api\validate\V1;
use think\validate;

class DiscoverArticle extends validate {


	protected $rule = [
		'title'=>['require'],
		'discover_cate_id'=>['require'],
	];

	protected $message = [
		'title.require'=>'标题不能为空',
		'discover_cate_id.require'=>'所属分类不能为空',
	];

	protected $scene  = [
	];



}

