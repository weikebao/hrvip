$('button').click(function(){
    if($('input[name="old_pass"]').val().length==0){
        $('input[name="old_pass"]').focus().attr('placeholder','请输入原密码验证身份');
        return false;
    }
    if($('input[name="pass"]').val().length<6 || $('input[name="pass"]').val().length>12){
        $('input[name="pass"]').focus().val('').attr('placeholder','请输入6-12位的密码');
        return false;
    }
    if($('input[name="pass"]').val()!=$('input[name="confirm_pass"]').val()){
        $('input[name="confirm_pass"]').focus().val('').attr('placeholder','两次输入的密码不一致');
        return false;
    }
    $.ajax({
        url:'/members/changepass',
        type:'POST',
        data:{'old_pass':$('input[name="old_pass"]').val(),'pass':$('input[name="pass"]').val(),'_token':$('input[name="_token"]').val()},
        success:function(mes){
            if(mes=='原密码错误'){
                $('input[name="old_pass"]').focus().val('').attr('placeholder',mes);
            }else if(mes=="修改密码失败"){
                alert(mes);
            }else if(mes=="do"){
                alert('密码修改成功');
                location.href='/';
            }
        }
    });
});