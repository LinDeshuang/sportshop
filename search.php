<?php 
	require_once('include/public.php');
	require_once('public/class/db.php');
	require_once('public/class/pages.php');

	//获取当前页号
	$page = isset($_GET['page'])?$_GET['page']:1;
	$search_type = (isset($_GET['search_type']) && !empty($_GET['search_type']))?$_GET['search_type']:'good_name';
	$search_val = isset($_GET['search_val'])?$_GET['search_val']:'';
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
			<form class="layui-form layui-form-pane" method="get">
			    <label class="layui-form-label">商品搜索</label>
			    <div class="layui-input-inline">
			      <select name="search_type">
					  <option value="" selected>选择搜索项</option>
					  <option value="good_name" <?php if($search_type == 'good_name'){echo "selected" ;}?>>商品名称</option>
					  <option value="cate_id" <?php if($search_type == 'cate_id'){echo "selected" ;}?>>商品分类</option>
					  <option value="intro" <?php if($search_type == 'intro'){echo "selected" ;}?>>商品介绍</option>
				  </select>     
			    </div>
			    <div class="layui-input-inline">
			      <input type="text" name="search_val" value="<?php echo $search_val; ?>" placeholder="输入想搜索的内容" required lay-verify="required" class="layui-input">  
			    </div>
			    <div class="layui-input-inline">
			      <button type="submit" lay-submit lay-filter="*" class="layui-btn layui-btn-normal"> 
			      	<i class="layui-icon">&#xe615;</i>
			      </button>  
			    </div>
 			</form>
		</div>		
	</div>

	<div class="layui-container main-container">
  	 	<div class="layui-row" style="margin: 20px auto;">
		<?php 
			$count = $_SQL->rowCount("SELECT * FROM good WHERE delete_time = 0 and {$search_type} LIKE '%{$search_val}%' ");
	    	$page_size = 8;
	    	$url = "/admin/search.php?search_type={$search_type}&search_val={$search_val}&page={page}";
	    	$begin = $page_size*($page-1);
	   		$good_info = $_SQL->query("SELECT * FROM good WHERE delete_time = 0 and {$search_type} LIKE '%{$search_val}%' ORDER BY create_time DESC LIMIT {$begin},{$page_size}  ");

	   		if(!$good_info){
	   			echo "<p class='tip-info'>找不到您想要的商品</p>";
	   		}else{
	   			echo "<p class='tip-info'>共找到{$count}个商品</p>";

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
	  	 					<a href="/good_detail.php?id=<?php echo $id;?>"  target="_blank" class="layui-btn layui-btn-sm layui-btn-danger"><i class="fas fa-cart-plus" ></i>&nbsp;加入购物车</a>
	  	 				</div>
	  	 			</div>
	  	 		</div>
	  	 
	  	 <?php 
				}
	   		}
	  	  ?>	
	  	</div>
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

	<?php
		include_once('include/footer.php');
	?>
</body>
	<?php
		include_once('include/script.php');
	?>
</html>