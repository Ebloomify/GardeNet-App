<?php 
/*
 module:		文章管理验证器
 create_time:	2022-01-18 00:22:33
 author:		
 contact:		
*/

namespace app\admin\validate\Community;
use think\validate;

class CommunityArticle extends validate {


	protected $rule = [
		'community_cate_id'=>['require'],
		'cate_name'=>['require'],
		'is_re'=>['require'],
	];

	protected $message = [
		'community_cate_id.require'=>'所属分类不能为空',
		'cate_name.require'=>'分类名称不能为空',
		'is_re.require'=>'是否推荐不能为空',
	];

	protected $scene  = [
		'update'=>['community_cate_id','is_re'],
	];



}

