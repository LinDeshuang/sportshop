<?php 
	require_once('/include/public.php');
	require_once('../public/class/db.php');

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>体育用品商城-后台管理</title>
	<?php 
		include_once('/include/head.php');
 	?>
</head>
<body class="layui-layout-body">
	<div class="layui-layout layui-layout-admin">
	  	<?php 
	  		include_once('/include/header.php');
	  		include_once('/include/aside.php');
	  	 ?>
	 	<div class="layui-body">
	    <!-- 内容主体区域 -->
	    	<div style="padding: 15px;">
	    		<div class="layui-tab layui-tab-brief">
				  <ul class="layui-tab-title">
				    <li><a href="/admin/order_list.php?menu=3-1">所有订单</a></li>
				    <li><a href="/admin/order_deal.php?menu=3-2">未处理订单</a></li>
				    <li><a href="/admin/order_deal.php?menu=3-2">已处理订单</a></li>
				    <li class="layui-this">订单详情</li>
				  </ul>
				  <div class="layui-tab-content">
				  	<div class="layui-container">
				  		<?php 
				  			if(!isset($_GET['id'])){
								header('Location:/admin/order_list.php?menu=3-1');
							}
							$order_id = $_GET['id'];

							$order_info = $_SQL->query("SELECT a.id,a.order_num,a.consignee,a.phone,a.address,a.express,a.worth,a.pay_type,a.create_time,a.status,a.update_time,b.account FROM main_order AS a LEFT JOIN user AS b ON a.user_id=b.id WHERE a.id = {$order_id}")[0];

							extract($order_info);
					  	 ?>
					  	 <table class="layui-table"  style="text-align: center;">
						  <thead>
						  	<tr><th colspan="2"  style="text-align: center;">订单信息</th></tr>
						  </thead>
						  <tbody>
						  	<tr>
						  		<td>订单编号</td>
						  		<td><?php echo $order_num; ?></td>
						  	</tr>
						  	<tr>
						  		<td>下单时间</td>
						  		<td><?php echo date("Y-m-d H:i",$create_time); ?></td>
						  	</tr>
						  	<tr>
						  		<td>用户</td>
						  		<td><?php echo $account; ?></td>
						  	</tr>
						  	<tr>
						  		<td>收货人</td>
						  		<td><?php echo $consignee; ?></td>
						  	</tr>
						  	<tr>
						  		<td>收货地址</td>
						  		<td><?php echo $address; ?></td>
						  	</tr>
						  	<tr>
						  		<td>联系方式</td>
						  		<td><?php echo $phone; ?></td>
						  	</tr>
						  	<tr>
						  		<td>快递方式</td>
						  		<td><?php echo $express; ?></td>
						  	</tr>
						  	<tr>
						  		<td>支付方式</td>
						  		<td><?php echo $express; ?></td>
						  	</tr>
						  	<tr>
						  		<td>订单付费</td>
						  		<td><?php echo $worth; ?></td>
						  	</tr>
						  	<tr>
						  		<td>订单状态</td>
						  		<td><?php switch ($status) {
						      	case '1':
						      		echo "已发货，时间：".date("Y-m-d H:i",$update_time);
						      		break;
						      	case '2':
						      		echo "已收货，时间：".date("Y-m-d H:i",$update_time);
						      		break;
						      	default:
						      		echo "未处理";
						      		break;
						      } ?></td>
						  	</tr>
						  </tbody>
						</table>
						<?php 
							$good_info = $_SQL->query("SELECT sub_order.id as sub_order_id ,good_id, price, good_num, good_color, good_size,good_name,photo FROM sub_order RIGHT JOIN good on sub_order.good_id = good.id WHERE sub_order.order_id = {$order_id} ORDER BY sub_order.id DESC");
							$total = 0;

						 ?>
						 <p class='tip-info'>订单商品</p>
						<table class="layui-table"   style="text-align: center;">
							<thead>
								<tr>
									<td>商品</td>
									<td>名称</td>
									<td>颜色</td>
									<td>规格</td>
									<td>数量</td>
									<td>单价</td>
									<td>小计</td>
								</tr>
							</thead>
							<tbody>
								<?php 
									foreach ($good_info as $key => $value) {
										extract($value);
										$photo = json_decode($photo,true)[0];
									
								 ?>
								 <tr>
								 	<td><img src="<?php echo $photo; ?>"></td>
								 	<td><?php echo $good_name; ?></td>
								 	<td><?php echo $good_color; ?></td>
								 	<td><?php echo $good_size; ?></td>
								 	<td><?php echo $good_num; ?></td>
								 	<td>￥<?php echo $price; ?></td>
								 	<td>￥<?php echo round($good_num*$price);$total+=round($good_num*$price); ?></td>
								 </tr>
								
								<?php 
									}
								 ?>
								 <tr><td colspan="7" align="right">总计：￥<?php echo $total; ?></td></tr>
								 <?php 
								 	if($status != '1'){
								 ?>
								 <tr><td colspan="7" align="center"><button class="layui-btn layui-btn-md layui-btn-normal" id="deliver-btn" data-id="<?php echo $order_id ?>">发货</button></td></tr>
								 <?php

								 	}
								  ?>
							</tbody>
						</table>
				  	  </div>

				  </div>
				</div>
	    	</div>
	  	</div>
	  	<?php
	  		include_once('/include/footer.php');
	  	?>
	</div>
</body>
	<?php 
		include_once('/include/script.php');
	 ?>
	 <script type="text/javascript">
	 	<?php 
		 	if($status != '1'){
		 ?>
		 $(function(){
			 	$('#deliver-btn').click(function(){
		 		var orderId = $(this).attr('data-id');
		 		$.ajax({
		 			url: '/admin/order_deliver.php',
		 			data: {
		 				id : orderId
		 			},
		 			method: 'post',
		 			dataType: 'json',
		 			success:function(ret){
		 				if(ret.errcode==0){
		 					layer.msg(ret.errmsg,{icon:1});
		 					setTimeout(function(){window.location.reload();},1000);
		 				}else{
		 					layer.msg(ret.errmsg,{icon:5});
		 				}
		 			},
		 			error:function(){
		 				layer.msg('网络有点问题，请稍后再试',{icon:5});
		 			}
		 		})
		 	});
		 });
	 	
	 	<?php
	 	}
	 	?>
	 </script>
</html>