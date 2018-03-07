<?php 
	require_once('/include/public.php');
	require_once('/public/class/db.php');
	require_once('/public/class/function.php');
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

	?>
	<div class="layui-container main-container">
		<div class="layui-row" style="margin: 20px auto;">
		<?php 
	   		if(!isset($_GET['id'])){
				header('Location:/index.php');
			}
			$good_id = $_GET['id'];
			$good_info = $_SQL->query("SELECT * FROM good WHERE id = {$good_id}");
			extract($good_info[0]);
			$photo=json_decode($photo,true);
			$size=json_decode($size,true);
			$color=json_decode($color,true);
	  	 ?>
	  	 	<div class="layui-col-xs5 layui-col-sm5 layui-col-md5">
	  	 		<!--商品轮播图-->
				<div class="layui-carousel" id="carousel" style="border: solid 1px #eee;overflow: hidden;">
				  <div carousel-item>
				    <?php 
				    	foreach ($photo as $key => $value) {
				    		echo "<img src='{$value}'' style='width:100%;height: 100%;'>";
				    	}
				     ?>
				  </div>
				</div>
	  	 	</div>
	  	 	<div class="layui-col-xs7 layui-col-sm7 layui-col-md7">
	  	 		<table class="layui-table good-table">
				  <colgroup>
				    <col width="150">
				    <col width="200">
				    <col>
				  </colgroup>
				  <thead>
				    <tr>
				      <th colspan="2" height="50px" style="line-height: 50px;text-align: center;"><h1><?php echo $good_name; ?></h1></th>
				    </tr> 
				  </thead>
				  <tbody>
				    
				      <tr><td width="20%" align="right">价格</td><td style="color: #e4393c;font-size: 20px;">￥<?php echo $price; ?></td> </tr>
				      <tr><td width="20%" align="right">分类</td><td><?php echo $cate_id; ?></td> </tr>
				      <tr><td width="20%" align="right">简介</td><td><?php echo $intro; ?></td> </tr>
				      <tr><td width="20%" align="right">规格</td><td><?php foreach ($size as $key => $value) {
				      	echo "<button class='layui-btn layui-btn-md layui-btn-primary chSize' ischoose='0'>{$value}</button>";
				      }; ?></td> </tr>
				      <tr><td width="20%" align="right">颜色</td><td><?php foreach ($color as $key => $value) {
				      	echo "<button class='layui-btn layui-btn-md layui-btn-primary chColor' ischoose='0'>{$value}</button>";
				      }; ?></td> </tr>
				      <tr><td width="20%" align="right">库存</td><td><?php echo $inventory; ?></td> </tr>
				      <tr><td width="20%" align="right">数量</td><td>
				      	<div class="number-bar">
				      		<span class="layui-btn layui-btn-xs layui-btn-primary de-num"><i class="fas fa-minus-circle" ></i></span>
				      		<div class="layui-input-inline"><input type="text" value="1" class="layui-input" name="num" id="num" style="width: 50px;text-align: center;" max-num="<?php echo $inventory; ?>"></div>
				      		<span class="layui-btn layui-btn-xs layui-btn-primary in-num" ><i class="fas fa-plus-circle" ></i></span>
				      	</div>
				      	</td> </tr>
				      <tr>
				      	<td colspan="2" height="50px" style="text-align: center;">
				      		<button class="layui-btn layui-btn-sm layui-btn-danger" id="addToCard" data-id="<?php echo $id; ?>"><i class="fas fa-cart-plus" ></i>&nbsp;加入购物车</button>
				      	</td>
				       </tr>
				  </tbody>
				</table>
	  	 	</div>
	  	</div>
	  	<h2 class="h2-title">同类商品推荐</h2>
		<div class="layui-row" style="margin: 20px auto;">
		<?php 
	   		$com_good_info = $_SQL->query("SELECT * FROM good WHERE delete_time = 0 AND id !={$good_id} AND cate_id = '{$cate_id}' ORDER BY sale_count DESC LIMIT 4");
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
	<script>
		layui.use('carousel', function(){
			//轮播初始化
		  var carousel = layui.carousel;
		  carousel.render({
		    elem: '#carousel'
		    ,width: '100%' //设置容器宽度
		    ,height: '500px'
		    ,arrow: 'always' //始终显示箭头
		    ,autoplay: false
		  });
		});
		var color = '';
		var size = '';
		$(function(){
			//数量加1
			$('.number-bar').find('.in-num').each(function(index){
				$(this).click(function(){
					var max = parseInt($(this).prev().find('input[name=num]').attr('max-num'));
					var val = parseInt($(this).prev().find('input[name=num]').val());
					if(val != max ){
						$(this).prev().find('input[name=num]').val(val+1)
					}
				});
			});
			//数量减1
			$('.number-bar').find('.de-num').each(function(index){
				$(this).click(function(){
					var val = parseInt($(this).next().find('input[name=num]').val());
					if(val != 1 ){
						$(this).next().find('input[name=num]').val(val-1)
					}
				});
			});
			//数量格式和大小限制
			$('.number-bar').find('input[name=num]').change(function(){
				var val = $(this).val();
				var max = parseInt($(this).attr('max-num'));
				if(!/^\d+$/i.test(val) || val == 0){
					$(this).val(1);
				}else if(val > max){
					$(this).val(max);
				}
			});
			//选择颜色
			$('.chColor').each(function(index){
				$(this).click(function(){
					if($(this).attr('ischoose') == '0'){
						$('.chColor').each(function(index){
							$(this).attr('ischoose',0);
							$(this).removeClass('layui-btn-warm').addClass('layui-btn-primary');
						});
						$(this).attr('ischoose',1);
						$(this).removeClass('layui-btn-primary').addClass('layui-btn-warm');
						color = $(this).text();
					}
				});
			});
			//选择规格
			$('.chSize').each(function(index){
				$(this).click(function(){
					if($(this).attr('ischoose') == '0'){
						$('.chSize').each(function(index){
							$(this).attr('ischoose',0);
							$(this).removeClass('layui-btn-warm').addClass('layui-btn-primary');
						});
						$(this).attr('ischoose',1);
						$(this).removeClass('layui-btn-primary').addClass('layui-btn-warm');
						size = $(this).text();
					}
				});
			});
			//加入购物车
			$('#addToCard').click(function(){
				if(size == ''){
					layer.msg('请选择规格',{icon:5});
				}else if(color == ''){
					layer.msg('请选择颜色',{icon:5});
				}else{
					var id = $(this).attr('data-id');
					var num = parseInt($('input[name=num]').val());
					$.ajax({
		  				url:'/add_to_cart.php',
		  				data: {
		  					id: id,
		  					num: num,
		  					color: color,
		  					size: size
		  				},
		  				method:'post',
		  				dataType:'json',
		  				success:function(ret){
		  					if(ret.errcode == 0){
						  		layer.msg(ret.errmsg,{icon:1});
		  					}else if(ret.errcode == 40500){
		  						layer.msg(ret.errmsg+"，请登录后再加入购物车&nbsp;<a class='layui-btn layui-btn-md' href='/login_form.php'>现在去登录</a>",{icon:5});
		  					}else{
						  		layer.msg(ret.errmsg,{icon:5});
		  					}
		  				},
		  				error:function(){
			  				layer.msg('发生了错误，加入购物车失败，请稍后再试',{icon:5});
			  			}
	  				});
				}
			})
		});
</script>
</html>