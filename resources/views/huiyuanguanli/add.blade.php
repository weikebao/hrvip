<!-- @extends('layout.layout') -->
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>添加下属会员</span>
        </div>
        <div class="mws-panel-body no-padding">
            <form class="mws-form" method="post" action="/admin/tuihuiyuan/adds" >
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">会员姓名</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='name'  value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">会员账号(手机号)</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='phone'  value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">会员密码</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='pass'  value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">会员地址</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='address'  value="">
                        </div>
                    </div>
                    <div class="mws-form-row bordered">
                        <label class="mws-form-label">选择位置部门</label>
                        <div class="mws-form-item">
                     <!--    <span class="11">点击加1</span>
                        <input type="text" name="qujian" value='1'>
                        <span class="22">点击减1</span>
                        <script type="text/javascript">
                            $(".11").click(function(){
                                $('input[name=qujian]').val('2')
                            })
                            $(".22").click(function(){
                                $('input[name=qujian]').val('1');
                            })
                        </script> -->
                            <select class="small qujian" name="qujian">
                                <option value="1">一部门
                                <option value="2">
                                二部门</option>
                                @if($id['zuoqujian']>=375 && $id['youqujian']>=375)
                                <option value="3">
                                三部门</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="mws-form-row bordered">
                        <label class="mws-form-label">会员的性质</label>
                        <div class="mws-form-item">
                            <select class="small jidian" name="jidian">
                                <option value="1">公司会员(不可更换)
                                <option value="2">
                                公司会员(可更换)
                            </select>
                        </div>
                    </div>
                    <!-- 这个是用户的id -->
                    <input type="hidden" name="id" id="id" value="{{$id['id']}}"><!-- <div class="d3">点击+1</div> -->
                    <!-- <script type="text/javascript">
                        //点击按钮进行加1
                        $('.d3').click(function(){
                           $("#id").val(parseInt($("#id").val())+1); 
                        })
                    </script> -->
                    <!-- <input type="text" name="code" id="code" value="1" placeholder="填写所属人员"><span id="d3">点击+1</span>
                    <script type="text/javascript">
                        //点击按钮进行加1
                        $('#d3').click(function(){
                           $("#code").val(parseInt($("#code").val())+1); 
                        })
                    </script> -->
                    <div class="mws-button-row">
                        <!-- <input type="submit" value="点击提交" class="btn btn-danger"> -->
                        <b class="c" style="color:green;border:5px solid">点击提交</b>
                        <a href="/admin/tuihuiyuan/index" style="color:red;border:1px solid;margin-left:150px;">返回首页</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{csrf_field()}}
    <script type="text/javascript">
        //点击获取传送的数据
        $('.c').click(function()
        {
            //获取用户的姓名
            var name = $('input[name=name]').val();
            var phone = $('input[name=phone]').val();
            var pass = $('input[name=pass]').val();
            var address = $('input[name=address]').val();
            var id = $('input[name=id]').val();
            var code = $('input[name=id]').val();
            if(name=='' || phone=='' || pass=='' ||address=='')
            {
                alert('请填写完整数据');
            }else{
                 //便利获取select选择的区间
                var qujian = $(".qujian").find("option:selected").val();
                // var  qujian = $('input[name="qujian"]').val();

                var jidian = $(".jidian").find("option:selected").val();
                var _token = $('input[name="_token"]').val();

                //发送ajax添加相应的数据
                $.ajax({
                    url:'/admin/tuihuiyuan/adds',
                    data:{'_token':_token,'name':name,'phone':phone,'pass':pass,'address':address,'qujian':qujian,'jidian':jidian,'id':id,'code':code},
                    type:'post',
                    success:function(mes)
                    {
                        console.log(mes);
                        // alert('成功');
                        mes = mes+'----是否返回首页?';
                        if(confirm(mes))
                        {
                            //点击确定回到首页
                            location.href="/admin/tuihuiyuan/index";
                        }else{
                            //点击取消留在当前页面
                            location.reload(true);
                        }
                    }
                })
            }
        })

    </script>
@endsection