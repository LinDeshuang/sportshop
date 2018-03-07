<?php 
	require('/public/class/db.php');
	$code = '';
	$msg = '';
	session_start();
	if(!empty($_POST)){
		if(!isset($_SESSION['user'])) {
			$code = 40100;
			$msg  = '登录失效，操作失败';	
		}else {
			extract($_POST);
			if(!isset($action) || !isset($id) || empty($id) || empty($action)){
				$code = 40100;
				$msg  = '参数错误，操作失败';
			}else{
				switch ($action) {
					case 'del':
					//删除购物车记录
						$time = time();
						if($_SQL->exec("UPDATE cart SET delete_time = {$time} WHERE id = {$id}")){
							$code = 0;
							$msg  = '操作成功';
						}else{
							$code = 40100;
							$msg  = '操作失败';
						}
						break;
					case 'number':
					//更新商品数量
						if(!isset($num) || empty($num)){
							$code = 40100;
							$msg  = '参数错误，操作失败';
						}else{
							if($_SQL->exec("UPDATE cart SET num = {$num} WHERE id = {$id}")){
								$code = 0;
								$msg  = '操作成功';
							}else{
								$code = 40100;
								$msg  = '操作失败';
							}
						}
						
						break;
					
					default:
						$code = 40100;
						$msg  = 'action不存在，操作失败';
						break;
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