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
            var ue = UE.getEditor('myEditor');
           
			//发帖
			$('#fatieBtn').on('click',function(){
				if($.cookie('user')){
					var article = ue.getContent()
					var articlecontent = encodeURIComponent(article);
					var loading = $('#loading');
					loading.show();
					$('#loading').find('p').html('发表中..');
					center(loading,200,40)
					$.ajax({
						type:"post",
						url:"php/add_content.php",
						data:{
							user:$.cookie('user'),
							content:articlecontent
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
			
			//显示帖子
			$.ajax({
				type:"post",
				url:"php/show_content.php",
				success:function(response){
					var json = $.parseJSON(response);
						var html = '';
				        var tiezicount = 0;
						$.each(json, function (index, value) {
							tiezicount = value.count;
							
							//解码comment
							var jiama = decodeURIComponent(value.content);
							//格式时间
							var unix_time = get_unix_time(value.date);
							var autotime = trantime(unix_time)
							html += '<li>'+
								          '<div class="contentwrap">'+
								          	  '<div class="usertime">'+
								          	      '<img class="faceImgs" src="'+value.faceurl+'"/>'+
								          	      '<span class="user">'+value.user+'</span>'+
								          	      '<span class="time">'+autotime+'</span>'+
								          	  '</div>'+
								          	  '<div class="content">'+jiama+'</div>'+
								          	  '<div class="bottomBox">'+
								          	      '<span class="pinglun">评论(<em id="count">0</em>)</span>'+
								          	      '<span class="zan">赞(<em id="zan">'+value.zan+'</em>)</span>'+
								          	  '</div>'+
								          '</div>'+
								          '<div class="comment">'+
								                '<div class="biaoji1"></div>'+
									    		'<form id="commentForm">'+
									    			'<input type="hidden" name="articleid" id="articleid" value="'+value.id+'" />'+
									    			'<img id="pinglunFace" class="faceImgs" alt="face" src=""/>'+
									    			'<textarea name="comments" class="emotion" id="textarea"></textarea>'+
									    			'<div class="emoijBox">'+
										    			'<span id="emoij"></span>'+
										    			'<input id="commentBtn" type="button" value="评论" />'+
									    			'</div>'+
									    		'</form>'+
									    		'<div id="showComment">'+
									    			'<ol class="commentOl" id="comments">'+
										    			  
									    			'</ol>'+
									    		'</div>'+
									    	'</div>'+
								      '</li>';
						});
						$('#contentUl').append(html);
						$('#contentUl').append('<input type="button" class="addmore" value="加载更多..." />');
						
						//加载更多
						var page = 2;
						var add1 = 0;
						var add2 = 0;
						if (page > tiezicount) {
							$('#contentUl').find('.addmore').off('click');
							$('#contentUl').find('.addmore').hide();
						}
						$('#contentUl').find('.addmore').on('click',function(){
							$('#contentUl').find('.addmore').attr('disabled',true);
							$.ajax({
								type:"post",
								url:"php/show_content.php",
								data:{
									page : page
								},
								beforeSend : function (jqXHR, settings) {
									$('#contentUl').find('.addmore').val('');
									$('#contentUl').find('.addmore').css('background','url(img/loading4.gif) no-repeat center')
								},
								success:function(response){
									var json_more = $.parseJSON(response);
									var html_more = '';
							       
									$.each(json_more, function (index, value) {
										//解码comment
										var jiama = decodeURIComponent(value.content);
										//格式时间
										var unix_time = get_unix_time(value.date);
										var autotime = trantime(unix_time)
										html_more += '<li>'+
											          '<div class="contentwrap">'+
											          	  '<div class="usertime">'+
											          	      '<img class="faceImgs" src="'+value.faceurl+'"/>'+
											          	      '<span class="user">'+value.user+'</span>'+
											          	      '<span class="time">'+autotime+'</span>'+
											          	  '</div>'+
											          	  '<div class="content">'+jiama+'</div>'+
											          	  '<div class="bottomBox">'+
											          	      '<span class="pinglun">评论(<em id="count">0</em>)</span>'+
											          	      '<span class="zan">赞(<em id="zan">'+value.zan+'</em>)</span>'+
											          	  '</div>'+
											          '</div>'+
											          '<div class="comment">'+
											                '<div class="biaoji1"></div>'+
												    		'<form id="commentForm">'+
												    			'<input type="hidden" name="articleid" id="articleid" value="'+value.id+'" />'+
												    			'<img id="pinglunFace" class="faceImgs" alt="face" src=""/>'+
												    			'<textarea name="comments" class="emotion" id="textarea"></textarea>'+
												    			'<div class="emoijBox">'+
													    			'<span id="emoij"></span>'+
													    			'<input id="commentBtn" type="button" value="评论" />'+
												    			'</div>'+
												    		'</form>'+
												    		'<div id="showComment">'+
												    			'<ol class="commentOl" id="comments">'+
													    			  
												    			'</ol>'+
												    		'</div>'+
												    	'</div>'+
											      '</li>';
									});
									$('#contentUl li').last().after(html_more);
									page++;
									if (page > tiezicount) {
										$('#contentUl').find('.addmore').off('click');
										$('#contentUl').find('.addmore').hide();
									}
									$('#contentUl').find('.addmore').val('加载更多...');
									$('#contentUl').find('.addmore').css('background','');
									$('#contentUl').find('.addmore').attr('disabled',false);
									
									//帖子列表
								    var tiezilist = $('#contentBox ul').children('li');
								    add1++
								    add1++
								    tiezilist.each(function(i){
								    	var index = i;
								    	
								    	var indexs = i+add1
								    	//alert(add1)
								    	add2++
								    	add2++
								    	var index1 = i+add2
								    	
								    	//textarea高度自适应
								    	var texts = $(this).find('#textarea').get(0);
						                autoTextarea(texts);
								    	// 绑定表情
								    	$(this).find('#emoij').SinaEmotion($(this).find('.emotion'));
								    	
								    	//评论者头像
								    	if($.cookie('user')){
								    		$.ajax({
												type:"post",
												url:"php/show_face.php",
												data:{
														user:$.cookie('user')
													},
												success:function(texts){
													
													$(tiezilist[index]).find('#pinglunFace').attr('src',texts);
												},
												async:true
											});
								    	}else{
								    		var faceUrl = 'face/moren.png'
								    		$(tiezilist[index]).find('#pinglunFace').attr('src',faceUrl);
								    	}
								    	
										
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
												if($.cookie('user')){
													var pinglun_textarea = ''
													if( /\[[\u0391-\uFFE5\w]*\]/ig.test( $(tiezilist[index]).find('#textarea').val() ) ){
														//解析表情
														pinglun_textarea = AnalyticEmotion($(tiezilist[index]).find('#textarea').val());
													}else{
														pinglun_textarea = $(tiezilist[index]).find('#textarea').val();
													}
													//解析表情
													//var textareas = AnalyticEmotion($(tiezilist[index]).find('#textarea').val());
												    //对发送的内容进行编码
												    var comments = encodeURIComponent(pinglun_textarea);
												    
													var htmls = '';
													htmls += '<li>'+
											    					'<div class="commentLeft">'+
											    						'<img src="face/test1484196094.jpg"/>'+
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
												articleid:$(tiezilist[indexs]).find('#articleid').val()
											},
											success:function(response){ 
												var json = $.parseJSON(response);
												var html = '';
												var placeholder = '';
												var pinglunCount = 0;
										
												$.each(json, function (index, value) {
													pinglunCount = value.count;
													//alert(pinglunCount)
													placeholder = value.user
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
												$(tiezilist[indexs]).find('#comments').append(html);
												$(tiezilist1[index2]).find('#comments').append('<input type="button" class="addMorePinglun" value="加载更多评论..." />');
												//$('#comments').eq(index).append(html);
												//帖子列表
								                var tiezilist1 = $('#contentBox ul').children('li');
								                tiezilist1.each(function(i){
								                	var index2 = i;
								                	//加载更多评论
													
													var page = 2;
													if (page > pinglunCount) {
														$(tiezilist1[index2]).find('#comments').find('.addMorePinglun').off('click');
														$(tiezilist1[index2]).find('#comments').find('.addMorePinglun').hide();
													}
													$(tiezilist1[index2]).find('#comments .addMorePinglun').on('click',function(){
														$(this).attr('disabled',true);
														$.ajax({
															type:"post",
															url:"php/show_comment.php",
															data:{
																articleid:$(tiezilist1[index2]).find('#articleid').val(),
																page:page
															},
															beforeSend : function (jqXHR, settings) {
																$(tiezilist1[index2]).find('#comments .addMorePinglun').val('');
																$(tiezilist1[index2]).find('#comments .addMorePinglun').css('background','url(img/loading4.gif) no-repeat center')
															},
															success:function(response){
																var addComment_json = $.parseJSON(response);
																var addComment_html = '';
																var placeholder = '';
														
																$.each(addComment_json, function (index, value) {
																	//alert(pinglunCount)
																	placeholder = value.user
																	//解码comment
																	var jiama = decodeURIComponent(value.comment);
																	//格式时间
																	var unix_time = get_unix_time(value.date);
																	var autotime = trantime(unix_time)
																	addComment_html += '<li>'+
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
																$(tiezilist1[index2]).find('#comments li').last().after(addComment_html);
																page++;
																if (page > pinglunCount) {
																	$(tiezilist1[index2]).find('#comments .addMorePinglun').off('click');
																	$(tiezilist1[index2]).find('#comments .addMorePinglun').hide();
																}
																$(tiezilist1[index2]).find('#comments .addMorePinglun').val('加载更多...');
																$(tiezilist1[index2]).find('#comments .addMorePinglun').css('background','');
																$(tiezilist1[index2]).find('#comments .addMorePinglun').attr('disabled',false);
															},
															async:true
														});
													});
								                })
												
												
												//评论list
												var commentList = $(tiezilist[index]).find('#comments').children('li');
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
						//															//console.log(placeholder)
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
										
										
								    });
									
								},
								async:true
							});
						})
						
						//帖子列表
					    var tiezilist = $('#contentBox ul').children('li');
					    tiezilist.each(function(i){
					    	var index = i
					    	//textarea高度自适应
					    	var texts = $(this).find('#textarea').get(0);
			                autoTextarea(texts);
					    	// 绑定表情
					    	$(this).find('#emoij').SinaEmotion($(this).find('.emotion'));
					    	
					    	//评论者头像
					    	if($.cookie('user')){
					    		$.ajax({
									type:"post",
									url:"php/show_face.php",
									data:{
											user:$.cookie('user')
										},
									success:function(texts){
										
										$(tiezilist[index]).find('#pinglunFace').attr('src',texts);
									},
									async:true
								});
					    	}else{
					    		var faceUrl = 'face/moren.png'
					    		$(tiezilist[index]).find('#pinglunFace').attr('src',faceUrl);
					    	}
					    	
							
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
									if($.cookie('user')){
										var pinglun_textarea = ''
										if( /\[[\u0391-\uFFE5\w]*\]/ig.test( $(tiezilist[index]).find('#textarea').val() ) ){
											//解析表情
											pinglun_textarea = AnalyticEmotion($(tiezilist[index]).find('#textarea').val());
										}else{
											pinglun_textarea = $(tiezilist[index]).find('#textarea').val();
										}
										//解析表情
										//var textareas = AnalyticEmotion($(tiezilist[index]).find('#textarea').val());
									    //对发送的内容进行编码
									    var comments = encodeURIComponent(pinglun_textarea);
									    
										var htmls = '';
										htmls += '<li>'+
								    					'<div class="commentLeft">'+
								    						'<img src="face/test1484196094.jpg"/>'+
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
									var json = $.parseJSON(response);
									var html = '';
									var placeholder = '';
									var pinglunCount = 0;
							
									$.each(json, function (index, value) {
										pinglunCount = value.count;
										//alert(pinglunCount)
										placeholder = value.user
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
			                        
									$(tiezilist[index]).find('#comments').append(html);
									//$('#comments').eq(index).append(html);
									//加载更多评论
									$(tiezilist[index]).find('#comments').append('<input type="button" class="addMorePinglun" value="加载更多评论..." />');
									var page = 2;
									if (page > pinglunCount) {
										$(tiezilist[index]).find('#comments').find('.addMorePinglun').off('click');
										$(tiezilist[index]).find('#comments').find('.addMorePinglun').hide();
									}
									$(tiezilist[index]).find('#comments .addMorePinglun').on('click',function(){
										$(this).attr('disabled',true);
										$.ajax({
											type:"post",
											url:"php/show_comment.php",
											data:{
												articleid:$(tiezilist[index]).find('#articleid').val(),
												page:page
											},
											beforeSend : function (jqXHR, settings) {
												$(tiezilist[index]).find('#comments .addMorePinglun').val('');
												$(tiezilist[index]).find('#comments .addMorePinglun').css('background','url(img/loading4.gif) no-repeat center')
											},
											success:function(response){
												var addComment_json = $.parseJSON(response);
												var addComment_html = '';
												var placeholder = '';
										
												$.each(addComment_json, function (index, value) {
													//alert(pinglunCount)
													placeholder = value.user
													//解码comment
													var jiama = decodeURIComponent(value.comment);
													//格式时间
													var unix_time = get_unix_time(value.date);
													var autotime = trantime(unix_time)
													addComment_html += '<li>'+
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
												$(tiezilist[index]).find('#comments li').last().after(addComment_html);
												page++;
												if (page > pinglunCount) {
													$(tiezilist[index]).find('#comments .addMorePinglun').off('click');
													$(tiezilist[index]).find('#comments .addMorePinglun').hide();
												}
												$(tiezilist[index]).find('#comments .addMorePinglun').val('加载更多...');
												$(tiezilist[index]).find('#comments .addMorePinglun').css('background','');
												$(tiezilist[index]).find('#comments .addMorePinglun').attr('disabled',false);
											},
											async:true
										});
									});
									
									//评论list
									var commentList = $(tiezilist[index]).find('#comments').children('li');
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
			//															//console.log(placeholder)
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
							
							
					    });
				},
				async:true
			});
			
			
            
			
			
			//帖子加载更多
			
			
			

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