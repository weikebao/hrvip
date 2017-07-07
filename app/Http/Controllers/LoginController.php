<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB,Validator,Input;

class LoginController extends Controller
{
    public function getIndex(){	//加载用户登录界面
    	return view('home.login');
    }
    public function postIndex(Request $request){	//执行用户的登录
    	$data=$request->except('_token');
    	$rules = ['captcha' => 'required|captcha'];
		$validator = Validator::make(['captcha'=>$data['captcha']], $rules);
		if($validator->fails()){
		    // return back()->with('error','请输入正确的验证码');
		    return '请输入正确的验证码';
		}
		if($res=DB::table('vip_huiyuan')->where('phone',$data['name'])->first()){
			if($res['pass']==md5($data['pass'])){
				//判断这个人是否被划落了一段时间 如果被划落了就进行激活 否则继续
				DB::table('vip_huiyuan')->where('id',$res['id'])->update(['s'=>1]);
				// return redirect('/');
				session(['hr_member'=>$res]);
				//将session值写在文本当中
				$res = json_encode($res);
				file_put_contents(session('hr_member')['id'].'.txt',$res);
				return 'do';
			}else{
				// return back()->with('error','请输入正确的密码');
				return '请输入正确的密码';
			}
		}else{
			// return back()->with('error','请输入正确的用户名');
			return '请输入正确的用户名';
		}

    }
    public function getCaptcha(){   //获取验证码;
    	return captcha();
    }
    //用户的退出功能
    public function getOut()
    {
    	
    	//删除这个人的所有文件
    	// unlink(session('hr_member')['id'].'.txt');
    	session()->forget('hr_member');
        return redirect('/login');
    }
}
