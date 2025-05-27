<?php 
/*
 module:		QA问题_回答验证器
 create_time:	2021-11-17 00:32:52
 author:		
 contact:		
*/

namespace app\api\validate\V1;
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
		'save'=>['question_id','content'],
	];



}

