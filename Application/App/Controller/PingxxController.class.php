<?php
namespace App\Controller;

use Think\Controller;
use Pingpp\Charge;
use Pingpp\Pingpp;
Vendor('alipay.AopSdk');
Vendor('WeChatPay.WeChatPay');

class PingxxController extends CommonController
{
    private $system=array();
    function _initialize(){
        $this->system=M("system")->where("id=1")->find();
    }

    /*********************支付宝微信支付回调*************************/

    public function alipayCallback()
    {   
        
        error_reporting(E_ALL);
        // file_put_contents("callback.txt", "\n\n", FILE_APPEND);
        // file_put_contents("callback.txt", $_POST, FILE_APPEND);
        file_put_contents("callback.txt", "ceshi", FILE_APPEND);
        $t = "\n\n" . date("Y-m-d H:i:s", time()) . "\n" . var_export($_POST, true);
        file_put_contents("callback.txt", $t, FILE_APPEND);

        $aop = new \AopClient;
        $aop->alipayrsaPublicKey = C('PUBLICKEY');
        $flag = $aop->rsaCheckV1($_POST, NULL, "RSA2");
        file_put_contents("callback.txt", ">>>>", FILE_APPEND);
        file_put_contents("callback.txt", $flag, FILE_APPEND);

        if($flag == 1 && $_POST['trade_status'] == 'TRADE_SUCCESS'){

            /*************充值钻石*****************/

            $result = json_encode($_POST);
            $arr = $_POST;
            if ($arr['out_trade_no']) {
                $dat = array(
                    "pay_on"=>$arr['trade_no'],
                    "pay_return"=>$result,
                    "uptime"=>time()
                );
                $rec = M('Recharge_record')->where(array('pay_number'=>substr($arr['out_trade_no'], 0, 17)))->find();
                if($rec && empty($rec['pay_on'])){
                    $sql = M('Recharge_record')->getLastSql();
                    file_put_contents("callback.txt", $sql, FILE_APPEND);

                    
                    M('Recharge_record')->where(array('recharge_record_id'=>$rec['recharge_record_id']))->save($dat); //支付成功!

                    file_put_contents("callback.txt", 'xxx', FILE_APPEND);
                    $sqll = M('Recharge_record')->getLastSql();
                    file_put_contents("callback.txt", $sqll, FILE_APPEND);

                    $money = (M('User')->where(array('user_id'=>$rec['user_id']))->getField('money'))+$rec['meters'];
                    M('User')->where(array('user_id'=>$rec['user_id']))->save(array('money'=>$money,'uptime'=>time()));  //修改会员钻石数量
                    echo "success"; //请不要修改或删除
                }
                
            }

            /*************商城订单返回值*****************/

            if (strpos($_POST['out_trade_no'], 'B') != false) {     //确认订单支付
                $a = explode("B", $_POST["out_trade_no"]);

                // $type = $_POST["subject"];
                $type = $_POST["body"];
                switch ($type) {
                    case 'AliApp':
                        $code['pay_way'] = '支付宝APP支付';
                        break;
                    case 'AliWap':
                        $code['pay_way'] = '支付宝扫码支付';
                        break;
                    default:
                        # code...
                        break;
                }

                file_put_contents("order.txt", json_encode($a[0]), FILE_APPEND);

                $order = M('shop_order')->where(['order_no' => $a[0]])->find();
                if ($order && $order['order_state'] == 'wait_pay') {
                    $data['order_state'] = 'wait_send';
                    $data['uptime'] = date("Y-m-d H:i:s", time());
                    //$data['returns'] = json_encode($result);
                    $s = M('shop_order')->where(['order_no' => $a[0]])->save($data);
                    if ($s) {
                        $code['order_state'] = 'wait_send';
                        $code['update_time'] = date("Y-m-d H:i:s", time());
                        $code['pay_time'] = date("Y-m-d H:i:s", time());
                        $code['ping_no'] = $_POST["trade_no"];   //ping++订单号
                        $code['pay_no'] = $_POST["out_trade_no"];
                        //$code['amount'] = $result['data']['object']['amount'] / 100;
                        $code['pay_charge'] = json_encode($_POST);
                        $result = M('shop_order_merchants')->where(['order_id' => $order['order_id']])->save($code);
                        $member = M('user')->where(['user_id' => $order['member_id']])->find();
                        $order_goods = M('shop_order_goods')->where(['order_id' => $order['order_id']])->select();
                        $goodsNum = 0;
                        foreach ($order_goods as $v) {
                            $goods = M('shop_goods')->where(['goods_id' => $v['goods_id']])->find();

                            if ($goods) {
                                $merchant = M('shop_merchants')->where(['member_id' => $goods['merchants_id']])->find();


                                $goodsInfo['total_sales'] = $goods['total_sales'] + $v['goods_num'];
                                $goodsInfo['month_sales'] = $goods['month_sales'] + $v['goods_num'];
                                $goodsInfo['day_sales'] = $goods['day_sales'] + $v['goods_num'];
                                $merchantInfo['total_sales'] = $merchant['total_sales'] + $v['goods_num'];
                                $merchantInfo['month_sales'] = $merchant['month_sales'] + $v['goods_num'];
                                $merchantInfo['day_sales'] = $merchant['day_sales'] + $v['goods_num'];
                                M('shop_merchants')->where(['member_id' => $goods['merchants_id']])->save($merchantInfo);

                                
                                if ($goods['goods_stock'] > $v['goods_num']) {
                                    $goodsInfo['goods_stock'] = $goods['goods_stock'] - $v['goods_num'];
                                    M('shop_goods')->where(['goods_id' => $v['goods_id']])->save($goodsInfo);
                                    if ($v['specification_id']) {
                                        $specification = M('shop_goods_relation_specification')->where(['specification_id' => $v['specification_id']])->find();
                                        if ($specification) {
                                            if ($specification['specification_stock'] > $v['goods_num']) {
                                                $goodsSpecification['specification_stock'] = $specification['specification_stock'] - $v['goods_num'];
                                            } else {
                                                $goodsSpecification['specification_stock'] = '0';
                                            }
                                            $goodsSpecification['specification_sales'] = $specification['specification_sales'] + $v['goods_num'];
                                        }
                                        M('shop_goods_relation_specification')->where(['specification_id' => $v['specification_id']])->save($goodsSpecification);
                                    }
                                } else {
                                    $goodsInfo['goods_stock'] = '0';
                                    M('shop_goods')->where(['goods_id' => $v['goods_id']])->save($goodsInfo);
                                }
                            }
                        }
                        //交易记录
                        $tradeRecord['member_id'] = $member['user_id'];
                        $tradeRecord['order_no'] = $a[0];
                        $tradeRecord['type'] = 1;
                        $tradeRecord['intime'] = date("Y-m-d H:i:s", time());
                        $tradeRecord['pay_no'] = $_POST['out_trade_no'];
                        $tradeRecord['amount'] = $_POST['total_amount'];
                        $tradeRecord['pay_return'] = json_encode($_POST);
                        M('shop_trade_record')->add($tradeRecord);
                        // $this->change_grade($member['user_id']);
                        // success("支付成功");
                        //
                        per($order); 
                        //
                        echo "success"; //请不要修改或删除
                    } else {
                        error("支付失败");
                    }
                }
            } else if (strpos($_POST['out_trade_no'], 'C') !== false) {   //待支付订单支付
                $a = explode("C", $_POST['out_trade_no']);
                // $type = $_POST["subject"];
                $type = $_POST["body"];
                switch ($type) {
                    case 'AliApp':
                        $code['pay_way'] = '支付宝APP支付';
                        break;
                    case 'AliWap':
                        $code['pay_way'] = '支付宝扫码支付';
                        break;
                    default:
                        # code...
                        break;
                }
                file_put_contents("order.txt", json_encode($a[0]), FILE_APPEND);
                $order = M('shop_order_merchants')->where(['order_no' => $a[0]])->find();
                if ($order && $order['order_state'] == 'wait_pay') {
                    $code['order_state'] = 'wait_send';
                    $code['update_time'] = date("Y-m-d H:i:s", time());
                    $code['pay_time'] = date("Y-m-d H:i:s", time());
                    $code['ping_no'] = $_POST["trade_no"];   //ping++订单号
                    $code['pay_no'] = $_POST["out_trade_no"];
                    //$code['amount'] = $result['data']['object']['amount'] / 100;
                    $code['pay_charge'] = json_encode($_POST);
                    $result = M('shop_order_merchants')->where(['order_merchants_id' => $order['order_merchants_id']])->save($code);
                    $member = M('user')->where(['user_id' => $order['member_id']])->find();
                    $order_goods = M('shop_order_goods')->where(['order_merchants_id' => $order['order_merchants_id']])->select();
                    foreach ($order_goods as $v) {
                        $goods = M('shop_goods')->where(['goods_id' => $v['goods_id']])->find();
                        if ($goods) {
                            $merchant = M('shop_merchants')->where(['member_id' => $goods['merchants_id']])->find();
                            $goodsInfo['total_sales'] = $goods['total_sales'] + $v['goods_num'];
                            $goodsInfo['month_sales'] = $goods['month_sales'] + $v['goods_num'];
                            $goodsInfo['day_sales'] = $goods['day_sales'] + $v['goods_num'];
                            $merchantInfo['total_sales'] = $merchant['total_sales'] + $v['goods_num'];
                            $merchantInfo['month_sales'] = $merchant['month_sales'] + $v['goods_num'];
                            $merchantInfo['day_sales'] = $merchant['day_sales'] + $v['goods_num'];
                            M('shop_merchants')->where(['member_id' => $goods['merchants_id']])->save($merchantInfo);

                            if ($goods['goods_stock'] > $v['goods_num']) {
                                $goodsInfo['goods_stock'] = $goods['goods_stock'] - $v['goods_num'];
                                M('shop_goods')->where(['goods_id' => $v['goods_id']])->save($goodsInfo);
                                if ($v['specification_id']) {
                                    $specification = M('shop_goods_relation_specification')->where(['specification_id' => $v['specification_id']])->find();
                                    if ($specification) {
                                        if ($specification['specification_stock'] > $v['goods_num']) {
                                            $goodsSpecification['specification_stock'] = $specification['specification_stock'] - $v['goods_num'];
                                        } else {
                                            $goodsSpecification['specification_stock'] = '0';
                                        }
                                        $goodsSpecification['specification_sales'] = $specification['specification_sales'] + $v['goods_num'];
                                    }
                                    M('shop_goods_relation_specification')->where(['specification_id' => $v['specification_id']])->save($goodsSpecification);
                                }
                            } else {
                                $goodsInfo['goods_stock'] = '0';
                                M('shop_goods')->where(['goods_id' => $v['goods_id']])->save($goodsInfo);
                            }
                        }
                    }

                    //交易记录
                    $tradeRecord['member_id'] = $member['user_id'];
                    $tradeRecord['order_no'] = $a[0];
                    $tradeRecord['type'] = 1;
                    $tradeRecord['intime'] = date("Y-m-d H:i:s", time());
                    $tradeRecord['pay_no'] = $_POST["trade_no"];
                    $tradeRecord['amount'] = $_POST['total_amount'];
                    $tradeRecord['pay_return'] = json_encode($_POST);
                    M('shop_trade_record')->add($tradeRecord);
                    // $this->change_grade($member['user_id']);
                    // success("支付成功");
                    //
                    per($order); 
                    //
                    echo "success"; //请不要修改或删除
                }else {
                    error("支付失败");
                }
            } else if (strpos($_POST['out_trade_no'], 'D') !== false) {   //待支付订单支付
                $a = explode("D", $_POST["out_trade_no"]);
                // $type = $_POST["subject"];
                $type = $_POST["body"];
                switch ($type) {
                    case 'AliApp':
                        $code['pay_way'] = '支付宝APP支付';
                        break;
                    case 'AliWap':
                        $code['pay_way'] = '支付宝扫码支付';
                        break;
                    default:
                        # code...
                        break;
                }
                file_put_contents("order.txt", $a[0], FILE_APPEND);
                $order = M('shop_merchants_deposit_order')->where(['order_no' => $a[0]])->find();
                if ($order && $order['order_state'] == 'wait_pay') {
                    $code['order_state'] = 'end';
                    $code['update_time'] = date("Y-m-d H:i:s", time());
                    $code['pay_time'] = date("Y-m-d H:i:s", time());
                    //$code['amount'] = $result['data']['object']['amount'] / 100;
                    $code['pay_charge'] = json_encode($_POST);
                    M('shop_merchants_deposit_order')->where(['deposit_id' => $order['deposit_id']])->save($code);
                    M('user')->where(['user_id' => $order['member_id']])->save(['type'=>'2']);
                    M('shop_merchants')->where(['member_id' => $order['member_id']])->save(['pay_state'=>'1']);
                    // success("支付成功");
                    echo "success"; //请不要修改或删除
                } else {
                    error("支付失败");
                }
            }else {
                error("支付失败");
            }


        }else {
            //验证失败
            echo "fail";
        }

    }

