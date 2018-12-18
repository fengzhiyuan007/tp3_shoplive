<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/10/12
 * Time: 上午11:57
 */
namespace App\Controller;
use Think\Controller;
class OrderController extends CommonController
{
    protected $cancel_time = 24;
    protected $return_time = 1;

    protected function queryInfoByCar($member,$ids)
    {
        $list = M('shop_goods_shop_car')->alias('a')
            ->field('a.merchants_id,b.merchants_name,merchants_img')
            ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
            ->where(['a.member_id' => $member['user_id'], 'a.is_valid' => '1', 'b.is_delete' => '0','a.car_id' => ['in', $ids]])
            ->group('a.merchants_id')->select();
        $amount = '0';   //订单总金额
        $num = '0';     //订单总额
        foreach ($list as $k=>$v) {
            $totalPrice = '0';     //商铺订单小记
            $totalNum = '0';    //商铺商品数
            $goods = M('shop_goods_shop_car')->alias('a')
                ->field('a.car_id,a.specification_id,b.goods_id,a.goods_name,a.goods_num,a.goods_img,specification_names,b.goods_origin_price,b.goods_pc_price,b.goods_now_price,a.seller,a.live_id,a.a_id')
                ->join('m_shop_goods b ON a.goods_id = b.goods_id')
                ->where(['a.merchants_id' => $v['merchants_id'], 'a.member_id' => $member['user_id'], 'a.car_id' => ['in', $ids]])
                ->select();
            foreach ($goods as $key => $val) {
                if ($val['specification_id']) {
                    $specification = M('shop_goods_relation_specification')->where(['specification_id' => $val['specification_id']])->find();
                    if ($specification) {
                        $goods[$key]['goods_origin_price'] = $specification['specification_price'];
                        $goods[$key]['goods_now_price'] = $specification['specification_sale_price'];
                        $totalPrice += $specification['specification_sale_price'] * $val['goods_num'];
                    }
                } else {
                    $totalPrice += $val['goods_now_price'] * $val['goods_num'];
                }
                $totalNum += $val['goods_num'];
            }
            $list[$k]['totalPrice'] = sprintf('%.2f', $totalPrice);
            $list[$k]['totalNum'] = (string)$totalNum;
            $list[$k]['goods'] = $goods;
            $amount += $totalPrice;
            $num += $totalNum;
            $merchants_id[] = $v['merchants_id'];
        }
        //优惠券
        $data = M('shop_member_coupon')->alias('a')
            ->field('a.intime,b.end_time,b.end_strtotime,a.id')
            ->join('m_shop_coupon b ON a.coupon_id = b.coupon_id')
            ->where(['a.member_id'=>$member['user_id'],'a.status'=>'1','b.is_delete'=>'0','b.status'=>'2'])->select();
        if($data) {
            foreach ($data as $key => $val) {
                if (time() > $val['end_strtotime']) {
                    M('shop_member_coupon')->where(['id' => $val['id']])->save(['status' => 3]);
                }
            }
            $map['a.member_id'] = $member['user_id'];
            $map['a.status'] = '1';
            $map['b.is_delete'] = '0';
            $map['b.status'] = '2';
            $map['b.limit_value'] = ['elt', $amount];
            $map['b.merchants_id'] = ['in', $merchants_id];
            $coupon = M('shop_member_coupon')->alias('a')
                ->field('a.id,a.coupon_id,b.title,b.img,b.limit_value,b.value,b.start_time,b.end_time,b.type,b.merchants_id')
                ->join('m_shop_coupon b ON a.coupon_id = b.coupon_id')
                ->where($map)->order('a.intime desc')->select();
            if (!empty($coupon)) {
                foreach ($coupon as $k => $v) {
                    if ($v['type'] == 2) {
                        $merchants = M('shop_merchants')->where(['member_id' => $v['merchants_id']])->find();
                        $coupon[$k]['merchants_name'] = $merchants['merchants_name'];
                        $coupon[$k]['merchants_img'] = $merchants['merchants_img'];
                    } else {
                        $coupon[$k]['name'] = '通用优惠券';
                        $coupon[$k]['merchants_name'] = '';
                        $coupon[$k]['merchants_img'] = '';
                    }
                }
            }else{
                $coupon = [];
            }
        }else{
            $coupon = [];
        }
        return array('list' => $list, 'amount' => sprintf('%.2f', $amount),'num'=>(string)$num,'deduct_integral_value'=>'0','deduct_value'=>'0','coupon'=>$coupon);
    }

    /**
     * @获取满减后的价格（购物车结算）
     */
    public function fullSubPrice(){
        if (IS_POST) {
            $member = checklogin();
            $id = I('id');
            $ids = I('ids');
            if (!$ids) error("商品参数错误");
            $ids = explode(',', $ids);
            if (empty($ids)) error("商品参数错误");
            $list = M('shop_goods_shop_car')->alias('a')
                ->field('a.merchants_id,b.merchants_name,merchants_img')
                ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
                ->where(['a.member_id' => $member['user_id'], 'a.is_valid' => '1', 'b.is_delete' => '0','a.car_id' => ['in', $ids]])
                ->group('a.merchants_id')->select();
            $amount = '0';   //订单总金额
            $num = '0';     //订单总额
            if(!$list){
                $list = [];
            }else{
                foreach ($list as $k=>$v) {
                    $totalPrice = '0';     //商铺订单小记
                    $totalNum = '0';    //商铺商品数
                    $goods = M('shop_goods_shop_car')->alias('a')
                        ->field('a.car_id,a.specification_id,b.goods_id,a.goods_name,a.goods_num,a.goods_img,specification_names,b.goods_origin_price,b.goods_pc_price,b.goods_now_price,a.seller,a.live_id,a.a_id')
                        ->join('m_shop_goods b ON a.goods_id = b.goods_id')
                        ->where(['a.merchants_id' => $v['merchants_id'], 'a.member_id' => $member['user_id'], 'a.car_id' => ['in', $ids]])
                        ->select();
                    foreach ($goods as $key => $val) {
                        if ($val['specification_id']) {
                            $specification = M('shop_goods_relation_specification')->where(['specification_id' => $val['specification_id']])->find();
                            if ($specification) {
                                $goods[$key]['goods_origin_price'] = $specification['specification_price'];
                                $goods[$key]['goods_now_price'] = $specification['specification_sale_price'];
                                $totalPrice += $specification['specification_sale_price'] * $val['goods_num'];
                            }
                        } else {
                            $totalPrice += $val['goods_now_price'] * $val['goods_num'];
                        }
                        $totalNum += $val['goods_num'];
                    }
                    $list[$k]['totalPrice'] = sprintf('%.2f', $totalPrice);
                    $list[$k]['totalNum'] = (string)$totalNum;
                    $list[$k]['goods'] = $goods;
                    $amount += $totalPrice;
                    $num += $totalNum;
                    $merchants_id[] = $v['merchants_id'];
                }
                $coupon = M('shop_member_coupon')->alias('a')
                        ->join('m_shop_coupon b ON a.coupon_id = b.coupon_id')
                        ->where(['a.coupon_id'=>$id,'a.member_id'=>$member['user_id'],'b.merchants_id'=>['in', $merchants_id]])
                        ->field('b.value,b.limit_value')
                        ->find();
                // print_r($amount);exit;
                if($amount >= $coupon['limit_value']){
                    $amount = sprintf('%.2f', ($amount-$coupon['value']));
                    success($amount);
                }else{
                    error('未达到满减金额');
                }
            }
        }

    }

