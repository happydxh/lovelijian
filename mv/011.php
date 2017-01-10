

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>美若黎明</title>
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
		
		<section id="videoShow">
			<div class="videoLeft">
				<h3>MV/美若黎明</h2>
				<video  width="800px" autoplay="autoplay"  controls="controls" poster="">
					<source type="video/mp4" src="http://oivwcgufp.bkt.clouddn.com/%E6%9D%8E%E5%81%A5%20-%20%E7%BE%8E%E8%8B%A5%E9%BB%8E%E6%98%8E.mp4">
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
				<p class="mvtitle">美若黎明</p>
				<time>发布时间：2016-09-08</time>
                <p>简介:李健第6张创作专辑《李健》主打曲《美若黎明》曝光正式版MV，MV由金曲奖导演陈映之掌镜，以梦境与时间的推移，营造魔幻写实的影像。无论在什么时间、在人生的任何阶段，只要有新的希望和目标，那一刻就是“黎明”。</p>
			    <h3>相关MV</h3>
			    <div class="xiangguanBox">
			    	<a href="009.php" target="_blank"><img alt="等待黎明" src="../img/mv/minddlm.jpg"/></a>
			    	<a href="009.php" target="_blank">等待黎明</a>
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
