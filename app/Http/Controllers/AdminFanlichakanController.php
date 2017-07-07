<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
date_default_timezone_set('Asia/Shanghai'); 

class AdminFanlichakanController extends Controller
{
  //返利页面
  public function getIndex()
  {
    //查询每日的返利的会员的信息
    $res = DB::table('vip_huiyuan')
          ->join('vip_fldw','vip_fldw.fanliid','=','vip_huiyuan.fanlileixing')
          ->where('s',1)
          ->where('status',1)
          ->orderBy('vip_huiyuan.fanlileixing','desc')
          ->paginate(15);
    return view('fanlichakan.index',['res'=>$res]);
  }
  //ajax查询不同职位的返利的查询
  public function getAjax(Request $request)
  {
    //接受返利的职位名称
    $name = $request->input('name');
    $res = DB::table('vip_fldw')
          ->join('vip_huiyuan','vip_huiyuan.fanlileixing','=','vip_fldw.fanliid')
          ->where('fanliname',$name)
          ->where('vip_huiyuan.s',1)
          ->where('vip_huiyuan.status',1)
          ->get();
    //判断个数
          if(count($res)==0)
          {
            echo 1;
          }else{
            echo json_encode($res);
          }
  }
}


