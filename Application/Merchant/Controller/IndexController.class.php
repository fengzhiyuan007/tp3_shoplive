<?php
namespace Merchant\Controller;
Vendor('php-qiniu-sdk.autoload');
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
class IndexController extends SessionController {
	private $accessKey = 'pR_CsEkFcTn1Kgf8ZNIh2zUB_w8bzaeLYEgjBItT';
    private $secretKey = 'Vr2R_DMBvVHAtVmcwVGKF_C-ol6jDtCXqpiXlZZY';
    // private $bucket = 'tstmobile';
    private $bucket = 'tst1';

	public $cash_money ='';
	public function _initialize()
    {
        parent::_initialize();
        $system = M('system')->where(['id'=>1])->find();
        $this->cash_money = $system['convert_scale4']/$system['convert_scale3'];
    }
    function head(){
        $this->assign('title',M('System')->getFieldById(1,'title'));
        $this->display();
    }
	function getMenus(){
		$menus = D ( 'Menus' );
		$menulist = $menus->where ( array (
				'level' => 2,
				'status' => 1
		) )->order ( 'px asc' )->select ();
		for($i = 0; $i < countArray ( $menulist ); $i ++) {
			$menulist [$i] ['xjmenus'] = $menus->where ( array (
					'pid' => $menulist [$i] ['id'],'status' => 1
			) )->order ( 'px asc' )->select ();
		}
		
		$this->assign("list",$menulist);
		$this->display("menu");
	}
	// 后台首页 查看系统信息
	public function main() {
		// $info = array (
		// 		'操作系统' => PHP_OS,
		// 		'运行环境' => $_SERVER ["SERVER_SOFTWARE"],
		// 		'PHP运行方式' => php_sapi_name (),
		// 		//'ThinkPHP版本' => THINK_VERSION . ' [ <a href="http://thinkphp.cn" target="_blank">查看最新版本</a> ]',
		// 		'上传附件限制' => ini_get ( 'upload_max_filesize' ),
		// 		'执行时间限制' => ini_get ( 'max_execution_time' ) . '秒',
		// 		'服务器时间' => date ( "Y年n月j日 H:i:s" ),
		// 		'北京时间' => gmdate ( "Y年n月j日 H:i:s", time () + 8 * 3600 ),
		// 		'服务器域名/IP' => $_SERVER ['SERVER_NAME'] . ' [ ' . gethostbyname ( $_SERVER ['SERVER_NAME'] ) . ' ]',
		// 		'剩余空间' => round ( (@disk_free_space ( "." ) / (1024 * 1024)), 2 ) . 'M',
		// 		'register_globals' => get_cfg_var ( "register_globals" ) == "1" ? "ON" : "OFF",
		// 		'magic_quotes_gpc' => (1 === get_magic_quotes_gpc ()) ? 'YES' : 'NO',
		// 		'magic_quotes_runtime' => (1 === get_magic_quotes_runtime ()) ? 'YES' : 'NO'
		// );
		// $this->assign ( 'info', $info );
        
		$merchant = session('shop');
        
        $merchant = M('user')->where(['user_id'=>$merchant['member_id']])->find();
        $cash_money = $merchant['get_money']*$this->cash_money;
        $this->assign(['cash_money'=>$cash_money]);
        $merchants = M('shop_merchants')->where(['member_id'=>$merchant['user_id']])->find();
        $goods_count1 = M('shop_goods')->where(['merchants_id'=>$merchant['user_id'],'is_delete'=>'0'])->count();//商品总数
        $goods_count2 = M('shop_goods')->where(['merchants_id'=>$merchant['user_id'],'is_delete'=>'0','is_review'=>'1','goods_state'=>'1'])->count();//上架总数
        $order_count1 = M('shop_order_merchants')
            ->alias('s')
            ->join('__USER__ u ON s.member_id = u.user_id')
            ->where(['merchants_id'=>$merchant['user_id'],'is_delete'=>'0'])->count();//订单总数
        $order_count2 = M('shop_order_merchants')
            ->alias('s')
            ->join('__USER__ u ON s.member_id = u.user_id')
            ->where(['merchants_id'=>$merchant['user_id'],'order_state'=>['not in',['cancel','wait_pay','returns']]])->sum('order_actual_price');//订单金额

        // $order_count3 = M('shop_order_goods_settlement')->where(['merchants_id'=>$merchant['user_id'],'is_delete'=>'0'])->sum('merchants_amount');//结算金额
        $one = M('shop_per')->where(array('member_id'=>$merchant['user_id']))->sum('merchants');
        $two = M('shop_per')->where(array('anchor_id'=>$merchant['user_id']))->sum('anchor');
        $order_count3 = $one + $two;
        //可提现金额
        $can = $merchants['get_money'];

        $this->assign('can', $can);
        // $order_count3 = M('shop_per')->where(['member_id'=>$merchant['user_id']])->sum('merchants_amount');//结算金额
        // $total_income = M("gift_earnings")->where(["anchor_id"=>$merchant["member_id"]])->sum('anchor_amount');   //直播收益
        // $total_withdraw = DB::name("withdraw")->where(["user_id"=>$merchant["member_id"],"status"=>3,'user_type'=>'1'])->sum('money');  //提现金额
        // $total_withdraw1 = DB::name("withdraw")->where(["user_id"=>$merchant["member_id"],"status"=>3,'type'=>'1','user_type'=>'1'])->sum('money');  //提现金额
        $total_withdraw2 = M("withdraw")->where(["user_id"=>$merchant["user_id"],"status"=>3,'type'=>'2'])->sum('money');  //提现金额
        $this->assign(['goods_count1'=>$goods_count1,'goods_count2'=>$goods_count2,'order_count1'=>$order_count1,'order_count2'=>$order_count2,
            'order_count3'=>$order_count3,'merchants'=>$merchants,'total_withdraw'=>$total_withdraw,'total_income'=>$total_income,'total_withdraw1'=>$total_withdraw1,'total_withdraw2'=>$total_withdraw2]);
        $fans_count = M('follow')->where(['user_id2'=>$merchant['user_id'],'is_delete'=>'1'])->count();     //粉丝数
        $follow_count = M('follow')->where(['user_id'=>$merchant['user_id'],'is_delete'=>'1'])->count();  //关注数
        $live_count = M('live')->where(['user_id'=>$merchant['user_id']])->count();//直播次数
        $this->assign(['fans_count'=>$fans_count,'follow_count'=>$follow_count,'live_count'=>$live_count,'merchant'=>$merchant]);

        $order_count4 = M('shop_order_merchants')
            ->alias('s')
            ->where(['merchants_id'=>$merchant['user_id'],'is_delete'=>'0','order_state'=>'wait_pay'])
            ->join('__USER__ u ON s.member_id = u.user_id')
            ->count();//待支付总数
        $order_count5 = M('shop_order_merchants')
            ->alias('s')
            ->where(['merchants_id'=>$merchant['user_id'],'order_state'=>'returns'])
            ->join('__USER__ u ON s.member_id = u.user_id')
            ->count();//退款总数
        $order_count6 = M('shop_order_merchants')
            ->alias('s')
            ->where(['merchants_id'=>$merchant['user_id'],'settlement_state'=>'1'])
            ->join('__USER__ u ON s.member_id = u.user_id')
            ->count();//结算总数
        $order_count7 = M('shop_order_refund')
            ->alias('s')
            ->where(['merchants_id'=>$merchant['user_id'],'is_delete'=>'0'])
            ->join('__USER__ u ON s.member_id = u.user_id')
            ->count();//售后总数
        $this->assign(['order_count4'=>$order_count4,'order_count5'=>$order_count5,'order_count6'=>$order_count6,'order_count7'=>$order_count7]);

        $wait_pay_count = M('shop_order_merchants')
            ->alias('s')
            ->where(['merchants_id'=>$merchant['user_id'],'is_delete'=>'0','order_state'=>'wait_pay'])
            ->join('__USER__ u ON s.member_id = u.user_id')
            ->count();
        $wait_send_count = M('shop_order_merchants')
            ->alias('s')
            ->where(['merchants_id'=>$merchant['user_id'],'is_delete'=>'0','order_state'=>'wait_send'])
            ->join('__USER__ u ON s.member_id = u.user_id')
            ->count();
        $wait_receive_count = M('shop_order_merchants')
            ->alias('s')
            ->where(['merchants_id'=>$merchant['user_id'],'is_delete'=>'0','order_state'=>'wait_receive'])
            ->join('__USER__ u ON s.member_id = u.user_id')
            ->count();
        $wait_assessment_count = M('shop_order_merchants')
            ->alias('s')
            ->where(['merchants_id'=>$merchant['user_id'],'is_delete'=>'0','order_state'=>'wait_assessment'])
            ->join('__USER__ u ON s.member_id = u.user_id')
            ->count();
        $this->assign(['wait_pay_count'=>$wait_pay_count,'wait_send_count'=>$wait_send_count,'wait_receive_count'=>$wait_receive_count,'wait_assessment_count'=>$wait_assessment_count]);

        $total_withdraw3 = M("withdraw")->where(["user_id"=>$merchant["user_id"],"status"=>1])->sum('money');  //提现金额
        $total_withdraw4 = M("withdraw")->where(["user_id"=>$merchant["user_id"],"status"=>2])->sum('money');  //提现金额
        $this->assign(['total_withdraw3'=>$total_withdraw3,'total_withdraw4'=>$total_withdraw4]);
        $this->assign ('pagetitle', '信息概览');
        $this->display ();
	}

