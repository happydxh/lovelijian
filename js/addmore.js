$(function(){
	
	    //格式时间
	    var time = $('#contentUl li').find('.time').attr('datatime');
	    var unix_time = get_unix_time(time);
		var autotime = trantime(unix_time);
		$('#contentUl li').find('.time').text(autotime);
		//解码帖子内容
		var content = $('#contentUl li').find('.content').attr('datacomment');
		var jiema = decodeURIComponent(content);
		$('#contentUl li').find('.content').html(jiema);
		
		//textarea高度自适应
		var texts = $('#textarea').get(0);
	    autoTextarea(texts);
	    // 绑定表情
		$('#emoij').SinaEmotion($('#contentBox ul li').find('.emotion'));
		
		//评论者头像
		if($.cookie('user')){
			$.ajax({
				type:"post",
				url:"php/show_face.php",
				data:{
						user:$.cookie('user')
					},
				success:function(texts){
					$('#contentBox ul li').find('#pinglunFace').attr('src',texts);
				},
				async:true
			});
		}else{
			var faceUrl = 'face/moren.png'
			$('#contentBox ul li').find('#pinglunFace').attr('src',faceUrl);
		}
		
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
						url:"php/add_comment.php",
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
			url:"php/show_commentCount.php",
			data:{
				articleid:$('#articleid').val()
			},
			success:function(response){
				$('#count').text(response)
			},
			async:true
		});
		
		//点赞
		$('#contentBox ul li').find('.zan').on('click',function(){
			var zanCount = $('#zan').text();
			zanCount++
			$('#zan').text(zanCount);
			$.ajax({
				type:"post",
				url:"php/add_zan.php",
				data:{
					articleid:$('#articleid').val(),
					zan:zanCount
				},
				async:true
			});
		});
		
		//显示评论
		$.ajax({
			type:"post",
			url:"php/addmore_showcomment.php",
			data:{
				articleid:$('#articleid').val()
			},
			success:function(response){ 
				var json = $.parseJSON(response);
				var html = '';
				var placeholder = '';
				var pinglunCount = 0;
				$.each(json, function (index, value) {
					pinglunCount = value.count;
					placeholder = value.user;
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
			    				    '<div id="answerBox">'+
			    				        '<dl class="answerol">'+
							    		
							    		'</dl>'+
				    				    '<form id="answerForm" >'+
							    			'<input type="hidden" name="commentid" id="commentid" value="'+value.id+'" />'+
							    			'<textarea name="answer_comment" class="answer_textarea" autofocus="autofocus"  placeholder="" id="answer_textarea"></textarea>'+
							    			'<div class="emoijBox">'+
								    			'<span class="answer_emoij" id="answer_emoij"></span>'+
								    			'<input class="answer_Btn" id="answer_Btn" type="button" value="评论" />'+
							    			'</div>'+
							    		'</form>'+
							    		
						    		'</div>'+
		    					'</div>'+
		    				'</li>';
				});
                
				$('#comments').append(html);
				var commentList = $('#comments').children('li');
				commentList.each(function(i){
				var commentindex = i;
				
				//显示隐藏回复标签
				$(this).find('.huifu').on('click',function(){
					$(commentList[commentindex]).find('#answerForm').toggle();
					$(commentList[commentindex]).find('#answer_textarea').attr('placeholder','回复@'+placeholder+':');
				})
				
				//textarea高度自适应
		    	var texts = $(this).find('#answer_textarea').get(0);
                autoTextarea(texts);
		    	// 绑定表情
		    	$(this).find('#answer_emoij').SinaEmotion($(this).find('.answer_textarea'));
		    	
		    	//发表回复
				$(this).find('#answer_Btn').on('click',function(){
					
					if( $(commentList[commentindex]).find('#answer_textarea').val() == '' ){
						var tishi = $('#tishi');
							tishi.show();
							$('#tishi').find('p').html('内容不得为空哦！');
							center(tishi,200,40);
							setTimeout(function(){
								tishi.hide();
							},1500);
					}else{
						if($.cookie('user')){
							var answer_textarea = ''
							if( /\[[\u0391-\uFFE5\w]*\]/ig.test( $(commentList[commentindex]).find('#answer_textarea').val() ) ){
								//解析表情
								answer_textarea = AnalyticEmotion($(commentList[commentindex]).find('#answer_textarea').val());
							}else{
								answer_textarea = $(commentList[commentindex]).find('#answer_textarea').val();
							}
							
							
						    //对发送的内容进行编码
						    var answer_comment = encodeURIComponent(answer_textarea);
						    
						
						    
						    var ansuser =  $(this).parents('#answerForm').find('#answer_textarea').attr('placeholder').substr(3);
						   
						    
							var answer_html = '';
							answer_html += '<dt>'+
								    				'<p class="ans_comment"><span class="answer_user">'+$.cookie('user')+':</span> 回复 <span class="answer_user">'+ansuser+'</span>'+ answer_textarea+'</p>'+
								    			    '<div class="answerBottom">'+
								    					'<time>刚刚</time>'+
								    					'<span class="huifu">回复</span>'+
								    				'</div>'+
							    			'</dt>';
							
							
	                        $(commentList[commentindex]).find('.answerol').prepend(answer_html);
	                        
						
							$.ajax({
								type:"post",
								url:"php/add_answer.php",
								data:{
									user:$.cookie('user'),
									answer_comment:answer_comment,
									commentid:$(commentList[commentindex]).find('#commentid').val()
								},
								success:function(response){
									if(response == 1){
										$(commentList[commentindex]).find('#answerForm')[0].reset();
									}
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
				
				//显示回复
				$.ajax({
					type:"post",
					url:"php/show_answer.php",
					data:{
						commentid:$(commentList[commentindex]).find('#commentid').val()
					},
					success:function(response){
						var answer_json = $.parseJSON(response);
						var html = '';
						
						$.each(answer_json, function (index, value) {
							//解码comment
							var jiama = decodeURIComponent(value.comment);
							//格式时间
							var unix_time = get_unix_time(value.date);
							var autotime = trantime(unix_time);
						
							html+='<dt>'+
						    				'<p class="ans_comment"><span class="placeholder answer_user">'+value.user+':</span> 回复 <span class="answer_user">'+value.ansuser+':</span>'+jiama+'</p>'+
						    			    '<div class="answerBottom">'+
						    					'<time>'+autotime+'</time>'+
						    					'<span class="huifu" dataid="'+value.id+'">回复</span>'+
						    				'</div>'+
					    			'</dt>';
						});
						$(commentList[commentindex]).find('.answerol').append(html);
						
						
						
						//回复list
						var huifuList = $(commentList[commentindex]).find('.answerol').find('dt');
						huifuList.each(function(i){
							var huifuindex = i;
							//显示隐藏回复标签
							
							$(huifuList[huifuindex]).find('.huifu').on('click',function(){
								var placeholder = $(this).parents('dt').find('.placeholder').text();
								//console.log(placeholder)
								$(commentList[commentindex]).find('#answerForm').show();
								$(commentList[commentindex]).find('#commentid').val($(this).attr('dataid'))
								$(commentList[commentindex]).find('#answer_textarea').attr('placeholder','回复@'+placeholder);
							})	
								
								//显示回复
								$.ajax({
									type:"post",
									url:"php/show_answer.php",
									data:{
										commentid:$(this).find('.huifu').attr('dataid')
									},
									success:function(response){
										var answer_json = $.parseJSON(response);
										var html = '';
										//alert(AnalyticEmotion(json[0]['comment']))
										$.each(answer_json, function (index, value) {
											//解码comment
											var jiama = decodeURIComponent(value.comment);
											//格式时间
											var unix_time = get_unix_time(value.date);
											var autotime = trantime(unix_time);
											
											html+='<dt>'+
										    				'<p class="ans_comment"><span class="placeholder answer_user">'+value.user+':</span> 回复 <span class="answer_user">'+value.ansuser+':</span>'+jiama+'</p>'+
										    			    '<div class="answerBottom">'+
										    					'<time>'+autotime+'</time>'+
										    					'<span class="huifu" dataid="'+value.id+'">回复</span>'+
										    				'</div>'+
									    			'</dt>';
										});
										$(commentList[commentindex]).find('.answerol').append(html);
										
										
										//回复list
										var huifuList = $(commentList[commentindex]).find('.answerol').children('dt');
										huifuList.each(function(i){
											var huifuindex = i;
											//显示隐藏回复标签
										
											$(this).find('.huifu').on('click',function(){
												
											var placeholder = $(this).parents('dt').find('.placeholder').text();
											$(commentList[commentindex]).find('#answerForm').show();
											$(commentList[commentindex]).find('#commentid').val($(this).attr('dataid'))
											$(commentList[commentindex]).find('#answer_textarea').attr('placeholder','回复@'+placeholder);
												
											  
											})
										})
									},
									async:true
								});
							    
								
								
							
							
						})
					},
					async:true
				});
					    	
			});
			},
			async:true
		});
	
	
	
	
	
})