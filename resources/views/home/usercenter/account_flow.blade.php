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
    .pagination{padding:0 0 30px;text-align: center;margin-top:20px;}
    .pagination li{display: inline-block;width: 80px;height:30px;line-height: 30px;text-align: center;border: 1px solid #cdcdcd;background: #fff;}
    .pagination a{color:#62e810;display: block;}
    th,td{text-align: center!important;}
    </style>
</head>
<script type="text/javascript">
    //预先加载分页的个数如果分页的栏目太多自动的省略中间的部分
    $(function(){
        var length = $('.pagination li').length-2;
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
<body id="mulu">
@include('layout.members.nav')
<div class="banner"></div>
<div class="main clear">
    <div class="title">
        欢迎进入新纪元红日会员<span>账目流水</span>页面
    </div>
    <h1 class="tit_01">会员中心</h1>
    @include('layout.members.left_nav')
    <div class="m_right">
        <table class="table table-bordered">
            <caption>最近三个月</caption>
            <tr>
                <th>交易状态</th>
                <th>数目</th>
                <th>余额</th>
                <th>发起时间</th>
            </tr>
            <tbody>
            @foreach($res as $v)
            <tr>
                <td>@if($v['status']==1)审批中@elseif($v['status']==2)通过审批@else审批失败@endif</td>
                <td>{{$v['txjin']}}元</td>
                <td>{{$text['free']}}元</td>
                <td>{{$v['time']}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>

        <div class="page01">
        {!! $res->render() !!}
            <!-- <ul class="clear">
                <li class="list">
                    <a href="javascript:;"><</a>
                </li>
                <li class="list">
                    <a href="javascript:;">1</a>
                </li>
                <li class="list">
                    <a href="javascript:;">2</a>
                </li>
                <li class="list one"></li>
                <li class="list one"></li>
                <li class="list one"></li>
                <li class="list"><a href="javascript:;">99</a></li>
                <li class="list three">跳至</li>
                <li class="list"><input type="text"></li>
                <li class="list">页</li>
                <li class="list"><a href="javascript:;">跳转</a></li>

            </ul> -->

        </div>

    </div>

</div>

<div class="footer">
    <p class="p1">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
</div>

<script src="/shop/js/members_nav_botton_style.js"></script>
</body>
</html>