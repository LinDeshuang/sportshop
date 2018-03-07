<?php 
	require_once('include/public.php');
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>体育用品商城</title>
	<?php
		include_once('include/head.php');
		if(isset($_SESSION['user'])){
			header("Location:/index.php");
		}
	?>
</head>
<body>
	<?php
		include_once('include/header.php');
	?>

	<div class="layui-container main-container">
		<form class="layui-form login-form">
			<div class="form-h2">
				用户注册
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">用户名</label>
			    <div class="layui-input-block">
			        <input type="text" name="account" lay-verify="required|account" placeholder="请输入用户名" required class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">密码</label>
			    <div class="layui-input-block">
			        <input type="password" name="password" lay-verify="required|password" placeholder="请输入密码" required class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">确认密码</label>
			    <div class="layui-input-block">
			        <input type="password" name="confirm_password" lay-verify="required|password" placeholder="请输入密码" required class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">昵称</label>
			    <div class="layui-input-block">
			        <input type="text" name="nickname" lay-verify="required|nickname" placeholder="请输入昵称" required class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">性别</label>
			    <div class="layui-input-block">
			      <input type="radio" name="gender" value="1" title="<i class='fas fa-mars'></i>&nbsp;男" checked>
			      <input type="radio" name="gender" value="2" title="<i class='fas fa-venus'></i>&nbsp;女" >
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">邮箱</label>
			    <div class="layui-input-block">
			        <input type="text" name="email" placeholder="请输入邮箱" lay-verify="required|email" required class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">手机号</label>
			    <div class="layui-input-block">
			        <input type="text" name="phone" placeholder="请输入手机号" lay-verify="required|phone|number" required class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">收货地址</label>
			    <div class="layui-input-block">
			        <input type="text" name="address" placeholder="请输入收货地址" lay-verify="required|address" required class="layui-input">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">验证码</label>
			    <div class="layui-input-inline">
			        <input type="text" name="verify_code" lay-verify="required|verify_code" placeholder="请输入验证码" required class="layui-input">
			    </div>
			     <img width="100px" height="40px" src="/public/create_verify.php" onclick="this.src = '/public/create_verify.php?time='+Math.random();" alt="点击更换" title="点击更换" style="float:left;cursor: pointer">
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
			    	<input type="submit" lay-filter='*' lay-submit  value="注册" class="layui-btn">
			    </div>
			</div>
		</form>
	</div>

	<?php
		include_once('include/footer.php');
	?>
</body>
	<?php
		include_once('include/script.php');
	?>
	<script type="text/javascript">
		layui.use('form', function(){
		  var form = layui.form;
		  
		  //监听提交
		  form.on('submit(*)', function(data){
		  	var register = data.field;
		  	if(register.password!=register.confirm_password){
		  		layer.msg('两次输入的密码不一样',{icon:5});
		  		$('input[name=confirm_password]').focus();
		  	}else{
		  		$('input[type=submit]').attr('disabled',true).addClass('layui-btn-disabled');
		  		//异步提交
			  	$.ajax({
			  		url:'register.php',
			  		data:register,
			  		dataType:'json',
			  		method:'post',
			  		success:function(ret){
			  			if(ret.errcode == 0){
			  				layer.alert(ret.errmsg+',&nbsp;&nbsp;<a href="/login_form.php">马上去登录</a>',{icon:1});
			  			}else{
			  				layer.msg(ret.errmsg,{icon:5});
			  			}
		  				$('input[type=submit]').attr('disabled',false).removeClass('layui-btn-disabled');
			  		},
			  		error:function(){
			  			layer.msg('注册失败，发生了错误',{icon:5});
			  			$('input[type=submit]').attr('disabled',false).removeClass('layui-btn-disabled');
			  		}
		  		});
			  }
		    return false;
		  });
		});
	</script>
</html>