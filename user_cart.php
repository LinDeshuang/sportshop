<?php 
	require_once('include/public.php');
	require_once('public/class/db.php');
	require_once('public/class/function.php');
	require_once('include/check_user.php');
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>体育用品商城</title>
	<?php
		include_once('include/head.php');
	?>
</head>
<body>
	<?php
		include_once('include/header.php');
		$user_id = $_SESSION['user_id'];

	?>
	<div class="layui-container main-container">
		<?php 
			$cart_info = $_SQL->query("SELECT cart.id as cart_id ,good_id, price, num, cart.color, cart.size,good_name,photo FROM cart RIGHT JOIN good on cart.good_id = good.id WHERE cart.delete_time = 0 AND cart.user_id = {$user_id} ORDER BY cart.id DESC");
		 ?>
		<h2 class="h2-title">我的购物车</h2>
		<?php 
			if(!$cart_info){
				echo "<p class='tip-info'>购物车空空的，快去买买买吧</p>";
			}else{
		 ?>
		<form method="post" action="/order_edit.php" id="cartForm">
		<table class="layui-table" style="text-align: center;">
			
			<thead>
				<tr>
					<td><input type="checkbox" id="checkAll">全选</td>
					<td>商品</td>
					<td>名称</td>
					<td>颜色</td>
					<td>规格</td>
					<td>单价</td>
					<td>数量</td>
					<td>小计</td>
					<td>操作</td>
				</tr>
			</thead>
			<tbody>
		 	<?php
		 		foreach ($cart_info as $key => $value) {
		 		 	extract($value);
		 		 	$photo = json_decode($photo,true)[0];
		 	?>
		 		<tr>
		 			<td><input class="cart_id_box" type="checkbox"  name="cart_id[]" value="<?php echo $cart_id; ?>"></td>
		 			<td><a href="/good_detail.php?id=<?php echo $good_id; ?>" target="_blank"> <img src="<?php echo $photo; ?>"></a></td>
		 			<td><?php echo $good_name; ?></td>
		 			<td><?php echo $color; ?></td>
		 			<td><?php echo $size; ?></td>
		 			<td>￥<?php echo $price; ?></td>
		 			<td>
		 				<div class="number-bar">
				      		<span class="layui-btn layui-btn-xs layui-btn-primary de-num"><i class="fas fa-minus-circle" ></i></span>
				      		<div class="layui-input-inline"><input type="text" value="<?php echo $num; ?>" class="layui-input" name="num" id="num" style="width: 50px;text-align: center;" max-num="<?php echo $inventory; ?>"></div>
				      		<span class="layui-btn layui-btn-xs layui-btn-primary in-num" ><i class="fas fa-plus-circle" ></i></span>
				      	</div>
		 			</td>
		 			<td class="preCountPrice">￥<?php echo round($num*$price); ?></td>
		 			<td><button onclick="return false;" class="layui-btn layui-btn-xs layui-btn-danger delete-btn" data-id="<?php echo $cart_id; ?>"><i class="fas fa-trash"  ></i>&nbsp;删除</button></td>
		 		</tr>
		 	<?php 
		 		 } 
		 	 ?> <tr>
		 	 		<td colspan="9" align="RIGHT">
		 	 			<p style="margin: 10px;padding: 5px;">总计 : <span id="total" style="font-size: 20px;color: #e4393c;">￥0</span></p>
		 	 			<button type="submit" class="layui-btn layui-btn-md layui-btn-warm">结算</button>
		 	 		</td>
		 	    </tr>
			</tbody>
		</table>
		</form>
		<?php 
			}
		 ?>
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
		include_once('include/footer.php');
	?>
