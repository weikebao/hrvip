<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB,Validator,Input;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;
ini_set('max_execution_time', '0');
class FanliController extends Controller
{
   //返利控制器  每天都会监听会员是否能够满足返利的要求
	public function getIndex()
	{
		// file_put_contents('test.txt','1');
		/*
			返利满足的条件
		1.该会员没有被划落
		2.该会员必须有三个是自己直推的人员
		3.该会员的三个直推人员必须在自己的左右两个区间
		4.最低要求是直推3个人  其余的按照返利条件进行返利
		*/

		$fanli = DB::table('vip_fldw')->get();
		//查询的要求是  基点为1,2,3的没有被划落的,本月已经消费的人员能查询出来
		$user = DB::table('vip_huiyuan')->where('s',1)->where('xiaofei',1)->where('huiyuanstatus',1)->select('vip_huiyuan.id','vip_huiyuan.tuipath','vip_huiyuan.zuojiedian','vip_huiyuan.zuoqujian','vip_huiyuan.youjiedian','vip_huiyuan.youqujian','vip_huiyuan.sanjiedian','vip_huiyuan.sanqujian','vip_huiyuan.fanlileixing','vip_huiyuan.fanliriqi','vip_huiyuan.status','vip_huiyuan.suoshu')->get();
			foreach($user as $v){
				$data = [];
				$num1 = [];
				$num2 = [];
				$num3 = [];
				$fenzu1 = [];
				$fenzu2 = [];
				$fenzu3 = [];
				$zuojiedian = $v['zuojiedian'];
				$youjiedian = $v['youjiedian'];
				$sanjiedian = $v['sanjiedian'];
				//将符合要求的放在数组当中
				foreach($user as $val){
					if(($v['id']==$val['suoshu'])&&($v['id']!=$val['id'])){
						$data[] = $val;
					}
					//将所有关于这个会员有关的会员统一放在3个数组当中 为下面的返利档位做判断使用
					//进行当前人的路径的拆分来判断是否有此人
					$arr = explode(',',$val['tuipath']);
					//判断要判断的人的左右节点位置
					if(in_array($zuojiedian,$arr)&&$v['id']!=$val['id']){
						// file_put_contents('test.txt',$val['id'].'==',FILE_APPEND);
							$fenzu1[] = $val;
						}else if(in_array($youjiedian, $arr)&&$v['id']!=$val['id']){
							$fenzu2[] = $val;
						}else if(in_array($sanjiedian, $arr)&&$sanjiedian!=''){
							$fenzu3[] = $val;
						}
				}
			
				if((count($data))>=3){
					//说明满足了直推三个人的要求
					//判断这些人的位置
					foreach($data as $value){
						//判断当前会员的左右节点  在判断满足要求的会员的所处位置
						$path = $value['tuipath'];
						//查找字符是那个区间的
						if(strpos($path,$zuojiedian.',')){
							$num1[] = $value;
						}else if(strpos($path,$youjiedian.',')){
							$num2[] = $value;
							//虚拟位置  每次经过的时候都会在此位置上加1
						}else if($sanjiedian!=''){
							if(strpos($path,$sanjiedian.',')){
								$num3[] = $value;
							}
						}else{
							continue;
						}
					}
					if((count($num1)>=1) && (count($num2)>=1)){
						//彻底满足了最基本的返利要求  再次判断是否满足什么段位的返利条件
						//进行数据库的修改进行相应的返利
						//查询返利要求
						if((count($fenzu1)>=2800)&&(count($fenzu2)>=2800)&&(count($fenzu3)>=2400)){
							//说明这个人满足了第一个返利的基础条件 fanliid =1
							//判断测试是否处于返利的状态当中
							if(strtotime($v['fanliriqi'])>=time()){
								//判断返利的类型是否改变
								if($v['fanlileixing']==13){
									$a = true;
								}else{
									echo 13;
									$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['fanlileixing'=>13]);
								}
							}else{
								$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['status'=>1,'fanlileixing'=>13,'fanliriqi'=>date('Y-m-d H:i:s',time()+3600*24*30)]);
							}
						}else if((count($fenzu1)>=2100)&&(count($fenzu2)>=2100)&&(count($fenzu3)>=1800)){
							if(strtotime($v['fanliriqi'])>=time()){
								if($v['fanlileixing']==12){
									$a = true;
								}else{
									echo 12;
									$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['fanlileixing'=>12]);
								}
							}else{
								$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['status'=>1,'fanlileixing'=>12,'fanliriqi'=>date('Y-m-d H:i:s',time()+3600*24*30)]);//3600*24*30
							}
						}else if((count($fenzu1)>=1400)&&(count($fenzu2)>=1400)&&(count($fenzu3)>=1200)){
							if(strtotime($v['fanliriqi'])>=time()){
								if($v['fanlileixing']==11){
									$a = true;
								}else{
									echo 11;
									$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['fanlileixing'=>11]);
								}
							}else{
								$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['status'=>1,'fanlileixing'=>11,'fanliriqi'=>date('Y-m-d H:i:s',time()+3600*24*30)]);
							}
						}else if((count($fenzu1)>=700)&&(count($fenzu2)>=700)&&(count($fenzu3)>=600)){
							if(strtotime($v['fanliriqi'])>=time()){
								if($v['fanlileixing']==10){
									$a = true;
								}else{
									echo 10;
									$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['fanlileixing'=>10]);
								}
							}else{
								$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['status'=>1,'fanlileixing'=>10,'fanliriqi'=>date('Y-m-d H:i:s',time()+3600*24*30)]);
							}
						}else if((count($fenzu1)>=350)&&(count($fenzu2)>=350)&&(count($fenzu3)>=300)){
							if(strtotime($v['fanliriqi'])>=time()){
								if($v['fanlileixing']==9){
									$a = true;
								}else{
									echo 9;
									$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['fanlileixing'=>9]);
								}
							}else{
								$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['status'=>1,'fanlileixing'=>9,'fanliriqi'=>date('Y-m-d H:i:s',time()+3600*24*30)]);
							}
						}else if((count($fenzu1)>=375)&&(count($fenzu2)>=375)&&(count($fenzu3)<300)){
							if(strtotime($v['fanliriqi'])>=time()){
								if($v['fanlileixing']==8){
									$a = true;
								}else{
									echo 8;
									$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['fanlileixing'=>8]);
								}
							}else{
								$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['status'=>1,'fanlileixing'=>8,'fanliriqi'=>date('Y-m-d H:i:s',time()+3600*24*30)]);
							}
						}else if((count($fenzu1)>=250)&&(count($fenzu2)>=250)&&(count($fenzu3)<300)){
							if(strtotime($v['fanliriqi'])>=time()){
								if($v['fanlileixing']==7){
									$a = true;
								}else{
									echo 7;
									$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['fanlileixing'=>7]);
								}
							}else{
								$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['status'=>1,'fanlileixing'=>7,'fanliriqi'=>date('Y-m-d H:i:s',time()+3600*24*30)]);
							}
						}else if((count($fenzu1)>=150)&&(count($fenzu2)>=150)&&(count($fenzu3)<300)){
							if(strtotime($v['fanliriqi'])>=time()){
								if($v['fanlileixing']==6){
									$a = true;
								}else{
									echo 6;
									$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['fanlileixing'=>6]);
								}
							}else{
								$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['status'=>1,'fanlileixing'=>6,'fanliriqi'=>date('Y-m-d H:i:s',time()+3600*24*30)]);
							}
						}elseif((count($fenzu1)>=75)&&(count($fenzu2)>=75)&&(count($fenzu3)<300)){
							if(strtotime($v['fanliriqi'])>=time()){
								if($v['fanlileixing']==5){
									$a = true;
								}else{
									echo 5;
									$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['fanlileixing'=>5]);
								}
							}else{
								$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['status'=>1,'fanlileixing'=>5,'fanliriqi'=>date('Y-m-d H:i:s',time()+3600*24*30)]);
							}
						}else if((count($fenzu1)>=40)&&(count($fenzu2)>=40)){
							if(strtotime($v['fanliriqi'])>=time()){
								if($v['fanlileixing']==4){
									$a = true;
								}else{
									echo 4;
									$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['fanlileixing'=>4]);
								}
							}else{
								$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['status'=>1,'fanlileixing'=>4,'fanliriqi'=>date('Y-m-d H:i:s',time()+3600*24*30)]);
							}
						}else if((count($fenzu1)>=20)&&(count($fenzu2)>=20)&&(count($fenzu3)<300)){
							if(strtotime($v['fanliriqi'])>=time()){
								if($v['fanlileixing']==3){
									$a = true;
								}else{
									echo 3;
									$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['fanlileixing'=>3]);
								}
							}else{
								$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['status'=>1,'fanlileixing'=>3,'fanliriqi'=>date('Y-m-d H:i:s',time()+3600*24*30)]);
							}
						}else if((count($fenzu1)>=6)&&(count($fenzu2)>=6)&&(count($fenzu3)<300)){
							if(strtotime($v['fanliriqi'])>=time()){
								if($v['fanlileixing']==2){
									$a = true;
								}else{
									echo 2;
									$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['fanlileixing'=>2]);
								}
							}else{
								$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['status'=>1,'fanlileixing'=>2,'fanliriqi'=>date('Y-m-d H:i:s',time()+3600*24*30)]);
							}
						}else if((count($fenzu1)>=1)&&(count($fenzu2)>=1)){
							if(strtotime($v['fanliriqi'])>=time()){
								if($v['fanlileixing']==1){
									$a = true;
								}else{
									echo 1;
									$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['fanlileixing'=>1]);
								}
							}else{
								$a = DB::table('vip_huiyuan')->where('id',$v['id'])->update(['status'=>1,'fanlileixing'=>1,'fanliriqi'=>date('Y-m-d H:i:s',time()+3600*24*30)]);
							}
						}
					}
				}else{
					//将那些存在返利的档位但是不满足要求的人的档位去除
					if($v['status']!=0)
					{
						//修改这些人的返利档位和条件
						DB::table('vip_huiyuan')->where('id',$v['id'])->update(['status'=>0,'fanlileixing'=>0,'fanliriqi'=>'']);
					}
				}
			}
	}
	//每日的返利修改会员数据
	public function getFanli()
	{
		//查询出所有的在进行返利的会员
		$user = DB::table('vip_huiyuan')->where('s',1)->where('status',1)->where('xiaofei',1)->get();
		foreach($user as $v){
			//判断此人的返利是否在时间内
			if(strtotime($v['fanliriqi'])>time()){
				//获取余额
				$free = $v['free'];
				//获取返利的类型的ID
				$fanliid = $v['fanlileixing'];
				//获取当前人的ID
				$id = $v['id'];
				$money = DB::table('vip_fldw')->where('fanliid',$fanliid)->first()['fanlimoney'];
				$newmoney = $free+$money;
				DB::table('vip_huiyuan')->where('id',$id)->update(['free'=>$newmoney]);
				//将所有的返利的人员的信息写入到新的表格当中
				$data['yfanmoney'] = $money;
				$data['yid'] = $id;
				$data['yphone'] = $v['phone'];
				$data['Jtime'] = date('Y-m-d H:i:s',time()-24*3600);//11号的是12号开始计算所以把日期减1天
				$data['zongjines'] = $newmoney;
				//将数据插入到数据库
				DB::table('vip_fanlijilu')->insert($data);
			}
		}		
	}
	//每月复销判断 没有购买的把消费变为0
	//每个月的1号进行相应的划落操作
	public function getFuxiao()
	{
		$user = DB::table('vip_huiyuan')->where('huiyuanstatus',1)->where('s',1)->where('xiaofei',1)->get();
			foreach($user as $v){
				//判断这些人的购买截止日期是否在判断的日期时间内 如果在就不进行操作 否则进行改变  
				if(strtotime($v['firstgoumai'])<time()){
					//说明这个人的最后的购买截止日期时没有购买物品应该被划落
					DB::table('vip_huiyuan')->where('id',$v['id'])->update(['xiaofei'=>0]);
				}
			}
	}

	//每月的定时划落不存在的会员  3个月不上线的彻底删除  3个月内上线的可以激活
	//根据用户的第一次的购买的时间来计算每次购买来刷新截止日期  只包括基点属性为2和3的会员具有划落的功能

	//每个月的1号进行相应的划落操作
	public function getHualuo()
	{
		$user = DB::table('vip_huiyuan')->where('huiyuanstatus',1)->where('s',1)->get();
			foreach($user as $v){
				//判断这些人的购买截止日期是否在判断的日期时间内 如果在就不进行划落 否则进行划落  
				if(strtotime($v['firstgoumai'])<time()){
					//说明这个人的最后的购买截止日期时没有购买物品应该被划落
					DB::table('vip_huiyuan')->where('id',$v['id'])->update(['s'=>0]);
				}
			}
	}

	//每天都要判断是否把划落的用户进行删除 将这个人的所在线路上的人员的数量-1
	public function getShanchu()
	{
		$user = DB::table('vip_huiyuan')->where('huiyuanstatus',1)->where('s',0)->get();
			foreach($user as $v){
				//这个是将90天内没有进行购买商品的用户删除
				if((time()-strtotime($v['firstgoumai'])>=30*24*3600*2)){
					// 讲这个用户的信息删除掉保留这个位置
					$data['phone']='';
					$data['pass']='';
					$data['name'] = '';
					$data['address'] = '';
					$data['code'] = '';
					$data['jifen'] = 0;
					$data['free'] = '0.00';
					$data['zhuceriqi'] = '';
					$data['huiyuanstatus'] = 0;
					$data['firstgoumai'] = '';
					$data['status'] = 0;
					$data['fanlileixing'] = '';
					$data['fanliriqi'] = '';
					$data['s'] = 3;
					$data['suoshu'] = '';
					$data['xiaofei']=0;
					$data['money'] = '';
					$data['taiyangbi']='';
					DB::table('vip_huiyuan')->where('id',$v['id'])->update($data);
					//根据这个人的推荐路径来进行相应的用户的数量的减少
					$tuipath = $v['tuipath'];
					$arr = explode(',',$tuipath);
					//计算数组的正确个数
					$num = count($arr)-1;
					for($i=1;$i<=$num;$i++){
						//截取数组的个数
						$str = array_slice($arr,0,$i);
						$str1 = array_slice($arr,0,$i+1);
						//合并数组形成字符串
				        $str = implode(',',$str);
				        $str = $str.',';
				        $str1 = implode(',',$str1);
				        $str1 = $str1.',';
				        //根据路径来求取所有的数据
				        $id = DB::table('vip_huiyuan')->where('tuipath',$str1)->first()['id'];
				        //判断这个人的ID是上一个人的那个节点上面
				        $info = DB::table('vip_huiyuan')->where('tuipath',$str)->first();
				       if(count($id)!=0){
					        if($id ==$info['zuojiedian']){
					        	//说明这个人的下级是会员的左区间的人应该将左区间的总人数-1
					        	DB::table('vip_huiyuan')->where('tuipath',$str)->decrement('zuoqujian',1);
					        }else if($id==$info['youjiedian']){
					        	DB::table('vip_huiyuan')->where('tuipath',$str)->decrement('youqujian',1);
					        }else if($id==$info['sanjiedian']){
					        	DB::table('vip_huiyuan')->where('tuipath',$str)->decrement('sanqujian',1);
					        }
					    }
					}
				}
			}
	}
	public function getTest()
	{
		file_put_contents('wangligang.txt', '1');
	}

	public function getDuanxins(){
		//每天查询是否用户该是否进行复销了  离最后5天的时候提醒
		$res = DB::table('vip_huiyuan')->where('s',1)->where('huiyuanstatus',1)->where('id','>',13)->get();


		$config = [
            'app_key'    => '23829723',
            'app_secret' => '662549e447c3e2aca05c530025a7f839',
        ];
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;

		foreach($res as $val){
			//判断他的购买到期时间
			if((strtotime($val['firstgoumai'])<(time()+5*24*3600))&&$val['firstgoumai']!=0){
				$req->setRecNum($val['phone'])
	            ->setSmsParam([
	                'name'=>$val['name']
	            ])
	            ->setSmsFreeSignName('新纪元红日')
	            ->setSmsTemplateCode('SMS_71955009');
	        	$resp = $client->execute($req);
			}
		}
	}
}