    public function wxpayCallback(){
       
        $wx = new \WeChatPay;
        $datas = $wx->getPost();
        $result = $wx->XmlToArr($datas);
        // $result = json_decode(file_get_contents('php://input'), true);
        $text = "\n\n" . date("Y-m-d H:i:s", time()) . "\n" . var_export($result, true);
        file_put_contents("callback.txt", $text, FILE_APPEND);
        if ($result['result_code'] == 'SUCCESS' && $result['return_code'] == 'SUCCESS') {

            /*************充值钻石*****************/

            $results = json_encode($result);
            $arr = $result;
            if ($arr['out_trade_no']) {
                $dat = array(
                    "pay_on"=>$arr['transaction_id'],
                    "pay_return"=>$results,
                    "uptime"=>time()
                );
                $rec = M('Recharge_record')->where(array('pay_number'=>substr($arr['out_trade_no'], 0, 17)))->find();
                
                if($rec && empty($rec['pay_on'])){

                    $sql = M('Recharge_record')->getLastSql();
                    file_put_contents("callback.txt", $sql, FILE_APPEND);

                    
                    M('Recharge_record')->where(array('recharge_record_id'=>$rec['recharge_record_id']))->save($dat); //支付成功!

                    file_put_contents("callback.txt", 'xxx', FILE_APPEND);
                    $sqll = M('Recharge_record')->getLastSql();
                    file_put_contents("callback.txt", $sqll, FILE_APPEND);

                    $money = (M('User')->where(array('user_id'=>$rec['user_id']))->getField('money'))+$rec['meters'];
                    M('User')->where(array('user_id'=>$rec['user_id']))->save(array('money'=>$money,'uptime'=>time()));  //修改会员钻石数量

                    echo '<xml>
                        <return_code><![CDATA[SUCCESS]]></return_code>
                        <return_msg><![CDATA[OK]]></return_msg>
                      </xml>';
                    
                }
                

            }

            /*************商城订单返回值*****************/

            if (strpos($result['out_trade_no'], 'B') != false) {     //确认订单支付
                $a = explode("B", $result['out_trade_no']);

                $type = $result["trade_type"];
                switch ($type) {
                    case 'NATIVE':
                        $code['pay_way'] = '微信扫码';
                        break;
                    case 'APP':
                        $code['pay_way'] = '微信APP支付';
                        break;
                    case 'JSAPI':
                        $code['pay_way'] = '公众号支付';
                        break;
                }

                file_put_contents("order.txt", json_encode($a[0]), FILE_APPEND);

                $order = M('shop_order')->where(['order_no' => $a[0]])->find();
                if ($order && $order['order_state'] == 'wait_pay') {
                    $data['order_state'] = 'wait_send';
                    $data['uptime'] = date("Y-m-d H:i:s", time());
                    //$data['returns'] = json_encode($result);
                    $s = M('shop_order')->where(['order_no' => $a[0]])->save($data);
                    if ($s) {
                        $code['order_state'] = 'wait_send';
                        $code['update_time'] = date("Y-m-d H:i:s", time());
                        $code['pay_time'] = date("Y-m-d H:i:s", time());
                        $code['ping_no'] = $result['transaction_id'];   //ping++订单号
                        $code['pay_no'] = $result['out_trade_no'];
                        //$code['amount'] = $result['data']['object']['amount'] / 100;
                        $code['pay_charge'] = json_encode($result);
                        $result = M('shop_order_merchants')->where(['order_id' => $order['order_id']])->save($code);
                        $member = M('user')->where(['user_id' => $order['member_id']])->find();
                        $order_goods = M('shop_order_goods')->where(['order_id' => $order['order_id']])->select();
                        $goodsNum = 0;
                        foreach ($order_goods as $v) {
                            $goods = M('shop_goods')->where(['goods_id' => $v['goods_id']])->find();
                            if ($goods) {
                                $merchant = M('shop_merchants')->where(['member_id' => $goods['merchants_id']])->find();
                                $goodsInfo['total_sales'] = $goods['total_sales'] + $v['goods_num'];
                                $goodsInfo['month_sales'] = $goods['month_sales'] + $v['goods_num'];
                                $goodsInfo['day_sales'] = $goods['day_sales'] + $v['goods_num'];
                                $merchantInfo['total_sales'] = $merchant['total_sales'] + $v['goods_num'];
                                $merchantInfo['month_sales'] = $merchant['month_sales'] + $v['goods_num'];
                                $merchantInfo['day_sales'] = $merchant['day_sales'] + $v['goods_num'];
                                M('shop_merchants')->where(['member_id' => $goods['merchants_id']])->save($merchantInfo);

                                if ($goods['goods_stock'] > $v['goods_num']) {
                                    $goodsInfo['goods_stock'] = $goods['goods_stock'] - $v['goods_num'];
                                    M('shop_goods')->where(['goods_id' => $v['goods_id']])->save($goodsInfo);
                                    if ($v['specification_id']) {
                                        $specification = M('shop_goods_relation_specification')->where(['specification_id' => $v['specification_id']])->find();
                                        if ($specification) {
                                            if ($specification['specification_stock'] > $v['goods_num']) {
                                                $goodsSpecification['specification_stock'] = $specification['specification_stock'] - $v['goods_num'];
                                            } else {
                                                $goodsSpecification['specification_stock'] = '0';
                                            }
                                            $goodsSpecification['specification_sales'] = $specification['specification_sales'] + $v['goods_num'];
                                        }
                                        M('shop_goods_relation_specification')->where(['specification_id' => $v['specification_id']])->save($goodsSpecification);
                                    }
                                } else {
                                    $goodsInfo['goods_stock'] = '0';
                                    M('shop_goods')->where(['goods_id' => $v['goods_id']])->save($goodsInfo);
                                }
                            }
                        }
                        //交易记录
                        $tradeRecord['member_id'] = $member['user_id'];
                        $tradeRecord['order_no'] = $a[0];
                        $tradeRecord['type'] = 1;
                        $tradeRecord['intime'] = date("Y-m-d H:i:s", time());
                        $tradeRecord['pay_no'] = $result['out_trade_no'];
                        $tradeRecord['amount'] = $result['total_fee'] / 100;
                        $tradeRecord['pay_return'] = json_encode($result);
                        M('shop_trade_record')->add($tradeRecord);
                        // $this->change_grade($member['user_id']);
                        // success("支付成功");
                        //
                        per($order); 
                        //
                        echo '<xml>
                                <return_code><![CDATA[SUCCESS]]></return_code>
                                <return_msg><![CDATA[OK]]></return_msg>
                              </xml>';
                    } else {
                        error("支付失败");
                    }
                }
            } else if (strpos($result['out_trade_no'], 'C') !== false) {   //待支付订单支付
                $a = explode("C", $result['out_trade_no']);
                $type = $result["trade_type"];
                switch ($type) {
                    case 'NATIVE':
                        $code['pay_way'] = '微信扫码';
                        break;
                    case 'APP':
                        $code['pay_way'] = '微信APP支付';
                        break;
                    case 'JSAPI':
                        $code['pay_way'] = '公众号支付';
                        break;
                }
                file_put_contents("order.txt", json_encode($a[0]), FILE_APPEND);
                $order = M('shop_order_merchants')->where(['order_no' => $a[0]])->find();
                if ($order && $order['order_state'] == 'wait_pay') {
                    $code['order_state'] = 'wait_send';
                    $code['update_time'] = date("Y-m-d H:i:s", time());
                    $code['pay_time'] = date("Y-m-d H:i:s", time());
                    $code['ping_no'] = $result['transaction_id'];   //ping++订单号
                    $code['pay_no'] = $result['out_trade_no'];
                    //$code['amount'] = $result['data']['object']['amount'] / 100;
                    $code['pay_charge'] = json_encode($result);
                    $result = M('shop_order_merchants')->where(['order_merchants_id' => $order['order_merchants_id']])->save($code);
                    $member = M('user')->where(['user_id' => $order['member_id']])->find();
                    $order_goods = M('shop_order_goods')->where(['order_merchants_id' => $order['order_merchants_id']])->select();
                    foreach ($order_goods as $v) {
                        $goods = M('shop_goods')->where(['goods_id' => $v['goods_id']])->find();
                        if ($goods) {
                            $merchant = M('shop_merchants')->where(['member_id' => $goods['merchants_id']])->find();
                            $goodsInfo['total_sales'] = $goods['total_sales'] + $v['goods_num'];
                            $goodsInfo['month_sales'] = $goods['month_sales'] + $v['goods_num'];
                            $goodsInfo['day_sales'] = $goods['day_sales'] + $v['goods_num'];
                            $merchantInfo['total_sales'] = $merchant['total_sales'] + $v['goods_num'];
                            $merchantInfo['month_sales'] = $merchant['month_sales'] + $v['goods_num'];
                            $merchantInfo['day_sales'] = $merchant['day_sales'] + $v['goods_num'];
                            M('shop_merchants')->where(['member_id' => $goods['merchants_id']])->save($merchantInfo);
                            
                            if ($goods['goods_stock'] > $v['goods_num']) {
                                $goodsInfo['goods_stock'] = $goods['goods_stock'] - $v['goods_num'];
                                M('shop_goods')->where(['goods_id' => $v['goods_id']])->save($goodsInfo);
                                if ($v['specification_id']) {
                                    $specification = M('shop_goods_relation_specification')->where(['specification_id' => $v['specification_id']])->find();
                                    if ($specification) {
                                        if ($specification['specification_stock'] > $v['goods_num']) {
                                            $goodsSpecification['specification_stock'] = $specification['specification_stock'] - $v['goods_num'];
                                        } else {
                                            $goodsSpecification['specification_stock'] = '0';
                                        }
                                        $goodsSpecification['specification_sales'] = $specification['specification_sales'] + $v['goods_num'];
                                    }
                                    M('shop_goods_relation_specification')->where(['specification_id' => $v['specification_id']])->save($goodsSpecification);
                                }
                            } else {
                                $goodsInfo['goods_stock'] = '0';
                                M('shop_goods')->where(['goods_id' => $v['goods_id']])->save($goodsInfo);
                            }
                        }
                    }

                    //交易记录
                    $tradeRecord['member_id'] = $member['user_id'];
                    $tradeRecord['order_no'] = $a[0];
                    $tradeRecord['type'] = 1;
                    $tradeRecord['intime'] = date("Y-m-d H:i:s", time());
                    $tradeRecord['pay_no'] = $result['out_trade_no'];
                    $tradeRecord['amount'] = $result['total_fee'] / 100;
                    $tradeRecord['pay_return'] = json_encode($result);
                    M('shop_trade_record')->add($tradeRecord);
                    // $this->change_grade($member['user_id']);
                    // success("支付成功");
                    //
                    per($order); 
                    //
                    echo '<xml>
                            <return_code><![CDATA[SUCCESS]]></return_code>
                            <return_msg><![CDATA[OK]]></return_msg>
                          </xml>';
                }else {
                    error("支付失败");
                }
            } else if (strpos($result['out_trade_no'], 'D') !== false) {   //待支付订单支付
                $a = explode("D", $result['out_trade_no']);
                $type = $result["trade_type"];
                switch ($type) {
                    case 'NATIVE':
                        $code['pay_way'] = '微信扫码';
                        break;
                    case 'APP':
                        $code['pay_way'] = '微信APP支付';
                        break;
                    case 'JSAPI':
                        $code['pay_way'] = '公众号支付';
                        break;
                    default:
                        # code...
                        break;
                }
                file_put_contents("order.txt", $a[0], FILE_APPEND);
                $order = M('shop_merchants_deposit_order')->where(['order_no' => $a[0]])->find();
                if ($order && $order['order_state'] == 'wait_pay') {
                    $code['order_state'] = 'end';
                    $code['update_time'] = date("Y-m-d H:i:s", time());
                    $code['pay_time'] = date("Y-m-d H:i:s", time());
                    //$code['amount'] = $result['data']['object']['amount'] / 100;
                    $code['pay_charge'] = json_encode($result);
                    M('shop_merchants_deposit_order')->where(['deposit_id' => $order['deposit_id']])->save($code);
                    M('user')->where(['user_id' => $order['member_id']])->save(['type'=>'2']);
                    M('shop_merchants')->where(['member_id' => $order['member_id']])->save(['pay_state'=>'1']);
                    // success("支付成功");
                    echo '<xml>
                            <return_code><![CDATA[SUCCESS]]></return_code>
                            <return_msg><![CDATA[OK]]></return_msg>
                          </xml>';
                } else {
                    error("支付失败");
                }
            }else {
                error("支付失败");
            }


        }else{
            return false;

        }
    }
    /*********************支付宝微信支付回调*************************/


