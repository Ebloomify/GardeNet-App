<?php 
/*
 module:		回答列表验证器
 create_time:	2022-01-16 23:38:57
 author:		
 contact:		
*/

namespace app\admin\validate\QA;
use think\validate;

class QuestionAnswer extends validate {


	protected $rule = [
		'question_id'=>['require'],
		'content'=>['require'],
	];

	protected $message = [
		'question_id.require'=>'问题id不能为空',
		'content.require'=>'回答内容不能为空',
	];

	protected $scene  = [
	];



}

