<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class AdminDuihuanController extends Controller {
	//这里是积分兑换比例页面
	public function getIndex()
	{
		$res = DB::table('vip_duihuan')->get();
		return view('adminduihuan.index',['res'=>$res]);
	}
	//添加积分兑换比例页面
	public function getAdd()
	{
		return view('adminduihuan.add');
	}
	//将兑换的数据加载到数据库中
	public function postAdds(Request $request)
	{
		$data['jifen'] = $request->input('jifen');
		$data['money'] = $request->input('money');
		$res = DB::table('vip_duihuan')->insert($data);
		if($res)
		{
			AdminUserController::jilu('添加积分兑换比例成功','2');
			return redirect('/admin/duihuan/index')->with('success','添加积分兑换比例成功');
		}else{
			AdminUserController::jilu('添加积分兑换比例失败','2');
			return back()->with('error','添加积分兑换比例失败');
		}
	}
	//修改积分兑换设置
	public function getEdit($id)
	{
		$res = DB::table('vip_duihuan')->where('id',$id)->first();
		return view('adminduihuan.edit',['res'=>$res]);
	}
	//修改积分属性
	public function postEdits(Request $request)
	{
		$id=  $request->input('id');
		$data['jifen']=  $request->input('jifen');
		$data['money']=  $request->input('money');
		$res = DB::table('vip_duihuan')->where('id',$id)->update($data);
		if($res)
		{
			AdminUserController::jilu('修改积分兑换比例成功','4');
			return redirect('/admin/duihuan/index')->with('success','修改积分兑换比例成功');
		}else{
			AdminUserController::jilu('修改积分兑换比例成功','4');
			return back()->with('error','修改积分兑换比例成功');
		}
	}
	//删除不需要的兑换比例
	public function getDel($id){
		$res = DB::table('vip_duihuan')->where('id',$id)->delete();
		if($res)
		{
			AdminUserController::jilu('删除积分兑换比例成功','3');
			return redirect('/admin/duihuan/index')->with('success','删除积分兑换比例成功');
		}else{
			AdminUserController::jilu('删除积分兑换比例成功','3');
			return back()->with('error','删除积分兑换比例成功');
		}
	}
}
