<?php 
	require_once('include/public.php');
	require_once('../public/class/db.php');
	require_once('../public/class/pages.php');
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
	    	<div style="padding: 15px;">商品编辑</div>
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