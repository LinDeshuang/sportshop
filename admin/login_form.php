<?php 
	date_default_timezone_set('PRC');
    session_start();
	if(isset($_SESSION['admin'])){
		header('Location:/admin/index.php');
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>体育用品商城-后台登录</title>
	<?php
		include_once('include/head.php');
	?>
</head>
<body class="layui-bg-gray">
		<form class="layui-form text-center login-form" style="position: absolute;top: 45%;left: 50%;width: 500px;height: 400px;margin-top: -200px;margin-left: -250px;">
			<div class="form-h2">
				<i class="fas fa-basketball-ball" ></i>&nbsp;体育用品商城-管理员登录
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">管理员</label>
			    <div class="layui-input-block">
			        <input type="text" name="name" placeholder="请输入管理员名称" lay-verify="required" required class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">密码</label>
			    <div class="layui-input-block">
			        <input type="password" name="password" placeholder="请输入管理员密码" lay-verify="required" required class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">验证码</label>
			    <div class="layui-input-inline">
			        <input type="text" name="verify_code" placeholder="请输入验证码" lay-verify="required" required class="layui-input">
			    </div>
			    <img width="100px" height="40px" src="/public/create_verify.php" onclick="this.src = '/public/create_verify.php?time='+Math.random();" alt="点击更换" title="点击更换" style="float:left;cursor: pointer">
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
			    	<input type="submit" lay-filter='*' lay-submit value="登录" class="layui-btn">
			    </div>
			</div>
		</form>
</body>
	<?php
		include_once('include/script.php');
	?>
	<script type="text/javascript">
		layui.use('form', function(){
		  var form = layui.form;

		  //监听提交
		  form.on('submit(*)', function(data){
		  	var loginData = data.field;
		  	 $('input[type=submit]').attr('disabled',true).addClass('layui-btn-disabled');
		  		//异步提交
			  	$.ajax({
			  		url:'/admin/login.php',
			  		data:loginData,
			  		dataType:'json',
			  		method:'post',
			  		success:function(ret){
			  			if(ret.errcode == 0){
			  				layer.msg(ret.errmsg,{icon:1});
			  				setTimeout(function(){window.location.href='/admin/index.php';},1500);
			  			}else{
			  				layer.msg(ret.errmsg,{icon:5});
			  			}
		  				$('input[type=submit]').attr('disabled',false).removeClass('layui-btn-disabled');
			  		},
			  		error:function(){
			  			layer.msg('登录失败，发生了错误',{icon:5});
			  			$('input[type=submit]').attr('disabled',false).removeClass('layui-btn-disabled');
			  		}
	  			});
		    return false;
		  });
		});
	</script>
</html>