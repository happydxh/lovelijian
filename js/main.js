$(function(){
	//焦点图
	(function(){
		//初始化
		$('.picBtn').find('span:first').css('opacity','1');
		//切换
		var index = null;
		var len = $('.picBtn').find('span').length;
		var timer = null;
		//手动滑入切换
		$('.picBtn').find('span').on('mouseover',function(){
			
			index = $('.picBtn').find('span').index(this);
			changeimg(index);
		})
		//自动切换
		timer = setInterval(function(){
			changeimg(index);
			index++;
			if(index == len){
				index = 0;
			}
		},4000)
		
		//滑入停止动画，划出开始动画
		$("#banner").hover(function(){
			if(timer){
					clearInterval(timer);
				}
			},function(){
				timer = setInterval(function(){
				changeimg(index);
				index++;
				if(index == len){
					index = 0;
				}
			},4000)
		})
		
		function changeimg(index){
			$('.picBtn').find('span').eq(index).css('opacity','1').siblings().css('opacity','0.7');
			moveLen = -index*1200+'px'
			$('.piclist').animate({left:moveLen},500)
		}
	})();
	
	//tab标签
    (function(){
		var lis = $('#tablist').find('li');
		var divList = $('.divBox')
		lis.each(function(index){
			$(this).on('click',function(){
				lis.removeClass('tabActive');
			    $(this).addClass('tabActive');
			    divList.hide().eq(index).show();
			})
		})
	})()
	
	//3d video
	$(".flipster").flipster({ style: 'carousel', start: 0 });
		

})