    /**
     * @获取满减后的价格（单个结算）
     */
    public function fullSubOne(){
        if (IS_POST) {
            $member = checklogin();
            $id = I('id');
            $goods_id = I('goods_id');
            $goods_num = I('goods_num');
            $specification_id = I('specification_id');

            if (!$goods_id) error("商品参数错误");
            if (!$goods_num) error("商品数量错误");
            if (!$this->isSignlessInteger($goods_num)) error("商品数量错误");
            $goods = M('shop_goods')->where(['goods_id' => $goods_id])->find();
            if (!$goods) error("商品库没有找到该商品");
            if($goods['goods_state'] !=1|| $goods['is_delete'] != '0' || $goods['is_review'] != '1'){
                error("该商品已下架");
            }
            $goods = M('shop_goods')->field('goods_id,goods_name,goods_img,goods_origin_price,goods_pc_price,goods_now_price,merchants_id,goods_stock')
                ->where(['goods_id' => $goods_id])->select();
            if (!$goods) error("商品参数错误");

            $list = M('shop_merchants')//店铺
                ->field('member_id as merchants_id,merchants_name,merchants_img')
                ->where(['member_id' => $goods[0]['merchants_id'], 'is_delete' => '0'])
                ->select();
            if (empty($list)) error("店铺错误");
            $totalPrice = '0';     //商铺订单小记
            foreach ($goods as $key => $val) {
                $goods[$key]['specification_names'] = '';
                if ($specification_id) {
                    $specification = M('shop_goods_relation_specification')->where(['specification_id' => $specification_id])->find();
                    if ($specification) {
                        $goods[$key]['goods_origin_price'] = $specification['specification_price'];
                        $goods[$key]['goods_now_price'] = $specification['specification_sale_price'];
                        $totalPrice += $specification['specification_sale_price'] * $goods_num;
                        $goods[$key]['specification_names'] = $specification['specification_names'];
                        if($specification['specification_stock']<$goods_num)          error("商品库存不足");
                    }
                } else {
                    $totalPrice += $val['goods_now_price'] * $goods_num;
                    if($val['goods_stock']<$goods_num)          error("商品库存不足");
                }
                $goods[$key]['goods_num'] = $goods_num;
                $goods[$key]['specification_id'] = $specification_id;
                
            }
            $coupon = M('shop_member_coupon')->alias('a')
                    ->join('m_shop_coupon b ON a.coupon_id = b.coupon_id')
                    ->where(['a.coupon_id'=>$id,'a.member_id'=>$member['user_id'],'b.merchants_id'=>$goods[0]['merchants_id']])
                    ->field('b.value,b.limit_value')
                    ->find();
            // echo M()->getLastSql();
            // print_r($totalPrice);exit;
            if($totalPrice >= $coupon['limit_value']){
                $totalPrice = sprintf('%.2f', ($totalPrice-$coupon['value']));
                success($totalPrice);
            }else{
                error('未达到满减金额');
            }


        }
    }
    

    /**
     *确认订单（购物车）
     */
    public function confirmOrderInfo(){
        if (IS_POST) {
            $member = checklogin();
            $ids = I('car_ids');
            if (!$ids) error("商品参数错误");
            $ids = explode(',', $ids);
            if (empty($ids)) error("商品参数错误");
            return success($this->queryInfoByCar($member,$ids));
        }
    }

    /**
     *确认订单（单件商品）
     */
    public function confirmGoodsInfo(){
        if (IS_POST) {
            $member = checklogin();
            $goods_id = I('goods_id');
            $goods_num = I('goods_num');

            $seller = I('seller')?I('seller'):0;//销售者
            // $live_id = I('live_id')?I('live_id'):0;//直播id
            $a_id = I('a_id')?I('a_id'):0;//活动id
            
            if (!$goods_id) error("商品参数错误");
            if (!$goods_num) error("商品数量错误");
            if (!$this->isSignlessInteger($goods_num)) error("商品数量错误");
            $goods = M('shop_goods')->where(['goods_id' => $goods_id])->find();
            if (!$goods) error("商品库没有找到该商品");
            if($goods['goods_state'] !=1|| $goods['is_delete'] != '0' || $goods['is_review'] != '1'){
                error("该商品已下架");
            }
            $specification_id = I('specification_id');
            $goods = M('shop_goods')->field('goods_id,goods_name,goods_img,goods_origin_price,goods_pc_price,goods_now_price,merchants_id,goods_stock')
                ->where(['goods_id' => $goods_id])->select();
            if (!$goods) error("商品参数错误");

            $list = M('shop_merchants')//店铺
                ->field('member_id as merchants_id,merchants_name,merchants_img')
                ->where(['member_id' => $goods[0]['merchants_id'], 'is_delete' => '0'])
                ->select();
            if (empty($list)) error("店铺错误");
            $totalPrice = '0';     //商铺订单小记
            foreach ($goods as $key => $val) {
                $goods[$key]['specification_names'] = '';
                if ($specification_id) {
                    $specification = M('shop_goods_relation_specification')->where(['specification_id' => $specification_id])->find();
                    if ($specification) {
                        $goods[$key]['goods_origin_price'] = $specification['specification_price'];
                        $goods[$key]['goods_now_price'] = $specification['specification_sale_price'];
                        $totalPrice += $specification['specification_sale_price'] * $goods_num;
                        $goods[$key]['specification_names'] = $specification['specification_names'];
                        if($specification['specification_stock']<$goods_num)          error("商品库存不足");
                    }
                } else {
                    $totalPrice += $val['goods_now_price'] * $goods_num;
                    if($val['goods_stock']<$goods_num)          error("商品库存不足");
                }
                $goods[$key]['goods_num'] = $goods_num;
                $goods[$key]['specification_id'] = $specification_id;
                if($seller && $a_id){
                    $goods[$key]['seller'] = $seller;
                    // $goods[$key]['live_id'] = $live_id;
                    $goods[$key]['a_id'] = $a_id;
                }else{
                    $goods[$key]['seller'] = 0;
                    // $goods[$key]['live_id'] = '';
                    $goods[$key]['a_id'] = 0;
                }
            }
            foreach ($list as $k=>$v) {
                $list[$k]['goods'] = $goods;
                $list[$k]['totalPrice'] = sprintf('%.2f', $totalPrice);
                $list[$k]['totalNum'] = (string)$goods_num;
            }

            //优惠券
            $data = M('shop_member_coupon')->alias('a')
                ->field('a.intime,b.end_time,b.end_strtotime,a.id')
                ->join('m_shop_coupon b ON a.coupon_id = b.coupon_id')
                ->where(['a.member_id'=>$member['user_id'],'a.status'=>'1','b.is_delete'=>'0','b.status'=>'2'])->select();
            if($data) {
                foreach ($data as $key => $val) {
                    if (time() > $val['end_strtotime']) {
                        M('shop_member_coupon')->where(['id' => $val['id']])->save(['status' => 3]);
                    }
                }
                $map['a.member_id'] = $member['user_id'];
                $map['a.status'] = '1';
                $map['b.is_delete'] = '0';
                $map['b.status'] = '2';
                $map['b.limit_value'] = ['elt', $totalPrice];
                $map['merchants_id'] = $goods[0]['merchants_id'];
                $coupon = M('shop_member_coupon')->alias('a')
                    ->field('a.id,a.coupon_id,b.title,b.img,b.limit_value,b.value,b.start_time,b.end_time,b.type,b.merchants_id')
                    ->join('m_shop_coupon b ON a.coupon_id = b.coupon_id')
                    ->where($map)->order('a.intime desc')->select();
                if (!empty($coupon)) {
                    foreach ($coupon as $k => $v) {
                        if ($v['type'] == 2) {
                            $merchants = M('shop_merchants')->where(['member_id' => $v['merchants_id']])->find();
                            $coupon[$k]['merchants_name'] = $merchants['merchants_name'];
                            $coupon[$k]['merchants_img'] = $merchants['merchants_img'];
                        } else {
                            $coupon[$k]['name'] = '通用优惠券';
                            $coupon[$k]['merchants_name'] = '';
                            $coupon[$k]['merchants_img'] = '';
                        }
                    }
                }else{
                   $coupon = []; 
                }
            }else{
                $coupon = [];
            }

            success(['list' => $list, 'amount' => sprintf('%.2f', $totalPrice), 'num' => (string)$goods_num, 'deduct_integral_value' => '0','deduct_value'=>'0','coupon'=>$coupon]);
        }

    }

