<?php
    require 'php/config.php';
	if($_GET['id']){
		$_query = mysql_query("SELECT title, id,content,date,zan,readcount FROM lj_dongtai a WHERE id='{$_GET['id']}' ORDER BY date DESC") or die('SQL 错误！');
		$_rows = mysql_fetch_array($_query,MYSQL_ASSOC);
		if($_rows){
			//累积阅读量
			mysql_query("UPDATE lj_dongtai SET readcount = readcount+1 WHERE id='{$_GET['id']}' ");
			$_html = array();
			$_html['id'] = $_rows['id'];
			$_html['title'] = $_rows['title'];
			$_html['content'] = $_rows['content'];
			$_html['date'] = $_rows['date'];
			$_html['zan'] = $_rows['zan'];
			$_html['readcount'] = $_rows['readcount'];
		}else{
			echo "非法操作。。。";
			exit;
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>动态</title>
		<link rel="stylesheet" type="text/css" href="css/main.css"/>
		<link rel="stylesheet" type="text/css" href="emoji/jquery.sinaEmotion.css"/>
		
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
				<!--content-->
				<section id="contentBox">
					<ul id="contentUl">
						<li>
					         <div class="contentwrap">
					          	  <div class="usertime">
					          	      <h3 id="title" style="font-size: 18px;" datatitle="<?php echo $_html['title']?>"></h3>
					          	  </div>
					          	  <div class="content" datacomment="<?php echo $_html['content']?>"></div>
					          	  <span class="time" style="font-family: '微软雅黑';color: gray;font-size: 14px;"><?php echo $_html['date']?></span>
					          	  <span class="readcount" style="font-family: '微软雅黑';color: gray;font-size: 14px;">阅读数(<em id="readcount"><?php echo $_html['readcount']?></em>)</span>
					          	  <div class="bottomBox">
					          	      <span class="pinglun">评论(<em id="count">0</em>)</span>
					          	      <span class="zan">赞(<em id="zan"><?php echo $_html['zan']?></em>)</span>
					          	      
					          	  </div>
					          </div>
					          <div class="comment">
					                <div class="biaoji1"></div>
						    		<form id="commentForm">
						    			<input type="hidden" name="articleid" id="articleid" value="<?php echo $_html['id']?>" />
						    			<img id="pinglunFace" class="faceImgs" alt="face" src=""/>
						    			<textarea name="comments" class="emotion" id="textarea"></textarea>
						    			<div class="emoijBox">
							    			<span id="emoij"></span>
							    			<input id="commentBtn" type="button" value="评论" />
						    			</div>
						    		</form>
						    		<div id="showComment">
						    			<ol class="commentOl" id="comments">
							    			  
						    			</ol>
						    		</div>
						    	</div>
					      </li>
					    
					</ul>
				</section>
			</div>
			<!--<div class="music">
				<iframe frameborder="no" border="0" marginwidth="0" marginheight="0" width=330 height=450 src="//music.163.com/outchain/player?type=0&id=539997813&auto=0&height=430"></iframe>
			</div>-->
		</section>
		<footer id="footer">
		    <div class="foot">
	            <a href="relation.html" target="_blank">联系我们</a> |
	            <a href="statement.html" target="_blank">网站声明</a> |
		        <a href="feedback.html" target="_blank">问题反馈</a> |
		        <a href="build.html" target="_blank">友情链接</a> 
	        </div>
	        <p>Copyright &copy; 2016 爱李健 版权所有 <span>京ICP证0843234号</span></p>
		</footer>
		
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
		
		
		
		<script src="js/jquery.cookie.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/json2.js" type="text/javascript" charset="utf-8"></script>
		<script src="emoji/jquery.sinaEmotion.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/tool.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/main.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/dongtai.js" type="text/javascript" charset="utf-8"></script>
		
	    <script type="text/javascript">
		  
		  
		  
				
	    </script>
	</body>
</html>