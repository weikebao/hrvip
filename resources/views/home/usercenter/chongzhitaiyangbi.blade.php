<!DOCTYPE HTML>
<HTML>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scale=no">
<title>太阳币中心</title>
<link href="/shop/css/goumai.css" rel="stylesheet" type="text/css">
	<link href="/shop/css/style.css" rel="stylesheet" />
	<link href="/shop/css/media.css" rel="stylesheet" />
	<script type="text/javascript" src="/shop/js/jquery-1.8.3.js"></script>
	<script type="text/javascript" src="/shop/js/index.js"></script>
</head>
<body id="mulu">
@include('layout.members.nav')
<div class="banner"></div>


	{{--<img class="czpic" src="./images/czpic.png">--}}
	<div class="main clear">
		<div class="title">
			欢迎进入新纪元红日会员<span>充值</span>页面
		</div>
		<h1 class="tit_01">会员中心</h1>
	@include('layout.members.left_nav')
		<div class="mright">
			<div class="biaozhun">太阳币充值中心，一太阳币等于一元</div>
			<div class="xinxi">
				<div class="shoujihao">
					<div class="text"><input type="text" name="phone" placeholder="      请输入手机号"/></div>
					<p>充值手机号码：</p>
				</div>
				<div class="miane">
					<div class="text"><input type="text" name="jine" placeholder="      请输入充值面额"/></div>
					<p>充值面额：</p>
				</div>
				<div class="price">
					<div class="text">900</div>
					<p>销售价格：</p>
				</div>
				<div class="gmsubmit">
					<input type="submit" value="立即充值" class="click"/>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$("input[name=jine]").keyup(function(){
			var jine = $(this).val();
			$('.price div').html(jine);
		})
		//点击按钮
		$(".click").click(function(){
			//获取充值的金额和手机号码
			var  phone = $('input[name=phone]').val();
			var money = $('input[name=jine]').val();
			if(!(/^1[3|4|5|7|8][0-9]\d{4,8}$/.test(phone))){
				alert('手机号不能为空');
			}else{
				//将购买的信息传递到下个页面
				location.href="/members/chongzhizhongxin?phone="+phone+"&money="+money
			}
		})
	</script>

	<div class="footer">
		<p class="p1" style="word-wrap:break-word ;">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
	</div>
	<script src="/shop/js/members_nav_botton_style.js"></script>
</body>
</HTML>