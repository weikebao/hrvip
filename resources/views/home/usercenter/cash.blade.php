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
        欢迎进入新纪元红日会员<span>提款</span>页面
    </div>
    <h1 class="tit_01">会员中心</h1>
    @include('layout.members.left_nav')
    <div class="m_right">
        <form class="con3">
            <ul>
                <li class="list clear">
                    <div class="tit">姓名:</div>
                    <input type="text"  name="txname" value="{{$bank['tname']}}" readonly="readonly" />
                </li>

                <li class="list clear">
                    <div class="tit">电话:</div>
                    <input type="text" name="txphone" value="{{$bank['tphone']}}" readonly="readonly" />
                </li>
                <li class="list clear">
                    <div class="tit">余额:</div>
                    <input type="text" name="free" value="{{$res['free']}}" readonly="readonly" />
                </li>
                <li class="list clear">
                    <div class="tit">银行卡类型:</div>
                    <input type="text" name="txbankcode" value="{{$bank['tbankcode']}}"  readonly="readonly" />
                </li>
                <li class="list clear">
                    <div class="tit">银行卡号:</div>
                    <input type="text" name="txbankzhanghao" value="{{$bank['tbankzhanghao']}}"  readonly="readonly"/>
                </li>
                <li class="list clear">
                    <div class="tit">提现金额:</div>
                    <input type="text" value=""  name="tixianjins"/>
                </li>
                <li class="list clear">
                    <div class="tit">验证码:</div>
                    <input type="text" name="yzm_txt" class="yzm_txt" value="" />
                    <a href="javascript:;" class="yzm_btn">点击获取验证码</a>
                    <input type="hidden" name="msgcode" value="">
                </li>
            </ul>

            <button type="button">提现</button>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        </form>
    </div>

</div>
<script type="text/javascript">

$('.yzm_btn').click(function(){
    var phone = $('input[name=txphone]').val();
    var money = $('input[name=tixianjins]').val();
    var name = $('input[name=txname]').val();
    $.ajax({
        url:'/members/code',
        data:{'phone':phone,'money':money,'name':name},
        type:'get',
        success:function(mes)
        {
            //将验证码放在页面中
            $('input[name=msgcode]').val(mes);
        }
    })
})
</script>

<div class="footer">
   <p class="p1">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
</div>


<script type="text/javascript">
  //点击提现按钮提交工单等待提现的审核 只需要提现金
    //点击按钮时判断金额
   $('button').click(function(){
        var tixianjin = $('input[name="tixianjins"]').val();
        var yongjin = $('input[name="free"]').val();
        var code = $('input[name=yzm_txt]').val();
        var msgcode = $('input[name=msgcode]').val();
        if(code!=msgcode || msgcode==''){
            alert('验证码不正确');
        }else if(isNaN(tixianjin)){
            alert('请输入数字');
        }else if(parseInt(yongjin)<parseInt(tixianjin)){
            $('input[name=tixianjins]').val(yongjin);
        }else if(tixianjin==0){
            alert('请输入正确提现金额');
        }else{
            //发送ajax进行提现申请
            $.ajax({
                url:'/members/cashs',
                type:'post',
                data:{'_token':$('input[name="_token"]').val(),'txjin':tixianjin},
                success:function(mes){
                    console.log(mes)
                    if(mes==1){
                        alert('工单成功提交')
                        location.reload(true);
                    }else if(mes==2){
                        alert('工单提交失败')
                    }else if(mes==3)
                    {
                        alert('提现金额不满足最低提现要求')
                    }else{
                        alert('请填写身份证信息');
                    }
                }
            })
        }
    })
    
</script>
<script src="/shop/js/members_nav_botton_style.js"></script>
</body>
</html>