<?php

    require 'php/config.php';

    $query = mysql_query("SELECT content,user,date FROM lj_article ORDER BY date DESC LIMIT 0,10") or die('SQL 错误！');
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
		<link href="editor/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	    <link href="editor/css/froala_editor.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="css/main.css"/>
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
			<div class="login"><a href="login.html">登录</a></div>
			<div class="reg"><a href="reg.html">注册</a></div>
			<div class="tuichu"><a href="javascript:;">退出</a></div>

		</header>
		<div id="fatieBox">
			<p class="question"></p>
			<section id="editor">
			    <form id="formfatie" name="fatie">
			      <textarea name="content" id='edit' style="margin-top: 30px;">
			      </textarea>
			
			      <input type="button" id="fatieBtn" value="发表">
			    </form>
			</section>
		</div>
		
		<!--content list-->
		<section id="contentBox">
			<ul>
				<?php
				     $_htmllist = array();
	                 while($_rows = mysql_fetch_array($query,MYSQL_ASSOC)){
	                    $_htmllist['user'] = $_rows['user'];
						$_htmllist['content'] = $_rows['content'];
						$_htmllist['date'] = $_rows['date'];
						$_time = $_htmllist['date'];
						$_timecuo = strtotime($_time);
						$_newtime =  tranTime($_timecuo);
						echo '<li><div class="usertime"><span class="user">'.$_htmllist['user'].'</span><span class="time">'.$_newtime.'</span></div><div class="content froala-element not-msie f-basic f-placeholder">'.$_htmllist['content'].'</div><div class="bottomBox"><span class="pinglun">评论(0)</span><span class="zan">赞(0)</span></div></li>';
					};
			    ?>
			</ul>
		</section>
		<!--<div contenteditable="true" class="froala-element not-msie f-basic f-placeholder" style="outline: 0px;" spellcheck="false" data-placeholder="Type something"><p><br></p></div>-->
		<script src="js/jquery-1.12.3.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.cookie.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/json2.js" type="text/javascript" charset="utf-8"></script>
		<script src="editor/js/froala_editor.min.js"></script>
		 <!--[if lt IE 9]>
	    <script src="editor/js/froala_editor_ie8.min.js"></script>
	  <![endif]-->
	  <script src="editor/js/plugins/tables.min.js"></script>
	  <script src="editor/js/plugins/lists.min.js"></script>
	  <script src="editor/js/plugins/colors.min.js"></script>
	  <script src="editor/js/plugins/media_manager.min.js"></script>
	  <script src="editor/js/plugins/font_family.min.js"></script>
	  <script src="editor/js/plugins/font_size.min.js"></script>
	  <script src="editor/js/plugins/block_styles.min.js"></script>
	  <script src="editor/js/plugins/video.min.js"></script>
	  <script type="text/javascript">
		  $(function(){
		  	  $('#edit').editable({inlineMode: false});
		  	  //如果cookie存在，自动登入
				if($.cookie('user')){
					$('.tuichu').show();
					$('.login').find('a').html($.cookie('user')).css('color','#f4c45a');
				}
				
				//退出登入
				$('.tuichu').on('click',function(){
					$.cookie('user','',{expires:-1});
					history.go(0);
				})
				
				
				//alert(jsons[0].id)
				//显示帖子
//				$.ajax({
//					type:"post",
//					url:"php/show_content.php",
//					success:function(response,status,xhr){
//						var jsons = $.parseJSON(response);
//						
//					    alert(jsons[0].content)
//					},
//					async:true
//				});
				
				//发帖
				$('#fatieBtn').on('click',function(){
					if($.cookie('user')){
						$.ajax({
							type:"post",
							url:"php/add_content.php",
							data:{
								user:$.cookie('user'),
								content:$('#edit').val()
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
				
				
				
				
		  })
				
	  </script>
	</body>
</html>
