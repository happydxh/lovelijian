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
		$('#contentBox ul li').find('#commentBtn').on('click',function(){
			if( $('#contentBox ul li').find('#textarea').val() == '' ){
				var tishi = $('#tishi');
					tishi.show();
					$('#tishi').find('p').html('评论内容不得为空哦！');
					center(tishi,200,40);
					setTimeout(function(){
						tishi.hide();
					},1500);
			}else{
				if($.cookie('user')){
					var src = $('#pinglunFace').attr('src');
					var pinglun_textarea = ''
					if( /\[[\u0391-\uFFE5\w]*\]/ig.test( $('#contentBox ul li').find('#textarea').val() ) ){
						//解析表情
						pinglun_textarea = AnalyticEmotion($('#contentBox ul li').find('#textarea').val());
					}else{
						pinglun_textarea = $('#contentBox ul li').find('#textarea').val();
					}
				    //对发送的内容进行编码
				    var comments = encodeURIComponent(pinglun_textarea);
				    
					var htmls = '';
					htmls += '<li>'+
			    					'<div class="commentLeft">'+
			    						'<img src="'+src+'"/>'+
			    					'</div>'+
			    					'<div class="commentRight">'+
			    						'<p>'+
				    						'<span class="commentUser">'+$.cookie('user')+':</span>'+
				    						'<span class="commentContent">'+pinglun_textarea+'</span>'+
				    				     '</p>'+
				    				    '<div class="commentBottom">'+
				    				    	'<time>刚刚</time>'+
				    				    	'<span class="huifu">回复</span>'+
				    				    '</div>'+
			    					'</div>'+
			    				'</li>';
					
                    
					$('#contentBox ul li').find('#comments').prepend(htmls);
					$('#contentBox ul li').find('#commentForm')[0].reset();
					
					//评论数
					var count = $('#contentBox ul li').find('#count').text();
					count++
					$('#contentBox ul li').find('#count').text(count);
					$.ajax({
						type:"post",
						url:"../php/add_comment.php",
						data:{
							user:$.cookie('user'),
							comments:comments,
							articleid:$('#contentBox ul li').find('#articleid').val()
						},
						async:true
					});
			    }else{
			    	var tishi = $('#tishi');
					tishi.show();
					$('#tishi').find('p').html('请登入后操作');
					center(tishi,200,40);
					setTimeout(function(){
						tishi.hide();
					},1500);
			    }
		   }
		});
		
		//显示评论数
		$.ajax({
			type:"post",
			url:"../php/show_commentCount.php",
			data:{
				articleid:$('#articleid').val()
			},
			success:function(response){
				$('#count').text(response)
			},
			async:true
		});
		
	
	
	
})
