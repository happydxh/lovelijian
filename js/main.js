$(function(){
	
    //如果cookie存在，自动登入
	if($.cookie('user')){
		$('.tuichu').show();
		$('.login').children('a').html($.cookie('user')).css('color','#f4c45a');
		$.ajax({
			type:"post",
			url:"php/show_face.php",
			data:{
					user:$.cookie('user')
				},
			success:function(texts){
				$('#touxiang').attr('src',texts).show();
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
		$('.infoUser').show().html("请输入用户名至少两个字符");
		if(check_user()){
			$('.successUser').show();
			$('.infoUser').hide();
		}else{
			$('.successUser').hide();
			$('.infoUser').show();
		}
	}).on('blur',function(){
		if(check_user()){
			$('.successUser').show();
			$('.infoUser').hide();
		}else{
			$('.successUser').hide();
			$('.infoUser').show();
		}
	})
	
	function check_user(){
		var flag = true
		if(/[\u0391-\uFFE5\w]{2,20}/.test($.trim($('#user').val()))){
			//return true;
			$.ajax({
				type:"post",
				url:"php/is_user.php",
				data:$('#formreg').serialize(),
				success:function(text){
					if(text == 1){
						$('.infoUser').show().html("用户名被占用");
						flag = false;
					}else{
						flag = true;
					}
				},
				async:false
			});
			return flag
		}
	}
	
	//密码验证
	$('#pass').on('focus',function(){
		$('.infoPass').show();
		if(check_pass()){
			$('.successPass').show();
			$('.infoPass').hide();
		}else{
			$('.successPass').hide();
			$('.infoPass').show();
		}
	}).on('blur',function(){
		if(check_pass()){
			$('.successPass').show();
			$('.infoPass').hide();
		}else{
			$('.successPass').hide();
			$('.infoPass').show();
		}
	})
	
	function check_pass(){
		if(/[\w]{6,20}/.test($.trim($('#pass').val()))){
			return true
		}
	}

	
	//密码确认
		$('#passTwo').on('focus',function(){
			if($.trim($(this).val()) == ''){
				$('.infoPassTwo').show();
			}else{
				if(check_passTwo()){
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
				if(check_passTwo()){
					$('.successPassTwo').show();
					$('.infoPassTwo').hide();
				}else{
					$('.successPassTwo').hide();
					$('.infoPassTwo').show();
					$('.infoPassTwo').html('密码不一致，请重新输入')
				}
			}
		})
		
		function check_passTwo(){
			if($.trim($('#passTwo').val()) == $.trim($('#pass').val())){
				return true
			}
		}
			
		//邮箱验证
		$('#email').on('focus',function(){
			if($.trim($(this).val()).length >= 1){
				$('.all_email').show()
			}
			
			$('.infoEmail').show();
			if(check_passEmail()){
				$('.successEmail').show();
				$('.infoEmail').hide();
			}else{
				$('.successEmail').hide();
				$('.infoEmail').show();
				$('.infoEmail').html('请输入电子邮箱')
			}
		}).on('blur',function(){
			$('.all_email').hide()
			if(check_passEmail()){
				$('.successEmail').show();
				$('.infoEmail').hide();
			}else{
				$('.successEmail').hide();
				$('.infoEmail').show();
				$('.infoEmail').html('邮箱不合法，请重新输入')
			}
		})
		
		function check_passEmail(){
			if(/^[\w-\.]+@[\w-]+(\.[a-zA-Z]{2,4}){1,2}$/.test($.trim($('#email').val()))){
				return true
			}
		}
		
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
		$('.regbtn').on('click',function(){
			var flag = true
			if(!check_user()){
				$('.infoUser').show();
				flag = false
			}
			
			if(!check_pass()){
				$('.infoPass').show();
				flag = false
			}
			
			if(!check_passTwo()){
				$('.infoPassTwo').show();
				flag = false
			}
			
			if(!check_passEmail()){
				$('.infoEmail').show();
				flag = false
			}
			
			if(flag){
				var _this = this;
				var loading = $('#loading');
				loading.show();
				$('#loading').find('p').html('正在提交注册中..');
				center(loading,200,40)
				_this.disabled = true;
				$(_this).css('background','darkgray');
				$.ajax({
					type:"post",
					url:"php/add.php",
					data:$('#formreg').serialize(),
					success:function(text){
						if(text == 1){
							loading.hide();
							var success = $('#success');
							success.show();
							success.find('p').html('注册成功，请登入');
							center(success,200,40)
							setTimeout(function(){
								success.hide();
								_this.disabled = false;
								$(_this).css('background','#a29060');
								$('#formreg')[0].reset();
								window.location.href='index.html';
							},1500);
						}	
					},
					async:true
				});
			}
		});
		
		//登入
		$('.loginBtn').on('click',function(){
			var _this = this;
			var loading = $('#loading');
			loading.show();
			$('#loading').find('p').html('登入中..');
			center(loading,200,40)
			_this.disabled = true;
			$(_this).css('background','darkgray');
			$.ajax({
				type:"post",
				url:"php/is_login.php",
				data:$('#formlogin').serialize(),
				success:function(text){
					loading.hide();
					if(text == 1){//失败
						$('.loginInfo').show();
						_this.disabled = false;
						$(_this).css('background','#a29060');
					}else{
						var success = $('#success');
						success.show();
						success.find('p').html('登入成功');
						center(success,200,40);
						if ($('#expires').is(':checked')) {
							$.cookie('user', $('#login_user').val(), {
								expires : 7,
							});
						} else {
							$.cookie('user', $('#login_user').val());
						}
						setTimeout(function(){
							success.hide();
							_this.disabled = false;
							$(_this).css('background','#a29060');
							$('#formlogin')[0].reset();
							$('.login').children('a').html($.cookie('user')).css('color','#f4c45a');
							window.history.back();  
							//window.location.href='index.html';
						},1500);
					}
				},
				async:true
			});
		})

})
