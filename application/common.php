<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function getCatName($catId)
{
	if(!$catId){
		return ;
	}
	$cats = config('lanmu.list');
	return !empty($cats[$catId]) ? $cats[$catId] : '';
}
function isYesNo($str)
{
	return $str ? '<span style="color:green">是</span>' : '<span style="color:red;">否</span>';
}
function getStatus($id,$status)
{
	$controller = request()->controller();
	$sta = $status==1 ? 0 : 1 ;
	$url = url($controller.'/status',['id'=>$id,'status'=>$sta]);
	if($status==1){
		$str="<a href='javascript:;' titile='修改状态' status_url='".$url."' onclick='news_status(this)'><span class='label label-success radius'>正常</span></a>";
	}else if($status==0){
		$str="<a href='javascript:;' titile='修改状态' status_url='".$url."' onclick='news_status(this)'><span class='label label-danger radius'>待审</span></a>";
	}
	return $str;
}