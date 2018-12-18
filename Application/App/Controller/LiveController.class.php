<?php

namespace App\Controller;
use Qiniu\Pili\Mac;
use Think\Controller;
use Think\Upload;
class LiveController extends CommonController {
/*****************************************百台云********************************************/

	/**
     *直播列表(电商直播商户列表)
     */
    public function merchants_list(){
       $params = I('param.');
       $page = empty($params["p"]) ? 1 :$params["p"];
       $pageSize = empty($params["pagesize"]) ? 20 : $params["pagesize"];

       	import('Vendor.Qiniu.Pili');
	    $system = M('System')->where(['id' => 1])->find();
	    $ak = $system['ak'];
	    $sk = $system['sk'];
	    $hubName = $system['hubname'];
	    $mac = new \Qiniu\Pili\Mac($ak, $sk);
	    $client = new \Qiniu\Pili\Client($mac);
	    $hub = $client->hub($hubName);
	    $stream_list = $hub->listLiveStreams("php-sdk-test", 100000, "");
	    $stream_list = $stream_list[keys];
        // $qn = new QiniuPili();
        // $stream_list = $qn->listLiveStreams();
        //对用户的正常退出进行处理
        if ($stream_list){
            $rs = M('Live')->where(['stream_key'=>['in',$stream_list],'is_normal_exit'=>1])->save(['live_status'=>1,'uptime'=>time()]);
        }
        //获取商家总数
        $count = M("shop_merchants")->count();
        $merchants_list = M("shop_merchants")->field('member_id,merchants_img as img ,live_id,merchants_name')->order("live_id desc")->limit(($page-1)*$pageSize,$pageSize)->select();
        foreach ($merchants_list as $k=>$v){
            if($v["live_id"] !=0){
                $live_info = M("live")->where(["live_id"=>$v["live_id"]])->find();
                $merchants_list[$k]["room_id"] = $live_info["room_id"];
                $merchants_list[$k]["play_address"] = $live_info["play_address"];
            }
        }
        success(["count"=>$count,"list"=>$merchants_list]);
    }

    /**
     *非电商直播(无商户)
     */
    public function anchor_live_list(){
        if(IS_POST){
            $uid = I('uid');
            $member = M('user')->where(['user_id'=>$uid])->find();
            $p = I("p");
            $p ? $p :$p = 1;
            $pagesize = I("pagesize");
            $pagesize ? $pagesize : $pagesize = 10;
            $map["live_status"] = 1;
            $type= I("type");
            switch ($type){
                case 1://广场
                    $order = 'a.intime desc';
                    break;
                case 2://关注
                    $follow_user = M('follow')->where(['user_id'=>$member['user_id']])->getField('user_id2',true);
                    if($follow_user){
                        $map['a.user_id'] = ['in',$follow_user];
                    }else{
                        success(['page'=>0,'list'=>[]]);
                    }
                    $order = 'a.intime desc';
                    break;
                case 3://热门
                    $order = 'a.watch_nums desc';
                    break;
                default:$type = 1;
            }
            $count = M('live')->alias('a')
                ->join('__USER__ b ON a.user_id = b.user_id')
                ->where($map)->count();
            $page = ceil($count/$pagesize);
            $list = M('live')->alias('a')
                ->field('a.*,b.username,b.header_img,b.member_id')
                ->join('__USER__ b ON a.user_id = b.user_id')
                ->where($map)->order($order)
                ->limit(($p-1)*$pagesize,$pagesize)->select();
            foreach ($list as $k=>$v){
                $list[$k]['share_url'] = C('IMG_PREFIX').'/mall_live/#/liveRoom_mobile?live_id='.$v['live_id'].'&room_id='.$v['room_id'];
            }
            success(['page'=>$page,'list'=>$list]);
        }
    }

