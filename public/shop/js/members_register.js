$('button').click(function(){

    if($('input[name="shenfenzheng"]').val().length==0){
        $('input[name="shenfenzheng"]').focus().attr('placeholder','用户名称不能为空!');
        return false;
    }
    if($('input[name="phone"]').val().length==0){
        $('input[name="phone"]').focus().attr('placeholder','请输入手机号码');
        return false;
    }
    if(!(/^1[3|4|5|7|8][0-9]\d{4,8}$/.exec($('input[name="phone"]').val()))){
        $('input[name="phone"]').focus().val('').attr('placeholder','手机号格式不正确');
        return false;
    } 
    if($('input[name="pass"]').val().length<6 || $('input[name="pass"]').val().length>12){
        $('input[name="pass"]').focus().val('').attr('placeholder','请输入6-12位的密码');
        return false;
    }
    if($('input[name=pass]').val() != $('input[name=pwd]').val()){
        $('input[name="pwd"]').focus().val('').attr('placeholder','两次密码不一致');
        return false;
    }
    if($('input[name="code"]').val().length==0){
        $('input[name="code"]').focus().attr('placeholder','请输入推荐码');
        return false;
    }
    if(($('input[name=codes]').val()!=$('input[name=msg]').val()) || ($('input[name=msg]').val()=='')){
        $('input[name=msg]').focus().attr('placeholder','验证码不正确');
        return false;
    }
    $.ajax({
        url:'/register',
        type:'POST',
        data:{'shenfenzheng':$('input[name="shenfenzheng"]').val(),'phone':$('input[name="phone"]').val(),'pass':$('input[name="pass"]').val(),'code':$('input[name="code"]').val(),'msg':$('input[name="msg"]').val(),'_token':$('input[name="_token"]').val()},
        success:function(mes){
            if(mes=="该号码已被注册"){
                $('input[name="phone"]').focus().val('').attr('placeholder',mes);
            }else if(mes=="推荐码不正确"){
                 $('input[name="code"]').focus().val('').attr('placeholder',mes);
            }else if(mes=="短信验证码不正确"){
                $('input[name="msg"]').focus().val('').attr('placeholder',mes);
            }else if(mes=="do"){
                alert('注册成功,请通知推荐人激活账户');
                location.href="/login";
            }else if(mes=="该号码已成功注册"){
                alert('注册成功!请尽快完善您的个人信息并通知推荐人激活您的账户。');
                location.href="/login";
            }
        }

    });
});