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
        欢迎进入新纪元红日会员<span>绑定银行卡</span>页面
    </div>
    <h1 class="tit_01">会员中心</h1>
    @include('layout.members.left_nav')
    <div class="m_right">
        <form class="con3">
            <ul>
                <li class="list clear">
                    <div class="tit">姓名:</div>
                    <input type="text" name="tname" />
                </li>
                <li class="list clear">
                    <div class="tit">身份证账号:</div>
                    <input type="text" name="shenfenzheng" />
                </li>
                <li class="list clear">
                    <div class="tit">银行卡类型:</div>
                    <input type="text" class="icon1" name="tbankcode"/>
                </li>
                <li class="list clear">
                    <div class="tit">开户行:</div>
                    <input type="text" name="tbankaddress"/>
                </li>
                <li class="list clear">
                    <div class="tit">银行卡号:</div>
                    <input type="text" name="tbankzhanghao" />
                </li>
                <li class="list clear">
                    <div class="tit">电话:</div>
                    <input type="text" name="tphone" />
                </li>

            </ul>
            <button type="button">保存</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>

</div>

<div class="footer">
    <p class="p1">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
</div>

<script src="/shop/js/members_nav_botton_style.js"></script>
<script type="text/javascript">
    //点击按钮将信息保存到 数据库中
    $('button').click(function(){
        //获取信息
        var tname = $('input[name=tname]').val();
        var  tbankcode = $('input[name=tbankcode]').val();
        var tbankaddress = $('input[name=tbankaddress]').val();
        var tbankzhanghao = $('input[name=tbankzhanghao]').val();
        var phone = $('input[name=tphone]').val();
        var shenfenzheng = $('input[name=shenfenzheng]').val();
        var _token = $('input[name=_token]').val();
        //判断信息是否为空
        if(tname==''||tbankcode==''||tbankzhanghao==''||tbankaddress==''||phone==''){
            alert('请完整填写信息');
        }else if(tbankzhanghao.length<16||tbankzhanghao.length>25){
            alert('银行卡账号位数错误');
        }else if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(phone))){
            alert('手机号输入有误');
        }else{
            //发送ajax 保存信息
            $.ajax({
                url:'/members/bindcard',
                type:'post',
                data:{'tname':tname,'tbankcode':tbankcode,'tbankaddress':tbankaddress,'tbankzhanghao':tbankzhanghao,'tphone':phone,'_token':_token,'shenfenzheng':shenfenzheng},
                success:function(mes){
                    alert(mes);
                }
            })
        }
    })
</script>
</body>
</html>