    /**
     * pingxx支付
     * @param $orderNo
     * @param $type
     * @param $openid
     */
    public function ping(){
        $user = checklogin();
        $amount = I('money');  //金额

        $price = M('Price')->where(['price'=>$amount])->find();
        if ($price){
            $meters = $price['meters']+$price['give'];  //钻石
        }else{
            error('价格未知错误!');
        }

        $type = I('type');
        (empty($amount) || $amount==0 || $meters==0) ? error('参数错误!') : true;
        $pay_number = date('YmdHis').rand(100,999);
        if($type==null){
            $type="wx";
        }
        M('Recharge_record')->add(array('user_id'=>$user['user_id'],'pay_number'=>$pay_number,'amount'=>$amount,'meters'=>$meters,'pay_on'=>'','pay_return'=>'','pay_type'=>$type,'intime'=>time()));
        $number = $pay_number.rand(100, 999);
        $this->pings($type,$number,$amount,I("openid"));

    }

    function pings($type,$number,$amount,$openid)
    {   
        // $amount = M('Recharge_record')->where(array('pay_number'=>substr($number, 0, 17)))->getField('amount');
        // if($amount==null){
        //     $amount=1;
        // }
        // if($number==null){
        //     $number="m".time();
        // }
        
        $body = "AliApp";
        if($type=="alipay"){
            $aop = new \AopClient;
            $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
            $aop->appId = C('ALIAPPID');
            $aop->rsaPrivateKey = C('PRIVATEKEY');
            $aop->format = "json";
            $aop->charset = "UTF-8";
            $aop->signType = "RSA2";
            $aop->alipayrsaPublicKey = C('PUBLICKEY');
            //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
            $request = new \AlipayTradeAppPayRequest();
            //SDK已经封装掉了公共参数，这里只需要传入业务参数
            // $out_trade_no = $order_no . "B" . time();
            $bizcontent = "{\"body\":\"".$body."\"," 
                            . "\"subject\": \"品聚\","
                            . "\"out_trade_no\": \"".$number."\","
                            . "\"timeout_express\": \"30m\"," 
                            . "\"total_amount\": \"".$amount."\","
                            . "\"product_code\":\"QUICK_MSECURITY_PAY\""
                            . "}";
            $request->setNotifyUrl("http://tp3shoplive.zhongfeigou.com/App/Pingxx/alipayCallback");
            $request->setBizContent($bizcontent);
            //这里和普通的接口调用不同，使用的是sdkExecute
            $response = $aop->sdkExecute($request);

            //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
            // echo htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
            $data = $response;
            success($data);
        }else if($type=="wx"){
            $total_fee = $amount * 100;
            $weChat = new \WeChatPay();
            $weChat->wechat_apppay($body, $number, $total_fee);
        } 
        
        
    }

