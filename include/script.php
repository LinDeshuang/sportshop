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
		    consignee: function(value){
	    	 if(value.length > 20){
		      return '收货人姓名长度不能大于20';
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
