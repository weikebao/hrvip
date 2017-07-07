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
        欢迎进入新纪元红日会员<span>修改密码</span>页面
    </div>
    <h1 class="tit_01">会员中心</h1>
    @include('layout.members.left_nav')
    <div class="m_right">
        <form class="con3">
            {{csrf_field()}}
            <ul>
                <li class="list clear">
                    <div class="tit">当前密码:</div>
                    <input type="text" name="old_pass"/>
                </li>
                <li class="list clear">
                    <div class="tit">新密码:</div>
                    <input type="text" name="pass"/>
                </li>
                <li class="list clear">
                    <div class="tit">重新输入密码:</div>
                    <input type="text" name="confirm_pass"/>
                </li>


            </ul>
            <button type="button" class="btn_2">保存</button>

        </form>
    </div>

</div>

<div class="footer">
    <p class="p1">@ L’Oreal China 红日（中国）有限公司版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;沪ICP备08100043号-34 </p>
</div>
<!-- <script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script> -->
<script src="/shop/js/changepass.js"></script>
<script src="/shop/js/members_nav_botton_style.js"></script>

</body>
</html>