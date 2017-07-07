<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;
class RegisterController extends Controller
{
    public function getIndex(){	//加载用户注册页面
    	return view('home.register');
    }
    public function postIndex(Request $request){	//执行用户的注册
    	$data=$request->except(['_token','msg']);
        //生成随机的登录用户ID 8位数字
    	if(!DB::table('vip_huiyuan')->where('code',$data['code'])->first()) return '推荐码不正确';
    	if(DB::table('vip_huiyuan')->where('phone',$data['phone'])->first()) return '该号码已被注册';
        if(DB::table('hongri_register')->where('phone',$data['phone'])->first()) return '该号码已成功注册';
    	$data['pass']=md5($data['pass']);
        DB::table('hongri_register')->insertGetId($data);
        
    	 return 'do';
    }
    //短信验证码
    public function getAliyun(Request $request)
    {
        $phone = $request->input('phone');
        $code = rand(100000, 999999);
        $config = [
            'app_key'    => '23829723',
            'app_secret' => '662549e447c3e2aca05c530025a7f839',
        ];
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum($phone)
            ->setSmsParam([
                'code' => $code,//这里是验证码  需要放在session中
                'product'=>'新纪元红日会员'
            ])
            ->setSmsFreeSignName('新纪元红日')
            ->setSmsTemplateCode('SMS_67095550');

        $resp = $client->execute($req);
        // dd($resp);
        //$resp->result->model 15733330232
        if($resp->result->model){
            //短信发送成功将验证码返还 给前台
            echo $code;
        }
    }
    //检测有没有注册过
    public function postCeshi(Request $request)
    {
        $phone = $request->input('phone');
        if($phone){
             $res = DB::table('vip_huiyuan')->where('phone',$phone)->first()['id'];
             $bb = DB::table('hongri_register')->where('phone',$phone)->first()['id'];
             if($res||$bb)
            {
                echo 1;
            }
        }
    }
}
