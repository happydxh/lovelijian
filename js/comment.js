$(function(){
	
		//textarea高度自适应
		var texts = $('#textarea').get(0);
	    autoTextarea(texts);
	    // 绑定表情
		$('#emoij').SinaEmotion($('#contentBox ul li').find('.emotion'));
		
		//评论者头像
		if($.cookie('user')){
			$.ajax({
				type:"post",
				url:"../php/show_face.php",
				data:{
						user:$.cookie('user')
					},
				success:function(texts){
					$('#contentBox ul li').find('#pinglunFace').attr('src','../'+texts);
				},
				async:true
			});
		}else{
			var faceUrl = '../face/moren.png'
			$('#contentBox ul li').find('#pinglunFace').attr('src',faceUrl);
		};
		
		//发表评论
		
		
		//显示评论数
		
		
		
		
	
	
	
})
