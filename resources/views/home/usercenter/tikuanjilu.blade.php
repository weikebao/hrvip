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
            欢迎进入新纪元红日会员<span>提款记录</span>页面
        </div>
        <h1 class="tit_01">会员中心</h1>
        @include('layout.members.left_nav')
        <div class="m_right">
            <table class="table table-bordered">
                <caption>提款记录</caption>
                <tr>
                    <!-- <th>#</th> -->
                    <th>提款时间</th>
                    <th>金额</th>
                    <th>状态</th>
                </tr>
                @foreach($res as $v)
                <tr class="huoqushuju">
                    <td>{{$v['time']}}</td>
                    <td>{{$v['txjin']}}</td>
                    <td>@if($v['status']==1)未审核@else已审核@endif</td>
                </tr>
                @endforeach
            </table>
            <div class="fenye">
            {!! $res->render() !!}
        </div>
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
            //隐藏一部分数据
           $('.pagination li').each(function(){
            if(($(this).index()>2) && ($(this).index()<num)){
                // 将这些数据进行隐藏
                $(this).css('display','none');
            }
           })
        }
    })
    </script>
    </div>
    <div class="footing">
        <p class="p1">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
    </div>
</body>
</html>