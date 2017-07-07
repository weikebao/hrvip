<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
date_default_timezone_set('Asia/Shanghai'); 

class AdminJifenController extends Controller
{
  //这里是积分的控制器
  public function getIndex(){
    //查询出所有人的积分来
    $res = DB::table('vip_huiyuan')->where('s',1)->orderBy('id','asc')->paginate(40);
    return view('adminjifen.index',['res'=>$res]);
  }
  //ajax查询相应人员的信息
  public function getAjax(Request $request)
  {
    //接受穿过来的数据
    $name=  $request->input('name');
    DB::table('vip_huiyuan')->chunk(100, function($vip_huiyuan)use($name){
      $data = [];
      foreach ($vip_huiyuan as $val) {
        //便利判断是否有与要查询的数据是否一致的信息
          if($name==$val['name'])
          {
            $data[] = $val;
          }
        }
        if($data)
        {
          echo json_encode($data);
        }else
        {
          echo 1;
        }
    });
  }
  //会员的积分来源信息表
  public function getLaiyuan($id){
    //根据用户的ID来查询他的所有积分的来源
    $res = DB::table('hongri_points')->where('ownerid',$id)->paginate(13);
    //讲数据加载到前台页面
    return view('adminjifen.list',['res'=>$res]);
  }
}


