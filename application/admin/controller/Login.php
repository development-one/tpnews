<?php

/**
 * @Author: lenovo
 * @Date:   2019-05-26 10:42:19
 * @Last Modified by:   lenovo
 * @Last Modified time: 2019-05-28 14:10:55
 */
namespace app\admin\controller;

use app\common\lib\IAuth;
class Login extends Base
{
	public function _initialize(){
	}
	public function login()
	{
		$isLogin = $this->isLogin();
		if($isLogin){
			$this->redirect('index/index');
		}
		return view();
	}
	public function check()
	{
		if(request()->isPost()){
			$data = input('post.');
			//获取数据库数据
			try {
				$user = model('AddAdmin')->get(['name'=>$data['name']]);
			} catch (Exception $e) {
				$this->error($e->getMessage());
			}

			//登录验证
			if(!captcha_check($data['code'])){
				$this->error("验证码不正确");
			}
			if(!$user || $user->status != 1){
				$this->error('用户不存在');
			}
			if(IAuth::setPassword($data['password']) != $user['password']){
				$this->error('密码不正确');
			}

			// 更新数据
			$updata = [
				'last_login_time' => time(),
				'last_login_ip' => request()->ip(),
 			];
 			try {
 				model('AddAdmin')->allowField(true)->save($updata,[ 'id'=> $user->id ]);
 			} catch (Exception $e) {
 				$this->error($e->getMessage());
 			}
 			session(config('session.session_name'),$user,config('session.session_scope'));
 			$this->success('登录成功','index/index');
		}else{
			$this->error("请求不合法");
		}
	}
	public function loginout()
	{
		session(null,config('session.session_scope'));
		$this->redirect('login/login');
	}
}