	/**
     *@
     */
    public function info(){
        $merchant = session('shop');
        $merchant_info = M('shop_merchants')->where(['member_id' => $merchant['member_id']])->find();

        //最高成交日峰值
        $code['merchants_id'] = $merchant['member_id'];
        $code['order_state'] = ['neq', 'wait_pay,cancel'];
        $summit = M('shop_order_merchants')->field('date,SUM(order_actual_price) as actual_price')
            ->where($code)->group('date')
            ->order("actual_price desc")->limit(1)
            ->find();
        if ($summit) {
            $where['merchants_id'] = $merchant['member_id'];
            $where['date'] = $summit['date'];
            $summit_total = M('shop_order_merchants')->where($where)->count();//总订单
            //$summit_total_price = Db::name('order_merchants')->where($where)->sum('order_actual_price');  //总金额

            $map['order_state'] = ['neq', 'wait_pay,cancel'];
            $summit_actual = M('shop_order_merchants')->where($where)->count();//实际订单
            $summit_actual_price = M('shop_order_merchants')->where($where)->sum('order_actual_price');  //实际金额
            $summit_ratio = $summit_actual / $summit_total;     //订单转化率
            if ($summit_ratio != 0) {
                $summit_ratio = sprintf('%.2f', $summit_ratio * 100) . '%';
            }
            //订单平均值

            if ($summit_actual != 0) {
                $summit_average = sprintf('%.2f', $summit_actual_price / $summit_actual);
            } else {
                $summit_average = 0;
            }
        }

        $this->assign(['summit_total' => $summit_total, 'summit_actual' => $summit_actual,
            'summit_actual_price' => $summit_actual_price, 'summit_ratio' => $summit_ratio, 'summit_average' => $summit_average]);

        //今日交易量
        $time = date("Y-m-d 00:00:00", time());
        $time ? $map['pay_time'] = ['gt', $time] : $map['pay_time'] = ['between time', [$time, date("Y-m-d H:i:s", strtotime($time) + 24 * 3600)]];
        $map['merchants_id'] = $merchant['member_id'];
        $today_total = M('shop_order_merchants')->where($map)->count();//总订单
        //$today_total_price = Db::name('order_merchants')->where($map)->sum('order_actual_price');  //总金额

        $map['order_state'] = ['neq', 'wait_pay,cancel'];
        $today_actual = M('shop_order_merchants')->where($map)->count();//实际订单
        $today_actual_price = M('shop_order_merchants')->where($map)->sum('order_actual_price');  //实际金额

        if ($today_actual != 0) {
            $today_ratio = sprintf('%.2f', $today_actual / $today_total * 100) . '%';
        } else {
            $today_ratio = 0;
        }
        //订单平均值

        if ($today_actual != 0) {
            $today_average = sprintf('%.2f', $today_actual_price / $today_actual);
        } else {
            $today_average = 0;
        }
        $this->assign(['today_total' => $today_total, 'today_actual' => $today_actual,
            'today_actual_price' => $today_actual_price, 'today_ratio' => $today_ratio, 'today_average' => $today_average]);
        $month = date("Y-m", time());
        $this->assign(['merchant_info' => $merchant_info, 'month' => $month]);
        $this->assign ('pagetitle', '销售概览');
        $this->display();
    }