    /***************************************百台云************************************/

    /**
     *商城确认订单支付
     */
    public function ping1(){
        if (IS_POST) {
            $member = checklogin();
            $order_no   = I('order_no');
            $type       = I('type');
            $openid     = I('openid');
            //$res = $order_no.$type.$openid;
            //file_put_contents('ceshi.txt',$res);
            $order = M('shop_order')->where(['order_no' => $order_no,'member_id'=>$member['user_id']])->find();
            if (!$order) error("订单错误");
            $this->pings($type, $order_no . "B" . time(), $order['order_actual_price'], $openid);
            // $this->pings($type, $order_no . "B" . time(), 0.01 * 100, $openid);
        }
    }

    /**
     *商城待支付订单支付
     */
    public function ping2(){
        if (IS_POST) {
            $member = checklogin();
            $order_no   = I('order_no');
            $type       = I('type');
            $openid     = I('openid');
            $order = M('shop_order_merchants')->where(['order_no' => $order_no,'member_id'=>$member['user_id']])->find();
            if (!$order) error("订单错误");
            $this->pings($type, $order_no . "C" . time(), $order['order_actual_price'], $openid);
            // $this->pings($type, $order_no . "C" . time(), 0.01 * 100, $openid);
        }
    }

    /**
     *商户订金支付
     */
    public function ping3($order_no,$amount,$type,$openid){
         $this->pings($type, $order_no . "D" . time(), $amount, $openid);
    }

