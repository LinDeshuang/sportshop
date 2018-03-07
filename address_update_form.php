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
		if(!isset($_GET['id'])){
			header('Location:/address_form.php');
		}
		$user_id = $_SESSION['user_id'];
		$address_id = $_GET['id'];
		$address_info = $_SQL->query("SELECT * FROM address WHERE id = {$address_id} AND user_id = {$user_id}");
		extract($address_info[0]);
	 ?>
	<div class="layui-container main-container">
		<div class="layui-tab layui-tab-brief">
			<ul class="layui-tab-title">
			    <li><a href="/user_info_form.php">个人信息</a></li>
			    <li ><a href="/user_password_form.php">密码修改</a></li>
			    <li class="layui-this">收货地址管理</li>
			</ul>
		</div>

		<div class="layui-tab">
		  <ul class="layui-tab-title">
		    <li><a href="/address_list.php">您的收货地址</a></li>
		    <li class="layui-this">编辑收货地址</li>
		  </ul>
		  <div class="layui-tab-content">
		    <div class="layui-tab-item layui-show">
				<form class="layui-form" style="margin: 20px;width: 600px;">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<div class="layui-form-item">
					    <label class="layui-form-label">收货地址</label>
					    <div class="layui-input-block">
					        <input type="text" name="address" placeholder="请输入收货地址" lay-verify="required|address" required class="layui-input" value="<?php echo $address; ?>">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">收货人</label>
					    <div class="layui-input-block">
					        <input type="text" name="consignee" placeholder="请输入收货人姓名" lay-verify="required|consignee" required class="layui-input" value="<?php echo $consignee; ?>">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">联系方式</label>
					    <div class="layui-input-block">
					        <input type="text" name="phone" placeholder="请输入收货人联系方式" lay-verify="required|phone|number" required class="layui-input" value="<?php echo $phone; ?>">
					    </div>
					</div>
					<div class="layui-form-item">
						<div class="layui-input-block">
					    	<input type="submit" lay-filter='*' lay-submit  value="保存" class="layui-btn">
					    </div>
					</div>
				</form>
		    </div>
		  </div>
		</div>

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
		  	var addressInfo = data.field;
		  		//异步提交
	  			$('input[type=submit]').attr('disabled',true).addClass('layui-btn-disabled');
	  			$.ajax({
	  				url:'/address_update.php',
	  				data: addressInfo,
	  				method:'post',
	  				dataType:'json',
	  				success:function(ret){
	  					if(ret.errcode == 0){
					  		layer.msg(ret.errmsg,{icon:1});
					  		setTimeout(function(){window.location.href='/address_list.php?menu=2-1';},2000);
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
	    		return false;
		  });
		});
	 </script>
</html>