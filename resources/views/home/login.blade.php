<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
    <title>婳之萱-会员中心</title>
    <link rel="stylesheet" href="/shop/bootstrap/css/bootstrap.min.css">
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
        欢迎注册新纪元红日商城
    </div>
    <div class="m_left two">
        <img src="/shop/images/denglu_pic_03.jpg" />
    </div>

    <div class="m_right two">
        <form class="con3 denglu" action="/login" method="post">
            {{csrf_field()}}
            <ul>
                <li class="list mima_list clear">
                    <div class="tit">用户名:</div>
                    <input type="text" name="name" placeholder="请输入有效的ID"/>
                </li>
                <li class="list mima_list clear">
                    <div class="tit">密码:</div>
                    <input type="password" name="pass" placeholder="请输入有效的密码"/>
                </li>
                <li class="list clear">
                    <div class="tit">验证码:</div>
                    <input type="text" class="duan two" name="captcha"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img class="ewm_pic"  src="/login/captcha"/>
                    <!-- <div class="ewm_pic">
                    </div> -->
                    <a href="javascript:;" class="yzm_btn2">看不清<br/>换一个</a>
                </li>

            </ul>
            <button type="button" class="btn_3">立即登录</button>

        </form>
    </div>

</div>
<script type="text/javascript">
    
    $(function(){
        var code; //在全局 定义验证码  
        code = "";
      var codeLength = 4;//验证码的长度  
      var checkCode = document.getElementById("checkCode");
      var selectChar = new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');//所有候选组成验证码的字符，当然也可以用中文的  
      
      for (var i = 0; i < codeLength; i++) {
        var charIndex = Math.floor(Math.random() * 26);
        code += selectChar[charIndex];
      }
     //将验证码写到页面中
     $('.ewm_pic').html(code);
    })
</script>

<div class="footer">
    <p class="p1">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
</div>

<!-- <script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script> -->
<script src="\shop\js\jquery-1.8.3.js"></script>
<script src="/shop/js/members_login.js"></script>
<script src="/shop/js/members_nav_botton_style.js"></script>
</body>
</html>