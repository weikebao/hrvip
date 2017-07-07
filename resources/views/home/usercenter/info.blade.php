<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
    <title>会员中心</title>
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
        欢迎进入新纪元红日会员<span>个人资料</span>页面
    </div>
    <h1 class="tit_01">会员中心</h1>
    @include('layout.members.left_nav')
    <div class="m_right">
        <form class="con3" action="/members/info" method="post">
            {{csrf_field()}}
            <ul>
                <li class="list clear">
                    <div class="tit">姓名:</div>
                    <input type="text" class="" required name="name" value="{{$res['name']}}"/>
                </li>
                <li class="list clear">
                    <div class="tit">详细(收货)地址:</div>
                    <input type="text" class="" required name="address" value="{{$res['address']}}"/>
                </li>

                <li class="list clear">
                    <div class="tit">推荐码:</div>
                    <input type="text" class="" required name="code" value="{{$res['code']}}" readonly="readonly"/>
                </li>
                <li class="list clear">
                    <div class="tit">ID:</div>
                    <input type="text" class="" required name="phone" value="{{$res['phone']}}" readonly="readonly"/>
                </li>
                <!-- <li class="list clear">
                    <div class="tit">推荐码</div>
                    <input type="text" class="" required name="city" value=""/>
                </li> -->
                
                <!-- <li class="list clear">
                    <div class="tit">邮箱:</div>
                    <input type="text" name="email" placeholder="(选填)" value=""/>
                </li> -->
                <!-- <li class="list clear">
                    <div class="tit">绑定支付宝账号:</div>
                    <input type="text" class="" required name="alipay" value=""/>
                </li> -->
            </ul>
            <button class="submit" type="submit">保存</button>

        </form>
    </div>

</div>

<div class="footer">
    <p class="p1">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
</div>
// <script>
//     $('.submit').click(function(){
        // if(!(/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/.exec($('input[name="identity_number"]').val()))){
//             $('input[name="identity_number"]').focus().val('').attr('placeholder','请输入正确的身份证号码');
//             return false;
//         }
//         if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.exec($('input[name="phone"]').val()))){
//             $('input[name="phone"]').focus().val('').attr('placeholder','手机号格式不正确');
//             return false;
//         } 
//         if(!(/[\u4E00-\u9FA5]{2,4}/.exec($('input[name="name"]').val()))){
//             $('input[name="name"]').focus().val('').attr('placeholder','请输入真实姓名');
//             return false;
//         } 
//     });
</script>
<script src="/shop/js/members_nav_botton_style.js"></script>
</body>
</html>