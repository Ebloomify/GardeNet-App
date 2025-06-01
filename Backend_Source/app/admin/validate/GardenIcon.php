<?php 
/*
 module:		花园图标设置验证器
 create_time:	2021-12-26 23:05:01
 author:		
 contact:		
*/

namespace app\admin\validate;
use think\validate;

class GardenIcon extends validate {


	protected $rule = [
		'name'=>['require','unique:garden_icon'],
		'icon'=>['require'],
		'type'=>['require'],
	];

	protected $message = [
		'name.require'=>'提醒名称不能为空',
		'name.unique'=>'提醒名称已经存在',
		'icon.require'=>'图标不能为空',
		'type.require'=>'类型不能为空',
	];

	protected $scene  = [
		'add'=>['name','icon'],
		'update'=>['name','icon'],
	];



}

