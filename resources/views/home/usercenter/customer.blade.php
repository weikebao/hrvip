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
<style>
    @font-face {
          font-family: 'iconfont';
          src: url('/shop/font-face/iconfont.eot');
          src: url('/shop/font-face/iconfont.eot?#iefix') format('embedded-opentype'),
          url('/shop/font-face/iconfont.woff') format('woff'),
          url('/shop/font-face/iconfont.ttf') format('truetype'),
          url('/shop/font-face/iconfont.svg#iconfont') format('svg');
    }
    .iconfont{
          font-family:"iconfont" !important;
          font-size:16px;font-style:normal;
          -webkit-font-smoothing: antialiased;
          -webkit-text-stroke-width: 0.2px;
          -moz-osx-font-smoothing: grayscale;
          cursor: pointer;
    }
</style>
<body id="mulu">
@include('layout.members.nav')
<div class="banner"></div>
<div class="main clear">
    <div class="title">
        欢迎进入北京新纪元红日会员<span>客户</span>页面
    </div>
    <h1 class="tit_01">会员中心</h1>
    @include('layout.members.left_nav')
    <div class="m_right">
        <div class="con2">
            <form class="top_box">
                搜索:&nbsp;
                <select>
                    <option>- - -   销售情况   - - -</option>
                </select>


                <input id="keyword" name="keyword"  class="inputstyle keywords" placeholder="请输入要查找的人员手机号" value=""><button type="button" ></button>
            </form>
            <fieldset class="layui-elem-field layui-field-title" >
                <legend >
                    <h1>点击姓名即可查询客户</h1>
                </legend>
            </fieldset>
            {{CSRF_FIELD()}}
            <div class="content_1">
            <i class="iconfont jiahao">&#xe677;</i>
                    <span class="chaxun"><span class="username">{{session('hr_member')['name']}}</span>
                            <input type="hidden" name="id" value="{{session('hr_member')['id']}}"></span>
            <i class="iconfont jianhao">&#xe678;</i>
                            <ul class="container">
                            </ul>
                            <script type="text/javascript">
                            //点击查询相应的人员
                            $('#keyword').next('button').click(function(){
                               //获取用户的姓名
                               var name= $(this).prev('input[name=keyword]').val();
                               //判断手机号是否正确
                               if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(name))){ 
                                    alert('手机号码格式不正确');
                                  }else{
                                //发送ajax查询是否存在
                                $.ajax({
                                    url:'/members/xinxi',
                                    data:{'name':name},
                                    type:'get',
                                    dataType:'json',
                                    success:function(mes)
                                    {
                                        if(mes==2){
                                            alert('查询人员不存在');
                                        }else{
                                           $('.biaoge').css('display','block');
                                            $('.tishi').empty();
                                            var a = '';
                                            if(mes.xiaofei==1)
                                            {
                                                a = '已消费';
                                            }else{
                                                a = '未消费';
                                            }
                                            $('.tishi').append('<td>'+mes.name+'</td><td>'+mes.phone+'</td><td>'+a+'</td><td><a href="javascript:;" class="btn02">代替支付</a><input type="hidden" name="id" value="'+mes.id+'"></td>\
                                                ') 
                                        }
                                    }
                                })
                               }
                            })
                                $('.jianhao').click(function(){
                                    $(this).next('ul').empty();
                                })
                                //点击加号进行ajax查询
                                $('.jiahao').live('click',function(){
                                //获取他的id值
                                var  id = $(this).next('span').find('input[name=id]').val();
                                $.ajax({
                                    url:'/members/lunxun',
                                    data:{'id':id},
                                    type:'get',
                                    dataType:'json',
                                    success:function(mes){
                                        //将得到的结果显示在页面中
                                             $('.container').empty();
                                            $.each(mes,function(key,val){
                                            	var a = '';
                                            	//判断这个人是否具有下属 有的话显示+-符号
                                            	if((val.zuojiedian==""&& val.youjiedian=="")||(val.zuojiedian==0&&val.youjiedian==0)){
                                            		a = '<span class="username">'+val.name+'</span><input type="hidden" name="id" value="'+val.id+'">';
                                            	}else{
                                            		a = '<i class="iconfont jia">&#xe677;</i><span class="username">'+val.name+'</span><input type="hidden" name="id" value="'+val.id+'"><i class="iconfont jian">&#xe678;</i>';
                                            	}
                                             $('.container').append('<li class="liveid">'+a+'</li>\
                                            ')   
                                            })
                                        }
                                    })
                                })
                                $(function(){
                                    $(document).on("click", ".jia", function(){ 
                                    // $('.liveid').live('click',function(){

                                        //获取他的id值
                                        var _this = $(this);//加号的位置
                                        var  id = _this.next('span').next('input[name=id]').val();
                                        $.ajax({
                                            url:'/members/lunxun',
                                            data:{'id':id},
                                            type:'get',
                                            dataType:'json',
                                            success:function(mes){

                                                //将得到的结果显示在页面中
                                                _this.parent('li').find('ul').remove();
                                                _this.parent('li').append('<ul style="margin-left:30px;"></ul>\
                                                    ');
                                                    $.each(mes,function(key,val){
                                                    	var a = '';
                                            	//判断这个人是否具有下属 有的话显示+-符号
		                                            	if((val.zuojiedian==""&& val.youjiedian=="")||(val.zuojiedian==0&&val.youjiedian==0)){
		                                            		a = '<span class="username">'+val.name+'</span><input type="hidden" name="id" value="'+val.id+'">';
		                                            	}else{
		                                            		a = '<i class="iconfont jia">&#xe677;</i><span class="username">'+val.name+'</span><input type="hidden" name="id" value="'+val.id+'"><i class="iconfont jian">&#xe678;</i>';
		                                            	}
                                                     _this.parent('li').find('ul').append('<li class="liveid">'+a+'</li>\
                                                    ')   
                                                    })
                                                }
                                            })
                                        return false;
                                    });
                                    $(document).on("click", ".jian", function(){ 
                                        //点击减进行相应的标签去除
                                        var _this = $(this);
                                        _this.parent('li').find('ul').remove();
                                    });
                                    //根据点击的人的不同来获取这个人的id查询他的购买信息,来决定是否代替够买
                                    $('.username').live('click',function(){
                                        var id = $(this).next('input[name=id]').val();
                                        // 发送ajax查询这个人的详细信息
                                        $.ajax({
                                            url:'/members/geren',
                                            data:{'id':id},
                                            type:'get',
                                            dataType:'json',
                                            success:function(mes)
                                            {
                                                //将数据显示在页面当中
                                            $('.biaoge').css('display','block');
                                            $('.tishi').empty();
                                            var a = '';
                                            if(mes.xiaofei==1)
                                            {
                                                a = '已消费';
                                            }else{
                                                a = '未消费';
                                            }
                                            $('.tishi').append('<td>'+mes.name+'</td><td>'+mes.phone+'</td><td>'+a+'</td><td><a href="javascript:;" class="btn02">代替支付</a><input type="hidden" name="id" value="'+mes.id+'"></td>\
                                                ')
                                            }
                                        })
                                    })
                                    $('.btn02').live('click',function(){
                                         if(confirm('确定付款?')){
                                            //点击代替支付按钮,获取用户的id以及本人的id
                                            var otherid = $(this).next('input[name=id]').val();
                                            //发送ajax将本人代替选择的用户进行相应的代替支付
                                            $.ajax({
                                                url:'/members/tipay',
                                                data:{'otherid':otherid,'_token':$('input[name="_token"]').val()},
                                                type:'post',
                                                dataType:'json',
                                                success:function(mes)
                                                {
                                                    console.log(mes);
                                                    if(mes==1)
                                                    {
                                                        alert('代替支付成功')
                                                        //关闭支付页面
                                                        $('.biaoge').css('display','none');
                                                    }else if(mes==2){
                                                        alert('太阳币不足');
                                                    }else{
                                                        alert('支付失败');
                                                    }
                                                }
                                            })
                                        }else{
                                            $(".biaoge").hide();
                                        }
                                    })
                                })
                            </script>
            </div>
            
            <div class="biaoge">
            <button class="btn_quxiao">x</button>
                <table>
                    <tr>
                        <th>姓名</th>
                        <th>电话</th>
                        <th>本月消费情况</th>
                        <th>功能</th>
                    </tr>
                    <tr class="tishi">
                       <!--  <td>张三123</td>
                        <td>13845687544</td>
                        <td>07-05-01</td>
                        <td><a href="javascript:;" class="btn02">代替支付</a></td> -->
                    </tr>
                </table>
            </div>
            <script type="text/javascript">
                $(".btn_quxiao").click(function(){
                    $(".biaoge").hide();
                })
            </script>
        </div>
    </div>

</div>

<div class="footer">
    <p class="p1">© 2017 新纪元红日生物科技 版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备17030171号 </p>
</div>

<script src="/shop/js/members_nav_botton_style.js"></script>
</body>
</html>