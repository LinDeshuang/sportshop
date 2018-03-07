<?php 
	$code = '';
	$msg = '';
	session_start();
	if(!empty($_POST)){
		if(!isset($_SESSION['admin'])){
			$code = 40100;
			$msg  = '未登录或登录失效';
		}else{
			$data = extract($_POST);
			//密码处理
			if(unlink('..'.$path)){
				$code = 0;
				$msg = '删除成功';
			}else{
				$code = 40100;
				$msg = '删除失败';
			}
		}
		
	}else{
		$code = 40000;
		$msg  = '方法错误，请用post方法';
	}

	exit(json_encode([
		'errcode'=>$code,
		'errmsg'=>$msg
	],JSON_UNESCAPED_UNICODE));
 ?>