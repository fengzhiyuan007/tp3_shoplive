<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/10/30
 * Time: 上午11:09
 */
namespace Merchant\Controller;

use Think\Db;
use Psr\Log\Test\DummyTest;

use Org\Util\Date;
use Think\Upload;
use Think\Controller;

class HorderController extends CommonController
{

    protected function get_order_count($map){
        $count = M('shop_order_merchants')
                ->alias('a')
                ->join('m_user b ON a.member_id = b.user_id')
                // ->join('m_shop_merchants c ON a.merchants_id = c.member_id')
                ->where($map)
                ->count();
        return $count;
    }

    protected function get_order_where(){
        $merchant = session('shop');
        $map['a.order_type'] = 'goods';
        $map['merchants_id'] = $merchant['member_id'];
        $order_no = I('order_no');
        if($order_no)                  $map['a.order_no|a.address_name|a.address_mobile|b.username|b.phone'] = ['like','%'.$order_no.'%'];
        $start_time = I('start_time');
        $end_time = I('end_time');
        if($start_time && !$end_time){
            $start_time = urldecode($start_time);
            $map['a.create_time'] = ['gt',$start_time];
        }else if($end_time && !$start_time){
            $end_time = urldecode($end_time);
            $map['a.create_time'] = ['lt',$end_time];
        }else if($start_time && $end_time){
            $map['a.create_time'] = ['between',[$start_time,$end_time]];
        }
        $map['a.is_delete'] = '0';
        return $map;
    }


    protected function get_order($map,$p){
        $order_no = I('order_no');
        $order_state = I('order_state');
        $start_time = I('start_time');
        $end_time = I('end_time');
        $merchants_id = I('merchants_id');
        $start_time && $start_time = urldecode($start_time);
        $end_time && $end_time = urldecode($end_time);
        $list = M('shop_order_merchants')
                ->alias('a')
                ->field('a.*,b.username,b.phone')
                ->join('m_user b ON a.member_id = b.user_id')
                // ->join('m_shop_merchants c ON a.merchants_id = c.member_id')
                ->where($map)
                ->order("a.create_time desc")
                ->limit($p->firstRow.','.$p->listRows)
                ->select();
        return $list;
    }

    protected function down_horder($map){
        $dat = M('shop_order_merchants')
                ->alias('a')
                ->field('a.*,b.username,b.phone')
                ->join('m_user b ON a.member_id = b.user_id')
                // ->join('m_shop_merchants c ON a.merchants_id = c.member_id')
                ->where($map)
                ->order("a.create_time desc")
                ->select();
        
        $str = '商品订单'.date('YmdHis');
        header('Content-Type: application/download');
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename={$str}.csv");
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo "\xEF\xBB\xBF"."序号,订单号,订单收件人,收件人电话,订单总金额,实付金额,使用积分,成本价,下单会员,会员手机号,订单类型,订单状态,商品信息,快递公司,快递单号,下单时间"."\t\n";
        foreach ($dat as $k=>$v){
            $goods = M('shop_order_goods')
                    ->where(['order_merchants_id'=>$v['order_merchants_id']])
                    ->select();
            foreach($goods as $key=>$val){
                $v['detail'] .= '商品名：'.$val['goods_name'].'，数量：'.$val['goods_num'].'，型号：'.$val['specification_names'];
            }
            switch ($v['order_type']){
                case 'goods':
                    $v['order_type'] = '正常下单';
                    break;
                case 'group':
                    $v['order_type'] = '团购下单';
                    break;
            }
            switch ($v['order_state']){
                case 'cancel':
                    $v['order_state'] = '已取消';
                    break;
                case 'wait_pay':
                    $v['order_state'] = '待付款';
                    break;
                case 'wait_send':
                    $v['order_state'] = '待发货';
                    break;
                case 'wait_receive':
                    $v['order_state'] = '待收货';
                    break;
                case 'wait_assessment':
                    $v['order_state'] = '待评价';
                    break;
                case 'end':
                    $v['order_state'] = '订单完成';
                    break;
                case 'returns':
                    $v['order_state'] = '已退款';
                    break;
            }
            $key = $k +1;
            echo $key.","
                .$v["order_no"]."\t,"
                .$v["address_name"]."\t,"
                .$v["address_mobile"]."\t,"
                .$v["order_total_price"]."\t,"
                .$v["order_actual_price"]."\t,"
                .$v["deduct_integral_price"]."\t,"
                .$v["cost_price"]."\t,"
                .$v["username"]."\t,"
                .$v["phone"]."\t,"
                .$v["order_type"]."\t,"
                .$v["order_state"]."\t,"
                .$v["detail"]."\t,"
                .$v["logistics_name"]."\t,"
                .$v["logistics_no"]."\t,"
                .$v["create_time"]."\t,"
                ."\n";
        }

    }

    


    /**
     *@今日新增订单
     */

    public function index(){
        $merchant = session('shop');
        $today = date("Y-m-d 00:00:00",time());
        $map['a.create_time'] = ['gt',$today];
        $map['a.order_type'] = 'goods';
        $map['a.merchants_id'] = $merchant['member_id'];
        $order_state = I('order_state');
        if($order_state)               $map['a.order_state'] = $order_state;
        $order_no = I('order_no');
        if($order_no)                  $map['a.order_no|a.address_name|a.address_mobile|b.username|b.phone'] = ['like','%'.$order_no.'%'];
        $map['a.is_delete'] = '0';
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = $this->get_order_count($map);

        $p = getpage($count,$nus);

        $list  = $this->get_order($map,$p);
        $this->assign("show",$p->show());
        
        $this->assign(['list'=>$list,'count'=>$count]);
        $act = I("act");
        if($act=="download"){
            $this->down_horder($map);
            die;
        }else{
            $url =$_SERVER['REQUEST_URI'];
            session('url',$url);
            $this->assign ('pagetitle', '今日订单');
            $this->display();
        }
    }


