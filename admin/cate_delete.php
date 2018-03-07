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
				$cate_info = $_SQL->query("SELECT * FROM category WHERE id = {$id}");
				$time = time();
				if(!$cate_info){
					$code = 40100;
					$msg = '不存在该分类';
				}else {
					if($cate_info[0]['pid'] == 0){//一级分类，则删除该分类及其子分类
						if($_SQL->exec("UPDATE category SET delete_time={$time} WHERE id={$id} OR pid = {$id}")) {
							$code = 0;
							$msg  = '删除成功';
						}else {
							$code = 40100;
							$msg  = '删除失败，请稍候再试';
						}
					}else{
						if($_SQL->exec("UPDATE category SET delete_time={$time} WHERE id={$id}")) {
							$code = 0;
							$msg  = '删除成功';
						}else {
							$code = 40100;
							$msg  = '删除失败，请稍候再试';
						}
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