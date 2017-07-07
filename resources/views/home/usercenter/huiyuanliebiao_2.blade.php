<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
    <title>会员中心</title>
    <link href="/shop/css/style.css" rel="stylesheet" />
    <link href="/shop/css/media.css" rel="stylesheet" />

    <script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="/shop/js/index.js"></script>
    <script type="text/javascript" src="/shop/js/jquery-1.8.3.js"></script>

</head>


<body id="mulu">
@include('layout.members.nav')
<div class="banner"></div>
<div class="main clear">
    <div class="title">
        欢迎进入新纪元红日会员目录页面<span>未分配会员</span>页面
    </div>
    <h1 class="tit_01">会员中心</h1>
    @include('layout.members.left_nav')
    <div class="m_right">
        <table class="con4">
        <input type="hidden" name="id" value="{{$id['id']}}">
        {{csrf_field()}}
            <tbody>
            @foreach($res as $v)
            <tr>
                <td><span class="icon2">{{$v['shenfenzheng']}}</span></td>
                <td>{{$v['phone']}}</td>
                <td>
                    <select name="select" style="cursor:pointer;">
                    <option value="1">一部门</option>
                    <option value="2">二部门</option>
                    @if(($id['zuoqujian']>=375) &&($id['youqujian']>=375))
                    <option value="3">三部门</option>
                    @endif
                    </select>
                </td>
                <td><a href="javascript:;" class="a2">确认<input type="hidden" name="fid" value="{{$v['id']}}"></a></td>
            </tr>
            @endforeach
            </tbody>

        </table>



    </div>

</div>

<div class="footer">
    <p class="p1">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
</div>
<script type="text/javascript">
    //点击填入将用户分配给制定的用户
    $('table .a2').live('click',function()
    {
        if(confirm('确定分配?')){
            //获取被分配的人的ID
            var fid = $(this).find('input').val();
            //获取分配人的ID
            var  id = $('input[name=id]').val();
            //获取选择的部门
            var bumen = $(this).parent('td').prev('td').find('select[name=select]').val();
            var _token = $('input[name="_token"]').val();
            //发送ajax
            $.ajax({
                url:'/members/ajax',
                data:{'fid':fid,'id':id,'bumen':bumen,'_token':_token},
                type:'post',
                success:function(mes)
                {
                     mes = mes+'----是否返回首页?';
                    if(confirm(mes))
                    {
                        //点击确定回到首页
                        location.href="/members/changecustomer";
                    }else{
                        //点击取消留在当前页面
                        location.reload(true);
                    }
                }
            })
        }
    })
</script>





</body>
</html>