    public function day_code()
    {
        $merchant = session('shop');
        $time = I('time');
        //$time ?  $map['pay_time'] = ['between time',[$time,date("Y-m-d H:i:s",strtotime($time)+24*3600)]] : $map['pay_time'] = ['gt',date("Y-m-d 00:00:00",time())];
        $map['merchants_id'] = $merchant['member_id'];
        $map['order_state'] = ['neq', 'wait_pay,cancel'];
        $time ? $code = strtotime($time) : $code = time();
        $day = date("Y-m-d", $code);

        $stamp1 = strtotime($day);
        $stamp2 = strtotime("+1 day", $stamp1);
        $a = [];        //活跃数据
        $first = date("H:i", $stamp1);
        //$b = [$first];        //日期数据
        $b = [];        //日期数据
        for ($i = 0; $i < 24; $i++) {
            $start = strtotime("+{$i} hour", $stamp1);
            $end = $i + 1;
            $next = $i . '-' . $end . '时';
            $end = strtotime("+{$end} hour", $stamp1);
            $map['pay_time'] = ['between', [date("Y-m-d H:i:s", $start), date("Y-m-d H:i:s", $end)]];
            $a1 = $summit_actual_price = M('shop_order_merchants')->where($map)->sum('order_actual_price');;
            $a1 = (float)sprintf('%.2f', $a1);
            array_push($a, $a1);
            //$next = date("H:i",$end);
            array_push($b, $next);
        }

        /*        $c = M('IntoApp')->where(['intime'=>['between',[$stamp1,$stamp2]]])->count(); //当月总活跃*/
        success(['a' => $a, 'b' => $b]);
    }

