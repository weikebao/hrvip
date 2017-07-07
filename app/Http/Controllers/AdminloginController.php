<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class AdminloginController extends Controller {
	//验证用户登录时的数据
	public function in(Request $request) {
		//判断用户名是否一致
		$res = DB::table('vip_guanli')->where('phone', $request->input('uname'))->first();
		//判断用户名是否可以查询到
		if ($res) {
			//判断密码是否一致
			$res1 = DB::table('vip_guanli')->where('phone', $request->input('uname'))
				->where('pass', $request->input('upwd'))
				->first();
			if ($res1) {
				//存入session
				session(['user' => $res]);
				//密码比对正确重定向到首页
				
				return redirect('/admin/index')->with('success', '登录成功');
			} else {
				return back()->with('error', '登录密码错误');
			}
		} else {
			return back()->with('error', '用户名填写错误');
		}

	}

	//退出后台登录 销毁session
	public function out() {
		//销毁session
		session()->forget('res');
		return redirect('login');
	}
}