    /**
     *@商城订单支付返回值
     */
    public function payCallback()
    {
        $result = json_decode(file_get_contents('php://input'), true);
        $text = "\n\n" . date("Y-m-d H:i:s", time()) . "\n" . var_export($result, true);
        file_put_contents("callback.txt", $text, FILE_APPEND);
        if ($result['type'] == 'charge.succeeded') {
            if (strpos($result['data']['object']['order_no'], 'A') != false) {     //确认订单支付
                $data['pay_state'] = 2;
                $data['pay_return'] = json_encode($result);
                $data['uptime'] = date("Y-m-d H:i:s", time());
                $a = explode("A", $result["data"]["object"]['order_no']);
                $record = Db::name('Recharge')->where(['pay_number' => $a[0]])->find();
                if($record && $record['pay_state'] == '1') {
                    file_put_contents("order.txt", $a[0], FILE_APPEND);
                    $s = Db::name('Recharge')->where(['pay_number' => $a[0]])->update($data);
                    if ($s) {
                        $member = Db::name('member')->where(['member_id' => $record['member_id']])->find();
                        $money = $result['data']['object']['amount'] / 100; //支付金额
                        $diamond = $member['b_diamond'] + $record['meters'] + $record['zeng'];    //充值币相加
                        $this->insertDiamondRecord($member['member_id'], '1', '充值', $record['meters'], $record['zeng']);
                        Db::name('member')->where(['member_id' => $member['member_id']])->update(['b_diamond' => $diamond]);

                        //交易记录
                        $tradeRecord['member_id'] = $member['member_id'];
                        $tradeRecord['order_no'] = $a[0];
                        $tradeRecord['type'] = 2;
                        $tradeRecord['intime'] = date("Y-m-d H:i:s", time());
                        $tradeRecord['pay_no'] = $result["data"]["object"]['order_no'];
                        $tradeRecord['amount'] = $money;
                        $tradeRecord['pay_return'] = json_encode($result);
                        Db::name('TradeRecord')->insert($tradeRecord);
                        $this->change_grade($member['member_id']);
                        success("支付成功");
                    } else {
                        error("支付失败");
                    }
                }
            } else if (strpos($result['data']['object']['order_no'], 'B') != false) {     //确认订单支付
                $a = explode("B", $result["data"]["object"]['order_no']);
                $type = $result["data"]["object"]['channel'];
                if (strpos($type, 'alipay') !== false) {
                    $code['pay_way'] = '支付宝';
                } else if (strpos($type, 'wx') !== false) {
                    $code['pay_way'] = '微信';
                }
                file_put_contents("order.txt", json_encode($a[0]), FILE_APPEND);
                $order = Db::name('order')->where(['order_no' => $a[0]])->find();
                if ($order && $order['order_state'] == 'wait_pay') {
                    $data['order_state'] = 'wait_send';
                    $data['uptime'] = date("Y-m-d H:i:s", time());
                    //$data['returns'] = json_encode($result);
                    $s = Db::name('order')->where(['order_no' => $a[0]])->update($data);
                    if ($s) {
                        $code['order_state'] = 'wait_send';
                        $code['update_time'] = date("Y-m-d H:i:s", time());
                        $code['pay_time'] = date("Y-m-d H:i:s", time());
                        $code['ping_no'] = $result["data"]["object"]['order_no'];   //ping++订单号
                        $code['pay_no'] = $result["data"]["object"]['order_no'];
                        //$code['amount'] = $result['data']['object']['amount'] / 100;
                        $code['pay_charge'] = json_encode($result);
                        $result = Db::name('order_merchants')->where(['order_id' => $order['order_id']])->update($code);
                        $member = Db::name('member')->where(['member_id' => $order['member']])->find();
                        $order_goods = Db::name('order_goods')->where(['order_id' => $order['order_id']])->select();
                        $goodsNum = 0;
                        foreach ($order_goods as $v) {
                            $goods = Db::name('goods')->where(['goods_id' => $v['goods_id']])->find();
                            if ($goods) {
                                $merchant = Db::name('merchants')->where(['member_id' => $goods['member_id']])->find();
                                $goodsInfo['total_sales'] = $goods['total_sales'] + $v['goods_num'];
                                $goodsInfo['month_sales'] = $goods['month_sales'] + $v['goods_num'];
                                $goodsInfo['day_sales'] = $goods['day_sales'] + $v['goods_num'];
                                $merchantInfo['total_sales'] = $merchant['total_sales'] + $v['goods_num'];
                                $merchantInfo['month_sales'] = $merchant['month_sales'] + $v['goods_num'];
                                $merchantInfo['day_sales'] = $merchant['day_sales'] + $v['goods_num'];
                                Db::name('merchants')->where(['member_id' => $goods['member_id']])->update($merchantInfo);
                                // if ($goods['goods_stock'] > $v['goods_num']) {
                                //     $goodsInfo['goods_stock'] = $goods['goods_stock'] - $v['goods_num'];
                                //     Db::name('goods')->where(['goods_id' => $v['goods_id']])->update($goodsInfo);
                                //     if ($v['specification_id']) {
                                //         $specification = Db::name('goods_relation_specification')->where(['specification_id' => $v['specification_id']])->find();
                                //         if ($specification) {
                                //             if ($specification['specification_stock'] > $v['goods_num']) {
                                //                 $goodsSpecification['specification_stock'] = $specification['specification_stock'] - $v['goods_num'];
                                //             } else {
                                //                 $goodsSpecification['specification_stock'] = '0';
                                //             }
                                //             $goodsSpecification['specification_sales'] = $specification['specification_sales'] + $v['goods_num'];
                                //         }
                                //         Db::name('goods_relation_specification')->where(['specification_id' => $v['specification_id']])->update($goodsSpecification);
                                //     }
                                // } else {
                                //     $goodsInfo['goods_stock'] = '0';
                                //     Db::name('goods')->where(['goods_id' => $v['goods_id']])->update($goodsInfo);
                                // }
                            }
                        }
                        //交易记录
                        $tradeRecord['member_id'] = $member['member_id'];
                        $tradeRecord['order_no'] = $a[0];
                        $tradeRecord['type'] = 1;
                        $tradeRecord['intime'] = date("Y-m-d H:i:s", time());
                        $tradeRecord['pay_no'] = $result["data"]["object"]['order_no'];
                        $tradeRecord['amount'] = $result['data']['object']['amount'] / 100;
                        $tradeRecord['pay_return'] = json_encode($result);
                        Db::name('TradeRecord')->insert($tradeRecord);
                        $this->change_grade($member['member_id']);
                        success("支付成功");
                    } else {
                        error("支付失败");
                    }
                }
            } else if (strpos($result['data']['object']['order_no'], 'C') !== false) {   //待支付订单支付
                $a = explode("C", $result["data"]["object"]['order_no']);
                $type = $result["data"]["object"]['channel'];
                if (strpos($type, 'alipay') !== false) {
                    $code['pay_way'] = '支付宝';
                } else if (strpos($type, 'wx') !== false) {
                    $code['pay_way'] = '微信';
                }
                file_put_contents("order.txt", json_encode($a[0]), FILE_APPEND);
                $order = Db::name('order_merchants')->where(['order_no' => $a[0]])->find();
                if ($order && $order['order_state'] == 'wait_pay') {
                    $code['order_state'] = 'wait_send';
                    $code['update_time'] = date("Y-m-d H:i:s", time());
                    $code['pay_time'] = date("Y-m-d H:i:s", time());
                    $code['ping_no'] = $result["data"]["object"]['order_no'];   //ping++订单号
                    $code['pay_no'] = $result["data"]["object"]['order_no'];
                    //$code['amount'] = $result['data']['object']['amount'] / 100;
                    $code['pay_charge'] = json_encode($result);
                    $result = Db::name('order_merchants')->where(['order_merchants_id' => $order['order_merchants_id']])->update($code);
                    $member = Db::name('member')->where(['member_id' => $order['member']])->find();
                    $order_goods = Db::name('order_goods')->where(['order_merchants_id' => $order['order_merchants_id']])->select();
                    foreach ($order_goods as $v) {
                        $goods = Db::name('Goods')->where(['goods_id' => $v['goods_id']])->find();
                        if ($goods) {
                            $merchant = Db::name('merchants')->where(['member_id' => $goods['member_id']])->find();
                            $goodsInfo['total_sales'] = $goods['total_sales'] + $v['goods_num'];
                            $goodsInfo['month_sales'] = $goods['month_sales'] + $v['goods_num'];
                            $goodsInfo['day_sales'] = $goods['day_sales'] + $v['goods_num'];
                            $merchantInfo['total_sales'] = $merchant['total_sales'] + $v['goods_num'];
                            $merchantInfo['month_sales'] = $merchant['month_sales'] + $v['goods_num'];
                            $merchantInfo['day_sales'] = $merchant['day_sales'] + $v['goods_num'];
                            Db::name('merchants')->where(['member_id' => $goods['member_id']])->update($merchantInfo);
                            // if ($goods['goods_stock'] > $v['goods_num']) {
                            //     $goodsInfo['goods_stock'] = $goods['goods_stock'] - $v['goods_num'];
                            //     Db::name('goods')->where(['goods_id' => $v['goods_id']])->update($goodsInfo);
                            //     if ($v['specification_id']) {
                            //         $specification = Db::name('goods_relation_specification')->where(['specification_id' => $v['specification_id']])->find();
                            //         if ($specification) {
                            //             if ($specification['specification_stock'] > $v['goods_num']) {
                            //                 $goodsSpecification['specification_stock'] = $specification['specification_stock'] - $v['goods_num'];
                            //             } else {
                            //                 $goodsSpecification['specification_stock'] = '0';
                            //             }
                            //             $goodsSpecification['specification_sales'] = $specification['specification_sales'] + $v['goods_num'];
                            //         }
                            //         Db::name('goods_relation_specification')->where(['specification_id' => $v['specification_id']])->update($goodsSpecification);
                            //     }
                            // } else {
                            //     $goodsInfo['goods_stock'] = '0';
                            //     Db::name('goods')->where(['goods_id' => $v['goods_id']])->update($goodsInfo);
                            // }
                        }
                    }

                    //交易记录
                    $tradeRecord['member_id'] = $member['member_id'];
                    $tradeRecord['order_no'] = $a[0];
                    $tradeRecord['type'] = 1;
                    $tradeRecord['intime'] = date("Y-m-d H:i:s", time());
                    $tradeRecord['pay_no'] = $result["data"]["object"]['order_no'];
                    $tradeRecord['amount'] = $result['data']['object']['amount'] / 100;
                    $tradeRecord['pay_return'] = json_encode($result);
                    Db::name('TradeRecord')->insert($tradeRecord);
                    $this->change_grade($member['member_id']);
                    success("支付成功");
                }
            } else if (strpos($result['data']['object']['order_no'], 'D') !== false) {   //待支付订单支付
                $a = explode("D", $result["data"]["object"]['order_no']);
                $type = $result["data"]["object"]['channel'];
                if (strpos($type, 'alipay') !== false) {
                    $code['pay_way'] = '支付宝';
                } else if (strpos($type, 'wx') !== false) {
                    $code['pay_way'] = '微信';
                }
                file_put_contents("order.txt", $a[0], FILE_APPEND);
                $order = Db::name('merchants_deposit_order')->where(['order_no' => $a[0]])->find();
                if ($order && $order['order_state'] == 'wait_pay') {
                    $code['order_state'] = 'end';
                    $code['update_time'] = date("Y-m-d H:i:s", time());
                    $code['pay_time'] = date("Y-m-d H:i:s", time());
                    //$code['amount'] = $result['data']['object']['amount'] / 100;
                    $code['pay_charge'] = json_encode($result);
                    Db::name('merchants_deposit_order')->where(['deposit_id' => $order['deposit_id']])->update($code);
                    Db::name('member')->where(['member_id' => $order['member']])->update(['type'=>'2']);
                    Db::name('merchants')->where(['member_id' => $order['member']])->update(['pay_state'=>'1']);
                    success("支付成功");
                } else {
                    error("支付失败");
                }
            }else {
                error("支付失败");
            }
        }
    }


    /***************************************百台云************************************/


    /**
     * @param $type
     * @param $number
     * @param $openid
     * @pc端充值
     */
    public function pay_to(){
        $user_id = trim(I('user_id'));
        $price_id = trim(I('price_id'));  $type = I('type');
        empty($price_id) ? error('参数错误!') : true;
        $user = M('User')->find($user_id);
        !$user ? error('充值用户错误!') : true;
        $price = M('Price')->where(['price_id'=>$price_id])->find();
        if ($price){
            $meters = $price['meters']+$price['give'];  //钻石
            $amount = $price['price'];
        }else{
            error('价格未知错误!');
        }
        $pay_number = date('YmdHis').rand(100,999);
        if($type==null){
            $type="wx";
        }
        M('Recharge_record')->add(array('user_id'=>$user['user_id'],'pay_number'=>$pay_number,'amount'=>$amount,'meters'=>$meters,'pay_on'=>'','pay_return'=>'','pay_type'=>$type,'intime'=>time(),'type'=>2,'product_id'=>$pay_number));
        $number = $pay_number.rand(100, 999);
        $this->pingss($type,$number,I("openid"));
    }



    function pingss($type,$number,$openid)
    {
        vendor("Pingpp.init");
        Pingpp::setApiKey($this->system['secretkey']);

        $amount = M('Recharge_record')->where(array('pay_number'=>substr($number, 0, 17)))->getField('amount');
        if($amount==null){
            $amount=1;
        }else{
            $amount *= 100;
        }
        //$amount=1;

        if($number==null){
            $number="m".time();
        }
        try {
            $extra = array();

//            if($type=="alipay_wap"){
//                $extra["success_url"]="http://www.baidu.com";
//            }else if($type=="wx_pub"){
//                $extra["open_id"]=$openid;
//            }
            if ($type=="wx_pub_qr"){
                $extra["product_id"]=substr($number, 0, 17);
            }
            $ch = Charge::create([
                'order_no' => $number,
                'amount' => $amount,
                'channel' => $type,
                'currency' => 'cny',
                'client_ip' => get_client_ip(),
                'subject' => "充值",
                'body' => 'Your Body',
                'app' => ['id' => $this->system['apiid']],
                'extra'=> $extra
            ]);
            $res = json_decode($ch,true);
            $url = $res['credential'][$type];
            $qrcode_path = "./Public/admin/pay/" . time() . rand(100, 999) . '_qrcode.png';
            qrcode($url, $qrcode_path, 3, 4);
            $result = C('IMG_PREFIX').$qrcode_path;
            M('Recharge_record')->where(array('pay_number'=>substr($number, 0, 17)))->save(['qr_code'=>$result,'uptime'=>time()]);
//            if ($type=="wx_pub_qr"){
                success($result);
//            }elseif ($type=="alipay_qr"){
//                echo '{"status": "ok","data":'.$ch.'}';
//            }
            //echo '{"status": "ok","data":'.$ch.'}';
        } catch (\Pingpp\Error\Base $e) {
            header('Status: ' . $e->getHttpStatus());
            echo('{"status":"pending","error":'.$e->getHttpBody()."}");
        }
    }


    

