<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */
//监听sql语句
// Event::listen('illuminate.query',function($query){
// 	var_dump($query);
// });
// 前台缺少中间件
Route::controller('/login','LoginController');	//登录
Route::controller('/register','RegisterController');	//注册
//微信回调路径
Route::controller('/order','HuiUrlController');

Route::group(['middleware' => 'homelogin'], function () {

	Route::controller('/members','members\MembersController');	//用户
	Route::get('/','members\MembersController@getIndex');  //前台首页
	
});


Route::get('/error', function () {
	return view('errors.503');
});

//加载后台的登录页面
Route::get('/admin/login', function () {
	return view('adminlogin.login');
});

//后台的登录、退出
Route::get('/admin/login/in', 'AdminloginController@in');
Route::get('/admin/login/out', 'AdminloginController@out');


//进行路由的认证只能从唯一入口进入
Route::group(['middleware' => 'login'], function () {
	//后台首页
	Route::get('/admin/index', function () {
		return view('adminindex.index');
	});
	//后台的管理员模块
	Route::controller('/admin/user','AdminUserController');
	//后台的模块的权限
	Route::controller('/admin/mokuai','AdminMokuaiController');
	//后台会员模块
	Route::controller('/admin/tuihuiyuan','TuihuiyuanController');
	//后台操作记录模块
	Route::controller('/admin/caozuo','AdminJiluController');
	//后台积分模块
	Route::controller('/admin/jifen','AdminJifenController');
	//后台会员购买返还积分设置
	Route::controller('/admin/gjifen','AdminGjifenController');
	//后台会员返利要求设置
	Route::controller('/admin/fanli','AdminFanliController');
	//每天的用户的返利查看  目的是检测每日的返利花费
	Route::controller('/admin/fanlichakan','AdminFanlichakanController');
	//后台积分兑换比例设置
	Route::controller('/admin/duihuan','AdminDuihuanController');
	Route::controller('/admin/tixian','AdminTixianController');
	//后台的费用的总的计算控制器
	Route::controller('/admin/feiyong','AdminFeiyongController');

});
	Route::controller('/admin/dingshi','FanliController');