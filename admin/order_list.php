<?php 
	require_once('include/public.php');
	require_once('../public/class/db.php');
	require_once('../public/class/pages.php');
	$page = isset($_GET['page'])?$_GET['page']:1;
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>体育用品商城-后台管理</title>
	<?php 
		include_once('include/head.php');
 	?>
</head>
<body class="layui-layout-body">
	<div class="layui-layout layui-layout-admin">
	  	<?php 
	  		include_once('include/header.php');
	  		include_once('include/aside.php');
	  	 ?>
	 	<div class="layui-body">
	    <!-- 内容主体区域 -->
	    	<div style="padding: 15px;">
	    		<div class="layui-tab layui-tab-brief">
				  <ul class="layui-tab-title">
				    <li class="layui-this">所有订单</a></li>
				    <li ><a href="/admin/order_undeal.php?menu=3-2">未处理订单</a></li>
				    <li ><a href="/admin/order_deal.php?menu=3-3">已处理订单</a></li>
				  </ul>
				  <div class="layui-tab-content">
				  	<div class="layui-container">
				  		<?php 
				  			$count = $_SQL->rowCount("SELECT a.id,a.order_num,a.consignee,a.phone,a.address,a.express,a.worth,a.pay_type,a.create_time,a.status,b.account FROM main_order AS a LEFT JOIN user AS b ON a.user_id=b.id");
					    	$page_size = 10;
					    	$url = "/admin/order_list.php?menu=3-1&page={page}";
					    	$begin = $page_size*($page-1);
					   		$order_info = $_SQL->query("SELECT a.id,a.order_num,a.consignee,a.phone,a.address,a.express,a.worth,a.pay_type,a.create_time,a.status,b.account FROM main_order AS a LEFT JOIN user AS b ON a.user_id=b.id ORDER BY a.create_time DESC LIMIT {$begin},{$page_size}  ");
					  	 ?>
					  	 <table class="layui-table">
						  <thead>
						    <tr>
						      <th>订单编号</th>
						      <th>下单时间</th>
						      <th>用户</th>
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
						  	<?php 
						  		if(!$order_info){
						  			echo " <p class='tip-info'>暂无订单</p> ";
						  		}else{
						  			foreach ($order_info as $key => $value) {
						  				extract($value);		
						  	 ?>
						  	 <tr>
						      <td><?php echo $order_num; ?></td>
						      <td><?php echo date("Y-m-d H:i",$create_time); ?></td>
						      <td><?php echo $account; ?></td>
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
								  <a href="/admin/order_detail.php?id=<?php echo $id;?>" class="layui-btn layui-btn-sm layui-btn-primary"><i class="fas fa-eyes"></i>&nbsp;查看详情</a>						      	
						      </td>
						    </tr>
							<?php
									}
						  		}
							  ?>
						  </tbody>
						</table>
					  	<!--分页栏 -->
				     	<div class="page-bar">
				     		<?php 
				 		   		if($count > $page_size){
				   					$Page = new Pages($count,$page_size,$page,$url,1);
									echo $Page->p_output();
				   				}
				   		 	?>
				     	</div>
				  	</div>

				  </div>
				</div>
	    	</div>
	  	</div>
	  	<?php
	  		include_once('include/footer.php');
	  	?>
	</div>
</body>
	<?php 
		include_once('include/script.php');
	 ?>
</html>