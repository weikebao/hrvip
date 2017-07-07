<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>
<html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>
<html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en"><!--<![endif]-->
<head>
    <meta charset="utf-8">

    <!-- Viewport Metatag -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <!-- Plugin Stylesheets first to ease overrides -->
    <link rel="stylesheet" type="text/css" href="/admins/plugins/colorpicker/colorpicker.css" media="screen">

    <!-- Required Stylesheets -->
    <link rel="stylesheet" type="text/css" href="/admins/bootstrap/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/admins/css/fonts/ptsans/stylesheet.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/admins/css/fonts/icomoon/style.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/admins/css/my.css" media="screen">

    <link rel="stylesheet" type="text/css" href="/admins/css/mws-style.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/admins/css/icons/icol16.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/admins/css/icons/icol32.css" media="screen">

    <!-- Demo Stylesheet -->
    <link rel="stylesheet" type="text/css" href="/admins/css/demo.css" media="screen">

    <!-- jQuery-UI Stylesheet -->
    <link rel="stylesheet" type="text/css" href="/admins/jui/css/jquery.ui.all.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/admins/jui/jquery-ui.custom.css" media="screen">

    <!-- Theme Stylesheet -->
    <link rel="stylesheet" type="text/css" href="/admins/css/mws-theme.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/admins/css/themer.css" media="screen">
    <!-- <link rel="stylesheet" type="text/css" href="/admins/css/my.css" media="screen"> -->
    <!-- <script src="/js/jquery-1.8.3.min.js"></script> -->


<script src="/admins/js/libs/jquery-1.8.3.min.js"></script>
<script src="/admins/js/libs/jquery.mousewheel.min.js"></script>
<script src="/admins/js/libs/jquery.placeholder.min.js"></script>
<script src="/admins/custom-plugins/fileinput.js"></script>
<script language="javascript" type="text/javascript" src="/admins/My97DatePicker/WdatePicker.js"></script>

<!-- jQuery-UI Dependent Scripts -->
<script src="/admins/jui/js/jquery-ui-1.9.2.min.js"></script>
<script src="/admins/jui/jquery-ui.custom.min.js"></script>
<script src="/admins/jui/js/jquery.ui.touch-punch.js"></script>
<script src="/admins/jui/js/timepicker/jquery-ui-timepicker.min.js"></script>
<!-- Plugin Scripts -->
<script src="/admins/plugins/colorpicker/colorpicker-min.js"></script>
<script src="/admins/plugins/validate/jquery.validate-min.js"></script>
 <script src="/admins/plugins/imgareaselect/jquery.imgareaselect.min.js"></script>
<script src="/admins/plugins/jgrowl/jquery.jgrowl-min.js"></script>


<!-- Core Script -->
<script src="/admins/bootstrap/js/bootstrap.min.js"></script>
<script src="/admins/js/core/mws.js"></script>

<!-- Themer Script (Remove if not needed) -->
<script src="/admins/js/core/themer.js"></script>
<script src="/admins/js/demo/demo.widget.js"></script>

<!-- Demo Scripts (remove if not needed) -->
    <title>红日后台管理系统</title>

</head>

<body>

<!-- Themer (Remove if not needed) -->
<div id="mws-themer">
    <div id="mws-themer-content">
        <div id="mws-themer-ribbon"></div>
        <div id="mws-themer-toggle">
            <i class="icon-bended-arrow-left"></i>
            <i class="icon-bended-arrow-right"></i>
        </div>
        <div id="mws-theme-presets-container" class="mws-themer-section">
            <label for="mws-theme-presets">Color Presets</label>
        </div>
        <div class="mws-themer-separator"></div>
        <div id="mws-theme-pattern-container" class="mws-themer-section">
            <label for="mws-theme-patterns">Background</label>
        </div>
        <div class="mws-themer-separator"></div>
        <div class="mws-themer-section">
            <ul>
                <li class="clearfix"><span>Base Color</span>
                    <div id="mws-base-cp" class="mws-cp-trigger"></div>
                </li>
                <li class="clearfix"><span>Highlight Color</span>
                    <div id="mws-highlight-cp" class="mws-cp-trigger"></div>
                </li>
                <li class="clearfix"><span>Text Color</span>
                    <div id="mws-text-cp" class="mws-cp-trigger"></div>
                </li>
                <li class="clearfix"><span>Text Glow Color</span>
                    <div id="mws-textglow-cp" class="mws-cp-trigger"></div>
                </li>
                <li class="clearfix"><span>Text Glow Opacity</span>
                    <div id="mws-textglow-op"></div>
                </li>
            </ul>
        </div>
        <div class="mws-themer-separator"></div>
        <div class="mws-themer-section">
            <button class="btn btn-danger small" id="mws-themer-getcss">Get CSS</button>
        </div>
    </div>
    <div id="mws-themer-css-dialog">
        <form class="mws-form">
            <div class="mws-form-row">
                <div class="mws-form-item">
                    <textarea cols="auto" rows="auto" readonly="readonly"></textarea>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Themer End -->

