<?php 
	require('/public/class/db.php');
	$code = '';
	$msg = '';
	session_start();
	if(!empty($_POST)){
		if(!isset($_SESSION['user'])) {
			$code = 40100;
			$msg  = '登录失效，修改失败';	
		}else {
			$user_id = $_SESSION['user_id'];
			extract($_POST);
			if(empty($address) || empty($consignee) || empty($phone) || empty($id)) {
				$code = 40100;
				$msg  = '参数错误';
			}else if(mb_strlen($address)>100){
				$code = 40100;
				$msg = '收货地址长度不能大于100';
			}else if(mb_strlen($consignee)>20){
				$code = 40100;
				$msg = '收货人姓名不能大于20';
			}else if(!preg_match("/^0?(13|14|15|17|18)[0-9]{9}$/", $phone)){
				$code = 40100;
				$msg = '手机号格式错误';
			}else {
				$address_info = [$address, $consignee, $phone];
				if($_SQL->prepare("UPDATE address SET address=?, consignee=?, phone=? WHERE id={$id} AND user_id={$user_id}",$address_info)) {
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