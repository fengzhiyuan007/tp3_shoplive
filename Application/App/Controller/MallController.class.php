<?php
namespace App\Controller;
use Think\Controller;
class MallController extends CommonController
{
    /**
     *推荐商铺
     */
    public function showMerchants(){
        if (IS_POST) {
            //获取商家总数
            $where['open'] = 1;
            $where['is_delete'] = '0';
            $where['apply_state'] = '2';
            $where['pay_state'] = '1';
            $where['is_tuijian'] = '1';
            $pagesize = I('pagesize');
            $pagesize ? $pagesize : $pagesize = 9;
            //获取商家
            $merchants_list = M("shop_merchants")->field('member_id,merchants_img,live_id,merchants_name,total_sales,merchants_content')
                ->where($where)->order("live_id desc")->limit($pagesize)->select();
            foreach ($merchants_list as $k => $v) {
                if ($v["live_id"] != 0) {
                    $live_info = M("live")->where(["live_id" => $v["live_id"]])->find();
                    $merchants_list[$k]["room_id"] = $live_info["room_id"];
                    $merchants_list[$k]["play_address"] = $live_info["play_address"];
                }

            }
            return success($merchants_list);
        }
    }

    /**
     *搜索商铺
     */
    public function searchMerchants(){
        if (IS_POST) {
            $name = I('name');
            $p = I('p');
            $p ? $p : $p = 1;
            $pagesize = I('pagesize');
            $pagesize ? $pagesize : $pagesize = 10;
            $member_type = I("member_type");
            if(empty($member_type)){
                $name && $where['a.merchants_name|b.ID'] = ['like', '%' . $name . '%'];
                $where['a.is_delete'] = '0';
                $where['a.apply_state'] = '2';
                $where['a.open'] = 1;
                //$where['a.pay_state'] = '1';
                $type = I('type');   //搜索类型：1综合；2销量
                $type ? $type : $type = 1;
                switch ($type) {
                    case 1:
                        $order = 'a.is_tuijian desc,a.create_time asc';
                        break;
                    case 2:
                        $order = 'a.total_sales desc,a.create_time asc';
                        break;
                    default :
                        $order = 'a.is_tuijian desc,a.create_time asc';
                }
                $count = M('shop_merchants')->alias('a')
                    ->join('m_user b ON a.member_id = b.user_id')
                    ->where($where)->count();
                $merchants_list = M("shop_merchants")->alias('a')
                    ->field('a.member_id,a.merchants_img,a.live_id,a.merchants_name,a.total_sales,a.merchants_content')
                    ->join('m_user b ON a.member_id = b.user_id')
                    ->where($where)->order($order)
                    ->limit(($p - 1) * $pagesize, $pagesize)->select();
                foreach ($merchants_list as $k=>$v){
                    $merchants_list[$k]["play_address"] ='';
                    $merchants_list[$k]["room_id"] ='';
                    $merchants_list[$k]["fans_count"] ='0';
                    $merchants_list[$k]["title"]="";
                }
                $page = ceil($count / $pagesize);
            }else{
                $name && $where["a.username"] = ["like",'%'.$name.'%'];
                $where["a.is_del"] = 1;
                $where["a.type"] =["in",[2,3]];
                $order = 'a.mlive_id desc,a.is_recommend desc,b.intime desc';
                $count = M("user")
                    ->where(["is_del"=>1,"type"=>["in",[2,3]]])
                    ->count();
                $merchants_list = M('user')->alias('a')
                    ->field('a.user_id,a.img as merchants_img,b.live_id,a.username as merchants_name,a.autograph as merchants_content,b.watch_nums as total_sales,b.play_address,b.room_id,b.title,b.play_img')
                    ->join('__LIVE__ b ON a.mlive_id = b.live_id','LEFT')
                    ->where($where)->order($order)
                    ->limit(($p-1)*$pagesize,$pagesize)
                    ->select();
                foreach ($merchants_list as $k=>$v){
                    $fans_count = M("Follow")->where(["user_id2"=>$v['user_id']])->count();
                    $list[$k]["fans_count"] = (string)$fans_count;
                    if(!$v['live_id']){

                        $merchants_list[$k]['merchants_img'] =C('IMG_PREFIX').$merchants_list[$k]['merchants_img'];

                        $merchants_list[$k]['live_id'] ='0';
                        $merchants_list[$k]['total_sales'] ='0';
                        $merchants_list[$k]['play_address'] ='';
                        $merchants_list[$k]['room_id'] ='';
                        $merchants_list[$k]['title'] ='';
                        $merchants_list[$k]['share_url'] = C('IMG_PREFIX').'/mall_live/#/liveRoom_mobile?live_id='.$v['live_id'].'&room_id='.$v['room_id'];
                    }else{
                        $merchants_list[$k]['share_url'] = '';
                    }
                    $fans_count = M("Follow")->where(["user_id2"=>$v["user_id"]])->count();
                    $merchants_list[$k]["fans_count"] = (string)$fans_count;
                }
                $page = ceil($count/$pagesize);
            }
            success(['page' => $page, 'merchants_list' => $merchants_list]);
        }
    }

