<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class AdminUserController extends Controller {
	//写类保存本页面的操作记录
	public static function jilu($jieguo,$leixing)
	{
		//设置文件的$num为自增的属性
		$data['gid'] = session('user')['name'];
		$data['dongzuo'] = $jieguo;
		$data['time'] = date('Y-m-d H:i:s',time());
		$data['lujing'] = session('url');
		$data['leixing'] = $leixing;
		//将数据插入到数据库
		DB::table('vip_jilu')->insert($data);
	}
	//后台的管理员的控制器
	public function getIndex()
	{
		$res = DB::table('vip_guanli')->get();
		return view('adminuser.index',['res'=>$res]);
	}
	//管理员的添加
	public function getAdd()
	{
		if(session('user')['quanxian']!=2)
		{
			return back()->with('error','您没有权利进行添加操作');
		 }	
		return view('adminuser.add');
	}
	public function getAdds(Request $request)
	{
		//接受数据
		$data['name'] = $request->input('name');
		$data['phone'] = $request->input('phone');
		$data['pass'] = $request->input('pass');
		$res = DB::table('vip_guanli')->insert($data);

		if($res)
		{	
			self::jilu('添加管理员成功','2');
			return redirect('/admin/user/index')->with('success','添加管理员成功');
		}else
		{
			self::jilu('添加管理员失败','2');
			return back()->with('error','添加管理员失败');
		}
	}
	//管理员的修改功能
	public function getEdit($id)
	{
	//将管理的信息加载到修改页面
		if(session('user')['quanxian']!=2)
		{
			return back()->with('error','您没有权利进行修改操作');
		}
		$res = DB::table('vip_guanli')->where('id',$id)->first();
		$mokuai = DB::table('vip_guanli')
				->join('vip_guanli_quanxian','vip_guanli_quanxian.gid','=','vip_guanli.id')
				->join('vip_guanli_mokuai','vip_guanli_mokuai.mid','=','vip_guanli_quanxian.mid')
				->where('vip_guanli.id',$id)
				->get();
		$mokuais = DB::table('vip_guanli_mokuai')->get();
		return view('adminuser.edit',['res'=>$res,'mokuai'=>$mokuai,'mokuais'=>$mokuais]);
	}
	public function getEdits(Request $request)
	{
		//接受数组
		$arr = $request->input('duo');
		if(!$arr)
		{
			return back()->with('error','请选择此人的管理模块');
		}
		$res = DB::table('vip_guanli_quanxian')->where('gid',$request->input('id'))->delete();
		foreach($arr as $v)
		{
			//接受数据
			$data['gid'] = $request->input('id');
			//便利循环插入到数据库
			$data['mid'] = $v;
			$res = DB::table('vip_guanli_quanxian')->insert($data);
			if(!$res)
			{
				self::jilu('修改管理权限失败','4');
				return back()->with('error','修改权限失败');
			}
		}
		self::jilu('修改管理权限成功','4');
		return redirect('/admin/user/index')->with('success','修改权限成功');
	}
	//管理员的权限列表
	public function getQuanxian()
	{
		if(session('user')['quanxian']!=2)
		{
			return back()->with('error','您没有权利进行此项操作');
		 }
		$res = DB::table('vip_guanli_mokuai')->get();
		$name = DB::table('vip_guanli')->where('quanxian','!=','2')->get();
		return view('adminuser.quanxian',['res'=>$res,'name'=>$name]);
	}
	//管理权限的添加
	public function getQuanadds(Request $request)
	{
		//判断这个人是否有权限了
		$res = DB::table('vip_guanli_quanxian')->where('gid',$request->input('guanli'))->first();
		if(count($res)!=0)
		{
			return back()->with('error','此人已有权限,请进行修改');
		}
		//接受数组
		$arr = $request->input('duo');
		if(!$arr)
		{
			return back()->with('error','请选择此人的管理模块');
		}
		foreach($arr as $v)
		{
			//接受数据
			$data['gid'] = $request->input('guanli');
			//便利循环插入到数据库
			$data['mid'] = $v;
			$res = DB::table('vip_guanli_quanxian')->insert($data);
			if(!$res)
			{
				self::jilu('添加权限失败','2');
				return back()->with('error','添加权限失败');
			}
		}
		self::jilu('添加权限成功','2');
		return redirect('/admin/user/index')->with('success','添加权限成功');
	}
	//管理员的删除功能
	public function getDel($id)
	{
		//查询是否有删除的权利
		if(session('user')['quanxian']!=2)
		{
			return back()->with('error','您没有权利进行删除');
		 }
		 //判断此人是否有了权限
		$res1 = DB::table('vip_guanli')
				->join('vip_guanli_quanxian','vip_guanli_quanxian.gid','=','vip_guanli.id')
				->where('vip_guanli.id',$id)
				->first();
		if($res1)
		{
			$res = DB::table('vip_guanli')->where('vip_guanli.id',$id)
				->delete();
			$res = DB::table('vip_guanli_quanxian')->where('gid',$id)->delete();
		}else
		{
			$res = DB::table('vip_guanli')->where('vip_guanli.id',$id)
				->delete();
		}
		
		if($res)
		{
			self::jilu('删除管理成功','3');
			return redirect('/admin/user/index')->with('success','删除管理成功');
		}else
		{
			self::jilu('删除管理失败','3');
			return back()->with('error','删除管理失败');
		}
		
	}
}
