$('.ewm_pic,.yzm_btn2').click(function(){
    $('.ewm_pic').attr('src',$('.ewm_pic').attr('src')+"?id="+Math.random());
});
$('button').click(function(){
    if($('input[name="captcha"]').val().length==0){
        $('input[name="captcha"]').focus().attr('placeholder','请输入验证码');
        $('.ewm_pic').click();
        return false;
    }
    if($('input[name="name"]').focus().val().length==0){
        $('input[name="name"]').focus().attr('placeholder','请输入用户名');
        $('.ewm_pic').click();
        return false;
    }
    if($('input[name="pass"]').focus().val().length<6 || $('input[name="pass"]').focus().val().length>12){
        $('input[name="pass"]').focus().val('').attr('placeholder','请输入6-12位的密码');
        $('.ewm_pic').click();
        return false;
    }
    $.ajax({
        url:'/login/index',
        type:'POST',
        data:{'name':$('input[name="name"]').val(),'pass':$('input[name="pass"]').val(),'captcha':$('input[name="captcha"]').val(),'_token':$('input[name="_token"]').val()},
        success:function(mes){
            if(mes=='请输入正确的验证码'){
                $('input[name="captcha"]').focus().val('').attr('placeholder',mes);
                $('.ewm_pic').click();
            }else if(mes=='请输入正确的用户名'){
                $('input[name="name"]').focus().val('').attr('placeholder',mes);
                $('.ewm_pic').click();
            }else if(mes=='请输入正确的密码'){
                $('input[name="pass"]').focus().val('').attr('placeholder',mes);
                $('.ewm_pic').click();
            }else if(mes=='do'){
                location.href='/';
            }
        }
    });
});