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
        欢迎注册新纪元红日会员
    </div>
    <div class="m_left two">
        <img src="/shop/images/denglu_pic_03.jpg" />
    </div>

    <div class="m_right two">
        <form class="con3 denglu">
            {{csrf_field()}}
            <ul>
                <li class="list clear">
                    <div class="tit">用&nbsp;户&nbsp;I&nbsp;D:</div>
                    <input type="text" name="phone" value="" required placeholder="请输入正确手机号码" />
                </li>
                <script type="text/javascript">
                    $('input[name=phone]').blur(function(){
                        //发送ajax 判断有没有注册data
                        var phone = $(this).val();
                        $.ajax({
                            url:'/register/ceshi',
                            data:{'phone':phone,'_token':$('input[name="_token"]').val()},
                            type:'post',
                            success:function(mes)
                            {
                                if(mes==1){
                                    $('input[name="phone"]').focus().val('').attr('placeholder','该号码已被注册');
                                }
                            }
                        })
                    })
                </script>
                <li class="list clear">
                    <div class="tit">姓&nbsp;&nbsp;&nbsp;&nbsp;名:</div>
                    <input type="text" name="shenfenzheng" required value="" placeholder="请输入真实姓名"/>
                </li>
                 <li class="list mima_list clear">
                    <div class="tit">密码:</div>
                    <input type="password" name="pass" placeholder="密码由6－12个字符组成"/>
                </li>
                <li class="list mima_list clear">
                    <div class="tit">确认密码:</div>
                    <input type="password" name="pwd"  placeholder="密码由6－12个字符组成"/>
                </li>
                <script type="text/javascript">
                    $('input[name=pwd]').blur(function(){
                        //判断两次密码的数据是否一直
                        var pass = $('input[name=pass]').val();
                        var pwd = $('input[name=pwd]').val();
                        if(pwd !=pass){
                            $('input[name=pwd]').val('');
                            $('input[name=pwd]').attr('placeholder','两次密码不一致');
                            return false;
                        }
                    })
                </script>
                <li class="list clear">
                    <div class="tit">推荐ID:</div>
                    <input type="text" name="code" required value="" />
                </li>
                <li class="list clear">
                    <div class="tit">手机验证码:</div>
                    <input type="text" class="duan" name="msg" required value="" />

                    <a href="javascript:;" class="yzm_btn">获取验证码</a>
                    <input type="hidden" name="codes" value="">
                </li>
            </ul>
            <script type="text/javascript">
                //点击获取验证码来进行验证
                $('.yzm_btn').click(function(){
                    //点击按钮进行倒计时  60秒钟
                    //改变按钮的文字
                    // var  s=30;
                    // var time =setInterval(function(){
                    //         s = s-1;
                    //         if(s==0){
                    //             s = 30;
                    //             clearTimeout(time);
                    //         }else{
                    //             $('.yzm_btn').html(s+'秒');
                    //         }
                    //     },1000)




                    //发送ajax
                    var phone = $('input[name="phone"]').val();
                    //正则判断会否正确  手机号
                    if(!(/^1[3|4|5|7|8][0-9]\d{4,8}$/.exec($('input[name="phone"]').val()))){
                        alert('请输入正确手机号码');
                    }else{
                        $.ajax({
                            url:"/register/aliyun",
                            data:{'phone':phone},
                            type:'get',
                            success:function(mes)
                            {
                                //将验证码放在隐藏位置上 便于做判断使用
                                $('input[name=codes]').val('');
                                $('input[name=codes]').val(mes);
                            }
                        })
                    }
                })
            </script>
            <button type="button" class="btn_3">立即注册</button>
        </form>
    </div>

</div>

<div class="footer">
    <p class="p1">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
</div>

<!-- <script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script> -->
<script src="/shop/js/members_register.js"></script>
<script src="/shop/js/members_nav_botton_style.js"></script>
</body>
</html>