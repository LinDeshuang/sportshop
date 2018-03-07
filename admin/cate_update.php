<?php 
	require('../public/class/db.php');
	$code = '';
	$msg = '';
	session_start();
	if(!empty($_POST)){
		if(!isset($_SESSION['admin'])) {
			$code = 40100;
			$msg  = '登录失效，保存失败';	
		}else {
			extract($_POST);
			if(empty($cate_name) || $pid === null || empty($id)) {
				$code = 40100;
				$msg  = '参数错误';
			}else if($pid !=0 && !$_SQL->rowCount("SELECT * FROM category WHERE id = $pid")) {
				$code = 40100;
				$msg  = '父级分类不存在';
			}else if(mb_strlen($cate_name) > 20) {
				$code = 40100;
				$msg  = '分类名长度不能大于20';
			}else if($_SQL->rowCount("SELECT * FROM category WHERE cate_name = '{$cate_name}' AND delete_time!=0")) {
				$code = 40100;
				$msg  = '该分类已存在';
			}else {
				$cate_info = [$pid, $cate_name, time()];
				if($_SQL->prepare("UPDATE category SET pid = ?, cate_name = ? ,create_time = ? WHERE id = {$id}" ,$cate_info)) {
					$code = 0;
					$msg  = '保存成功';
				}else {
					$code = 40100;
					$msg  = '保存失败，请稍候再试';
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