
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
					<ul id="contentUl">
						
					    
					</ul>
				</section>
			</div>
			<div class="music">
				<iframe frameborder="no" border="0" marginwidth="0" marginheight="0" width=330 height=450 src="//music.163.com/outchain/player?type=0&id=539997813&auto=0&height=430"></iframe>
			</div>
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
		<script src="js/tool.js" type="text/javascript" charset="utf-8"></script>
		
		
		<script src="js/jquery.cookie.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/json2.js" type="text/javascript" charset="utf-8"></script>
		<script src="emoji/jquery.sinaEmotion.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/fatie.js" type="text/javascript" charset="utf-8"></script>
		
	  <script type="text/javascript">
		  
		  
		  
				
	  </script>
	</body>
</html>
