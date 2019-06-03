<?php

/**
 * @Author: lenovo
 * @Date:   2019-05-27 19:12:41
 * @Last Modified by:   lenovo
 * @Last Modified time: 2019-05-27 21:25:27
 */
namespace app\admin\validate;
use think\Validate;
class Admin extends Validate
{
	protected $rule = [
		'name' => 'require|length:1,10',
		'password' => 'require|length:6,20|confirm:password2',
	];
	protected $message = [
		'name.require' => '名称必须要加上哦',
		'password.require' => '密码必须要加上哦',
		'password.confirm' => '请确认密码一致',
		'password.length' => '密码长度在6到20之间',
	];
}