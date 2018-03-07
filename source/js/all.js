//异步删除	
function ajaxDelete(id, url){
	layer.confirm('确定删除？',function(index){
		$.ajax({
		  	url: url,
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
}					