    /**
     * 订单返回值
     */
    public function callback()
    {
        $result = file_get_contents('php://input');
        $arr = json_decode($result, true);
        if ($arr['data']['object']['order_no']) {
            $data = array(
                "pay_on"=>$arr['data']['object']['order_no'],
                "pay_return"=>$result,
                "uptime"=>time()
            );
            $rec = M('Recharge_record')->where(array('pay_number'=>substr($arr['data']['object']['order_no'], 0, 17)))->find();
            M('Recharge_record')->where(array('recharge_record_id'=>$rec['recharge_record_id']))->save($data); //支付成功!
            $money = (M('User')->where(array('user_id'=>$rec['user_id']))->getField('money'))+$rec['meters'];
            M('User')->where(array('user_id'=>$rec['user_id']))->save(array('money'=>$money,'uptime'=>time()));  //修改会员钻石数量

        }
    }

    /**
     * 账户余额
     */
    public function balance()
    {
        $map['member_id'] = $this->member_id;
        $map['type'] = 1;
        $result = M('recharge')->where($map)->sum('amount');
        if(empty($result)){
            apiSuccess(0);
        } else {
            apiSuccess($result);
        }
    }

    /**
     * 充值、提取记录
     * type = 1充值
     */
    public function charges()
    {
        $map['member_id'] = $this->member_id;
        $list = M('recharge')->where($map)->select();

        apiSuccess([
            'chargeList' => $list
        ]);
    }

    /**
     * 提现,个人中心提现
     * type = 0提现
     * status = 0待审核
     */
    public function takeback()
    {
        $data['order_no'] = date('YmdHis');
        $data['member_id'] = $this->member_id;
        $data['amount']  = I('amount');
        $data['type'] = 0;
        $data['status'] = 0;
        $data['create_time'] = time();
        $result = M('recharge')->add($data);

        if($result){
            apiSuccess('提现申请成功');
        } else {
            apiSuccess('提现申请失败');
        }
    }

    /**
     * 充值,个人中心充值
     */
    public function recharge()
    {
        $amount = I('amount') * 100;
        vendor("Pingpp.init");
        Pingpp::setApiKey($this->apiKey);
        try {
            $ch = Charge::create([
                'order_no' => $this->member_id.'d'.date('YmdHis'),
                'amount' => $amount,
                'channel' => 'wx',
                'currency' => 'cny',
                'client_ip' => get_client_ip(),
                'subject' => '充值',
                'body' => '充值',
                'app' => ['id' => $this->appID]
            ]);

            echo $ch;
        } catch (\Pingpp\Error\Base $e) {
            header('Status: ' . $e->getHttpStatus());
            echo($e->getHttpBody());
        }
    }


    public function rechargeHook()
    {
        $post = file_get_contents('php://input');
        $result = json_decode($post, true);
        if(strpos($result['data']['object']['order_no'], 'd') < 0){
            http_response_code(200);
            exit;
        }

        if ($result['type'] == 'charge.succeeded') {
            $arr = explode('d', $result['data']['object']['order_no']);
            $data['member_id'] = $arr[0];
            $data['order_no'] = $arr[1];
            $data['amount'] = $result['data']['object']['amount'];
            $data['type'] = 1;
            $data['status'] = 1;
            $data['create_time'] = time();
            $result = M('recharge')->add($data);
            if($result) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        }
    }

    /******************************************微信提现,企业付款*********************************************************/

    public function withdraw(){
        $user = checklogin();
        $total = I('ticket');  //度票数
        $money = I('money');  //金额
        $openid = trim(I("openid"));    $type = I('type');   $unionid = I('unionid');
        (empty($total) || $total==0 || empty($total)) ? error('参数错误!') : true;
        $withdraw = M('System')->field(['convert_scale3,convert_scale4,withdraw_switch,every_day_switch,period_of_time_start,period_of_time_end,day_switch,start_time,end_time,day_lowest,day_highest,day_number'])->where(['id'=>1])->find();
        if ($withdraw['withdraw_switch']==1){
            $user['withdraw_switch']==2 ? success(['type'=>"1",'des'=>'提现关闭,无法提现']) : true;
            if ($withdraw['day_switch']==1){
                if (time()>$withdraw['start_time'] && time()<$withdraw['end_time']){
                    success(['type'=>"1",'des'=>"".date('Y-m-d H:i',$withdraw['start_time'])."~".date('Y-m-d H:i',$withdraw['end_time'])."提现关闭,无法提现!"]);
                }else{
                    if ($user['day_switch']==1){
                        if (time()>$user['start_time'] && time()<$user['end_time']){
                            success(['type'=>"1",'des'=>"提现关闭,无法提现"]);
                        }
                    }else{
                        if ($withdraw['every_day_switch']==1){
                            $now = strtotime(date('H:i'));
                            if ($now>strtotime($withdraw['period_of_time_start']) && $now<strtotime($withdraw['period_of_time_end'])){
                                success(['type'=>"1",'des'=>"".$withdraw['period_of_time_start']."~".$withdraw['period_of_time_end']."提现关闭,无法提现!"]);
                            }
                        }
                        //else{
                            $count = M('Withdraw_record')->where(['user_id'=>$user['user_id'],'date'=>date('Y-m-d',time())])->count();
                            $count >= $withdraw['day_number'] ? success(['type'=>"1",'des'=>"当天提现次数已用完,无法提现!"]) : true;
                            $highest= get_day_highest($user['grade']);   //根据等级返回当日最高提现值
                            $highest ? $highest = $highest : $highest = $withdraw['day_highest'];
                            $sum = M('Withdraw_record')->where(['user_id'=>$user['user_id'],'date'=>date('Y-m-d',time())])->sum('amount');
                            $sum ? $sum = $sum : $sum = "0";
                            if($sum>=$highest){
                                success(['type'=>"1",'des'=>"今日提现金额已达到最大值,无法提现!"]);
                            }else{
                                if (($sum+$money)>$highest) {
                                    $money = $highest - $sum;
                                    $total = round($money * $withdraw['convert_scale3']);  //四舍五入
                                }
                            }
//                            ($sum+$money)>$highest ? success(['type'=>"1",'des'=>"今日提现金额已达到最大值,无法提现!"]) : true;
                            $money < $withdraw['day_lowest'] ? success(['type'=>"1",'des'=>"提现金额必须大于".$withdraw['day_lowest']."元!"]) : true;
                       // }
                    }
                }
            }else{
                if ($user['day_switch']==1){
                    if (time()>$user['start_time'] && time()<$user['end_time']){
                        success(['type'=>"1",'des'=>"提现关闭,无法提现"]);
                    }
                }else{
                    if ($withdraw['every_day_switch']==1){
                        $now = strtotime(date('H:i'));
                        if ($now>strtotime($withdraw['period_of_time_start']) && $now<strtotime($withdraw['period_of_time_end'])){
                            success(['type'=>"1",'des'=>"".$withdraw['period_of_time_start']."~".$withdraw['period_of_time_end']."提现关闭,无法提现!"]);
                        }
                    }
                    //else{
                        $count = M('Withdraw_record')->where(['user_id'=>$user['user_id'],'date'=>date('Y-m-d',time())])->count();
                        $count >= $withdraw['day_number'] ? success(['type'=>"1",'des'=>"当天提现次数已用完,无法提现!"]) : true;
                        $highest= get_day_highest($user['grade']);   //根据等级返回当日最高提现值
                        $highest ? $highest = $highest : $highest = $withdraw['day_highest'];
                        $sum = M('Withdraw_record')->where(['user_id'=>$user['user_id'],'date'=>date('Y-m-d',time())])->sum('amount');
                        $sum ? $sum = $sum : $sum = "0";
                        if($sum>=$highest){
                            success(['type'=>"1",'des'=>"今日提现金额已达到最大值,无法提现!"]);
                        }else{
                            if (($sum+$money)>$highest) {
                                $money = $highest - $sum;
                                $total = round($money * $withdraw['convert_scale3']);  //四舍五入
                            }
                        }
                        //($sum+$money)>$highest ? success(['type'=>"1",'des'=>"今日提现金额已达到最大值,无法提现!"]) : true;
                        $money < $withdraw['day_lowest'] ? success(['type'=>"1",'des'=>"提现金额必须大于".$withdraw['day_lowest']."元!"]) : true;
                   //}
                }
            }
        }else{
            //error('提现通道暂时关闭!');
            success(['type'=>"1",'des'=>"提现通道暂时关闭"]);
        }
        $user['get_money'] < $total ? success(['type'=>"1",'des'=>"提现度票大于余额,无法提现!"]) : true;
        $lowest_limit = M('System')->where(['id'=>1])->getField('lowest_limit');
        $total < $lowest_limit ? success(['type'=>"1",'des'=>"度票小于最低提现值,无法提现!"]) : true;

        //安卓提现(安卓调起来微信开放平台,需要我查询公众平台的openid)
        if ($type==2){
            empty($unionid) ? error('参数错误') : true;
            $with = M('Withdraw_wechat')->where(['unionid'=>$unionid])->find();
            if ($with){
                $openid = $with['openid'];
            }else{
                success(['type'=>"1",'des'=>"请手动关注度络平台微信公众号,隔天可以提现!"]);
            }
            $withdraw_type = "2";
        }else{
            empty($openid) ? error('参数错误') : true;
            $withdraw_type = "1";
        }





        $user_openid = M('User_openid')->where(['user_id'=>$user['user_id']])->find();
        if($user_openid){
            $user_openid['openid'] == $openid ? true : success(['type'=>"1",'des'=>"提现账户不正确,无法提现!"]);
        }

        $pay_number = date('YmdHis').rand(100,999);
        $type="wx_pub";
        M('Withdraw_record')->add(array('user_id'=>$user['user_id'],'pay_number'=>$pay_number,'amount'=>$money,'total_number'=>$total,'pay_type'=>$type,'intime'=>time(),'date'=>date('Y-m-d',time()),'withdraw_type'=>$withdraw_type));
        $number = $pay_number.rand(100, 999);
        $this->pings2($type,$number,$openid);
    }

