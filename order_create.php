<?php 
	require_once('/include/public.php');
	require_once('/public/class/db.php');
	require_once('/public/class/function.php');
	require_once('/include/check_user.php');
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>体育用品商城</title>
	<?php
		include_once('/include/head.php');
	?>
</head>
<style type="text/css">
	.address-pan-this{border: dashed 5px #e4393c;box-sizing: border-box;}
</style>
<body>
	<?php
		include_once('/include/header.php');
		$user_id = $_SESSION['user_id'];
		extract($_POST);
		$time = time();
		//生成订单编号
		$order_num = date("YmdHi",time()).$user_id.rand(0,9).rand(0,9);
		$order_info = [$user_id, $order_num, $consignee, $phone, $address, $express, $worth, $pay_type, $time];
	?>
	<div class="layui-container main-container">
		<?php 
			//录入订单数据
			if($_SQL->prepare("INSERT INTO main_order(id,user_id,order_num,consignee,phone,address,express,worth,pay_type,create_time,update_time,status)  VALUES(0,?,?,?,?,?,?,?,?,?,0,0)", $order_info)){
				$order_id = $_SQL->lastInsertId('order');

				//处理订单商品，并清除对应购物车记录
				foreach ($cart_id as $key => $value) {
					$cart_info = $_SQL->query("SELECT * FROM cart WHERE id = {$value}")[0];
					extract($cart_info);
					if($_SQL->exec("INSERT INTO sub_order(id, order_id, good_id, good_size, good_color, good_num) VALUES(0,{$order_id}, {$good_id}, '{$size}', '{$color}', {$num})")){
						$_SQL->exec("UPDATE cart SET delete_time = {$time} WHERE id = {$value} ");
						//库存减少、销量增加
						$_SQL->exec("UPDATE good SET inventory = inventory-{$num} ,sale_count=sale_count+{$num} WHERE id = {$value}");
					}
				}

		?>
		<h2 class="h2-title">成功提交订单</h2>

		<table class="layui-table">
			<thead>
				<tr><td colspan="2">订单详情</td></tr>
			</thead>
			<tbody>
				<tr>
					<td align="right">订单编号</td>
					<td><?php echo $order_num; ?></td>
				</tr>
				<tr>
					<td align="right">收货人</td>
					<td><?php echo $consignee; ?></td>
				</tr>
				<tr>
					<td align="right">收货地址</td>
					<td><?php echo $address; ?></td>
				</tr>
				<tr>
					<td align="right">联系方式</td>
					<td><?php echo $phone; ?></td>
				</tr>
				<tr>
					<td align="right">付款方式</td>
					<td><?php echo $pay_type; ?></td>
				</tr>
				<tr>
					<td align="right">快递方式</td>
					<td><?php echo $express; ?></td>
				</tr>
				<tr>
					<td align="right">订单创建时间</td>
					<td><?php echo date("Y-m-d H:i",$time); ?></td>
				</tr>
				<tr>
					<td align="right">总付费</td>
					<td style="font-size: 20px;color: #e4393c;">￥<?php echo $worth; ?></td>
				</tr>
			</tbody>
		</table>
		<?php
			}else{
				echo "<p class='tip-info'>订单生成失败</p>";
			}
		 ?>
	</div>

	<?php
		include_once('/include/footer.php');
	?>
</body>
	<?php
		include_once('/include/script.php');
	?>
</html>