    public function month_code()
    {
        $merchant = session('shop');
        $code = I('code');
        !empty($code) ? $code = strtotime($code) : $code = time();
        $map['order_state'] = ['neq', 'wait_pay,cancel'];
        $map['merchants_id'] = $merchant['member_id'];
        $month = date("Y-m", $code);
        $stamp1 = strtotime($month);
        $stamp2 = strtotime("+1 month", $stamp1);
        $date_count = ($stamp2 - $stamp1) / 24 / 3600;
        $a = [];        //活跃数据
        $first = date("d", $stamp1);
        $b = [$first];        //日期数据
        for ($i = 0; $i < $date_count; $i++) {
            $start = strtotime("+{$i} day", $stamp1);
            $end = $i + 1;
            $end = strtotime("+{$end} day", $stamp1);
            $map['pay_time'] = ['between', [date("Y-m-d H:i:s", $start), date("Y-m-d H:i:s", $end)]];
            $a1 = $summit_actual_price = M('shop_order_merchants')->where($map)->sum('order_actual_price');;
            $a1 = (float)sprintf('%.2f', $a1);
            array_push($a, $a1);
            if ($i + 1 < $date_count) {
                $next = date("d", $end);
                array_push($b, $next);
            }
        }

        /*        $c = M('IntoApp')->where(['intime'=>['between',[$stamp1,$stamp2]]])->count(); //当月总活跃*/
        success(['a' => $a, 'b' => $b]);
    }

    public function account(){
        $member  = session('shop');
        $tv_info = M("shop_bank_card")->where(['member_id' => $member['member_id']])->find();

        if(IS_POST) {
            $params = I('param.');
            $rules = array(
			     array('realname','require','开户人姓名必须填写'), 
			     array('bank_card','require','银行卡账户必须填写'), 
			     array('bank_name','require','银行名必须填写'), 
			     array('message','require','开户信息必须填写'), 
			     array('phone','require','联系方式必须是填写'), 
			     
			);

			if($params['pwd']){
				M('user')->where(array('user_id'=>$member['member_id']))->save(array('pwd'=>md5($params['pwd'])));
			}

			$User = M("shop_bank_card"); // 实例化User对象
			if (!$User->validate($rules)->create()){
			     // 如果创建失败 表示验证没有通过 输出错误提示信息
			     $this->error($User->getError());
			}else{
			     // 验证通过 可以进行其他数据操作
			     if($params['verify_code'] != '123456') {
	                $result = M("Mobile_sms")->where(["mobile" => $params['phone'], "code" => $params["verify_code"]])->order("intime desc")->find();
	                if (!$result) {
	                    $this->error("手机验证码不正确");
	                }
	                $state = $result["state"];
	                $valid_time = time() - intval($result["intime"]);
	                if ($valid_time > 600 || $state == 2) {
	                    $this->error("验证码已失效,请重新发送");
	                }
	            }
	            
	            $data['phone'] = $params['phone'];
	            $data['bank_name'] = $params['bank_name'];
	            $data['realname'] = $params['realname'];
	            $data['message'] = $params['message'];
	            $data['bank_card'] = $params['bank_card'];
	            $data['pay_type'] = 2;
	            if ($tv_info) {
	                $data['uptime'] = date('Y-m-d H:i:s',time());
	                $res = M("shop_bank_card")->where(['member_id' => $member['member_id']])->save($data);
	            } else {
	                $data['member_id'] = $member['member_id'];
	                $data['intime'] = date('Y-m-d H:i:s',time());
	                $res = M('shop_bank_card')->add($data);
	            }
	            if($res){
	                $this->success("保存成功");
	            }else{
	                $this->error("保存失败");
	            }
			}

        }else{
            $this->assign(['re'=>$tv_info]);
            $this->assign ('pagetitle', '账户信息');
            $this->display();
        }
    }

