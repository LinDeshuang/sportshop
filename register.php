<?php 
	require('public/class/db.php');
	$code = '';
	$msg = '';
	session_start();
	$verify_code_sess = strtolower($_SESSION['verify_code']);
	if(!empty($_POST)){
		$data = extract($_POST);
		if($verify_code_sess != strtolower($verify_code)){
			$code = 40100;
			$msg = '验证码错误';
		}else if(!preg_match("/^\w{8,20}$/", $account)){
			$code = 40100;
			$msg = '账号必须是长度8-20之间的数字和字母';
		}else if($_SQL->rowCount("SELECT * FROM user WHERE account = '{$account}'")){
			$code = 40100;
			$msg = '账号已存在';
		}else if(!preg_match("/^[^\'\"]{6,20}$/", $password)){
			$code = 40100;
			$msg = '密码的长度必须在6-20之间,且不能包含引号';
		}else if($password!=$confirm_password){
			$code = 40100;
			$msg = '两次输入的密码不一致';
		}else if(mb_strlen($nickname)>20){
			$code = 40100;
			$msg = '昵称长度不能大于20';
		}else if($_SQL->rowCount("SELECT * FROM user WHERE nickname = '{$nickname}'")){
			$code = 40100;
			$msg = '昵称已存在';
		}else if(!preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $email)){
			$code = 40100;
			$msg = '邮箱格式错误';
		}else if(!preg_match("/^0?(13|14|15|17|18)[0-9]{9}$/", $phone)){
			$code = 40100;
			$msg = '手机号格式错误';
		}else if(mb_strlen($address)>100){
			$code = 40100;
			$msg = '收货地址长度不能大于100';
		}else {
			$time = time();//注册时间
			$password = md5(md5($password).SEC);//密码接上秘钥并加密
			$register_data = [$account,$password,$nickname,$gender,$email,$phone,$address,$time,1,0];
			$res = $_SQL->prepare("INSERT INTO user(id,account,password,nickname,gender,email,phone,address,create_time,status,delete_time) VALUES(0,?,?,?,?,?,?,?,?,?,?)",$register_data);
			if($res){
				$code = 0;
				$msg = '注册成功';
			}else{
				$code = 40100;
				$msg = '注册失败，稍后再试';

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