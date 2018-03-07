<div class="search-bar">
	<form class="layui-form layui-form-pane" action="/search.php" method="get">
	    <label class="layui-form-label">商品搜索</label>
	    <div class="layui-input-inline">
	      <select name="search_type">
			  <option value="">选择搜索项</option>
			  <option value="cate_name" <?php if($search_type == 'cate_name'){echo "selected" ;}?>>商品名称</option>
			  <option value="cate_id" <?php if($search_type == 'cate_id'){echo "selected" ;}?>>商品分类</option>
			  <option value="intro" <?php if($search_type == 'note'){echo "selected" ;}?>>商品介绍</option>
		  </select>     
	    </div>
	    <div class="layui-input-inline">
	      <input type="text" name="search_val" value="<?php echo $search_val; ?>" placeholder="输入想搜索的内容" required lay-verify="required" class="layui-input">  
	      <input type="hidden" name="nav" value="1-1"> 
	    </div>
	    <div class="layui-input-inline">
	      <button type="submit" lay-submit lay-filter="*" class="layui-btn layui-btn-normal"> 
	      	<i class="layui-icon">&#xe615;</i>
	      </button>  
	    </div>
 	</form>
</div>