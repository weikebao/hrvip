<!DOCTYPE HTML>
<HTML>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scale=no">
<title>太阳币中心</title>
	<link href="/shop/css/chongzhizhongxin.css" rel="stylesheet" type="text/css">
	<link href="/shop/css/style.css" rel="stylesheet" />
	<link href="/shop/css/media.css" rel="stylesheet" />
	<link href="/shop/css/chongzhizhongxin.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="/shop/js/jquery-1.8.3.js"></script>
	<script type="text/javascript" src="/shop/js/index.js"></script>
    <style type="text/css">
    
    </style>
</head>
<body id="mulu">
@include('layout.members.nav')
<div class="banner"></div>
<div class="main clear">
	<!--头部导航结束-->

<div class="content">
	<!--显示页面位置-->
	<div class="location">
		<p>您当前位置：太阳币中心＞充值中心</p>
	</div>

	<!--显示金钱-->
	<h1 class="tit_01">会员中心</h1>
	@include('layout.members.left_nav')
	<div class="xianshi">
		<div class="pic">
		</div>
		<div class="txt">
			<p class="txt1">新纪元红日生物科技充值太阳币<span></span>元，及时到账</p>
			<p class="phone">买家手机号：<span></span></p>
		</div>
		<div class="money">￥<span></span></div>
	</div>
	<div class="line"></div>
	<div class="buttons">
		<div class="btns">
			<div class="btn1"><input type="button" name="zhifubao" value="支付宝支付"/></div>
			<!-- <div class="btn2"><input type="button" name="yinlian" value="在线支付"/></div> -->
			<div class="btn3"><input type="button" name="weixin" value="微信支付"/></div>
		</div>

		
		<div class="tanchuang">
			<div class="cztupian"><img src="" style="background-color: #fff;height:200px;width:200px;display:none;"></div>
			<div class="czbiaoge" style="display:none;">
				<table border="1" cellspacing="0">
					<tr>
						<th>充值名称</th>
						<th>手机号</th>
						<th>订单号</th>
						<th>充值日期</th>
					</tr>
					<tr class="shuju">
					<!-- 	<td></td>
						<td></td>
						<td></td> -->
					</tr>
				</table>
			</div>
		</div>
		   {{CSRF_FIELD()}}
		 <script type="text/javascript">
            //将url中的数值显示到页面中
            $(function(){
                function GetQueryString(name)
                {
                    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
                    var r = window.location.search.substr(1).match(reg);
                    if(r!=null)return decodeURI(r[2]); return null; //这个是获取汉字不乱码
                }
               var  num = GetQueryString('money');
               $('.txt1 span').html(num);
               $('.money span').html(num);
               var phone = GetQueryString('phone');
               $('.phone span').html(phone);
            })
            //点击微信支付进行支付
            $('input[name=weixin]').click(function(){
            	var money = $('.money span').html(); 
            	var phone = $('.phone span').html();
            	if(money==''||phone==''){
            		alert('充值条件不足')
            	}else{
            		//发送ajax
            		 //发送数据到后台
                    $.ajax({
                        url:'/members/pay',
                        data:{'phone':phone,'num':money,'_token':$('input[name="_token"]').val()},
                        type:'post',
                        dataType:'json',
                        success:function(mes)
                        {
                            if(mes==2){
                                alert('充值延时,请重新充值');
                            }else if(mes==3){
                            	alert('充值手机号不存在');
                            }else{
                                //清除原来的信息
                                $('.shuju').empty();
                                $('.cztupian img').css('display','block');
                                $('.czbiaoge').css('display','block');
                               //将二维码输出
                                $('.cztupian img').attr('src','http://paysdk.weixin.qq.com/example/qrcode.php?data='+mes.code_url);
                                //将这个人的充值信息显示在页面中 
                                $('.shuju').append('<td>'+mes.body+'</td><td>'+mes.phone+'</td><td>'+mes.total_fee+'元</td><td>'+mes.out_trade_no+'</td>');
                            }
                        }
                    })
            	}
            })

             //定时便利查询数据库用户充值是否成功
                $(function(){
                    var time = setInterval(function(){
                        //判断是否有订单的编号 如果有查询数据库
                        var outid = $('.shuju td:eq(3)').html();
                        if(outid.length>0){
                            //发送ajax判断充值是否成功
                            $.ajax({
                                url:'/members/result',
                                data:{'outid':outid},
                                type:'get',
                                success:function(mes){
                                    if(mes==1){
                                        alert('恭喜您,充值成功');
                                        //关闭本轮的查询
                                        clearTimeout(time)
                                    }else if(mes==2){
                                        alert('充值失败,请联系客服');
                                    }
                                }
                            })
                        }
                    },3000)
            })
            //点击进行支付宝支付
            $('input[name=zhifubao]').click(function(){
            	var money = $('.money span').html(); 
            	var phone = $('.phone span').html();
            	if(money==''||phone==''){
            		alert('充值条件不足')
            	}else{
            		window.open("/members/zpy?phone="+phone+"&num="+money);
            	}
            	// 	//发送ajax
            	// 	 //发送数据到后台
             //        $.ajax({
             //            url:'/members/zpy',
             //            data:{'phone':phone,'num':money,'_token':$('input[name="_token"]').val()},
             //            type:'post',
             //            // dataType:'json',
             //            success:function(mes)
             //            {
             //            	console.log(mes);
             //            	location.href=mes;
             //                // if(mes==2){
             //                //     alert('充值延时,请重新充值');
             //                // }else if(mes==3){
             //                // 	alert('充值手机号不存在');
             //                // }else{
             //                //     //清除原来的信息
             //                //     $('.shuju').empty();
             //                //    //将二维码输出
             //                    // $('.cztupian img').attr('src',mes);
             //                //     //将这个人的充值信息显示在页面中 
             //                //     $('.shuju').append('<td>'+mes.body+'</td><td>'+mes.phone+'</td><td>'+mes.total_fee+'元</td><td>'+mes.out_trade_no+'</td>');
             //                // }
             //            }
             //        })
            	// }
            })
             $('input[name=yinlian]').click(function(){
                var money = $('.money span').html(); 
                var phone = $('.phone span').html();
                if(money==''||phone==''){
                    alert('充值条件不足')
                }else{
                    window.open("/members/ylpay?phone="+phone+"&num="+money);
                }
            })
        </script>
	</div>
</div>

</div>
<div class="footer">
	<p class="p1" style="word-wrap:break-word ;">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
        
    
</div>
<script src="/shop/js/members_nav_botton_style.js"></script>
</body>
</HTML>
