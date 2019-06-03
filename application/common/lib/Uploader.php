<?php

/**
 * @Author: lenovo
 * @Date:   2019-05-31 19:12:01
 * @Last Modified by:   lenovo
 * @Last Modified time: 2019-06-01 17:08:41
 */
namespace app\common\lib;
//引入鉴权类
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
class Uploader
{
	public static function image()
	{
		if(empty($_FILES['file']['tmp_name'])){
			exception('您提交的数据不合法',404);
		}
		//要上传的文件
		$file = $_FILES['file']['tmp_name'];
		//文件的后缀名
		$ext = explode('.',$_FILES['file']['name']);
		$ext = $ext[1];
		/*$pathinfo = pathinfo($_FILES['file']['name']);
		$ext = $pathinfo['extension'];
*/

		$config = config('qiniu');
		//构建鉴权对象
		$auth = new Auth($config['ak'],$config['sk']);
		//生成上传的token
		$token = $auth->uploadToken($config['bucket']);
		//上传到七牛后的文件名
		$key = date('Y')."/".date('m')."/".substr(md5($file),0,5).date('YmdHis').rand(0,9999).'.'.$ext;
		//初始化UploadManager()
		$uploadMgr = new UploadManager();
		list($ret,$err) = $uploadMgr->putFile($token,$key,$file); 
		if($err!==null){
			return null;
		}else{
			return $key;
		}
	}
}