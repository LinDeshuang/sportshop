<?php 
	require('../public/class/db.php');
	$code = '';
	$msg = '';
	session_start();
	if(!empty($_POST)){
		if(!isset($_SESSION['admin'])) {
			$code = 40100;
			$msg  = '登录失效，修改失败';	
		}else {
			$admin_id = $_SESSION['admin_id'];
			$old_password = isset($_POST['old_password'])?md5(md5($_POST['old_password']).SEC):'';
			$password = isset($_POST['password'])?$_POST['password']:'';
			$confirm_password = isset($_POST['confirm_password'])?$_POST['confirm_password']:'';
			if(empty($old_password) || empty($password) || empty($confirm_password)) {
				$code = 40100;
				$msg  = '参数错误';
			}else if(!preg_match("/^[^\'\"]{6,20}$/", $password)){
				$code = 40100;
				$msg = '密码的长度必须在6-20之间,且不能包含引号';
			}else if($password!=$confirm_password) {
				$code = 40100;
				$msg  = '两次输入的密码不一样';
			}else if($_SQL->query("SELECT password FROM admin WHERE id = {$admin_id}")[0]['password'] != $old_password ) {
				$code = 40100;
				$msg  = '原密码错误，请重新输入';
			}else {
				$password = md5(md5($password).SEC);//加密处理
				if($_SQL->prepare("UPDATE admin set password = ? WHERE id = {$admin_id}",[$password])) {
					$code = 0;
					$msg  = '修改成功';
					unset($_SESSION['user']);
					setcookie(session_name(), session_id(), time() - 1, "/"); 
				}else {
					$code = 40100;
					$msg  = '修改失败，请稍候再试';
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