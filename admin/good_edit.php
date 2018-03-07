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
				$good_info = $_SQL->query("SELECT * FROM good WHERE id={$id}");
				if(!$good_info){
					$code = 40100;
					$msg  = '不存在该商品';
				}else{
					$update_info = [
					$good_name,
				    $price,
					$intro,
					$inventory,
					$pid.'-'.$cid,
					json_encode($size),
					json_encode($color),
					json_encode($photo)
					];
					if($_SQL->prepare("UPDATE good SET  good_name=?, price=?, intro=?, inventory=?, cate_id=?, size=?, color=?, photo=? WHERE id={$id}",$update_info)) {
						$code = 0;
						$msg  = '保存成功';
						//删除无用的图片
						foreach (json_decode($good_info[0]['photo'],true) as $key => $value) {
							$is_change = 1;
							foreach ($photo as $k => $v) {
								if($value == $v){
									$is_change = 0;
									break;
								}
							}
							if($is_change){
								@unlink('..'.$value);
							}
						}
					}else {
						$code = 40100;
						$msg  = '保存失败，请稍候再试';
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