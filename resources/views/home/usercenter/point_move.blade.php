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
        欢迎进入新纪元红日会员<span>积分</span>页面
    </div>
    <h1 class="tit_01">会员中心</h1>
    @include('layout.members.left_nav')
    <div class="m_right">
        <form class="con3">
            {{csrf_field()}}
            <ul>
                <li class="list clear">
                    <div class="tit">用户名:</div>
                    <input type="text" name="name" value="{{session('hr_member')['name']}}" disabled/>
                </li>

                <li class="list clear">
                    <div class="tit">账户积分余额:</div>
                    <input type="text" name="balance" value="{{$res}}" disabled/>
                </li>
                <!-- <li class="list clear">
                    <div class="tit">即将过期积分:</div>
                    <input type="text" name="nearlose" value="" disabled/>
                </li> -->
                <li class="list clear">
                    <div class="tit">赠送数额:</div>
                    <input type="text" name="amount"/>
                </li>
                <li class="list clear">
                    <div class="tit">受赠ID:</div>
                    <input type="text" class="icon1" name="toid"/>
                </li>

            </ul>
            <button type="button">立即赠送</button>

        </form>
    </div>

</div>

<div class="footer">
    <p class="p1">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
</div>
<script>
    // $('input[name="amount"]').focus(function(){
    //     $(this).val($('input[name="nearlose"]').val());
    // });
    $('input[name="amount"]').keyup(function(){
        if(parseInt($('input[name="amount"]').val())>parseInt($('input[name="balance"]').val())){
            $('input[name="amount"]').val($('input[name="balance"]').val());
        }
    });
    $('button').click(function(){
        if($('input[name="amount"]').val().length==0 || $('input[name="amount"]').val()==0){
            $('input[name="amount"]').focus().val("").attr('placeholder','赠送数额不能为空');
            return false;
        }
        if($('input[name="toid"]').val().length==0){
            $('input[name="toid"]').focus().attr('placeholder','受赠人ID不能为空');
            return false;
        }
        if(!(/\d+/.exec($('input[name="toid"]').val()))){
            $('input[name="toid"]').focus().val('').attr('placeholder','请输入正确的受赠人ID');
            return false;
        }
    //     if($('input[name="amount"]').val()>$('input[name="balance"]').val()){
    //         $('input[name="amount"]').focus().attr('placeholder','赠送积分数额不能超过积分余额');
    //         return false;
    //     }
        $.ajax({
            url:'/members/pointmove',
            type:'POST',
            data:{'amount':$('input[name="amount"]').val(),'toid':$('input[name="toid"]').val(),'_token':$('input[name="_token"]').val()},
            success:function(mes){
                if(mes=='受赠人不存在'){
                    $('input[name="toid"]').focus().val('').attr('placeholder',mes);
                }else if(mes=='do'){
                    alert('赠送积分成功');
                    location.href='/members/pointmove';
                }else{
                    alert('赠送积分失败');
                }
            }
        });
    });
    
</script>
<script src="/shop/js/members_nav_botton_style.js"></script>
</body>
</html>