<script type="text/javascript" src="/source/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/source/layui/layui.all.js"></script>
<script type="text/javascript" src="/source/js/all.js"></script>
<script type="text/javascript">
	layui.use('form', function(){
		  var form = layui.form;
		  	  //自定义验证规则
	  	  form.verify({
		    account: function(value){
		     if(!/^\w{8,20}$/.test(value)){
		      return '账号必须是长度8-20之间的数字和字母';
		     }
		    }, 
		    password: function(value){
		     if(!/^[^\'\"]{6,20}$/.test(value)){
		      return '密码的长度必须在6-20之间,且不能包含引号';
		     }
		    },
		    address: function(value){
	    	 if(value.length > 100){
		      return '地址长度不能大于100';
		     }
		    },
		    nickname: function(value){
	    	 if(value.length > 20){
		      return '昵称长度不能大于20';
		     }
		    },
		    good_name: function(value){
	    	 if(value.length > 30){
		      return '商品名称长度不能大于30';
		     }
		    },
		    price: function(value){
	    	 if(!/^\d{1,10}(\.\d{1,2})?$/.test(value)){
		      return '商品价格过大或格式错误';
		     }
		    },
		    intro: function(value){
	    	 if(value.length > 200){
		      return '商品简介长度不能大于200';
		     }
		    },
		    verify_code: function(value){
	    	 if(!/^\w{4}$/.test(value)){
		      return '验证码格式错误';
		     }
		 	}
	  	});
	});
</script>
