<?php

    require 'php/config.php';

    $query = mysql_query("SELECT content,user,date FROM lj_article ORDER BY date DESC LIMIT 0,20") or die('SQL 错误！');
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
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>发帖</title>
		<link rel="stylesheet" type="text/css" href="css/main.css"/>
		<script type="text/javascript" charset="utf-8" src="UMeditor/ueditor.config.js"></script>
	    <script type="text/javascript" charset="utf-8" src="UMeditor/ueditor.all.min.js"> </script>
	    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
	    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
	    <script type="text/javascript" charset="utf-8" src="UMeditor/lang/zh-cn/zh-cn.js"></script>
		
	</head>
	
	<body style="background: #E9EDF0;">
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
			<div class="login"><a href="login.html">登录</a><img id="touxiang" src="face/moren.png" alt="头像"/></div>
			<div class="reg"><a href="reg.html">注册</a></div>
			<div class="tuichu"><a href="javascript:;">退出</a></div>

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
			    	<div class="usertime">
			    		<span class="user">刘看山</span>
			    		<span class="time">2017-01-07 10:10:10</span>
			    	</div>
			    	<div class="content">打开国际视野，来看国外设计师是怎么找灵感，看待雾霾。（他欣赏的国内设计大神会是谁呢？）[可爱]预告：这个月也会为追波人气第一名的Mike 大神做一期专</div>
			    	<div class="bottomBox">
			    		<span class="pinglun">评论(0)</span>
			    		<span class="zan">赞(0)</span>
			    	</div>
			    </li>
				<?php
				     $_htmllist = array();
	                 while($_rows = mysql_fetch_array($query,MYSQL_ASSOC)){
	                    $_htmllist['user'] = $_rows['user'];
						$_htmllist['content'] = $_rows['content'];
						$_htmllist['date'] = $_rows['date'];
						$_time = $_htmllist['date'];
						$_timecuo = strtotime($_time);
						$_newtime =  tranTime($_timecuo);
						echo '<li><div class="usertime"><span class="user">'.$_htmllist['user'].'</span><span class="time">'.$_newtime.'</span></div><div class="content">'.$_htmllist['content'].'</div><div class="bottomBox"><span class="pinglun">评论(0)</span><span class="zan">赞(0)</span></div></li>';
					};
			    ?>
			</ul>
		</section>
		<div id="back"></div>
		<script src="js/jquery-1.12.3.min.js" type="text/javascript" charset="utf-8"></script>
		<!--编辑器-->
		<!--<script type="text/javascript" src="UMeditor/third-party/jquery.min.js"></script>
	    <script type="text/javascript" charset="utf-8" src="UMeditor/umeditor.config.js"></script>
	    <script type="text/javascript" charset="utf-8" src="UMeditor/umeditor.min.js"></script>
	    <script type="text/javascript" src="UMeditor/lang/zh-cn/zh-cn.js"></script>-->
		
		<script src="js/jquery.cookie.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/json2.js" type="text/javascript" charset="utf-8"></script>
		
		
		
	  <script type="text/javascript">
		  $(function(){
		  	  //实例化编辑器
              var ue = UE.getEditor('editor');
		  	  
		  	  //如果cookie存在，自动登入
				if($.cookie('user')){
					$('.tuichu').show();
					$('.login').find('a').html($.cookie('user')).css('color','#f4c45a');
					$('#touxiang').show();
				}
				
				//退出登入
				$('.tuichu').on('click',function(){
					$.cookie('user','',{expires:-1});
					$('#touxiang').hide();
					history.go(0);
				})
				
				

				//显示帖子

				
				//发帖
				$('#fatieBtn').on('click',function(){
					if($.cookie('user')){
						$.ajax({
							type:"post",
							url:"php/add_content.php",
							data:{
								user:$.cookie('user'),
								content:ue.getContent()
							},
							success:function(text){
								if(text){
									alert("发表成功 ")
									history.go(0);
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
