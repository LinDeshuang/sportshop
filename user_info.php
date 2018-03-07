<?php 
	require('/public/class/db.php');
	$code = '';
	$msg = '';
	session_start();
	if(!empty($_POST)){
		if(!isset($_SESSION['admin'])) {
			$code = 40100;
			$msg  = '登录失效，保存失败';	
		}else {
			$user_id = $_SESSION['user_id'];
			$data = extract($_POST);
			if(mb_strlen($nickname)>20){
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
				$save_data = [$nickname,$gender,$email,$phone,$address];
				$res = $_SQL->prepare("UPDATE user SET nickname = ?, gender = ?, email = ?, phone = ?, address = ? WHERE id = {$user_id}",$save_data);
				if($res){
					$code = 0;
					$msg = '保存成功';
				}else{
					$code = 40100;
					$msg = '保存失败，稍后再试';

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