    /**
     *搜索商品
     */
    public function searchGoods(){
        if (IS_POST) {
            $name = I('name');
            $p = I('p');
            $p ? $p : $p = 1;
            $pagesize = I('pagesize');
            $pagesize ? $pagesize : $pagesize = 10;
            $name && $where['a.goods_name'] = ['like', '%' . $name . '%'];
            $class_uuid = I('class_uuid');
            if($class_uuid){
                $class = M('shop_goods_class')->where(['class_uuid'=>$class_uuid])->find();
                if($class){
                    $where['parent_class|seed_class'] = $class['class_id'];
                }else{
                    success(['page' => 0, 'goodsBean' => []]);
                }
            }
            $merchants_id = I('merchants_id');
            !empty($merchants_id)    &&  $where['a.merchants_id'] = $merchants_id;
            $where['a.is_delete'] = '0';
            $where['a.goods_state'] = '1';
            $where['a.is_review'] = '1';

            $where['b.open'] = 1;
            $where['b.apply_state'] = 2;
            $where['b.is_delete'] = 0;

            $type = I('type');   //搜索类型：1综合；2销量高；3低价； 4高价
            $type ? $type : $type = 1;
            switch ($type) {
                case 1:
                    $order = 'a.important desc,a.is_tuijian desc,a.sort desc,a.create_time asc';
                    break;
                case 2:
                    $order = 'a.total_sales desc,a.sort desc,a.create_time asc';
                    break;
                case 3:
                    $order = 'a.goods_now_price asc,a.sort desc,a.total_sales desc,a.create_time asc';
                    break;
                case 4:
                    $order = 'a.goods_now_price desc,a.sort desc,a.total_sales desc,a.create_time asc';
                    break;
                case 5:
                    $order = 'a.total_sales asc,a.sort desc,a.create_time asc';
                    break;
                default :
                    $order = 'a.is_tuijian desc,a.sort desc,a.create_time asc';
            }
            $count = M('shop_goods')->alias('a')
                    ->join('m_shop_merchants b ON a.merchants_id=b.member_id')
                    ->where($where)->count();
            $list = M("shop_goods")->alias('a')
                    ->join('m_shop_merchants b ON a.merchants_id=b.member_id')
                ->field('a.goods_id,a.goods_img,a.goods_name,a.goods_now_price,a.goods_pc_price,a.goods_origin_price,a.total_sales,
            a.month_sales,a.day_sales,a.goods_desc,a.goods_per,b.merchants_name,b.merchants_img')
                ->where($where)->order($order)
                ->limit(($p - 1) * $pagesize, $pagesize)->select();
            if(!$list){
                $list = [];
            }else{
                foreach ($list as $k => &$v) {
                    $v['is_all'] = warehouse($v['goods_id']);
                    $v['goods_per'] = $v['goods_per'].'%';
                    $v['price_per'] = sprintf('%.2f',($v['goods_per']/100) * $v['goods_now_price']);
                }
            }
            $page = ceil($count / $pagesize);
            success(['page' => $page, 'goodsBean' => $list]);
        }
    }

    /**
     *好货分类
     */
    public function showGoodsClass(){
        if (IS_POST) {
            $where = [
                'is_delete' => '0',
                'class_state' => '1',
                'parent_id' => '-1',
                'is_recommend' => '1'
            ];
            $list = M('shop_goods_class')
                ->field('class_id,class_name,class_desc,class_img,class_color,class_uuid,template_img')
                ->where($where)->order("sort desc")->select();
           return success($list);
        }
    }

    /**
     *好货推荐
     */
    public function showGoods(){
        if (IS_POST) {
            $where = [
                'is_delete' => '0',
                'class_state' => '1',
                'parent_id' => '-1',
                'is_recommend' => '1'
            ];
            $list = M('shop_goods_class')
                ->field('class_id,class_name,class_desc,class_img,class_color,class_uuid,template_img')
                ->where($where)->order("sort desc")->select();
            foreach ($list as &$v) {
                $v['show_goods'] = M('shop_goods')
                    ->field('goods_id,goods_name,goods_img,goods_origin_price,goods_pc_price,goods_now_price')
                    ->where(['parent_class|seed_class' => $v['class_id'], 'is_delete'=>'0', 'goods_state' => '1','is_review' => 1])->order('important desc,sort desc,create_time asc')
                    ->select();
            }

//            foreach ($list as &$v) {
//                $class_id = $v['class_id'];
//                $map = array();
//                $map[] = ['exp','FIND_IN_SET('.$class_id.',goods_class)'];
//                $map['is_delete'] = '0';
//                $map['goods_state'] = '1';
//                $map['is_delete'] = '0';
//                $map['is_tuijian'] = '1';
//                $v['show_goods'] = Db::name('goods')
//                    ->field('goods_id,goods_name,goods_img,goods_origin_price,goods_pc_price,goods_now_price')
//                    ->where($map)->order('sort desc,create_time asc')
//                    ->limit(8)
//                    ->select();
//            }

            return success($list);
        }
    }

    /**
     *分类商品
     */
    public function class_goods()
    {
        if (IS_POST) {
            $p = I('p');
            empty($p) && $p = 1;
            $pageSize = I('pagesize');
            $pageSize ? $pageSize : $pageSize = 10;
            $class_uuid = I('class_uuid');
            if (!$class_uuid) error("商户分类id错误");
            $goodsClass = M('shop_goods_class')
                ->field('class_id,class_name,class_desc,class_img,class_color,class_uuid,template_img')
                ->where(['class_uuid' => $class_uuid])->find();
            if (!$goodsClass) error("商户分类id错误");

            $where['parent_class|seed_class'] = $goodsClass['class_id'];
            $where['is_delete'] = '0';
            $where['goods_state'] = '1';
            $where['is_review'] = '1';
            $list = M('shop_goods')
                ->field('goods_id,goods_name,goods_img,goods_origin_price,goods_pc_price,goods_now_price')
                ->where($where)->order('important desc,is_tuijian desc,sort desc,create_time asc')
                ->page($p, $pageSize)->select();
            $count = M('shop_goods')->where($where)->count();
            $page = ceil($count / $pageSize);
            return success(['page' => $page, 'goodsBean' => $list]);
        }
    }

    /**
     *店铺基础信息 
     *描述 评价
     */
    public function merchants_info()
    {
        if (IS_POST) {
            $uid = I('uid');
            if ($uid) {
                $member = M('user')->where(['user_id'=>$uid])->find();
                if(!$member)        pending("token failed");
            }
            $merchants_id = I('merchants_id');//商家商户id
            if (!$merchants_id) error("商户店铺id不能为空");
            $where['member_id'] = $merchants_id;
            $merchants = M('shop_merchants')->where($where)->find();
            if ($merchants) {
                if ($uid) {
                    $check = M('shop_follow_merchants')->where(['user_id' => $uid, 'user_id2' => $merchants_id,'is_delete'=>'1'])->find();
                    if ($check) {
                        $merchants['is_follow'] = '1';     //已关注
                    } else {
                        if ($member['user_id'] != $merchants_id) {
                            $merchants['is_follow'] = '2'; //未关注
                        } else {
                            $merchants['is_follow'] = '3';  //表示是自己
                        }
                    }
                } else {
                    $merchants['is_follow'] = '2'; //未关注
                }
            }
         $goods_comment_star = M('shop_goods_comment')->where(['merchants_id'=> $merchants_id ])->sum('mark');
         $goods_comment_count = M('shop_goods_comment')->where(['merchants_id'=> $merchants_id ])->count();
         $merchant['merchants_star1'] = sprintf('%.2f',($goods_comment_star+5)/($goods_comment_count+1));//商品评分
        $merchant_comment_count = M('shop_merchants_comment')->where(['merchants_id'=> $merchants_id ])->count();
        $merchant_comment_service = M('shop_merchants_comment')->where(['merchants_id'=> $merchants_id ])->sum('service_mark');
        $merchant_comment_express = M('shop_merchants_comment')->where(['merchants_id'=> $merchants_id ])->sum('express_mark');
         $merchant['merchants_star2'] = sprintf('%.2f',($merchant_comment_service+5)/($merchant_comment_count+1));//服务评分
         $merchant['merchants_star3'] = sprintf('%.2f',($merchant_comment_express+5)/($merchant_comment_count+1));//服务评分
         $merchants_comment= M('shop_merchants_comment')->where(['merchants_id'=>$merchants_id])->find();
         $merchants['merchants_star1']= $merchant['merchants_star1'] ;
         $merchants['merchants_star2']= $merchant['merchants_star2'];
         $merchants['merchants_star3']= $merchant['merchants_star3'];

           return success($merchants);
        }
    }

    /**
     *商户商品分类
     */
    public function merchants_class()
    {
        if (IS_POST) {
            //$member = $this->checklogin();
            $merchants_id = I('merchants_id');//商家商户id

            $array[] = ['class_id'=>'','class_name'=>'全部','class_uuid'=>''];

            if (!$merchants_id) error("商户店铺id不能为空");
            $uid = M('shop_merchants')->where(['merchants_id'=>$merchants_id])->getField('member_id');
            $merchants = M('user')->where(['user_id'=>$uid])->find();
            if($merchants['type'] == '3'){
                $list = M('shop_goods_class')->field('class_id,class_name,class_uuid')
                    ->where(['parent_id'=>'-1','is_delete'=>'0'])->select();
            }else{
                $list = M('shop_goods_merchants_class')->alias('a')
                    ->field('b.class_id,b.class_name,b.class_uuid')
                    ->join('m_shop_goods_class b ON FIND_IN_SET(b.class_id,a.class_id)')
                    ->where(['a.member_id' => $uid, 'b.is_delete' => 0])
                    ->select();
                // echo M()->getLastSql();
            }
        
        $all = M('shop_goods_class')
            ->field('class_id,class_name,class_uuid')
            ->where(['class_state' => 1, 'parent_id' => '-1', 'is_delete'=>0])
            ->select();

            if(!empty($list)){
                $list = array_merge($array,$list);
            }else{
                $list = [];
            }

            return success($all);
        }
    }

    /**
     * 商品所有分类
     * 
     */
    public function goods_class(){
        $all = M('shop_goods_class')
            ->field('class_id,class_name,class_uuid')
            ->where(['class_state' => 1, 'parent_id' => '-1', 'is_delete'=>0])
            ->order('sort desc')
            ->select();
        success($all);
    }

    /**
     * 根据商品分类筛选商户
     */
    public function search_merchants(){
        $class_id = I('class_id');
        $merchants_name = I('merchants_name');
        empty($class_id)?error('参数错误'):true;

        $dat['_string']='FIND_IN_SET("'.$class_id.'", a.class_id)';
        $dat['apply_state'] = 2;
        $dat['open'] = 1;
        $dat['is_delete'] = 0;

        if($merchants_name){
            $dat['merchants_name'] = ['like', '%' . $merchants_name . '%'];
        }

        $list = M('shop_goods_merchants_class')->alias('a')
              ->join('m_shop_merchants b ON a.member_id = b.member_id')
              ->field('a.class_id,b.member_id as merchants_id,b.merchants_name,b.merchants_img,b.contact_name,b.contact_mobile,b.is_all,b.open')
              ->where($dat)
              ->select();
        if(!$list){
            $list = [];
        }else{
            foreach ($list as $k => &$v) {
                $v['merchants_img'] = domain($v['merchants_img']);
            }
        }
        success($list);
    }


    /**
     *商户店铺商品
     *搜索商品
     *
     */
    public function merchants_goods()
    {
        if (IS_POST) {
            $merchants_id = I('merchants_id');//商家商户id
            if (!$merchants_id) error("商户店铺id不能为空");
            $goods_name = I('goods_name');
            $p = I('p');
            empty($p) && $p = 1;
            $pageSize = I('pagesize');
            $pageSize ? $pageSize : $pageSize = 10;
            $where = [
                'merchants_id' => $merchants_id,
                'is_delete' => '0',
                'goods_state' => '1',
                'is_review' => '1'
            ];
            if ($goods_name) $where['goods_name'] = ['like', '%' . $goods_name . '%'];
            $list = M('shop_goods')->field('goods_id,goods_name,goods_img,goods_origin_price,goods_pc_price,goods_now_price')
                ->where($where)->order('important desc,is_tuijian desc,sort desc,create_time asc')
                ->page($p, $pageSize)->select();
            $count = M('shop_goods')->where($where)->count();
            $page = ceil($count / $pageSize);
           return success(['page' => $page, 'list' => $list]);
        }
    }

    /**
     *商户分类商品
     */
    public function merchants_class_goods()
    {
        if (IS_POST) {
            $merchants_id = I('merchants_id');//商家商户id
            if (!$merchants_id) error("商户店铺id不能为空");
            $p = I('p');
            empty($p) && $p = 1;
            $pageSize = I('pagesize');
            $pageSize ? $pageSize : $pageSize = 10;
            $class_uuid = I('class_uuid');
            if (!$class_uuid) error("商户分类id错误");
            $class = M('shop_goods_class')->where(['class_uuid' => $class_uuid])->find();
            if (!$class) error("商户分类id错误");
            $where['parent_class|seed_class'] = $class['class_id'];
            $where['is_delete'] = '0';
            $where['merchants_id'] = $merchants_id;
            $where['goods_state'] = '1';
            $where['is_review'] = '1';
            $list = M('shop_goods')
                ->field('goods_id,goods_name,goods_img,goods_origin_price,goods_pc_price,goods_now_price,month_sales,total_sales')
                ->where($where)->order('important desc,is_tuijian desc,sort desc,create_time asc')
                ->page($p, $pageSize)->select();
            $count = M('shop_goods')->where($where)->count();
            $page = ceil($count / $pageSize);
            return success(['page' => $page, 'list' => $list]);
        }
    }

    /**
     *商品基础信息
     */
    public function goods_info()
    {
        if(IS_POST) {
            $goods_id = I('goods_id');
            if (!$goods_id) error('商品id不能为空');
            $uid = I('uid');
            /*商品基础信息*/
            $goods = M('shop_goods')->where(['goods_id' => $goods_id])->find();
            if (empty($goods)) error("商品不存在");

            if($uid){
                /*插入商品浏览记录表*/
                $result = M('shop_goods_histroy')->where(['goods_id'=>$goods_id,'user_id'=>$uid])->find();
                if($result){
                    M('shop_goods_histroy')->where(['id'=>$result['id']])->setInc('count');
                }else{
                    M('shop_goods_histroy')->add(['goods_id'=>$goods_id,'user_id'=>$uid,'intime'=>time()]);
                }
                /*插入商品浏览记录表*/
            }

            $imgs = explode(',', $goods['imgs']);
            foreach ($imgs as $k => $v) {
                if(!empty($v)){
                    $img[] = $v;
                }
            }
            if($goods['goods_state'] !=1|| $goods['is_delete'] != '0' || $goods['is_review'] != '1'){
                $goods['is_stop'] = '1';
            }else{
                $goods['is_stop'] = '2';
            }

            !empty($img) ? $goods['imgs'] = $img  : $goods['imgs'] = [];
            $goods['goods_detail'] = $goods['goods_detail'];
            //父级分类
//            $goodsSpecificationBeans = Db::name('goods_relation_specification')->alias('a')
//                ->field('c.specification_id,c.specification_value')
//                ->join('th_goods_specification b', 'FIND_IN_SET(b.specification_id,a.specification_ids)')
//                ->join('th_goods_specification c', 'b.parent_id=c.specification_id')
//                ->where(['a.is_delete' => '0', 'a.goods_id' => $goods_id, 'b.is_delete' => '0', 'c.is_delete' => '0'])
//                ->group('c.specification_id')
//                ->select();
            $beans = M('shop_goods_relation_specification')->where(['goods_id'=>$goods['goods_id'],'is_delete'=>'0'])->order("specification_id desc")->getField('specification_ids');
            $beans = explode(',',$beans);
            $goodsSpecificationBeans = array();
            foreach ($beans as $v){
                $arr1 = M('shop_goods_specification')->alias('a')
                    ->field('b.specification_id,b.specification_value')
                    ->join('m_shop_goods_specification b ON a.parent_id = b.specification_id')
                    ->where(['a.specification_id'=>$v,'a.is_delete'=>0])
                    ->find();

                if(!empty($arr1)) {
                    if (!in_array($arr1, $goodsSpecificationBeans)) {
                        array_push($goodsSpecificationBeans, $arr1);
                    }
                }
            }
            if (!empty($goodsSpecificationBeans)) {
                foreach ($goodsSpecificationBeans as &$v) {
                    $specificationBeans = M('shop_goods_relation_specification')->alias('a')
                        ->field('b.specification_value,b.specification_id,a.specification_id as s_id')
                        ->join('m_shop_goods_specification b ON FIND_IN_SET(b.specification_id,a.specification_ids)')
                        ->where(['b.is_delete' => '0', 'b.parent_id' => $v['specification_id'], 'a.is_delete' => '0', 'a.goods_id' => $goods_id])
                        ->group('b.specification_id')
                        ->select();
                    if($specificationBeans){
                        $v['specificationBeans'] = $specificationBeans;
                    }
                    $specification[] = $v['specification_value'];
                    
                }
                $goods['goodsSpecificationBeans'] = $goodsSpecificationBeans;
                $goods['specification'] = join('、', $specification);
            } else {
                $goods['goodsSpecificationBeans'] = [];
                $goods['specification'] = '';
            }
            /*商品和物流评分*/
            /*            $where['type']    = 1;
                        $where['object_id'] = $goods_id;
                        $count = M('Comment')->where($where)->count();
                        if(empty($count)){
                            $goods['goods_mark']    = 5;
                            $goods['express_mark']    = 5;
                            $goods['send_mark']    = 5;
                        }else{
                            $goods_mark = M('Comment')->where($where)->sum('goods_mark');
                            $express_mark = M('Comment')->where($where)->sum('express_mark');
                            $send_mark = M('Comment')->where($where)->sum('send_mark');
                            $goods['goods_mark']    = (int)(($goods_mark + 5)/($count+1));
                            $goods['express_mark']  = (int)(($express_mark + 5)/($count+1));
                            $goods['send_mark']     = (int)(($send_mark + 5)/($count+1));
                        }
                        $goods['together_mark'] = sprintf("%.1f",($goods_mark+$express_mark+$send_mark+15)/(($count+1)*3));*/

            $goods['is_collect'] = '2';
            /*检测是否收藏*/
            if (!empty($uid)) {
                $map['member_id'] = $uid;
                $map['goods_id'] = $goods_id;
                $map['is_delete'] = '1';
                $check = M('shop_goods_collection')->where($map)->find();
                if ($check) {
                    $goods['is_collect'] = '1';
                }

            }
            $goods['goods_url'] = $this->url . U('Mall/goods_url', ['goods_id' => $goods_id]);
            //商品评论
            $comment = M('shop_goods_comment')->alias('a')
                     ->field('a.comment_desc,a.mark,a.img,b.username,b.img as header_img,a.create_time')
                     ->join('m_user b ON a.member_id = b.user_id')
                     ->where(['a.is_delete'=>'0','a.goods_id'=>$goods_id])
                     ->order("a.create_time desc")->limit(1)->select();
            if($comment){
               foreach ($comment as &$v){
                    if($v['img']){
                        $v['img'] = explode(',',$v['img']);
                    }else{
                        $v['img'] = [];
                    }
                    $v['header_img'] = C('IMG_PREFIX').$v['header_img'];
                } 
            }else{
                $comment = [];
            }
            
            $parent_class = M('shop_goods_class')->where(['class_id'=>$goods['parent_class']])->find();
            $goods['parent_class_name'] = $parent_class['class_name'];
            $goods['parent_class_uuid'] = $parent_class['class_uuid'];
            $seed_class = M('shop_goods_class')->where(['class_id'=>$goods['seed_class']])->find();
            $goods['seed_class_name'] = $seed_class['class_name'];
            $goods['seed_class_uuid'] = $seed_class['class_uuid'];
            $goods['comment'] = $comment;
            $goods['merchants_star1']=2;
            $goods['merchants_star2']=3;
            $goods['merchants_star3']=4;
            $goods['share_url'] = C("IMG_PREFIX").'/App/Index/share_goods?goods_id='.$goods['goods_id'];
            return success($goods);
        }
    }
    //商品评论
    public function goods_comment(){
        $goods_id = I('goods_id');
        if(!$goods_id)      error("参数错误");
        $p = I('p');
        $p ? $p : $p = 1;
        $pagesize = I('pagesize');
        $pagesize ? $pagesize : $pagesize = 10;
        $count =  M('shop_goods_comment')->alias('a')
            ->join('m_user b ON a.member_id = b.user_id')
            ->where(['a.is_delete'=>'0','a.goods_id'=>$goods_id])
            ->count();
        $comment = M('shop_goods_comment')->alias('a')
            ->field('a.comment_desc,a.mark,a.img,b.username,b.img as header_img,a.create_time')
            ->join('m_user b ON a.member_id = b.user_id')
            ->where(['a.is_delete'=>'0','a.goods_id'=>$goods_id])
            ->limit(($p-1)*$pagesize,$pagesize)
            ->order("a.create_time desc")->select();
        if(!empty($comment)){
            foreach ($comment as &$v){
                if($v['img']){
                    $v['img'] = explode(',',$v['img']);
                }else{
                    $v['img'] = [];
                }
                $v['header_img'] = C('IMG_PREFIX').$v['header_img'];
            }
        }
        $page = ceil($count/$pagesize);
        success(['page'=>$page,'comment'=>$comment,'count'=>$count]);
    }

    /**
     *@商品收藏与取消收藏
     */
    public function goods_collect(){
        if (IS_POST) {
            $member = checklogin();
            $id = I('goods_id');
            if (!$id) error("商品参数错误");
            $check = M('shop_goods_collection')->where(['goods_id' => $id, 'member_id' => $member['user_id']])->find();
            if ($check) {
                if ($check['is_delete'] == '1') {
                    $update['is_delete'] = '2';

                } else {
                    $update['is_delete'] = '1';
                }
                $result = M('shop_goods_collection')->where(['collection_id' => $check['collection_id']])->save($update);
                if ($result) {
                    success($update['is_delete']);
                } else {
                    error("操作失败");
                }
            } else {
                $data['member_id'] = $member['user_id'];
                $data['goods_id'] = $id;
                $data['intime'] = date("Y-m-d H:i:s", time());
                $result = M('shop_goods_collection')->add($data);
                if ($result) {
                    success('1');
                } else {
                    error("操作失败");
                }
            }
        }
    }

    /**
     *@收藏列表
     */
    public function collect(){
        if (IS_POST) {
            $member = checklogin();
            $map['a.is_delete'] = '1';
            $map['b.is_delete'] = '0';
            $map['b.goods_state'] = '1';
            $map['b.is_review'] = '1';
            $map['a.member_id'] = $member['user_id'];
            $p = I('p');
            $count = M('shop_goods_collection')->alias('a')
                ->join('m_shop_goods b ON a.goods_id = b.goods_id')
                ->where($map)->count();
            empty($p) && $p = 1;
            $num = I('pagesize');
            $num ? $num : $num = 10;
            $page = ceil($count / $num);
            $list =M('shop_goods_collection')->alias('a')
                ->field("a.collection_id,a.goods_id,b.goods_name,b.goods_img,b.goods_now_price,b.goods_origin_price,b.goods_pc_price,b.goods_desc")
                ->join('m_shop_goods b ON a.goods_id = b.goods_id')
                ->where($map)->limit(($p - 1) * $num, $num)
                ->select();
            success(['page' => $page, 'list' => $list]);
        }
    }

    /**
     *@删除收藏
     */
    public function del_collect(){
        if (IS_POST) {
            $member = checklogin();
            $ids = I('ids');
            $map['collection_id'] = ['in',$ids];
            $map['member_id'] = $member['user_id'];
            $result = M('shop_goods_collection')->where($map)->save(['is_delete'=>'2']);
            if($result){
                success("操作成功");
            }else{
                error("操作失败");
            }
        }
    }

    /**
     *商品图文详情
     */
    public function goods_url()
    {
        $id = I('goods_id');
        $text = M('shop_goods')->where(['goods_id' => $id])->getField('goods_detail');

        $this->assign(['text' => htmlspecialchars_decode($text)]);
        $this->display();
    }

    /**
     *查询型号库存
     */
    public function get_specification()
    {
        if (IS_POST) {
            $goods_id = I('goods_id');
            if (!$goods_id) error("商品id不能为空");
            $specification_ids = I('specification_ids');
            if (!$specification_ids) error("型号参数不能为空");
            $re = M('shop_goods_relation_specification')
                ->field('specification_id,goods_id,specification_names,specification_sales,specification_ids,specification_stock,specification_img,specification_sale_price,specification_price')
                ->where(['goods_id' => $goods_id, 'specification_ids' => $specification_ids])
                ->find();
            if(!$re){
                $goods = M('shop_goods')->where(['goods_id'=>$goods_id])->find();
                $re['specification_id'] = '';
                $re['goods_id'] = $goods_id;
                $re['specification_ids'] = '';
                $re['specification_stock'] = '0';
                $re['specification_names'] = '';
                $re['specification_sales'] = '';
                $re['specification_img'] = $goods['goods_img'];
                $re['specification_sale_price'] = $goods['goods_now_price'];
                $re['specification_price'] = $goods['goods_origin_price'];
            }
           return success($re);
        }
    }

    /**
     *加入购物车
     */
    public function insertShopCar(){
        if (IS_POST) {
            $member = checklogin();
            $goods_id = I('goods_id');
            if (!$goods_id) error("商品不能为空");
            $goods = M('shop_goods')->where(['goods_id' => $goods_id])->find();
            if (!$goods) error("商品库没有找到该商品");
            if($goods['goods_state'] !=1|| $goods['is_delete'] != '0' || $goods['is_review'] != '1'){
                error("该商品已下架");
            }
            $specification_id = I('specification_id');//规格id

            $seller = I('seller')?I('seller'):0;//销售者
            // $live_id = I('live_id')?I('live_id'):0;//直播id
            $a_id = I('a_id')?I('a_id'):0;//活动id

            $goods_num = I('goods_num');
            if (!$goods_num) error("购买数量错误");
            if (!$this->isSignlessInteger($goods_num)) error("购买数量错误");

            $where['goods_id'] = $goods_id;
            $where['member_id'] = $member['user_id'];

            if ($specification_id) {//是否有型号参数

                $specification = M('shop_goods_relation_specification')
                    ->where(['goods_id' => $goods_id, 'specification_id' => $specification_id])
                    ->find();
                // echo M()->getLastSql();
                // print_r($specification);exit;
                if ($specification) {

                /*************购物车中已经添加的和要添加的和************/
                    $owncar = M('shop_goods_shop_car')
                            ->where(array('goods_id'=>$goods_id,'specification_id'=>$specification_id,'member_id'=>$member['user_id'],'is_valid'=>1))
                            ->getField('goods_num');

                    $owncar = $owncar ? $owncar : 0;

                    $goods_num = intval($owncar + $goods_num);
                /*************购物车中已经添加的和要添加的和************/

                    $specification['specification_img'] ? $data['goods_img'] = $specification['specification_img'] : $data['goods_img'] = $goods['goods_img'];
                    $data['specification_names'] = $specification['specification_names'];
                    $data['specification_ids'] = $specification['specification_ids'];
                    $data['specification_id'] = $specification_id;
                    if($specification['specification_stock']<$goods_num)        error("商品库存不足");
                } else {
                    error("商品型号参数错误");
                }
                $where['specification_id'] = $specification_id;
            } else {

            /*************购物车中已经添加的和要添加的和************/
                $owncar = M('shop_goods_shop_car')
                        ->where(array('goods_id'=>$goods_id,'member_id'=>$member['user_id'],'is_valid'=>1))
                        ->getField('goods_num');

                $owncar = $owncar ? $owncar : 0;
                // print_r($owncar);
                $goods_num = intval($owncar + $goods_num);
                // print_r($goods_num);
                // print_r($goods['goods_stock']);

                // exit;
            /*************购物车中已经添加的和要添加的和************/

                $data['goods_img'] = $goods['goods_img'];
                if($goods['goods_stock']<$goods_num)        error("商品库存不足");
            };

            $data['goods_name'] = $goods['goods_name'];
            if($seller && $a_id){
                $data['seller'] = $seller;
                // $data['live_id'] = $live_id;
                $data['a_id'] = $a_id;

                $where['a_id'] = $a_id;
            }else{
                // $check_seller = M('shop_goods_shop_car')->where(['goods_id'=>$goods_id,'seller'=>$seller])->find();
                // if($check_seller){
                    // $data['seller'] = 0;
                    // $data['live_id'] = $check_seller['live_id'];

                    $where['a_id'] = 0;

                // }
            }
            $check = M('shop_goods_shop_car')->where($where)->find();
            if ($check) {  //购物车中有该商品
                $data['goods_num'] = $check['goods_num'] + I('goods_num');
                $data['update_time'] = date("Y-m-d H:i:s", time());
                $result = M('shop_goods_shop_car')->where(['car_id' => $check['car_id']])->save($data);
            } else {
                $data['member_id'] = $member['user_id'];
                $data['merchants_id'] = $goods['merchants_id'];
                $data['goods_num'] = I('goods_num');
                $data['goods_id'] = $goods['goods_id'];
                $data['create_time'] = date("Y-m-d H:i:s", time());
                $result = M('shop_goods_shop_car')->add($data);
            }

            if ($result) {
                success("商品添加购物车成功");
            } else {
                error("商品添加购物车失败");
            }

        }
    }

    /**
     *购物车中商品
     */
    public function getShopCars(){
        if (IS_POST) {
            $member = checklogin();
            $list = M('shop_goods_shop_car')->where(['member_id' => $member['user_id']])->order('is_valid asc')->select();
            //if (empty($list)) success((object)null);
            if($list){
                foreach ($list as $v) {
                    $goods = M('shop_goods')->where(['goods_id' => $v['goods_id']])->find();
                    if ($goods) {
                            if ($v['specification_id']) { //查询库存，如果库存不足，商品无效
                                $specification = M('shop_goods_relation_specification')->where(['specification_id' => $v['specification_id']])->find();
                                if ($specification) {
                                    if ($specification['specification_stock'] < $v['goods_num'] || $specification['is_delete'] == '1') {
                                        $no_valid[] = $v['car_id'];
                                    } else {
                                        $valid[] = $v['car_id'];
                                    }
                                }
                            } else {
                                if ($goods['goods_stock'] < $v['goods_num'] || $goods['is_delete'] == '1' || $goods['goods_state'] == '2' || $goods['is_review'] == '0') {
                                    $no_valid[] = $v['car_id'];
                                } else {
                                $valid[] = $v['car_id'];
                            }
                        }
                    }else{
                        $no_valid[] = $v['car_id'];
                    }
                }
            }
            
            if (!empty($no_valid)) {
                M('shop_goods_shop_car')->where(['car_id' => ['in', $no_valid]])->save(['is_valid' => '2']);
            }
            if($valid){
                M('shop_goods_shop_car')->where(['car_id' => ['in', $valid]])->save(['is_valid' => '1']);
            }
            
            $valid_count = M('shop_goods_shop_car')->where(['member_id' => $member['user_id'], 'is_valid' => '1'])->count();
            //分店铺查询有效商品查询
            $valid_data = M('shop_goods_shop_car')->alias('a')
                ->field('a.merchants_id,b.merchants_name,merchants_img')
                ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
                ->where(['a.member_id' => $member['user_id'], 'a.is_valid' => '1'])
                ->group('a.merchants_id')->select();
            if($valid_data){
                foreach ($valid_data as &$v) {
                    $goods = M('shop_goods_shop_car')->alias('a')
                        ->field('a.car_id,a.goods_id,a.specification_id,a.goods_name,a.goods_num,a.goods_img,specification_names,b.goods_origin_price,b.goods_pc_price,b.goods_now_price,a.live_id,a.seller,a.a_id')
                        ->join('m_shop_goods b ON a.goods_id = b.goods_id')
                        ->where(['a.merchants_id' => $v['merchants_id'], 'a.member_id' => $member['user_id'], 'is_valid' => '1'])
                        ->select();
                    if($goods){
                        foreach ($goods as $key => $val) {
                            if ($val['specification_id']) {
                                $specification = M('shop_goods_relation_specification')->where(['specification_id' => $val['specification_id']])->find();
                                if ($specification) {
                                    $goods[$key]['goods_origin_price'] = $specification['specification_price'];
                                    $goods[$key]['goods_now_price'] = $specification['specification_sale_price'];
                                }
                            }
                            if (!$val['specification_names']) {
                                $val['specification_names'] = '无';
                            }
                            //主播名称
                            $goods[$key]['live_name'] = M('user')->where(['user_id'=>$goods[$key]['seller']])->getField('username');
                            if(!$goods[$key]['live_name']){
                                $goods[$key]['live_name'] = '';
                            }
                            //主播头像
                            $goods[$key]['live_img'] = M('user')->where(['user_id'=>$goods[$key]['seller']])->getField('img');
                            if(!$goods[$key]['live_img']){
                                $goods[$key]['live_img'] = '';
                            }else{
                                $goods[$key]['live_img'] = domain($goods[$key]['live_img']);
                            }
                            //查看是否是总仓商品
                            $goods[$key]['is_all'] = warehouse($goods[$key]['goods_id']);
                        }
                        $v['goods'] = $goods;
                    }
                    
                }
            }
            

            //分店铺查询无效商品查询

            $no_valid_data = M('shop_goods_shop_car')->alias('a')
                ->field('a.car_id,a.goods_id,a.specification_id,a.goods_name,a.goods_num,a.goods_img,specification_names,b.goods_origin_price,b.goods_pc_price,b.goods_now_price')
                ->join('m_shop_goods b ON a.goods_id = b.goods_id')
                ->where(['a.member_id' => $member['user_id'], 'is_valid' => '2'])
                ->select();
            if($no_valid_data){
                foreach ($no_valid_data as $key => $val) {
                    if ($val['specification_id']) {
                        $specification = M('shop_goods_relation_specification')->where(['specification_id' => $val['specification_id']])->find();
                        if ($specification) {
                            $no_valid_data[$key]['goods_origin_price'] = $specification['specification_price'];
                            $no_valid_data[$key]['goods_now_price'] = $specification['specification_sale_price'];
                        }
                    }
                    if (!$val['specification_names']) {
                        $val['specification_names'] = '无';
                    }
                }
            }
            

            $data['valid_count'] = $valid_count;
            $data['valid_data'] = $valid_data?$valid_data:[];
            $data['no_valid_data'] = $no_valid_data?$no_valid_data:[];

            success($data);
        }
    }

    /**
     *购物车数量
     */
    public function getShopCarCount(){
        if (IS_POST) {
            $uid = I('uid');
            if ($uid) {
                $member = checklogin();
                $count = M('shop_goods_shop_car')->where(['member_id' => $member['user_id'], 'is_valid' => '1'])->count();
                if ($count) {
                    return success($count);
                } else {
                    return success('0');
                }
            } else {
                return success('0');
            }
        }
    }



    /**
     *推荐商品
     */
    public function maybeEnjoy(){
        if (IS_POST) {
            $uid = I('uid');
            $pagesize = I('pagesize');
            $pagesize ? $pagesize  :  $pagesize = 10;
            if($uid){
                $member = checklogin();
                $goods = M('shop_goods_shop_car')->where(['member_id'=>$member['user_id']])->getField('goods_id',true);
                !empty($goods)   &&  $map['a.goods_id'] = ['not in',$goods];
            }
            $merchants_id = I('merchants_id');
            !empty($merchants_id)    &&  $map['a.merchants_id'] = $merchants_id;
            $map['a.is_delete'] = '0';
            $map['a.goods_state'] = 1;
            $map['a.is_review'] = 1;

            $map['b.open'] = 1;
            $map['b.apply_state'] = 2;
            $map['b.is_delete'] = 0;

//            $map['is_tuijian'] = 1;
            $goods = M('shop_goods')->alias('a')
                ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
                ->field("a.goods_id,a.goods_name,a.goods_img,a.goods_origin_price,a.goods_pc_price,a.goods_now_price,a.total_sales,a.month_sales,a.day_sales")
                ->where($map)->order('rand()')
                ->order("a.is_tuijian desc")
                ->limit($pagesize)
                ->select();
            success($goods);
        }
    }

    /**
     *删除购物车
     */
    public function delShopCar(){
        if (IS_POST) {
            $member = checklogin();
            $car_ids = I('car_ids');
            if (!$car_ids) error("要删除的购物车商品为空");
            $car_ids = explode(',', $car_ids);
            if (empty($car_ids)) error("要删除的购物车商品为空");
            $where['car_id'] = ['in', $car_ids];
            $where['member_id'] = $member['user_id'];
            $result = M('shop_goods_shop_car')->where($where)->delete();
            if ($result) {
                success("删除商品购物车成功");
            } else {
                error("删除商品购物车失败");
            }
        }
    }
    /**
     *清空无效商品
     */
    public function delInvalidShopCar(){
        if (IS_POST) {
            $member = checklogin();
            $where['member_id'] = $member['user_id'];
            $where['is_valid'] = '2';
            $result = M('shop_goods_shop_car')->where($where)->delete();
            if ($result) {
                success("清空无效商品成功");
            } else {
                error("清空无效商品失败");
            }
        }
    }

    /**
     *商品数量加1
     */
    public function plusShopCar(){
        if (IS_POST) {
            $member = checklogin();
            $car_id = I('car_id');
            if (!$car_id) error("购物车ID错误");
            $check = M('shop_goods_shop_car')->where(['car_id' => $car_id, 'member_id' => $member['user_id']])->find();
            if (!$check) error("购物车ID错误");
            if (!empty($check['specification_id'])) {
                $specification = M('shop_goods_relation_specification')->where(['specification_id' => $check['specification_id']])->find();
                if ($specification['specification_stock'] > $check['goods_num']) {
                    $result = M('shop_goods_shop_car')->where(['car_id' => $check['car_id']])->setInc('goods_num');
                } else {
                    error("商品库存不足");
                }
            } else {
                $goods = M('shop_goods')->where(['goods_id' => $check['goods_id']])->find();
                if ($goods['goods_stock'] > $check['goods_num']) {
                    $result = M('shop_goods_shop_car')->where(['car_id' => $check['car_id']])->setInc('goods_num');
                } else {
                    error("商品库存不足");
                }
            }
            if ($result) {
                success("添加商品数量成功");
            } else {
                error("添加商品数量失败");
            }
        }
    }

    public function minusShopCar(){
        if (IS_POST) {
            $member = checklogin();
            $car_id = I('car_id');
            if (!$car_id) error("购物车ID错误");
            $check = M('shop_goods_shop_car')->where(['car_id' => $car_id, 'member_id' => $member['user_id']])->find();
            if (!$check) error("购物车ID错误");
            if ($check['goods_num'] > 1) {
                $result = M('shop_goods_shop_car')->where(['car_id' => $check['car_id']])->setDec('goods_num');
            } else {
                error("数量不能再少了");
            }
            if ($result) {
                success("减少商品数量成功");
            } else {
                error("减少商品数量失败");
            }
        }

    }

    //父级分类
    public function parent_class(){
        $map['parent_id'] = '-1';
        $map['is_delete'] = '0';
        $list = M('shop_goods_class')->field('class_id,class_name,class_desc,class_img,class_color,class_uuid,template_img')
            ->where($map)->order("sort desc")->select();
        success($list);
    }

    //子级分类
    public function seed_class(){
        $class_uuid = I('class_uuid');
        if(!$class_uuid)        error("参数错误");
        $parent = M('shop_goods_class')->where(['class_uuid'=>$class_uuid])->find();
        if(!$parent)            error("参数错误");
        $map['parent_id'] = $parent['class_id'];
        $map['is_delete'] = '0';
        $list = M('shop_goods_class')->field('class_id,class_name,class_desc,class_img,class_color,class_uuid,template_img')
            ->where($map)->order("sort desc")->select();
        success($list);
    }

    /**
     * @查询总仓列表
     */
    public function warehouse(){
        $where = [];
        $keywords = I('keywords');
        if($keywords){
            $where['merchants_name'] = ['like','%'.$keywords.'%'];
        }
        $where['is_all'] = 1;
        $where['open'] = 1;
        $where['apply_state'] = 2;
        $where['is_delete'] = 0;

        $list = M('shop_merchants')
                ->where($where)
                ->field('merchants_id,member_id,merchants_name,merchants_img,merchants_province,merchants_city,merchants_country,merchants_address,merchants_content')
                ->order('create_time desc')
                ->select();
        if(!$list){
            $list = [];
        }
        success($list);


    }


}