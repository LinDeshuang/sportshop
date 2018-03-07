<?php 
	require_once('include/public.php');
	require_once('include/check_user.php');
	require_once('public/class/db.php');
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>体育用品商城-个人信息</title>
	<?php
		include_once('include/head.php');
	?>
</head>
<body>
	<?php
		include_once('include/header.php');
	?>
	<?php 
		$user_id = $_SESSION['user_id'];
		
		$address_info = $_SQL->query("SELECT * FROM address WHERE user_id={$user_id} AND delete_time=0 ORDER BY id DESC");

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
		    <li class="layui-this">您的收货地址</li>
		    <li>添加收货地址</li>
		  </ul>
		  <div class="layui-tab-content">
		    <div class="layui-tab-item layui-show">
		    	<div class="layui-container"> 
	    			<p class="layui-badge">默认收货地址和联系方式是注册时填写的，可前往个人信息修改</p>
	    			<div class="layui-row" style="margin: 30px auto;">
	    				<?php
	    				if(!$address_info){
	    					echo "您还没有添加收货地址，快去添加吧";
	    				}else{

	    					foreach ($address_info as $key => $value) {
	    						extract($value);
	    						if($key != 0 && $key%2 == 0 ){
	    							echo "</div><div class='layui-row'>";
	    						}
	    				?>

	    				<div class="layui-col-xs5 layui-col-sm5 layui-col-md5 address-pan">
	    					<p>收货地址：<?php echo $address; ?> </p>
	    					<p>收货人：<?php echo $consignee; ?> </p>
	    					<p>联系方式：<?php echo $phone; ?> </p>
	    					<a href='/address_update_form.php?id=<?php echo $id; ?>' class="layui-btn layui-btn-xs layui-btn-normal edit-btn"><i class="fas fa-edit" ></i>&nbsp;编辑</a>
	    					<a title="删除" data-id="<?php echo $id; ?>" class="delete-btn"><i class="fas fa-times-circle"></i></a>
	    				</div>

	    				<?php
	    					}		    					
	    				} 
	    				 ?>
	    			</div>
    			</div>
		    </div>

		    <div class="layui-tab-item">
		    	<form class="layui-form" style="margin: 20px;width: 600px;">
					<div class="layui-form-item">
					    <label class="layui-form-label">收货地址</label>
					    <div class="layui-input-block">
					        <input type="text" name="address" placeholder="请输入收货地址" lay-verify="required|address" required class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">收货人</label>
					    <div class="layui-input-block">
					        <input type="text" name="consignee" placeholder="请输入收货人姓名" lay-verify="required|consignee" required class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">联系方式</label>
					    <div class="layui-input-block">
					        <input type="text" name="phone" placeholder="请输入收货人联系方式" lay-verify="required|phone|number" required class="layui-input">
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
		  	var addressInfo = data.field;
		  		//异步提交
	  			$('input[type=submit]').attr('disabled',true).addClass('layui-btn-disabled');
	  			$.ajax({
	  				url:'/address_add.php',
	  				data: addressInfo,
	  				method:'post',
	  				dataType:'json',
	  				success:function(ret){
	  					if(ret.errcode == 0){
					  		layer.msg(ret.errmsg,{icon:1});
					  		setTimeout(function(){window.location.reload();},1000);
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

		$(function(){
			$('.delete-btn').each(function(index){
				$(this).click(function(){
					var id = $(this).attr('data-id');
					ajaxDelete(id , '/address_delete.php');
				});
			});
		});
	 </script>
</html>