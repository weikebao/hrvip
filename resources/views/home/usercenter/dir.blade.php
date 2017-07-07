<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
    <title>会员中心</title>
    <link href="/shop/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="/shop/css/tikuanlishi.css">
    <link rel="stylesheet" href="/shop/bootstrap/css/bootstrap.min.css">
    <link href="/shop/css/media.css" rel="stylesheet" />
    <script type="text/javascript" src="/shop/js/jquery-1.8.3.js"></script>
    <script type="text/javascript" src="/shop/js/index.js"></script>
    <script src="/shop/bootstrap/js/bootstrap.min.js"></script>
    <style type="text/css">
    th,td{text-align: center!important;}
    </style>
</head>

<body id="mulu">
@include('layout.members.nav')
<div class="banner"></div>
<div class="main clear">
    <div class="title">
        欢迎进入新纪元红日会员<span>目录</span>页面
    </div>
    <h1 class="tit_01">会员中心</h1>
    @include('layout.members.left_nav')
    <div class="m_right">
        <table class="table table-bordered table-hover">
            <caption>目录</caption>
            <tr>
                <th>ID</th>
                <th>姓名</th>
                <th>消费金额</th>
                <th>余额</th>
                <th>当日返利</th>
                <th>太阳币</th>
                <th>代理截止日期</th>
            </tr>
            <tr>
                <td>{{$res['code']}}</td>
                <td>@if($res['name']){{$res['name']}}@else<a href="/members/info">完善信息</a>@endif</td>
                <td>￥{{$res['money']}}</td>
                <td>￥{{$res['free']}}</td>
                <td>@if($fanli['fanlimoney']){{$fanli['fanlimoney']}}@else无返利@endif</td>
                <td>{{$res['taiyangbi']}}颗</td>
                <td>{{$res['firstgoumai']}}</td>
            </tr>
        </table>


        {{--<ul class="con1">--}}
            {{--<li class="list">--}}
                {{--<p class="p1">ID</p>--}}
                {{--<p class="p2">{{$res['code']}}</p>--}}
            {{--</li>--}}
            {{--<li class="list">--}}
                {{--<p class="p1">姓名</p>--}}
                {{--<p class="p2">@if($res['name']){{$res['name']}}@else<a href="/members/info">完善信息</a>@endif</p>--}}
            {{--</li><br/>--}}
            {{--<li class="list">--}}
                {{--<p class="p1">代理金额</p>--}}
                {{--<p class="p2">￥{{$res['money']}}</p>--}}
            {{--</li>--}}
            {{--<li class="list">--}}
                {{--<p class="p1">余额</p>--}}
                {{--<p class="p2"><span>￥{{$res['free']}}</span></p>--}}
            {{--</li><br/>--}}
            {{--<li class="list">--}}
                {{--<p class="p1">当日返利</p>--}}
                {{--<p class="p2"><span>@if($fanli['fanlimoney']){{$fanli['fanlimoney']}}@else无返利@endif</span></p>--}}
            {{--</li>--}}
            {{--<li class="list">--}}
                {{--<p class="p1">太阳币</p>--}}
                {{--<p class="p2">{{$res['taiyangbi']}}颗</p>--}}
            {{--</li>--}}
            {{--<li class="list">--}}
                {{--<p class="p1">提现</p>--}}
                {{--<p class="p2">{{$txjin}}</p>--}}
            {{--</li>--}}
        {{--</ul>--}}

    </div>

</div>

<div class="footer">
    <p class="p1">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
</div>

<script src="/shop/js/members_nav_botton_style.js"></script>
</body>
</html>