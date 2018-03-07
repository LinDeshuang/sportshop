<?php 
	require_once('include/public.php');
	require_once('public/class/db.php');
	require_once('public/class/function.php');
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
	?>
	<div class="search-bar">
		<div class="layui-container">
			<form class="layui-form layui-form-pane" action="/search.php" method="get" target="_blank">
			    <label class="layui-form-label">商品搜索</label>
			    <div class="layui-input-inline">
			      <select name="search_type">
					  <option value="" selected>选择搜索项</option>
					  <option value="good_name" >商品名称</option>
					  <option value="cate_id" >商品分类</option>
					  <option value="intro" >商品介绍</option>
				  </select>     
			    </div>
			    <div class="layui-input-inline">
			      <input type="text" name="search_val" value="" placeholder="输入想搜索的内容" required lay-verify="required" class="layui-input">  
			    </div>
			    <div class="layui-input-inline">
			      <button type="submit" lay-submit lay-filter="*" class="layui-btn layui-btn-normal"> 
			      	<i class="layui-icon">&#xe615;</i>
			      </button>  
			    </div>
 			</form>
		</div>		
	</div>
	<div class="layui-container" style="margin: 10px auto;padding: 10px;">
		<div class="layui-row">
			<!--侧边分类导航-->
			<div class="layui-col-xs6 layui-col-sm4 layui-col-md4">
				<nav class="aside-nav">
					<?php 
						$cate_info = $_SQL->query("SELECT * FROM category WHERE delete_time = 0 ORDER BY id");
						$cate_info = arrayToLevel($cate_info);

						$output="<ul><li>";
						$li='';
							foreach ($cate_info as $key => $value) 
						{
							if($key == 0){
								$li.="<p>".$value['cate_name']."</p><ul>";
							}else if($value['level']==1){
								$li.="</ul><li><p>".$value['cate_name']."</p><ul>";
							}else{
								$li.="<li><a href='/search.php?search_type=cate_id&search_val={$value['cate_name']}'>".$value['cate_name']."</a></li>";			
							}
						}
						$output.=$li."</ul></li></ul>";
						echo $output;
					 ?>
				</nav>
			</div>
			<div class="layui-col-xs6 layui-col-sm8 layui-col-md8">
				<!--轮播图-->
				<div class="layui-carousel" id="carousel">
				  <div carousel-item>
				    <div><img src="/source/images/banner1.jpg" style="width: 100%;height: 100%;"></div>
				    <div><img src="/source/images/banner2.jpg" style="width: 100%;height: 100%;"></div>
				    <div><img src="/source/images/banner3.jpg" style="width: 100%;height: 100%;"></div>
				    <div><img src="/source/images/banner4.jpeg" style="width: 100%;height: 100%;"></div>
				  </div>
				</div>
			</div>
		
		</div>
	</div>

	<div class="layui-container main-container">
		<h2 class="h2-title">最新上架</h2>
		<div class="layui-row" style="margin: 20px auto;">
		<?php 
	   		$good_info = $_SQL->query("SELECT * FROM good WHERE delete_time = 0 ORDER BY create_time DESC LIMIT 8");

	   			foreach ($good_info as $key => $value) {
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
	  	 					<a href="/good_detail.php?id=<?php echo $id;?>" class="layui-btn layui-btn-sm layui-btn-danger" ><i class="fas fa-cart-plus" ></i>&nbsp;加入购物车</a>
	  	 				</div>
	  	 			</div>
	  	 		</div>
	  	 
	  	 <?php 
				}
	  	  ?>	
	  	</div>
	  	<h2 class="h2-title">热销商品</h2>
		<div class="layui-row" style="margin: 20px auto;">
		<?php 
	   		$good_info = $_SQL->query("SELECT * FROM good WHERE delete_time = 0 ORDER BY sale_count DESC LIMIT 8");

	   			foreach ($good_info as $key => $value) {
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
	  	 					<a href="/good_detail.php?id=<?php echo $id;?>" class="layui-btn layui-btn-sm layui-btn-danger " ><i class="fas fa-cart-plus" ></i>&nbsp;加入购物车</a>
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
		layui.use('carousel', function(){
			//轮播初始化
		  var carousel = layui.carousel;
		  carousel.render({
		    elem: '#carousel'
		    ,width: '100%' //设置容器宽度
		    ,arrow: 'always' //始终显示箭头
		  });
		});
</script>
</html>