<?php 
	require_once('/include/public.php');
	require_once('../public/class/db.php');
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

	  		if(!isset($_GET['id'])){
				header('Location:/admin/good_list.php?menu=1-1');
			}
			$good_id = $_GET['id'];
			$good_info = $_SQL->query("SELECT * FROM good WHERE id = {$good_id}");
			extract($good_info[0]);
			$cate = explode('-', $cate_id);
			$p_c = $cate[0];
			$c_c = $cate[1];

			$photo = json_decode($photo,true);
			$size = json_decode($size,true);
			$color = json_decode($color,true);
	  	 ?>
	 	<div class="layui-body">
	    <!-- 内容主体区域 -->
	    	<div style="padding: 15px;">
	    		<div class="layui-tab layui-tab-brief">
				  <ul class="layui-tab-title">
				    <li ><a href="/admin/good_list.php?menu=1-1">商品列表</a></li>
				    <li ><a href="/admin/good_add_form.php?menu=1-2">添加商品</a></li>
				    <li class="layui-this">编辑商品</li>
				  </ul>
				  <div class="layui-tab-content">
				  	<div class="layui-container">
				  		<form class="layui-form" style="margin:5% auto;padding:30px;width: 500px;">
				  			<input type="hidden" name="id" value="<?php echo $id;?>">
				  			<div class="layui-form-item">
							    <label class="layui-form-label">商品名称</label>
							    <div class="layui-input-block">
							        <input type="text" name="good_name" placeholder="请输入商品名称" lay-verify="required|good_name" value="<?php echo $good_name;?>" required class="layui-input">
							    </div>
							</div>
							<div class="layui-form-item">
							    <label class="layui-form-label">商品价格</label>
							    <div class="layui-input-block">
							        <input type="text" name="price" placeholder="请输入商品价格，最多保留两位小数" lay-verify="required|price" value="<?php echo $price;?>" required class="layui-input">
							    </div>
							</div>
							<div class="layui-form-item">
							    <label class="layui-form-label">商品简介</label>
							    <div class="layui-input-block">
							         <textarea name="intro" placeholder="请输入商品简介" lay-verify="intro" class="layui-textarea"><?php echo $intro;?></textarea>
							    </div>
							</div>
							<div class="layui-form-item">
							    <label class="layui-form-label">商品库存</label>
							    <div class="layui-input-block">
							         <input type="text" name="inventory" placeholder="请输入商品库存" lay-verify="required|number" value="<?php echo $inventory;?>" required class="layui-input">
							    </div>
							</div>
							<div class="layui-form-item">
							    <label class="layui-form-label">所属分类</label>
							    
							    <div class="layui-input-block">
							        <select class="normal-select" lay-verify="required" lay-ignore name="pid" id="pid">
							        	<option value="">请选择主分类</option>
							        	<?php 
							        		$p_cate = $_SQL->query("SELECT id,cate_name FROM category WHERE delete_time = 0 AND pid = 0");
							        		foreach ($p_cate as $key => $value) {
							        			extract($value);
							        			if($cate_name == $p_c){
													echo "<option value='{$cate_name}' data-id='{$id}' selected>{$cate_name}</option>";
							        			}else{
							        				echo "<option value='{$cate_name}' data-id='{$id}'>{$cate_name}</option>";

							        			}
							        			
							        		}
							        	 ?>
							        </select>
								    <select class="normal-select" lay-verify="required" lay-ignore name="cid" id="cid">
								        	<option value="">请选择次分类</option>
								        	<?php 
								        		$c_cate = $_SQL->query("SELECT id,pid,cate_name FROM category WHERE delete_time = 0 AND pid != 0");
								        		foreach ($c_cate as $key => $value) {
								        			extract($value);
								        			if($cate_name == $c_c){
														echo "<option value='{$cate_name}' data-pid='{$pid}' selected>{$cate_name}</option>";
								        			}else{
								        				echo "<option value='{$cate_name}' data-pid='{$pid}' style='display:none;'>{$cate_name}</option>";
								        			}
								        			
								        		}
								        	 ?>
							        </select>
								</div>
								<div class="layui-input-block">
							    	<span class="layui-badge">注意！分类必选，如果还没有创建分类，请前往创建</span>
							    </div>
							</div>
							<div class="layui-form-item">
							    <label class="layui-form-label">商品规格</label>
							    <div class="layui-input-inline">
							         <input type="text" id="sizeV" placeholder="请输入规格，点击添加" class="layui-input">
							         
							    </div>
							    	<span class="layui-btn layui-btn-normal layui-btn-sm" id="addSize" style="margin: 5px;"><i class="fas fa-plus-circle" ></i></span>
							    	<span class="layui-btn layui-btn-danger layui-btn-sm" id="delSize" style="margin: 5px;"><i class="fas fa-minus-circle" ></i></span>
						    	<div class="layui-input-block" id="size-box">
						    		<?php 
						    			foreach ($size as $key => $value) {
						    				echo "<input name='size[]' class='layui-input input-sm' value='{$value}'>";
						    			}
						    		 ?>
						         </div>
							</div>
							<div class="layui-form-item">
							    <label class="layui-form-label">商品颜色</label>
							    <div class="layui-input-inline">
							         <input type="text" id="colorV"  placeholder="请输入颜色,点击添加" class="layui-input">
							    </div>
						         <span class="layui-btn layui-btn-normal layui-btn-sm" id="addColor" style="margin: 5px;"><i class="fas fa-plus-circle" ></i></span>
						         <span class="layui-btn layui-btn-danger layui-btn-sm" id="delColor" style="margin: 5px;"><i class="fas fa-minus-circle" ></i></span>
						         <div class="layui-input-block" id="color-box">
						         	<?php 
						    			foreach ($color as $key => $value) {
						    				echo "<input name='color[]' class='layui-input input-sm' value='{$value}'>";
						    			}
						    		 ?>
						         </div>
							</div>
							<div class="layui-form-item">
							    <label class="layui-form-label">商品图片</label>
							    <div class="layui-input-block">
							         <button type="button" class="layui-btn layui-btn-normal" id="uploadPhoto">
									  <i class="layui-icon">&#xe67c;</i>上传图片
									</button>
							    </div>
							    <div class="layui-input-block">
    							    <span class="layui-badge">上传后点击图片可删除，最多上传4张</span>
    							</div>
							    <div id="photo-input-box">
							    	<?php 
							    		$img_num = 1;
						    			foreach ($photo as $key => $value) {
						    				echo "<input data-img-num='{$img_num}' name='photo[]' type='hidden'  value='{$value}'>";
						    				$img_num++;
						    			}
						    		 ?>
							    </div>
							    <div class="layui-input-block" id="photo-box">
							    	<?php 
							    		$img_num = 1;
						    			foreach ($photo as $key => $value) {
						    				echo "<img data-img-num='{$img_num}' class='upload-img' title='点击删除该图片' onclick='deletePhoto(this);'  src='{$value}' />";
						    				$img_num++;
						    			}
						    		 ?>
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
	  		include_once('/include/footer.php');
	  	?>
	</div>
