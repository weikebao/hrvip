<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use EasyWeChat\Foundation\Application;
use ZPY;
use Omnipay;
class HuiUrlController extends Controller
{
    public function postIndex(){	//这里是微信充值的回调路径信息
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
		
		$response = $app->payment->handleNotify(function($notify, $successful){
			//这里书写逻辑将充值成功的消息再返还给用户
			//修改用户的数据库  根据微信的订单的号的唯一性
			$out_trade_no = $notify->out_trade_no;
			//根据订单的编号来修改相应的状态
			$true = DB::table('vip_zhifu')->where('out_trade_no',$out_trade_no)->where('status',1)->first();
			if($true){
				DB::table('vip_zhifu')->where('out_trade_no',$out_trade_no)->update(['status'=>2]);
				//获取充值的手机号
				$phone = $true['phone'];
				//充值的金额
				$money = $true['money'];//将分换为元
				$tyb = floor($money);
				// file_put_contents('tyb.txt', $tyb);
				//根据手机号来修改用户的总的太阳币个数  一元=一个太阳币
				DB::table('vip_huiyuan')->where('phone',$phone)->increment('taiyangbi',$tyb);
			}
		});
    }
    //这个是支付宝的回调路径
    public  function getPay(Request $request)
    {
		//获取订单的编号
		//http://www.hongri.com/order/pay?body=%E6%96%B0%E7%BA%AA%E5%85%83%E7%BA%A2%E6%97%A5&buyer_email=15176623559&buyer_id=2088502825714130&exterface=create_direct_pay_by_user&is_success=T&notify_id=RqPnCoPT3K9%252Fvwbh3InYzNWzL0kYd%252FhA1lZvQu%252FvGmr49bM8CwvyXhPM9dh1%252Bk2ealBJ&notify_time=2017-05-26+16%3A34%3A47&notify_type=trade_status_sync&out_trade_no=2017052616374015176623559888&payment_type=1&seller_email=xinjiyuanhongri%40163.com&seller_id=2088621981456451&subject=%E6%96%B0%E7%BA%AA%E5%85%83%E7%BA%A2%E6%97%A5&total_fee=0.01&trade_no=2017052621001004130228464453&trade_status=TRADE_SUCCESS&sign=a215aa074826ded1cab81ee9640280c8&sign_type=MD5
		//判断支付是否成功
		if($request->input('is_success')=='T')
		{
			$out_trade_no = $request->input('out_trade_no');
			//根据订单的编号来修改相应的状态
			$true = DB::table('vip_zhifu')->where('out_trade_no',$out_trade_no)->where('status',1)->first();
			if($true){
				DB::table('vip_zhifu')->where('out_trade_no',$out_trade_no)->update(['status'=>2]);
				//获取充值的手机号
				$phone = $true['phone'];
				//充值的金额
				$money = $true['money'];//默认为元
				$tyb = floor($money);
				//根据手机号来修改用户的总的太阳币个数  一元=一个太阳币
				DB::table('vip_huiyuan')->where('phone',$phone)->increment('taiyangbi',$tyb);
				return redirect('/members/dir');
			}
		}else{
			return redirect('/members/chongzhitaiyangbi');
		}
			
	
    }
    public  function postPays()
    {
    }
    //银联支付成功的返回路径
    public function getYinlianhoutais(Request $request)
    {	
	   dd(11);
    }
    public function postYinlianhoutais(Request $request)
    {
    	$gateway = Omnipay::gateway('unionpay');
	    $response = $gateway->completePurchase(['request_params'=>$_REQUEST])->send();
	    if ($response->isPaid()) {
	        $orderid = $request->input('orderId');
	        //根据订单的id来将相应的数据进行修改
	        $true = DB::table('vip_zhifu')->where('out_trade_no',$orderid)->first();
			if($true){
				DB::table('vip_zhifu')->where('out_trade_no',$orderid)->update(['status'=>2]);
				//获取充值的手机号
				$phone = $true['phone'];
				//充值的金额
				$money = $request->input('txnAmt')/100;//将分转换为元
				$tyb = floor($money);
				//根据手机号来修改用户的总的太阳币个数  一元=一个太阳币
				$a = DB::table('vip_huiyuan')->where('phone',$phone)->increment('taiyangbi',$tyb);
				if($a){
					return redirect('/members/dir');
				}else{
					return redirect('/members/chongzhi');
				}
			}else{
				return redirect('/members/chongzhi');
			}
	    }else{
	        return redirect('/members/chongzhi');
	    }
    }
}