    public function searchMerchant(){
        if(IS_AJAX) {
            $name = I('name');
            $name && $map['merchants_name'] = ['like', '%' . $name . '%'];
            $map['is_delete'] = '0';
            $map['apply_state'] = '2';
            $merchants = M('shop_merchants')->where($map)->select();
            $type_list = "<option value=''>请选择商家店铺</option>";
            if ($merchants) {
                foreach ($merchants as $v) {
                    $type_list .= '<option value=' . $v['member_id'] . '>' . $v['merchants_name'] . '</option>';
                }
            }
            echo $type_list;
        }
    }

    /**
     *@全部订单
     */
    public function to_all_order(){
        $order_state = I('order_state');
        $map = $this->get_order_where();
        if($order_state)               $map['a.order_state'] = $order_state;
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = $this->get_order_count($map);
        $p = getpage($count,$nus);
        $list  = $this->get_order($map,$p);
        $this->assign("show",$p->show());
        
        $this->assign(['list'=>$list,'count'=>$count]);
        $act = I("act");
        if($act=="download"){
            $this->down_horder($map);
        }else{
            $url =$_SERVER['REQUEST_URI'];
            session('url',$url);
            $this->assign ('pagetitle', '全部订单');
            $this->display();
        }
    }


    /**
     *@待支付订单
     */

    public function to_be_pay(){
        $map = [];
        $order_state = I('order_state');
        $map = $this->get_order_where();
        $order_state ? $map['order_state'] = $order_state : $map['order_state'] = 'wait_pay';
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = $this->get_order_count($map);
        $p = getpage($count,$nus);
        $list  = $this->get_order($map,$p);
        $this->assign("show",$p->show());
        $this->assign(['list'=>$list,'count'=>$count]);
        $act = I("act");
        if($act=="download"){
            $this->down_horder($map);
        }else{
            $url =$_SERVER['REQUEST_URI'];
            session('url',$url);
            $this->assign ('pagetitle', '待支付订单');
            $this->display();
        }
    }

    /**
     *@待发货
     */

    public function to_be_drawer(){
        $map = [];
        $order_state = I('order_state');
        $map = $this->get_order_where();
        $order_state ? $map['order_state'] = $order_state : $map['order_state'] = 'wait_send';
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = $this->get_order_count($map);
        $p = getpage($count,$nus);
        $list  = $this->get_order($map,$p);
        $this->assign("show",$p->show());
        $this->assign(['list'=>$list,'count'=>$count]);
        $act = I("act");
        if($act=="download"){
            $this->down_horder($map);
        }else{
            $url =$_SERVER['REQUEST_URI'];
            session('url',$url);
            $this->assign ('pagetitle', '待发货订单');
            $this->display();
        }
    }

    /**
     *@待收货订单
     */
    public function to_be_accept(){
        $map = [];
        $order_state = I('order_state');
        $map = $this->get_order_where();
        $order_state ? $map['order_state'] = $order_state : $map['order_state'] = 'wait_receive';
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = $this->get_order_count($map);
        $p = getpage($count,$nus);
        $list  = $this->get_order($map,$p);
        $this->assign("show",$p->show());
        $this->assign(['list'=>$list,'count'=>$count,'page'=>$page]);
        $act = I("act");
        if($act=="download"){
            $this->down_horder($map);
        }else{
            $url =$_SERVER['REQUEST_URI'];
            session('url',$url);
            $this->assign ('pagetitle', '待收货订单');
            $this->display();
        }
    }

    /**
     *@待评价订单
     */
    public function to_be_check(){
        $order_state = I('order_state');
        $map = $this->get_order_where();
        $order_state ? $map['order_state'] = $order_state : $map['order_state'] = 'wait_assessment';
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = $this->get_order_count($map);
        $p = getpage($count,$nus);
        $list  = $this->get_order($map,$p);
        $this->assign("show",$p->show());
        
        $this->assign(['list'=>$list,'count'=>$count]);
        $act = I("act");
        if($act=="download"){
            $this->down_horder($map);
        }else{
            $url =$_SERVER['REQUEST_URI'];
            session('url',$url);
            $this->assign ('pagetitle', '待评价订单');
            $this->display();
        }
    }

    /**
     *@已完成订单
     */

    public function complete(){
        $order_state = I('order_state');
        $map = $this->get_order_where();
        $order_state ? $map['order_state'] = $order_state : $map['order_state'] = 'end';
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = $this->get_order_count($map);
        $p = getpage($count,$nus);
        $list  = $this->get_order($map,$p);
        $this->assign("show",$p->show());
        $this->assign(['list'=>$list,'count'=>$count]);
        $act = I("act");
        if($act=="download"){
            $this->down_horder($map);
        }else{
            $url =$_SERVER['REQUEST_URI'];
            session('url',$url);
            $this->assign ('pagetitle', '已完成订单');
            $this->display();
        }
    }

    /**
     *@已取消订单
     */
    

    public function cancel_order(){
        $order_state = I('order_state');
        $map = $this->get_order_where();
        $order_state ? $map['order_state'] = $order_state : $map['order_state'] = 'cancel';
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = $this->get_order_count($map);
        $p = getpage($count,$nus);
        $list  = $this->get_order($map,$p);
        $this->assign("show",$p->show());
        $this->assign(['list'=>$list,'count'=>$count]);
        $act = I("act");
        if($act=="download"){
            $this->down_horder($map);
        }else{
            $url =$_SERVER['REQUEST_URI'];
            session('url',$url);
            $this->assign ('pagetitle', '已取消订单');
            $this->display();
        }
    }

    /**
     *@已退款订单
     */
    public function to_be_returns(){
        $order_state = I('order_state');
        $map = $this->get_order_where();
        $order_state ? $map['order_state'] = $order_state : $map['order_state'] = 'returns';
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = $this->get_order_count($map);
        $p = getpage($count,$nus);
        $list  = $this->get_order($map,$p);
        $this->assign("show",$p->show());
        $this->assign(['list'=>$list,'count'=>$count]);
        $act = I("act");
        if($act=="download"){
            $this->down_horder($map);
        }else{
            $url =$_SERVER['REQUEST_URI'];
            session('url',$url);
            $this->assign ('pagetitle', '已退款订单');
            $this->display();
        }
    }

