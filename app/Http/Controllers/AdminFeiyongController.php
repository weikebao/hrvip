<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class AdminFeiyongController extends Controller {

	public function getIndex()
	{
		//加载费用统计表加载每个月的以及每日的指最近一个月的
		//查询数据库  肯定是30条数据  
		$time = date('Y-m-d H:i:s',time()-3600*24*30);
		$res1 = DB::table('vip_fanlijilu')->where('Jtime','>',$time)->orderBy('yfanmoney','desc')->paginate(30);
		$res = DB::table('vip_fanlijilu')->where('Jtime','>',$time)->get();
		//将所有的数据加载一起这是一个月的
		$account = 0;
		foreach($res as $v){
			$account+=$v['yfanmoney'];
		}
		return view('adminfeiyong.index',['res'=>$res1,'acount'=>$account]);
	}
	//ajax查询每天的返利详情
	public function postAjax(Request $request){
		$reqi = $request->input('riqi');
		//根据日期查询数据
		$res = DB::table('vip_fanlijilu')->where('Jtime','like','%'.$reqi.'%')->get();
		//将这一天的综合求取出来
		$acount = 0;
		foreach($res as $v)
		{
			$acount+=$v['yfanmoney'];
		}
		$res['d'] = $acount;
		echo json_encode($res);
	}
	//查询每月的信息
	public function postAjaxs(Request $request){
		$yue = $request->input('yue');
		if($yue>9){
			$yue = date('Y-',time()).$yue;
		}else{
			$yue = date('Y-',time()).'0'.$yue;
		}
		//根据日期查询数据
		$res = DB::table('vip_fanlijilu')->where('Jtime','like','%'.$yue.'%')->get();
		$acount = 0;
		foreach($res as $v){
			$acount+=$v['yfanmoney'];
		}
		$res['d'] = $acount;
		echo json_encode($res);
	}
	//每次返利的分算 指每个等级的人的返利计算
	public  function getFen()
	{
		//加载可选择的页面
		return view('adminfeiyong.fen');
	}
	//返利档位的详细信息
	public function getFenlei(Request $request)
	{
		//接受返利的档位的信息
		$id = $request->input('id');
		$res = DB::table('vip_huiyuan')
				->join('vip_fldw','vip_fldw.fanliid','=','vip_huiyuan.fanlileixing')
				->where('fanlileixing',$id)
				->where('s',1)
				->get();
		//这个职位的总人数
		$data['num'] = count($res);
		//求取这个职位的一天的总的金额
		$data['money'] =0;
		foreach($res as $v)
		{
			$data['money'] +=$v['fanlimoney'];
		}
		//将数据显示在前台
		return view('adminfeiyong.fenindex',['res'=>$data,'id'=>$id]);
	}
		//查看详细的信息
	public function getXiangxing($id)
	{
		//根据相应的档位的id 来进行相应的查看
		$res = DB::table('vip_huiyuan')->where('fanlileixing',$id)->where('s',1)->get();
		return view('adminfeiyong.xiangxing',['data'=>$res,'id'=>$id]);
	}
	//查看莫个人的详细信息
	public function getXiangxingajax(Request $request){
		$phone = $request->input('name');
		$id = $request->input('id');
		$res = DB::table('vip_huiyuan')->where('phone',$phone)->where('fanlileixing',$id)->where('s',1)->first();
		if($res){
			echo json_encode($res);
		}else{
			echo 1;
		}
	}
	//商品售出的费用总计算
	public function getWuindex()
	{
		//将一天的商品的售出的总的费用显示在页面当中(默认一天的)
		$time = date("Y-m-d",time());
		$res = DB::table('hongri_orders')
				->join('vip_huiyuan','hongri_orders.uid','=','vip_huiyuan.id')
				->where('hongri_orders.status','>=',1)->where('hongri_orders.paytime','like','%'.$time.'%')->select('vip_huiyuan.id','vip_huiyuan.phone','hongri_orders.total')->get();
		$total = 0;
		foreach($res as $v)
		{
			$total+=$v['total'];
		}
		$res = DB::table('hongri_orders')
				->join('vip_huiyuan','hongri_orders.uid','=','vip_huiyuan.id')
				->where('hongri_orders.status','>=',1)
				->where('hongri_orders.paytime','like','%'.$time.'%')
				->select('hongri_orders.uid','vip_huiyuan.phone','hongri_orders.total')
				->paginate(30);
		//将今天的数据加载到页面中
		return view('adminfeiyong.wuindex',['res'=>$res,'total'=>$total]);
	}


	//ajax查询每天的售出详情
	public function postWuajax(Request $request){
		$reqi = $request->input('riqi');
		//根据日期查询数据
		// $res = DB::table('hongri_orders')->where('paytime','like','%'.$reqi.'%')->where('status','>=',1)->get();
		$res = DB::table('hongri_orders')
				->join('vip_huiyuan','hongri_orders.uid','=','vip_huiyuan.id')
				->where('hongri_orders.status','>=',1)
				->where('hongri_orders.paytime','like','%'.$reqi.'%')
				->get();
		//将这一天的综合求取出来
		$acount = 0;
		foreach($res as $v)
		{
			$acount+=$v['total'];
		}
		$res['d'] = $acount;
		echo json_encode($res);
	}
	//查询每月的售出信息
	public function postWuajaxs(Request $request){
		$yue = $request->input('yue');
		if($yue>9){
			$yue = date('Y-',time()).$yue;
		}else{
			$yue = date('Y-',time()).'0'.$yue;
		}
		//根据日期查询数据
		// $res = DB::table('hongri_orders')->where('paytime','like','%'.$yue.'%')->where('status','>=',1)->get();
		$res = DB::table('hongri_orders')
				->join('vip_huiyuan','hongri_orders.uid','=','vip_huiyuan.id')
				->where('hongri_orders.status','>=',1)
				->where('hongri_orders.paytime','like','%'.$yue.'%')
				->get();
		$acount = 0;
		foreach($res as $v){
			$acount+=$v['total'];
		}
		$res['d'] = $acount;
		echo json_encode($res);
	}
	//费用合计表
	public function  getZongji()
	{
		//计算今天的购买的总费用 以及今天的返利的总的费用
		$time = date('Y-m-d');
		//查询今日的销售量
		$good  = DB::table('hongri_orders')->where('status','>=',1)->where('paytime','like','%'.$time.'%')->get();
		$total = 0;
		foreach($good as $v)
		{
			$total+=$v['total'];
		}
		//查询今日的返利总的费用
		$res = DB::table('vip_fanlijilu')->where('Jtime','like','%'.$time.'%')->get();
		$totals = 0;
		foreach($res as $v)
		{
			$totals+=$v['yfanmoney'];
		}
		//将数据加载到桌面上
		return view('adminfeiyong.zongji',['total'=>$total,'totals'=>$totals]);
	}
	//ajax查询某一天的总的费用
	public function postZongjiyueajax(Request $request)
	{
		//获取查询的日期
		$riqi = $request->input('riqi');
		$good  = DB::table('hongri_orders')->where('status','>=',1)->where('paytime','like','%'.$riqi.'%')->get();
		$data['total'] = 0;
		foreach($good as $v)
		{
			$data['total']+=$v['total'];
		}
		//查询今日的返利总的费用
		$res = DB::table('vip_fanlijilu')->where('Jtime','like','%'.$riqi.'%')->get();
		$data['totals'] = 0;
		foreach($res as $v)
		{
			$data['totals']+=$v['yfanmoney'];
		}
		echo json_encode($data);
	}
	//ajax查询近一个月的所有的总的费用
	public function postZongjiajax(Request $request)
	{
		$yue = $request->input('yue');
		if($yue>9){
			$yue = date('Y-',time()).$yue;
		}else{
			$yue = date('Y-',time()).'0'.$yue;
		}
		$good  = DB::table('hongri_orders')->where('status','>=',1)->where('paytime','like','%'.$yue.'%')->get();
		$data['total'] = 0;
		foreach($good as $v)
		{
			$data['total']+=$v['total'];
		}
		//查询今日的返利总的费用
		$res = DB::table('vip_fanlijilu')->where('Jtime','like','%'.$yue.'%')->get();
		$data['totals'] = 0;
		foreach($res as $v)
		{
			$data['totals']+=$v['yfanmoney'];
		}
		echo json_encode($data);
	}
	//个人费用详细查询表
	public function getXiangxi()
	{
		return view('adminfeiyong.xiangxi');
	}
	//ajax查询月的详细信息  指当前年的
	public function postXiangxiajax(Request $request)
	{
		$phone = $request->input('phone');
		$leixing = $request->input('leixing');
		$yue = $request->input('yue');
		if($yue>9){
			$yue = date('Y-',time()).$yue;
		}else{
			$yue = date('Y-',time()).'0'.$yue;
		}
		if($leixing==1){
			//交易记录
			//根据手机号来求取用户的id
			$id = DB::table('vip_huiyuan')->where('phone',$phone)->first()['id'];
			if($id){
				//交易记录
				$res = DB::table('hongri_orders')->where('uid',$id)->where('status','>=',1)->where('paytime','like','%'.$yue.'%')->orderBy('paytime','desc')->select('hongri_orders.paytime as time','hongri_orders.total as total')->get();
				echo json_encode($res);
			}
		}else if($leixing==2){
			//返利记录
			$res = DB::table('vip_fanlijilu')->where('yphone',$phone)->where('Jtime','like','%'.$yue.'%')->orderBy('Jtime','desc')->select('vip_fanlijilu.Jtime as time','vip_fanlijilu.yfanmoney as total')->get();
			echo json_encode($res);
		}else if($leixing==3){
			//充值记录
			$res = DB::table('vip_zhifu')->where('phone',$phone)->where('time','like','%'.$yue.'%')->where('status',2)->orderBy('time','desc')->select('vip_zhifu.time as time','vip_zhifu.money as total')->get();
			echo json_encode($res);
		}else if($leixing==4){
			//提现记录
			$res = DB::table('vip_tx')
					->join('vip_huiyuan','vip_huiyuan.id','=','vip_tx.yid')
					->where('vip_huiyuan.phone',$phone)
					->where('vip_tx.time','like','%'.$yue.'%')
					->orderBy('vip_tx.time','desc')
					->select('vip_tx.time as time','vip_tx.txjin as total')
					->get();
			echo json_encode($res);
		}else if($leixing==5){
			//兑换记录
			$res = DB::table('vip_taiyangbiduihuan')
					->where('phone',$phone)
					->where('time','like','%'.$yue.'%')
					->orderBy('time','desc')
					->select('vip_taiyangbiduihuan.time as time ','vip_taiyangbiduihuan.money as total')
					->get();
			echo json_encode($res);
		}else if($leixing==6){
			$res = DB::table('vip_zhuanzhang')->where('phone',$phone)->where('time','like','%'.$yue.'%')->select('vip_zhuanzhang.time as time','vip_zhuanzhang.money as total')->get();
			echo json_encode($res);
		}
	}
	//当前日期的ajax查询
	public function postXiangxiajaxs(Request $request)
	{
		$phone = $request->input('phone');
		$leixing = $request->input('leixing');
		$riqi = $request->input('riqi');
		if($leixing==1){
			//根据手机号来求取用户的id
			$id = DB::table('vip_huiyuan')->where('phone',$phone)->first()['id'];
			if($id){
				//交易记录
				$res = DB::table('hongri_orders')->where('uid',$id)->where('status','>=',1)->where('paytime','like','%'.$riqi.'%')->orderBy('paytime','desc')->select('hongri_orders.paytime as time','hongri_orders.total as total')->get();
				echo json_encode($res);
			}
		}else if($leixing==2){
			//返利记录
			$res = DB::table('vip_fanlijilu')->where('yphone',$phone)->where('Jtime','like','%'.$riqi.'%')->orderBy('Jtime','desc')->select('vip_fanlijilu.Jtime as time','vip_fanlijilu.yfanmoney as total')->get();
			echo json_encode($res);
		}else if($leixing==3){
			//充值记录
			$res = DB::table('vip_zhifu')->where('phone',$phone)->where('time','like','%'.$riqi.'%')->where('status',2)->orderBy('time','desc')->select('vip_zhifu.time as time','vip_zhifu.money as total')->get();
			echo json_encode($res);
		}else if($leixing==4){
			//提现记录
			$res = DB::table('vip_tx')
					->join('vip_huiyuan','vip_huiyuan.id','=','vip_tx.yid')
					->where('vip_huiyuan.phone',$phone)
					->where('vip_tx.time','like','%'.$riqi.'%')
					->orderBy('vip_tx.time','desc')
					->select('vip_tx.time as time','vip_tx.txjin as total')
					->get();
			echo json_encode($res);
		}else if($leixing==5){
			//兑换记录
			$res = DB::table('vip_taiyangbiduihuan')
					->where('phone',$phone)
					->where('time','like','%'.$riqi.'%')
					->orderBy('time','desc')
					->select('vip_taiyangbiduihuan.time as time ','vip_taiyangbiduihuan.money as total')
					->get();
			echo json_encode($res);
		}else if($leixing==6){
			$res = DB::table('vip_zhuanzhang')->where('phone',$phone)->where('time','like','%'.$riqi.'%')->select('vip_zhuanzhang.time as time','vip_zhuanzhang.money as total')->get();
			echo json_encode($res);
		}
	}
}