</body>
	<?php
		include_once('include/script.php');
	?>
	<script>
		var color = '';
		var size = '';
		$(function(){
			//数量加1
			$('.number-bar').find('.in-num').each(function(index){
				$(this).click(function(){
					var max = parseInt($(this).prev().find('input[name=num]').attr('max-num'));
					var val = parseInt($(this).prev().find('input[name=num]').val());
					var price = parseInt($(this).parent().parent().prev().text().substring(1));
					var preCount = parseInt($(this).parent().parent().next().text().substring(1));
					var id = $(this).parent().parent().next().next().children('button').attr('data-id');
					if(val != max ){
						$(this).prev().find('input[name=num]').val(val+1);
						var newCount = preCount+price;
						$(this).parent().parent().next().text('￥'+newCount);
						serverUpdateNum(id, val+1);
						calTotal();
					}
				});
			});
			//数量减1
			$('.number-bar').find('.de-num').each(function(index){
				$(this).click(function(){
					var val = parseInt($(this).next().find('input[name=num]').val());
					var price = parseInt($(this).parent().parent().prev().text().substring(1));
					var preCount = parseInt($(this).parent().parent().next().text().substring(1));
					var id = $(this).parent().parent().next().next().children('button').attr('data-id');
					if(val != 1 ){
						$(this).next().find('input[name=num]').val(val-1);
						var newCount = preCount - price;
						$(this).parent().parent().next().text('￥'+newCount);
						serverUpdateNum(id, val-1);
						calTotal();
					}
				});
			});
			//输入数字
			$('.number-bar').find('input[name=num]').change(function(){
				var val = $(this).val();
				var max = parseInt($(this).attr('max-num'));
				var id = $(this).parent().parent().next().next().children('button').attr('data-id');
				if(!/^\d+$/i.test(val) || val == 0){
					$(this).val(1);
					val = 1;
				}else if(val > max){
					$(this).val(max);
					val = max;
				}
				serverUpdateNum(id, val);
			});
			//删除
				$('.delete-btn').each(function(Ind){
					$(this).click(function(){
						var id = $(this).attr('data-id');
						layer.confirm('确定删除？',function(index){
								$.ajax({
								  	url:'/cart_change.php',
								  	data:{
								  		id: id,
								  		action: 'del'
								  	},
								  	method:'post',
								  	dataType:'json',
								  	success:function(ret){
								  		if(ret.errcode == 0){
								  			$('.delete-btn').eq(Ind).parent().parent().remove();
								  		}else {
								  			layer.msg(ret.errmsg,{icon:5});
								  		}
								  		layer.close(index);
								  	},
								  	error:function(){
								  		layer.close(index);
										layer.msg('网络出错了，请稍后再试',{icon:5});
								  	}
								  });
							});
					});
				});

			//全选
			$('#checkAll').click(function(){
				if($(this).prop('checked')){
					$('input[type=checkbox]').each(function(index){
						$(this).prop('checked',true);
					});
					calTotal();
				}else{
					$('input[type=checkbox]').each(function(index){
						$(this).prop('checked',false);
					});
					$('#total').text('￥0');
				}
			});
			//选中处理
			$('.cart_id_box').each(function(index){
				$(this).click(function(){
					calTotal();
				});
			});

			//点击结算，检测有没有勾选商品
			$('#cartForm').submit(function(){
				var testCheck = false;
				$('input[type=checkbox]').each(function(index){
						if($(this).prop('checked')){
							testCheck = true;
						}
				});
				if(!testCheck){
					layer.msg('请勾选想要结算的商品',{icon:5});
					return false;
				}
			})
		});
		//服务器修改数量
		function serverUpdateNum(id , val){
			$.ajax({
  				url:'/cart_change.php',
  				data: {
  					id: id,
  					action: 'number',
  					num: val
  				},
  				method:'post',
  				dataType:'json',
  				success:function(ret){
  				},
  				error:function(){
	  				layer.msg('发生了错误，修改失败，请稍后再试',{icon:5});
	  			}
				});
		}
		
		//根据选中计算总计
		function calTotal(){
			var total = 0;
			$('.cart_id_box').each(function(index){
				if($(this).prop('checked')){
					total = total + parseInt($(this).parent().parent().find('.preCountPrice').eq(0).text().substring(1)); 
				}
			});
			$('#total').text('￥'+total);
		}
</script>
</html>