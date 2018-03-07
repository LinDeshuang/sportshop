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
	    	<div style="padding: 15px;">
	    		<div class="layui-tab layui-tab-brief">
				  <ul class="layui-tab-title">
				    <li class="layui-this"><i class="fas fa-edit" ></i>&nbsp;密码修改</li>
				  </ul>
				</div>

	    		<form class="layui-form text-center" style="margin:5% auto;padding:30px;width: 500px;">
					<div class="layui-form-item">
					    <label class="layui-form-label">管理员</label>
					    <div class="layui-input-block">
					        <input type="text" name="account" autocomplete="off" class="layui-input" value="<?php echo $_SESSION['admin']; ?>" disabled="disabled">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">原密码</label>
					    <div class="layui-input-block">
					        <input type="password" name="old_password" placeholder="请输入原密码" lay-verify="required|password" required autocomplete="off" class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">新密码</label>
					    <div class="layui-input-block">
					        <input type="password" name="password" placeholder="请输入新密码" lay-verify="required|password" required autocomplete="off" class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">确认密码</label>
					    <div class="layui-input-block">
					        <input type="password" name="confirm_password" placeholder="请确认新密码" lay-verify="required|password" required autocomplete="off" class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
						<div class="layui-input-block">
					    	<input type="submit" lay-filter='*' lay-submit value="修改" class="layui-btn">
					    </div>
					</div>
				</form>
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
	 <script type="text/javascript">
	 	layui.use('form', function(){
		  var form = layui.form;

		  //监听提交
		  form.on('submit(*)', function(data){
		  	var updateData = data.field;
		  		//异步提交
		  		if(updateData.password!=updateData.confirm_password){
		  			layer.msg('两次输入的密码不一样',{icon:5});
		  		}else{
		  			$('input[type=submit]').attr('disabled',true).addClass('layui-btn-disabled');
		  			$.ajax({
		  				url:'/admin/update_password.php',
		  				data: updateData,
		  				method:'post',
		  				dataType:'json',
		  				success:function(ret){
		  					if(ret.errcode == 0){
						  		layer.msg(ret.errmsg+'，请用新密码重新登录！',{icon:1});
					  			setTimeout(function(){window.location.href = '/admin/login_form.php';},2000);
		  					}else {
						  		layer.msg(ret.errmsg,{icon:5});
		  					}
						  	$('input[type=submit]').attr('disabled',false).removeClass('layui-btn-disabled');
		  				},
		  				error:function(){
			  				layer.msg('发生了错误',{icon:5});
			  				$('input[type=submit]').attr('disabled',false).removeClass('layui-btn-disabled');
			  			}
		  			});
		  		}
		    return false;
		  });
		});
	 </script>
</html>