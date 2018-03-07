<?php 
	$code = '';
	$msg = '';
	$path = '';
	session_start();
	if(!isset($_SESSION['admin'])){
		$code = 40100;
		$msg  = '未登录或登录失效';
	}else{
			if(empty($_FILES['image'])){
				$code = 40100;
				$msg  = '出错了，参数缺失，文件缺失';
			  }else {
				extract($_FILES['image']);
				$file_ext = strtolower(substr($name, strpos($name, '.')));
				//验证图片类型
				if($file_ext != '.jpg' && $file_ext != '.png' && $file_ext != '.gif' &&  $file_ext != '.jpeg' ){
					$code = 40100;
					$msg  = '上传失败，图片类型错误:'.$file_ext.'请上传jpg,jpeg,gif,png格式的图片';
				}else if($size >= 2*1024*1024){
				   //验证图片大小
					$code = 40100;
					$msg  = '上传失败，图片不能大于2M';
				}else {
				//保存图片到服务器
					date_default_timezone_set('PRC');
					$photo_name=date("Ymdhi").rand(0,9).rand(0,9).rand(0,9);
					$save_dir = '../upload/good/'.date("Ymdhi").'/';
					//创建图片目录
					if(!is_dir($save_dir)){
						mkdir($save_dir);
					}
					$save_path = $save_dir.$photo_name.$file_ext;
					if(move_uploaded_file($tmp_name, $save_path)){
						$time = time();
						$path = '/upload/good/'.date("Ymdhi").'/'.$photo_name.$file_ext;
					}else{
						$code = 40100;
						$msg  = '上传失败，请稍后重试';
					}
				}
			}
		}

	exit(json_encode([
		'errcode'=>$code,
		'errmsg'=>$msg,
		'path' => $path
	],JSON_UNESCAPED_UNICODE));
 ?>