</body>
	<?php 
		include_once('/include/script.php');
	 ?>
	 <script type="text/javascript">
		//图片上传处理
		imgNum = <?php echo $img_num; ?>;
		layui.use(['upload','form'], function(){
		  var upload = layui.upload;
		  var form = layui.form;
		   
		  //执行实例
		  var uploadInst = upload.render({
		    elem: '#uploadPhoto' //绑定元素
		    ,url: '/admin/good_photo.php' //上传接口
		    ,field: 'image'
		    ,size: 2000
		    ,before: function(obj){
			    	layer.load();
		    }
		    ,done: function(res){
	    	  layer.closeAll('loading');
		      if(res.errcode==0){
		      	$('#photo-box').append('<img data-img-num="'+imgNum+'" class="upload-img" title="点击删除该图片" onclick="deletePhoto(this);"  src="'+ res.path +'" />');
		      	$('#photo-input-box').append('<input data-img-num="'+imgNum+'" name="photo[]" type="hidden"  value="'+ res.path +'">');
		      	imgNum++;
		      	if($('#photo-input-box').children().length ==4 ){
		      		$('#uploadPhoto').css('display','none');
		      	}
		      }else{
		      	layer.msg('上传失败，原因：' + res.errmsg,{icon:5});
		      }
		    }
		    ,error: function(){
		      layer.closeAll('loading');
		    }
		  });
		  //监听提交
		  form.on('submit(*)', function(data){
		  	var goodData = data.field;
		  	console.log(goodData)
		  		//异步提交
	  			$('input[type=submit]').attr('disabled',true).addClass('layui-btn-disabled');
	  			$.ajax({
	  				url:'/admin/good_edit.php',
	  				data: goodData,
	  				method:'post',
	  				dataType:'json',
	  				success:function(ret){
	  					if(ret.errcode == 0){
					  		layer.msg(ret.errmsg,{icon:1});
				  			setTimeout(function(){window.location.href = '/admin/good_list.php';},1500);
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
			//分类选择处理
			$('#pid').change(function(){
				var  pid = $(this).find(':selected').attr('data-id');
				$('#cid').find('option').each(function(index){
					$(this).css('display','block');
					if($(this).attr('data-pid') != pid){
						$(this).css('display','none');
					}
				})
			});

			//添加规格
			$('#addSize').click(function(){
				var size = $('#sizeV').val();
				if(size != ''){
					$('#size-box').append('<input name="size[]" class="layui-input input-sm" value="'+ size +'">');
				}
			})
			//添加颜色
			$('#addColor').click(function(){
				var color = $('#colorV').val();
				if(color != ''){
					$('#color-box').append('<input name="color[]" class="layui-input input-sm"  value="'+ color +'">');
				}
			})
			//删除规格
			$('#delSize').click(function(){
				$('#size-box').children('input:last').remove();
				
			})
			//删除颜色
			$('#delColor').click(function(){
				$('#color-box').children('input:last').remove();;
			})
		});
		
		//删除图片
		function deletePhoto(obj){
			var num = $(obj).attr('data-img-num');
			var del_path = '';
			$(obj).remove();
			$('#photo-input-box').children('input').each(function(index){
				
				if($(this).attr('data-img-num') == num){
					$(this).remove();
					del_path = $(this).val();
				}
			})
			if($('#photo-input-box').children().length < 4 ){
		      		$('#uploadPhoto').css('display','block');
	      	}
		}
	 </script>
</html>