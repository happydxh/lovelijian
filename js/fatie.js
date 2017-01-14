$(function(){
		  	    
		  	    
            
            
	  	  
	  	    //如果cookie存在，自动登入
			if($.cookie('user')){
				$('.tuichu').show();
				$('.login').children('a').html($.cookie('user')).css('color','#f4c45a');
				$.ajax({
					type:"post",
					url:"php/show_face.php",
					data:{
							user:$.cookie('user')
						},
					success:function(texts){
						$('#touxiang').attr('src',texts).show();
					},
					async:true
				});
				
			}
			
			//退出登入
			$('.tuichu').on('click',function(){
				$.cookie('user','',{expires:-1});
				$('#touxiang').hide();
				history.go(0);
			})
			
			//显示隐藏个人中心
			$('#touxiangBox').hover(function(){
				$(this).find('.shezhi').fadeIn();
			},function(){
				$(this).find('.shezhi').fadeOut();
			})
			
			
   
			//显示帖子

			//实例化编辑器
            var ue = UE.getEditor('editor');
			//发帖
			$('#fatieBtn').on('click',function(){
				if($.cookie('user')){
					var loading = $('#loading');
					loading.show();
					$('#loading').find('p').html('发表中..');
					center(loading,200,40)
					$.ajax({
						type:"post",
						url:"php/add_content.php",
						data:{
							user:$.cookie('user'),
							content:ue.getContent()
						},
						success:function(text){
							loading.hide();
							if(text){
								var success = $('#success');
								success.show();
								success.find('p').html('发表成功');
								center(success,200,40);
								setTimeout(function(){
									success.hide();
									history.go(0);
								},1500);
								
							}
						},
						async:true
					});
			    }else{
			    	alert("请先登入")
			    }

			});
			
			

		    var tiezilist = $('#contentBox ul').children('li');
		    tiezilist.each(function(i){
		    	var index = i
		    	//textarea高度自适应
		    	var texts = $(this).find('#textarea').get(0);
                autoTextarea(texts);
		    	// 绑定表情
		    	$(this).find('#emoij').SinaEmotion($(this).find('.emotion'));
		    	
		    	//发表评论
				$(this).find('#commentBtn').on('click',function(){
					var textareas = AnalyticEmotion($(tiezilist[index]).find('#textarea').val());
					var comments = encodeURIComponent(textareas);
					if($.cookie('user')){
						var loading = $('#loading');
						loading.show();
						$('#loading').find('p').html('发表中..');
						center(loading,200,40)
						$.ajax({
							type:"post",
							url:"php/add_comment.php",
							data:{
								user:$.cookie('user'),
								comments:comments,
								articleid:$(tiezilist[index]).find('#articleid').val()
							},
							success:function(text){
								loading.hide();
								if(text){
									var success = $('#success');
									success.show();
									success.find('p').html('发表成功');
									center(success,200,40);
									setTimeout(function(){
										success.hide();
										history.go(0);
									},1500);
									
								}
							},
							async:true
						});
				    }else{
				    	alert("请先登入")
				    }
				});
				
				//显示评论数
				$.ajax({
					type:"post",
					url:"php/show_commentCount.php",
					data:{
						articleid:$(tiezilist[index]).find('#articleid').val()
					},
					success:function(response){
						$(tiezilist[index]).find('#count').text(response)
					},
					async:true
				});
				

//<img src="http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/50/pcmoren_huaixiao_thumb.png" height="22" width="22" />
 //&l&nbsp; &nbsp; ;img src="h&nbsp; &nbsp; &nbsp; &nbsp; p:&xie;&xie;img.&nbsp; &nbsp; .sinajs.cn&xie;&nbsp; &nbsp; 4&xie;apps&nbsp; &nbsp; yle&xie;expression&xie;ex&nbsp; &nbsp; &xie;normal&xie;50&xie;pcmoren_huaixiao_&nbsp; &nbsp; humb.png" heigh&nbsp; &nbsp; ="22" wid&nbsp; &nbsp; h="22" &xie;&g&nbsp; &nbsp; ;               
				//显示评论
				$.ajax({
					type:"post",
					url:"php/show_comment.php",
					data:{
						articleid:$(tiezilist[index]).find('#articleid').val()
					},
					success:function(response){
						//alert(response)
						var json = $.parseJSON(response);
						var html = '';
						//alert(AnalyticEmotion(json[0]['comment']))
						$.each(json, function (index, value) {
							var jiama = decodeURIComponent(value.comment);
							
							html += '<li>'+
				    					'<div class="commentLeft">'+
				    						'<img src="face/test1484196094.jpg"/>'+
				    					'</div>'+
				    					'<div class="commentRight">'+
				    						'<p>'+
					    						'<span class="commentUser">'+value.user+':</span>'+
					    						'<span class="commentContent">'+jiama+'</span>'+
					    				     '</p>'+
					    				    '<div class="commentBottom">'+
					    				    	'<time>'+value.date+'</time>'+
					    				    	'<span class="huifu">回复</span>'+
					    				    '</div>'+
				    					'</div>'+
				    				'</li>';
						});
                        
						$(tiezilist[index]).find('#comments').append(html);
					},
					async:true
				});
		    	
		    })
			
			
			
			
			

            //返回顶部
            $('#back').on('click',function(){
            	$('html,body').animate({
					scrollTop:0
				},800);
            })
            $(window).on('scroll',function(){
            	checkPosition($(window).height())
            })
            
            checkPosition($(window).height())
            
            function checkPosition(pos){
            	if($(window).scrollTop() < pos){
            		$('#back').fadeOut()
            	}else{
            		$('#back').fadeIn()
            	}
            }
            
            
				
	  });