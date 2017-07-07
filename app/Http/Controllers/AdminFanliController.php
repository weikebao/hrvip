<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
date_default_timezone_set('Asia/Shanghai'); 

class AdminFanliController extends Controller
{
  //返利页面
  public function getIndex()
  {
    $res = DB::table('vip_fldw')->get();
    return view('adminfanli.index',['res'=>$res]);
  }
  //返利要求的添加
  public function getAdd()
  {
    return view('adminfanli.add');
  }
  //返利信息的添加
  public function getAdds(Request $request)
  {
    $data['fanliname'] = $request->input('name');
    $data['bumenyi'] = $request->input('bumenyi');
    $data['bumener'] = $request->input('bumener');
    $data['bumensan'] = $request->input('bumensan');
    $data['fanlimoney'] = $request->input('free');
    $res = DB::table('vip_fldw')->insert($data);
    if($res)
    {
      AdminUserController::jilu('设置返利成功','2');
      return redirect('/admin/fanli/index')->with('success','设置返利成功');
    }else{
      AdminUserController::jilu('设置返利失败','2');
      return back()->with('error','设置返利失败');
    }
  }
  //返利要求的修改
  public function getEdit($id)
  {
    $res = DB::table('vip_fldw')->where('fanliid',$id)->first();
    return view('adminfanli.edit',['res'=>$res]);
  }
  //返利要求的修改确定
  public function postEdits(Request $request)
  {
    $data['fanliname'] = $request->input('name');
    $data['bumenyi'] = $request->input('bumenyi');
    $data['bumener'] = $request->input('bumener');
    $data['bumensan'] = $request->input('bumensan');
    $data['fanlimoney'] = $request->input('free');
    $res = DB::table('vip_fldw')->where('fanliid',$request->input('id'))->update($data);
    if($res)
    {
      AdminUserController::jilu('修改返利成功','4');
      return redirect('/admin/fanli/index')->with('success','设置返利成功');
    }else{
      AdminUserController::jilu('修改返利失败','4');
      return back()->with('error','设置返利失败');
    }
  }
  //删除不需要的职位
  public function getDel($id)
  {
    $res = DB::table('vip_fldw')->where('fanliid',$id)->delete();
    if($res)
    {
      AdminUserController::jilu('删除返利成功','3');
      return redirect('/admin/fanli/index')->with('success','删除返利成功');
    }else{
      AdminUserController::jilu('删除返利失败','3');
      return back()->with('error','删除返利失败');
    }
  }
}


