<?php 
	require('public/class/db.php');
	$code = '';
	$msg = '';
	session_start();
	if(!empty($_POST)){
		if(!isset($_SESSION['user'])) {
			$code = 40100;
			$msg  = '登录失效，删除失败';	
		}else {
			$user_id = $_SESSION['user_id'];
			extract($_POST);
			if(empty($id) || !isset($id)) {
				$code = 40100;
				$msg  = '参数错误';
			}else if(!$_SQL->rowCount("SELECT * FROM address WHERE id = {$id}")){
				$code = 40100;
				$msg = '不存在该收货地址';
			}else {
				$time = time();
				if($_SQL->exec("UPDATE address SET delete_time={$time} WHERE id={$id}")) {
					$code = 0;
					$msg  = '删除成功';
				}else {
					$code = 40100;
					$msg  = '删除失败，请稍候再试';
				}
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