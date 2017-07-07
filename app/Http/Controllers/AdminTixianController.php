<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class AdminTixianController extends Controller {
	//提现要求
	public function getYaoqiu()
	{
		$res = DB::table('vip_tixian_yaoqiu')->get();
		return view('admintixian.yaoqiu',['res'=>$res]);
	}
	//修改提现要求
	public function getYaoqiuedit(Request $request)
	{
		$id = $request->input('id');
		$lilv = $request->input('lilv');
		$money = $request->input('money');
		$res = DB::table('vip_tixian_yaoqiu')->where('id',$id)->update(['lilv'=>$lilv,'zuidimoney'=>$money]);
		if($res)
		{
			echo  1;
		}else{
			echo  2;
		}
	}
	public function getIndex()
	{
		//加载提现申请列表页面
		$res = DB::table('vip_tx')
				->join('vip_huiyuan','vip_huiyuan.id','=','vip_tx.yid')
				->join('vip_bank','vip_bank.yid','=','vip_tx.yid')
				->where('vip_tx.status',1)
				->paginate(15);
		return view('admintixian.index',['res'=>$res]);
	}
	//提现通过表
	public function getIndex1()
	{
		//加载提现申请列表页面
		$res = DB::table('vip_tx')
				->join('vip_huiyuan','vip_huiyuan.id','=','vip_tx.yid')
				->join('vip_bank','vip_bank.yid','=','vip_tx.yid')
				->where('vip_tx.status',2)
				->paginate(15);
		return view('admintixian.index_1',['res'=>$res]);
	}
	//提现不通过的页面
	public function getIndex2()
	{
		//加载提现申请列表页面
		$res = DB::table('vip_tx')
				->join('vip_huiyuan','vip_huiyuan.id','=','vip_tx.yid')
				->join('vip_bank','vip_bank.yid','=','vip_tx.yid')
				->where('vip_tx.status',3)
				->paginate(15);
		return view('admintixian.index_2',['res'=>$res]);
	}
	//提现的申请通过  这里需要银行的提现接口来支持  并且要减少%3的钱数充当工作人员的费用
	public function getTong($id){
		//修改提现的状态
		
		//减少相应人员的佣金
		$yuser = DB::table('vip_tx')->where('txid',$id)->first();
		$yid = $yuser['yid'];
		//求取提现人的佣金的数量
		$free = DB::table('vip_huiyuan')->where('id',$yid)->first()['free'];
		$money = $yuser['txjin'];
		if($free>=$money){
			$a = DB::table('vip_huiyuan')->where('id',$yid)->decrement('free',$money);
			$res = DB::table('vip_tx')->where('txid',$id)->update(['status'=>2]);
			if($res)
			{
				return redirect('/admin/tixian/index')->with('success','提现申请通过');
			}else{
				return back()->with('error','提现申请通过失败');
			}
		}else{
			return back()->with('error','提现申请通过失败');
		}
		
	}
	public function getNotong($id){
		$res = DB::table('vip_tx')->where('txid',$id)->update(['status'=>3]);
		if($res)
		{
			return redirect('/admin/tixian/index')->with('success','不允许申请通过');
		}else{
			return back()->with('error','不允许申请通过失败');
		}
	}
}