    /**
     *@售后订单
     */
    // public function refund(){
    //     $merchant_id = I('merchants_id');
    //     !empty($merchant_id)  && $map['a.merchants_id'] = $merchant_id;
    //     $refund_type = I('refund_type');
    //     $refund_state = I('refund_state');
    //     !empty($refund_type)        &&      $map['refund_type'] = $refund_type;
    //     !empty($refund_state)        &&      $map['refund_state'] = $refund_state;
    //     $order_no = I('refund_no');
    //     if($order_no)                  $map['a.order_no|a.refund_no|b.username|b.phone'] = ['like','%'.$order_no.'%'];
    //     $map['a.is_delete'] = '0';
    //     //每页显示几条
    //     if (isset($_GET['nums'])){
    //         $nus  = intval($_GET['nums']);
    //     }else {
    //         $nus  = 10;
    //     }
    //     $this->assign("nus",$nus);

    //     $count = M('shop_order_refund')->alias('a')
    //         ->join('m_user b ON a.member_id = b.user_id')
    //         ->join('m_shop_merchants c ON a.merchants_id = c.member_id')
    //         ->where($map)->count();

    //     $p = getpage($count,$nus);

    //     $list = M('shop_order_refund')->alias('a')
    //         ->field('a.refund_id,a.refund_type,a.refund_no,a.refund_count,a.order_no,a.refund_reason,a.refund_desc,a.refund_img,a.refund_state,a.refund_price
    //                 ,b.username,b.phone,a.create_time,c.merchants_name')
    //         ->join('m_user b ON a.member_id = b.user_id')
    //         ->join('m_shop_merchants c ON a.merchants_id = c.member_id')
    //         ->where($map)
    //         ->order('a.create_time desc')
    //         ->limit($p->firstRow.','.$p->listRows)
    //         ->select();

    //     $this->assign("show",$p->show());
    //     $merchant = $this->merchant();
    //     $this->assign(['list'=>$list,'count'=>$count,'merchant'=>$merchant]);
    //     $act = I("act");
    //     if($act=="download"){
    //         $this->down_refund_horder($map);
    //     }else{
    //         $url =$_SERVER['REQUEST_URI'];
    //         session('url',$url);
    //         $this->display();
    //     }
    // }

    public function refund(){
        $merchant = session('shop');
        $map['a.merchants_id'] = $merchant['member_id'];
        $refund_type = I('refund_type');
        $refund_state = I('refund_state');
        !empty($refund_type)        &&      $map['refund_type'] = $refund_type;
        !empty($refund_state)        &&      $map['refund_state'] = $refund_state;
        $order_no = I('refund_no');
        if($order_no)                  $map['a.refund_no|b.username|b.phone'] = ['like','%'.$order_no.'%'];
        $map['a.is_delete'] = '0';
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);

        $count = M('shop_order_refund')->alias('a')
            ->join('m_user b ON a.member_id = b.user_id')
            ->where($map)->count();
        $p = getpage($count,$nus);
            
        $list = M('shop_order_refund')->alias('a')
            ->field('a.refund_id,a.refund_type,a.refund_no,a.refund_count,a.order_no,a.refund_reason,a.refund_desc,a.refund_img,a.refund_state,a.refund_price
                    ,b.username,b.phone,a.create_time')
            ->join('m_user b ON a.member_id = b.user_id')
            ->where($map)
            ->order('a.create_time desc')
            ->limit($p->firstRow.','.$p->listRows)
            ->select();

        $this->assign("show",$p->show());
        
        $this->assign(['list'=>$list,'count'=>$count]);
        $act = I("act");
        if($act=="download"){
            $this->down_horder($map);
        }else{
            $url =$_SERVER['REQUEST_URI'];
            session('url',$url);
            $this->assign ('pagetitle', '售后订单');
            $this->display();
        }
    }

    protected function down_refund_horder($map){
        $dat = M('shop_order_refund')
                ->alias('a')
                ->field('a.*,b.username,b.phone')
                ->join('m_user b ON a.member_id = b.user_id')
                ->join('m_shop_merchants c ON a.merchants_id = c.member_id')
                ->where($map)
                ->order("a.create_time desc")
                ->select();
        $str = '商品订单'.date('YmdHis');
        header('Content-Type: application/download');
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename={$str}.csv");
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo "\xEF\xBB\xBF"."序号,订单号,订单收件人,收件人电话,订单总金额,实付金额,使用积分,成本价,下单会员,会员手机号,订单类型,订单状态,商品信息,快递公司,快递单号,下单时间"."\t\n";
        foreach ($dat as $k=>$v){
            $goods = M('shop_order_goods')
                    ->where(['order_merchants_id'=>$v['order_merchants_id']])
                    ->select();
            foreach($goods as $key=>$val){
                $v['detail'] .= '商品名：'.$val['goods_name'].'，数量：'.$val['goods_num'].'，型号：'.$val['specification_names'];
            }
            switch ($v['refund_type']){
                case '1':
                    $v['refund_type'] = '换货订单';
                    break;
                case '2':
                    $v['refund_type'] = '退货订单';
                    break;
            }
            switch ($v['refund_state']){
                case 'wait_review':
                    $v['refund_state'] = '待审核';
                    break;
                case 'accept':
                    $v['refund_state'] = '接受';
                    break;
                case 'refuse':
                    $v['refund_state'] = '拒绝';
                    break;
                case 'end':
                    $v['refund_state'] = '退款成功';
                    break;
                
            }
            $key = $k +1;
            echo $key.","
                .$v["order_no"]."\t,"
                .$v["address_name"]."\t,"
                .$v["address_mobile"]."\t,"
                .$v["order_total_price"]."\t,"
                .$v["order_actual_price"]."\t,"
                .$v["deduct_integral_price"]."\t,"
                .$v["cost_price"]."\t,"
                .$v["username"]."\t,"
                .$v["phone"]."\t,"
                .$v["refund_type"]."\t,"
                .$v["refund_state"]."\t,"
                .$v["detail"]."\t,"
                .$v["logistics_name"]."\t,"
                .$v["logistics_no"]."\t,"
                .$v["create_time"]."\t,"
                ."\n";
        }

    }

