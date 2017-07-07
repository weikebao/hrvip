<style>
.gationnav{display:none;}
.gatingnav{display: none;}
.gatiednav{display: none;}
.gatynav{display: none;}
.gatnav{display: none;}
.gatynav,.gationnav,.gatingnav,.gatiednav,.gatnav,.mecan,.hercan,.hiscan,.youcan{cursor: pointer;}
</style>
<div class="header clear">
    <div class="logo"><a href="javascript:;"><img src="/shop/images/huiyuan_03.jpg"></a></div>
    <ul class="nav clear">
        {{--前两个是新加的--}}
        <!-- 主页说的是官网 -->
        <li class="list"><a href="http://xinjiyuanhr.com"  target="_blank">主页</a></li>
        <!-- 产品与项目说的是 -->
        <li class="list"><a href="http://shop.xinjiyuanhr.com" target="_blank">产品与项目</a></li>
        <li class="list"><a href="/members/dir">目录</a></li>
        {{--<li class="list"><a href="/members/customer">客户</a></li>--}}
        {{--<li class="list"><a href="/members/pointmove">积分赠送</a></li>--}}
        {{--<li class="list"><a href="/members/cash">提现</a></li>--}}
        {{--<li class="list"><a href="/members/accountflow">账目流水</a></li>--}}
        @if(!session('hr_member')['id'])
        <li class="list"><a href="/login">登录</a></li>
        <li class="list"><a href="/register">注册</a></li>
        @else
        <li class="list"><a href="/login/out">退出</a></li>
        @endif
        
    </ul>
    <a href="javascript:;" class="nav_btn"><img src="/shop/images/nav_icon.png" /></a>
    <ul class="nav_s">
        <li class="list"><a href="/members/dir">目录</a></li>
        <li class="list"><a href="/members/customer">客户</a></li>
        <li class="list"><a href="/members/changecustomer">分配客户</a></li>
        <li class="list">
            <a class="jiucan">充值</a>
            <li class="list"><a class="gatynav" href="/members/chongzhi">充值</a></li>
            <li class="list"><a class="gatynav" href="/members/chongzhijilu">充值记录</a></li>
        </li>
        <script type="text/javascript">
            $('.jiucan').each(function(){
                $(this).toggle(function(){
                    $('.gatynav').show();
                },function(){
                    $('.gatynav').hide();
                })
            })
        </script>
        <li class="list"><a href="/members/duihuan">兑换</a></li>
        <li class="list">
            <a class="hercan">交易记录</a>
            <li class="list"><a class="gatnav" href="/members/goumaijilu">购买记录</a></li>
            <li class="list"><a class="gatnav" href="/members/fanlijilu">返利记录</a></li>
        </li>
        <script type="text/javascript">
//            $(document).ready(function () {
//                $(".canher").each(function () {
//                    var this_div = $(".navgat");
//                    var _inx = $(".canher").index(this);
//                    $(this).click(
//                            function () { this_div.slideToggle(); },
//                            function () { this_div.slideToggle(); }
//                    );
//                });
//            });
            $('.hercan').each(function(){
                $(this).toggle(function(){
                    $('.gatnav').show();
                },function(){
                    $('.gatnav').hide();
                })
            })
        </script>
        <li class="list">
            <a class="mecan">转账</a>
            <div><a class="gatingnav" href="/members/zhuanzhang">转账</a></div>
            <div><a class="gatingnav" href="/members/zhuanzhangjilu">转账记录</a></div>
        </li>
        <script type="text/javascript">
//            $(document).ready(function () {
//                $(".canme").each(function () {
//                    var this_div = $(".navgating");
//                    var _inx = $(".canme").index(this);
//                    $(this).click(
//                            function () { this_div.slideToggle(); },
//                            function () { this_div.slideToggle(); }
//                    );
//                });
//            });
                $('.mecan').each(function(){
                    $(this).toggle(function(){
                        $('.gatingnav').show();
                    },function(){
                        $('.gatingnav').hide();
                    })
                })
        </script>
        <li class="list">
            <a class="youcan">提款</a>
            <div><a class="gationnav" href="/members/cash" >提款</a></div>
            <div><a class="gationnav" href="/members/tikuanjilu" >提款记录</a></div>
        </li>
        <script type="text/javascript">
//            $(document).ready(function () {
//                $(".canyou").each(function () {
//                    var this_div = $(".navgation");
//                    var _inx = $(".canyou").index(this);
//                    $(this).click(
//                            function () { this_div.slideToggle(); },
//                            function () { this_div.slideToggle(); }
//                    );
//                });
//            });
                $('.youcan').each(function(){
                    $(this).toggle(function(){
                        $('.gationnav').show();
                    },function(){
                        $('.gationnav').hide();
                    })
                })
        </script>
        <li class="list"><a href="/members/pointmove">积分</a></li>

        <!-- <li class="list"><a href="/members/accountflow">账目流水</a></li> -->
        <!--  <li class="list"><a href="javascript:;">投资</a></li>
         <li class="list"><a href="javascript:;">个人文档</a></li> -->
        {{--<li class="list"><a href="/members/info">个人资料</a></li>--}}
        <li class="list">
            <a class="hiscan">个人资料</a>
           <!-- <div><a class="gatiednav" href="/members/bindcard">完善账户信息</a></div>-->
            <div><a class="gatiednav" href="/members/changecard">账户信息</a></div>
            <div><a class="gatiednav" href="/members/changepass">更改密码</a></div>
        </li>
        @if(!session('hr_member')['id'])
        <li class="list"><a href="/login">登录</a></li>
        <li class="list"><a href="/register">注册</a></li>
        @else
        <li class="list"><a href="/login/out">退出</a></li>
        @endif
        <script type="text/javascript">
//            $(document).ready(function () {
//                $(".canhis").each(function () {
//                    var this_div = $(".navgatied");
//                    var _inx = $(".canhis").index(this);
//                    $(this).click(
//                            function () { this_div.slideToggle(); },
//                            function () { this_div.slideToggle(); }
//                    );
//                });
//            });
                    $('.hiscan').each(function(){
                        $(this).toggle(function(){
                            $('.gatiednav').show();
                        },function(){
                            $('.gatiednav').hide();
                        })
                    })
        </script>
        {{--<li class="list"><a href="/members/dir">目录</a></li>--}}
        {{--<li class="list"><a href="/members/customer">客户</a></li>--}}
        {{--<li class="list"><a href="/members/pointmove">积分赠送</a></li>--}}
        {{--<li class="list"><a href="/members/cash">提现</a></li>--}}
        {{--<li class="list"><a href="/members/accountflow">账目流水</a></li>--}}
        {{--<li class="list"><a href="/members/info">个人资料</a></li>--}}
        {{--<li class="list"><a href="/members/bindcard">绑定银行卡</a></li>--}}
        {{--<li class="list"><a href="/members/changecard">更换银行卡</a></li>--}}
        {{--<li class="list ac"><a href="/members/changepass">修改密码</a></li>--}}
        {{--<li class="list"><a href="/members/chongzhi">充值</a></li>--}}
        {{--<li class="list"><a href="/members/zhuanzhang">转账</a></li>--}}
        {{--<li class="list"><a href="/members/duihuan">兑换</a></li>--}}
    </ul>
</div>