    /**
     *下单
     */
    public function insertMallOrder(){
        if (IS_POST) {
            $member = checklogin();
            // $json = I('json');
            $json = $_POST['json'];
            if ($json) $json = json_decode($json, true);
            if (!$json['address_id']) error("收货地址错误");
            $address = M('shop_member_address')->where(['address_id' => $json['address_id']])->find();
            if (!$address) error("收货地址错误");
            if (empty($json['orderBeans'])) error("商品信息错误");
            $car_ids = I('car_ids');
            $amount = '0';
            $orderBeans = $json['orderBeans'];
            if($json['coupon_ids']){   //优惠券
                $coupon = M('shop_coupon')->alias('a')
                        ->field('a.limit_value,a.value')
                        ->join('m_shop_member_coupon b ON a.coupon_id = b.coupon_id')
                        ->where(['b.id'=>$json['coupon_ids']])
                        ->find();
            }
            foreach ($orderBeans as $k=>$v) {
                if (!$v['merchants_id']) error("商家信息错误");
                $totalPrice = '0';     //商铺订单小记
                $costPrice = '0';     //商铺订单成本价小记
                foreach ($v['orderGoodsBeans'] as $key=>$val) {
                    if (!$val['goods_id']) error("商品信息错误");
                    if (!$val['goods_num']) error("商品数量错误");
                    $goods = M('shop_goods')->where(['goods_id' => $val['goods_id']])->find();

                /*****************下单的时候减库存*****************/ 
                    if($goods){
                        if ($goods['goods_stock'] > $val['goods_num']) {
                            $goodsInfo['goods_stock'] = $goods['goods_stock'] - $val['goods_num'];
                            M('shop_goods')->where(['goods_id' => $val['goods_id']])->save($goodsInfo);
                            if ($val['specification_id']) {
                                $specification = M('shop_goods_relation_specification')->where(['specification_id' => $val['specification_id']])->find();
                                if ($specification) {
                                    if ($specification['specification_stock'] > $val['goods_num']) {
                                        $goodsSpecification['specification_stock'] = $specification['specification_stock'] - $val['goods_num'];
                                    } else {
                                        $goodsSpecification['specification_stock'] = '0';
                                    }
                                    $goodsSpecification['specification_sales'] = $specification['specification_sales'] + $val['goods_num'];
                                }
                                M('shop_goods_relation_specification')->where(['specification_id' => $val['specification_id']])->save($goodsSpecification);
                            }
                        } else {
                            $goodsInfo['goods_stock'] = '0';
                            M('shop_goods')->where(['goods_id' => $val['goods_id']])->save($goodsInfo);
                        }
                    }
                /*****************下单的时候减库存*****************/    


                    if ($val['specification_id']) {
                        $specification = M('shop_goods_relation_specification')->where(['specification_id' => $val['specification_id']])->find();
                        if ($specification) {
                            //$goods_sale_ratio = Db::name('goods')->where(['goods_id' =>$val['goods_id'] ])->value('sale_ratio');
                            $orderBeans[$k]['orderGoodsBeans'][$key]['specification_ids'] = $specification['specification_ids'];
                            $orderBeans[$k]['orderGoodsBeans'][$key]['specification_names'] = $specification['specification_names'];
                            $orderBeans[$k]['orderGoodsBeans'][$key]['specification_stock'] = $specification['specification_stock'];
                            $orderBeans[$k]['orderGoodsBeans'][$key]['specification_img'] = $specification['specification_img'];
                            $orderBeans[$k]['orderGoodsBeans'][$key]['specification_price'] = $specification['specification_sale_price'];
                            $orderBeans[$k]['orderGoodsBeans'][$key]['specification_id'] = $specification['specification_id'];
                            $orderBeans[$k]['orderGoodsBeans'][$key]['sale_ratio'] = $goods['sale_ratio'];
                            $totalPrice += $specification['specification_sale_price'] * $val['goods_num'];
                            $costPrice += $specification['specification_cost_price'] * $val['goods_num'];
                        }
                    } else {
                        $totalPrice += $goods['goods_now_price'] * $val['goods_num'];
                        $costPrice += $goods['cost_price'] * $val['goods_num'];
                        $orderBeans[$k]['orderGoodsBeans'][$key]['specification_ids'] = '';
                        $orderBeans[$k]['orderGoodsBeans'][$key]['specification_names'] = '';
                        $orderBeans[$k]['orderGoodsBeans'][$key]['specification_stock'] = $goods['goods_stock'];
                        $orderBeans[$k]['orderGoodsBeans'][$key]['specification_img'] = '';
                        $orderBeans[$k]['orderGoodsBeans'][$key]['specification_price'] = $goods['goods_now_price'];
                        $orderBeans[$k]['orderGoodsBeans'][$key]['sale_ratio'] = $goods['sale_ratio'];
                    }
                    $orderBeans[$k]['orderGoodsBeans'][$key]['goods_name'] = $goods['goods_name'];
                    $orderBeans[$k]['orderGoodsBeans'][$key]['goods_img'] = $goods['goods_img'];
                    $orderBeans[$k]['orderGoodsBeans'][$key]['merchants_id'] = $v['merchants_id'];
                    if($val['seller'] && $val['a_id']){
                        $orderBeans[$k]['orderGoodsBeans'][$key]['seller'] = $val['seller'];
                        // $orderBeans[$k]['orderGoodsBeans'][$key]['live_id'] = $val['live_id'];
                        $orderBeans[$k]['orderGoodsBeans'][$key]['a_id'] = $val['a_id'];
                    }else{
                        $orderBeans[$k]['orderGoodsBeans'][$key]['seller'] = 0;
                        $orderBeans[$k]['orderGoodsBeans'][$key]['a_id'] = 0;
                    }
                }
                $amount += $totalPrice;
                $orderBeans[$k]['totalPrice'] = $totalPrice;
                $orderBeans[$k]['costPrice'] = $costPrice;
            }

            if (!$amount) error("订单金额错误");

            if ($json['deduct_integral_value']) {
                if ($json['deduct_integral_value'] < $amount) {   //积分抵扣
                    $order['is_deduct_integral'] = 1;
                    $order['deduct_integral_value'] = $json['deduct_integral_value'];
                } else {
                    return error("无效积分抵扣");
                }
            }
            $order['order_no'] = rand(1000, 9999) . getMilliseconds();
            $order['order_actual_price'] = $amount - $json['deduct_integral_value']-$coupon['value'];
            $order['order_total_price'] = $amount - $json['deduct_integral_value'];
            $order['goods_total_price'] = $amount;
            $order['member_id'] = $member['user_id'];
            if($coupon['value']){
                $order['coupon_ids'] = $json['coupon_ids'];
                $order['coupon_value'] = $coupon['value'];
            }
            $order['create_time'] = date("Y-m-d H:i:s", time());

            // 启动事务
            M()->startTrans();
            if($json['coupon_ids']){
                $result = M('shop_member_coupon')->where(['id'=>$json['coupon_ids']])->save(['status'=>'2']);
                if(!$result){
                    M()->rollback();
                    error("下单失败");
                }
            }

            $result = M('shop_order')->add($order);
            if (!$result) {
                M()->rollback();
                error("下单失败");
            }

            foreach ($orderBeans as $k=>$v) {
                $order_merchants = [];
                $order_merchants['member_id'] = $member['user_id'];
                $order_merchants['merchants_id'] = $v['merchants_id'];
                $order_merchants['order_id'] = $result;
                $order_merchants['order_no'] = date("YmdHis", time()) . rand(10000, 99999);
                $order_merchants['address_id'] = $json['address_id'];
                $order_merchants['address_mobile'] = $address['address_mobile'];
                $order_merchants['address_name'] = $address['address_name'];
                $order_merchants['address_province'] = $address['address_province'];
                $order_merchants['address_city'] = $address['address_city'];
                $order_merchants['address_country'] = $address['address_country'];
                $order_merchants['address_detailed'] = $address['address_detailed'];
                $order_merchants['address_road'] = $address['address_road'];
                $order_merchants['address_zip_code'] = $address['address_zip_code'];
                $order_merchants['address_longitude'] = $address['address_longitude'];
                $order_merchants['address_latitude'] = $address['address_latitude'];
                $order_merchants['order_total_price'] = $v['totalPrice'];
                $order_merchants['cost_price'] = $v['costPrice'];
                $order_merchants['order_actual_price'] = sprintf('%.2f', $order['order_actual_price'] * $v['totalPrice'] / $amount);//按商品原价平均拆分子订单总额
                if ($json['deduct_integral_value']) {
                    $order_merchants['deduct_integral_price'] = sprintf('%.2f', $json['deduct_integral_value'] * $v['totalPrice'] / $amount);//按商品原价平均拆分子订单积分抵扣总额
                    $order_merchants['is_deduct_integral'] = 1;
                    $order_merchants['deduct_integral_percent'] = sprintf('%.2f', $v['totalPrice'] / $amount * 100) . '%';
                }
                $order_merchants['goods_total_price'] = $v['totalPrice'];
                $order_merchants['order_remark'] = $v['order_remark'];
                $order_merchants['create_time'] = date("Y-m-d H:i:s", time());
                $order_merchants['cancel_time'] = date("Y-m-d H:i:s", time());;
                $order_merchants['cancel_end_time'] = date("Y-m-d H:i:s", (time() + $this->cancel_time * 3600));
                $order_merchants['date'] = date("Y-m-d", time());
                $order_merchants_id = M('shop_order_merchants')->add($order_merchants);
                if (!$order_merchants_id) {
                    M()->rollback();
                    error("下单失败");
                }
                foreach ($v['orderGoodsBeans'] as $key=>$val) {
                    /**********平台抽成，主播分成**********/
                    $merchants_per = M('shop_merchants')->where(array('member_id'=>$v['merchants_id']))->getField('merchants_per');
                    $goods_per = M('shop_goods')->where(array('goods_id'=>$val['goods_id']))->getField('goods_per');
                    /**********平台抽成，主播分成**********/

                    $order_goods[] = [
                        'order_id' => $result,
                        'order_merchants_id' => $order_merchants_id,
                        'goods_name' => $val['goods_name'],
                        'goods_img' => $val['goods_img'],
                        'goods_id' => $val['goods_id'],
                        'goods_num' => $val['goods_num'],
                        'merchants_id' => $v['merchants_id'],
                        'seller' => $val['seller'],
                        // 'live_id' => $val['live_id'],
                        'a_id' => $val['a_id'],
                        'sale_ratio' => $val['sale_ratio'],
                        'specification_id' => $val['specification_id'],
                        'specification_ids' => $val['specification_ids'],
                        'specification_names' => $val['specification_names'],
                        'specification_stock' => $val['specification_stock'],
                        'specification_price' => $val['specification_price'],
                        'specification_img' => $val['specification_img'],
                        'create_time' => date("Y-m-d H:i:s", time()),
                        'merchants_per' =>$merchants_per,
                        'goods_per' =>$goods_per
                    ];
                }
            }
            $insertAll = M('shop_order_goods')->addAll($order_goods);
            if (!$insertAll) {
                M()->rollback();
                error("下单失败");
            } else {
                M()->commit(); 
            }

            M('shop_goods_shop_car')->where(['member_id'=>$member['user_id'],'car_id'=>['in',$car_ids]])->delete();
            success(['order_id' => $result, 'order_no' => $order['order_no']]);
        }
    }

