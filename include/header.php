<div class="layui-layout layui-layout-admin">
	<div class="home-header layui-bg-gray">
	    <div class="layui-container">
		    <a href="/index.php"><h2 class="layui-logo"><i class="fas fa-basketball-ball" ></i>&nbsp;体育用品商城</h2></a>
		    <!-- 头部区域 -->
		    <ul class="layui-nav layui-layout-left layui-bg-gray">
		    	<li class='layui-nav-item'> <a href="/index.php"><i class="fas fa-home" ></i>&nbsp;首页</a></li>
			    <li class='layui-nav-item'><a href='/admin/login_form.php' target="_blank"><i class="fas fa-tachometer-alt" ></i>&nbsp;商城管理员</a></li>
			   

		    </ul>
		     <ul class="layui-nav layui-layout-right layui-bg-gray">
    
		      <?php

		        if(isset($_SESSION['user'])){
		            echo "<li class='layui-nav-item'>
		            		<a><i class='fas fa-user' ></i>&nbsp;{$_SESSION['user_nickname']}</a>
							<dl class='layui-nav-child'>
						        <dd><a href='/user_info_form.php'><i class='fas fa-edit' ></i>&nbsp;个人信息</a></dd>
					            <dd><a href='/user_cart.php'><i class='fas fa-shopping-cart' ></i>&nbsp;我的购物车</a></dd>
					            <dd><a href='/user_order.php'><i class='fas fa-calculator' ></i>&nbsp;我的订单</a></dd>
					        </dl>
		            	  </li>
		                  <li class='layui-nav-item'><a href='/logout.php'><i class='fas fa-power-off' ></i>&nbsp;退出</a></li>";
		        }else{
		            echo "<li class='layui-nav-item'><a href='/login_form.php'>登录</a></li>
		                  <li class='layui-nav-item'><a href='/register_form.php'>注册</a></li>";
		        }
		      ?>
		    </ul>
	    </div>
	</div>
</div>
