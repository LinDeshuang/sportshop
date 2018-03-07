<?php 
	require('../public/class/db.php');
	$code = '';
	$msg = '';
	session_start();
	if(!empty($_POST)){
		if(!isset($_SESSION['admin'])) {
			$code = 40100;
			$msg  = '登录失效，添加失败';	
		}else {
			extract($_POST);
			if(mb_strlen($good_name)>30){
				$code = 40100;
				$msg = '商品长度不能大于30';

			}else if(!preg_match("/^\d{1,10}(\.\d{1,2})?$/", $price)){
				$code = 40100;
				$msg = '商品价格过大或格式错误';
			}else if(mb_strlen($intro)>200){
				$code = 40100;
				$msg = '商品简介长度不能大于200';
			}else if($inventory <= 0 || $inventory > 9999999) {
				$code = 40100;
				$msg  = '库存数量错误';
			}else if(empty($size)) {
				$code = 40100;
				$msg  = '未填写商品规格';
			}else if($cid=='' || $pid=='') {
				$code = 40100;
				$msg  = '未选择分类';
			}else if(empty($color)) {
				$code = 40100;
				$msg  = '未填写商品颜色';
			}else if(empty($photo)) {
				$code = 40100;
				$msg  = '未上传商品图片';
			}else {
				$good_info = [
					$good_name,
				    $price,
					$intro,
					$inventory,
					$pid.'-'.$cid,
					json_encode($size),
					json_encode($color),
					json_encode($photo),
					time()
				];
				if($_SQL->prepare("INSERT INTO good(id, good_name, price, intro, inventory, cate_id, size, color, photo, create_time, delete_time, status, sale_count) VALUES(0,?,?,?,?,?,?,?,?,?,0,1,0)",$good_info)) {
					$code = 0;
					$msg  = '添加成功';
				}else {
					$code = 40100;
					$msg  = '添加失败，请稍候再试';
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