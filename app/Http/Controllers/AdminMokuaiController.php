<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class AdminMokuaiController extends Controller {
	//ajax 请求此人的数据
	public function getIndex()
	{
		$id = session('user')['id'];

		$res = DB::table('vip_guanli_quanxian')->where('gid',$id)->get();
		echo json_encode($res);
	}
}
