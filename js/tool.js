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