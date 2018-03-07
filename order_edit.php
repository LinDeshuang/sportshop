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
		$user_info = $_SQL->query("SELECT * FROM user WHERE id = {$user_id}")[0];
		$address_info = $_SQL->query("SELECT * FROM address WHERE user_id={$user_id} AND delete_time=0 ORDER BY id DESC");
		$cart_id_post = $_POST['cart_id'];
		$cart_id_set = implode($cart_id_post, ',');
	?>
	<div class="layui-container main-container">
		<?php 
			$cart_info = $_SQL->query("SELECT cart.id as cart_id ,good_id, price, num, cart.color, cart.size,good_name,photo,inventory FROM cart RIGHT JOIN good on cart.good_id = good.id WHERE cart.id in ({$cart_id_set}) AND cart.delete_time = 0 AND cart.user_id = {$user_id}");
		 ?>
		<h2 class="h2-title">结算</h2>
		<?php 
			if(!$cart_info){
				echo "<p class='tip-info'>商品信息出错</p>";
			}else{
		 ?>
		 <form class="layui-form" action="/order_create.php" method="post">
		<table class="layui-table" style="text-align: center;">
			
			<thead>
				<tr>
					<td>商品</td>
					<td>名称</td>
					<td>颜色</td>
					<td>规格</td>
					<td>单价</td>
					<td>数量</td>
					<td>小计</td>
				</tr>
			</thead>
			<tbody>
		 	<?php
		 		$total = 0;
		 		foreach ($cart_info as $key => $value) {
		 		 	extract($value);
		 		 	$photo = json_decode($photo,true)[0];
		 		 	if($num > $inventory){
		 		 		echo "<tr><td colspan='9'><p class='tip-info'>商品“{$good_name}”库存不足，请返回购物车重新选择数量</p></td><tr>";
		 		 	}else{
		 	?>
		 		<tr>
		 			<td><a href="/good_detail.php?id=<?php echo $good_id; ?>" target="_blank"> <img src="<?php echo $photo; ?>"></a></td>
		 			<td><?php echo $good_name; ?><input type="hidden" name="cart_id[]" value="<?php echo $cart_id; ?>"></td>
		 			<td><?php echo $color; ?></td>
		 			<td><?php echo $size; ?></td>
		 			<td>￥<?php echo $price; ?></td>
		 			<td><?php echo $num; ?></div>
		 			</td>
		 			<td>￥<?php echo round($num*$price); $total=$total+round($num*$price); ?></td>
		 		</tr>
			 	<?php 
			 		 }
			 		} 
			 	 ?> 
		 	 	<tr>
		 	 		<td colspan="9" align="RIGHT">
		 	 			<p style="margin: 10px;padding: 5px;">总计 : <span id="total" style="font-size: 20px;color: #e4393c;">￥<?php echo $total; ?></span><input type="hidden" name="worth" value="<?php echo $total; ?>"></p>
		 	 		</td>
		 	    </tr>
			</tbody>
		</table>
		<table class="layui-table">
			<tr>
				<td align="RIGHT">收货人</td>
				<td><input class="layui-input" type="text" name="consignee" lay-verify="require|consignee" required value="<?php echo $user_info['nickname']; ?>"></td>
			</tr>
			<tr>
				<td  align="RIGHT">手机号</td>
				<td><input class="layui-input" type="text" name="phone" lay-verify="require|phone" required value="<?php echo $user_info['phone']; ?>"></td>
			</tr>
			<tr>
				<td  align="RIGHT">收货地址</td>
				<td><input class="layui-input" type="text" name="address" lay-verify="require|address" required value="<?php echo $user_info['address']; ?>"></td>
			</tr>
			<tr>
				<td align="RIGHT"><p>选择收货信息</p><p class="layui-badge">不选则使用默认收货信息</p></td>
				<td>
					<div class="layui-row" style="margin: 30px auto;">
	    				<?php
	    				if(!$address_info){
	    					echo "您还没有添加收货地址，快去添加吧";
	    				}else{

	    					foreach ($address_info as $key => $value) {
	    						extract($value);
	    						if($key != 0 && $key%2 == 0 ){
	    							echo "</div><div class='layui-row'>";
	    						}
	    				?>

	    				<div class="layui-col-xs5 layui-col-sm5 layui-col-md5 address-pan" style="cursor: pointer;background-color: #efefef;">
	    					<p>收货地址：<span><?php echo $address; ?></span> </p>
	    					<p>收货人：<span><?php echo $consignee; ?></span> </p>
	    					<p>联系方式：<span><?php echo $phone; ?></span> </p>
	    				</div>

	    				<?php
	    					}		    					
	    				} 
	    				 ?>
	    			</div>
				</td>
			</tr>
			<tr>
				<td align="RIGHT">快递方式</td>
				<td>
					<input type="radio" name="express" value="顺丰" title="顺丰" checked>
					<input type="radio" name="express" value="圆通" title="圆通">
					<input type="radio" name="express" value="天天" title="天天">
      				<input type="radio" name="express" value="韵达" title="韵达">
      			</td>
			</tr>
			<tr>
				<td align="RIGHT">支付方式</td>
				<td>
					<input type="radio" name="pay_type" value="支付宝" title="支付宝" checked>
      				<input type="radio" name="pay_type" value="微信" title="微信" >
      				<input type="radio" name="pay_type" value="货到付款" title="货到付款" >
      			</td>
			</tr>
			<tr>
				<td colspan="2" align="RIGHT">
					<button type="submit" lay-submit class="layui-btn layui-btn-md layui-btn-danger">提交订单</button>
				</td>
			</tr>
		</table>
	</form>
		<?php 
				
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
	<script type="text/javascript">
		$(function(){
			//选择收货信息
			$('.address-pan').each(function(index){
				$(this).click(function(){
					var address = $(this).children().eq(0).find('span').text();
					var consignee = $(this).children().eq(1).find('span').text();
					var phone = $(this).children().eq(2).find('span').text();
					$('input[name=consignee]').val(consignee);
					$('input[name=address]').val(address);
					$('input[name=phone]').val(phone);
					$('.address-pan').each(function(Ind){
						$(this).removeClass('address-pan-this');
					});
					$(this).addClass('address-pan-this');
				});
			});
		});
	</script>
</html>