<?php
namespace Merchant\Controller;
use Think\Db;
use Org\Util\Date;
use Think\Upload;
use Think\Controller;
class CaiwuController extends CommonController{
    public function index(){
        $this->display();
    }
    /**
     *@提现记录
     */
    public function withdraw(){
        $merchant  = session('shop');
        $param = I('param.');
        $map['user_id'] = $merchant['member_id'];
        $start_time = I('start_time');
        $end_time = I('end_time');
        if($start_time && !$end_time){
            $start_time = urldecode($start_time);
            $map['intime'] = ['gt',strtotime($start_time)];
        }else if($end_time && !$start_time){
            $end_time = urldecode($end_time);
            $map['intime'] = ['lt',strtotime($end_time)];
        }else if($start_time && $end_time){
            $map['intime'] = ['between',[strtotime($start_time),strtotime($end_time)]];
        }
        $type = I('type');
        !empty($type)       &&      $map['type'] = $type;
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M('withdraw')->where($map)->count();
        $p = getpage($count,$nus);
        $list = M('withdraw')->where($map)
            ->where($map)
            ->order('cash_time desc')
            ->order('intime desc')
            ->limit($p->firstRow.','.$p->listRows)
            ->select();
        $this->assign("show",$p->show());
        $sum = M('withdraw')->where($map)->sum('money');
        $this->assign(['count'=>$count,'list'=>$list,'sum'=>$sum]);
        $this->assign ('pagetitle', '提现管理');

        $this->display();
    }

    /*******下方有缺陷*******/

    public function to_withdraw_money(){
        $merchant = session('shop');
        $merchant = M('shop_merchants')->where(array('merchants_id'=>$merchant['merchants_id']))->find();
        $system = M('system')->where(['id'=>1])->find();
        // $merchant = M('user')->where(['user_id'=>$merchant['member_id']])->find();
        $cash_money =  $system['convert_scale4']/$system['convert_scale3'];
        // $merchant['money'] = $merchant['get_money'] * $cash_money;
        $bank = M('shop_bank_card')->where(['member_id'=>$merchant['member_id']])->find();
        if(IS_POST) {
            if(!$bank)                                      $this->error('请先填写提现账户信息');
            $money = I('money');
            if($money>$merchant['get_money'] || $money<0)      $this->error('提现余额错误');
            // $data['user_type'] = '1';
            $data['user_id'] = $merchant['member_id'];
            $data['k'] = $money;
            $data['money'] = $money;
            $data['withdraw_way'] = $bank['bank_card'];
            $data['withdraw_type'] = $bank['bank_name'];
            $data['relname'] = $bank['realname'];
            $data['intime'] = time();
            $data['date'] = date('Y-m-d', $data['intime']);
            $data['type'] = 2;
            // 启动事务
            M()->startTrans();
            $result = M('withdraw')->add($data);
            if(!$result){
                M()->rollback();
                $this->error("余额提现申请失败");
            }
            $result = M('shop_merchants')->where(['member_id'=>$merchant['member_id']])->setDec('get_money',$money);
            if(!$result){
                M()->rollback();
                $this->error("余额提现申请失败");
            }else{
                M()->commit();
                $this->success('余额提现申请成功');
            }

        }else{
            $this->assign(['cash_money'=>$cash_money,'re'=>$merchant,'bank'=>$bank]);
            $this->display();
        }
    }

    public function to_withdraw_ticket(){
        $merchant = session('shop');
        $system = M('system')->where(['id'=>1])->find();
        $merchant = M('user')->where(['user_id'=>$merchant['member_id']])->find();
        $cash_money =  $system['convert_scale4']/$system['convert_scale3'];
        $merchant['money'] = $merchant['get_money'];
        $merchant['moneys'] = $merchant['get_money'] * $cash_money;
        if(IS_POST) {
            if($merchant['get_money']<100)       $this->error('钻石数量少于100');
            $data['get_money'] = 0;
            $data['amount'] = $merchant['get_money'] + $merchant['money'];
            $result = M('user')->where(['user_id'=>$merchant['user_id']])->save($data);
            if($result){
                success(['info'=>'钻石转化成功','url'=>url('Caiwu/to_withdraw_ticket')]);
            }else{
                error('钻石转化失败');
            }
        }else{
            $this->assign(['cash_money'=>$cash_money,'re'=>$merchant]);
            $this->display();
        }
    }




    /**************************************************************************************/




    

