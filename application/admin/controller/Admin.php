<?php

/**
 * @Author: lenovo
 * @Date:   2019-05-27 13:42:12
 * @Last Modified by:   lenovo
 * @Last Modified time: 2019-05-28 14:13:07
 */
namespace app\admin\controller;

class Admin extends Base
{
	public function addAdmin(){
		if(request()->isPost()){
			$data = input('post.');
			$validate = validate('Admin');
			if(!$validate->check($data)){
				$this->error($validate->getError());
			}else{
				$data['password'] = md5($data['password'].'_#sing_ty');
				$data['status'] = 1;
				try {
					$id = model('AddAdmin')->add($data);
				} catch (Exception $e) {
					$this->error($e->getMessage());
				}
				if($id){
					$this->success("id".$id."的用户数据添加成功");
				}else{
					$this->error('用户添加失败');
				}
			}
		}else{
			return view();
		}
	}
}