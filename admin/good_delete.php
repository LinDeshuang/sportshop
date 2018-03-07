<?php 
	require('../public/class/db.php');
	$code = '';
	$msg = '';
	session_start();
	if(!empty($_POST)){
		if(!isset($_SESSION['admin'])) {
			$code = 40100;
			$msg  = '登录失效，删除失败';	
		}else {
			extract($_POST);
			if(empty($id) || !isset($id)) {
				$code = 40100;
				$msg  = '参数错误';
			}else{
				$good_info = $_SQL->query("SELECT * FROM good WHERE id = {$id}");
				$time = time();
				if(!$good_info){
					$code = 40100;
					$msg = '不存在该商品';
				}else {
						if($_SQL->exec("UPDATE good SET delete_time={$time} WHERE id={$id}")) {
							$code = 0;
							$msg  = '删除成功';
							//商品删除成功，删除商品图片
							$photo = json_decode($good_info[0]['photo'],true);
							foreach ($photo as $value) {
								@unlink('..'.$value);
							}
						}else {
							$code = 40100;
							$msg  = '删除失败，请稍候再试';
						}
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