<!-- Header -->
<div id="mws-header" class="clearfix">

    <!-- Logo Container -->
    <div id="mws-logo-container">

        <!-- Logo Wrapper, images put within this wrapper will always be vertically centered -->
        <div id="mws-logo-wrap">
            <img src="/admins/images/mws-logo.png" alt="mws admin">
        </div>
    </div>

    <!-- User Tools (notifications, logout, profile, change password) -->
    <div id="mws-user-tools" class="clearfix">

        <div id="mws-user-message" class="mws-dropdown-menu"

        >
            <a href="#" data-toggle="dropdown" class="mws-dropdown-trigger">
                <i class="icon-envelope"></i></a>

            <!-- Unred messages count -->
            <span class="mws-dropdown-notif aaa"></span>

            <!-- Messages dropdown -->
            <div class="mws-dropdown-box"

            >
                <div class="mws-dropdown-content">
                    <ul class="mws-messages aaaaaa">
                    </ul>
                </div>
            </div>
        </div>
        <!-- User Information and functions section -->
        <div id="mws-user-info" class="mws-inset">

            <!-- User Photo -->
            <div id="mws-user-photo">
                <img src="/admins/example/profile.jpg" alt="User Photo">
            </div>

            <!-- Username and Functions -->
            <div id="mws-user-functions">
                <div id="mws-username">
                    欢迎您：&nbsp;&nbsp;{{session('user')['name']}}
                </div>
                <ul>
                    <li><a href="/admin/login/out">退出登录</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Start Main Wrapper -->
