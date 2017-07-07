<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>心禧爱</title>
		<link rel="stylesheet" type="text/css" href="/qiantai/css/style.css"/>
	</head>
	<script src="/qiantai/js/jquery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/qiantai/js/jquery.easing.js" type="text/javascript" charset="utf-8"></script>
	<script src="/qiantai/js/index.js" type="text/javascript" charset="utf-8"></script>
	
	<body id="index">
		<!--头部-->
		<div id="nav" class="clear">
			<div class="logo">
				<img src="/qiantai/images/logo.png"/>
			</div>
			<ul id="list" class="clear">
				<li class="list_1 list_xt"><a href="/">首页</a></li>
				<li class="list_2 list_xt">
					<a href="/fenlei">分类</a>
					<ul id="list2" style="overflow: none;" class="clear">
					@foreach($res as $v)
						<li class="list2_1 xt1">
							<a class="xt" href="#">{{$v['cname']}}</a>
							<ul class="list3 list3_1">
								<li class="list_details">
									@if($v['pin']==1)
									<a class="details_xt details_1" href="">品牌</a>
									<ul class="clear list_details_brand">
								 @foreach($res1 as $vv)
                                    @foreach(explode(',',$vv['cid']) as $av)
                                    @if($av==$v['cid'])
                                    <li><a href="">{{$vv['pname']}}</a></li>
                                    @endif
                                    @endforeach
                                @endforeach
									</ul>
									@endif
								</li>
								<li class="list_details">
									@if($v['kuan']==1)
									<a class="details_xt details_1" href="">杯型款式</a>
									<ul class="clear list_details_brand">
									@foreach($res2 as $vv)
									@if($vv['cid']==$v['cid'])
										<li><a href="">{{$vv['kname']}}</a></li>
									@endif
									@endforeach
									</ul>
									@endif
								</li>
								<li class="list_details">
									@if($v['hou']==1)
									<a class="details_xt details_1" href="">厚度</a>
									<ul class="clear list_details_brand">
									@foreach($res3 as $vv)
									@if($vv['cid']==$v['cid'])
										<li><a href="">{{$vv['hname']}}</a></li>
									@endif
									@endforeach
									</ul>
									@endif
								</li>
								<li class="list_details">
									@if($v['cai']==1)
									<a class="details_xt details_1" href="">罩杯材质</a>
									<ul class="clear list_details_brand">
									@foreach($res4 as $vv)
									@if($vv['cid']==$v['cid'])
										<li><a href="">{{$vv['czname']}}</a></li>
									@endif
									@endforeach
									</ul>
									@endif
								</li>
							</ul>
						</li>
					@endforeach
					</ul>
				</li>
				<li class="list_3 list_xt"><a href="/meilimima">美丽密码</a></li>
				<li class="list_4 list_xt"><a href="/huiyuan">会员中心</a></li>
				<li class="list_5 list_xt"><a href="/sidai">粉红丝带</a></li>
				<li class="list_6 list_xt"><a href="/women">关于我们</a></li>
			</ul>
			<div id="right">
				<a href="#">购物车</a>
				<a href="#">官方微信</a>
			</div>
		</div>

@section('con')
@show
