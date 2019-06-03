<?php

/**
 * @Author: lenovo
 * @Date:   2019-05-28 13:57:42
 * @Last Modified by:   lenovo
 * @Last Modified time: 2019-06-02 15:57:13
 */
namespace app\admin\controller;
use think\Controller;
class Base extends Controller
{
	public function _initialize()
	{
		$isLogin = $this->isLogin();
		if(!$isLogin){
			return $this->redirect('login/login');
		}
	}
	public function isLogin()
	{
		$login = session(config('session.session_name'),'',config('session.session_scope')); 
		if($login && $login->id){
			return true;
		}else{
			return false;
		}
	}
}