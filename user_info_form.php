<?php 
	require_once('/include/public.php');
	require_once('/include/check_user.php');
	require_once('/public/class/db.php');
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>体育用品商城-个人信息</title>
	<?php
		include_once('/include/head.php');
	?>
</head>
<body>
	<?php
		include_once('/include/header.php');
	?>
	<?php 
		$user_id = $_SESSION['user_id'];
		$user_info = $_SQL->query("SELECT * FROM user WHERE id = {$user_id}");
		extract($user_info[0]);
	 ?>
	<div class="layui-container main-container">
		<div class="layui-tab layui-tab-brief">
				  <ul class="layui-tab-title">
				    <li class="layui-this">个人信息</li>
				    <li><a href="/user_password_form.php">密码修改</a></li>
				    <li><a href="/address_list.php">收货地址管理</a></li>
				  </ul>
		</div>


		<form class="layui-form" style="margin: 20px;width: 600px;">
			<div class="layui-form-item">
			    <label class="layui-form-label">用户名:</label>
			    <div class="layui-input-block">
			        <input type="text" name="account" class="layui-input" value="<?php echo $account; ?>" disabled="disabled">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">昵称:</label>
			    <div class="layui-input-block">
			        <input type="text" name="nickname" lay-verify="required|nickname" placeholder="请输入昵称" required class="layui-input" value="<?php echo $nickname; ?>">
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">性别:</label>
			    <div class="layui-input-block">
			      <input type="radio" name="gender" value="1" title="<i class='fas fa-mars'></i>&nbsp;男" <?php if($gender=='1') echo "checked"; ?>>
			      <input type="radio" name="gender" value="2" title="<i class='fas fa-venus'></i>&nbsp;女" <?php if($gender=='2') echo "checked"; ?>>
			    </div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">邮箱:</label>
			    <div class="layui-input-block">
			        <input type="text" name="email" placeholder="请输入邮箱" lay-verify="required|email" required class="layui-input" value="<?php echo $email; ?>">
			    </div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">默认手机号:</label>
			    <div class="layui-input-block">
			        <input type="text" name="phone" placeholder="请输入手机号" lay-verify="required|phone|number" required class="layui-input" value="<?php echo $phone; ?>">
			    </div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">默认收货地址:</label>
			    <div class="layui-input-block">
			        <input type="text" name="address" placeholder="请输入收货地址" lay-verify="required|address" required class="layui-input" value="<?php echo $address; ?>">
			    </div>
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
			    	<input type="submit" lay-filter='*' lay-submit  value="保存" class="layui-btn">
			    </div>
			</div>
		</form>
	</div>

	<?php
		include_once('/include/footer.php');
	?>
</body>
	<?php
		include_once('/include/script.php');
	?>
	<script type="text/javascript">
		layui.use('form', function(){
		  var form = layui.form;
		  
		  //监听提交
		  form.on('submit(*)', function(data){
		  	var info = data.field;
	  		$('input[type=submit]').attr('disabled',true).addClass('layui-btn-disabled');
	  		//异步提交
		  	$.ajax({
		  		url:'/user_info.php',
		  		data:info,
		  		dataType:'json',
		  		method:'post',
		  		success:function(ret){
		  			if(ret.errcode == 0){
		  				layer.alert(ret.errmsg,{icon:1});
		  			}else{
		  				layer.msg(ret.errmsg,{icon:5});
		  			}
	  				$('input[type=submit]').attr('disabled',false).removeClass('layui-btn-disabled');
		  		},
		  		error:function(){
		  			layer.msg('发生了错误',{icon:5});
		  			$('input[type=submit]').attr('disabled',false).removeClass('layui-btn-disabled');
		  		}
	  		});
		    return false;
		  });
		});
	</script>
</html>