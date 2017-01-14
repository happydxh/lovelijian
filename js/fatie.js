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
		    	
		    	//评论者头像
		    	$.ajax({
					type:"post",
					url:"php/show_face.php",
					data:{
							user:$.cookie('user')
						},
					success:function(texts){
						//alert(texts)
						
						$(tiezilist[index]).find('#pinglunFace').attr('src',texts);
					},
					async:true
				});
				
		    	//发表评论
				$(this).find('#commentBtn').on('click',function(){
					if( $(tiezilist[index]).find('#textarea').val() == '' ){
						var tishi = $('#tishi');
							tishi.show();
							$('#tishi').find('p').html('评论内容不得为空哦！');
							center(tishi,200,40);
							setTimeout(function(){
								tishi.hide();
							},1500);
					}else{
						var textareas = AnalyticEmotion($(tiezilist[index]).find('#textarea').val());
						var comments = encodeURIComponent(textareas);
						if($.cookie('user')){
							var htmls = '';
							htmls += '<li>'+
					    					'<div class="commentLeft">'+
					    						'<img src="face/test1484196094.jpg"/>'+
					    					'</div>'+
					    					'<div class="commentRight">'+
					    						'<p>'+
						    						'<span class="commentUser">'+$.cookie('user')+':</span>'+
						    						'<span class="commentContent">'+textareas+'</span>'+
						    				     '</p>'+
						    				    '<div class="commentBottom">'+
						    				    	'<time>刚刚</time>'+
						    				    	'<span class="huifu">回复</span>'+
						    				    '</div>'+
					    					'</div>'+
					    				'</li>';
							
	                        
							$(tiezilist[index]).find('#comments').prepend(htmls);
							$(tiezilist[index]).find('#commentForm')[0].reset();
							
							//评论数
							var count = $(tiezilist[index]).find('#count').text();
							count++
							$(tiezilist[index]).find('#count').text(count);
							$.ajax({
								type:"post",
								url:"php/add_comment.php",
								data:{
									user:$.cookie('user'),
									comments:comments,
									articleid:$(tiezilist[index]).find('#articleid').val()
								},
	//							success:function(text){
	//								loading.hide();
	//								if(text){
	//									var success = $('#success');
	//									success.show();
	//									success.find('p').html('发表成功');
	//									center(success,200,40);
	//									setTimeout(function(){
	//										success.hide();
	//										//history.go(0);
	//									},1500);
	//									
	//								}
	//							},
								async:true
							});
					    }else{
					    	alert("请先登入")
					    }
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
				
				//点赞
				$(tiezilist[index]).find('.zan').on('click',function(){
					var zanCount = $(tiezilist[index]).find('#zan').text();
					zanCount++
					$(tiezilist[index]).find('#zan').text(zanCount);
					$.ajax({
						type:"post",
						url:"php/add_zan.php",
						data:{
							articleid:$(tiezilist[index]).find('#articleid').val(),
							zan:zanCount
						},
						async:true
					});
				})
				
				

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
							//解码comment
							var jiama = decodeURIComponent(value.comment);
							//格式时间
							var unix_time = get_unix_time(value.date);
							var autotime = trantime(unix_time)
							html += '<li>'+
				    					'<div class="commentLeft">'+
				    						'<img src="'+value.faceurl+'"/>'+
				    					'</div>'+
				    					'<div class="commentRight">'+
				    						'<p>'+
					    						'<span class="commentUser">'+value.user+':</span>'+
					    						'<span class="commentContent">'+jiama+'</span>'+
					    				     '</p>'+
					    				    '<div class="commentBottom">'+
					    				    	'<time>'+autotime+'</time>'+
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