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
    <script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="/shop/js/index.js"></script>
    <script type="text/javascript" src="/shop/js/jquery-1.8.3.js"></script>
    <style type="text/css">
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
        欢迎进入新纪元红日会员页面<span>分配会员</span>页面
    </div>
    <h1 class="tit_01">会员中心</h1>
    @include('layout.members.left_nav')
    <div class="m_right">
        <form class="top_box">
            搜索:&nbsp;
            {{csrf_field()}}
            <input type="text" value="" placeholder="请输入要查找的人员姓名"/>
            <button type="button"></button>
            <input type="hidden" name="zuojiedian" value="{{$ding['zuojiedian']}}">
            <input type="hidden" name="youjiedian" value="{{$ding['youjiedian']}}">
            <input type="hidden" name="sanjiedian" value="{{$ding['sanjiedian']}}">
        </form>
        <script type="text/javascript">
            //点击按钮查询相应的人员
            $(function(){$('form button').click(function(){
                var name = $(this).prev('input').val();
                var zuojiedian = $(this).next('input[name=zuojiedian]').val();
                var youjiedian = $(this).next('input[name=zuojiedian]').next('input[name=youjiedian]').val();
                var sanjiedian = $(this).next('input[name=zuojiedian]').next('input[name=youjiedian]').next('input[name=sanjiedian]').val();
                var _token = $('input[name="_token"]').val();
                if(name!=''){
                    $.ajax({
                        url:'/members/sousuo',
                        data:{'name':name,'_token':_token},
                        type:'post',
                        dataType:'json',
                        success:function(mes){
                            if(mes==1){
                                alert('您搜索的会员姓名不存在!');
                            }else{
                                $('.sousuo').empty();
                                //隐藏分页效果
                                $('.pagination').remove();
                                    var tianjia = '';
                                    var tiaojian = '';
                                    var fid = mes.id;
if((mes.zuojiedian==null || mes.youjiedian==null)||((mes.zuoqujian>=375) && (mes.youqujian>=375) && mes.sanjiedian==null)){
tianjia = '<a style="color:green;font-size: 12px;">添加<input type="hidden" name="fid" value='+mes.id+'></a>';
                                    }else{
                                        tianjia ='两侧已满';
                                    }
                                    if(mes.sanqujian!=0){
                                        tiaojian = '<option value="3">三部门</option>';
                                    }else{
                                        tiaojian='';
                                    }
                                    $('.sousuo').append('<tr><td>'+mes.name+'</td><td>'+mes.phone+'</td><td>'+mes.zuoqujian+'</td><td>'+mes.youqujian+'</td><td>'+mes.sanqujian+'</td><td class="click">'+tianjia+'</td><td><select style="min-width: 65px" name="chakan"><option >选择查看</option><option value="1">一部门</option><option value="2">二部门</option>'+tiaojian+'<select><input type="hidden" name="id" value="'+fid+'"></td></tr>\
                                        ');
                            }
                        }
                    })
                }else{
                    alert('请输入要查找的人员姓名');
                }
            })
            })
        </script>
        <table class="table table-bordered nihaoya">
            <caption>会员信息</caption>
            <tr>
                <th>姓名</th>
                <th>电话</th>
                <th>一部门</th>
                <th>二部门</th>
                <th>三部门</th>
                <!-- <th>所在大部</th> -->
                <th>添加会员</th>
                <th>查看</th>
            </tr>
            <tbody class="sousuo">
            @foreach($res as $v)

            <tr>
                <td>{{$v['name']}}</td>
                <td>{{$v['phone']}}</td>
                <td>{{$v['zuoqujian']}}</td>
                <td>{{$v['youqujian']}}</td>
                <td>{{$v['sanqujian']}}</td>
                <td class="click">@if(($v['zuojiedian']=='' || $v['youjiedian']=='')||(($v['zuoqujian']>=375) && ($v['youqujian']>=375) && $v['sanjiedian']==''))<a  style="color:green;cursor:pointer">添加<input type="hidden" name="fid" value="{{$v['id']}}"></a>@else两侧已满@endif</td>
                <td><select style="min-width: 65px" name="chakan">
                        <option >选择查看</option>
                        <option value='1'>一部门</option>
                        <option value='2'>二部门</option>
                        @if($v['sanqujian']!=0)
                        <option value='3'>三部门</option>
                        @endif
                    </select>
                    <input type="hidden" name="id" value="{{$v['id']}}">
                </td>
            </tr>
            @endforeach
            </tbody>

        </table>
        <div class="fenye">
            {!! $res->render() !!}
        </div>
    </div>

</div>

<div class="footer">
    <p class="p1">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
</div>
<script type="text/javascript">
        $(function(){
            var length = $('.pagination li').length-2;
            var lengths = length+1;
            $('.pagination li:eq(0) span').html('上一页');
            $('.pagination li:eq(0) a').html('上一页');
                $('.pagination li:eq('+lengths+') span').html('下一页');
                $('.pagination li:eq('+lengths+') a').html('下一页');
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

    //点击按钮进行跳转
    $(function(){
        $('.click a').live('click',function(){
            var fid = $(this).find('input').val();
            // 进行网页的跳转
            location.href="/members/addcustomer/"+fid;
        })
        //点击根据部门来查看他的下属会员人员
        $('.sousuo').find('select[name=chakan]').live('change',function(){
            //获取选择查看的部门的值
            var oid = $(this).val();
            //获取选择查看的这个人的ID
            var id = $(this).next('input[name=id]').val();
            var _token = $('input[name="_token"]').val();
            //发送ajax
            $.ajax({
                url:'/members/qujian',
                data:{'oid':oid,'id':id,'_token':_token},
                type:"post",
                dataType:'json',
                success:function(mes){
                   //将数据加载到当前页面
                   if(mes==1){
                    alert('没有查询结果');
                   }else{
                    $('.sousuo').empty();
                    //隐藏分页效果
                    $('.pagination').remove();
                    $.each(mes,function(key,val){
                        var tianjia = '';
                        var tiaojian = '';
                        var fid = val.id;
if((val.zuojiedian==0 || val.youjiedian==0)||((val.zuoqujian>=375) && (val.youqujian>=375) && val.sanjiedian==0)){
tianjia = '<a style="color:green;">添加<input type="hidden" name="fid" value='+val.id+'></a>';
                        }else{
                            tianjia ='两侧已满';
                        }

                        if(val.sanqujian!=0){
                            tiaojian = '<option value="3">三部门</option>';
                        }else{
                            tiaojian='';
                        }
                    $('.sousuo').append('<tr><td>'+val.name+'</td><td>'+val.phone+'</td><td>'+val.zuoqujian+'</td><td>'+val.youqujian+'</td><td>'+val.sanqujian+'</td><td class="click">'+tianjia+'</td><td><select style="min-width: 65px" name="chakan"><option >选择查看</option><option value="1">一部门</option><option value="2">二部门</option>'+tiaojian+'<select><input type="hidden" name="id" value="'+fid+'"></td></tr>\
                                    ');
                    })
                   }
                }
            })
            
        })
    })

</script>




</body>
</html>