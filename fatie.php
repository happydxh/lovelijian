<?php

    require 'php/config.php';

    $query = mysql_query("SELECT (SELECT face_url FROM lj_user WHERE user=a.user) AS faceurl,a.content,a.user,a.date FROM lj_article a ORDER BY a.date DESC LIMIT 0,20") or die('SQL 错误！');
    date_default_timezone_set('PRC');
	function tranTime($time) { 
	    $rtime = date("Y-m-d H:i:s",$time); 
	    $htime = date("H:i",$time); 
	     
	    $time = time() - $time; 
	 
	    if ($time < 60) { 
	        $str = '刚刚'; 
	    } 
	    elseif ($time < 60 * 60) { 
	        $min = floor($time/60); 
	        $str = $min.'分钟前'; 
	    } //时间轴 www.jbxue.com
	    elseif ($time < 60 * 60 * 24) { 
	        $h = floor($time/(60*60)); 
	        $str = $h.'小时前 '.$htime; 
	    } 
	    elseif ($time < 60 * 60 * 24 * 3) { 
	        $d = floor($time/(60*60*24)); 
	        if($d==1) 
	           $str = '昨天 '.$rtime; 
	        else 
	           $str = '前天 '.$rtime; 
	    } 
	    else { 
	        $str = $rtime; 
	    } 
	    return $str; 
	} 
	
//	$now = time();
//	
//	$base64 = "";
//	$img = base64_decode($base64);
//	$a = file_put_contents('face/test'.$now.'.jpg', $img);//返回的是字节数
//	$b = 'face/test'.$now.'.jpg';
//	print_r($b);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>发帖</title>
		<link rel="stylesheet" type="text/css" href="css/main.css"/>
		<link rel="stylesheet" type="text/css" href="emoji/jquery.sinaEmotion.css"/>
		<script type="text/javascript" charset="utf-8" src="UMeditor/ueditor.config.js"></script>
	    <script type="text/javascript" charset="utf-8" src="UMeditor/ueditor.all.min.js"> </script>
	    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
	    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
	    <script type="text/javascript" charset="utf-8" src="UMeditor/lang/zh-cn/zh-cn.js"></script>
		
	</head>
	
	<body style="background: rgba(133, 175, 216, 0.38);">
		<header id="header" style="background: #0c0a0d;">
			<h2 class="logo">爱李健</h2>
			<nav class="nav">
				<ul>
					<li><a href="index.html">首页</a></li>
					<li><a href="music.html">专辑</a></li>
					<li><a href="video.html">视频</a></li>
					<li><a href="fatie.html" class="active">发帖</a></li>
					<li><a href="about.html">关于</a></li>
				</ul>
			</nav>
			<div class="login">
				<a href="login.html">登录</a>
				<span id="touxiangBox">
					<img id="touxiang" src="" alt="头像"/>
					<div class="shezhi">
						<span class="jiantuo"></span>
						<ul>
							<li><a href="changeface.html">更改头像</a></li>
							<li class="tuichu"><a href="javascript:;">退出</a></li>
						</ul>
					</div>
				</span>
			</div>
			<div class="reg"><a href="reg.html">注册</a></div>
			

		</header>
		<div id="fatieBox">
			<p class="question"></p>
			<section id="editor">
			    <form id="formfatie" name="fatie">
			        <!--style给定宽度可以影响编辑器的最终宽度-->
					<script type="text/plain" id="myEditor" style="width:560px;height:100px;"></script>
			        
			        
			    </form>
			    
			</section>
			<input type="button" id="fatieBtn" value="发表">
		</div>
		
		<!--content list-->
		<section id="contentBox">
			<ul>
				<li>
					<div class="contentwrap">
				    	<div class="usertime">
				    		<img class="faceImgs" src="face/test1484196094.jpg"/>
				    		<span class="user">刘看山</span>
				    		<span class="time">2017-01-07 10:10:10</span>
				    	</div>
				    	<div class="content">打开国际视野，来看国外设计师是怎么找灵感，看待雾霾。（他欣赏的国内设计大神会是谁呢？）[可爱]预告：这个月也会为追波人气第一名的Mike 大神做一期专</div>
				    	<div class="bottomBox">
				    		<span class="pinglun">评论(0)</span>
				    		<span class="zan">赞(0)</span>
				    	</div>
			    	</div>
			    	<div class="comment">
			    		<form id="commentForm">
			    			<img class="faceImgs" src="face/test1484196094.jpg"/>
			    			<textarea class="emotion" id="textarea"></textarea>
			    			<div class="emoijBox">
				    			<span id="emoij"></span>
				    			<input id="commentBtn" type="button" value="评论" />
			    			</div>
			    		</form>
			    	</div>
			    </li>
				<?php
				     $_htmllist = array();
	                 while($_rows = mysql_fetch_array($query,MYSQL_ASSOC)){
	                 	$_htmllist['faceurl'] = $_rows['faceurl'];
	                    $_htmllist['user'] = $_rows['user'];
						$_htmllist['content'] = $_rows['content'];
						$_htmllist['date'] = $_rows['date'];
						$_time = $_htmllist['date'];
						$_timecuo = strtotime($_time);
						$_newtime =  tranTime($_timecuo);
						echo '<li><div class="contentwrap"><div class="usertime"><img class="faceImgs" src="'.$_htmllist['faceurl'].'"/><span class="user">'.$_htmllist['user'].'</span><span class="time">'.$_newtime.'</span></div><div class="content">'.$_htmllist['content'].'</div><div class="bottomBox"><span class="pinglun">评论(0)</span><span class="zan">赞(0)</span></div></div></li>';
					};
			    ?>
			</ul>
		</section>
		<div id="loading">
			<p>加载中</p>
		</div>
		<div id="success">
			<p>成功</p>
		</div>
		<div id="back"></div>
		<script src="js/jquery-1.12.3.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/tool.js" type="text/javascript" charset="utf-8"></script>
		<!--编辑器-->
		<!--<script type="text/javascript" src="UMeditor/third-party/jquery.min.js"></script>
	    <script type="text/javascript" charset="utf-8" src="UMeditor/umeditor.config.js"></script>
	    <script type="text/javascript" charset="utf-8" src="UMeditor/umeditor.min.js"></script>
	    <script type="text/javascript" src="UMeditor/lang/zh-cn/zh-cn.js"></script>-->
		
		<script src="js/jquery.cookie.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/json2.js" type="text/javascript" charset="utf-8"></script>
		<script src="emoji/jquery.sinaEmotion.js" type="text/javascript" charset="utf-8"></script>
		
		
	  <script type="text/javascript">
		  $(function(){
		  	    
		  	    //textarea高度自适应
		  	    var texts = document.getElementById("textarea");
                autoTextarea(texts);
                
                // 绑定表情
		        $('#emoij').SinaEmotion($('.emotion'));
		  	  
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
				
		  })
				
	  </script>
	</body>
</html>
