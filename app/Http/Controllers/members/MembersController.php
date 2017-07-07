<?php

namespace App\Http\Controllers\members;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;
//微信支付
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order;
//银联支付
use Omnipay;

class MembersController extends Controller
{   
    //银联支付测试
    public function getYlpay(Request $request)
    {
        //接受充值的参数
        $phone = $request->input('phone');
        $money = $request->input('num')*100;
        $orderid = date('YmdHis');
        $gateway = Omnipay::gateway('unionpay');
        $order = [
            'orderId' => $orderid ,
            'txnTime' => date('YmdHis'),
            'orderDesc' => '红日太阳币充值', //订单名称
            'txnAmt' => $money, //订单价格
        ];

        $data['out_trade_no']  =$orderid;
        //获取充值的金额
        $data['money']=$money;
        //获取充值的手机号
        $data['phone'] = $phone;
        $data['time'] = date('Y-m-d H:i:s',time());
        //支付的类型
        $data['code'] = '银联支付';
        //支付的初始的状态
        $data['status'] = 1;
        DB::table('vip_zhifu')->insert($data);
        $response = $gateway->purchase($order)->send();
        $response->redirect();
    }

    //支付宝支付
    public function getZpy(Request $request)
    {
        $phone = $request->input('phone');
        $money = $request->input('num');
        $order_id = date('YmdHis',time()).$phone.'888';
        // 创建支付单。
        $alipay = app('alipay.web');
        $alipay->setOutTradeNo($order_id);
        $alipay->setTotalFee($money);
        $alipay->setSubject('新纪元红日');
        $alipay->setBody('新纪元红日');
        
        // $alipay->setQrPayMode('5'); //该设置为可选，添加该参数设置，支持二维码支付。
        //获取产生的编号
        $data['out_trade_no']  =$order_id;
        //获取充值的金额
        $data['money']=$money;
        //获取充值的手机号
        $data['phone'] = $phone;
        //充值的名称
        $pay['body'] = '北京新纪元红日太阳币';
        //在这里将数据插入到数据库中
        $data['time'] = date('Y-m-d H:i:s',time());
        //支付的类型
        $data['code'] = '支付宝支付';
        //支付的初始的状态
        $data['status'] = 1;
        DB::table('vip_zhifu')->insert($data);
        return redirect()->to($alipay->getPayLink());
    }
    public function getIndex(){
        // $res = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->first();
        //获取文本的内容
        $res = file_get_contents(session('hr_member')['id'].'.txt');
        $res = json_decode($res,1);
        //求取这个人的返利每日金额
        $fanli = DB::table('vip_fldw')->where('fanliid',session('hr_member')['fanlileixing'])->first();
        //求取当前人的提现的数据
        $tixian = DB::table('vip_tx')->where('yid',session('hr_member')['id'])->where('status',1)->get();
        $jine = '0.00';
        foreach($tixian as $v){
            $jine+=$v['txjin'];
        }
        $jine = $jine;
    	return view('home.usercenter.dir',['res'=>$res,'txjin'=>$jine,'fanli'=>$fanli]);
    }
    public function getChangepass(){	//加载修改密码页面
    	return view('home.usercenter.changepass');
    }
    public function postChangepass(Request $request){	//执行密码修改
    	$data=$request->only(['old_pass','pass']);
    	$old_pass=DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->first()['pass'];
    	if($old_pass!=md5($data['old_pass'])) return '原密码错误';
    	if(DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->update(['pass'=>md5($data['pass'])])){
    		return 'do';
    	}else{
    		return "修改密码失败";
    	}
    }
    public function getDir(){   //加载目录界面重定向到登录页面
        //加载这个人的信息
        //重新获取这个人的详细信息
        $res = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->first();
        //将新的信息加入到session中
        session(['hr_member'=>$res]);
        //求取这个人的返利每日金额
        $fanli = DB::table('vip_fldw')->where('fanliid',session('hr_member')['fanlileixing'])->first();
        //求取当前人的提现的数据
        $tixian = DB::table('vip_tx')->where('yid',session('hr_member')['id'])->where('status',1)->get();
        $jine = '0.00';
        foreach($tixian as $v){
            $jine+=$v['txjin'];
        }
        $jine = $jine;
        return view('home.usercenter.dir',['res'=>$res,'txjin'=>$jine,'fanli'=>$fanli]);
    }
    public function getChangecustomer()
    {
        //根据session中的ID来请求这个人的所有数据
        // $pathurl = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->first()['tuipath'];
        $res = file_get_contents(session('hr_member')['id'].'.txt');
        $pathurl = json_decode($res,1)['tuipath'];
        //根据路径将他所有的下属会员查询出来
        $res = DB::table('vip_huiyuan')->where('tuipath','like','%'.$pathurl.'%')->paginate(10);

        //求取这个人的第一个人的左右节点
        $path = explode(',',$pathurl)[0].',';
        $dingjihuiyuan = DB::table('vip_huiyuan')->where('tuipath',$path)->first();
        return view('home.usercenter.huiyuanliebiao',['res'=>$res,'ding'=>$dingjihuiyuan]);
    }
    //分配页面的查询会员姓名
    public function postSousuo(Request $request){
        $name = $request->input('name');
        //查询会员表显示当前用户的信息
        // $tiaojian = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->first()['tuipath'];
        $res = file_get_contents(session('hr_member')['id'].'.txt');
        $tiaojian = json_decode($res,1)['tuipath'];
        $res = DB::table('vip_huiyuan')->where('name',$name)->where('tuipath','like','%'.$tiaojian.'%')->select("vip_huiyuan.xiaofei",'vip_huiyuan.id','vip_huiyuan.name','vip_huiyuan.phone','vip_huiyuan.zuoqujian','vip_huiyuan.youqujian','vip_huiyuan.sanqujian','vip_huiyuan.zuojiedian','vip_huiyuan.youjiedian','vip_huiyuan.sanjiedian','vip_huiyuan.tuipath')->first();
        if($res){
            echo json_encode($res);
        }else{
            echo 1;
        }
        
    }
    //点击查看会员部门的下属
    public function postQujian(Request $request)
    {
        //接受传过来的参数
        $qujianid = $request->input('oid');
        $id = $request->input('id');
        $path = DB::table('vip_huiyuan')->where('id',$id)->first();

        if($qujianid==1){
            //查询这个人的左区间
            //左区间
            $pathurl = $path['tuipath'].$path['zuojiedian'].',';
            $res = DB::table('vip_huiyuan')->where('tuipath','like','%'.$pathurl.'%')->get();
        }else if($qujianid==2){
            //查询这个人的右区间
            $pathurl = $path['tuipath'].$path['youjiedian'].',';
            $res = DB::table('vip_huiyuan')->where('tuipath','like','%'.$pathurl.'%')->get();
        }else if($qujianid==3){
            //查询这个人的三区间
            $pathurl = $path['tuipath'].$path['sanjiedian'].',';
            $res = DB::table('vip_huiyuan')->where('tuipath','like','%'.$pathurl.'%')->get();
        }else if($qujianid==4){
            //查询这个人的全部信息
            $res = DB::table('vip_huiyuan')->where('tuipath','like','%'.$path['tuipath'].'%')->get();
        }
        if($res){
            echo json_encode($res);
        }else{
            echo 1;
        }
    }
    //添加下属会员信息的分配
    public function getAddcustomer($id)
    {
        $ids = DB::table('vip_huiyuan')->where('id',$id)->first();
        $res = DB::table('hongri_register')->where('code',session('hr_member')['code'])->get();
        // dd($res);
        return view('home.usercenter.huiyuanliebiao_2',['res'=>$res,'id'=>$ids]);
    }
    public function postAjax(Request $request)
    {
       $fid =  $request->input('fid');
       $id =  $request->input('id');
       $bumen =  $request->input('bumen');
       //根据传过来的数据来进行数据的分配
       /*
        1.查询被分配的人的注册信息
        2.查询当前登录人的信息
        3.查询当前分配人的信息
       */
        $zhuce = DB::table('hongri_register')->where('id',$fid)->first();
        $fenpei = DB::table('vip_huiyuan')->where('id',$id)->first();

        $data['phone'] = $zhuce['phone'];
        $data['pass'] = $zhuce['pass'];
        //会员的姓名
        $data['name'] = $zhuce['shenfenzheng'];
        //会员的地址
        $data['address'] = '';
        //推荐人的推荐码
        $data['code'] = $zhuce['phone'];
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
        //会员的注册日期就是会员的分配日期
        $data['zhuceriqi'] = date('Y-m-d H:i:s',time());
        //会员的购买日期
        $data['firstgoumai'] = date('Y-m-d H:i:s',time()+7*24*3600);
        //会员所从属的人员
        $data['suoshu'] = session('hr_member')['id'];
        //是否划落的标志默认为1
        $data['s'] = 1;
        //会员拥有的性质
        $data['jidian'] = 3;
        //会员基点的返利状态
        $data['status'] = 0;
        //基点会员的状态表示是否进行了消费0没有消费1消费
        $data['huiyuanstatus'] =0;
        $ids = session('hr_member')['id'];//这个是登录人的ID
        //判断这个人的左右节点是否已经满了
//进行数据的分配
DB::transaction(function ()use($data,$ids,$bumen,$fenpei,$fid) {
    $true = '';
        if($bumen==1){
            if($fenpei['zuojiedian']!=''&&$fenpei['zuojiedian']!=0){
                echo "左节点已满选择失败";
            }else{
                //将人添加到数据库中
                $id = DB::table('vip_huiyuan')->insertGetId($data);
                //获取他的上一级的会员的路径变为当前会员的推荐路径
                $pathurl = $fenpei['tuipath'].$id.',';
                //这个会员的所在推荐路径加入到数据库中
                DB::table('vip_huiyuan')->where('id',$id)->update(['tuipath'=>$pathurl]);
                //同时把他的上级的左节点进行修改
                $true = DB::table('vip_huiyuan')->where('id',$fenpei['id'])->update(['zuojiedian'=>$id]);
            }
        }elseif($bumen==2){
            if($fenpei['youjiedian']!=''&&$fenpei['youjiedian']!=0){
                echo "右节点已满选择失败";
            }else{
                //将人添加到数据库中
                $id = DB::table('vip_huiyuan')->insertGetId($data);
                //获取他的上一级的会员的路径变为当前会员的推荐路径
                $pathurl = $fenpei['tuipath'].$id.',';
                //这个会员的所在推荐路径加入到数据库中
                DB::table('vip_huiyuan')->where('id',$id)->update(['tuipath'=>$pathurl]);
                //同时把他的上级的左节点进行修改
                $true = DB::table('vip_huiyuan')->where('id',$fenpei['id'])->update(['youjiedian'=>$id]);
            }
        }elseif($bumen==3){
            if($fenpei['sanjiedian']!=''&&$fenpei['sanjiedian']!=0){
                echo "三节点已满选择失败";
            }else{
                //将人添加到数据库中
                $id = DB::table('vip_huiyuan')->insertGetId($data);
                //获取他的上一级的会员的路径变为当前会员的推荐路径
                $pathurl = $fenpei['tuipath'].$id.',';
                //这个会员的所在推荐路径加入到数据库中
                DB::table('vip_huiyuan')->where('id',$id)->update(['tuipath'=>$pathurl]);
                //同时把他的上级的左节点进行修改
                $true = DB::table('vip_huiyuan')->where('id',$fenpei['id'])->update(['sanjiedian'=>$id]);
            }
        }else{
            echo  "系统错误";
        }

        if($true){
            //正确添加会员的基础上进行这一条线上的所有数据的修改
            $arr = explode(',',$pathurl);
            $num = count($arr)-1;//数组的个数
            //循环进行字符的截取修改
            for($i=1;$i<=$num;$i++){
                $firstid = array_slice($arr,0,$i);
                $secondif = array_slice($arr,0,$i+1);
                //合并数组形成字符串
              $str = implode(',',$firstid);
              $str = $str.',';
              $str1 = implode(',',$secondif);
              $str1 = $str1.',';
              //根据这个$str来精确查找数据 将所有数据加1
              $bb = DB::table('vip_huiyuan')->where('tuipath',$str)->first();
              $bb1 = DB::table('vip_huiyuan')->where('tuipath',$str1)->first();
              if(count($bb1)!=0){
                //判断str1这个会员时str这个会员的那个区间的人就相应的把str的相应区间人数加1
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
            if($cc){
                //当修改数据也成功时清除注册表中的信息
                DB::table('hongri_register')->where('id',$fid)->delete();
                echo '分配会员成功';
            }else{
               DB::rollBack(); 
               echo '分配会员失败';
            }
        }else{
            DB::rollBack();
            echo '分配会员失败';
        }
});
    }
    public function getCustomer(){  //加载客户界面  进行相应的用户的查询
        $first = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->first();
        return view('home.usercenter.customer',['res'=>$first]);
    }
    //轮流查询当前人的所有的子集会员
    public function getLunxun(Request $request)
    {
        $id = $request->input('id');
        //查询和我有关的所有的一级会员
        DB::table('vip_huiyuan')->where('suoshu',$id)->where('s',1)->chunk(100,function($user){
           echo json_encode($user); 

        });
        // $res = DB::table('vip_huiyuan')->where('suoshu',$id)->where('s',1)->get();
    }
    //详细的个人信息的查询
    public function getGeren(Request $request)
    {
        $id = $request->input('id');
        $res = DB::table('vip_huiyuan')->where('id',$id)->first();
        echo json_encode($res);

    }
    //搜索查询个人的信息
    public function getXinxi(Request $request)
    {
        $name = $request->input('name');
        $res = DB::table('vip_huiyuan')->where('phone',$name)->first();
        if($res)
        {
            echo json_encode($res);
        }else{
            echo 2;
        }
    }

    public function getInfo(){  //加载个人资料添加界面
        // $res = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->first();
        $res = file_get_contents(session('hr_member')['id'].'.txt');
        $res = json_decode($res,1);
        return view('home.usercenter.info',['res'=>$res]);
    }
    public function postInfo(Request $request){ //执行个人资料修改
        // $flag=DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->first();
        $res = file_get_contents(session('hr_member')['id'].'.txt');
        $flag = json_decode($res,1);
        $data=$request->except('_token');
        if($flag){
            $res=DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->update($data);
        }else{
            $data['id']=session('hr_member')['id'];
            $res=DB::table('vip_huiyuan')->insert($data);
        }
        if($res){
             $flag=DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->first();
            //更改session的数据
            session(['hr_member'=>$flag]);
            //更新文本
            $flag = json_encode($flag);
            file_put_contents(session('hr_member')['id'].'.txt',$flag);
            return redirect('/members/info')->with('success','个人资料修改成功');
        }else{
            return back()->with('error','个人资料修改失败');
        }
    }
    public function getBindcard(){  //加载绑定银行卡界面
        return view('home.usercenter.bindcard');
    }
    public function postBindcard(Request $request){ //执行银行卡绑定
        //接受传过来的信息将数据保存到数据库
        $data = $request->except('_token');
        $data['yid'] = session('hr_member')['id'];
        //查询是否已经绑定了银行卡 如果绑定了就不允许在绑定
        $true = DB::table('vip_bank')->where('yid',session('hr_member')['id'])->first();
        if(!$true){
            $res = DB::table('vip_bank')->insert($data);
            if($res){
                //将正确的数据放在session当中节约更改银行卡时查询数据库
                session(['card'=>$data]);
                echo  '绑定成功';
            }else{
                echo '绑定失败';
            }
        }else{
            echo  '您已经绑定银行卡了';
        }
        
    }
    public function getChangecard(){    //加载更换银行卡界面
        $res = DB::table('vip_bank')->where('yid',session('hr_member')['id'])->first();
        return view('home.usercenter.changecard',['res'=>$res]);
    }
    public function postChangecard(Request $request){   //执行银行卡更换
         //接受传过来的信息将数据保存到数据库
        $data = $request->except('_token');
        $data['yid'] = session('hr_member')['id'];
		
        $id=$data['tid'];
		if($id)
		{
			$res = DB::table('vip_bank')->where('tid',$id)->update($data);
			if($res){
				//将正确的数据放在session当中节约更改银行卡时查询数据库
				session(['card'=>$data]);
				echo  '修改成功';
			}else{
				echo '修改失败';
			}
		}else{
			$res = DB::table('vip_bank')->where('yid',session('hr_member')['id'])->insert($data);
			if($res){
				//将正确的数据放在session当中节约更改银行卡时查询数据库
				session(['card'=>$data]);
				echo  '修改成功';
			}else{
				echo '修改失败';
			}			
		}
        
    }
    public function getPointmove(){ //加载积分赠送界面
        $res = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->first()['jifen'];
        return view('home.usercenter.point_move',['res'=>$res]);
    }
    public function postPointmove(Request $request){    //执行积分赠送
DB::transaction(function ()use($request) {        
        $data=$request->except('_token');
        if(!DB::table('vip_huiyuan')->where('id',$data['toid'])->first()){
             DB::rollBack(); 
             echo  '受赠人不存在';
        }
        //判断
        $flag=$data['amount'];
        DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->decrement('jifen',$flag);
        DB::table('vip_huiyuan')->where('id',$data['toid'])->increment('jifen',$flag);

        $temp=DB::table('hongri_points')->where('ownerid',session('hr_member')['id'])->where('amount','>','0')->orderBy('end_time','asc')->get();
        // dd($temp);
        foreach($temp as $k=>$v){
            if($flag<=0){
                echo 'do';
                exit;
            }

            $insert=$out_record=DB::table('hongri_points')->where('id',$v['id'])->select('amount','start_time','end_time')->first();
            $insert['ownerid']=$data['toid'];
            $insert['from']='ID为'.$v['ownerid'].'用户赠送';
            $insert['start_time'] =date('Y-m-d',time());
            $out_record['ownerid']=$v['ownerid'];
            $out_record['to']='赠送给ID为'.$data['toid'].'的用户';
            if($flag>$v['amount']){
                $a = DB::table('hongri_points')->where('id',$v['id'])->delete();  //该条积分全部转增出去,删除该条数据
               $b = DB::table('hongri_points')->insert($insert);    //增加一条受赠数据
                $out_record['amount']='-'.$v['amount'];
               $c =  DB::table('hongri_points')->insert($out_record);    //增加一条积分转出记录

            }else{
                $a =DB::table('hongri_points')->where('id',$v['id'])->decrement('amount',$flag);    //该条积分转赠除部分,递减积分数额
                $insert['amount']=$flag;
               $b = DB::table('hongri_points')->insert($insert);    //增加一条受赠数据
                $out_record['amount']='-'.$flag;
               $c =  DB::table('hongri_points')->insert($out_record);    //增加一条积分转出记录
            }
            $flag-=$v['amount'];
        }

        if(($a == $b) &&($a==$c)){
            echo  'do';
        }else{
            DB::rollBack();
            echo '赠送积分失败';
        }
});
    }
    public function getCash(){  //加载提现界面
        // $free = json_decode(file_get_contents(session('hr_member')['id'].'.txt'),true);
        $free = DB::table('vip_huiyuan')->where('phone',session('hr_member')['phone'])->first();
        $res = DB::table('vip_bank')->where('yid',session('hr_member')['id'])->first();
        return view('home.usercenter.cash',['res'=>$free,'bank'=>$res]);
    }
    public function postCashs(Request $request){ //执行提现
        //接受传过来的数据
        $data['txjin'] =$request->input('txjin');
        //判断提现的金额是否满足最低的要求
        $money = DB::table('vip_tixian_yaoqiu')->first();
        if($data['txjin']<$money['zuidimoney'])
        {
            echo 3;
        }else{
            //接受这个人的id
        $data['yid'] = session('hr_member')['id'];
        //提现的时间
        $data['time'] = date('Y-m-d H:i:s',time());
        //工单的状态默认是没有被审批
        $data['status'] = 1;
        //判断这个人是否已经填写了身份证信息
        $first = DB::table('vip_bank')->where('yid',session('hr_member')['id'])->first()['shenfenzheng'];
        if($first){
            //申请的工单写入到数据库中
            $res = DB::table('vip_tx')->insert($data);
            if($res){
                //修改session中的数据
                $a = session('hr_member')['free']-$data['txjin'];
                //将数据写在文本当中
                $res1 = file_get_contents(session('hr_member')['id'].'.txt');
                $res1 = json_decode($res1,true);
                $res1['free'] = $a;
                $res1 = json_encode($res1);
                file_put_contents(session('hr_member')['id'].'.txt', $res1);
                echo '1';
            }else{
                echo '2';
            }
        }else{
            echo 4;
        }
        }
        
    }
    public function getAccountflow(){   //查看账目流水
        $time = time()-3600*24*30;
       
        $data = DB::table('vip_tx')->where('yid',session('hr_member')['id'])->paginate(5);
        $text = file_get_contents(session('hr_member')['id'].'.txt');
        $text = json_decode($text,1);
        
        return view('home.usercenter.account_flow',['res'=>$data,'text'=>$text]);
    }


    public function getTest(){
        $temp=DB::table('hongri_points')->where('ownerid',session('hr_member')['id'])->orderBy('end_time','desc')->get();
        dd($temp);
        // DB::table('hongri_points')->where('ownerid',session('hr_member')['id'])->orderBy('')->decrement('amount',$data['amount']);
    }


    //充值太阳币页面加载
    public function getChongzhi()
    {
    	return view('home.usercenter.chongzhitaiyangbi');
    }
    //加载充值中心的页面
    public function getChongzhizhongxin(Request $request)
    {
        $phone = $request->input('phone');
        $money = $request->input('money');
        return  view('home.usercenter.chongzhizhongxin',['phone'=>$phone,'money'=>$money]);
    }
    //太阳币的充值
    public function postPay(Request $request)
    {
        //将要充值的钱数
        $num = $request->input('num')*100;
        $data['phone'] = $phone = $request->input('phone');
        //查询要充值的手机号是否存在
        $first = DB::table('vip_huiyuan')->where('phone',$data['phone'])->first();
        if($first){
            //商品的随机的编号 28位
            $out_trade_no = date('YmdHis').$phone.'018';
            // dd($out_trade_no);   2017051618142815176623559018
            $options = [
                    'debug'     => true,
                    'app_id'    => 'wxa1b8b90c8ce5b600',
                    'secret'    => '29a88917f84c122df70beee8dd34ccca',
                    // 'token'     => '7GtE4gFkmrkNHLtCpyfJ',

                    'payment' => [
                    'merchant_id'        => '1471348602',
                    'key'                => 'ae2MJeCexWg82w6DMc32A90RgwKv9n0v',
                    ],
                ];

            $app = new Application($options);

            $payment = $app->payment;
            
            $attributes = [
                    'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
                    'body'             => '北京新纪元红日太阳币',
                    'detail'           => '北京新纪元红日太阳币',
                    'out_trade_no'     => $out_trade_no,
                    'total_fee'        => $num, // 单位：分
                    'notify_url'       => 'http://vip.xinjiyuanhr.com/order/index', //这里的回调地址需要在csrf验证中排除
                ];
            $order = new Order($attributes);
            $result = $payment->prepare($order);

            if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
                //将需要的数据返回到前台的首页
                //获取产生二维码的数据
                $pay['code_url']=$result->code_url;
                //获取产生的编号
                $data['out_trade_no'] = $pay['out_trade_no'] =$out_trade_no;
                //获取充值的金额
                $pay['total_fee']=$num/100;
                //获取充值的手机号
                $pay['phone'] = $phone;
                //充值的名称
                $pay['body'] = '北京新纪元红日太阳币';
                //在这里将数据插入到数据库中
                $data['time'] = date('Y-m-d H:i:s',time());
                //支付的类型
                $data['code'] = '微信支付';
                //支付的初始的状态
                $data['status'] = 1;
		$data['money'] = $num/100;
                DB::table('vip_zhifu')->insert($data);
                // echo json_encode($pay);
                echo json_encode($pay); 
            }else{
                 echojson_encode(2); 
            }
        }else{
            echo json_encode(3); 
        }
    }
    
    //兑换太阳币页面加载
    public function getDuihuan()
    {
        return  view('home.usercenter.yongjin');
    }

    public function getDuihuans(Request $request)
    {
        $data['phone'] = $request->input('phone');
        $data['money'] = $request->input('money');
        $data['time'] = date('Y-m-d H:i:s',time());
        //讲数据加入到数据库并相应的减少这个人的佣金增加他的太阳币
        $res = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->first();
        if($res['free']>=$data['money'])
        {
            //进行相应的佣金的减少  太阳币的增加
            $a = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->increment('taiyangbi',$data['money']);
            $b = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->decrement('free',$data['money']);
            //将记录加入到数据库中
            $c = DB::table('vip_taiyangbiduihuan')->insert($data);
            if($c){
                echo 1;
            }else{
                echo 3;
            }

        }else{
            echo 2;//说明要兑换的太阳币比佣金多无法进行兑换
        }
    }
    //进行用户的代替支付
    public function postTipay(Request $request)
    {
        $otherid = $request->input('otherid');
        $myid = session('hr_member')['id'];
        //默认只能代替购买一个月的物品
        //获取默认的地址
        $address = DB::table('hongri_receiver')->where('uid',$myid)->where('status',1)->first();
        $data['ocode'] = date("YmdHis",time()).rand(000000,999999);//订单编号
        $data['uid'] = $address['uid'];
        $data['total'] = 900;
        $data['usepoints'] = 0;
        $data['points'] = 0;
        $data['replace'] = 0;
        $data['receiver'] = $address['name'];
        $data['address'] = $address['uid'];
        $data['phone'] = $address['phone'];
        $data['code'] = $address['code'];
        $data['status'] = 1;
        $data['ordertime'] = date('Y-m-d H:i:s',time());
        $data['paytime'] = date('Y-m-d H:i:s',time());
        $data['expresscode'] = '';//快递单号
        $data['result'] = '30';
        $data['display'] = 1;
       	//查询商品表和商品的分类详情表 随机区的一件一个月的商品来进行填充
       	$good = DB::table('hongri_products')
       			->join('hongri_product_property','hongri_products.id','=','hongri_product_property.pid')
       			->where('hongri_product_property.property','1套')
       			->get();
       
       	$num = count($good);
       	//随机选取一个数组
       	$num = rand(0,$num-1);
       	//将随机选的商品加入到下单的表格当中
       	$goods['ocode'] = $data['ocode'];
       	$goods['name'] = $good[$num]['name'];
       	$goods['subname'] = $good[$num]['subname'];
       	$goods['property'] = $good[$num]['property'];
       	$goods['gid'] = $good[$num]['pid'];
       	$goods['property_number'] = $good[$num]['number'];
       	$goods['price'] = $good[$num]['price'];
       	$goods['amount'] = 1;
       	$goods['pic'] = $good[$num]['pic'];
        //减少此人的太阳币的数量
        //判断此人的太阳币是否足够
        $t = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->first();
        if($t['taiyangbi']>=900){
        	 //将此信息加入到数据库中并减少相应的此人的太阳币 增加购买者的消费时间
        	$res = DB::table('hongri_orders')->insert($data);
        	$res = DB::table('hongri_order_detail')->insert($goods);
            $a = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->decrement('taiyangbi',900);
            //增加此人的消费总额
            $a = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->increment('money',900);
            //查询代替支付的人的时间信息
            $times = DB::table('vip_huiyuan')->where('id',$otherid)->first()['firstgoumai'];
            if(strtotime($times)>time())
            {
            	//时间大于当前时间  再原有的基础上增加
            	$time = date('Y-m-d H:i:s',strtotime($times)+3600*24*30);
            }else{
            	//时间小于当前的时间  以现在的时间为基础
            	 $time = date('Y-m-d H:i:s',time()+3600*24*30);
            }
            //增加被代替的人的持续时间
            $b = DB::table('vip_huiyuan')->where('id',$otherid)->update(['firstgoumai'=>$time,'xiaofei'=>1]);
            if($a&&$b)
            {
                echo  1;
            }else{
                echo 3;
            }
        }else{
            echo 2;
        }
    }
    //转账太阳币
    public function getZhuanzhang()
    {
        return  view('home.usercenter.zhuanzhang');
    }
    public function getZhuanzhangjilu()
    {
        //需要分页处理
        $res = DB::table('vip_zhuanzhang')
                ->join('vip_huiyuan','vip_huiyuan.phone','=','vip_zhuanzhang.phone')
                ->where('vip_zhuanzhang.phone',session('hr_member')['phone'])
                ->orWhere('vip_zhuanzhang.otherphone',session('hr_member')['phone'])
                ->select('vip_zhuanzhang.time','vip_zhuanzhang.money','vip_zhuanzhang.othername','vip_huiyuan.name')
                ->paginate(10);
       //这里是转账记录的页面
        // $res = DB::table('vip_zhuanzhang')
        //         ->where('phone',session('hr_member')['phone'])
        //         ->orwhere('otherphone',session('hr_member')['phone'])
        //         ->paginate(10);
        return  view('home.usercenter.zhuanzhangjilu',['res'=>$res]);
    }
    public function getTikuanjilu()
    {
        //需要分页处理
        $res = DB::table('vip_tx')->where('yid',session('hr_member')['id'])->paginate(10);
        return  view('home.usercenter.tikuanjilu',['res'=>$res]);
    }
    public function getGoumaijilu()
    {
        //需要分页处理
        $res = DB::table('hongri_orders')
                ->join('hongri_order_detail','hongri_order_detail.ocode','=','hongri_orders.ocode')
                ->where('uid',session('hr_member')['id'])
                ->where('display',1)
                ->where('status',1)
                ->paginate(10);
        return  view('home.usercenter.goumaijilu',['res'=>$res]);
    }
    public function getFanlijilu()
    {
        //需要分页处理
        $res = DB::table('vip_huiyuan')
                ->join('vip_fanlijilu','vip_fanlijilu.yid','=','vip_huiyuan.id')
                ->where('vip_huiyuan.id',session('hr_member')['id'])
                ->paginate(10);

        $zhiwei = DB::table('vip_huiyuan')
                ->join('vip_fldw','vip_fldw.fanliid','=','vip_huiyuan.fanlileixing')
                ->first();
        return  view('home.usercenter.fanlijilu',['res'=>$res,'zhiwei'=>$zhiwei]);
    }
    public function  getZhuanzhangtrue(Request $request)
    {
        //接受信息加入到数据库中
        //查询判断转账的账号是否存在
        $otherphone = $request->input('otherphone');
        $othername = $request->input('othername');
        //转账人的手机号
        $phone = $request->input('phone');
        $first = DB::table('vip_huiyuan')->where('phone',$otherphone)->where('name',$othername)->first();
        if($first){
            //转账的时间
            $data = $request->all();
            $data['time'] = date('Y-m-d H:i:s',time());
            
            //将当前人的太阳币进行相应的减少
            $money = $request->input('money');
            $taiyangbi = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->first();
            if($taiyangbi['taiyangbi']>=$money){
                $s = DB::table('vip_huiyuan')->where('id',session('hr_member')['id'])->decrement('taiyangbi',$money);

                DB::table('vip_huiyuan')->where('id',$first['id'])->increment('taiyangbi',$money);
                $res = DB::table('vip_zhuanzhang')->insert($data);//生成转账人的数据
                if($s)
                {
                    echo 1;
                }else{
                    echo 4;
                }
            }else{
                echo 3;
            }
        }else{
            //说明这个人不存在转账失败
            echo 2;
        }
    }

    //短信验证码

    public function getCode(Request $request)
    {
        $phone = $request->input('phone');
        $money = $request->input('money');
        $name = $request->input('name');
        $code = rand(100000, 999999);
        $time = date('Y-m-d H:i:s',time());
        $config = [
            'app_key'    => '23829723',
            'app_secret' => '662549e447c3e2aca05c530025a7f839',
        ];
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum($phone)
            ->setSmsParam([
                'code' => $code,//这里是验证码  需要放在session中
                'name'=>$name,
                'money'=>$money,
                'time'=>$time
            ])
            ->setSmsFreeSignName('新纪元红日')
            ->setSmsTemplateCode('SMS_67105873');

        $resp = $client->execute($req);
        if($resp->result->model){
            //短信发送成功将验证码返还 给前台
            echo $code;
        }
    }
    public function getCodes(Request $request)
    {
        $phone = $request->input('phone');
        $money = $request->input('money');
        $code = rand(100000, 999999);
        $time = date('Y-m-d H:i:s',time());
        $config = [
            'app_key'    => '23829723',
            'app_secret' => '662549e447c3e2aca05c530025a7f839',
        ];
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum($phone)
            ->setSmsParam([
                'code' => $code,//这里是验证码  需要放在session中
                'money'=>$money,
                'time'=>$time
            ])
            ->setSmsFreeSignName('新纪元红日')
            ->setSmsTemplateCode('SMS_68230225');

        $resp = $client->execute($req);
        if($resp->result->model){
            //短信发送成功将验证码返还 给前台
            echo $code;
        }
    }
    //充值成功的轮询
    public function getResult(Request $request)
    {
        $outid = $request->input('outid');
        $res = DB::table('vip_zhifu')->where('out_trade_no',$outid)->first()['status'];
        if($res==2){
            echo 1;
        }elseif($res==3&&$res!=1){
            echo 2;
        }
    }
    //加载得是用户的充值记录的也页面
    public function getChongzhijilu(Request $request){
    	$res = DB::table('vip_zhifu')->where('phone',session('hr_member')['phone'])->where('status',2)->paginate(10);
        return view('home.usercenter.chongzhijilu',['res'=>$res]);
    }
}
