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
	})();
	
	
	
	//注册
	//用户名验证
	$('#user').on('focus',function(){
		$('.infoUser').show();
		if(/[\u0391-\uFFE5\w]{2,20}/.test($.trim($(this).val()))){
			$('.successUser').show();
			$('.infoUser').hide();
		}else{
			$('.successUser').hide();
			$('.infoUser').show();
		}
	}).on('blur',function(){
		if(/[\u0391-\uFFE5\w]{2,20}/.test($.trim($(this).val()))){
			$('.successUser').show();
			$('.infoUser').hide();
		}else{
			$('.successUser').hide();
			$('.infoUser').show();
		}
	})
	

	
	//密码验证
	$('#pass').on('focus',function(){
		$('.infoPass').show();
		if(/[\w]{6,20}/.test($.trim($(this).val()))){
			$('.successPass').show();
			$('.infoPass').hide();
		}else{
			$('.successPass').hide();
			$('.infoPass').show();
		}
	}).on('blur',function(){
		if(/[\w]{6,20}/.test($.trim($(this).val()))){
			$('.successPass').show();
			$('.infoPass').hide();
		}else{
			$('.successPass').hide();
			$('.infoPass').show();
		}
	})
	
//	function check_user(){
//		if(/[\u0391-\uFFE5\w]{2,20}/.test($.trim($(this).val()))){
//			return true
//		}
//	}
	
	//密码确认
		$('#passTwo').on('focus',function(){
			if($.trim($(this).val()) == ''){
				$('.infoPassTwo').show();
			}else{
				if($.trim($('#passTwo').val()) == $.trim($('#pass').val())){
					$('.successPassTwo').show();
					$('.infoPassTwo').hide();
				}else{
					$('.successPassTwo').hide();
					$('.infoPassTwo').show();
					$('.infoPassTwo').html('请再次输入密码')
				}
			}
		}).on('blur',function(){
			if($.trim($(this).val()) == ''){
				$('.infoPassTwo').show();
			}else{
				if($.trim($('#passTwo').val()) == $.trim($('#pass').val())){
					$('.successPassTwo').show();
					$('.infoPassTwo').hide();
				}else{
					$('.successPassTwo').hide();
					$('.infoPassTwo').show();
					$('.infoPassTwo').html('密码不一致，请重新输入')
				}
			}
		})
		
		//邮箱验证
		$('#email').on('focus',function(){
			if($.trim($(this).val()).length >= 1){
				$('.all_email').show()
			}
			
			$('.infoEmail').show();
			if(/^[\w-\.]+@[\w-]+(\.[a-zA-Z]{2,4}){1,2}$/.test($.trim($(this).val()))){
				$('.successEmail').show();
				$('.infoEmail').hide();
			}else{
				$('.successEmail').hide();
				$('.infoEmail').show();
				$('.infoEmail').html('请输入电子邮箱')
			}
		}).on('blur',function(){
			$('.all_email').hide()
			if(/^[\w-\.]+@[\w-]+(\.[a-zA-Z]{2,4}){1,2}$/.test($.trim($(this).val()))){
				$('.successEmail').show();
				$('.infoEmail').hide();
			}else{
				$('.successEmail').hide();
				$('.infoEmail').show();
				$('.infoEmail').html('邮箱不合法，请重新输入')
			}
		})
		
		//邮箱补全
		$('#email').on('keyup',function(e){
			
			if($.trim($(this).val()).indexOf('@') == -1){
				$('.all_email').show();
				$('.all_email').find('em').html($.trim($(this).val()));
			}else{
				$('.all_email').hide();
			}
			
			//向下键
			if(e.keyCode == 40){
				if(this.index == undefined || this.index >= $('.all_email').find('li').size() - 1){
					this.index = 0
				}else{
					this.index++
				}
				
				$('.all_email').find('li').eq(this.index).css('background', 'gray').siblings().css('background','#433f40');
			}
			//向上键
			if(e.keyCode == 38){
				if(this.index == undefined || this.index <= 0 ){
					this.index = $('.all_email').find('li').size() - 1
				}else{
					this.index--
				}
				
				$('.all_email').find('li').eq(this.index).css('background', 'gray').siblings().css('background','#433f40');
			}
			//回车确定键
			if(e.keyCode == 13){
				$(this).val($('.all_email').find('li').eq(this.index).text());
				$('.all_email').hide();
				this.index = null;
			}
		})
	    //电子邮件点击获取补全
		$('.all_email').find('li').bind('mousedown',function(){
			$('#email').val($(this).text());
			$('.all_email').hide();
		})
		
		//提交表单
		$('#regbtn').on('click',function(){
			var flag = true
		})

})
