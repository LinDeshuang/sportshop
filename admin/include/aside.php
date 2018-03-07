  <?php
  //左侧菜单选中状态处理
  	$menu = isset($_GET['menu'])?$_GET['menu']:'0-0';
    $menu = explode('-', $menu);
      $menu_1 = $menu[0];  //一级菜单编号
      $menu_2 = $menu[1];  //二级菜单编号
  ?>
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧菜单区域-->
      <ul class="layui-nav layui-nav-tree">
        <li class="layui-nav-item <?php  if($menu_1 == 1){echo "layui-nav-itemed";} ?>">
          <a class="" href="javascript:;"><i class="fas fa-table" ></i>&nbsp;&nbsp;商品管理</a>
          <dl class="layui-nav-child">
            <dd><a href="/admin/good_list.php?menu=1-1" <?php if($menu_2 == 1){echo "class='layui-this'";}  ?>>商品列表</a></dd>
            <dd><a href="/admin/good_add_form.php?menu=1-2" <?php if($menu_2 == 2){echo "class='layui-this'";}  ?>>添加商品</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item <?php  if($menu_1 == 2){echo "layui-nav-itemed";} ?>">
          <a class="" href="javascript:;"><i class="fas fa-tag" ></i>&nbsp;&nbsp;分类管理</a>
          <dl class="layui-nav-child">
            <dd><a href="/admin/cate_list.php?menu=2-1" <?php if($menu_2 == 1){echo "class='layui-this'";}  ?>>分类列表</a></dd>
            <dd><a href="/admin/cate_add_form.php?menu=2-2" <?php if($menu_2 == 2){echo "class='layui-this'";}  ?>>添加分类</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item <?php if($menu_1 == 3){echo "layui-nav-itemed";} ?>">
          <a href="javascript:;"><i class="fas fa-calculator" ></i>&nbsp;&nbsp;订单管理</a>
          <dl class="layui-nav-child">
            <dd><a href="/admin/order_list.php?menu=3-1" <?php if($menu_2 == 1){echo "class='layui-this'";}  ?>>所有订单</a></dd>
            <dd><a href="/admin/order_undeal.php?menu=3-2" <?php if($menu_2 == 2){echo "class='layui-this'";}  ?>>未处理订单</a></dd>
            <dd><a href="/admin/order_deal.php?menu=3-3" <?php if($menu_2 == 3){echo "class='layui-this'";}  ?>>已处理订单</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item <?php if($menu_1 == 4){echo "layui-nav-itemed";} ?>" >
          <a href="javascript:;"><i class="fas fa-user" ></i>&nbsp;&nbsp;用户管理</a>
          <dl class="layui-nav-child">
            <dd><a href="/admin/user_list.php?menu=4-1" <?php if($menu_2 == 1){echo "class='layui-this'";}  ?>>用户列表</a></dd>
          </dl>
        </li>
      </ul>
    </div>
  </div>