    function pings2($type,$number,$openid)
    {
        vendor("Pingpp.init");
        \Pingpp\Pingpp::setApiKey($this->system['secretkey']);

        $amount = M('Withdraw_record')->where(array('pay_number'=>substr($number, 0, 17)))->getField('amount');
        if($amount==null){
            $amount=1;
        }else{
            $amount *= 100;
        }
       // $amount=200;

        if($number==null){
            $number="m".time();
        }
        try {
            $extra = array();

//            if($type=="alipay_wap"){
//                $extra["success_url"]="http://www.baidu.com";
//            }else if($type=="wx_pub"){
//                $extra["open_id"]=$openid;
//            }
            $ch = \Pingpp\Transfer::create([
                'order_no'    => $number,
                'app'         => ['id' => $this->system['apiid']],
                'channel'     => $type,
                'amount'      => $amount,
                'currency'    => 'cny',
                'type'        => 'b2c',
                'recipient'   => $openid,
                'description' => '度票提现',
                'extra'=> $extra
            ]);
            $chs = json_decode($ch,true);
            if ($chs['failure_msg']!=null){
                success(['type'=>"1",'des'=>$chs['failure_msg']]);
               // error($chs['failure_msg']);
            }else{
                success(['type'=>"2",'des'=>"提现成功!"]);
               // echo '{"status": "ok","data":'.$ch.'}';
            }
        } catch (\Pingpp\Error\Base $e) {
            header('Status: ' . $e->getHttpStatus());
            success(['type'=>"1",'des'=>$e->getHttpBody()]);
            //echo('{"status":"pending","error":'.$e->getHttpBody()."}");
        }
    }

    /**
     * 企业付款返回值
     */
    public function callback2()
    {
        $result = file_get_contents('php://input');
        $arr = json_decode($result, true);
        if ($arr['data']['object']['order_no']) {
            $data = array(
                "pay_return"=>$result,
                "uptime"=>time(),
                "type"=>2
            );
            $rec = M('Withdraw_record')->where(array('pay_number'=>substr($arr['data']['object']['order_no'], 0, 17)))->find();
            M('Withdraw_record')->where(array('withdraw_record_id'=>$rec['withdraw_record_id']))->save($data); //提现成功!
            $money = (M('User')->where(array('user_id'=>$rec['user_id']))->getField('get_money'))-$rec['total_number'];
            M('User')->where(array('user_id'=>$rec['user_id']))->save(array('get_money'=>$money,'uptime'=>time()));  //修改会员票数量
            $user_openid = M('User_openid')->where(['user_id'=>$rec['user_id']])->find();
            if (!$user_openid){
                M('User_openid')->add(['user_id'=>$rec['user_id'],'openid'=>$arr['data']['object']['recipient'],'intime'=>time(),'date'=>date('Y-m-d',time())]);
            }
        }else{
            $rec = M('Withdraw_record')->where(array('pay_number'=>substr($arr['data']['object']['order_no'], 0, 17)))->find();
            $data = array(
                "pay_return"=>"",
                "uptime"=>time(),
                "type"=>3
            );
            M('Withdraw_record')->where(array('withdraw_record_id'=>$rec['withdraw_record_id']))->save($data); //提现失败!
        }
    }

    /**
     * @apple_recharge 苹果充值
     */
    public function apple_recharge(){
        $user = checklogin();
        $amount = I('money');  //金额
        $meters = I('meters');  //钻石
        $type = 'apple';
        $pay_number = date('YmdHis').rand(100,999);
        M('Recharge_record')->add(array('user_id'=>$user['user_id'],'pay_number'=>$pay_number,'amount'=>$amount,'meters'=>$meters,'pay_on'=>'','pay_return'=>'','pay_type'=>$type,'intime'=>time()));
        $money = (M('User')->where(array('user_id'=>$user['user_id']))->getField('money'))+$meters;
        M('User')->where(array('user_id'=>$user['user_id']))->save(array('money'=>$money,'uptime'=>time()));  //修改会员钻石数量
        success("成功");
    }


    /**
     *@退款
     */
    public function return_money($amount,$charge){
        vendor("Pingpp.init");
        Pingpp::setApiKey($this->system['secretkey']);
        \Pingpp\Pingpp::setPrivateKeyPath(__DIR__ . '/your_rsa_private_key.pem');
        // 创建退款
        try {
            // 通过发起一次退款请求创建一个新的 refund 对象，只能对已经发生交易并且没有全额退款的 charge 对象发起退款
            $ch = \Pingpp\Charge::retrieve($charge);
            $re = $ch->refunds->create(array(
                'description'=>'Refund Description',
                'amount'    => $amount * 100
            ));
            return $re;// 输出 Ping++ 返回的退款对象 Refund;
        } catch (\Pingpp\Error\Base $e) {
            //header('Status: ' . $e->getHttpStatus());
            return $e->getHttpBody();
        }
    }

    public function perdemo(){
        $order = M('shop_order')->where(array('order_id'=>26))->find();
        per($order);
    }

