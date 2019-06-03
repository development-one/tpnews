<?php

/**
 * @Author: lenovo
 * @Date:   2019-05-27 20:35:53
 * @Last Modified by:   lenovo
 * @Last Modified time: 2019-06-01 15:56:38
 */
namespace app\admin\model;
use think\Model;
class Base extends Model
{
	protected $autoWriteTimestamp = true;

	public function add($data)
	{
		if(!is_Array($data)){
			exception('传递数据不合法');
		}
		$this->allowField(true)->save($data);
		return $this->id;
		
	}
}