    /**
     *@删除订单列表
     */

    public function is_del_order(){
        $map = [];
        $merchant = session('shop');
        $map['a.order_type'] = 'goods';
        $map['merchants_id'] = $merchant['member_id'];
        $order_no = I('order_no');
        if($order_no)                  $map['a.order_no|a.address_mobile|b.username|b.phone'] = ['like','%'.$order_no.'%'];
        $start_time = I('start_time');
        $end_time = I('end_time');
        if($start_time){
            $start_time = urldecode($start_time);
        }
        if($start_time){
            $start_time = urldecode($start_time);
            $map['create_time'] = ['gt',$start_time];
        }
        if($end_time){
            $end_time = urldecode($end_time);
            $map['create_time'] = ['lt',$end_time];
        }
        $map['a.is_delete'] = '1';
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = $this->get_order_count($map);
        $p = getpage($count,$nus);
        $list  = $this->get_order($map,$p);

        $this->assign("show",$p->show());
        $this->assign(['list'=>$list,'count'=>$count]);
        $act = I("act");
        if($act=="download"){
            $this->down_horder($map);
        }else{
            $url =$_SERVER['REQUEST_URI'];
            session('url',$url);
            $this->assign ('pagetitle', '已删除订单');
            $this->display();
        }

    }

    /**
     *@删除订单
     */
    public function del_order(){
        if(IS_AJAX) {
            $id = I('ids');
            $map['order_merchants_id'] = array('in', $id);
            $data['is_delete'] = 1;
            $result = M('shop_order_merchants')->where($map)->save($data);
            if ($result) {
                $id = explode(',',$id);
                if (is_array($id)) {
                    foreach ($id as $val) {
                        $this->work_log($table = 'order_merchants', $record_id = $val,'1', $work = '删除了订单记录');
                    }
                } else {
                    $this->work_log($table = 'order_merchants', $record_id = $id,'1', $work = '删除了订单记录');
                }
                success(['info' => '删除记录成功!', 'url' => session('url')]);
            } else {
                error('删除记录失败!');
            }
        }
    }

    /**
     *@删除售后
     */
    public function del_refund(){
        if(IS_AJAX) {
            $id = I('ids');
            $map['refund_id'] = array('in', $id);
            $data['is_delete'] = 1;
            $result = M('shop_order_refund')->where($map)->save($data);
            if ($result) {
                $id = explode(',',$id);
                if (is_array($id)) {
                    foreach ($id as $val) {
                        $this->work_log($table = 'order_refund', $record_id = $val,'1', $work = '删除了售后订单记录');
                    }
                } else {
                    $this->work_log($table = 'order_refund', $record_id = $id,'1', $work = '删除了售后订单记录');
                }
                success(['info' => '删除记录成功!', 'url' => session('url')]);
            } else {
                error('删除记录失败!');
            }
        }
    }

    /**
     *@真实删除订单
     */
    public function del_order_true(){
        if(IS_AJAX) {
            $id = I('ids');
            $data['order_merchants_id'] = array('in', $id);
            $result = M('shop_order_merchants')->where($data)->delete();
            if ($result) {
                success(array('info' => '删除记录成功!', 'url' => session('url')));
            } else {
                error('删除记录失败!');
            }
        }
    }


    /**
     *@恢复订单
     */
    public function recovery_order(){
        $id = I('ids');
        $data['order_merchants_id'] = array('in',$id);
        $result = M('shop_order_merchants')->where($data)->save(['is_delete'=>'0']);
        if($result){
            $id = explode(',',$id);
            if (is_array($id)) {
                foreach ($id as $val) {
                    $this->work_log($table = 'order_merchants', $record_id = $val,'1', $work = '恢复了订单记录');
                }
            } else {
                $this->work_log($table = 'order_merchants', $record_id = $id,'1', $work = '恢复了订单记录');
            }
            success(['info'=>'记录恢复成功!','url'=>session('url')]);
        }else{
            error('记录恢复失败!');
        }
    }