    /**
     * 直播列表
     *@param class_id 商家id
     */
    public function queryLiveListByClass(){
        if(IS_POST){
            $uid = I('uid');
            if($uid){
                $member = M('user')->where(['user_id'=>$uid])->find();
            }
            $class_id = I('class_id');
            if(!empty($class_id)){
                $where[] = ['exp','FIND_IN_SET('.$class_id.',class_id)'];
                $anthor = M('shop_goods_merchants_class')->where($where)->getField('member_id',true);
                if($anthor){
                   $map['a.user_id'] = ['in',$anthor];
                }else{
                    success(['page'=>0,'list'=>[]]);
                }
            }
            $p = I('p');
            $p ? $p : $p = 1;
            $pagesize = I('pagesize');
            $pagesize ? $pagesize : $pagesize = 10;
            $type = I('type');
            switch ($type){
                case 1://综合
                    $order = 'a.intime desc';
                    break;
                case 2://关注
                    $follow_user = M('follow')->where(['user_id'=>$member['user_id']])->getField('user_id2',true);
                    if($follow_user){
                        $map['a.user_id'] = ['in',$follow_user];
                    }else{
                        success(['page'=>0,'list'=>[]]);
                    }
                    $order = 'a.intime desc';
                    break;
                case 3:
                    $order = 'a.watch_nums desc';
                    break;
                default:$type = 1;
            }

            $map['a.type'] != '1';
            $map['b.is_delete'] = '0';
            $map['b.apply_state'] = '2';
            $count = M('user')->alias('a')
                ->join('m_shop_merchants b ON a.user_id = b.member_id')
                ->where($map)->count();
            $page = ceil($count/$pagesize);
            $list = M('user')->alias('a')
                ->field('a.user_id,a.username,a.city,b.merchants_name,b.merchants_img,b.live_id')
                ->join('m_shop_merchants b ON a.user_id = b.member_id')
                ->where($map)->order($order)
                ->limit(($p-1)*$pagesize,$pagesize)->select();
            foreach ($list as $k=>$v){
                $list[$k]['goods_class'] = M('shop_goods_merchants_class')->alias('a')
                    ->field('b.class_id,b.class_name,b.class_uuid')
                    ->join('m_shop_goods_class b ON FIND_IN_SET(b.class_id,a.class_id)')
                    ->where(['a.member_id' => $v['user_id'], 'b.is_delete' => 0])
                    ->select();
                if($v['live_id']){
                    $live = M('live')->where(['live_id'=>$v['live_id']])->find();
                    $list[$k]['play_img'] = $live['play_img'];
                    $list[$k]['title'] = $live['title'];
                    $list[$k]['city'] = $live['shi'];
                    $list[$k]['share_url'] = C('IMG_PREFIX').'/mall_live/#/liveRoom_mobile?live_id='.$live['live_id'].'&room_id='.$live['room_id'];
                }else{
                    $list[$k]['play_img'] = $v['merchants_img'];
                    $list[$k]['title'] = '';
                    $list[$k]['city'] = $v['city'];
                    $list[$k]['share_url'] = '';
                }
            }
            success(['page'=>$page,'list'=>$list]);
        }
    }

    /**
     *好货分类
     */
    public function showGoodsClass(){
        if (IS_POST) {
            $where = [
                'class_type' => 'home',
                'is_delete' => '0',
                'class_state' => '1',
                'parent_id' => '-1'
            ];
            $list = M('shop_goods_class')
                ->field('class_id,class_name,class_desc,class_img,class_color,class_uuid,template_img')
                ->where($where)->order("sort desc")->select();
            $arr = [
                'class_id'      =>  '',
                'class_name'    =>  '全部',
                'class_desc'    =>  '',
                'class_img'     =>  '',
                'class_color'   =>  '',
                'class_uuid'    =>  '',
                'template_img'  =>  ''
            ];
            array_push($list,$arr);
            return success($list);
        }
    }

