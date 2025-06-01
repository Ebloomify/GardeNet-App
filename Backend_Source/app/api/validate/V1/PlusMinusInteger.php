<?php 
/*
 module:		增减积分验证器
 create_time:	2021-11-16 16:57:40
 author:		
 contact:		
*/

namespace app\api\validate\V1;
use think\validate;

class PlusMinusInteger extends validate {


	protected $rule = [
		'type'=>['require'],
	];

	protected $message = [
		'type.require'=>'type不能为空',
	];

	protected $scene  = [
		'save'=>['type'],
	];



}

