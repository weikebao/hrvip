<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
date_default_timezone_set('Asia/Shanghai'); 

class TuihuiyuanController extends Controller
{
  public function getIndex()
  {
   //查询所有的推荐人的信息 为被划落的人员的信息 
    $res = DB::table('vip_huiyuan')->where('s',1)->orderBy('id','asc')->get();
    return view('huiyuanguanli.index',['res'=>$res]);
  }
  //会员最基本的基点的添加
  public function getJidian()
  {
    return view('huiyuanguanli.jidianadd');
  }
  public function postJidianadds(Request $request)
  {
    //接受信息添加到会员的信息列表当中
    //推荐人的账号(手机号)
    $data['phone'] = $request->input('phone');
    //推荐人的姓名
    $data['name'] = $request->input('name');
    //推荐人的密码
    $data['pass'] = md5($request->input('pass'));
    //推荐人的基点区别 2为基点1不是基点
    $data['jidian'] = $request->input('jidian');
    //基点添加的日期
    $data['zhuceriqi'] = date('Y-m-d H:i:s',time());
    //推荐人的地址
    $data['address'] = null;
    //推荐人的推荐码  用手机号代替
    $data['code'] = $request->input('phone');
    //推荐人的余额
    $data['free'] = '0.00';
   //推荐的左区间的人数
    $data['zuoqujian'] = 0;
    //推荐人的右区间的人数
    $data['youqujian'] = 0;
    //推荐人的左节点
    $data['zuojiedian'] =0;
    //推荐人的右节点
    $data['youjiedian'] =0;
    //推荐人的第三个节点
    $data['sanjiedian'] =0;
    //推荐人的第三区间人数
    $data['sanqujian'] = 0;
    //基点会员的状态 表示都进行了消费
    $data['huiyuanstatus'] =1;
    //会员的第一次购买日期
    $data['firstgoumai'] = date('Y-m-d H:i:s',time());
    //会员基点的返利状态
    $data['status'] = 0;
    $data['tuipath'] = '.1,';
    //将信息插入到数据库只能怪
    $res = DB::table('vip_huiyuan')->insert($data);
    if($res){
      return redirect('/admin/tuihuiyuan/index')->with('success','添加基点会员成功');
    }else{
      return back()->with('error','添加基点会员失败');
    }
  }
  //加载推荐的添加页面
  public  function getAdd($id)
  {
    $id = DB::table('vip_huiyuan')->where('id',$id)->first();
    return view('huiyuanguanli.add',['id'=>$id]);
  }
  //添加推荐人的会员的信息   公司的基点
  public function postAdds(Request $request)
  {
    //接受推荐人的信息
    //推荐人的账号(手机号)
    //查询数据库来自动的增加用户的编号
    // $first = DB::table('vip_huiyuan')->orderBy('id','desc')->first();
    // $data['phone'] = $first['name']+1 ;
    // $data['name'] = $first['name']+1;
    // $data['pass'] = md5('123456');
    // $data['address'] =$first['name']+1;
    // $data['code'] = $first['name']+1;
    $data['phone'] = $request->input('phone');
    $data['name'] = $request->input('name');
    $data['pass'] = md5($request->input('pass'));
    $data['address'] = $request->input('address');
    $data['code'] = $request->input('phone');
  //   //推荐人的余额
    $data['free'] = '0.00';
   //推荐的左区间的人数
    $data['zuoqujian'] = 0;
    //推荐人的右区间的人数
    $data['youqujian'] = 0;
    //推荐人的左节点
    $data['zuojiedian'] =0;
    //推荐人的右节点
    $data['youjiedian'] =0;
    //推荐人的第三个节点
    $data['sanjiedian'] =0;
    //推荐人的第三区间人数
    $data['sanqujian'] = 0;
    //推荐人的基点区别 2为基点1不是基点
    $data['jidian'] = $request->input('jidian');
    //基点添加的日期
    $data['zhuceriqi'] = date('Y-m-d H:i:s',time());
    //基点会员的状态
    $data['huiyuanstatus'] =1;
    //会员的第一次购买日期
    $data['firstgoumai'] = '';
    //会员基点的返利状态
    $data['status'] = 0;
    $ids = $request->input('id');
    //获取这个人的ID存放到新加的人的身上,为以后是否满足返利作条件
    $data['suoshu'] = $request->input('code');//这个主要是前台注册的时候用得到
    $data['xiaofei']=1;
    $jiedian = $request->input('qujian');

    
    //判断添加的这个人在穿过来得这个人的那个位置 如果位置有人 则向他的节点的位置上下滑一位
    // $qujian = $request->input('qujian');//这个是要添加的位置
    // $id = $request->input('id');  //这个是要添加人的id
    // $one = DB::table('vip_huiyuan')->where('id',$id)->first();
    // //判断这个人选择的区间的位置上是否有人
    // if($qujian==1){
    //   //判断这个人的左区间  有人就自动下滑一位  没有直接添加
    //   if($one['zuojiedian']==''){
    //     //说明没有人直接添加
    //     //将此人添加到数据库获取当前人的推荐路径
    //     $pathurl = $one['tuipath'];
    //     $tianid = DB::table('vip_huiyuan')->insertGetId($data);
    //     //修改添加的人的路径
    //     $pathurls = $pathurl.$tianid.',';
    //     DB::table('vip_huiyuan')->where('id',$tianid)->update(['tuipath'=>$pathurls]);
    //     //修改当前一条线上的总人数  和节点位置
    //     DB::table('vip_huiyuan')->where('id',$one['id'])->update(['zuojiedian'=>$tianid]);
    //     //拆分当前人的路径
    //     $path = explode(',',$pathurls);
    //     //判断数组的个数
    //     $a = count($path)-1;
    //     //最后一次的id出现的位置  同时判断数组的个数
    //     if($a==2){
    //       $zuiid = explode('.',$path[$a-2])[1];//1
    //     }else{
    //       $zuiid = $path[$a-2];//这个是它添加的这个人的id
    //     }
    //     //将字符串进行截取$pathurl['tuipath'] .1,11,11,111,1111,
    //     for($i=1;$i<=$a;$i++){ 
    //       $str = array_slice($path,0,$i);
    //       $str1 = array_slice($path,0,$i+1);
    //       //合并数组形成字符串
    //       $str = implode(',',$str);
    //       $str = $str.',';
    //       $str1 = implode(',',$str1);
    //       $str1 = $str1.',';
    //       //根据这个$str来精确查找数据 将所有数据加1
    //       $bb = DB::table('vip_huiyuan')->where('tuipath',$str)->first();
    //       $bb1 = DB::table('vip_huiyuan')->where('tuipath',$str1)->first();
    //       if(count($bb1)!=0){
    //         //判断这个人的下属会员时那个区间的
    //         if($bb['zuojiedian']==$bb1['id']){
    //           //就在这个人的左区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['zuoqujian'=>$bb['zuoqujian']+1]);
    //         }elseif($bb['youjiedian']==$bb1['id']){
    //           //就在这个人的右区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['youqujian'=>$bb['youqujian']+1]);
    //         }elseif($bb['sanjiedian']==$bb1['id']){
    //           //就在这个人的三区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['sanqujian'=>$bb['sanqujian']+1]);
    //         }
    //       }
    //     }
    //   }else{
    //     //说明有人下滑在这个人的1部门
    //     // 获取这个人的左节点的信息
    //     $zuoren = DB::table('vip_huiyuan')->where('id',$one['zuojiedian'])->first();
    //     //将新添加的这个人放在获取的这个人的左节点的位置上
    //     $pathurl = $zuoren['tuipath'];
    //     $tianid = DB::table('vip_huiyuan')->insertGetId($data);
    //     //修改添加的人的路径
    //     $pathurls = $pathurl.$tianid.',';
    //     DB::table('vip_huiyuan')->where('id',$tianid)->update(['tuipath'=>$pathurls]);
    //     //修改这个人的左节点  并把一条线上的人加1
    //     DB::table('vip_huiyuan')->where('id',$zuoren['id'])->update(['zuojiedian'=>$tianid]);
    //     //拆分当前人的路径
    //     $path = explode(',',$pathurls);
    //     //判断数组的个数
    //     $a = count($path)-1;
    //     //最后一次的id出现的位置  同时判断数组的个数
    //     if($a==2){
    //       $zuiid = explode('.',$path[$a-2])[1];//1
    //     }else{
    //       $zuiid = $path[$a-2];//这个是它添加的这个人的id
    //     }
    //     //将字符串进行截取$pathurl['tuipath'] .1,11,11,111,1111,
    //     for($i=1;$i<=$a;$i++){ 
    //       $str = array_slice($path,0,$i);
    //       $str1 = array_slice($path,0,$i+1);
    //       //合并数组形成字符串
    //       $str = implode(',',$str);
    //       $str = $str.',';
    //       $str1 = implode(',',$str1);
    //       $str1 = $str1.',';
    //       //根据这个$str来精确查找数据 将所有数据加1
    //       $bb = DB::table('vip_huiyuan')->where('tuipath',$str)->first();
    //       $bb1 = DB::table('vip_huiyuan')->where('tuipath',$str1)->first();
    //       if(count($bb1)!=0){
    //         //判断这个人的下属会员时那个区间的
    //         if($bb['zuojiedian']==$bb1['id']){
    //           //就在这个人的左区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['zuoqujian'=>$bb['zuoqujian']+1]);
    //         }elseif($bb['youjiedian']==$bb1['id']){
    //           //就在这个人的右区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['youqujian'=>$bb['youqujian']+1]);
    //         }elseif($bb['sanjiedian']==$bb1['id']){
    //           //就在这个人的三区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['sanqujian'=>$bb['sanqujian']+1]);
    //         }
    //       }
    //     }
    //   }
    // }elseif($qujian==2){
    //   //判断这个人的右区间
    //   if($one['youjiedian']==''){
    //     //说明没有人直接添加
    //     //将此人添加到数据库获取当前人的推荐路径
    //     $pathurl = $one['tuipath'];
    //     $tianid = DB::table('vip_huiyuan')->insertGetId($data);
    //     //修改添加的人的路径
    //     $pathurls = $pathurl.$tianid.',';
    //     DB::table('vip_huiyuan')->where('id',$tianid)->update(['tuipath'=>$pathurls]);
    //     //修改当前一条线上的总人数  和节点位置
    //     DB::table('vip_huiyuan')->where('id',$one['id'])->update(['youjiedian'=>$tianid]);
    //     //拆分当前人的路径
    //     $path = explode(',',$pathurls);
    //     //判断数组的个数
    //     $a = count($path)-1;
    //     //最后一次的id出现的位置  同时判断数组的个数
    //     if($a==2){
    //       $zuiid = explode('.',$path[$a-2])[1];//1
    //     }else{
    //       $zuiid = $path[$a-2];//这个是它添加的这个人的id
    //     }
    //     //将字符串进行截取$pathurl['tuipath'] .1,11,11,111,1111,
    //     for($i=1;$i<=$a;$i++){ 
    //       $str = array_slice($path,0,$i);
    //       $str1 = array_slice($path,0,$i+1);
    //       //合并数组形成字符串
    //       $str = implode(',',$str);
    //       $str = $str.',';
    //       $str1 = implode(',',$str1);
    //       $str1 = $str1.',';
    //       //根据这个$str来精确查找数据 将所有数据加1
    //       $bb = DB::table('vip_huiyuan')->where('tuipath',$str)->first();
    //       $bb1 = DB::table('vip_huiyuan')->where('tuipath',$str1)->first();
    //       if(count($bb1)!=0){
    //         //判断这个人的下属会员时那个区间的
    //         if($bb['zuojiedian']==$bb1['id']){
    //           //就在这个人的左区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['zuoqujian'=>$bb['zuoqujian']+1]);
    //         }elseif($bb['youjiedian']==$bb1['id']){
    //           //就在这个人的右区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['youqujian'=>$bb['youqujian']+1]);
    //         }elseif($bb['sanjiedian']==$bb1['id']){
    //           //就在这个人的三区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['sanqujian'=>$bb['sanqujian']+1]);
    //         }
    //       }
    //     }
    //   }else{
    //     $zuoren = DB::table('vip_huiyuan')->where('id',$one['youjiedian'])->first();
    //     //将新添加的这个人放在获取的这个人的左节点的位置上
    //     $pathurl = $zuoren['tuipath'];
    //     $tianid = DB::table('vip_huiyuan')->insertGetId($data);
    //     //修改添加的人的路径
    //     $pathurls = $pathurl.$tianid.',';
    //     DB::table('vip_huiyuan')->where('id',$tianid)->update(['tuipath'=>$pathurls]);
    //     //修改这个人的左节点  并把一条线上的人加1
    //     DB::table('vip_huiyuan')->where('id',$zuoren['id'])->update(['zuojiedian'=>$tianid]);
    //     //拆分当前人的路径
    //     $path = explode(',',$pathurls);
    //     //判断数组的个数
    //     $a = count($path)-1;
    //     //最后一次的id出现的位置  同时判断数组的个数
    //     if($a==2){
    //       $zuiid = explode('.',$path[$a-2])[1];//1
    //     }else{
    //       $zuiid = $path[$a-2];//这个是它添加的这个人的id
    //     }
    //     //将字符串进行截取$pathurl['tuipath'] .1,11,11,111,1111,
    //     for($i=1;$i<=$a;$i++){ 
    //       $str = array_slice($path,0,$i);
    //       $str1 = array_slice($path,0,$i+1);
    //       //合并数组形成字符串
    //       $str = implode(',',$str);
    //       $str = $str.',';
    //       $str1 = implode(',',$str1);
    //       $str1 = $str1.',';
    //       //根据这个$str来精确查找数据 将所有数据加1
    //       $bb = DB::table('vip_huiyuan')->where('tuipath',$str)->first();
    //       $bb1 = DB::table('vip_huiyuan')->where('tuipath',$str1)->first();
    //       if(count($bb1)!=0){
    //         //判断这个人的下属会员时那个区间的
    //         if($bb['zuojiedian']==$bb1['id']){
    //           //就在这个人的左区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['zuoqujian'=>$bb['zuoqujian']+1]);
    //         }elseif($bb['youjiedian']==$bb1['id']){
    //           //就在这个人的右区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['youqujian'=>$bb['youqujian']+1]);
    //         }elseif($bb['sanjiedian']==$bb1['id']){
    //           //就在这个人的三区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['sanqujian'=>$bb['sanqujian']+1]);
    //         }
    //       }
    //     }
    //   }
    // }// elseif($qujian==3){
    // 	//选择第三区间的增加
    // 	//判断选择的这个人的左右节点是否有人
    // 	 if($one['zuojiedian']==''){
    //     //说明没有人直接添加
    //     //将此人添加到数据库获取当前人的推荐路径
    //     $pathurl = $one['tuipath'];
    //     $tianid = DB::table('vip_huiyuan')->insertGetId($data);
    //     //修改添加的人的路径
    //     $pathurls = $pathurl.$tianid.',';
    //     DB::table('vip_huiyuan')->where('id',$tianid)->update(['tuipath'=>$pathurls]);
    //     //修改当前一条线上的总人数  和节点位置
    //     DB::table('vip_huiyuan')->where('id',$one['id'])->update(['zuojiedian'=>$tianid]);
    //     //拆分当前人的路径
    //     $path = explode(',',$pathurls);
    //     //判断数组的个数
    //     $a = count($path)-1;
    //     //最后一次的id出现的位置  同时判断数组的个数
    //     if($a==2){
    //       $zuiid = explode('.',$path[$a-2])[1];//1
    //     }else{
    //       $zuiid = $path[$a-2];//这个是它添加的这个人的id
    //     }
    //     //将字符串进行截取$pathurl['tuipath'] .1,11,11,111,1111,
    //     for($i=1;$i<=$a;$i++){ 
    //       $str = array_slice($path,0,$i);
    //       $str1 = array_slice($path,0,$i+1);
    //       //合并数组形成字符串
    //       $str = implode(',',$str);
    //       $str = $str.',';
    //       $str1 = implode(',',$str1);
    //       $str1 = $str1.',';
    //       //根据这个$str来精确查找数据 将所有数据加1
    //       $bb = DB::table('vip_huiyuan')->where('tuipath',$str)->first();
    //       $bb1 = DB::table('vip_huiyuan')->where('tuipath',$str1)->first();
    //       if(count($bb1)!=0){
    //         //判断这个人的下属会员时那个区间的
    //         if($bb['zuojiedian']==$bb1['id']){
    //           //就在这个人的左区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['zuoqujian'=>$bb['zuoqujian']+1]);
    //         }elseif($bb['youjiedian']==$bb1['id']){
    //           //就在这个人的右区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['youqujian'=>$bb['youqujian']+1]);
    //         }elseif($bb['sanjiedian']==$bb1['id']){
    //           //就在这个人的三区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['sanqujian'=>$bb['sanqujian']+1]);
    //         }
    //       }
    //     }
    //   }else{
    //     //说明有人下滑在这个人的1部门
    //     //获取这个人的三节点的信息
    //     $zuoren = DB::table('vip_huiyuan')->where('id',$one['sanjiedian'])->first();
    //     //将新添加的这个人放在获取的这个人的左节点的位置上
    //     $pathurl = $zuoren['tuipath'];
    //     $tianid = DB::table('vip_huiyuan')->insertGetId($data);
    //     //修改添加的人的路径
    //     $pathurls = $pathurl.$tianid.',';
    //     DB::table('vip_huiyuan')->where('id',$tianid)->update(['tuipath'=>$pathurls]);
    //     //修改这个人的左节点  并把一条线上的人加1
    //     DB::table('vip_huiyuan')->where('id',$zuoren['id'])->update(['zuojiedian'=>$tianid]);
    //     //拆分当前人的路径
    //     $path = explode(',',$pathurls);
    //     //判断数组的个数
    //     $a = count($path)-1;
    //     //最后一次的id出现的位置  同时判断数组的个数
    //     if($a==2){
    //       $zuiid = explode('.',$path[$a-2])[1];//1
    //     }else{
    //       $zuiid = $path[$a-2];//这个是它添加的这个人的id
    //     }
    //     //将字符串进行截取$pathurl['tuipath'] .1,11,11,111,1111,
    //     for($i=1;$i<=$a;$i++){ 
    //       $str = array_slice($path,0,$i);
    //       $str1 = array_slice($path,0,$i+1);
    //       //合并数组形成字符串
    //       $str = implode(',',$str);
    //       $str = $str.',';
    //       $str1 = implode(',',$str1);
    //       $str1 = $str1.',';
    //       //根据这个$str来精确查找数据 将所有数据加1
    //       $bb = DB::table('vip_huiyuan')->where('tuipath',$str)->first();
    //       $bb1 = DB::table('vip_huiyuan')->where('tuipath',$str1)->first();
    //       if(count($bb1)!=0){
    //         //判断这个人的下属会员时那个区间的
    //         if($bb['zuojiedian']==$bb1['id']){
    //           //就在这个人的左区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['zuoqujian'=>$bb['zuoqujian']+1]);
    //         }elseif($bb['youjiedian']==$bb1['id']){
    //           //就在这个人的右区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['youqujian'=>$bb['youqujian']+1]);
    //         }elseif($bb['sanjiedian']==$bb1['id']){
    //           //就在这个人的三区间增加
    //             $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['sanqujian'=>$bb['sanqujian']+1]);
    //         }
    //       }
    //     }
    //   }
    // }

// exit;
    DB::transaction(function ()use($data,$ids,$jiedian) {
      //将人添加到数据库中
      $id = DB::table('vip_huiyuan')->insertGetId($data);
      //查询添加这个人的推荐路径将其放在新添加的人的推荐路径上
      $pathurl = DB::table('vip_huiyuan')->where('id',$ids)->first();
      //这个会员的顶级的ID的左右区间 
      $dingjiID = explode(',',$pathurl['tuipath'])[0];
      $dingjiID = explode('.',$dingjiID)[1];
      // 顶级会员的左右区间的总人数
      $zuoqujian = DB::table('vip_huiyuan')->where('id',$dingjiID)->first()['zuoqujian'];
      $youqujian = DB::table('vip_huiyuan')->where('id',$dingjiID)->first()['youqujian'];
      $sanqujian = DB::table('vip_huiyuan')->where('id',$dingjiID)->first()['sanqujian'];
      //顶级会员的左右节点
      $zuojiedian = DB::table('vip_huiyuan')->where('id',$dingjiID)->first()['zuojiedian'];
      $youjiedian = DB::table('vip_huiyuan')->where('id',$dingjiID)->first()['youjiedian'];
      $sanjiedian = DB::table('vip_huiyuan')->where('id',$dingjiID)->first()['sanjiedian'];
     
      //判断这个会员的路径来判断他是否是顶级会员
      $dingjiqujian = explode(',',$pathurl['tuipath'])[1];

     //这个是新人的推荐路径
      $pathurls = $pathurl['tuipath'].$id.',';
      //将新的路径结合新添的人的ID修改新会员的推荐路径
      $res = DB::table('vip_huiyuan')->where('id',$id)->update(['tuipath'=>$pathurls]);
      

      //判断顶级会员的两侧节点是否被占用
      //没数据说明他是顶级会员1, 
      if($dingjiqujian==''){
        //说明添加的是第一代会员 同时也还要判断他的左右节点的情况
        if($pathurl['zuojiedian']!='' &&$jiedian==1){
          //说明左节点已经有人了在添加就失败
          DB::rollBack();
          echo  '左节点已经有人了,添加失败';
          exit;
        }elseif($pathurl['youjiedian']!=''&&$jiedian==2){
          //说明右节点有人了在添加就失败
           DB::rollBack();
          echo  '右节点已经有人了,添加失败';
          exit;
        }elseif($pathurl['sanjiedian']!=''&&$jiedian==3){
          //说明三节点有人了在添加就失败
           DB::rollBack();
          echo  '三节点已经有人了,添加失败';
          exit;
        }
        //判断区间进行添加
        if($jiedian==1){
          //说明添加到了会员的左区间并修改左区间的所有人数
          $qujian = DB::table('vip_huiyuan')->where('id',$dingjiID)->update(['zuojiedian'=>$id]);
       
        }elseif($jiedian==2){
          $qujian = DB::table('vip_huiyuan')->where('id',$dingjiID)->update(['youjiedian'=>$id]);
        }elseif($jiedian==3){
          //说明他这个时候填写的是第三个区间的总人数
          $qujian = DB::table('vip_huiyuan')->where('id',$dingjiID)->update(['sanjiedian'=>$id]);
        }
      }else{
          //说明添加的不是第一代会员1,2,或1,2,3,这样他上边的所有人都要加1
          //判断他所在的区间是第一代会员的那侧
         
          if( $dingjiqujian==$zuojiedian){
            //判断节点进行添加
            if($jiedian==1){
              //查询这个人的左节点是否有人
              $aa = DB::table('vip_huiyuan')->where('id',$ids)->first()['zuojiedian'];
              if($aa!=0){
                DB::rollBack();
                //添加操作记录
                // AdminUserController::jilu('添加会员失败,左节点已经有人了','2');
                echo '添加失败,左节点已经有人了1';
                // return back()->with('success','添加失败,左区间已经有人了');
              }else{
                //说明添加到了会员的左区间并修改左区间的所有人数以及他这一个区间的人数$pathurl['tuipath']这一路径得所有人都要1个人
                $qujian = DB::table('vip_huiyuan')->where('id',$ids)->update(['zuojiedian'=>$id]);
              }
            }elseif($jiedian==2){
              //说明添加到了会员的右区间
              //查询这个人的左节点是否有人
              $aa = DB::table('vip_huiyuan')->where('id',$ids)->first()['youjiedian'];
              if($aa!=0){
                DB::rollBack();
                // AdminUserController::jilu('添加会员失败,右节点已经有人了','2');
                echo '添加失败,右节点已经有人了1';
                // return back()->with('success','添加失败,右区间已经有人了');
              }else{
                $qujian = DB::table('vip_huiyuan')->where('id',$ids)->update(['youjiedian'=>$id]);
              }
            }elseif($jiedian==3){
              //判断他的3节点是否有人
              $aa = DB::table('vip_huiyuan')->where('id',$ids)->first()['sanjiedian'];
              if($aa!=0){
                DB::rollBack();
                // AdminUserController::jilu('添加会员失败,三号节点已经有人了','2');
                echo '添加失败,三节点已经有人了1';
                // return back()->with('success','添加失败,右区间已经有人了');
              }else{
                $qujian = DB::table('vip_huiyuan')->where('id',$ids)->update(['sanjiedian'=>$id]);
              }
            }
          }else if($dingjiqujian==$youjiedian){
            //判断节点进行添加
            if($jiedian==1){
              //查询这个人的左节点是否有人
              $aa = DB::table('vip_huiyuan')->where('id',$ids)->first()['zuojiedian'];
              if($aa!=0)
              {
                DB::rollBack();
                // AdminUserController::jilu('添加会员失败,左节点已经有人了','2');
                echo '添加失败,左节点已经有人了2';
                // return back()->with('success','添加失败,左区间已经有人了');
              }else{
                 //说明添加到了会员的左区间并修改左区间的所有人数
                $qujian = DB::table('vip_huiyuan')->where('id',$ids)->update(['zuojiedian'=>$id]);
              }
            }elseif($jiedian==2){
              //说明添加到了会员的右区间
              //查询这个人的左节点是否有人
              $aa = DB::table('vip_huiyuan')->where('id',$ids)->first()['youjiedian'];
              if($aa!=0)
              {
                DB::rollBack();
                // AdminUserController::jilu('添加会员失败,右节点已经有人了','2');
                echo '添加失败,右节点已经有人了2';
                // return back()->with('success','添加失败,右区间已经有人了');
              }else{
                $qujian = DB::table('vip_huiyuan')->where('id',$ids)->update(['youjiedian'=>$id]);
              }
            }elseif($jiedian==3){
              $aa = DB::table('vip_huiyuan')->where('id',$ids)->first()['sanjiedian'];
              if($aa!=0)
              {
                DB::rollBack();
                // AdminUserController::jilu('添加会员失败,三号节点已经有人了','2');
                echo '添加失败,三节点已经有人了2';
                // return back()->with('success','添加失败,右区间已经有人了');
              }else{
                $qujian = DB::table('vip_huiyuan')->where('id',$ids)->update(['sanjiedian'=>$id]);
              }
            }
          }elseif($dingjiqujian==$sanjiedian){
            //判断节点进行添加
            if($jiedian==1){
              //查询这个人的三节点是否有人
              $aa = DB::table('vip_huiyuan')->where('id',$ids)->first()['zuojiedian'];
              if($aa!=0){
                DB::rollBack();
                // AdminUserController::jilu('添加会员失败,左节点已经有人了','2');
                echo '添加失败,左节点已经有人了1';
                // return back()->with('success','添加失败,左区间已经有人了');
              }else{
                //说明添加到了会员的左区间并修改左区间的所有人数
                // $num = DB::table('vip_huiyuan')->where('id',$dingjiID)->update(['sanqujian'=>$sanqujian+1]);
                $qujian = DB::table('vip_huiyuan')->where('id',$ids)->update(['zuojiedian'=>$id]);
              }
            }elseif($jiedian==2){
              //说明添加到了会员的右区间
              //查询这个人的左节点是否有人
              $aa = DB::table('vip_huiyuan')->where('id',$ids)->first()['youjiedian'];
              if($aa!=0)
              {
                DB::rollBack();
                // AdminUserController::jilu('添加会员失败,右节点已经有人了','2');
                echo '添加失败,右区间已经有人了1';
                // return back()->with('success','添加失败,右区间已经有人了');
              }else{
                // $num = DB::table('vip_huiyuan')->where('id',$dingjiID)->update(['sanqujian'=>$sanqujian+1]);
                $qujian = DB::table('vip_huiyuan')->where('id',$ids)->update(['youjiedian'=>$id]);
              }
            }elseif($jiedian==3){
              $aa = DB::table('vip_huiyuan')->where('id',$ids)->first()['sanjiedian'];
              if($aa!=0)
              {
                DB::rollBack();
                // AdminUserController::jilu('添加会员失败,三号节点已经有人了','2');
                echo '添加失败,三节点已经有人了2';
                // return back()->with('success','添加失败,右区间已经有人了');
              }else{
                // $num = DB::table('vip_huiyuan')->where('id',$dingjiID)->update(['sanqujian'=>$sanqujian+1]);
                $qujian = DB::table('vip_huiyuan')->where('id',$ids)->update(['sanjiedian'=>$id]);
              }
            }
             
          }else{
            DB::rollBack();
            // AdminUserController::jilu('添加会员失败,系统错误','2');
            echo '系统错误';
          }
      }
      if(!$qujian)
      {
        DB::rollBack();
        // AdminUserController::jilu('添加会员失败','2');
        echo "会员添加失败";
      }else
      { 
        $path = explode(',',$pathurls);
        //判断数组的个数
        $a = count($path)-1;
        //最后一次的id出现的位置  同时判断数组的个数
        if($a==2){
          $zuiid = explode('.',$path[$a-2])[1];
        }else{
          $zuiid = $path[$a-2];
        }
        //将字符串进行截取$pathurl['tuipath'] .1,11,11,111,1111,
        for($i=1;$i<=$a;$i++){ 
          $str = array_slice($path,0,$i);
          $str1 = array_slice($path,0,$i+1);
          //合并数组形成字符串
          $str = implode(',',$str);
          $str = $str.',';
          $str1 = implode(',',$str1);
          $str1 = $str1.',';
          //根据这个$str来精确查找数据 将所有数据加1
          $bb = DB::table('vip_huiyuan')->where('tuipath',$str)->first();
          $bb1 = DB::table('vip_huiyuan')->where('tuipath',$str1)->first();
          if(count($bb1)!=0){
            //判断这个人的下属会员时那个区间的
            if($bb['zuojiedian']==$bb1['id']){
              //就在这个人的左区间增加
                $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['zuoqujian'=>$bb['zuoqujian']+1]);
            }elseif($bb['youjiedian']==$bb1['id']){
              //就在这个人的右区间增加
                $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['youqujian'=>$bb['youqujian']+1]);
            }elseif($bb['sanjiedian']==$bb1['id']){
              //就在这个人的三区间增加
                $cc = DB::table('vip_huiyuan')->where('tuipath',$str)->update(['sanqujian'=>$bb['sanqujian']+1]);
            }
          }
        }
        // AdminUserController::jilu('添加会员成功','2');
        echo "会员添加成功";
      }
     
  });
  }
  //加载所有的会员列表
  public function getList(Request $request)
  {
   //根据查询的条件不同显示不同的数据
    $action = $request->input('wei');
    $id = $request->input('id');
    if($action=='zuo'){
      //查询关于此人的左区间的所有的自己会员
      $res = DB::table('vip_huiyuan')->where('id',$id)->first();
      //求出此人的左区间的第一个节点的ID
      $zuoid = $res['zuojiedian'];//这个值有可能不存在说明他的左区间没人
      if($zuoid=='')
      {
        return back()->with('error','您的一部市场还没有会员');
      }else{
        //他这个会员的路径加上他左节点ID就是要查询的左区间的所有人D的开始路径,把这个路径的所有会员提取出来
        $path = $res['tuipath'].$zuoid.',';
        $res1 = DB::table('vip_huiyuan')
                ->where('tuipath','like','%'.$path.'%')
                ->paginate(40);
      }
      return view('huiyuanguanli.qujian',['res'=>$res1]);
    }elseif($action=='you'){
      //查询关于此人的右区间的所有的自己会员
      $res = DB::table('vip_huiyuan')->where('id',$id)->first();
      //求出此人的左区间的第一个节点的ID
      $youid = $res['youjiedian'];//这个值有可能不存在说明他的左区间没人
      if($youid=='')
      {
        return back()->with('error','您的二部市场还没有会员');
      }else{
        //他这个会员的路径加上他左节点ID就是要查询的左区间的所有人D的开始路径,把这个路径的所有会员提取出来
        $path = $res['tuipath'].$youid.',';
        $res2 = DB::table('vip_huiyuan')
                ->where('tuipath','like','%'.$path.'%')
                ->paginate(40);
      }
      return view('huiyuanguanli.qujian',['res'=>$res2]);
    }elseif($action=='san'){
      //查询关于此人的右区间的所有的自己会员
      $res = DB::table('vip_huiyuan')->where('id',$id)->first();
      //求出此人的左区间的第一个节点的ID
      $sanid = $res['sanjiedian'];//这个值有可能不存在说明他的左区间没人
      if($sanid=='')
      {
        return back()->with('error','您的三部市场还没有会员');
      }else{
        //他这个会员的路径加上他左节点ID就是要查询的左区间的所有人D的开始路径,把这个路径的所有会员提取出来
        $path = $res['tuipath'].$sanid.',';
        $res3 = DB::table('vip_huiyuan')
                ->where('tuipath','like','%'.$path.'%')
                ->paginate(40);
      }
      return view('huiyuanguanli.qujian',['res'=>$res3]);
    }elseif($action=='outo'){
      //查询这个人的所有信息将三个部门的信息放在一起
      //查询关于此人的左区间的所有的自己会员
      $res = DB::table('vip_huiyuan')->where('id',$id)->first();
      //求出此人的左区间的第一个节点的ID
      $zuoid = $res['zuojiedian'];//这个值有可能不存在说明他的左区间没人
      if($zuoid=='')
      {
        $res1 = [];
      }else{
        //他这个会员的路径加上他左节点ID就是要查询的左区间的所有人D的开始路径,把这个路径的所有会员提取出来
        $path = $res['tuipath'].$zuoid.',';
        $res1 = DB::table('vip_huiyuan')
                ->where('tuipath','like','%'.$path.'%')
                ->get();
      }
      //查询右区间的
       //求出此人的左区间的第一个节点的ID
      $youid = $res['youjiedian'];//这个值有可能不存在说明他的左区间没人
      if($youid=='')
      {
        $res2 = [];
      }else{
        //他这个会员的路径加上他左节点ID就是要查询的左区间的所有人D的开始路径,把这个路径的所有会员提取出来
        $path = $res['tuipath'].$youid.',';
        $res2 = DB::table('vip_huiyuan')
                ->where('tuipath','like','%'.$path.'%')
                ->get();
      }
      //查询三区间的
       $sanid = $res['sanjiedian'];//这个值有可能不存在说明他的左区间没人
      if($sanid=='')
      {
        $res3 = [];
      }else{
        //他这个会员的路径加上他左节点ID就是要查询的左区间的所有人D的开始路径,把这个路径的所有会员提取出来
        $path = $res['tuipath'].$sanid.',';
        $res3 = DB::table('vip_huiyuan')
                ->where('tuipath','like','%'.$path.'%')
                ->get();
      }
      //合并三个区间的数组利用追加的形式
     // array_merge_recursive()
      $aa = array_merge_recursive($res1,$res2,$res3);
      if($aa)
      {
        return view('huiyuanguanli.qujians',['res'=>$aa]);
      }else
      {
        return back()->with('error','此会员还没有发展会员');
      }
      
    }else{
      echo '查询条件有误!';
    }
  }
  //会员单独信息的查询
  public function getAjax(Request $request)
  {
    //接受穿过来的数据
    $name=  $request->input('name');
    $data = DB::table('vip_huiyuan')->where('phone',$name)->first();
    if(count($data)!=0)
    {
       echo json_encode($data); 
   }else{
    echo  1;
   }
    
    // DB::table('vip_huiyuan')->chunk(100, function($vip_huiyuan)use($name){
    //   $data = [];
    //   foreach ($vip_huiyuan as $val) {
    //     //便利判断是否有与要查询的数据是否一致的信息
    //       if($name==$val['name'])
    //       {
    //         $data[] = $val;
    //       }
    //     }
    //     if($data)
    //     {
    //       echo json_encode($data);
    //     }else
    //     {
    //       echo 1;
    //     }
    // });
  }

  //会员的重名字的查看
  public function getChongname()
  {
    $res = DB::select("select * from vip_huiyuan where name in (select name from  vip_huiyuan  group by name having count(name)> 1 )");

    return view('huiyuanguanli.chongname',['res'=>$res]);
  }




  //所有会员的划落(修改数据)  判断他所处的位置
  // public function getListedit($id)
  // {
  //   //将这个人的信息存放到划落表中
  //   $res = DB::table('vip_huiyuan')->where('id',$id)->first();
  //   $ress = $res;
  //   //将此人的信息加入到被划落的会员表中
  //   $data['name'] = $res['name'];
  //   $data['phone'] = $res['phone'];
  //   $data['pass'] = $res['pass'];
  //   $data['address'] = $res['address'];
  //   $data['code'] = $res['code'];
  //   $data['jifen'] = $res['jifen'];
  //   $data['free'] = $res['free'];
  //   $data['zhuceriqi'] = $res['zhuceriqi'];
  //   $data['huiyuanstatus'] = $res['huiyuanstatus'];
  //   $data['firstgoumai'] = $res['firstgoumai'];
  //   $data['zuojiedian'] = 0;
  //   $data['youjiedian'] = 0;
  //   $data['jidian']=3;
  //   $data['status'] =0;
  //   $data['paixuid'] =0;
  //   $data['s'] =0;
  //   $data['fanliriqi'] =null;
  //   $data['fujiedian'] =0;
  //   $data['tuijiedian'] =$res['tuijiedian'];
  //   $data['zhuzuojiedian'] =0;
  //   $data['zhuyoujiedian'] =0;
  //   $data['zuoqujian'] =0;
  //   $data['youqujian'] =0;
  //   //将数据加入到划落表中
  //   $aa = DB::table('vip_huiyuan_hualuo')->insert($data);
  //   //将这个人的原来的数据空位保留
  //   $mm['name'] = '';
  //   $mm['phone'] = '';
  //   $mm['pass']  ='';
  //   $mm['address'] = '';
  //   $mm['code'] = '';
  //   $mm['jifen']=0;
  //   $mm['free']='0.00';
  //   $mm['zhuceriqi'] = '';
  //   $mm['huiyuanstatus'] ='';
  //   $mm['firstgoumai'] = '';

  //   $mm['zuojiedian'] = $res['zuojiedian'];
  //   $mm['youjiedian'] = $res['youjiedian'];
  //   $mm['jidian']=$res['jidian'];
  //   $mm['status'] =$res['status'];
  //   $mm['paixuid'] =$res['paixuid'];
  //   $mm['s'] =1;
  //   $mm['fanliriqi'] =null;
  //   $mm['fujiedian'] =$res['fujiedian'];
  //   $mm['tuijiedian'] =$res['tuijiedian'];
  //   $mm['zhuzuojiedian'] =$res['zhuzuojiedian'];
  //   $mm['zhuyoujiedian'] =$res['zhuyoujiedian'];
  //   $mm['zuoqujian'] =$res['zuoqujian'];
  //   $mm['youqujian'] =$res['youqujian'];
  //   $bb = DB::table('vip_huiyuan')->where('id',$res['id'])->update($mm);
  //   if($aa&&$bb)
  //   {
  //     return redirect('/admin/tuihuiyuan/list')->with('success','划落此会员成功');
  //   }else
  //   {
  //     return back()->with('error','划落此会员失败');
  //   }
  // }

  // //加载某一个会员下面的所有子级会员列表
  // public function getZilist($uid)
  // {
  //   $res = DB::table('vip_huiyuan')->where('tuijiedian',$uid)->orwhere('id',$uid)->where('s',1)->paginate(40);
  //   return view('huiyuanguanli.zilist',['res'=>$res]);
  // }

  public function getEdit(Request $request)
  {
  	//根据用户的id来将信息查询出来
  	$res = DB::table('vip_huiyuan')->where('id',$request->input('id'))->first();



    return view('huiyuanguanli.edits',['res'=>$res]);
  }
  //更换会员信息的修改
  public function getGenghuan(Request $request)
  {
   //接受传过来的信息
    $id = $request->input('id');
    //判断修改的类型
    if($request->input('jidian')==1){
        //修改成新的会员
         //推荐人的账号(手机号)
        $data['phone'] = $request->input('phone');
        //推荐人的姓名
        $data['name'] = $request->input('name');
        //推荐人的密码
        $data['pass'] = md5($request->input('pass'));
        //推荐人的地址
        $data['address'] = $request->input('address');
        //推荐人的推荐码
        $data['code'] = $request->input('phone');
        //推荐人的余额
        $data['free'] = '0.00';
       //推荐的左区间的人数
        $data['zuoqujian'] = $request->input('zuoqujian');
        //推荐人的右区间的人数
        $data['youqujian'] = $request->input('youqujian');
        $data['sanjiedian'] = $request->input('sanjiedian');
        $data['sanqujian'] = $request->input('sanqujian');
        //推荐人区间判断  
        //推荐人的左节点
        $data['zuojiedian'] = $request->input('zuojiedian');
        //推荐人的右节点
        $data['youjiedian'] = $request->input('youjiedian');
        //推荐人的推荐人的节点  顶级的默认推荐人节点默认为0
        $data['tuipath'] = $request->input('tuipath');
        //推荐人的基点区别 
        $data['jidian'] = 2;
        //基点添加的日期
        $data['zhuceriqi'] = date('Y-m-d H:i:s',time());
        //基点会员的状态
        $data['huiyuanstatus'] =1;
        //会员的第一次购买日期
        $data['firstgoumai'] = date('Y-m-d H:i:s',time());
        //会员基点的返利状态
        $data['status'] = 0;
        $data['taiyangbi'] = 0;
        $data['s'] = 1;
        $data['jifen'] = 0;
        $data['fanlileixing'] = 0;
        $data['fanliriqi'] = 0;
        $data['suoshu'] = $request->input('suoshu');
        $data['xiaofei'] = 0;
        $data['money'] = 0;
        $res = DB::table('vip_huiyuan')->where('id',$id)->update($data);
        if($res)
        {
            //将和这个id相关的所有的记录删除  包括返利记录和购买记录
            DB::table('vip_fanlijilu')->where('yid',$id)->delete();
            DB::table('hongri_orders')->where('uid',$id)->delete();
          return redirect('/admin/tuihuiyuan/index')->with('success','更换新会员信息成功');
        }else
        {
          return back()->with('error','更换新会员信息失败');
        }
    }else{
        //修改会员的部分信息
        //判断更换的是什么
        //判断信命是否更改
        $res = DB::table('vip_huiyuan')->where('id',$id)->first();
        if($request->input('name')==''){
            $data['name'] = $res['name'];
        }else{
            $data['name'] = $request->input('name');
        }
         
        //推荐人的姓名
        if($request->input('phone')==''){
            $data['phone'] = $res['phone'];
        }else{
            $data['phone'] = $request->input('phone');
        }
        
        //推荐人的密码
        if($request->input('pass')==''){
            $data['pass'] = $res['pass'];
        }else{
            $data['pass'] = md5($request->input('pass'));
        }
        
        //推荐人的地址
        if($request->input('address')==''){
            $data['address'] = $res['address'];
        }else{
            $data['address'] = $request->input('address');
        }
        

        //推荐人的推荐码
        $data['code'] = $request->input('phone');
        //推荐人的余额
        $data['free'] = $request->input('free');
       //推荐的左区间的人数
        $data['zuoqujian'] = $request->input('zuoqujian');
        //推荐人的右区间的人数
        $data['youqujian'] = $request->input('youqujian');
        $data['sanjiedian'] = $request->input('sanjiedian');
        $data['sanqujian'] = $request->input('sanqujian');
        //推荐人区间判断  
        //推荐人的左节点
        $data['zuojiedian'] = $request->input('zuojiedian');
        //推荐人的右节点
        $data['youjiedian'] = $request->input('youjiedian');
        //推荐人的推荐人的节点  顶级的默认推荐人节点默认为0
        $data['tuipath'] = $request->input('tuipath');
        //推荐人的基点区别 
        $data['jidian'] = $request->input('jidians');
        //基点添加的日期
        $data['zhuceriqi'] = date('Y-m-d H:i:s',time());
        //基点会员的状态
        $data['huiyuanstatus'] =$request->input('huiyuanstatus');
        //会员的第一次购买日期
        $data['firstgoumai'] = $request->input('firstgoumai');
        //会员基点的返利状态
        $data['status'] = $request->input('status');
        $data['taiyangbi'] = $request->input('taiyangbi');
        $data['s'] = 1;
        $data['jifen'] = $request->input('jifen');
        $data['fanlileixing'] = $request->input('fanlileixing');
        $data['fanliriqi'] = $request->input('fanliriqi');
        $data['suoshu'] = $request->input('suoshu');
        $data['xiaofei'] = $request->input('xiaofei');
        $data['money'] = $request->input('money');
        $res = DB::table('vip_huiyuan')->where('id',$id)->update($data);
        if($res)
        {
          return redirect('/admin/tuihuiyuan/index')->with('success','更换会员信息成功');
        }else
        {
          return back()->with('error','更换会员信息失败');
        }
    }
  
  }
  //会员的手动删除 保留其位置  相应的个人数据清空
  public function getDel(Request $request)
  {
    //接受传过来的信息
    $id = $request->input('id');
   //推荐人的账号(手机号)
    $data['phone'] = '';
    //推荐人的姓名
    $data['name'] = '';
    //推荐人的密码
    $data['pass'] = '';
    //推荐人的地址
    $data['address'] = '';
    //推荐人的推荐码
    $data['code'] = '';
    //推荐人的余额
    $data['free'] = '0.00';
    //会员基点的返利状态
    $data['status'] = 0;
    $data['taiyangbi'] = 0;
    $data['s'] = 1;
    $data['jifen'] = 0;
    $data['fanlileixing'] = 0;
    $data['fanliriqi'] = 0;
    $data['xiaofei'] = 0;
    $data['money'] = 0;
    $res = DB::table('vip_huiyuan')->where('id',$id)->update($data);
    if($res)
    {
      return redirect('/admin/tuihuiyuan/index')->with('success','删除会员信息成功');
    }else
    {
      return back()->with('error','删除会员信息失败');
    }
  }


  //会员的划落(短暂的没有激活的账号)
  // public function getDellist()
  // {
  //   $res = DB::table('vip_huiyuan')->where('s',0)->paginate(3);
  //   return view('huiyuanguanli.delist',['res'=>$res]);
  // }


  //进行会员的分配
  // public function getFenpei($id)
  // {
  //   $res = DB::table('vip_huiyuan')->paginate(5);
  //   //获取这个人的信息
  //   $first = DB::table('vip_huiyuan_hualuo')->where('id',$id)->first();
  //   return view('huiyuanguanli.fenpei',['res'=>$res,'first'=>$first]);
  // }
  // //会员信息的查看搜索
  // public function getHuiyuanlist(Request $request)
  // {
  //   //接受信息
  //   $name = $request->input('name');
  //   $res = DB::table('vip_huiyuan')->where('name',$name)->get();
  //   echo json_encode($res);
  // }
  // //会员信息的分配添加
  // public function getFenpeis(Request $request)
  // {
  //   //获取要分配的人的信息
  //   $name = $request->input('name');
  //   //获取要分配人的ID
  //   $id = $request->input('fid');
  //   //获取推荐人的信息
  //   $tuiname = $request->input('click');
  //   //获取推荐人的ID
  //   $tuijiedian = $request->input('id');
  // }
}