    public function queryLiveByClass(){
        $class_uuid = I('class_uuid');
        if(!$class_uuid)            error("参数错误");
        $city = I('city');
        $p = I('p');
        $p ? $p : $p = 1;
        $pagesize = I('pagesize');
        $pagesize ? $pagesize : $pagesize = 10;
        $merchant = M('shop_goods_merchants_class')->alias('a')
              ->join('m_shop_goods_class b ON FIND_IN_SET(b.class_id,a.class_id)')
              ->where(['b.class_uuid'=>$class_uuid])
              ->getField('a.member_id',true);
        if($merchant){
            $map['a.user_id'] = ['in',$merchant];
            $map['a.live_status'] = 1;
            $map['a.is_offline'] = 1;
            if($city)       $map['a.city']  =   ['like','%'.$city.'%'];
            $count = M('live')->alias('a')
                ->join('m_user b ON a.user_id = b.user_id')
                ->join('m_shop_merchants c ON c.member_id = a.user_id')
                ->where($map)->count();
            $list = M('live')->alias('a')
                ->field('a.*,b.username,b.img as header_img,b.user_id as member_id,c.merchants_name')
                ->join('m_user b ON a.user_id = b.user_id')
                ->join('m_shop_merchants c ON c.member_id = a.user_id')
                ->where($map)->order("a.intime desc")
                ->limit(($p-1)*$pagesize,$pagesize)->select();
            foreach ($list as $k=>$v){
                $list[$k]['share_url'] = C('IMG_PREFIX').'/mall_live/#/liveRoom_mobile?live_id='.$v['live_id'].'&room_id='.$v['room_id'];
            }
            $page = ceil($count/$pagesize);
            success(['page'=>$page,'list'=>$list]);
        }else{
            success(['page'=>0,'list'=>[]]);
        }

    }

    /**
     *商家直播和录播
     */
    public function merchants_live(){
        $params = I('param.');
        $member_id = empty($params["member_id"]) ? error("无法获取商家信息") : $params["member_id"];
        //获取商家直播
        $live_list = M("live")
                    ->where(["user_id"=>$member_id,"live_status"=>1])
                    ->order("live_id desc")
                    ->find();
        if($live_list){
            $live_list["start_time"] = date("Y-m-d H:m",$live_list["start_time"]);
        }else{
            $live_list =(object)array();
        }
        success($live_list);
    }

    /**
     *商户录播
     */
    public function playback_list(){
        $params = I('param.');
        $member_id = empty($params["member_id"]) ? error("无法获取商家信息") : $params["member_id"];
        $p = I('p');
        empty($p) && $p = 1;
        $pageSize = I('pagesize');
        $pageSize ? $pageSize : $pageSize = 10;
        //回放列表
        $playback_list = M("live_store")
            ->field('live_store_id,title,url,play_img,date,play_number')
            ->where(["user_id"=>$member_id,"is_del"=>1])
            ->order("intime desc")
            ->limit(($p-1)*$pageSize,$pageSize)
            ->select();
        foreach ($playback_list as $k=>$v){
            $playback_list[$k]['date'] = date('Y-m-d',strtotime($v['date']));
            $playback_list[$k]['play_img'] = domain($playback_list[$k]['play_img']);
        }
        $count = M("live_store")
            ->field("title,url,play_img,date,play_number")
            ->where(["user_id"=>$member_id,"is_del"=>1])
            ->count();
        $page = ceil($count/$pageSize);
        success(['list'=>$playback_list,'count'=>(string)$count,'page'=>$page]);
    }

    /**
     *@删除录播
     */
    public function del_playback(){
        $user =checklogin();
        $live_store_id = I('live_store_id');
        $result = M('Live_store')->where(['live_store_id'=>$live_store_id])->save(['is_del'=>'2']);
        if($result){
            success('删除成功');
        }else{
            success('删除失败');
        }
    }

    /**
     * @获取支付宝/银行卡信息
     */
    public function get_alipay(){
        $user = checklogin();
        $alipay = M('Alipay')->field("alipay_id,user_id,phone,alipay,relname")->where(['user_id'=>$user['user_id']])->find();
       if(!$alipay){
           $alipay= (object)array();
       }
        success($alipay);
    }

