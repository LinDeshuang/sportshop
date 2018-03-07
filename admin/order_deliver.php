<?php 
	require('../public/class/db.php');
	$code = '';
	$msg = '';
	session_start();
	if(!empty($_POST)){
		if(!isset($_SESSION['admin'])) {
			$code = 40100;
			$msg  = '登录失效，发货失败';	
		}else {
			extract($_POST);
			if(empty($id) || !isset($id)) {
				$code = 40100;
				$msg  = '参数错误';
			}else if(!$_SQL->rowCount("SELECT * FROM main_order WHERE id = {$id}")){
				$code = 40100;
				$msg = '不存在该订单';
			}else{
					$time = time();
					if($_SQL->exec("UPDATE main_order SET status='1', update_time = {$time} WHERE id={$id}")) {
						$code = 0;
						$msg  = '发货成功';
					}else {
						$code = 40100;
						$msg  = '发货失败，请稍候再试';
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