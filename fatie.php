<?php

    require 'php/config.php';
	$_sql = mysql_query("SELECT COUNT(*) AS count FROM lj_article");
	$_result = mysql_fetch_array($_sql, MYSQL_ASSOC);
	
	$_pagesize = 3;
	$_count = ceil($_result['count'] / $_pagesize);
	$_page = 1;
	if (!isset($_POST['page'])) {
		$_page = 1;
	} else {
		$_page = $_POST['page'];
		if ($_page > $_count) {
			$_page = $_count;
		}
	}
	
	$_limit = ($_page - 1) * $_pagesize;
    //显示贴子
    $query = mysql_query("SELECT (SELECT face_url FROM lj_user WHERE user=a.user) AS faceurl,a.id,a.content,a.user,a.date , a.zan FROM lj_article a ORDER BY a.date DESC LIMIT {$_limit},{$_pagesize}") or die('SQL 错误！');
	
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
		<section id="contentWrap">
			<div class="contentWrapLeft">
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
						
						<?php
						     $_htmllist = array();
			                 while($_rows = mysql_fetch_array($query,MYSQL_ASSOC)){
			                 	$_htmllist['id'] = $_rows['id'];
			                 	$_htmllist['faceurl'] = $_rows['faceurl'];
			                    $_htmllist['user'] = $_rows['user'];
								$_htmllist['content'] = $_rows['content'];
								$_htmllist['date'] = $_rows['date'];
								$_htmllist['zan'] = $_rows['zan'];
								$_time = $_htmllist['date'];
								$_timecuo = strtotime($_time);
								$_newtime =  tranTime($_timecuo);
								echo '<li>'.
								          '<div class="contentwrap">'.
								          	  '<div class="usertime">'.
								          	      '<img class="faceImgs" src="'.$_htmllist['faceurl'].'"/>'.
								          	      '<span class="user">'.$_htmllist['user'].'</span>'.
								          	      '<span class="time">'.$_newtime.'</span>'.
								          	  '</div>'.
								          	  '<div class="content">'.$_htmllist['content'].'</div>'.
								          	  '<div class="bottomBox">'.
								          	      '<span class="pinglun">评论(<em id="count">0</em>)</span>'.
								          	      '<span class="zan">赞(<em id="zan">'.$_htmllist['zan'].'</em>)</span>'.
								          	  '</div>'.
								          '</div>'.
								          '<div class="comment">'.
								                '<div class="biaoji1"></div>'.
									    		'<form id="commentForm">'.
									    			'<input type="hidden" name="articleid" id="articleid" value="'.$_htmllist['id'].'" />'.
									    			'<img id="pinglunFace" class="faceImgs" alt="face" src=""/>'.
									    			'<textarea name="comments" class="emotion" id="textarea"></textarea>'.
									    			'<div class="emoijBox">'.
										    			'<span id="emoij"></span>'.
										    			'<input id="commentBtn" type="button" value="评论" />'.
									    			'</div>'.
									    		'</form>'.
									    		'<div id="showComment">'.
									    			'<ol class="commentOl" id="comments">'.
										    			    
															
									    			'</ol>'.
									    		'</div>'.
									    	'</div>'.
								      '</li>';
							};
					    ?>
					    <div class="addmore">加载更多...</div>
					</ul>
				</section>
			</div>
			<div class="music">
				<iframe frameborder="no" border="0" marginwidth="0" marginheight="0" width=330 height=450 src="//music.163.com/outchain/player?type=0&id=539997813&auto=0&height=430"></iframe>
			</div>
		</section>
		
		
		<div id="loading">
			<p>加载中</p>
		</div>
		<div id="success">
			<p>成功</p>
		</div>
		<div id="tishi">
			<p>请登入后操作</p>
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
		<script src="js/fatie.js" type="text/javascript" charset="utf-8"></script>
		
	  <script type="text/javascript">
		  
		    $(function(){
				$('#jiexi').on('click',function(){
					var inputText = '[左哼哼]';
			        alert(AnalyticEmotion(inputText))
				})
			})
		  
				
	  </script>
	</body>
</html>