    /**
     * @绑定修改体现账户
     */
    public function binding_alipay(){
        $user = checklogin();
        $params = I('param.');
        $rules = array(
		     array('relname','require','请输入身份证上的姓名'), //默认情况下用正则进行验证
		     array('phone','','此手机号已被使用',0,'unique',1), // 在新增的时候验证name字段是否唯一
		);

		$User = M("alipay"); // 实例化User对象
		if (!$User->validate($rules)->create()){
		     // 如果创建失败 表示验证没有通过 输出错误提示信息
		     exit($User->getError());
		}else{
		     // 验证通过 可以进行其他数据操作
		    //判断验证码是否有效期
	        $result = M("Mobile_sms")->where(["mobile"=>$params["phone"],"code"=>$params["yzm"]])->order("intime desc")->find();
	        if(!$result){
	            error("验证码不正确");
	        }
	        $state = $result["state"];
	        $valid_time =time()-intval($result["intime"]);
	        if($valid_time>600){
	            error("验证码已失效,请重新发送");
	        }
	        $data = [
	            'user_id'=>$user['member_id'],
	            'phone'=>$params["phone"],
	            'alipay'=>$params["phone"],
	            'relname'=>$params["relname"],
	            'intime'=>date("Y-m-d H:i:s", time()),
	            'type'=>1,
	            'where_it_is'=>"",
	        ];
	        if(empty($params["alipay_id"])){
	            //添加
	            if(!$validate->check($params)){
	                error($validate->getError());
	            }
	            $res = M('Alipay')->add($data);
	        }else{
	            //修改
	             
	            $res = M('Alipay')->where(['alipay_id'=>$params["alipay_id"]])->save($data);
	        }
		    
		}
        
        if($res){
            success("保存成功");
        }else{
            error("保存失败");
        }
    }

    /**
     * @票据兑换金额比例
     */
    private function em_scale(){
        $params = M("system")->where(array('id'=>1))->find();
        $em_scale = $params['convert_scale4']/$params['convert_scale3'];
        return $em_scale;
    }

    /**
     * @输入票据获取兑换金额
     */
    public function return_money(){
        $user = checklogin();
        $diamond = I('e_ticket');
        empty($diamond) ? error('请输入你要提现的龙票数量') : true;
        $get_money = (string)sprintf("%.2f",($diamond*em_scale()));
        success($get_money);
    }

    /**
     * @提现提交
     */
    public function withdraw(){
        $user = checklogin();
        $params = I('param.');
        //数据验证
        $money = empty($params["money"]) ? error("输入的金额有误，请核实后重新输入") : $params["money"];
        $e_ticket = empty($params["e_ticket"]) ? error("输入的龙票有误，请核实后重新输入") : $params["e_ticket"];
        $alipay_id = empty($params["alipay_id"]) ? error("提现账号有误") : $params["alipay_id"];
        $withdraw_way = empty($params["withdraw_way"]) ? error("提现账号有误") :$params["withdraw_way"];
        //提现最小额度限制
        $lowest_limit = M("system")->where(["id"=>1])->getField("day_lowest");
        if($e_ticket < $lowest_limit){
            error("提现钻石不能小于".$lowest_limit);
        }
        //进行账号验证
        $zhanghao = M("alipay")->where(array('alipay_id'=>$alipay_id))->getField("alipay");
        ($withdraw_way != $zhanghao) ? error("提现账号有误") :true;
        //进行提现金额判断
        $user['get_money'] - $e_ticket < 0 ? error('余额不足') : true;
        //获取实际可提现的金额(进行金额验证)
        $actual_amount = (string)sprintf("%.2f",($e_ticket*em_scale()));
        //金额进行判断
        $actual_money = (string)sprintf("%.2f",$money);
        if($actual_amount != $actual_money){
            error("提现金额有误，请重新进行提现！！");
        }
        //验证成功后数据处理
        $data = [
            'user_id'=>$user['member_id'],
            'k'=>$e_ticket,
            'money'=>$money,
            'withdraw_type'=>'支付宝',
            'withdraw_way'=>$withdraw_way,
            'intime'=>time(),
            'date'=>date('Y-m-d',time()),
            'relname' =>M("Alipay")->where(array("alipay_id"=>$alipay_id))->getField("relname"),
        ];
        // 启动事务
        M()->startTrans();
        try{
            M('Withdraw')->add($data);
            $get_money = $user['e_ticket'] - $e_ticket;
            M("user")->where(array('member_id'=>$user['user_id']))->save(['get_money'=>$get_money,'uptime'=>time()]);
            // 提交事务
            M()->commit();
            success("提现成功，请等待商家付款");
        } catch (\Exception $e) {
            // 回滚事务
            M()->rollback();
            error("提现失败，请核实提现信息");
        }
    }

