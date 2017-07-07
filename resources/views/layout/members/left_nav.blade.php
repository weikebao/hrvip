<style type="text/css">
    /*.navgation{margin:0;padding:0;list-style-type:none;position:relative;}*/
    /*.navgation a{text-decoration:none;}*/
    /*.navgation a:hover {background-color:white;color:blue;text-decoration:underline;}*/
    .navgation{display:none;}
    .navgating{display: none;}
    .navgatied{display: none;}
    .navgat{display: none;}
    .navgaty{display: none;}
    .navgaty,.navgation,.navgating,.navgatied,.navgat,.canme,.canher,.canhis,.canyou{cursor: pointer;}
    /*.navgation ul li{list-style-type: none;}*/
</style>
<div class="m_left">
    <ul class="nav2">
        <li class="list"><a href="/members/dir">目录</a></li>
        <li class="list"><a href="/members/customer">客户</a></li>
        <li class="list"><a href="/members/changecustomer">分配客户</a></li>
        <li class="list">
            <a class="canjiu" style="cursor:pointer">充值</a>
            <div><a class="navgaty" href="/members/chongzhi">充值</a></div>
            <div><a class="navgaty" href="/members/chongzhijilu">充值记录</a></div>
        </li>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".canjiu").each(function () {
                    var the_div = $(".navgaty");
                    // var _inx = $(".canjiu").index(this);
                    $(this).click(
                            function () { the_div.slideToggle(); },
                            function () { the_div.slideToggle(); }
                    );
                });
            });
        </script>
        <li class="list"><a href="/members/duihuan">兑换</a></li>
        <li class="list">
            <a class="canher">交易记录</a>
            <div><a class="navgat" href="/members/goumaijilu">购买记录</a></div>
            <div><a class="navgat" href="/members/fanlijilu">返利记录</a></div>
        </li>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".canher").each(function () {
                    var this_div = $(".navgat");
                    var _inx = $(".canher").index(this);
                    $(this).click(
                            function () { this_div.slideToggle(); },
                            function () { this_div.slideToggle(); }
                    );
                });
            });
        </script>
        <li class="list">
            <a class="canme">转账</a>
            <div><a class="navgating" href="/members/zhuanzhang">转账</a></div>
            <div><a class="navgating" href="/members/zhuanzhangjilu">转账记录</a></div>
        </li>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".canme").each(function () {
                    var this_div = $(".navgating");
                    var _inx = $(".canme").index(this);
                    $(this).click(
                            function () { this_div.slideToggle(); },
                            function () { this_div.slideToggle(); }
                    );
                });
            });
        </script>
        <li class="list">
                    <a class="canyou">提款</a>
                    <div><a class="navgation" href="/members/cash" >提款</a></div>
                    <div><a class="navgation" href="/members/tikuanjilu" >提款记录</a></div>
        </li>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".canyou").each(function () {
                    var this_div = $(".navgation");
                    var _inx = $(".canyou").index(this);
                    $(this).click(
                            function () { this_div.slideToggle(); },
                            function () { this_div.slideToggle(); }
                    );
                });
            });
        </script>
        <!-- <li class="list"><a href="/members/pointmove">积分</a></li> -->

        <!-- <li class="list"><a href="/members/accountflow">账目流水</a></li> -->
        <!--  <li class="list"><a href="javascript:;">投资</a></li>
         <li class="list"><a href="javascript:;">个人文档</a></li> -->
        {{--<li class="list"><a href="/members/info">个人资料</a></li>--}}
        <li class="list">
            <a class="canhis">个人资料</a>
           <!-- <div><a class="navgatied" href="/members/bindcard">完善账户信息</a></div>-->
            <div><a class="navgatied" href="/members/changecard">账户信息</a></div>
            <div><a class="navgatied" href="/members/changepass">更改密码</a></div>
        </li>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".canhis").each(function () {
                    var this_div = $(".navgatied");
                    var _inx = $(".canhis").index(this);
                    $(this).click(
                            function () { this_div.slideToggle(); },
                            function () { this_div.slideToggle(); }
                    );
                });
            });
        </script>
        {{--<li class="list"><a href="/members/changecard">更换银行卡</a></li>--}}
        {{--<li class="list"><a href="/members/changepass">更改密码</a></li>--}}



    </ul>
</div>
