<?php 
/*
 module:		问题列表验证器
 create_time:	2022-01-16 23:36:37
 author:		
 contact:		
*/

namespace app\admin\validate\QA;
use think\validate;

class Question extends validate {


	protected $rule = [
		'is_re'=>['require'],
	];

	protected $message = [
		'is_re.require'=>'是否推荐不能为空',
	];

	protected $scene  = [
		'update'=>['is_re'],
	];



}

