
  <div class="admin-header layui-header layui-bg-black">
    <a href="/index.php"><h2 class="layui-logo"><i class="fas fa-basketball-ball" ></i>&nbsp;体育用品商城-后台管理</h2></a>
    <!-- 头部区域 -->
    <ul class="layui-nav layui-layout-left">
		<li class='layui-nav-item'><a href='/index.php' target="_blank"><i class="fas fa-home" ></i>&nbsp;商城首页</a></li>
    </ul>
    <ul class="layui-nav layui-layout-right">
        <li class='layui-nav-item'><i class="fas fa-user" ></i>&nbsp;管理员:<?php echo $_SESSION['admin']; ?></li>
    	<li class='layui-nav-item'><a href='/admin/update_password_form.php'><i class="fas fa-edit" ></i>&nbsp;密码修改</a></li>
   	 	<li class='layui-nav-item'><a href='/admin/logout.php'><i class="fas fa-power-off" ></i>&nbsp;退出</a></li>";
    </ul>
  </div>