<!DOCTYPE HTML>
<HTML>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scale=no">
<title>太阳币中心</title>
	<link href="/shop/css/zhuanzhang.css" rel="stylesheet" type="text/css">
	<link href="/shop/css/style.css" rel="stylesheet" />
	<link href="/shop/css/media.css" rel="stylesheet" />
	<script type="text/javascript" src="/shop/js/jquery-1.8.3.js"></script>
	<script type="text/javascript" src="/shop/js/index.js"></script>
</head>
<body id="mulu">

@include('layout.members.nav')
<div class="banner"></div>
<div class="main clear">
<div class="title">
    欢迎进入新纪元红日会员<span>转账</span>页面
</div>
<div class="content">
		<h1 class="tit_01">会员中心</h1>
		@include('layout.members.left_nav')
		<div class="mright">
			<div class="zhuanzhang">
				<div class="total">
					<div>{{session('hr_member')['taiyangbi']}}</div>
					<p>可用太阳币：</p>
				</div>
				<div class="phone1">
					<div><input type="text" name="othername" value="" placeholder="  请输入姓名"/></div>
					<p>对方姓名：</p>
					<div class="phones">
						<ul>
							<li></li>
							<li></li>
							<li></li>
						</ul>
					</div>
				</div>
				<div class="phone1">
					<div><input type="text" name="otherphone" value="" placeholder="  请输入手机号"/></div>
					<p>对方手机号：</p>
					<div class="phones">
						<ul>
							<li></li>
							<li></li>
							<li></li>
						</ul>
					</div>
				</div>
				<div class="num">
					<div><input type="text"  name="free" value="" placeholder=" 请输入转账太阳币数量"/></div>
					<p>转账太阳币数量：</p>
				</div>
				<!-- <div class="phone2">
					<div><input type="text" name="phone" value="" placeholder="  请输入手机号"/></div>
					<p>手机号：</p>
					
				</div> -->
				<input type="hidden" name="phone" value="{{session('hr_member')['phone']}}">
				<div class="yanzhengma">
					<div><input type="text" name="code" value="" placeholder="  请输入验证码"/><input type="hidden" name="msg" value=""></div>
					<p>验证码：</p>
					<span class="huoqu">获取验证码</span>
				</div>
				<div class="zzsubmit">
					<input type="submit" value="立即转账"/>
				</div>

				<script type="text/javascript">
					//将输入的金额进行相应的判断
					$('input[name=free]').keyup(function(){
						//时刻判断
						if(parseInt($('.total div').html())<parseInt($(this).val())){
							$(this).val(parseInt($('.total div').html()));
						}
					})
					//点击发送验证码
					$(".huoqu").click(function(){
						//获取手机号
						var  phone = $('input[name=phone]').val();
						var  name = $('input[name=othername]').val();
						var  money = $('input[name=free]').val();
						  if(!(/^1[3|4|5|7|8][0-9]\d{4,8}$/.test(phone))){ 
						  	alert('手机号码格式不正确');
						  }else if(money!=0){
						  	//发送ajax发送短信
						  	$.ajax({
						  		url:'/members/code',
						  		data:{'phone':phone,'name':name,'money':money},
						  		type:"get",
						  		success:function(mes)
						  		{
						  			//将二维码放到指定的位置上
						  			$('input[name=msg]').val(mes);
						  		}
						  	})
						  }
					})
					//点击转账进行相应的操作
					$('.zzsubmit input').click(function(){
						var  othername = $('input[name=othername]').val();
						var  otherphone = $('input[name=otherphone]').val();
						var  phone = $('input[name=phone]').val();
						var  money = $('input[name=free]').val();
						var  code = $('input[name=code]').val();
						var  msg = $('input[name=msg]').val();
						//判断所有的条件
						var  money = $('input[name=free]').val();
						  if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(phone)) || !(/^1[3|4|5|8][0-9]\d{4,8}$/.test(otherphone))){ 
						  	alert('您鼠标手机号码格式不正确');
						  }else if(msg!=code||msg==''){
						  	alert('验证码不正确');
						  }else{
						  	//发送ajax
						  	$.ajax({
						  		url:'/members/zhuanzhangtrue',
						  		data:{'othername':othername,'otherphone':otherphone,'money':money,'phone':phone},
						  		type:'get',
						  		success:function(mes)
						  		{
						  			console.log(mes);
						  			if(mes==1)
						  			{
						  				alert('转账成功');
						  				location.reload(true);
						  				// $('.success').css('display','block');
						  			}else if(mes==2){
						  				alert('您输入的账号不存在');
						  			}else if(mes==3){
						  				alert('余额不足无法转账')
						  			}else{
						  				alert('系统错误,请联系客服');
						  			}
						  		}
						  	})
						  }

					})
				</script>	
				<!--转账成功弹窗-->
				<div class="sucess">
					恭喜您转账成功
				</div>
			</div>
		</div>
	</div>
</div>
<div class="footer">
	<p class="p1" style="word-wrap:break-word ;">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
</div>
<script src="/shop/js/members_nav_botton_style.js"></script>
</body>
</HTML>