    /**
     * @我的钱包
     */
    public function my_wallet(){
        $user = checklogin();
        $all_fire = $user['get_money'];
        $all_get_money = sprintf("%.2f",$all_fire*em_scale());
        //提现砖石最小值
        $lowest_limit = M("system")->where(["id"=>1])->value("day_lowest");
        //提现说明
        $result = ['all_fire'=>$all_fire,'all_get_money'=>$all_get_money,"lowest_limit"=>$lowest_limit];
        success($result);
    }

    /**
     * @提现记录
     */
    public function withdraw_list(){
        $user = checklogin();
        $page = I('p');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;
        $pageSize ? $pageSize : $pageSize = 10;

        $list = M('Withdraw')
            ->field('k,money,status,intime,withdraw_way,cash_time')
            ->where(['user_id'=>$user['user_id']])
            ->limit(($page-1)*$pageSize,$pageSize)
            ->order('intime desc')
            ->select();
        if ($list){
            foreach ($list as $k=>$v){
                switch ($list[$k]['status'])
                {
                    case 1:
                        $content= "申请中";
                        break;
                    case 2:
                        $content= " 驳回";
                        break;
                    case 3:
                        $content= " 已返现";
                        break;
                }
                $list[$k]["content"]=$content.":".$list[$k]['money']."元";
                $list[$k]['intime'] = date('Y-m-d H:i:s',$v['intime']);
            }
        }else{$list=[];}
        success($list);
    }

    /**
     * 导购视屏列表
     */
    public function video_list(){
        $user = checklogin();
        $params = I('param.');
        $member_id = empty($params["mid"]) ? error("无法获取商户信息") : $params["mid"];
        $p = I('p');
        $p  ?   $p  :   $p = 1;
        $pagesize = I('pagesize');
        $pagesize   ?   $pagesize   :   $pagesize = 10;
        $count =  M("video")->where(["is_del"=>1,"user_id"=>$member_id,'is_shenhe'=>'2'])->count();
        $list = M("video")->field("title,video_img,url,watch_nums,video_id,date")->where(["is_del"=>1,"user_id"=>$member_id,'is_shenhe'=>'2'])
            ->limit(($p-1)*$pagesize,$pagesize)->select();
        if(empty($list)){
            $list=[];
        }
       success(["count"=>(string)$count,"list"=>$list]);
    }

    public function live_info(){
        $live_id = I('live_id');
        if(empty($live_id))        error("参数错误");
        $live = M('live')->alias('a')
            ->field('a.*,b.username,b.img as header_img,b.user_id as member_id,b.ID')
            ->join('m_user b ON a.user_id = b.user_id')
            ->where(['a.live_id'=>$live_id])
            ->find();
        $live['share_url'] = C('IMG_PREFIX').'/mall_live/#/liveRoom_mobile?live_id='.$live['live_id'].'&room_id='.$live['room_id'];
        $live['header_img'] = domain($live['header_img']);
        $live['play_img'] = domain($live['play_img']);
        $live['qrcode_path'] = domain($live['qrcode_path']);
        success($live);
    }


    /**
     * 播放视频
     */
    public function play_video(){
        $user = checklogin();
        $params = I('param.');
        $video_id = empty($params["video_id"]) ? error("无法获取视频信息") : $params["video_id"];
        $ce = M("video")->where(["video_id"=>$video_id])->setInc("watch_nums");
        $watch_num = M("video")->where(["video_id"=>$video_id])->getField("watch_nums");
        success($watch_num);
    }



/*****************************************百台云********************************************/


}