    /**
     * 直播收益财务报表
     * @return mixed
     */
    public function anchor(){
        $member =session::get("member");
        $map=[];
        $params = Request::instance()->param();
        $username = $params["username"];
        if($username)   $map['b.username|b.phone|d.title'] = ['like','%'.$username.'%'];
        if($params["member_type"]) $map["a.member_type"] = $params["member_type"];
        $start_time = $params["start_time"];
        $end_time = $params["end_time"];
        //时间
        if($start_time){
            $map["a.date"] = ["gt",urldecode($start_time)];
        }
        if($end_time){
            $map["a.date"] = ['lt',urldecode($end_time)];
        }
        $num  = input('num');
        if(empty($num)){
            $num=10;
        }
        $count = DB::name("give_gift")
                ->alias('a')
                ->join("__MEMBER__ b","a.user_id2 = b.member_id","LEFT")
                ->join("__GIFT__ c","a.gift_id = c.gift_id")
                ->join("__LIVE__ d","a.live_id = d.live_id")
                ->where(["a.tv_id"=>$member["member_id"]])
                ->where($map)
                ->count();
        $list = DB::name("give_gift")
                ->field("a.*,b.username,b.header_img,b.phone,c.*,d.title")
                ->alias('a')
                ->join("__MEMBER__ b","a.user_id2 = b.member_id","LEFT")
                ->join("__GIFT__ c","a.gift_id = c.gift_id",'LEFT')
                ->join("__LIVE__ d","a.live_id = d.live_id")
                ->where(["a.tv_id"=>$member["member_id"]])
                ->where($map)
                ->order("a.intime desc")
                ->paginate($num,false,["query"=>$params]);
        $system = DB::name("system")->where(["id"=>1])->find();
        $change_scale = $change_scale = $system["convert_scale1"]/$system["convert_scale2"];
        $list->toArray();
        foreach ($list as $k=>$v){
            $platform_scale = explode(',',$v["dashang_scale"])[0]/100;
            $anchor_scale = explode(",",$v["dashang_scale"])[1]/100;
            $anchor_amount = $v["price"]*$change_scale*$platform_scale*$anchor_scale;
            $platform_amount = $v["price"]*$change_scale*$platform_scale*(1-$anchor_scale);
            $data = array();
            $data = $v;
            $data['anchor_amount'] = $anchor_amount;
            $data['platform_amount'] = $platform_amount;
            $list->offsetSet($k,$data);
        }
       $this->assign("count",$count);
       $this->assign("list",$list);
       return $this->fetch();
    }
    /**
     * 商户销售报表
     * @return mixed
     */
    public function  merchants(){
        //获取电视台id
        $member =session::get("member");
        $tv_id = $member["member_id"];
        //获取电视台下的商户
        $merchants =array("tv_id"=>$tv_id,"platform_type"=>1);
        $merchants_id = DB::name("Merchants")->where($merchants)->column("member_id");
        if(empty($num)){
            $num =10;
        }
        $params = Request::instance()->param();
        $order_no = $params["order_no"];
        if($order_no)                  $map['a.order_no|c.username|c.phone|b.merchants_name'] = ['like','%'.$order_no.'%'];
        //获取相应对应商户的支付订单信息
        if($params["order_state"]){
            $map["order_state"] = $params["order_state"];
        }else{
            $map['order_state'] = ['in','wait_send','wait_receive','wait_assessment','end'];
        }
        //订单时间
        $start_time = $params["start_time"];
        $end_time = $params["end_time"];
        if($start_time){
            $map["a.create_time"] = ["gt",urldecode($start_time)];
        }
        if($end_time){
            $map["a.create_time"] = ['lt',urldecode($end_time)];
        }
        $map["a.merchants_id"] = ['in',$merchants_id];
        if(!empty($merchants_id)){
            $count = DB::name("order_merchants")
                ->alias("a")
                ->join("__MERCHANTS__ b","a.merchants_id=b.member_id")
                ->join("__MEMBER__ c","a.member_id = c.member_id")
                ->where($map)
                ->count();
            $list = DB::name("order_merchants")
                ->alias("a")
                ->field("a.*,b.merchants_img,b.merchants_name,b.contact_name,b.contact_mobile,c.phone,c.username")
                ->join("__MERCHANTS__ b","a.merchants_id=b.member_id")
                ->join("__MEMBER__ c","a.member_id = c.member_id")
                ->where($map)
                ->paginate($num,false,["query"=>$params]);
            $page = $list->render();
            $this->assign(["count"=>$count,"list"=>$list,'page'=>$page]);
        }else{
                $this->assign(["count"=>0,"list"=>[]]);
        }
        return $this->fetch();
    }
    /**
     * 去提现
     */
     public function to_withdraw(){
         $member =session::get("member");
         $tv_id = $member["member_id"];
         if(request()->isAjax()) {
             $res = DB::name("alipay")->where(['user_id'=>$tv_id])->find();
             $television_info = DB::name("television")->where(["tv_id"=>$tv_id])->find();
             $params = Request::instance()->param();
             if(empty($params['withdraw_money'])){
                 error("提现信息有误");
             }
             if((float)$params['withdraw_money'] > $television_info['account_money']){
                 error("账户余额不足");
             }
             $data['relname'] = $params["relname"];
             $data['withdraw_type'] = "银行卡";//$params['where_it_is'];
             $data['withdraw_way'] = $params['alipay'];
             $data['money'] = (float)$params['withdraw_money'];
             $data['k'] = 0;
             $data['intime'] =time();
             $data["user_id"] = $tv_id;
             $data['user_type'] = 2;
             $data['type'] = 2;
             $data['status'] = 1;
             $add = DB::name("withdraw")->insert($data);
             if($add){
                 $upArr['account_money'] = DB::name("television")->where(["tv_id"=>$tv_id])->value("account_money")-$params['withdraw_money'];
                 $upArr['withdraw_money'] = DB::name("television")->where(["tv_id"=>$tv_id])->value("withdraw_money")+$params['withdraw_money'];
                 $update = DB::name("television")->where(["tv_id"=>$tv_id])->update($upArr);
                 success(['info'=>"提现提现成功",'url'=>"/Television/index/index"]);
             }else{
                 error(['info'=>"提现失败"]);
             }

         }else{
             $res = DB::name("alipay")->where(['user_id'=>$tv_id])->find();
             if($res){
                 $res["account_money"] = DB::name("television")->where(['tv_id'=>$tv_id])->value('account_money');
                 $this->assign(['re'=>$res]);
                 return $this->fetch();
             }else{
                 $this->redirect('Index/account');
             }
         }


     }
    

    

}