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
    <script src="/shop/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/shop/js/jquery-1.8.3.js"></script>
    <script type="text/javascript" src="/shop/js/index.js"></script>
    <style type="text/css">
    th,td{text-align: center!important;}
    </style>
</head>
    
<body id="mulu">
@include('layout.members.nav')
<div class="banner"></div>
<div class="main clear">
    <div class="title">
        欢迎进入新纪元红日会员<span>充值记录</span>页面
    </div>
    <h1 class="tit_01">会员中心</h1>
    @include('layout.members.left_nav')
    <div class="m_right">
        <table class="table table-bordered">
            <caption>充值记录</caption>
            <tr>
                <!-- <th>#</th> -->
                <th>充值时间</th>
                <th>充值类型</th>
                <th>充值金额</th>
            </tr>
            @foreach($res as $val)
            <tr class="huoqushuju">
                <!--获取数据-->
                <td>{{$val['time']}}</td>
                <td>{{$val['code']}}</td>
                <td>{{$val['money']}}</td>
            </tr>
            @endforeach
        </table>
        <div class="fenye">
            {!! $res->render() !!}
        </div>
        <script type="text/javascript">
        $(function(){
        var length = $('.pagination li').length-2;
        var lengths = length+1;
        $('.pagination li:eq(0) span').html('上一页');
        $('.pagination li:eq(0) a').html('上一页');
            $('.pagination li:eq('+lengths+') span').html('下一页');
            $('.pagination li:eq('+lengths+') a').html('下一页');
        var num = length-1;
        if(length>3){
            //Òþ²ØÒ»²¿·ÖÊý¾Ý
           $('.pagination li').each(function(){
            if(($(this).index()>2) && ($(this).index()<num)){
                // ½«ÕâÐ©Êý¾Ý½øÐÐÒþ²Ø
                $(this).css('display','none');
            }
           })
        }
    })
    </script>
    </div>
</div>
<div class="footing">
    <p class="p1">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
</div>
</body>
</html>