    public function order_view(){
        $id = I('id');
        if(IS_AJAX){
            $this->check_order_locker($id);
        }else {
            $map['a.order_no'] = $id;
            $re = M('shop_order_merchants')->alias('a')
                ->field('a.*,b.username,b.phone')
                ->join('m_user b ON a.member_id = b.user_id')
                ->where($map)->find();

            $order = M('shop_order')->where(['order_id'=>$re['order_id']])->find();

            if (!empty($order['coupon_ids'])) {  //判断是否使用优惠券

                $coupon_ids = explode(',',$order['coupon_ids']);
                $coupon = M('shop_member_coupon')->alias('a')
                    ->field('title,value')
                    ->join('m_shop_coupon b ON a.coupon_id = b.coupon_id')
                    ->where(['a.id' => ['in', $coupon_ids]])->select();
            }

            $re['coupon'] = $coupon;
            $value = '0';
            if($coupon){
                foreach ($coupon as $k => &$v) {
                    $value += $v['value'];
                }
            }
            /***
             * 商品信息
             */
            $goods = M('shop_order_goods')
                ->where(['order_merchants_id'=>$re['order_merchants_id']])->select();

            /*退换货信息*/
            $refund = M('shop_order_refund')->alias('a')
                    ->field('a.refund_type,a.refund_no,a.refund_count,a.refund_reason,a.refund_desc,a.refund_img,a.refund_state,a.refund_price
                    ,b.goods_name,b.specification_names')
                    ->join('m_shop_order_goods b ON a.order_goods_id = b.order_goods_id')
                    ->where(['a.order_merchants_id'=>$re['order_merchants_id'],'a.is_delete'=>'0'])
                    ->order('a.create_time desc')
                    ->select();


            /*日志*/
            $work_log = M('shop_work_log')
                ->field('title,intime,user_type,user_id')
                ->where(['table' => 'order_merchants', 'record_id' => $re['order_merchants_id']])->order("intime desc")->select();
            if(!empty($work_log)) {
                foreach ($work_log as &$v) {
                    // if ($v['user_type'] == 1) {
                    //     $v['name'] = M('shop_system_member')->where(['id' => $v['user_id']])->getField('username');
                    // } else {
                        $v['name'] = M('user')->where(['user_id' => $v['user_id']])->getField('username');
                    // }
                }
            }
            $url = session('url');
            $this->assign(['value'=>$value,'re' => $re, 'log' => $work_log,'goods'=>$goods,'refund'=>$refund,'url'=>$url]);

            $this->display();
        }
    }

    /**
     *@订单备注
     */
    public function beizhu(){
        if(IS_AJAX){
            $id = I('id');
            $beizhu = I('beizhu');
            $check = M('shop_order_merchants')->where(['order_no'=>$id])->find();
            if($check['custom_remark'] == $beizhu){
                echo json_encode(['status' => "error", 'info' => '备注未做改变!']);
                die;
            }
            $result = M('shop_order_merchants')->where(['order_merchants_id'=>$check['order_merchants_id']])->save(['custom_remark'=>$beizhu]);
            if($result){
                $this->work_log($table = 'order_merchants', $record_id = $check['order_merchants_id'],'1', $work = '备注了订单,原备注信息是：'.$check['custom_remark']);
                echo json_encode(['status' => "ok", 'info' => '订单备注成功!']);
            }else{
                echo json_encode(['status' => "error", 'info' => '备注信息失败!']);
            }
        }
    }

    //快递
    public function express(){
        if(IS_POST){
            // $rule = [
            //     'logistics_name'      => 'require',
            //     'logistics_pinyin'   => 'require',
            //     'logistics_no'   => 'require|min:6',
            //     'order_no'   => 'require',
            // ];

            // $message = [
            //     'logistics_name.require' => '快递公司必须填写',
            //     'logistics_pinyin.require'     => '快递公司标识必须填写',
            //     'logistics_no.require'     => '物流单号必须填写',
            //     'logistics_no.min'     => '物流单号长度最小6位',
            //     'order_no.require'     => '订单单号必须填写',
            // ];

            $rules = array(
                 array('logistics_name','require','快递公司必须填写'), //默认情况下用正则进行验证
                 array('logistics_pinyin','require','快递公司标识必须填写'), //默认情况下用正则进行验证
                 array('logistics_no','require','物流单号必须填写'), //默认情况下用正则进行验证
                 array('order_no','require','订单单号必须填写'), //默认情况下用正则进行验证
                 
            );

            $data['order_no'] = I('order_no');
            $data['logistics_name'] = I('logistics_name');
            $data['logistics_pinyin'] = I('logistics_pinyin');
            $data['logistics_no'] = I('logistics_no');

            $User = M("shop_order_merchants"); // 实例化对象
            if (!$User->validate($rules)->create()){
                 // 如果创建失败 表示验证没有通过 输出错误提示信息
                 // exit($User->getError());
                $this->error($User->getError(),U('express',['order_no'=>$data['order_no']]));

            }else{
                 // 验证通过 可以进行其他数据操作
                $info = M('shop_order_merchants')->where(['order_no'=>$data['order_no']])->find();
                $result = M('shop_order_merchants')->where(['order_no'=>$data['order_no']])->save($data);
                if($result){
                    $work = '修改了物流信息：';
                    if($data['logistics_name'] != $info['logistics_name'])      $work .= '原物流公司:'.$info['logistics_name'].'；';
                    if($data['logistics_no'] != $info['logistics_no'])      $work .= '原物流单号是:'.$info['logistics_no'].'；';
    //                if($data['kuaidi_state'] != $info['kuaidi_state']){
    //                    switch($info['kuaidi_state']){
    //                        case 1:
    //                            $work .= '原物流状态是:待发货；';
    //                            break;
    //                        case 2:
    //                            $work .= '原物流状态是:已发货；';
    //                            break;
    //                        case 3:
    //                            $work .= '原物流状态是:派送中；';
    //                            break;
    //                        case 4:
    //                            $work .= '原物流状态是:已签收；';
    //                            break;
    //                    }
    //                }
                    $this->work_log($table='order_merchants',$record_id = $info['order_merchants_id'],'1',$work);

                    // success(['info'=>'保存物流信息成功']);
                    $this->success('保存物流信息成功!',U('express',['order_no'=>$data['order_no']]));

                }else{
                    $this->error("保存失败");
                }
            }

            // $validate = new Validate($rule,$message);
            // $result = $validate->check($data);
            // if(!$result)            error($validate->getError());
            
        }else {
            // $this->view->engine->layout(false);
            $order_no = I('order_no');
            $re = M('shop_order_merchants')->where(['order_no'=>$order_no])->find();
            /*物流*/
            $express_node = M('shop_express_node')->select();
            $this->assign(['express_node'=>$express_node,'re'=>$re]);
            $this->display();
        }
    }

     /**
     *@查找快递
     */
    public function getExpress(){
        $express = I('express');
        !empty($express)    &&  $map['express'] = ['like','%'.$express.'%'];
        $list = M('shop_express_node')->where($map)->select();
        $code = '<option value="">请选择快递</option>';
        if($list){
            foreach($list as $k=>$v){
                $code .= "<option value=".$v['express'].">".$v['express']."</option>";
            }
        }
        echo $code;
    }

    /**
     *@查找快递
     */
    public function getExpressNode(){
        $express = I('express');
        $re = M("shop_express_node")->where(['express'=>$express])->find();
        if($re){
            echo $re['node'];
        }else{
            echo '';
        }
    }

    /**
     *@修改订单状态
     */
    public function change_order_status(){
        if(IS_AJAX){
            $order_no = I('order_no');
            $state = I('state');
            $check = M('shop_order_merchants')->where(['order_no'=>$order_no])->find();
            if($check) {
                //$member = M('Member')->where(['member_id'=>$check['member_id']])->find();
                if ($check['order_state'] == $state) {
                    $this->error('修改失败，订单状态未改变');
                }
                $time = date("Y-m-d H:i:s",time());
                switch ($state){
                    case 'cancel':
                        $data['cancel_time'] = $time;
                        break;
                    case 'wait_receive':
                        $data['send_time'] = $time;
                        break;
                    case 'wait_assessment':
                        $data['receive_time'] = $time;
                        break;
                }
                switch ($check['order_state']){
                    case 'cancel':
                        $tag = '取消';
                        break;
                    case 'wait_pay':
                        $tag = '待付款';
                        break;
                    case 'wait_send':
                        $tag = '待发货';
                        break;
                    case 'wait_receive':
                        $tag = '待收货';
                        break;
                    case 'wait_assessment':
                        $tag = '待评价';
                        break;
                    case 'end':
                        $tag = '已结束';
                        break;
                    case 'returns':
                        $tag = '已退款';
                        break;
                }
                if($state == 'wait_receive'){
                    if(empty($check['logistics_no'])){
                        $this->error('请先添加物流信息');
                    }
                }
                $data['order_state'] = $state;
                $work = '修改了订单状态,';
                $work .='原订单状态是:'.$tag;
                $result = M('shop_order_merchants')->where(['order_merchants_id' => $check['order_merchants_id']])->save($data);
                if ($result) {
                    if($check['order_state'] == 'wait_receive'){
                        $this->set_message($check['member_id'],'订单已发货','2',$check['order_merchants_id']);
                    }
//                    if ($check['state'] != $data['state']) {
//                        switch ($data['state']) {
//                            case 3:
//                                $message = '你的订单已发货';
//                                set_message($check['mid'], $message, $check['id'], $check['type']);
//                                $this->send_SMS($check['phone'], $message);
//                                break;
//                            case 4 :
//                                if (in_array($check['type'], ['1', '2'])) {
//                                    $order_detail = M('MallOrderDetail')->where(['order_id' => $check['id']])->select();
//                                    foreach ($order_detail as $k => $v) {
//                                        M('Goods')->where(['goods_id' => $v['goods_id']])->setInc('sale_number', $v['number']);
//                                        if (!empty($v['kinds_id'])) {
//                                            $kinds = $v['kinds_id'];
//                                            M('GoodsStock')->where(['goods_id' => $v['goods_id'], 'kinds' => $kinds])->setInc('sale_number', $v['number']);
//                                        }
//                                    }
//
//                                }
//                                break;
//                            case 5:
//                                $message = '你的订单已完成';
//                                set_message($check['mid'], $message, $check['id'], $check['type']);
//                                break;
//                            case 6:
//                                $message = '你的订单已取消';
//                                set_message($check['mid'], $message, $check['id'], $check['type']);
//                                break;
//                        }
//                    }
                    // if (!empty($member['openid'])) {
                    //     $weixin = new WechatAuth($this->system['appid'], $this->system['appsecret']);
                    //     $accessToken = S('globals_access_token');
                    //     if (empty($accessToken)) $accessToken = $weixin->getAccessToken();
                    //     $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $accessToken;
                    //     //$tmp = json_encode($tmp);
                    //     //$result = curl_post_json($url,$tmp);
                    // }
                    $this->work_log($table = 'order_merchants', $record_id = $check['order_merchants_id'], '1', $work = $work);
                    $this->success('修改订单状态成功');
                } else {
                    $this->error('修改订单状态失败');
                }
            }else{
                $this->error("订单无效");
            }
        }
    }

    /**
     *@售后详情
     */
    public function refund_view(){
        $id = I('id');
        if(IS_AJAX){
            $this->check_order_locker($id);
        }else {
            $map['a.refund_no'] = $id;
            $re = M('shop_order_refund')->alias('a')
                ->field('a.refund_id,a.reason_name,a.refund_type,a.refund_no,a.refund_count,a.order_no,a.refund_reason,a.refund_desc,a.refund_img,a.refund_state,a.refund_price
                    ,b.username,b.phone,a.create_time,a.order_goods_id,a.refund_actual_price')
                ->join('m_user b ON a.member_id = b.user_id')
                ->where($map)->order('a.create_time desc')->find();
            if($re['refund_img']){
                $re['refund_img'] = explode(',',$re['refund_img']);
            }
            $goods = M('shop_order_goods')->where(['order_goods_id'=>$re['order_goods_id']])->select();

            /*日志*/
            $work_log = M('shop_work_log')
                ->field('title,intime,user_type,user_id')
                ->where(['table' => 'order_refund', 'record_id' => $re['refund_id']])->order("intime desc")->select();
            if(!empty($work_log)) {
                foreach ($work_log as &$v) {
                    if ($v['user_type'] == 1) {
                        $v['name'] = M('shop_system_member')->where(['id' => $v['user_id']])->getField('username');
                    } else {
                        $v['name'] = M('user')->where(['user_id' => $v['user_id']])->getField('username');
                    }
                }
            }
            $url = session('url');
            $this->assign(['re' => $re, 'log' => $work_log,'goods'=>$goods,'url'=>$url]);

            $this->display();
        }
    }


    /**
     *@修改退换货订单
     */
    public function change_refund_state(){
        if(IS_AJAX){
            $refund_id = I('refund_id');
            $state = I('state');
            $reason_name = I('reason_name');
            $check = M('shop_order_refund')->where(['refund_id'=>$refund_id])->find();
            if($check) {
                //$member = M('Member')->where(['member_id'=>$check['member_id']])->find();
                if ($check['refund_state'] == $state) {
                    $this->error('修改失败，状态未改变');
                }
                $time = date("Y-m-d H:i:s",time());
                switch ($check['refund_state']){
                    case 'accept':
                        $tag = '接受审核';
                        break;
                    case 'refuse':
                        $tag = '拒绝受理';
                        break;
                    case 'end':
                        $tag = '退款成功';
                        break;
                    case 'wait_review':
                        $tag = '等待审核';
                        break;
                }
                //dd($state);
                if ($state == 'accept' || $state == 'refuse') $data['accept_or_refuse_time'] = date('Y-m-d H:i:s',time());
                if ($state == 'end') $data['refund_time'] = date('Y-m-d H:i:s',time());
                $data['refund_state'] = $state;
                $data['update_time'] = date('Y-m-d H:i:s',time());
                if($reason_name) {
                    $data['reason_name'] = $reason_name;
                }
                $work = '修改了售后订单状态,';
                $work .='原订单状态是:'.$tag;
                if($state == 'end'){
                    $order_merchants = M('shop_order_merchants')->where(['order_merchants_id'=>$check['order_merchants_id']])->find();
                    $pay_charge = json_decode($order_merchants['pay_charge'], true);

                    // $obj = new Pingxx();
                    // $amount = $check['refund_actual_price'];
                    // //$amount = 0.01;
                    // $charge = $pay_charge['data']['object']['id'];
                    // $result = $obj->return_money($amount, $charge);
                    // $result = json_decode($result, true);
                    // if (empty($result) || $result['error']) {
                        $this->error("无退款权限，请联系总平台");
                    // }
                }
                $result = M('shop_order_refund')->where(['refund_id' => $check['refund_id']])->save($data);
                if ($result) {
                    $this->work_log($table = 'order_refund', $record_id = $check['refund_id'], '1', $work = $work);
                    $this->success('修改订单状态成功');
                } else {
                    $this->error('修改订单状态失败');
                }
            }else{
                $this->error("订单无效");
            }
        }
    }

    public function reason()
    {
        $refund_id = I('refund_id');
        $state = I('state');
        //$reason_name = input('reason_name');
        // $this->view->engine->layout(false);
        $this->assign(['state' => $state, 'refund_id' => $refund_id]);
        $this->display();
    }


    /****************************我是华丽的分割线（以下是TP5内容）********************************/
    






























    
    

    
    

    

    /**
     *@订单结算
     */
    public function settlement(){
        $order_merchant_id = input('order_merchant_id');
        if(!$order_merchant_id)         error("参数错误");
        $order = Db::name('order_merchants')->where(['order_merchants_id'=>$order_merchant_id])->find();
        if($order){
            if($order['settlement_state'] != 0 || $order['order_state'] != 'end'){
                error("结算状态错误");
            }
            $date = date("Y-m-d",time());
            $create_time = date("Y-m-d H:i:s",time());
            $merchants = Db::name('merchants')->where(['member_id'=>$order['merchants_id']])->find();
            Db::startTrans();
            if($merchants['tv_id']){
                if($merchants['tv_sell_scale']){    //电视台结算
                    $tv['order_merchants_id'] = $order['order_merchants_id'];
                    $tv['merchant_id'] = $merchants['tv_id'];
                    $tv['settlement_price'] = $order['order_actual_price']*$merchants['tv_sell_scale']/100;
                    $tv['order_price'] = $order['order_actual_price'];
                    $tv['ratio'] = $merchants['tv_sell_scale'];
                    $tv['create_time'] = $create_time;
                    $tv['date'] = $date;
                    $tv['type'] = '3';
                    $result = Db::name('order_settlement')->insert($tv);
                    if(!$result){
                        Db::rollback();
                        error("结算失败");
                    }
                }
            }
            //销售主播结算
            $seller_all = '0';
            $seller_goods = Db::name('order_goods')->where(['order_merchants_id'=>$order_merchant_id,'seller'=>['neq','']])->select();
            if($seller_goods){
                foreach ($seller_goods as $v){
                    if($v['specification_id']){
                        $sale_ratio = Db::name('goods_relation_specification')->where(['specification_id'=>$v['specification_id']])->value('sale_ratio');
                    }else{
                        $sale_ratio = Db::name('goods')->where(['goods_id'=>$v['goods_id']])->value('sale_ratio');
                    }
                    if($sale_ratio) {
                        $seller_money = sprintf('%.2f', $order['order_actual_price']  * ($v['specification_price'] * $v['goods_num'] / $order['goods_total_price']) * $sale_ratio/100);
                        $seller[] = [
                            'order_merchants_id' => $order['order_merchants_id'],
                            'merchant_id' => $v['seller'],
                            'settlement_price' => $seller_money,
                            'order_price' => $order['order_actual_price'],
                            'ratio' => $sale_ratio,//销售主播比例是总订单除开平台和电视结余的百分之15
                            'create_time' => $create_time,
                            'type' => '2'
                        ];
                        $seller_all += $seller_money;
                        $result = Db::name('member')->where(['member_id' => $v['seller']])->setInc('amount', $seller_money);
                        if (!$result) {
                            Db::rollback();
                            error("结算失败");
                        }
                    }
                }
                if($seller){
                    $result = Db::name('order_settlement')->insertAll($seller);
                    if(!$result){
                        Db::rollback();
                        error("结算失败");
                    }
                }
            }

            //商家结算剩余

            $data['order_merchants_id'] = $order['order_merchants_id'];
            $data['merchant_id'] = $order['merchants_id'];
            $data['order_price'] = $order['order_actual_price'];
            $data['settlement_price'] = $order['order_actual_price']*(1-$merchants['sell_scale'])-$seller_all-$tv['settlement_price'];
            $data['ratio'] = sprintf('%.2f',$data['settlement_price']/$order['order_actual_price']*100);
            $data['create_time'] = $create_time;
            $data['date'] = $date;
            $result = Db::name('order_settlement')->insert($data);
            if($result){
                $a = Db::name('order_merchants')->where(['order_merchants_id'=>$order_merchant_id])->update(['settlement_state'=>'1']);
                $b = db::name('member')->where(['member_id'=>$order['merchants_id']])->setInc('amount',$data['settlement_price']);
                if($a && $b){
                    Db::commit();
                }else{
                    Db::rollback();
                    error("结算失败");
                }
                $work = '订单结算操作';
                $this->work_log($table='order_merchants',$record_id = $order['order_merchants_id'],'1',$work);
                success("操作成功");
            }else{
                Db::rollback();
                error("结算失败");
            }
        }else{
            error("参数错误");
        }
    }

    

    

    

    

    

    

    
    

   

    /**
     *@下载
     */
    public function down_diy()
    {
        $order_no = I('order_no');
        $url = I('url');
        $arr = explode('?',$url);
        $new_url = $arr[0];
        $array = explode('.',$new_url);
        $str = $array[count($array) - 1];
        $result = httpcopy($url);
        $file = $result['fileName'];
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }


    /**
     *@退换货凭证图片
     */
    public function get_returns_img(){
        $id = I('id');
        $img = M('MallReturnsOrder')->where(['id'=>$id])->getField('img');
        $img = explode(',',$img);
        foreach($img as $k=>$v){
            $arr['data'][$k]['src'] = $v;
        }
        $arr['title'] = '';
        $arr['start'] = 0;
        echo json_encode($arr);
    }

    /**
     *@订单改价
     */
    public function change_paid(){
        if(Request::instance()->isAjax()){
            $order_no = input('order_no');
            $data['order_actual_price'] = input('order_actual_price');
            $data['cost_price'] = input('cost_price');
            $order = Db::name('order_merchants')->where(['order_no'=>$order_no])->find();
            if($order) {
                $result = Db::name('order_merchants')->where(['order_no' => $order_no])->update($data);
                if ($result) {
                    $work = '修改了订单价格：';
                    if($data['order_actual_price'] != $order['order_actual_price'])      $work .= '原订单实收金额:'.$order['order_actual_price'].'；';
                    if($data['cost_price'] != $order['cost_price'])      $work .= '原订单成本价是:'.$order['cost_price'].'；';
                    $this->work_log($table = 'order_merchants', $record_id = $order['order_merchants_id'], '1', $work = $work);
                    success('修改订单价格信息成功');
                } else {
                   error('修改订单价格失败');
                }
            }else{
                error("订单错误");
            }
        }
    }

    /**
     *@订单改价
     */
    public function change_refund_paid(){
        if(Request::instance()->isAjax()){
            $refund_no = input('refund_no');
            $data['refund_actual_price'] = input('refund_actual_price');
            $order = Db::name('order_refund')->where(['refund_no'=>$refund_no])->find();
            if($data['refund_actual_price']>$order['refund_price']){
                error("实际金额不能超出售后金额");
            }
            if($order) {
                $result = Db::name('order_refund')->where(['refund_no' => $refund_no])->update($data);
                if ($result) {
                    $work = '修改了售后价格：';
                    if($data['refund_actual_price'] != $order['refund_actual_price'])      $work .= '原售后实际金额:'.$order['refund_actual_price'].'；';
                    $this->work_log($table = 'order_refund', $record_id = $order['refund_id'], '1', $work = $work);
                    success('修改订单价格信息成功');
                } else {
                    error('修改订单价格失败');
                }
            }else{
                error("订单错误");
            }
        }
    }

    
    


    

    

    
    

    
    

    

    /**
     *@待确认订单
     */
    public function to_be_confirm(){
        $map = [];
        $order_state = input('order_state');
        $map = $this->get_order_where();
        $order_state ? $map['order_state'] = $order_state : $map['order_state'] = 'wait_pay';
        $num = input('num');
        $num    ?   $num    :   $num = 10;
        $this->assign('nus',$num);
        $count = $this->get_order_count($map);
        $list  = $this->get_order($map,$num);
        $page = $list->render();
        $merchant = $this->merchant();
        $this->assign(['list'=>$list,'count'=>$count,'page'=>$page,'merchant'=>$merchant]);
        $act = input("act");
        if($act=="download"){
            $this->down_horder($map);
        }else{
            $url =$_SERVER['REQUEST_URI'];
            session('url',$url);
            return $this->fetch();
        }
    }

    

    

    

    

    

    
    


    /**
     *@锁定订单
     */
    public function lock_order(){
        if(IS_POST){
            $id = I('id');
            $check = M('HotelOrder')->where(['order_id'=>$id])->find();
            $user = session('user');
            if($check['is_lock'] == '1'){
//                if($user['uname'] == 'admin'){
//                    echo json_encode(array('status'=>'error','info'=>'超级管理员不能锁定订单'));
//                    die;
//                }
                $result = M('HotelOrder')->where(['order_id'=>$id])->save(['is_lock'=>'2','locker_id'=>$user['id']]);
                $action = '锁定';
            }else{
                if($user['id'] == $check['locker_id'] || $user['uname'] == 'admin'){
                    $result = M('HotelOrder')->where(['order_id'=>$id])->save(['is_lock'=>'1','locker_id'=>'']);
                    $action = '解绑';
                }else{
                    echo json_encode(array('status'=>'error','info'=>'你没有权限解绑该订单'));
                    die;
                }
            }
            if($result){
                work_log($table='HotelOrder',$record_id = $id,'1',$work=$action.'了航班订单');
                echo json_encode(array('status'=>'ok','info'=>$action.'该订单成功'));
            }else{
                echo json_encode(array('status'=>'error','info'=>$action.'该订单失败'));
            }
        }
    }

    



}