    //订单根据状态分类
    public function queryOrderByState(){
        if (IS_POST) {
            $member = checklogin();
            M('shop_order_merchants')->where(['cancel_end_time'=>['lt',date("Y-m-d H:i:s",time())],'order_state'=>'wait_pay','is_delete'=>'0'])->save(['is_delete'=>'1']);
            $p = I('p');
            empty($p) && $p = 1;
            $pageSize = I('pagesize');
            $pageSize ? $pageSize : $pageSize = 10;
            $order_state = I('order_state');
            !empty($order_state) ? $map['a.order_state'] = $order_state :$map['a.order_state'] = ['in',['wait_pay','wait_send','wait_receive','wait_assessment','end','returns']];
            $map['a.member_id'] = $member['user_id'];
            $map['a.is_delete'] = '0';
            $map['a.order_type'] = 'goods';
            $list = M('shop_order_merchants')->alias('a')
                ->field('a.order_merchants_id,a.refund_state,a.settlement_state,a.order_state,a.order_no,a.merchants_id,a.order_actual_price,a.logistics_no,a.logistics_pinyin,a.logistics_name,b.merchants_name,b.merchants_img,b.contact_mobile')
                ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
                ->where($map)->order("a.create_time desc")->limit(($p - 1) * $pageSize, $pageSize)
                ->select();
        if($list){

            foreach ($list as &$v) {
                $totalNum = '0';
                $goods = M('shop_order_goods')->field('order_goods_id,goods_id,goods_num,goods_name,goods_img,specification_id,specification_ids,specification_names,specification_price,specification_img')
                    ->where(['order_merchants_id' => $v['order_merchants_id']])->select();
                foreach ($goods as &$val) {
                    if (!$val['specification_names']) {
                        $val['specification_names'] = '无';
                    }
                    $totalNum += $val['goods_num'];
                }
                $v['orderBeans'] = $goods;
                $v['totalNum'] = (string)$totalNum;
            }
        }else{
            $list = [];
        }

            $count = M('shop_order_merchants')->alias('a')
                ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
                ->where($map)->count();
            $page = ceil($count / $pageSize);
            success(['page' => $page, 'list' => $list]);
        }
    }