<div id="mws-wrapper">

    <!-- Necessary markup, do not remove -->
    <div id="mws-sidebar-stitch"></div>
    <div id="mws-sidebar-bg"></div>

    <!-- Sidebar Wrapper -->
    <div id="mws-sidebar">

        <!-- Hidden Nav Collapse Button -->
        <div id="mws-nav-collapse">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <script type="text/javascript">
            $(function(){
                //发送ajax 来显示此人登录的会员模块
                $.ajax({
                    url:'/admin/mokuai',
                    dataType:'json',    
                    success:function(mes)
                    {
                        console.log(mes);
                        if(mes)
                        {
                            $.each(mes,function(key,val){
                                //判断登录人所拥有的的权限
                               if(val.mid=="1")
                               {
                                $('.a1').css('display','block')
                               }else if(val.mid=="2")
                               {
                                $('.a2').css('display','block')
                               }else if(val.mid=="3")
                                {
                                $('.a3').css('display','block')
                                }else if(val.mid=="4")
                               {
                                $('.a4').css('display','block')
                               }else if(val.mid=="5")
                               {
                                $('.a5').css('display','block')
                               }else if(val.mid=="6")
                               {
                                $('.a6').css('display','block')
                               }else if(val.mid=="7")
                               {
                                $('.a7').css('display','block')
                               }else if(val.mid=="8")
                               {
                                $('.a8').css('display','block')
                               }else if(val.mid=="9")
                               {
                                $('.a9').css('display','block')
                               }
                            })
                        }
                    }
                })
            })
        </script>
        <!-- 左侧列表的功能模块 -->
        <div id="mws-navigation">
                <ul>
                    <li class="active a1" style="display:none;" >
                        <a href="#"><i class="icon-home"></i> 管理员模块</a>
                        <ul style="display: none;" class="closed">
                            <li><a href="/admin/user/index">管理员列表</a></li>
                            <li><a href="/admin/user/add">添加管理员</a></li>
                            <li><a href="/admin/user/quanxian">管理权限添加</a></li>
                            <li><a href="/admin/tixian/yaoqiu"> 提现要求</a></li>
                        </ul>
                    </li>
 
                    <li class="active a2" style="display:none;" >
                        <a href="#"><i class="icon-home"></i> 会员管理</a>
                        <ul style="display: none;" class="closed">
                            <li><a href="/admin/tuihuiyuan/jidian">会员基点添加</a></li>
                            <li><a href="/admin/tuihuiyuan/index">会员列表</a></li>
                            <li><a href="/admin/tuihuiyuan/chongname">会员名重复列表</a></li>
                            <!-- <li><a href="/admin/tuihuiyuan/dellist">会员划落列表</a></li> -->
                        </ul>
                    </li> 
                    <li class="active a3" style="display:none;" >
                        <a href="#"><i class="icon-home"></i>积分管理</a>
                        <ul style="display: none;" class="closed">
                            <li><a href="/admin/jifen/index"> 会员积分管理查询</a>
                            </li>
                        </ul>
                    </li>
                    <li class="active a4" style="display:none;" >
                        <a href="#"><i class="icon-home"></i>返还积分设置</a>
                        <ul style="display: none;" class="closed">
                            <li><a href="/admin/gjifen/index"> 会员积分返还列表</a>
                            </li>
                            <li><a href="/admin/gjifen/add"> 添加会员积分返还设置</a>
                            </li>
                        </ul>
                    </li>
                    <li class="active a5" style="display:none;" >
                        <a href="#"><i class="icon-home"></i>积分兑换比例管理</a>
                        <ul style="display: none;" class="closed">
                            <li><a href="/admin/duihuan/index"> 积分兑换比例列表</a>
                            </li>
                            <li><a href="/admin/duihuan/add"> 积分兑换比例设置</a>
                            </li>
                        </ul>
                    </li>
                    <li class="active a6" style="display:none;" >
                        <a href="#"><i class="icon-home"></i>返利管理</a>
                        <ul style="display: none;" class="closed">
                            <li><a href="/admin/fanli/index"> 每日返利设置</a>
                            </li>
                            <li><a href="/admin/fanli/add"> 每日返利设置添加</a>
                            </li> 
                        </ul>
                    </li>
                    <li class="active a7" style="display:none;" >
                        <a href="#"><i class="icon-home"></i>提现管理</a>
                        <ul style="display: none;" class="closed">
                            <li><a href="/admin/tixian/index"> 提现列表</a></li>
                            <li><a href="/admin/tixian/index1">已审批提现</a></li>
                            <li><a href="/admin/tixian/index2">未通过提现</a></li>
                             
                        </ul>
                    </li>
                    <li class="active a8" style="display:none;" >
                        <a href="#"><i class="icon-home"></i>每日返利查看</a>
                        <ul style="display: none;" class="closed">
                            <li><a href="/admin/fanlichakan/index"> 返利会员列表</a>
                            </li>
                        </ul>
                    </li>
                    <li class="active a9" style="display:none;" >
                        <a href="#"><i class="icon-home"></i>费用查看</a>
                        <ul style="display: none;" class="closed">
                            <li><a href="/admin/feiyong/index"> 返利费用合计表</a>
                            <li><a href="/admin/feiyong/fen"> 返利费用分算表</a>
                            <li><a href="/admin/feiyong/wuindex"> 物品售出回收表</a>
                            <li><a href="/admin/feiyong/zongji"> 日常总费用表</a>
                            <li><a href="/admin/feiyong/xiangxi"> 个人流水查询</a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li>
                        <a href="/admin/caozuo/index"><i class="icon-home"></i> 操作记录查询</a>
                    </li>   -->                
            </ul>
        </div>
    </div>
    <!-- 这里是页面的主体部分 -->
    <div id="mws-container" class="clearfix">
        <div class="container">
            @if (count($errors) > 0)
                <div class="mws-form-message error">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @if(session('success'))
                <div class="mws-form-message success">
                    {{session('success')}}
                </div>
            @endif

            @if(session('error'))
                <div class="mws-form-message error">
                    {{session('error')}}
                </div>
            @endif
            @section('con')
            @show
        </div>
        <div id="mws-footer">
            红日后台管理系统
        </div>

    </div>


</div>


</body>
</html>
