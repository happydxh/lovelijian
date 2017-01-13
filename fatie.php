<?php

    require 'php/config.php';
    //显示贴子
    $query = mysql_query("SELECT (SELECT face_url FROM lj_user WHERE user=a.user) AS faceurl,a.id,a.content,a.user,a.date FROM lj_article a ORDER BY a.date DESC LIMIT 0,20") or die('SQL 错误！');
	//显示评论
//	$_id = $_POST['articleid'];
//	echo 1;
//	exit;
//	$_commentquery = mysql_query("SELECT comment,user,date FROM lj_comment WHERE articleid='{$_POST['articleid']}' ORDER BY date DESC LIMIT 0,10") or die('SQL 错误！');
//  $_commentlist = array();
//									                 while($_rows = mysql_fetch_array($_commentquery,MYSQL_ASSOC)){
//									                    $_commentlist['user'] = $_rows['user'];
//														$_commentlist['comment'] = $_rows['comment'];
//														$_commentlist['date'] = $_rows['date'];
//														$_time = $_commentlist['date'];
//														$_timecuo = strtotime($_time);
//														$_newtime =  tranTime($_timecuo);
//													    echo '<li>'.
//										    					'<div class="commentLeft">'.
//										    						'<img src="face/test1484196094.jpg"/>'.
//										    					'</div>'.
//										    					'<div class="commentRight">'.
//										    						'<p>'.
//											    						'<span class="commentUser">'.$_commentlist['user'].':</span>'.
//											    						'<span class="commentContent">'.$_commentlist['comment'].'</span>'.
//											    				     '</p>'.
//											    				    '<div class="commentBottom">'.
//											    				    	'<time>'.$_newtime.'</time>'.
//											    				    	'<span class="huifu">回复</span>'.
//											    				    '</div>'.
//										    					'</div>'.
//										    				 '</li>';
//													    }; 
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
			    		<form id="commentForm" >
			    			<input type="hidden" name="articleid" id="articleid" value="1" />
			    			<img class="faceImgs" src="face/test1484196094.jpg"/>
			    			<textarea name="comments" class="emotion" id="textarea"></textarea>
			    			<div class="emoijBox">
				    			<span id="emoij"></span>
				    			<input id="commentBtn" type="button" value="评论" />
			    			</div>
			    		</form>
			    		<div id="showComment">
			    			<ol>
			    				<li>
			    					<div class="commentLeft">
			    						<img src="face/test1484196094.jpg"/>
			    					</div>
			    					<div class="commentRight">
			    						<p>
				    						<span class="commentUser">千百度:</span>
				    						<span class="commentContent">打开国际视野，来看国外设计师是怎么找灵感 来啦！C3PO是经典电影系列中一个重要的机械人。它性格怕事懦弱，但对主人绝无异心。那怕自己受困苦捱灾难，仍会随传随到，功成身退后将爱拱手相让也无怨言。[心]这首歌将它的默默付出，一一诉说。</span>
				    				    </p>
				    				    <div class="commentBottom">
				    				    	<time>2016-12-12 12:12:12</time>
				    				    	<span class="huifu">回复</span>
				    				    </div>
			    					</div>
			    				</li>
			    				<li>
			    					<div class="commentLeft">
			    						<img src="face/test1484196094.jpg"/>
			    					</div>
			    					<div class="commentRight">
			    						<p>
				    						<span class="commentUser">千百度:</span>
				    						<span class="commentContent">打开国际视野，来看国外设计师是怎么找灵感</span>
				    				    </p>
				    				    <div class="commentBottom">
				    				    	<time>今天</time>
				    				    	<span class="huifu">回复</span>
				    				    </div>
			    					</div>
			    				</li>
			    			</ol>
			    		</div>
			    	</div>
			    </li>
				<?php
				     $_htmllist = array();
	                 while($_rows = mysql_fetch_array($query,MYSQL_ASSOC)){
	                 	$_htmllist['id'] = $_rows['id'];
	                 	$_htmllist['faceurl'] = $_rows['faceurl'];
	                    $_htmllist['user'] = $_rows['user'];
						$_htmllist['content'] = $_rows['content'];
						$_htmllist['date'] = $_rows['date'];
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
						          	      '<span class="zan">赞(0)</span>'.
						          	  '</div>'.
						          '</div>'.
						          '<div class="comment">'.
							    		'<form id="commentForm">'.
							    			'<input type="hidden" name="articleid" id="articleid" value="'.$_htmllist['id'].'" />'.
							    			'<img class="faceImgs" src="'.$_htmllist['faceurl'].'"/>'.
							    			'<textarea name="comments" class="emotion" id="textarea"></textarea>'.
							    			'<div class="emoijBox">'.
								    			'<span id="emoij"></span>'.
								    			'<input id="commentBtn" type="button" value="评论" />'.
							    			'</div>'.
							    		'</form>'.
							    		'<div id="showComment">'.
							    			'<ol id="comments">'.
								    			    
													
							    			'</ol>'.
							    		'</div>'.
							    	'</div>'.
						      '</li>';
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