    //订单详情
    public function queryOrderView(){
        $member = checklogin();
        $order_merchants_id = I('order_merchants_id');
        $map['a.order_merchants_id'] = $order_merchants_id;
        $map['a.member_id'] = $member['user_id'];
        $order = M('shop_order_merchants')->alias('a')
            ->field('a.order_merchants_id,a.refund_state,a.order_id,a.order_state,a.settlement_state,a.order_no as pay_no,a.merchants_id,a.order_actual_price,b.merchants_name,b.merchants_img,b.merchants_name,b.contact_mobile,a.create_time,a.pay_time,a.send_time,a.receive_time,
            a.order_remark,a.deduct_integral_value,a.pay_way,c.order_no,a.address_mobile,a.address_name,a.address_province,a.address_city,address_country,a.address_longitude,a.address_latitude,a.address_detailed,a.logistics_no,a.logistics_pinyin,a.logistics_name,a.cancel_end_time,a.cancel_time')
            ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
            ->join('m_shop_order c ON a.order_id = c.order_id')
            ->where($map)->find();
        if($order){
            $totalNum = '0';
            $goods = M('shop_order_goods')->field('order_goods_id,goods_id,goods_num,goods_name,goods_img,specification_id,specification_ids,specification_names,specification_price,has_refund,specification_img')
                ->where(['order_merchants_id' => $order['order_merchants_id']])->select();
            if($goods) {
                $order['orderBeans'] = $goods;
                foreach ($goods as $key=>&$val) {
                    if (!$val['specification_names']) {
                        $val['specification_names'] = '无';
                    }
                    $totalNum += $val['goods_num'];

                    //查询售后id
                    if ($val['has_refund']){
                        $order_refund_where['order_goods_id'] = $val['order_goods_id'];
                        $order['orderBeans'][$key]['refund_id'] = M('shop_order_refund')->where($order_refund_where)->getField('refund_id');
                        //$order['orderBeans'][$key]['refund_id'] = Db::name('order_refund')->where($order_refund_where)->find();
                    }
                }


            }else{
                $order['orderBeans'] = [];
            }


            $order['totalNum'] = (string)$totalNum;
            $order['address']['address_mobile'] = $order['address_mobile'];
            $order['address']['address_name'] = $order['address_name'];
            $order['address']['address_province'] = $order['address_province'];
            $order['address']['address_city'] = $order['address_city'];
            $order['address']['address_country'] = $order['address_country'];
            $order['address']['address_longitude'] = $order['address_longitude'];
            $order['address']['address_latitude'] = $order['address_latitude'];
            $order['address']['address_detailed'] = $order['address_detailed'];
            success($order);
        }else{
            success((object)null);
        }
    }

    //取消订单
    public function cancelOrder(){
        $member = checklogin();
        $order_merchants_id = I('order_merchants_id');
        if(!$order_merchants_id)        error("请选择订单");
        $order_merchants = M('shop_order_merchants')->where(['order_merchants_id'=>$order_merchants_id])->find();
        if(!$order_merchants_id)        error("订单错误");
        $where = [
            'order_merchants_id'=>$order_merchants_id,
            'member_id'     =>$member['user_id'],
            'order_state'   => 'wait_pay'
        ];
        $result = M('shop_order_merchants')->where($where)->save(['order_state'=>'cancel','cancel_time'=>date("Y-m-d H:i:s",time())]);
        if($result){
            $order = M('shop_order')->where(['order_id'=>$order_merchants['order_id']])->find();
        /**********************取消订单的时候将库存加回去**************************/
            $order_goods = M('shop_order_goods')
                         ->where(array('order_id'=>$order_merchants['order_id']))
                         ->field('goods_id,goods_num,specification_id')
                         ->select();
            foreach ($order_goods as $key => &$val) {
                if($val['specification_id']){
                    M('shop_goods_relation_specification')->where(['specification_id' => $val['specification_id']])->setInc('specification_stock', $val['goods_num']);
                    M('shop_goods')->where(array('goods_id'=>$val['goods_id']))->setInc('goods_stock', $val['goods_num']);
                }else{
                    M('shop_goods')->where(array('goods_id'=>$val['goods_id']))->setInc('goods_stock', $val['goods_num']);
                }
            }


        /**********************取消订单的时候将库存加回去**************************/

            if($order['coupon_ids']) {
                $order = M('shop_order_merchants')->where(['order_id' => $order_merchants['order_id']])->getField('order_state',true);
                $order_state = ['returns', 'cancel'];
                foreach ($order as $v) {
                    if (in_array($v, $order_state)) {
                        $is_return = '1';
                    } else {
                        $is_return = '2';
                        break;
                    }
                }
                if ($is_return == '1'){
                    M('shop_member_coupon')->where(['id'=>$order['coupon_ids']])->save(['status'=>'1']);
                }
            }
            success("取消订单操作成功");
        }else{
            error("订单错误或状态不符合");
        }
    }

    //确认收货
    public function receiveOrder(){
        $member = checklogin();
        $order_merchants_id = I('order_merchants_id');
        if(!$order_merchants_id)        error("请选择订单");
        $where = [
            'order_merchants_id'=>$order_merchants_id,
            'member_id'     =>$member['user_id'],
            'order_state'   => 'wait_receive'
        ];
        // $merchants_id = M('shop_order_merchants')->where($where)->getField('merchants_id');
        // M("shop_merchants")->where(['member_id'=>$merchants_id])->setInc('total_sales');
        // M("shop_merchants")->where(['member_id'=>$member['user_id']])->setInc('month_sales');
        // $order_no = M('shop_order_merchants')->where($where)->getField('order_no');
        $result = M('shop_order_merchants')->where($where)->save(['order_state'=>'wait_assessment','receive_time'=>date("Y-m-d H:i:s",time())]);
        // $res = settle($order_no);
        if($result){
            set_message($member['user_id'],'订单已签收','2',$order_merchants_id);
            success("确认收货操作成功");
        }else{
            error("订单错误或状态不符合");
        }
    }

    /**
     *@催单
     */
    public function hurry_order()
    {
        if (IS_POST) {
            $member = checklogin();
            $order_merchants_id = I('order_merchants_id');
            empty($type)    &&  $type = 1;
            empty($order_merchants_id) ? error("参数错误") : true;
            $order = M('shop_order_merchants')->where(['order_merchants_id'=>$order_merchants_id])->find();
            $order['order_state'] != 'wait_send' ? error("该状态下无法操作") : true;
            $check = M('shop_order_hurry')
                ->where(['member_id' => $member['user_id'],'order_id' => $order['order_merchants_id'],'type'=>'1'])
                ->order("intime desc")->limit(1)->find();
            if ($check && time() - strtotime($check['intime']) < 3600) {
                error("催单过于频繁");
            } else {
                $data['member_id'] = $member['user_id'];
                $data['order_id'] = $order['order_merchants_id'];
                $data['intime'] = date("Y-m-d H:i:s", time());
                $data['type'] = $type;
                $result = M('shop_order_hurry')->add($data);
                if ($result) {
                    success("催单成功,商家会尽快为您发货哟");
                } else {
                    error("催单失败");
                }
            }
        }
    }

    //删除订单
    public function delOrder(){
        if (IS_POST) {
            $member = checklogin();
            $order_merchants_id = I('order_merchants_id');
            if (!$order_merchants_id) error("请选择订单");
            $where = [
                'order_merchants_id' => $order_merchants_id,
                'member_id' => $member['user_id'],
                'order_state' => ['in',['end','cancel','returns']]
            ];
            $result = M('shop_order_merchants')->where($where)->save(['is_delete' => '1']);
            if ($result) {
                success("删除订单操作成功");
            } else {
                error("订单错误或状态不符合");
            }
        }

    }

    //取消订单时间
    public function cancelTime(){
        $member = checklogin();
        $order_merchants_id = I('order_merchants_id');
        if(!$order_merchants_id)        error("请选择订单");
        $where = [
            'order_merchants_id'=>$order_merchants_id,
            'member_id'     =>$member['user_id'],
            'order_state'   =>'wait_pay'
        ];
        $result = M('shop_order_merchants')->where($where)->find();
        if($result){
            success($this->timediff(time(),strtotime($result['cancel_end_time'])));
        }else{
            error("订单错误");
        }
    }

    

    //订单退款
    public function return_order(){
        if (IS_POST) {
            $member = checklogin();
            $order_merchants_id = I('order_merchants_id');
            if (!$order_merchants_id) error("请选择订单");
            $where = [
                'order_merchants_id' => $order_merchants_id,
                'member_id' => $member['user_id'],
            ];
            $order_merchants = M('shop_order_merchants')->where($where)->find();
            if ($order_merchants['order_state'] != 'wait_send') {
                error("退款状态不符合，请选择售后服务");
            }
            if (time() - strtotime($order_merchants['pay_time']) > $this->return_time * 3600 *7*24) {
                error("可退款时间已过，请选择售后服务");
            }

            $pay_charge = json_decode($order_merchants['pay_charge'], true);

/****************************************退款**************************************************/            
            $obj = new PingxxController();
            $amount = $order_merchants['order_actual_price'];    //线上开启
            //$amount = 0.01;                                 //线上关闭
            $charge = $pay_charge['data']['object']['id'];

            $result = $obj->return_money($amount, $charge);

/****************************************退款**************************************************/            
            $result = json_decode($result, true);
            if (empty($result) || $result['error']) {
                error("退款失败");
            } else {
                M('shop_order_merchants')->where(['order_merchants_id' => $order_merchants_id])->save(['order_state' => 'returns']);
                $order = M('shop_order')->where(['order_id'=>$order_merchants['order_id']])->find();
                if($order['coupon_ids']) {
                    $order = M('shop_order_merchants')->where(['order_id' => $order_merchants['order_id']])->getField('order_state',true);
                    $order_state = ['returns', 'cancel'];
                    foreach ($order as $v) {
                        if (in_array($v, $order_state)) {
                            $is_return = '1';
                        } else {
                            $is_return = '2';
                            break;
                        }
                    }
                    if ($is_return == '1'){
                        M('shop_member_coupon')->where(['id'=>$order['coupon_ids']])->save(['status'=>'1']);
                    }
                }
                success("退款成功");
            }
        }

    }

    public function check_refund(){
        if (IS_POST) {
            $member = checklogin();
            $order_merchants_id = I('order_merchants_id');
            $where = [
                'order_merchants_id' => $order_merchants_id,
                'member_id' => $member['user_id'],
            ];
            $order = M('shop_order_merchants')->where($where)->find();
            if (!in_array($order['order_state'], ['wait_assessment', 'end'])) {
                error("订单错误或状态不符合");
            }
            $order_goods_id = I('order_goods_id');
            $result = M('shop_order_goods')->where(['order_merchants_id' => $order_merchants_id, 'order_goods_id' => $order_goods_id])->find();
            if (!$result) {
                error("参数错误");
            } else {
                $check = M('shop_order_refund')->where(['order_merchants_id' => $order_merchants_id, 'order_goods_id' => $order_goods_id])->find();
                if ($check) {
                    error("已存在该商品的售后记录");
                } else {
                    success("ok");
                }
            }
        }
    }

    public function apply_refund(){
        if (IS_POST) {
            $member = checklogin();
            $data = I('post.');
            $where = [
                'order_merchants_id' => $data['order_merchants_id'],
                'member_id' => $member['user_id'],
            ];
            $order = M('shop_order_merchants')->where($where)->find();
            if($order['receive_time'] != '0000-00-00 00:00:00'){
                if(time()-strtotime($order['receive_time'])>7*24*3600){
                    error("超过售后期限");
                }
            }
            if (!$order) error("参数错误");

            $rules = array(
                 array('order_merchants_id','require','参数错误'), 
                 array('order_goods_id','require','参数错误'), 
                 array('refund_count','require','数量必须填写'), 
                 array('refund_type','require','退货类型必须选择'), 
                 array('refund_reason','require','原因不能为空'),
                 
            );
            $User = M("shop_order_refund"); // 实例化User对象

            if (!$User->validate($rules)->create($data)){
                 // 如果创建失败 表示验证没有通过 输出错误提示信息
                 error($User->getError());
            }else{
                 // 验证通过 可以进行其他数据操作
                $check = M('shop_order_refund')->where(['order_merchants_id' => $data['order_merchants_id'], 'order_goods_id' => $data['order_goods_id']])->find();
                if ($check) error("不能多次提交");
                $goods = M('shop_order_goods')
                    ->field('order_goods_id,goods_id,goods_num,goods_name,goods_img,specification_id,specification_ids,specification_names,specification_price,has_refund')
                    ->where(['order_goods_id' => $data['order_goods_id']])->find();
                if (!$goods) error("参数错误");
                $goods['refund_price'] = sprintf('%.2f', $goods['specification_price'] * $order['order_actual_price'] / $order['order_total_price']);
                $data['refund_price'] = $goods['refund_price'] * $data['refund_count'];
                $data['refund_actual_price'] = $data['refund_price'];
                $data['order_no'] = $order['order_no'];
                $data['refund_no'] = rand(1000, 9999) . getMilliseconds();
                $data['merchants_id'] = $order['merchants_id'];
                $data['member_id'] = $member['user_id'];
                $model = D('OrderRefund');
                $result = $model->edit($data);
                if ($result) {
                    M('shop_order_goods')->where(['order_goods_id' => $data['order_goods_id']])->save(['has_refund'=>'1']);
                    M('shop_order_merchants')->where(['order_merchants_id'=>$order['order_merchants_id']])->save(['refund_state'=>1]);
                    success("申请信息提交成功");
                } else {
                    error("申请信息提交失败");
                }
            }

            
        }
    }

    //退换货原因
    public function order_refund_reason(){
        $list = M('shop_order_refund_reason')->where(['is_delete'=>'0'])->order("sort asc")->select();
        success($list);
    }

    //退换货商品信息
    public function refund_goods(){
        $member = checklogin();
        $order_merchants_id = I('order_merchants_id');
        $where = [
            'order_merchants_id'=>$order_merchants_id,
            'member_id'     =>$member['user_id'],
        ];
        $order_goods_id = I('order_goods_id');
        $order = M('shop_order_merchants')->where($where)->find();
        $goods = M('shop_order_goods')
            ->field('order_goods_id,goods_id,goods_num,goods_name,goods_img,specification_id,specification_ids,specification_names,specification_price,has_refund')
            ->where(['order_goods_id'=>$order_goods_id])->find();
        if(!$goods)     error("参数错误");
        $goods['refund_price'] = sprintf('%.2f',$goods['specification_price'] * $order['order_actual_price'] / $order['order_total_price']);
        success($goods);

    }

    //售后订单
    public function refund_order(){
        $member = checklogin();
        $p = I('p');
        $p ? $p : $p = 1;
        $pagesize = I('pagesize');
        $pagesize ? $pagesize : $pagesize = 10;
        $where['a.member_id'] = $member['user_id'];
        $where['a.is_delete'] = 0;
        $count = M('shop_order_refund')->alias('a')
            ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
            ->join('m_shop_order_goods c ON a.order_goods_id = c.order_goods_id')
            ->where($where)->count();
        $page = ceil($count/$pagesize);
        $list = M('shop_order_refund')->alias('a')
            ->field('a.*,b.merchants_name,b.merchants_img,c.goods_name,c.goods_img,c.specification_names,c.specification_price')
            ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
            ->join('m_shop_order_goods c ON a.order_goods_id = c.order_goods_id')
            ->limit(($p-1)*$pagesize,$pagesize)
            ->where($where)->order("a.create_time desc")
            ->select();
        success(['page'=>$page,'list'=>$list]);
    }

    //售后订单
    public function refund_order_view(){
        $member = checklogin();
        $refund_id = I('refund_id');
        if(!$refund_id)     error("参数错误");
        /**
         * 店铺名称
         * 店铺照片
         * 商品名称
         * 商品图片
         * 型号名称
         * 型号价格
         * 商家电话
         *
        */
        $refund = M('shop_order_refund')->alias('a')
            ->field('a.*,b.merchants_name,b.contact_mobile,b.merchants_img,c.goods_name,c.goods_img,c.specification_names,c.specification_price')
            ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
            ->join('m_shop_order_goods c ON a.order_goods_id = c.order_goods_id')
            ->where(['a.refund_id'=>$refund_id,'a.member_id'=>$member['user_id']])
            ->find();
        success($refund);
    }

    //取消售后
    public function del_refund(){
        $member = checklogin();
        $refund_id = I('refund_id');
        $refund = M('shop_order_refund')->where(['refund_id'=>$refund_id])->find();
        $result = M('shop_order_refund')->where(['member_id'=>$member['user_id'],'refund_id'=>$refund_id])->save(['is_delete'=>'1']);
        if($result){
            M('shop_order_goods')->where(['order_goods_id'=>$refund['order_goods_id']])->save(['has_refund'=>'0']);
            success("取消售后成功");
        }else{
            error("取消售后失败");
        }
    }

    /**
     *@商品评价
     */
    public function comment_goods()
    {
        if (IS_POST) {
            $member = checklogin();
            $order_merchants_id = I('order_merchants_id');
            if(empty($order_merchants_id))        error("订单id不能为空");
            $order = M('shop_order_merchants')->where(['order_merchants_id'=>$order_merchants_id])->find();
            if(!$order)             error("订单错误");
            if($order['order_state'] != 'wait_assessment')      error("订单状态错误");
            $content = $_POST['content'];
            $merchants['express_mark'] = I('express_mark');
            $merchants['service_mark'] = I('service_mark');
            $merchants['merchants_id'] = $order['merchants_id'];
            if(!$merchants['express_mark'] || $merchants['express_mark']>5){
                error("店铺物流评分错误");
            }
            if(!$merchants['service_mark'] || $merchants['service_mark']>5){
                error("店铺服务评分错误");
            }
            $create_time = date("Y-m-d H:i:s",time());
            if(!empty($content)){
            // $content=str_replace('\&quot;','"',$content); 
            // print_r($content);exit;
            // $content = stripslashes($content);
            // print_r($content);exit;

                $content = json_decode($content,true);

                foreach ($content as $key=>$v){
                    if(!$v['mark'] || $v['mark']>5){
                        error("商品评分错误");
                    }else{
                        $goods_comment[$key]['mark'] = $v['mark'];
                        // $goods_comment['mark'] = I('mark');
                    }
                    if(empty($v['comment_desc'])){
                        if($v['mark'] > 3){
                            $goods_comment[$key]['comment_desc'] = '好评!好评!';
                        }else{
                            $goods_comment[$key]['comment_desc'] = '中评';
                        }
                    }else{
                        $goods_comment[$key]['comment_desc'] = $v['comment_desc'];
                    }
                    // if(empty(I('comment_desc'))){
                    //     if(I('mark') > 3){
                    //         $goods_comment['comment_desc'] = '好评!好评!';
                    //     }else{
                    //         $goods_comment['comment_desc'] = '中评';
                    //     }
                    // }else{
                    //     $goods_comment['comment_desc'] = I('comment_desc');
                    // }

                    $goods_comment[$key]['order_merchants_id'] = $order_merchants_id;
                    $goods_comment[$key]['order_no'] = $order['order_no'];
                    $goods_comment[$key]['merchants_id'] = $order['merchants_id'];
                    if(!empty($v['img'])){
                        $goods_comment[$key]['img'] = $v['img'];
                    }else{
                        $goods_comment[$key]['img'] = '';
                    }
                    // if(!empty(I('img'))){
                    //     $goods_comment['img'] = I('img');
                    // }else{
                    //     $goods_comment['img'] = '';
                    // }

                    $goods_comment[$key]['member_id'] = $member['user_id'];
                    $goods_comment[$key]['create_time'] = $create_time;
                    if(!$v['goods_id']){
                        error("商品信息错误");
                    }else{
                        $goods_comment[$key]['goods_id'] = $v['goods_id'];
                        $goods[] = $v['goods_id'];
                    }
                    // if(!I('goods_id')){
                    //     error("商品信息错误");
                    // }else{
                    //     $goods_comment['goods_id'] = I('goods_id');
                    //     $goods[] = I('goods_id');
                    // }
                }
            }else{
                error("评论信息错误");
            }
            if(empty($goods_comment))         error("评论信息错误");
            // print_r($goods_comment);exit;
            // $result = M('shop_goods_comment')->addAll($goods_comment);
            $result = M('shop_goods_comment')->addAll($goods_comment);
            
            // echo M()->getLastSql();exit;
            if($result){
                $merchants['member_id'] = $member['user_id'];
                $merchants['create_time'] = $create_time;
                M('shop_merchants_comment')->add($merchants);
                M('shop_order_merchants')->where(['order_merchants_id'=>$order_merchants_id])->save(['order_state'=>'end']);
                M('shop_goods')->where(['goods_id'=>['in',$goods]])->setInc('comment_count');
                $goods_comment_star = M('shop_goods_comment')->where(['merchants_id'=>$order['merchants_id']])->sum('mark');
                $goods_comment_count = M('shop_goods_comment')->where(['merchants_id'=>$order['merchants_id']])->count();

                $merchant['merchants_star1'] = sprintf('%.2f',($goods_comment_star+5)/($goods_comment_count+1));//商品评分

                $merchant_comment_count = M('shop_merchants_comment')->where(['merchants_id'=>$order['merchants_id']])->count();
                $merchant_comment_service = M('shop_merchants_comment')->where(['merchants_id'=>$order['merchants_id']])->sum('service_mark');
                $merchant_comment_express = M('shop_merchants_comment')->where(['merchants_id'=>$order['merchants_id']])->sum('express_mark');

                $merchant['merchants_star2'] = sprintf('%.2f',($merchant_comment_service+5)/($merchant_comment_count+1));//服务评分
                $merchant['merchants_star3'] = sprintf('%.2f',($merchant_comment_express+5)/($merchant_comment_count+1));//服务评分
                success("评论成功");
            }else{
                error("评价失败");
            }
        }
    }

    //商家申请支付定金
   public function insert_merchants_deposit(){
        $member = checklogin();
        $merchant = M('shop_merchants')->where(['member_id'=>$member['user_id']])->find();
        if(!$merchant)          error("请先填写申请资料");
        if($merchant['apply_state'] != '2')         error("资料未被审核，不能支付");
        if($merchant['pay_state'] != '0')           error("已通过支付，不能重复支付");
        $system = M('system')->where(['id'=>'1'])->find();
        $type = I('type');
        $openid = I('openid');
        $order['order_no'] = rand(1000, 9999) . getMilliseconds();
        $order['amount'] = $system['deposit'];
        $order['member_id'] = $member['user_id'];
        $order['create_time'] = date("Y-m-d H:i:s",time());
        $order['order_state'] = 'wait_pay';
        $order['pay_way'] = $type;
        $result = M('shop_merchants_deposit_order')->add($order);
/*******************************************************************************************/
        if($result){
            $obj = new PingxxController();
            $obj->ping3($order['order_no'],$order['amount'],$type,$openid);
        }else{
            error("下单失败");
        }
/*******************************************************************************************/


   }

   //订单信息
    public function getOrderView(){
       $member = checklogin();
       $order_no = I('order_no');
       if(!$order_no)           error('参数错误');
       $order = M('shop_order')->where(['member_id'=>$member['user_id'],'order_no'=>$order_no])->find();
       if(!$order){
           error('订单错误');
       }
       $order_merchants = M('shop_order_merchants')->where(['order_id'=>$order['order_id']])->find();
       $address_mobile = hideStr($order_merchants['address_mobile'],3);
       $order_merchants['cancel_end_time'] = strtotime($order_merchants['cancel_end_time']);
       success(['cancel_end_time'=>$order_merchants['cancel_end_time'],'address_mobile'=>$address_mobile,'amount'=>$order['order_actual_price'],'address_name'=>$order_merchants['address_name'],'address_province'=>$order_merchants['address_province'],
       'address_city'=>$order_merchants['address_city'],'address_country'=>$order_merchants['address_country'],'address_detailed'=>$order_merchants['address_detailed']]);
    }

    //订单信息
    public function getMerchantOrderView(){
        $member = checklogin();
        $order_no = I('order_no');
        if(!$order_no)           error('参数错误');
        $order_merchants = M('shop_order_merchants')->where(['order_no'=>$order_no,'member_id'=>$member['user_id']])->find();
        $address_mobile = hideStr($order_merchants['address_mobile'],3);
        $order_merchants['cancel_end_time'] = strtotime($order_merchants['cancel_end_time']);
        success(['cancel_end_time'=>$order_merchants['cancel_end_time'],'address_mobile'=>$address_mobile,'amount'=>$order_merchants['order_actual_price'],'address_name'=>$order_merchants['address_name'],'address_province'=>$order_merchants['address_province'],
            'address_city'=>$order_merchants['address_city'],'address_country'=>$order_merchants['address_country'],'address_detailed'=>$order_merchants['address_detailed']]);
    }


}