<?php 
	require_once('/include/public.php');
	require_once('../public/class/db.php');
	require_once('../public/class/pages.php');

	//获取当前页号
	$page = isset($_GET['page'])?$_GET['page']:1;
	$search_type = (isset($_GET['search_type']) && !empty($_GET['search_type']))?$_GET['search_type']:'good_name';
	$search_val = isset($_GET['search_val'])?$_GET['search_val']:'';
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
				    <li class="layui-this">商品列表</a></li>
				    <li ><a href="/admin/good_add_form.php?menu=1-2">添加商品</a></li>
				  </ul>
				  <div class="layui-tab-content">
				  	<div class="layui-container">
				  		<form class="layui-form layui-form-pane">
						    <label class="layui-form-label">商品搜索</label>
						    <div class="layui-input-inline">
						      <select name="search_type">
								  <option value="">选择搜索项</option>
								  <option value="good_name" <?php if($search_type == 'good_name'){echo "selected" ;}?>>商品名称</option>
								  <option value="cate_id" <?php if($search_type == 'cate_id'){echo "selected" ;}?>>商品分类</option>
								  <option value="intro" <?php if($search_type == 'note'){echo "selected" ;}?>>商品介绍</option>
							  </select>     
						    </div>
						    <div class="layui-input-inline">
						      <input type="text" name="search_val" value="<?php echo $search_val; ?>" placeholder="输入想搜索的内容" required lay-verify="required" class="layui-input">  
						      <input type="hidden" name="menu" value="2-1"> 
						    </div>
						    <div class="layui-input-inline">
						      <button type="submit" lay-submit lay-filter="*" class="layui-btn layui-btn-normal"> 
						      	<i class="layui-icon">&#xe615;</i>
						      </button>  
						    </div>
				     	</form>
				  		<?php 
				  			$count = $_SQL->rowCount("SELECT * FROM good WHERE delete_time = 0 and {$search_type} LIKE '%{$search_val}%' ");
					    	$page_size = 8;
					    	$url = "/admin/good_list.php?menu=2-1&search_type={$search_type}&search_val={$search_val}&page={page}";
					    	$begin = $page_size*($page-1);
					   		$good_info = $_SQL->query("SELECT * FROM good WHERE delete_time = 0 and {$search_type} LIKE '%{$search_val}%' ORDER BY create_time DESC LIMIT {$begin},{$page_size}  ");
					  	 ?>
					  	 <table class="layui-table">
						  <thead>
						    <tr>
						      <th>ID</th>
						      <th>商品名称</th>
						      <th>分类</th>
						      <th>价格</th>
						      <th>库存</th>
						      <th>销量</th>
						      <th>简介</th>
						      <th>状态</th>
						      <th>添加时间</th>
						      <th style="min-width: 200px;">操作</th>
						    </tr> 
						  </thead>
						  <tbody>
						  	<?php 
						  		if(!$good_info){
						  			echo " <p class='tip-info'>无商品信息</p> ";
						  		}else{
						  			foreach ($good_info as $key => $value) {
						  				extract($value);		
						  	 ?>
						  	 <tr>
						      <td><?php echo $id; ?></td>
						      <td><?php echo $good_name; ?></td>
						      <td><?php echo $cate_id; ?></td>
						      <td><?php echo $price; ?></td>
						      <td><?php echo $inventory; ?></td>
						      <td><?php echo $sale_count; ?></td>
						      <td><?php echo $intro; ?></td>
						      <td><?php if($status == 1){echo "正常";}else{echo "已下架";} ?></td>
						      <td><?php echo date("Y-m-d",$create_time); ?></td>
						      <td>
						      	<a class="layui-btn layui-btn-primary layui-btn-xs change-btn" status="<?php echo $status; ?>" data-id="<?php echo $id; ?>"><i class="fas fa-<?php if($status == 1){echo 'ban';}else{echo 'sync';} ?>"></i>&nbsp;<?php if($status == 1){echo "下架";}else{echo "恢复";} ?></a>
						      	<a href="/admin/good_edit_form.php?id=<?php echo $id; ?>" class="layui-btn layui-btn-xs"><i class="fas fa-edit"></i>&nbsp;编辑</a>
						      	<a class="layui-btn layui-btn-danger layui-btn-xs delete-btn" data-id="<?php echo $id; ?>"><i class="fas fa-trash"  ></i>&nbsp;删除</a>
						      	
						      </td>
						    </tr>
							<?php
									}
						  		}
							  ?>
						  </tbody>
						</table>
					  	<!--分页栏 -->
				     	<div class="page-bar">
				     		<?php 
				 		   		if($count > $page_size){
				   					$Page = new Pages($count,$page_size,$page,$url,1);
									echo $Page->p_output();
				   				}
				   		 	?>
				     	</div>
				  	</div>

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
	 		//删除商品
			$('.delete-btn').each(function(index){
				$(this).click(function(){
					var id = $(this).attr('data-id');
					ajaxDelete(id , '/admin/good_delete.php');
				});
			});
			//下架或恢复
			$('.change-btn').each(function(index){
				$(this).click(function(){
					var id = $(this).attr('data-id');
					var status = parseInt(($(this).attr('status')));
					var text = $(this).text();
					layer.confirm('确定'+ text +'？',function(index){
					$.ajax({
					  	url: '/admin/good_change_status.php',
					  	data:{
					  		id: id,
					  		status: status
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
				});
			});

		});
	 </script>
</html>