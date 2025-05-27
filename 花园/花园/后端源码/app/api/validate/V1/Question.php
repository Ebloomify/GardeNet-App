<?php 
/*
 module:		QA问题验证器
 create_time:	2021-08-05 10:14:53
 author:		
 contact:		
*/

namespace app\api\validate\V1;
use think\validate;

class Question extends validate {


	protected $rule = [
		'title'=>['require'],
		'question_cate_id'=>['require'],
		'content'=>['require'],
	];

	protected $message = [
		'title.require'=>'标题不能为空',
		'question_cate_id.require'=>'所属分类不能为空',
		'content.require'=>'问题内容不能为空',
	];

	protected $scene  = [
		'add'=>['title','question_cate_id','content'],
		'update'=>['title','content','question_cate_id'],
	];



}

