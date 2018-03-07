<?php 
	require_once('/include/public.php');
	require_once('../public/class/db.php');
	require_once('../public/class/function.php');
	require_once('../public/class/pages.php');
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>体育用品商城-后台管理</title>
	<?php 
		include_once('/include/head.php');
 	?>
</head>
<body class="layui-layout-body">
	<div class="layui-layout layui-layout-admin">
	  	<?php 
	  		include_once('/include/header.php');
	  		include_once('/include/aside.php');
	  	 ?>
	 	<div class="layui-body">
	    <!-- 内容主体区域 -->
	    	<div style="padding: 15px;">
	    		<div class="layui-tab layui-tab-brief">
				  <ul class="layui-tab-title">
				    <li class="layui-this">分类列表</li>
				    <li><a href="/admin/cate_add_form.php?menu=2-2">添加分类</a></li>
				  </ul>
				  <div class="layui-tab-content">
				  	<?php 
				  		$cate_info = $_SQL->query("SELECT * FROM category WHERE delete_time=0 ORDER BY id ");
				  	 ?>
				  	 <table class="layui-table">
					  <thead>
					    <tr>
					      <th>ID</th>
					      <th>分类名称</th>
					      <th>创建时间</th>
					      <th>操作</th>
					    </tr> 
					  </thead>
					  <tbody>
					  	<?php 
					  		if(!$cate_info){
					  			echo "<p class='tip-info'>您还没有添加任何分类</p>";
					  		}else{
					  			$cate_info = arrayToLevel($cate_info);
					  			foreach ($cate_info as $key => $value) {
					  				extract($value);		
					  	 ?>
					  	 <tr>
					      <td><?php echo $id; ?></td>
					      <td><?php if($level==2){ echo "|--"; } echo $cate_name; ?></td>
					      <td><?php echo date("Y-m-d",$create_time); ?></td>
					      <td>
				         	<a href="/admin/cate_update_form.php?id=<?php echo $id; ?>" class="layui-btn layui-btn-xs" data-id="<?php echo $id; ?>"><i class="fas fa-edit"></i>&nbsp;编辑</a>
					      	<a class="layui-btn layui-btn-danger layui-btn-xs delete-btn" data-id="<?php echo $id; ?>" data-level="<?php echo $level;?>"><i class="fas fa-trash"  ></i>&nbsp;删除</a>
					   
					      </td>
					    </tr>
						<?php
								}
					  		}
						  ?>
					  </tbody>
					</table>
				  </div>
				</div>
	    	</div>
	  	</div>
	  	<?php
	  		include_once('/include/footer.php');
	  	?>
	</div>
</body>
	<?php 
		include_once('/include/script.php');
	 ?>
	 <script type="text/javascript">
		$(function(){
			$('.delete-btn').each(function(index){
				$(this).click(function(){
					var id = $(this).attr('data-id');
					var level = $(this).attr('data-level');
					console.log(level)
					if(level == '1'){
						layer.confirm('删除一级分类，其子分类将一并删除，确定删除？',function(Index){
							$.ajax({
							  	url: '/admin/cate_delete.php',
							  	data:{
							  		id: id
							  	},
							  	method:'post',
							  	dataType:'json',
							  	success:function(ret){
							  		if(ret.errcode == 0){
							  			layer.msg(ret.errmsg,{icon:1});
							  			setTimeout(function(){window.location.reload();},1000);
							  		}else {
							  			layer.msg(ret.errmsg,{icon:5});
							  		}
							  		layer.close(index);
							  	},
							  	error:function(){
							  		layer.close(index);
									layer.msg('网络出错了，请稍后再试',{icon:5});
							  	}
							  });
						});
					}else{
						    ajaxDelete(id , '/admin/cate_delete.php');
					}
				});
			});
		});
	 </script>
</html>