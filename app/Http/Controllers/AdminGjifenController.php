<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
date_default_timezone_set('Asia/Shanghai'); 

class AdminGjifenController extends Controller
{ 
  //加载返利积分页面
  public function getIndex()
  {
    $res = DB::table('hongri_products')
  				->join('hongri_product_property','hongri_product_property.pid','=','hongri_products.id')
  				->select('hongri_product_property.id as fid','hongri_product_property.*','hongri_products.*')
  				->get();

  	return view('admingjifen.index',['res'=>$res]);
  }
  //添加返利积分页面
  public function getAdd()
  {
  	$res = DB::table('hongri_products')
  				->join('hongri_product_property','hongri_product_property.pid','=','hongri_products.id')
  				->select('hongri_product_property.id as fid','hongri_product_property.property','hongri_products.name')
  				->get();
  	return view('admingjifen.add',['res'=>$res]);
  }
  //积分返还的添加
  public function postAdds(Request $request)
  {
  	$id = $request->input('name');
  	$point = $request->input('point');
  	//修改数据库
  	$res = DB::table('hongri_product_property')->where('id',$id)->update(['return_points'=>$point]);
  	if($res)
    {
      AdminUserController::jilu('设置返还积分成功','4');
      return redirect('/admin/gjifen/index')->with('success','设置返还积分成功');
    }else{
      AdminUserController::jilu('设置返还积分失败','4');
      return back()->with('error','设置返还积分失败');
    }
  }
  //返还积分的修改
  public function getEdit($id)
  {
  	$res = DB::table('hongri_products')
  				->join('hongri_product_property','hongri_product_property.pid','=','hongri_products.id')
  				->where('hongri_product_property.id',$id)
  				->select('hongri_product_property.id as fid','hongri_product_property.property','hongri_product_property.return_points','hongri_products.name')
  				->first();
  	return view('admingjifen.edit',['res'=>$res]);
  }
  //修改商品的积分多少
  public function postEdits(Request $request)
  {
  	//接受参数
  	$id = $request->input('fid');
  	$point = $request->input('point');
    $res = DB::table('hongri_product_property')->where('id',$id)->update(['return_points'=>$point]);
    if($res)
    {
      AdminUserController::jilu('修改返还积分成功','4');
      return redirect('/admin/gjifen/index')->with('success','修改返还积分成功');
    }else{
      AdminUserController::jilu('修改返还积分失败','4');
      return back()->with('error','修改返还积分失败');
    }
  }
  //删除不需要的积分设置
  public function getDel($id)
  {
    $res = DB::table('hongri_product_property')->where('id',$id)->delete();
    if($res)
    {
      AdminUserController::jilu('删除积分设置成功','3');
      return redirect('/admin/gjifen/index')->with('success','删除积分设置成功');
    }else{
      AdminUserController::jilu('删除积分设置失败','3');
      return redirect('/admin/gjifen/index')->with('success','删除积分设置失败');
    }
  }
}


