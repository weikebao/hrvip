<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class AdminJiluController extends Controller {
	//这历史浏览历史记录的控制器
	public function getIndex()
	{
		$res = DB::table('vip_jilu')->paginate(3);
		return view('adminjilu.index',['res'=>$res]);
	}
	//ajax查询相应的操作记录
	public function postAjax(Request $request)
	{
		//接受传过来的数据
		$riqi = $request->input('riqi');
		$caozuo = $request->input('caozuo');
		if($riqi=='')
		{
			//只查询相应的操作
			$num = '';
			if($caozuo=='增加')
			{
				$num = 2;
			}elseif($caozuo=='修改')
			{
				$num =4;
			}elseif($caozuo=='删除')
			{
				$num =3;
			}else
			{
				$res['a'] = "请输入正确查询条件";
				$res['d'] = '错误';
				echo json_encode($res);
				exit;
			}

			$res = DB::table('vip_jilu')->where('leixing',$num)->get();
			$res['d'] = '操作';
			echo json_encode($res);
				exit;
		}elseif($caozuo=='')
		{
			//只查询相应的日期
			$res = DB::table('vip_jilu')->where('time','like','%'.$riqi.'%')->get();
			$res['d'] = '日期';
			echo json_encode($res);
				exit;
		}else
		{
			$num = '';
			if($caozuo=='增加')
			{
				$num = 2;
			}elseif($caozuo=='修改')
			{
				$num =4;
			}elseif($caozuo=='删除')
			{
				$num =3;
			}else
			{
				$res['a'] = "请输入正确查询条件";
				$res['d'] = '错误';
			}

			//查询两个共同的条件
			$res = DB::table('vip_jilu')->where('time','like','%'.$riqi.'%')->where('leixing',$num)->get();
			$res['d'] = '日期操作';
			echo json_encode($res);
				exit;
			
		}
	}
}
