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
        欢迎进入新纪元红日会员<span>更换银行卡</span>页面
    </div>
    <h1 class="tit_01">会员中心</h1>
    @include('layout.members.left_nav')
    <div class="m_right">
        <form class="con3">
            <ul>
                <li class="list clear">
                    <div class="tit">当前银行卡号:</div>
                    <input type="text" />
                </li>
                <li class="list clear">
                    <div class="tit">新银行卡号:</div>
                    <input type="text" />
                </li>
                <li class="list clear">
                    <div class="tit">重新输入密码:</div>
                    <input type="text" />
                </li>

            </ul>
            <button type="button">保存</button>

        </form>
    </div>

</div>

<div class="footer">
    <p class="p1">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
</div>

<script src="/shop/js/members_nav_botton_style.js"></script>
</body>
</html>