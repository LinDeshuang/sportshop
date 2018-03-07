<?php 
	require('../public/class/db.php');
	$code = '';
	$msg = '';
	session_start();
	$verify_code_sess = strtolower($_SESSION['verify_code']);
	if(!empty($_POST)){
		$data = extract($_POST);
		//密码处理
		$password = $password = md5(md5($password).SEC);
		if ($verify_code_sess != strtolower($verify_code)) {
			$code = 40100;
			$msg = '验证码错误';
		}else if (!($admin_info = $_SQL->query("SELECT * FROM admin WHERE name = '{$name}' AND password = '{$password}'"))) {
			$code = 40100;
			$msg = '账号或密码错误，请重新输入';
		}else{
			$life_time = 3600*4;//4小时有效
			$_SESSION['admin'] = $admin_info[0]['name'];
			$_SESSION['admin_id'] = $admin_info[0]['id'];
			setcookie(session_name(), session_id(), time() + $life_time, "/"); 
			$code = 0;
			$msg  = '登录成功';
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