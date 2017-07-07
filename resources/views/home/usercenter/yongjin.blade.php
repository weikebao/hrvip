<!DOCTYPE HTML>
<HTML>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scale=no">
<title>太阳币中心</title>

	<link href="/shop/css/yongjin.css" rel="stylesheet" type="text/css">
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
        欢迎进入新纪元红日会员<span>兑换</span>页面
    </div>
<div class="content">
		<h1 class="tit_01">会员中心</h1>
		@include('layout.members.left_nav')
		<div class="mright">
			<div class="zhuanzhang">
				<div class="total">
					<div>{{session('hr_member')['free']}}</div>
					<p>余额：</p>
				</div>
				<div class="keyong">
					<div>{{session('hr_member')['free']}}</div>
					<p>可兑换太阳币：</p>
				</div>
				
				<div class="num">
					<div><input type="text" name="jine" placeholder="请输入兑换太阳币的数量"/></div>
					<p>兑换数量：</p>
				</div>
				<div class="phone2">
					<div><input type="text" name="phone" placeholder="请输入手机号"/></div>
					<p>手机号码：</p>
					<span class="click">获取验证码</span>
				</div>
				<div class="yanzhengma">
					<div><input type="text" name="code" value="" placeholder="请输入验证码"/><input type="hidden" name="msg" value="" /></div>
					<p>验证码：</p>
				</div>
				<div class="zzsubmit">
					<input type="submit" value="立即兑换" class="submit" />
				</div>
				<script type="text/javascript">
					$('input[name=jine]').keyup(function(){
						//时时根据佣金来兑换
						if(parseInt($('.total div').html())<parseInt($(this).val())){
							$(this).val(parseInt($('.total div').html()));
						}
					})
					//点击获取验证码
					$('.click').click(function(){
						var  money = $('input[name=jine]').val();
						var  phone = $('input[name=phone]').val();
						if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(phone))){
							alert('您输入的手机号不正确');
						}else if(money>0){
							//发送ajax
							$.ajax({
								url:'/members/codes',
								data:{'phone':phone,'money':money},
								type:'get',
								success:function(mes)
								{
									$('input[name=msg]').val(mes);
								}
							})
						}
					})
					$('.submit').click(function(){
						var  money = $('input[name=jine]').val();
						var  phone = $('input[name=phone]').val();
						var code = $('input[name=code]').val();
						var msg = $('input[name=msg]').val();
						if(msg!=code||code=='')
						{
							alert('验证码不正确');
						}else if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(phone)))
						{
							alert('你输入的手机号有问题');
						}else{
							//发送ajax
							$.ajax({
								url:'/members/duihuans',
								data:{'money':money,'phone':phone},
								type:'get',
								success:function(mes)
								{
									if(mes==1){
										alert('兑换成功');
									}else if(mes==2){
										alert('兑换失败');
									}else{
										alert('系统错误请联系客服')
									}
								}
							})
						}
					})
				</script>
				<!--兑换成功弹窗-->
				<div class="dhsucess">
					恭喜您兑换成功
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