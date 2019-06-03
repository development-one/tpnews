<?php

/**
 * @Author: lenovo
 * @Date:   2019-05-29 15:47:12
 * @Last Modified by:   lenovo
 * @Last Modified time: 2019-06-03 14:06:51
 */
namespace app\admin\controller;
use app\common\lib\Uploader;
class News extends Base
{
	//新闻添加界面
	public function index()
	{
		return view('',[
			'lanmu' => config('lanmu.list')
		]);
	}
	//图片上传到本地
	/*public function add(){
		$file = request()->file('file');
		$info = $file->move('uploade');
		dump($info);
	}*/
	//新闻列表图片添加功能
	public function uploader()
	{
		try {
			$img = Uploader::image();
		} catch (Exception $e) {
			echo json_code(['status' => 0,"message"=>$e->getMessage()]);
		}
		if($img){
			$data = [
				'status' =>1,
				'message' =>'OK',
				'data' => config('qiniu.image_url').'/'.$img,
			];
			echo json_encode($data);
		}else{
			echo json_encode(['status'=>0,'message'=>上传失败]);
		}
	}
	//新闻添加功能
	public function addnews()
	{
		if(request()->isPost()){
			$data = input('post.');
			try {
				$data['status'] = 1;
				$id = model('AddNews')->add($data);
			} catch (Exception $e) {
				return $this->result('',0,'新增失败');
			}
			if($id){
				return $this->result(['jump_url'=>url('news/index')],1,'新增成功');
			}else{
				return $this->result('',0,'新增失败');
			}
		}
	}
	//新闻页面展示管理功能
	public function manage()
	{
		//新闻删除模型
		$data = input('get.');

		//搜索展示
		$whereData = [];
		if(!empty($data['start_time']) && !empty($data['end_time']) && $data['end_time'] > $data['start_time']){
			$whereData['create_time'] = [
				['gt',strtotime($data['start_time'])],
				['lt',strtotime($data['end_time'])]
			];
		}
		if(!empty($data['catid'])){
			$whereData['catid'] = intval($data['catid']);
		}
		if(!empty($data['title'])){
			$whereData['title'] = ['like',"%".$data['title']."%"];
		}
		$str = model('AddNews')->getNews($whereData);
		if(!$str){
			return ;
		}
		return view('',[
			'news'=>$str,
			'cats'=>config('lanmu.list'),
			'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
			'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
			'catid' => empty($data['catid']) ? '' : $data['catid'],
			'title' => empty($data['title']) ? '' : $data['title'],

		]);
	}
	
	//新闻删除功能
	public function delete($id)
	{
		if(!intval($id)){
			return $this->result('',0,'ID不合法');
		}
		try {
			$res = model('AddNews')->save(['status'=>-1],['id'=>$id]);
		} catch (Exception $e) {
			return $this->result('',0,$e->getMessage());
		}

		if($res){
			return $this->result(['jump_url'=>$_SERVER['HTTP_REFERER']],1,'删除成功');
		}
		return $this->result('',0,'删除失败');
	}
	//新闻状态修改功能
	public function status()
	{
		$data = input('param.');
		try {
			$res = model('AddNews')->save(['status'=>$data['status']],['id'=>$data['id']]);
		} catch (Exception $e) {
			return $this->result('',0,$e->getMessage());
		}

		if($res){
			return $this->result(['jump_url'=>$_SERVER['HTTP_REFERER']],1,'修改成功');
		}
		return $this->result('',0,'修改失败');
	}
}