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

			if(!isset($_GET['id'])){
				header('Location:/admin/cate_list.php?menu=2-1');
			}
			$cate_id = $_GET['id'];
			$cate_info = $_SQL->query("SELECT id as cur_id, pid as cur_pid, cate_name as cur_cate_name FROM category WHERE id = {$cate_id}");
			extract($cate_info[0]);
		 ?>
	 	<div class="layui-body">
	    <!-- 内容主体区域 -->
	    	<div style="padding: 15px;">
	    		<div class="layui-tab layui-tab-brief">
				  <ul class="layui-tab-title">
				    <li ><a href="/admin/cate_list.php?menu=2-1">分类列表</a></li>
				    <li ><a href="/admin/cate_add_form.php?menu=2-1">添加分类</a></li>
				    <li class="layui-this">编辑分类</li>
				  </ul>
				  <div class="layui-tab-content">
				  	<div class="layui-container">
				  		<form class="layui-form" style="margin:5% auto;padding:30px;width: 500px;">
				  			<input type="hidden" name="id" value="<?php echo $cur_id;?>">
					  		<div class="layui-form-item">
							    <label class="layui-form-label">父级分类</label>
							    <div class="layui-input-block">
							        <select lay-verify="required" name="pid">
							        	<option value="0"<?php if($cur_pid == 0){ echo "selected"; } ?>>无</option>
							        	<?php
							        		if($cur_pid != 0){
							        			$p_cate = $_SQL->query("SELECT id,cate_name FROM category WHERE delete_time = 0 AND pid = 0");
								        		foreach ($p_cate as $key => $value) {
								        			extract($value);
								        			if($cur_pid == $id){
								        				echo "<option value='{$id}' selected>{$cate_name}</option>";
								        			}else{
								        				echo "<option value='{$id}'>{$cate_name}</option>";
								        			}
								        			
								        		}
							        		} 
							        		
							        	 ?>
							        </select>
							    </div>
							</div>
					  		<div class="layui-form-item">
							    <label class="layui-form-label">分类名</label>
							    <div class="layui-input-block">
							        <input type="text" name="cate_name" placeholder="请输入分类名" lay-verify="required" required class="layui-input" value="<?php echo $cur_cate_name ?>">
							    </div>
							</div>
							<div class="layui-form-item">
							    <div class="layui-input-block">
							        <input type="submit" lay-filter='*' lay-submit value="保存" class="layui-btn">
							    </div>
							</div>
				  		</form>
				  	</div>
				  	
				  </div>
				</div>
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
		  	var cateData = data.field;
		  	 $('input[type=submit]').attr('disabled',true).addClass('layui-btn-disabled');
		  		//异步提交
			  	$.ajax({
			  		url:'/admin/cate_update.php',
			  		data:cateData,
			  		dataType:'json',
			  		method:'post',
			  		success:function(ret){
			  			if(ret.errcode == 0){
			  				layer.msg(ret.errmsg,{icon:1});
			  				setTimeout(function(){window.location.href='/admin/cate_list.php?menu=2-1';},1500);
			  			}else{
			  				layer.msg(ret.errmsg,{icon:5});
			  			}
		  				$('input[type=submit]').attr('disabled',false).removeClass('layui-btn-disabled');
			  		},
			  		error:function(){
			  			layer.msg('添加失败，发生了错误',{icon:5});
			  			$('input[type=submit]').attr('disabled',false).removeClass('layui-btn-disabled');
			  		}
	  			});
		    return false;
		  });
		});
	</script>
</html>