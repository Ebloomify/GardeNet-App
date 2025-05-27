<?php 
/*
 module:		花园验证器
 create_time:	2021-12-23 23:46:57
 author:		
 contact:		
*/

namespace app\api\validate\V1;
use think\validate;

class Garden extends validate {


	protected $rule = [
		'member_id'=>['require'],
		'plant_name'=>['require'],
		'img'=>['require'],
	];

	protected $message = [
		'member_id.require'=>'member_id不能为空',
		'plant_name.require'=>'plant_name不能为空',
		'img.require'=>'img不能为空',
	];

	protected $scene  = [
		'add'=>['member_id','plant_name','img'],
		'update'=>['member_id','plant_name','img'],
		'setRemind'=>['member_id'],
	];



}

