//tool function
    function getScroll(){
		return {
			top : document.documentElement.scrollTop || document.body.scrollTop,
			left : document.documentElement.scrollLeft || document.body.scrollLeft
		}
	}
    
	function center(obj,width,height){
		var top = (document.documentElement.clientHeight-height) / 2;
	    var left = (document.documentElement.clientWidth-width) / 2;
	    var scroll = 
	    obj.css('top',top+getScroll().top+'px')
	    obj.css('left',left+getScroll().left+'px')
	}
	
	//textarea高度自适应
    var autoTextarea = function (elem, extra, maxHeight) {
        extra = extra || 0;
        var isFirefox = !!document.getBoxObjectFor || 'mozInnerScreenX' in window,
        isOpera = !!window.opera && !!window.opera.toString().indexOf('Opera'),
                addEvent = function (type, callback) {
                        elem.addEventListener ?
                                elem.addEventListener(type, callback, false) :
                                elem.attachEvent('on' + type, callback);
                },
                getStyle = elem.currentStyle ? function (name) {
                        var val = elem.currentStyle[name];
 
                        if (name === 'height' && val.search(/px/i) !== 1) {
                                var rect = elem.getBoundingClientRect();
                                return rect.bottom - rect.top -
                                        parseFloat(getStyle('paddingTop')) -
                                        parseFloat(getStyle('paddingBottom')) + 'px';        
                        };
 
                        return val;
                } : function (name) {
                                return getComputedStyle(elem, null)[name];
                },
                minHeight = parseFloat(getStyle('height'));
 
        elem.style.resize = 'none';
 
        var change = function () {
            var scrollTop, height,
            padding = 0,
            style = elem.style;
 
            if (elem._length === elem.value.length) return;
            elem._length = elem.value.length;
 
            if (!isFirefox && !isOpera) {
                    padding = parseInt(getStyle('paddingTop')) + parseInt(getStyle('paddingBottom'));
            };
            scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
 
            elem.style.height = minHeight + 'px';
	        if (elem.scrollHeight > minHeight) {
	                if (maxHeight && elem.scrollHeight > maxHeight) {
	                        height = maxHeight - padding;
	                        style.overflowY = 'auto';
	                } else {
	                        height = elem.scrollHeight - padding;
	                        style.overflowY = 'hidden';
	                };
	                style.height = height + extra + 'px';
	                scrollTop += parseInt(style.height) - elem.currHeight;
	                document.body.scrollTop = scrollTop;
	                document.documentElement.scrollTop = scrollTop;
	                elem.currHeight = parseInt(style.height);
	        };
        };
 
	        addEvent('propertychange', change);
	        addEvent('input', change);
	        addEvent('focus', change);
	        change();
        };
        
        
        //将后台反过来时间 "2014-05-08 00:22:11" 格式成时间戳
        function get_unix_time(dateStr){
		    var newstr = dateStr.replace(/-/g,'/');
		    //alert(newstr)
		    var date =  new Date(newstr); 
		    var time_str = date.getTime();
		    //return time_str.substr(0, 10);
		    return time_str
		}
        
        //时间戳格式化
        function formatDate(now) { 
			var year=now.getFullYear();  
			var month=now.getMonth()+1; 
			var date=now.getDate(); 
			var hour=now.getHours(); 
			var minute=now.getMinutes(); 
			var second=now.getSeconds(); 
			return year+"-"+month+"-"+date+" "+hour+":"+minute+":"+second; 
		} 
        
        function trantime(oldtime){
        	
        	var datetimes = new Date(oldtime);
        	var datetime = formatDate(datetimes);
        	
        	var now = new Date().getTime();
        	var newtime = now - oldtime;
        	var str = null;
        	
        	if (newtime < 60 * 1000){ 
		        str = '刚刚'; 
		    }else if (newtime < 60 * 60 * 1000) { 
		        var min = Math.floor(newtime/(60 * 1000)); 
		        str = min+'分钟前'; 
		    } 
		    else if (newtime < 60 * 60 * 24 * 1000) { 
		        var h = Math.floor(newtime/(60*60 * 1000)); 
		        str = h+'小时前 '; 
		    } 
		    else if (newtime < 60 * 60 * 24 * 10 * 1000) { 
		        var d = Math.floor(newtime/(60*60*24 * 1000)); 
		        if(d==1){
		        	str = '昨天 ';
		        }else{
		        	 str = d+'天前';
		        }
		    } 
		    else { 
		        str = datetime; 
		    }
		    
		    return str; 
        }
        

        //js字符过滤html标签互转函数
        function htmlencode(str) {
			 str = str.replace(/&/g, '&amp;');
			 str = str.replace(/</g, '&lt;');
			 str = str.replace(/>/g, '&gt;');
			 //str = str.replace(/(?:t| |v|r)*n/g, '<br />');
			 str = str.replace(/  /g, '&nbsp; ');
			 str = str.replace(/t/g, '&nbsp; &nbsp; ');
			 str = str.replace(/x22/g, '&quot;');
			 str = str.replace(/x27/g, '&#39;');
			 str = str.replace(/\//g, '&xie;');
			 return str;
		}
		
		function htmldecode(str) {
			 str = str.replace(/&amp;/gi, '&');
			 str = str.replace(/&nbsp;/gi, ' ');
			 str = str.replace(/&quot;/gi, '"');
			 str = str.replace(/&#39;/g, "'");
			 str = str.replace(/&lt;/gi, '<');
			 str = str.replace(/&gt;/gi, '>');
			 str = str.replace(/&xie;/gi, '/');
			 //str = str.replace(/<br[^>]*>(?:(rn)|r|n)?/gi, 'n');
			 return str;
		}
		
		
	//评论功能公共函数
	
		//解码帖子内容
		var content = $('#contentUl li').find('.content').attr('datacomment');
		var jiema = decodeURIComponent(content);
		$('#contentUl li').find('.content').html(jiema);
		
		//textarea高度自适应
		var texts = $('#textarea').get(0);
	    autoTextarea(texts);
	    // 绑定表情
		$('#emoij').SinaEmotion($('#contentBox ul li').find('.emotion'));
		
		//评论者头像
		if($.cookie('user')){
			$.ajax({
				type:"post",
				url:"php/show_face.php",
				data:{
						user:$.cookie('user')
					},
				success:function(texts){
					$('#contentBox ul li').find('#pinglunFace').attr('src',texts);
				},
				async:true
			});
		}else{
			var faceUrl = 'face/moren.png'
			$('#contentBox ul li').find('#pinglunFace').attr('src',faceUrl);
		}
		
		//发表评论
		function addcomment(url){
			$('#contentBox ul li').find('#commentBtn').on('click',function(){
			if( $('#contentBox ul li').find('#textarea').val() == '' ){
				var tishi = $('#tishi');
					tishi.show();
					$('#tishi').find('p').html('评论内容不得为空哦！');
					center(tishi,200,40);
					setTimeout(function(){
						tishi.hide();
					},1500);
			}else{
				if($.cookie('user')){
					var src = $('#pinglunFace').attr('src');
					var pinglun_textarea = ''
					if( /\[[\u0391-\uFFE5\w]*\]/ig.test( $('#contentBox ul li').find('#textarea').val() ) ){
						//解析表情
						pinglun_textarea = AnalyticEmotion($('#contentBox ul li').find('#textarea').val());
					}else{
						pinglun_textarea = $('#contentBox ul li').find('#textarea').val();
					}
				    //对发送的内容进行编码
				    var comments = encodeURIComponent(pinglun_textarea);
				    
					var htmls = '';
					htmls += '<li>'+
			    					'<div class="commentLeft">'+
			    						'<img src="'+src+'"/>'+
			    					'</div>'+
			    					'<div class="commentRight">'+
			    						'<p>'+
				    						'<span class="commentUser">'+$.cookie('user')+':</span>'+
				    						'<span class="commentContent">'+pinglun_textarea+'</span>'+
				    				     '</p>'+
				    				    '<div class="commentBottom">'+
				    				    	'<time>刚刚</time>'+
				    				    	'<span class="huifu">回复</span>'+
				    				    '</div>'+
			    					'</div>'+
			    				'</li>';
					
                    
					$('#contentBox ul li').find('#comments').prepend(htmls);
					$('#contentBox ul li').find('#commentForm')[0].reset();
					
					//评论数
					var count = $('#contentBox ul li').find('#count').text();
					count++
					$('#contentBox ul li').find('#count').text(count);
					$.ajax({
						type:"post",
						url:url,
						data:{
							user:$.cookie('user'),
							comments:comments,
							articleid:$('#contentBox ul li').find('#articleid').val()
						},
						async:true
					});
				    }else{
				    	var tishi = $('#tishi');
						tishi.show();
						$('#tishi').find('p').html('请登入后操作');
						center(tishi,200,40);
						setTimeout(function(){
							tishi.hide();
						},1500);
				    }
			   }
			});
		}
		
		//显示评论数
		function showCommentCount(url){
			$.ajax({
				type:"post",
				url:url,
				data:{
					articleid:$('#articleid').val()
				},
				success:function(response){
					$('#count').text(response)
				},
				async:true
			});
		}
		
		//点赞
		function dianzan(url){
			$('#contentBox ul li').find('.zan').on('click',function(){
				var zanCount = $('#zan').text();
				zanCount++
				$('#zan').text(zanCount);
				$.ajax({
					type:"post",
					url:url,
					data:{
						articleid:$('#articleid').val(),
						zan:zanCount
					},
					async:true
				});
			});
		}
				

