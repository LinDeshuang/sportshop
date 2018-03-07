<?php 
	require_once('/include/public.php');
	require_once('../public/class/db.php');
	require_once('../public/class/pages.php');

	//获取当前页号
	$page = isset($_GET['page'])?$_GET['page']:1;
	$search_type = (isset($_GET['search_type']) && !empty($_GET['search_type']))?$_GET['search_type']:'nickname';
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
				    <li class="layui-this">用户管理</a></li>
				  </ul>
				  <div class="layui-tab-content">
				  	<div class="layui-container">
				  		<form class="layui-form layui-form-pane">
						    <label class="layui-form-label">用户搜索</label>
						    <div class="layui-input-inline">
						      <select name="search_type">
								  <option value="">选择搜索项</option>
								  <option value="account" <?php if($search_type == 'account'){echo "selected" ;}?>>用户账号</option>
								  <option value="nickname" <?php if($search_type == 'nickname'){echo "selected" ;}?>>用户昵称</option>
								  <option value="email" <?php if($search_type == 'email'){echo "selected" ;}?>>用户邮箱</option>
								  <option value="phone" <?php if($search_type == 'phone'){echo "selected" ;}?>>用户手机</option>
								  <option value="address" <?php if($search_type == 'address'){echo "selected" ;}?>>用户地址</option>
							  </select>     
						    </div>
						    <div class="layui-input-inline">
						      <input type="text" name="search_val" value="<?php echo $search_val; ?>" placeholder="输入想搜索的内容" required lay-verify="required" class="layui-input">  
						      <input type="hidden" name="menu" value="4-1"> 
						    </div>
						    <div class="layui-input-inline">
						      <button type="submit" lay-submit lay-filter="*" class="layui-btn layui-btn-normal"> 
						      	<i class="layui-icon">&#xe615;</i>
						      </button>  
						    </div>
				     	</form>
				     	<?php 
				  			$count = $_SQL->rowCount("SELECT * FROM user WHERE delete_time = 0 and {$search_type} LIKE '%{$search_val}%' ");
					    	$page_size = 4;
					    	$url = "/admin/user_list.php?menu=4-1&search_type={$search_type}&search_val={$search_val}&page={page}";
					    	$begin = $page_size*($page-1);
					   		$user_info = $_SQL->query("SELECT * FROM user WHERE delete_time = 0 and {$search_type} LIKE '%{$search_val}%' ORDER BY create_time DESC LIMIT {$begin},{$page_size}");
					  	 ?>
					  	 <table class="layui-table">
						  <thead>
						    <tr>
						      <th>ID</th>
						      <th>账号</th>
						      <th>呢称</th>
						      <th>性别</th>
						      <th>邮箱</th>
						      <th>手机</th>
						      <th>地址</th>
						      <th>注册时间</th>
						      <th>状态</th>
						      <th>操作</th>
						    </tr> 
						  </thead>
						  <tbody>
						  	<?php 
						  		if(!$user_info){
						  			echo " <p class='tip-info'>无用户信息</p> ";
						  		}else{
						  			foreach ($user_info as $key => $value) {
						  				extract($value);		
						  	 ?>
						  	 <tr>
						      <td><?php echo $id; ?></td>
						      <td><?php echo $account; ?></td>
						      <td><?php echo $nickname; ?></td>
						      <td><?php if($gender == 1){echo "男";}else{echo "女";} ?></td>
						      <td><?php echo $email; ?></td>
						      <td><?php echo $phone; ?></td>
						      <td><?php echo $address; ?></td> 
						      <td><?php echo date("Y-m-d",$create_time); ?></td>
						      <td><?php if($status == 1){echo "正常";}else{echo "已禁用";} ?></td>
						      <td>
						      	<a class="layui-btn layui-btn-primary layui-btn-xs change-btn" status="<?php echo $status; ?>" data-id="<?php echo $id; ?>"><i class="fas fa-<?php if($status == 1){echo 'ban';}else{echo 'sync';} ?>"></i>&nbsp;<?php if($status == 1){echo "禁用";}else{echo "恢复";} ?></a>
						      	
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
	 	//禁用或恢复用户
			$('.change-btn').each(function(index){
				$(this).click(function(){
					var id = $(this).attr('data-id');
					var status = parseInt(($(this).attr('status')));
					var text = $(this).text();
					layer.confirm('确定'+ text +'？',function(index){
					$.ajax({
					  	url: '/admin/user_change_status.php',
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
	 </script>
</html>