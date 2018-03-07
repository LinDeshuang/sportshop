<?php 
	require_once('/include/public.php');
	require_once('/public/class/db.php');
	require_once('/public/class/function.php');
	require_once('/include/check_user.php');
	//获取当前页号
	$page = isset($_GET['page'])?$_GET['page']:1;
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>体育用品商城</title>
	<?php
		include_once('/include/head.php');
	?>
</head>
<body>
	<?php
		include_once('/include/header.php');
		$user_id = $_SESSION['user_id'];

	?>
	<div class="layui-container main-container">
		<?php 
			$count = $_SQL->rowCount("SELECT a.id,a.order_num,a.consignee,a.phone,a.address,a.express,a.worth,a.pay_type,a.create_time,a.status FROM main_order AS a LEFT JOIN user AS b ON a.user_id=b.id WHERE a.user_id={$user_id}");
	    	$page_size = 10;
	    	$url = "/admin/order_list.php?menu=3-1&page={page}";
	    	$begin = $page_size*($page-1);
	   		$order_info = $_SQL->query("SELECT a.id,a.order_num,a.consignee,a.phone,a.address,a.express,a.worth,a.pay_type,a.create_time,a.status FROM main_order AS a LEFT JOIN user AS b ON a.user_id=b.id WHERE a.user_id={$user_id} ORDER BY a.create_time DESC LIMIT {$begin},{$page_size}  ");
		 ?>
		<h2 class="h2-title">我的订单</h2>
			<?php 
				if(!$order_info){
					echo "<p class='tip-info'>暂无订单信息，您还没有进任何下单操作</p>";
				}else{
			?>
			<table class="layui-table">
				<thead>
					<tr>
					  <th>订单编号</th>
				      <th>下单时间</th>
				      <th>收货人</th>
				      <th>收货地址</th>
				      <th>联系方式</th>
				      <th>快递方式</th>
				      <th>支付方式</th>
				      <th>订单付费</th>
				      <th>订单状态</th>
				      <th>操作</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($order_info as $key => $value): extract($value);?>
					<tr>
				      <td><?php echo $order_num; ?></td>
				      <td><?php echo date("Y-m-d H:i",$create_time); ?></td>
				      <td><?php echo $consignee; ?></td>
				      <td><?php echo $address; ?></td>
				      <td><?php echo $phone; ?></td>
				      <td><?php echo $express; ?></td>
				      <td><?php echo $pay_type; ?></td>
				      <td>￥<?php echo $worth; ?></td>
				      <td><?php switch ($status) {
				      	case '1':
				      		echo "已发货";
				      		break;
				      	case '2':
				      		echo "已收货";
				      		break;
				      	default:
				      		echo "未处理";
				      		break;
				      } ?></td>
				      <td>
						  <a href="/order_detail.php?id=<?php echo $id;?>" class="layui-btn layui-btn-sm layui-btn-primary"><i class="fas fa-eyes"></i>&nbsp;查看详情</a>						      	
				      </td>
				    </tr>
				<?php endforeach ?>
				</tbody>
			</table>
			<?php
				}
			 ?> 
		<!--分页栏 -->
	 	<div class="page-bar">
	 		<?php 
		   		if($count > $page_size){
					$Page = new Pages($count,$page_size,$page,$url,1);
				echo $Page->p_output();
				}
			 ?>
	 	</div>
	  	<h2 class="h2-title">新品推荐</h2>
		<div class="layui-row" style="margin: 20px auto;">
		<?php 
	   		$com_good_info = $_SQL->query("SELECT * FROM good WHERE delete_time = 0 ORDER BY create_time DESC LIMIT 4");
	   			foreach ($com_good_info as $key => $value) {
	   				extract($value);
	   				$photo = json_decode($photo,true)[0];
	   				$cate = explode('-', $cate_id)[1];
	   		
	  	 ?>

	  	 		<?php 
	  	 			if($key!=0 && $key%4==0){
	  	 				echo "</div><div class='layui-row'>";
	  	 			}
	  	 		 ?>
	  	 		<div class="layui-col-xs3 layui-col-sm3 layui-col-md3">
	  	 			<div class="good-info-card">
	  	 				<a href="/good_detail.php?id=<?php echo $id;?>" class="good-img"  target="_blank"><img src="<?php echo $photo; ?>"></a>
	  	 				<p class="good-price">
	  	 					<?php echo '￥'.$price ?>
	  	 					<span>[<?php echo "销量：{$sale_count}";  ?>]</span>
	  	 				</p>
	  	 				<a class="good-name" href="/good_detail.php?id=<?php echo $id;?>"  target="_blank"><?php echo "[{$cate}]{$good_name}"; ?></a>
	  	 				<div class="good-btn">
	  	 					<a href="/good_detail.php?id=<?php echo $id;?>"  target="_blank" class="layui-btn layui-btn-sm layui-btn-danger " ><i class="fas fa-cart-plus" ></i>&nbsp;加入购物车</a>
	  	 				</div>
	  	 			</div>
	  	 		</div>
	  	 
	  	 <?php 
				}
	  	  ?>	
	  	</div>
	</div>

	<?php
		include_once('/include/footer.php');
	?>
</body>
	<?php
		include_once('/include/script.php');
	?>
</html>