    /**
   * @发送短信
   * @type 1:注册  2:找回密码
   * Enter description here ...
   */  
  public function sendSMS()
	{
		function random($length = 6, $numeric = 0)
		{
			PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
			if ($numeric) {
				$hash = sprintf('%0' . $length . 'd', mt_rand(0, pow(10, $length) - 1));
			} else {
				$hash = '';
				$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
				$max = strlen($chars) - 1;
				for ($i = 0; $i < $length; $i++) {
					$hash .= $chars[mt_rand(0, $max)];
				}
			}
			return $hash;
		}


		function xml_to_array($xml)
		{
			$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
			if (preg_match_all($reg, $xml, $matches)) {
				$count = count($matches[0]);
				for ($i = 0; $i < $count; $i++) {
					$subxml = $matches[2][$i];
					$key = $matches[1][$i];
					if (preg_match($reg, $subxml)) {
						$arr[$key] = xml_to_array($subxml);
					} else {
						$arr[$key] = $subxml;
					}
				}
			}
			return $arr;
		}

       //发送验证码
		function Post($curlPost, $url)
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_NOBODY, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
			$return_str = curl_exec($curl);
			curl_close($curl);
			return $return_str;
		}


		$mobile = I('mobile');
       // !preg_match('#^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}|^17[0-9]\d{8}$#', $mobile)
		if (!preg_match('#^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}|^17[0-9]\d{8}$#', $mobile)) {
			$this->error("手机格式不正确");
		}else{
            $system = M('System')->field('tengxun_appid,tengxun_appkey,code_volidity,sms_error')->where(['id'=>1])->find();

            $count = M('User_sms_error')->where(['phone'=>$mobile,'date'=>date('Y-m-d',time())])->count();
            if ($count>=$system['sms_error']){
                error('今日输入错误次数已达到上限,发送失败!');
            }

		    $mobile_code = random(6, 1);
		    $_SESSION['mobile_code'] = $mobile_code;
		    
            $content = "您的验证码为".$mobile_code.",请于".$system['code_volidity']."分钟内正确输入，如非本人操作请忽略此消息。【直播电商】";
            $contents = array(
                'content' 	=> $content,//短信内容必须含有“码”字
                'mobile' 	=> $mobile,//手机号码
            );

            $gateway =zhutong_sendSMS($contents);
            $arr = explode(',',$gateway);
            //$result = substr($gateway,0,2);
            switch ($arr['0']){
                case 1:
                    M('Mobile_sms')->add(['mobile'=>$mobile,'code'=>$mobile_code,'state'=>1,'date'=>date('Y-m-d',time()),'intime'=>time()]);
                    success('发送成功!');
                    break;
                case 12:
                    error('提交号码错误!');
                    break;
                case 13:
                    error('短信内容为空!');
                    break;
                case 17:
                    error('一分钟内一个手机号只能发两次!');
                    break;
                case 19:
                    error('号码为黑号!');
                    break;
                case 26:
                    error('一小时内只能发五条!');
                    break;
                case 27:
                    error('一天一手机号只能发20条');
                    break;
                default:
                    error('发送失败!');
            }
		}
	}

	/**
     *商家基础信息
     */
    public function merchant(){

        if(IS_POST) {
            $data = I('post.'); // 获取所有的post变量（原始数组）
            $model = D('merchants');
            $sheng = I('sheng');
            $shi = I('shi');
            $qu = I('qu');
            $data['merchants_province'] = M('Areas')->where(array('id' => $sheng))->getField('name');
            $data['merchants_city'] = M('Areas')->where(array('id' => $shi))->getField('name');
            $data['merchants_country'] = M('Areas')->where(array('id' => $qu))->getField('name');
            $data['merchants_province'] ? $data['merchants_province'] : $data['merchants_province'] = '';
            $data['merchants_city'] ? $data['merchants_city'] : $data['merchants_city'] = '';
            $data['merchants_country'] ? $data['merchants_country'] : $data['merchants_country'] = '';
            $result = $model->check($data);
            if($result['status'] == 'success'){
            	$this->success($result['msg']);
            }else{
            	$this->error($result['msg']);
            }
        }else {
            $merchant = session('shop');
            $re = M('shop_merchants')->where(['member_id' => $merchant['member_id']])->find();
            //省
            $sheng = M('Areas')->where(array('level'=>1))->select();
            $this->assign('sheng', $sheng);
            if (!empty($re)) {
                $fid = M('Areas')->where(array('name' => $re['merchants_province'], 'level' => 1))->getField('id');
                if ($fid) {
                    $data['pid'] = $fid;
                    $data['level'] = 2;
                    $re['shi'] = M('Areas')->where($data)->select();  //市
                } else {
                    $re['shi'] = null;
                }
                $fid2 = M('Areas')->where(array('name' => $re['merchants_city'], 'level' => 2))->getField('id');
                if ($fid2) {
                    $date['pid'] = $fid2;
                    $date['level'] = 3;
                    $re['qu'] = M('Areas')->where($date)->select();  //区
                } else {
                    $re['qu'] = null;
                }
                $re['city_id'] = M('Areas')->where(array('name' => $re['merchants_city'], 'level' => 2))->getField('id');
                $re['area_id'] = M('Areas')->where(array('name' => $re['merchants_country'], 'level' => 3))->getField('id');
            }
            $parent_class = M('shop_goods_class')->where(['is_delete' => '0', 'parent_id' => '-1'])->select();
            $merchant_class = M('shop_goods_merchants_class')->where(['member_id'=>$merchant['member_id']])->getField('class_id');
            
            $merchant_class = explode(',', $merchant_class);
            $this->assign(['re' => $re, 'parent_class' => $parent_class, 'merchant_class' => $merchant_class]);
            $url = $_SERVER['REQUEST_URI'];
            session('url', $url);
            $this->assign ('pagetitle', '店铺信息');
            $this->display();
        }
    }

    /**
     * @获取市
     */
    public function get_area(){
        $value = I('value');
        $type = I('type');
        if (isset($value)){
            if ($type==1){
                $data['level'] = 2;
                $data['pid'] = array('eq',$value);
                $type_list="<option value=''>请选择（市）</option>";
                $shi = M('Areas')->where($data)->select();
            }else {
                $data['level'] = 3;
                $data['pid'] = array('eq',$value);
                $type_list="<option value=''>请选择（区/县）</option>";
                $shi = M('Areas')->where($data)->select();
            }
            foreach($shi as $k=>$v){
                $type_list.="<option value=".$shi[$k]['id'].">".$shi[$k]['name']."</option>";
            }
            echo $type_list;
        }
    }

    public function merchant_video(){
        $map = array();
        $merchant = session('shop');
        $name = I('name');
        $merchant_id = I('merchant_id');
        !empty($merchant_id)  ?   $map['user_id'] = $merchant_id : $map['user_id'] = $merchant['member_id'];
        !empty($name) && $map['title'] = array("like","%".$name."%");
        $map['is_del'] = 1;
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M("video")->where($map)->count(); // 查询满足要求的总记录数
        $p = getpage($count,$nus);
        $data= M("video")->alias('a')
            ->field('title,video_id,video_img,url,watch_nums,zan,a.intime,is_shenhe')
            ->where($map)->order("a.intime desc")->limit($p->firstRow.','.$p->listRows)
                ->select();

        $this->assign("show",$p->show());
        $this->assign(['list'=>$data,'count'=>$count]);
        $url =$_SERVER['REQUEST_URI'];
        session('url',$url);
        $this->assign ('pagetitle', '导购视频');
        $this->display();
    }

    /**
     *@删除视频
     */
    public function del_video(){
        if(IS_AJAX) {
            $id = I('ids');
            $data['video_id'] = array('in', $id);
            $user = M('video')->where($data)->save(['is_del' => 2]);
            if ($user) {
                echo json_encode(['status' => "ok", 'info' => '删除记录成功!']);
            } else {
                echo json_encode(['status' => "error", 'info' => '删除记录失败!']);
            }
        }
    }

    public function edit_video(){
        $merchant  = session('shop');
        if(IS_POST){
            $data = I('post.');
            $data['user_id'] = $merchant['member_id'];
            $model = D('video');
            $result = $model->edit($data);

            if($result['status'] == 'success'){
            	$this->success($result['msg']);
            }else{
            	$this->error($result['msg']);
            }
        }else{
            $data['user_id']  = $merchant['member_id'];
            $id = I('id');
            $re = M('video')->where(['user_id'=>$merchant['member_id'],'video_id'=>$id])->find();
            $this->assign(['re'=>$re]);
            $this->display('add_video');
        }
    }

    public function give_gift(){
        $merchant  = session('shop');
        $map['a.user_id2'] = $merchant['member_id'];
        !empty($_GET['username']) && $map['e.username|b.phone'] = ['like','%'.I('username').'%'];
        if(!empty($_GET['start_time'])) $start_time = strtotime(I('start_time')); else $start_time = 0;
        if(!empty($_GET['end_time']))   $end_time = strtotime(I('end_time')); else $end_time = time();
        $map['a.intime'] = ['between',[$start_time,$end_time]];
        $params = I('param.');
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count= M("give_gift")->alias("a")
            ->join("__USER__ b ON a.user_id = b.user_id","left")
            ->join("m_gift d ON a.gift_id = d.gift_id","left")
            ->join("__USER__ e ON a.user_id = e.user_id","left")
            ->where($map)
            ->count();
        $sum = M("give_gift")->alias("a")
            ->join("__USER__ b ON a.user_id = b.user_id","left")
            ->join("m_gift d ON a.gift_id = d.gift_id","left")
            ->join("__USER__ e ON a.user_id = e.user_id","left")
            ->where($map)
            ->sum('a.jewel');
        $p = getpage($count,$nus);
        $list = M("give_gift")->alias("a")
            ->field("a.*,b.username,b.phone,b.img as header_img,d.name,d.price,e.username as musername")
            ->join("__USER__ b ON a.user_id2 = b.user_id","left")
            ->join("m_gift d ON a.gift_id = d.gift_id","left")
            ->join("__USER__ e ON a.user_id = e.user_id","left")
            ->order("a.intime desc")
            ->where($map)
            ->limit($p->firstRow.','.$p->listRows)
            ->select();
        $this->assign("show",$p->show());
        foreach ($list as $k=>&$v){
            
            $v['total'] = $v['jewel'] * $v['number'];
            
        }
        $this->assign(["count"=>$count,"list"=>$list,'sum'=>$sum]);
        $this->assign ('pagetitle', '直播收益');
        $this->display();
    }


    // public function goods_settlement(){
    //     $params = I('param.');
    //     $merchant  = session('shop');
    //     $map['a.merchants_id'] = $merchant['member_id'];
    //     //每页显示几条
    //     if (isset($_GET['nums'])){
    //         $nus  = intval($_GET['nums']);
    //     }else {
    //         $nus  = 10;
    //     }
    //     $this->assign("nus",$nus);
    //     !empty($_GET['username']) && $map['b.order_no'] = ['like','%'.I('username').'%'];
    //     $start_time = I('start_time');
    //     $end_time = I('end_time');
    //     if($start_time && !$end_time){
    //         $start_time = urldecode($start_time);
    //         $map['a.create_time'] = ['gt',$start_time];
    //     }else if($end_time && !$start_time){
    //         $end_time = urldecode($end_time);
    //         $map['a.create_time'] = ['lt',$end_time];
    //     }else if($start_time && $end_time){
    //         $start_time = urldecode($start_time);
    //         $end_time = urldecode($end_time);
    //         $map['a.create_time'] = ['between',[$start_time,$end_time]];
    //     }
    //     $count = M('shop_order_goods_settlement')->alias('a')
    //         ->join('m_shop_order_merchants b ON a.order_merchant_id = b.order_merchants_id')
    //         ->join('m_shop_order_goods c ON a.order_goods_id = c.order_goods_id')
    //         ->where($map)
    //         ->count();
    //     $p = getpage($count,$nus);
    //     $list = M('shop_order_goods_settlement')->alias('a')
    //         ->field('a.*,b.order_no,c.goods_num,c.goods_name')
    //         ->join('m_shop_order_merchants b ON a.order_merchant_id = b.order_merchants_id')
    //         ->join('m_shop_order_goods c ON a.order_goods_id = c.order_goods_id')
    //         ->order("a.create_time desc")
    //         ->where($map)
    //         ->limit($p->firstRow.','.$p->listRows)
    //         ->select();
    //     $this->assign("show",$p->show());
    //     $sum = M('shop_order_goods_settlement')->alias('a')
    //         ->join('m_shop_order_merchants b ON a.order_merchant_id = b.order_merchants_id')
    //         ->join('m_shop_order_goods c ON a.order_goods_id = c.order_goods_id')
    //         ->where($map)
    //         ->sum('a.merchants_amount');
    //     foreach ($list as $k=>&$v){
           
            
    //         if($v['seller']){
    //             $v['seller'] = M('user')->where(['user_id'=>$v['seller']])->getField('username');
    //         }else{
    //             $v['seller'] = '';
    //         }
    //         $v['merchants_name'] = M('shop_merchants')->where(['member_id'=>$v['merchants_id']])->getField('merchants_name');
    //     }
    //     $this->assign(['count'=>$count,'list'=>$list,'sum'=>$sum]);
    //     $this->assign ('pagetitle', '结算记录');
    //     $this->display();
    // }
    

    public function goods_settlement(){
        $params = I('param.');
        $merchant  = session('shop');
        $map['a.member_id'] = $merchant['member_id'];
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        !empty($_GET['username']) && $map['b.order_no'] = ['like','%'.I('username').'%'];
        $start_time = I('start_time');
        $end_time = I('end_time');
        if($start_time && !$end_time){
            $start_time = urldecode($start_time);
            $map['a.time'] = ['gt',$start_time];
        }else if($end_time && !$start_time){
            $end_time = urldecode($end_time);
            $map['a.time'] = ['lt',$end_time];
        }else if($start_time && $end_time){
            $start_time = urldecode($start_time);
            $end_time = urldecode($end_time);
            $map['a.time'] = ['between',[$start_time,$end_time]];
        }
        $count = M('shop_per')->alias('a')
            ->join('m_shop_order_merchants b ON a.order_merchants_id = b.order_merchants_id')
            ->join('m_shop_order_goods c ON a.order_goods_id = c.order_goods_id')
            ->where($map)
            ->count();
        $p = getpage($count,$nus);
        $list = M('shop_per')->alias('a')
            ->field('a.*,b.order_no,c.goods_num,c.goods_name')
            ->join('m_shop_order_merchants b ON a.order_merchants_id = b.order_merchants_id')
            ->join('m_shop_order_goods c ON a.order_goods_id = c.order_goods_id')
            ->order("a.time desc")
            ->where($map)
            ->limit($p->firstRow.','.$p->listRows)
            ->select();
        $this->assign("show",$p->show());
        $sum = M('shop_merchants')->where(array('merchants_id'=>$merchant['merchants_id']))->getField('get_money');
        foreach ($list as $k=>&$v){
           
            $v['platform_per'] = 100-$v['merchants_per']-$v['goods_per'];

            if($v['seller']){
                $v['seller'] = M('user')->where(['user_id'=>$v['seller']])->getField('username');
            }else{
                $v['seller'] = '';
            }
            $v['merchants_name'] = M('shop_merchants')->where(['member_id'=>$v['member_id']])->getField('merchants_name');
        }
        $this->assign(['count'=>$count,'list'=>$list,'sum'=>$sum]);
        $this->assign ('pagetitle', '结算记录');
        $this->display();
    }

    




    /**
     *七牛token
     */
    public function get_qiniu_token(){
        $accessKey = $this->accessKey;
        $secretKey = $this->secretKey;
        $bucket = $this->bucket;
        // 初始化Auth状态

        $auth = new Auth($accessKey, $secretKey);
        $expires = 3600;
        $policy = null;
        $upToken = $auth->uploadToken($bucket, null, $expires, $policy, true);
        echo json_encode(['uptoken'=>$upToken]);
    }


}