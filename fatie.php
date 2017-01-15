<?php

    require 'php/config.php';
    //显示贴子
    $query = mysql_query("SELECT (SELECT face_url FROM lj_user WHERE user=a.user) AS faceurl,a.id,a.content,a.user,a.date , a.zan FROM lj_article a ORDER BY a.date DESC LIMIT 0,20") or die('SQL 错误！');
	
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
		
        <object id="tudouHomePlayer" name="tudouHomePlayer" width="780px" height="500px" data="http://js.tudouui.com/bin/lingtong/PortalPlayer_197.swf" type="application/x-shockwave-flash"><param name="allowfullscreen" value="true"><param name="allowscriptaccess" value="always"><param name="bgcolor" value="#000000"><param name="wMode" value="direct"><param name="quality" value="high"><param name="allowFullScreenInteractive" value="true"><param name="flashvars" value="abtest=0&amp;referrer=http%3A%2F%2Fwww.soku.com%2Ft%2Fnisearch.do%3Fkw%3D%25E6%259D%258E%25E5%2581%25A5%25E5%259B%259B%25E5%25A4%25A7%25E9%25AB%2598%25E6%25A0%25A1&amp;href=http%3A%2F%2Fwww.tudou.com%2Fprograms%2Fview%2Fr_tU5kz8fdI%2F%3Fspm%3Da2h0k.8191414.r_tU5kz8fdI.A.NBUCsE&amp;USER_AGENT=Mozilla%2F5.0%20(Windows%20NT%2010.0)%20AppleWebKit%2F537.36%20(KHTML%2C%20like%20Gecko)%20Chrome%2F45.0.2454.101%20Safari%2F537.36&amp;areaCode=110000&amp;yjuid=&amp;yseid=1484457173197dW3jgv&amp;ypvid=1484464617032oWhhJo&amp;yrpvid=1484464218036FzfO33&amp;yrct=30&amp;frame=0&amp;noCookie=0&amp;yseidtimeout=1484471817034&amp;yseidcount=1&amp;fac=0&amp;aop=0&amp;listType=0&amp;listCode=&amp;listId=0&amp;lid=0&amp;paid=&amp;paidTime=&amp;paidType=&amp;lshare=1&amp;license=&amp;tdReg=&amp;exclusive=0&amp;icode=r_tU5kz8fdI&amp;iid=245682142&amp;sp=http://g2.tdimg.com/8c48cf16f29b51521c5561ca25fb4d7f/p_2.jpg&amp;segs=%7B%222%22%3A%5B%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3D27ecaf028276160452aba600c731dcf9%22%2C%22seconds%22%3A412000%2C%22no%22%3A0%2C%22xid%22%3A%2204001216005673DE016D9330C1DCD6CBB52512-875C-76E0-DFB0-000378500442%22%2C%22pt%22%3A2%2C%22k%22%3A378500442%2C%22size%22%3A13670653%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3D0cf1dcfa190af304fb49964cdb226ef0%22%2C%22seconds%22%3A408000%2C%22no%22%3A1%2C%22xid%22%3A%2204001216015673DE0139EAD05C3C1945647B51-409E-EA53-681E-000378500443%22%2C%22pt%22%3A2%2C%22k%22%3A378500443%2C%22size%22%3A15852832%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3D085d22ab9b63b254ee5b50a49cd232dd%22%2C%22seconds%22%3A412000%2C%22no%22%3A2%2C%22xid%22%3A%2204001216025673DE0143DF79E01BABB7879EFA-A14F-26D4-4146-000378500444%22%2C%22pt%22%3A2%2C%22k%22%3A378500444%2C%22size%22%3A14834055%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3De09beae7fe830ce7f8c6c80014a3f6fe%22%2C%22seconds%22%3A413000%2C%22no%22%3A3%2C%22xid%22%3A%2204001216035673DE014F07FE8D140D0F810004-552D-E1CC-C3FE-000378500445%22%2C%22pt%22%3A2%2C%22k%22%3A378500445%2C%22size%22%3A14829793%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3Dbae8508036e6d395e5d26e1dfc69fc94%22%2C%22seconds%22%3A412000%2C%22no%22%3A4%2C%22xid%22%3A%2204001216045673DE016A4CBF69936B752F63E1-D0F0-3497-E299-000378500446%22%2C%22pt%22%3A2%2C%22k%22%3A378500446%2C%22size%22%3A14450279%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3Da3599c64f572a70d415ec86466182040%22%2C%22seconds%22%3A412000%2C%22no%22%3A5%2C%22xid%22%3A%2204001216055673DE019B8C42652281E41E7507-3D82-DBF0-CA5F-000378500447%22%2C%22pt%22%3A2%2C%22k%22%3A378500447%2C%22size%22%3A13748683%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3D9d85e19ed5495df12a63ad04a7a7189c%22%2C%22seconds%22%3A415000%2C%22no%22%3A6%2C%22xid%22%3A%2204001216065673DE019478F17915391A66A9E7-17BF-B6E9-3559-000378500448%22%2C%22pt%22%3A2%2C%22k%22%3A378500448%2C%22size%22%3A14915964%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3Db60687853c3a9e3721eeae2faeb42200%22%2C%22seconds%22%3A412000%2C%22no%22%3A7%2C%22xid%22%3A%2204001216075673DE01456DB2C7A81EC123DD0A-97C5-AB0C-4352-000378500449%22%2C%22pt%22%3A2%2C%22k%22%3A378500449%2C%22size%22%3A16118276%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3D01bbaef987de1c258274cc139d51a2b1%22%2C%22seconds%22%3A411000%2C%22no%22%3A8%2C%22xid%22%3A%2204001216085673DE0196DC31BBBAE63BDF7F09-C3F4-8413-8E38-000378500450%22%2C%22pt%22%3A2%2C%22k%22%3A378500450%2C%22size%22%3A13048543%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3D22c0d79e005595bbf4195b3d3bcec71a%22%2C%22seconds%22%3A412000%2C%22no%22%3A9%2C%22xid%22%3A%2204001216095673DE010EA619CB881E612F09D2-3E22-F936-2D03-000378500451%22%2C%22pt%22%3A2%2C%22k%22%3A378500451%2C%22size%22%3A13287848%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3Da05c114ba9e9fc1f0bdc449b5afa3a5a%22%2C%22seconds%22%3A411000%2C%22no%22%3A10%2C%22xid%22%3A%2204001216105673DE01FA492C6EA2F872048C4B-989B-C3BD-CA5F-000378500452%22%2C%22pt%22%3A2%2C%22k%22%3A378500452%2C%22size%22%3A16798083%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3Ddb60bb6e6517fb3a1301bbc393c3c8c7%22%2C%22seconds%22%3A410000%2C%22no%22%3A11%2C%22xid%22%3A%2204001216115673DE01753DBFAB17EDE2FE4128-EE3B-0CBA-B330-000378500453%22%2C%22pt%22%3A2%2C%22k%22%3A378500453%2C%22size%22%3A17309223%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3D304495991ff9b510e01ea6ab680f62ef%22%2C%22seconds%22%3A416000%2C%22no%22%3A12%2C%22xid%22%3A%2204001216125673DE011FFA147384D2B03B3429-9799-A34C-5E1A-000378500454%22%2C%22pt%22%3A2%2C%22k%22%3A378500454%2C%22size%22%3A15696063%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3D0fb0a5f68578fed7ac956048ff971ede%22%2C%22seconds%22%3A409000%2C%22no%22%3A13%2C%22xid%22%3A%2204001216135673DE014903E934AA0D9E590ED0-F3D2-4E4E-E4DA-000378500455%22%2C%22pt%22%3A2%2C%22k%22%3A378500455%2C%22size%22%3A13660124%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3D86a47a61be88b021d4115459a609864c%22%2C%22seconds%22%3A413000%2C%22no%22%3A14%2C%22xid%22%3A%2204001216145673DE0185FAE326430022A9239C-60D8-0CA3-D3ED-000378500456%22%2C%22pt%22%3A2%2C%22k%22%3A378500456%2C%22size%22%3A13768992%7D%2C%7B%22baseUrl%22%3A%22http%3A%2F%2Fv2.tudou.com%2Fx%3Fev%3D1%26expire%3D1484464815%26cks%3Dff4045a1e9ae65b7058048178f35cd9a%22%2C%22seconds%22%3A415000%2C%22no%22%3A15%2C%22xid%22%3A%2204001216155673DE01AD1A1E252CB9A4AE52A5-ABB4-3904-4E7C-000378500457%22%2C%22pt%22%3A2%2C%22k%22%3A378500457%2C%22size%22%3A14827679%7D%5D%7D&amp;tvcCode=-1&amp;channel=1&amp;tict=3&amp;hd=0&amp;ol=0&amp;olw=-1&amp;olh=-1&amp;olr=-1&amp;kw=%E6%9D%8E%E5%81%A5%E9%9D%B3%E4%B8%9C%E5%AF%B9%E8%B0%88%E9%9D%92%E6%98%A5%E6%95%B4%E5%9C%BA2015-12-17&amp;mediaType=vi&amp;np=0&amp;sh=0&amp;st=0&amp;videoOwner=360994008&amp;ocode=VDUF77mtpPI&amp;time=6593&amp;vcode=&amp;ymulti=&amp;lang=&amp;isFeature=0&amp;is1080p=0&amp;hasWaterMark=1&amp;actionID=0&amp;resourceId=&amp;tpa=&amp;cs=&amp;k=%E9%9D%B3%E4%B8%9C&amp;prd=&amp;uid=1081462585&amp;ucode=pWHbZz1RJZM&amp;mmid=0&amp;juid=01ajl15508e0o&amp;seid=01b6gfcas42eu0&amp;showWS=0&amp;ahcb=0&amp;wtime=0&amp;lb=0&amp;scale=0&amp;dvd=0&amp;hideDm=0&amp;pepper=http://css.tudouui.com/bin/lingtong/pepper.swz&amp;panelEnd=http://css.tudouui.com/bin/lingtong/PanelEnd_13.swz&amp;panelRecm=http://css.tudouui.com/bin/lingtong/PanelRecm_9.swz&amp;panelShare=http://css.tudouui.com/bin/lingtong/PanelShare_7.swz&amp;panelCloud=http://css.tudouui.com/bin/lingtong/PanelCloud_12.swz&amp;panelDanmu=http://css.tudouui.com/bin/lingtong/PanelDanmu_18.swz&amp;aca="></object>
		
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
			    		<div class="biaoji1"></div>
			    		<form id="commentForm" >
			    			<input type="hidden" name="articleid" id="articleid" value="1" />
			    			<img class="faceImgs" alt="face" src="face/test1484196094.jpg"/>
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
				    				    <div id="answerBox">
			    							<form id="answerForm" >
								    			<input type="hidden" name="commentid" id="commentid" value="1" />
								    			<textarea name="answer_comments" class="answer_textarea" id="answer_textarea"></textarea>
								    			<div class="emoijBox">
									    			<span class="answer_emoij" id="answer_emoij"></span>
									    			<input class="answer_Btn" id="answer_Btn" type="button" value="评论" />
								    			</div>
								    		</form>
			    					    </div>
			    					</div>
			    				</li>
			    				<li>
			    					<div class="commentLeft">
			    						<img alt="face" src="face/test1484196094.jpg"/>
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
				    				    <div id="answerBox">
			    						
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
