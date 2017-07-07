<?php

namespace App\Http\Middleware;

use Closure;

class HomeLoginMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		//进行登录的检测  session值
		if (session('hr_member')['id'] ){
			//成功向下传递数据
			//文件名称
			$filename = session('hr_member')['id'].'.txt';
			//获取用户操作的路径
			$pathurl = $_SERVER['REQUEST_URI'];
			//将路径存在session中
			session(['url'=>$pathurl]);
			return $next($request);
		} else {
			//没有登录的返回到登录页面
			return redirect('/login');
		}
	}
}
