<?php 
	require_once('include/public.php');
	require_once('public/class/db.php');
	require_once('public/class/pages.php');
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
			unset($_SESSION['user']);
			setcookie(session_name(), session_id(), time() - 1, "/"); 
			header("refresh:3;url='/index.php");
	?>
	<?php
		include_once('include/header.php');
	?>

	<div class="layui-container main-container">
		<p class='layui-elem-quote' style="background-color: #efefef;position: absolute;top: 50%;left: 50%;width: 200px;height: 100px;line-height: 100px; margin-top: -100px;margin-left: -50px;font-size: 15px;text-align: center;border: solid 2px #009688;color: #5FB878;">
			退出账号成功，正在跳转<i class="layui-icon layui-anim layui-anim-rotate layui-anim-loop">&#xe63d;</i>
		</p>
	</div>

	<?php
		include_once('include/footer.php');
	?>
</body>
	<?php
		include_once('include/script.php');
	?>
</html>