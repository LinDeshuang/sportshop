<?php 
	require('/public/class/db.php');
	$code = '';
	$msg = '';
	session_start();
	if(!empty($_POST)){
		if(!isset($_SESSION['user'])) {
			$code = 40500;
			$msg  = '尚未登录或登录失效';	
		}else {
			$user_id = $_SESSION['user_id'];
			extract($_POST);
			if(empty($id) || empty($num) || empty($color) || empty($size)) {
				$code = 40100;
				$msg  = '参数错误';
			}else {
				$good_info = $_SQL->query("SELECT inventory FROM good WHERE id = {$id} AND delete_time=0 AND status=1");
				if(!$good_info){
					$code = 40100;
					$msg  = '商品已失效';
				}else if($num > $good_info[0]['inventory']){
					$code = 40100;
					$msg  = '商品库存不足，请刷新重试';
				}else{
					if($_SQL->rowCount("SELECT * FROM cart WHERE user_id = {$user_id} AND good_id = {$id} AND delete_time=0")){
						if($_SQL->exec("UPDATE cart SET num=num+{$num} WHERE user_id = {$user_id} AND good_id = {$id} AND delete_time=0 ")) {
							$code = 0;
							$msg  = '成功加入购物车';
						}else {
							$code = 40100;
							$msg  = '加入购物车失败，请稍候再试';
						}
					}else{
						$cart_info = [$user_id, $id, $num, $color, $size, time()];
						if($_SQL->prepare("INSERT INTO cart(id, user_id, good_id, num, color, size, create_time, delete_time) VALUES(0, ?, ?, ?, ?, ?, ?, 0)",$cart_info)) {
							$code = 0;
							$msg  = '成功加入购物车';
						}else {
							$code = 40100;
							$msg  = '加入购物车失败，请稍候再试';
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