    /************************************新增申请提现*******************************************/
    /**
     * @提现接口
     * total_number 要提现的魅力值  
     * withdraw_type  提现类型   1：ios   2:安卓 
     * zfbnumber   支付宝账号 
     * zfbname  支付宝名称
     */
    public function take_money(){
        $user = checklogin();
        $money = I('total_number');
        $data['user_id'] = I('uid');
        $data['total_number'] = I('total_number');
        $data['withdraw_type'] = I('withdraw_type');
        $data['zfbnumber'] = I('zfbnumber');
        $data['zfbname'] = I('zfbname');

        $withdraw = M('System')
                    ->field(['convert_scale3,convert_scale4,withdraw_switch,every_day_switch,period_of_time_start,period_of_time_end,day_switch,start_time,end_time,day_lowest,day_highest,day_number'])
                    ->where(['id'=>1])->find();
        $moneys = intval(floor($money * ($withdraw['convert_scale4']/$withdraw['convert_scale3'])));
        $data['amount'] = $moneys;
        $data['pay_number'] = date('YmdHis').rand(100,999);
        $data['intime'] = time();
        $data['date'] = date('Y-m-d');

        if ($withdraw['withdraw_switch']==1){
            $user['withdraw_switch']==2 ? error('提现关闭,无法提现') : true;
            if ($withdraw['day_switch']==1){
                if (time()>$withdraw['start_time'] && time()<$withdraw['end_time']){
                    error("".date('Y-m-d H:i',$withdraw['start_time'])."~".date('Y-m-d H:i',$withdraw['end_time'])."提现关闭,无法提现!");
                }else{
                    if ($user['day_switch']==1){
                        if (time()>$user['start_time'] && time()<$user['end_time']){
                            error("提现关闭,无法提现");
                        }
                    }else{
                        if ($withdraw['every_day_switch']==1){
                            $now = strtotime(date('H:i'));
                            if ($now>strtotime($withdraw['period_of_time_start']) && $now<strtotime($withdraw['period_of_time_end'])){
                                error("".$withdraw['period_of_time_start']."~".$withdraw['period_of_time_end']."提现关闭,无法提现!");
                            }
                        }
                        //else{
                            $count = M('withdraw_record')->where(['user_id'=>$user['user_id'],'date'=>date('Y-m-d',time())])->count();
                            $count >= $withdraw['day_number'] ? error("当天提现次数已用完,无法提现!") : true;
                            $highest= get_day_highest($user['grade']);   //根据等级返回当日最高提现值
                            $highest ? $highest = $highest : $highest = $withdraw['day_highest'];
                            $sum = M('withdraw_record')->where(['user_id'=>$user['user_id'],'date'=>date('Y-m-d',time())])->sum('amount');
                            $sum ? $sum = $sum : $sum = "0";
                            if($sum>=$highest){
                                error("今日提现金额已达到最大值,无法提现!");
                            }else{
                                if (($sum+$moneys)>$highest) {
                                    $moneys = $highest - $sum;
                                    $total = $moneys;  //四舍五入
                                }
                            }
//                            ($sum+$money)>$highest ? success(['type'=>"1",'des'=>"今日提现金额已达到最大值,无法提现!"]) : true;
                            $moneys < $withdraw['day_lowest'] ? error("提现金额必须大于".$withdraw['day_lowest']."元!") : true;
                       // }
                    }
                }
            }else{
                if ($user['day_switch']==1){
                    if (time()>$user['start_time'] && time()<$user['end_time']){
                        error("提现关闭,无法提现");
                    }
                }else{
                    if ($withdraw['every_day_switch']==1){
                        $now = strtotime(date('H:i'));
                        if ($now>strtotime($withdraw['period_of_time_start']) && $now<strtotime($withdraw['period_of_time_end'])){
                            error("".$withdraw['period_of_time_start']."~".$withdraw['period_of_time_end']."提现关闭,无法提现!");
                        }
                    }
                    //else{
                        $count = M('withdraw_record')->where(['user_id'=>$user['user_id'],'date'=>date('Y-m-d',time())])->count();
                        $count >= $withdraw['day_number'] ? error("当天提现次数已用完,无法提现!") : true;
                        $highest= get_day_highest($user['grade']);   //根据等级返回当日最高提现值
                        $highest ? $highest = $highest : $highest = $withdraw['day_highest'];
                        $sum = M('withdraw_record')->where(['user_id'=>$user['user_id'],'date'=>date('Y-m-d',time())])->sum('amount');
                        $sum ? $sum = $sum : $sum = "0";
                        if($sum>=$highest){
                            error("今日提现金额已达到最大值,无法提现!");
                        }else{
                            if (($sum+$moneys)>$highest) {
                                $moneys = $highest - $sum;
                                $total = $moneys;  //四舍五入
                            }
                        }

                        //($sum+$money)>$highest ? success(['type'=>"1",'des'=>"今日提现金额已达到最大值,无法提现!"]) : true;
                        $moneys < $withdraw['day_lowest'] ? error("提现金额必须大于".$withdraw['day_lowest']."元!") : true;
                   //}
                }
            }
        }else{
            //error('提现通道暂时关闭!');
            error("提现通道暂时关闭");
        }
        $user['get_money'] < $money ? error("提现魅力大于余额,无法提现!") : true;
        $lowest_limit = M('System')->where(['id'=>1])->getField('lowest_limit');
        $money < $lowest_limit ? error("魅力小于最低提现值,无法提现!") : true;

        $result = M('withdraw_record')->add($data);

        if($result){
            //减get_money
            $re = M('user')->where(array('user_id'=>$user['user_id']))->setDec('get_money',$money);
            success('提现申请成功');
        } else {
            success('提现申请失败');
        }
    }


    /************************************销售收益申请提现**********************************/
    /**
     * @提现接口
     * seller_money 要提现的销售金额  
     * withdraw_type  提现类型   1：ios   2:安卓 
     * zfbnumber   支付宝账号 
     * zfbname  支付宝名称
     */
    public function take_income(){
        $user = checklogin();
        $money = I('seller_money');
        $data['user_id'] = I('uid');
        $data['amount'] = $money;
        $data['withdraw_type'] = I('withdraw_type');
        $data['zfbnumber'] = I('zfbnumber');
        $data['zfbname'] = I('zfbname');

        (empty($money) || empty($data['withdraw_type']) || empty($data['zfbnumber']) || empty($data['zfbname'])) ? error('参数错误') : true;

        $withdraw = M('System')
                    ->field(['convert_scale3,convert_scale4,withdraw_switch,every_day_switch,period_of_time_start,period_of_time_end,day_switch,start_time,end_time,day_lowest,day_highest,day_number'])
                    ->where(['id'=>1])->find();
        // $moneys = intval(floor($money * ($withdraw['convert_scale4']/$withdraw['convert_scale3'])));
        // $data['amount'] = $moneys;
        $data['pay_number'] = date('YmdHis').rand(100,999);
        $data['intime'] = time();
        $data['date'] = date('Y-m-d');

        if ($withdraw['withdraw_switch']==1){
            $user['withdraw_switch']==2 ? error('提现关闭,无法提现') : true;
            if ($withdraw['day_switch']==1){
                if (time()>$withdraw['start_time'] && time()<$withdraw['end_time']){
                    error("".date('Y-m-d H:i',$withdraw['start_time'])."~".date('Y-m-d H:i',$withdraw['end_time'])."提现关闭,无法提现!");
                }else{
                    if ($user['day_switch']==1){
                        if (time()>$user['start_time'] && time()<$user['end_time']){
                            error("提现关闭,无法提现");
                        }
                    }else{
                        if ($withdraw['every_day_switch']==1){
                            $now = strtotime(date('H:i'));
                            if ($now>strtotime($withdraw['period_of_time_start']) && $now<strtotime($withdraw['period_of_time_end'])){
                                error("".$withdraw['period_of_time_start']."~".$withdraw['period_of_time_end']."提现关闭,无法提现!");
                            }
                        }
                        //else{
                            $count = M('withdraw_income')->where(['user_id'=>$user['user_id'],'date'=>date('Y-m-d',time())])->count();
                            $count >= $withdraw['day_number'] ? error("当天提现次数已用完,无法提现!") : true;
                            $highest= get_day_highest($user['grade']);   //根据等级返回当日最高提现值
                            $highest ? $highest = $highest : $highest = $withdraw['day_highest'];
                            $sum = M('withdraw_income')->where(['user_id'=>$user['user_id'],'date'=>date('Y-m-d',time())])->sum('amount');
                            $sum ? $sum = $sum : $sum = '0';
                            // if($sum>=$highest){
                            //     error("今日提现金额已达到最大值,无法提现!");
                            // }else{
                            //     if (($sum+$money)>$highest) {
                            //         $money = $highest - $sum;
                            //         $total = $money;  //四舍五入
                            //     }
                            // }
//                            ($sum+$money)>$highest ? success(['type'=>"1",'des'=>"今日提现金额已达到最大值,无法提现!"]) : true;
                            $money < $withdraw['day_lowest'] ? error("提现金额必须大于".$withdraw['day_lowest']."元!") : true;
                       // }
                    }
                }
            }else{
                if ($user['day_switch']==1){
                    if (time()>$user['start_time'] && time()<$user['end_time']){
                        error("提现关闭,无法提现");
                    }
                }else{
                    if ($withdraw['every_day_switch']==1){
                        $now = strtotime(date('H:i'));
                        if ($now>strtotime($withdraw['period_of_time_start']) && $now<strtotime($withdraw['period_of_time_end'])){
                            error("".$withdraw['period_of_time_start']."~".$withdraw['period_of_time_end']."提现关闭,无法提现!");
                        }
                    }
                    //else{
                        $count = M('withdraw_income')->where(['user_id'=>$user['user_id'],'date'=>date('Y-m-d',time())])->count();
                        $count >= $withdraw['day_number'] ? error("当天提现次数已用完,无法提现!") : true;
                        $highest= get_day_highest($user['grade']);   //根据等级返回当日最高提现值
                        $highest ? $highest = $highest : $highest = $withdraw['day_highest'];
                        $sum = M('withdraw_income')->where(['user_id'=>$user['user_id'],'date'=>date('Y-m-d',time())])->sum('amount');
                        $sum ? $sum = $sum : $sum = '0';
                        // if($sum>=$highest){
                        //     error("今日提现金额已达到最大值,无法提现!");
                        // }else{
                        //     if (($sum+$money)>$highest) {
                        //         $money = $highest - $sum;
                        //         $total = $money;  //四舍五入
                        //     }
                        // }

                        //($sum+$money)>$highest ? success(['type'=>"1",'des'=>"今日提现金额已达到最大值,无法提现!"]) : true;
                        $money < $withdraw['day_lowest'] ? error("提现金额必须大于".$withdraw['day_lowest']."元!") : true;
                   //}
                }
            }
        }else{
            //error('提现通道暂时关闭!');
            error("提现通道暂时关闭");
        }
        $user['seller_money'] < $money ? error("提现金额大于销售余额,无法提现!") : true;
        // $lowest_limit = M('System')->where(['id'=>1])->getField('lowest_limit');
        // $money < $lowest_limit ? error("金额小于最低提现值,无法提现!") : true;

        $result = M('withdraw_income')->add($data);

        if($result){
            //减get_money
            // print_r($money);exit;
            $re = M('user')->where(array('user_id'=>$user['user_id']))->setDec('seller_money',I('seller_money'));
            success('提现申请成功');
        } else {
            success('提现申请失败');
        }
    }



}
