

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>等我遇见你</title>
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
				<h3>MV/等我遇见你</h2>
				<video  width="800px" autoplay="autoplay"  controls="controls" poster="">
					<source type="video/mp4" src="http://oivwcgufp.bkt.clouddn.com/%E6%9D%8E%E5%81%A5%20-%20%E7%AD%89%E6%88%91%E9%81%87%E8%A7%81%E4%BD%A0.mp4">
			    </video>
			    <p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p>
			    <p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p>
			    <p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p>
			    <p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p>
			    <p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p>
			    <p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p><p>a</p>
			</div>
			<div class="videoRight">
				<h3>MV介绍</h3>
				<p class="mvtitle">等我遇见你</p>
				<time>发布时间：2016-04-28</time>
                <p>简介:电影《北京遇上西雅图之不二情书》今日曝光李健演唱的主题曲《等我遇见你》MV，除了将电影中绝美的八大城市景观收录其中，汤唯、吴秀波片中的重要金句也与李健的词完美遇上，让这个音乐与电影跨界合作更加令人耳目一新。完美传达了片中角色的浪漫与孤单。</p>
			    <h3>相关MV</h3>
			    <div class="xiangguanBox">
			    	<a href="011.php" target="_blank"><img alt="美若黎明" src="../img/mv/minmrlm.jpeg"/></a>
			    	<a href="011.php" target="_blank">美若黎明</a>
			    </div>
			    <div class="xiangguanBox">
			    	<a href="010.php" target="_blank"><img alt="等我遇见你" src="../img/mv/mindwyjn.jpg"/></a>
			    	<a href="010.php" target="_blank">等我遇见你</a>
			    </div>
			    <div class="xiangguanBox">
			    	<a href="005.php" target="_blank"><img alt="异乡人" src="../img/mv/minyixiangren.jpg"/></a>
			    	<a href="005.php" target="_blank">异乡人</a>
			    </div>
			    <div class="xiangguanBox">
			    	<a href="006.php" target="_blank"><img alt="我始终在这里" src="../img/mv/minwszzzl.jpg"/></a>
			    	<a href="006.php" target="_blank">我始终在这里</a>
			    </div>
			</div>
		</section>
		
		<div id="back"></div>
		<script src="../js/jquery-1.12.3.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="../js/jquery.cookie.js" type="text/javascript" charset="utf-8"></script>
		<script src="../js/json2.js" type="text/javascript" charset="utf-8"></script>
		
		
		
	  <script type="text/javascript">
		  $(function(){
		  	 
		  	 
		  	  
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
