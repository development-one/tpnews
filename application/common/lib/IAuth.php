<?php

/**
 * @Author: lenovo
 * @Date:   2019-05-28 11:19:19
 * @Last Modified by:   lenovo
 * @Last Modified time: 2019-05-28 13:03:59
 */
namespace app\common\lib;
class IAuth
{
	public static function setPassword($data)
	{
		return md5($data.config('app.password_pre'));
	}
}