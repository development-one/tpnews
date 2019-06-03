<?php

/**
 * @Author: lenovo
 * @Date:   2019-05-27 20:35:53
 * @Last Modified by:   lenovo
 * @Last Modified time: 2019-06-02 13:37:26
 */
namespace app\admin\model;
class AddNews extends Base
{
	public function getNews($abc)
	{
		$data = $abc;
		$data['status'] = ['neq',config('code.status_delete')];
		$order = ['id' => 'desc'];

		//查询
		$result = $this->where($data)->order($order)->paginate(6,false,['query'=>input('param.')]);
		return $result;
	}
}