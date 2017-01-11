

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>车站</title>
		<link rel="stylesheet" type="text/css" href="../css/main.css"/>
	</head>
	
	<body style="background: #E9EDF0;">
		<header id="header" style="background: #0c0a0d;">
			<h2 class="logo">爱李健</h2>
			<nav class="nav">
				<ul>
					<li><a href="../index.html">首页</a></li>
					<li><a href="../music.html">专辑</a></li>
					<li><a href="../video.html" class="active">视频</a></li>
					<li><a href="../fatie.php">发帖</a></li>
					<li><a href="../about.html">关于</a></li>
				</ul>
			</nav>
			<div class="login">
				<a href="../login.html">登录</a>
				<span id="touxiangBox">
					<img id="touxiang" src="" alt="头像"/>
					<div class="shezhi">
						<span class="jiantuo"></span>
						<ul>
							<li><a href="../changeface.html">更改头像</a></li>
							<li class="tuichu"><a href="javascript:;">退出</a></li>
						</ul>
					</div>
				</span>
			</div>
			<div class="reg"><a href="../reg.html">注册</a></div>
		</header>
		
		<section id="videoShow">
			<div class="videoLeft">
				<h3>我是歌手/车站</h2>
				<video  width="800px" autoplay="autoplay" id="bgAudio" controls="controls" poster="">
					<source type="video/mp4" src="http://oiquezwzp.bkt.clouddn.com/%E8%BD%A6%E7%AB%99.mp4">
			    </video>
			    <p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p>
			    <p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p>
			    <p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p>
			    <p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p>
			    <p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p>
			    <p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p>
			</div>
			<div class="videoRight">
				<h3>相关video</h3>
			    <div class="xiangguanBox">
			    	<a href="001.php" target="_blank"><img alt="贝加尔湖畔" src="../img/geshou/min01.jpg"/></a>
			    	<a href="001.php" target="_blank">贝加尔湖畔</a>
			    </div>
			    <div class="xiangguanBox">
			    	<a href="003.php" target="_blank"><img alt="袖手旁观" src="../img/geshou/min03.jpg"/></a>
			    	<a href="003.php" target="_blank">袖手旁观</a>
			    </div>
			    <div class="xiangguanBox">
			    	<a href="004.php" target="_blank"><img alt="今天是你的生日,妈妈 " src="../img/geshou/min04.jpg"/></a>
			    	<a href="004.php" target="_blank">今天是你的生日</a>
			    </div>
			    <div class="xiangguanBox">
			    	<a href="005.php" target="_blank"><img alt="当你老了" src="../img/geshou/min05.jpg"/></a>
			    	<a href="005.php" target="_blank">当你老了</a>
			    </div>
			    <div class="xiangguanBox">
			    	<a href="006.php" target="_blank"><img alt="尘缘" src="../img/geshou/min06.jpg"/></a>
			    	<a href="006.php" target="_blank">尘缘</a>
			    </div>
			</div>
		</section>
		
		<div id="back"></div>
		<script src="../js/jquery-1.12.3.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="../js/jquery.cookie.js" type="text/javascript" charset="utf-8"></script>
		<script src="../js/json2.js" type="text/javascript" charset="utf-8"></script>
		
		
		
	  <script type="text/javascript">
		  $(function(){
		  	 //设置初始音量大小
		  	 document.getElementById("bgAudio").volume = 0.4;
		  	 
		  	  
		  	  //如果cookie存在，自动登入
				if($.cookie('user')){
					$('.tuichu').show();
					$('.login').children('a').html($.cookie('user')).css('color','#f4c45a');
					$.ajax({
						type:"post",
						url:"../php/show_face.php",
						data:{
								user:$.cookie('user')
							},
						success:function(texts){
							$('#touxiang').attr('src','../'+texts).show();
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
