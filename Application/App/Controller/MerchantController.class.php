<?php
namespace App\Controller;
use Think\Controller;
use Think\Upload;

class MerchantController extends CommonController{
    /**
     * 商户申请上传资料
     * @param  legal_face_img [身份证正面照]
     * @param  legal_opposite_img [身份证反面照]
     * @param  merchants_name [店铺名称]
     * @param  contact_mobile [联系方式]
     */
    public function sub_new(){
        $user = checklogin();
        //资料审核状态判断
        $apply_state= M("shop_merchants")->where(array('member_id'=>$user["user_id"]))->getField("apply_state");

        switch ($apply_state){
            case "1":
                error("资料审核中无法进行修改");
                break;
            case "2":
                error("资料审核已通过，如需修改请联系商家");
            break;
        }
        if($apply_state==3){
            M("shop_merchants")->where(array('member_id'=>$user["user_id"]))->delete();
        }

        
        //用户信息验证
        $params = $_POST;

        $rules = array(
            array('contact_mobile','','手机号已被使用',0,'unique',1), // 在新增的时候验证字段是否唯一 
            array('merchants_name','','店铺名称已被使用',0,'unique',1), 
            array('legal_face_img','require','请上传身份证正面照'), 
            array('legal_opposite_img','require','请上传身份证反面照'), 

        );

        $merchant = M("shop_merchants"); // 实例化User对象
        if (!$merchant->validate($rules)->create($params)){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            error($merchant->getError());
        }else{
             // 验证通过 可以进行其他数据操作
            /**********************增加用户初始密码*************************/
            if(!$user['pwd']){
                $user['pwd'] = md5('123456');
                M('user')->where(['user_id'=>$user["user_id"]])->save(['pwd'=>$user['pwd']]);
            }
            /**********************增加用户初始密码*************************/
            //证件验证
            $params["apply_state"] = 1;
            $params["member_id"] = $user["user_id"];
            $params["create_time"] = date("Y-m-d H:i:s");
            unset($params["uid"]);
            unset($params["token"]);
            $model = D('Merchants');
            if(!empty($params["business_img"])){
                $re = $model->edit_merchants($params);
                if($re){
                    success("提交成功，请等待审核");
                }else{
                    error("提交失败，请核对信息");
                }
            }else{
                if($params["legal_face_img"] && $params["legal_opposite_img"]){
                    $re = $model->edit_merchants($params);
                    if($re){
                        success("提交成功，请等待审核");
                    }else{
                        error("提交失败，请核对信息");
                    }
                }else{
                    error("提交失败，请核对信息");
                }
            } 
        }
    }


    /**
     * 提交申请资料
     * @param
     * @param legal_img ; //法人照片
     * @param legal_hand_img; //手持身份证照
     * @param  legal_face_img //身份证正面
     * @params legal_opposite_img; //身份证反面
     */
    /**
     *用户提交信息验证
     */
    public function  message_authentication(){
        $user = checklogin();
        //用户信息验证
        $params = I('param.'); 
        $rules = array(
            array('contact_name','require','请输入身份证上的姓名'), 
            array('contact_mobile','','手机号已被使用',0,'unique',1), // 在新增的时候验证字段是否唯一 
            array('business_number','','营业执照号已经被使用',0,'unique',1), 
            array('merchants_name','','店铺名称已被使用',0,'unique',1), 
            array('merchants_province','require','省份不能为空'), 
            array('merchants_city','require','城市不能为空'), 
            array('merchants_country','require','区县不能为空'), 
            array('merchants_address','require','请输入店铺详细地址'), 

        );

        $merchant = M("shop_merchants"); // 实例化User对象
        if (!$merchant->validate($rules)->create($params)){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            error($merchant->getError());
        }else{
             // 验证通过 可以进行其他数据操作
            success("验证成功");
        }

    }

    /**
     * 提交用户信息
     */
    public function  sub_material(){
        $user = checklogin();
        //资料审核状态判断
        $apply_state= M("shop_merchants")->where(array('member_id'=>$user["user_id"]))->getField("apply_state");

        switch ($apply_state){
            case "1":
                error("资料审核中无法进行修改");
                break;
            case "2":
                error("资料审核已通过，如需修改请联系商家");
            break;
        }
        if($apply_state==3){
            M("shop_merchants")->where(array('member_id'=>$user["user_id"]))->delete();
        }
        //用户信息验证
        $params = I('param.');

        $rules = array(
            array('contact_name','require','请输入身份证上的姓名'), 
            array('contact_mobile','','手机号已被使用',0,'unique',1), // 在新增的时候验证字段是否唯一 
            array('business_number','','营业执照号已经被使用',0,'unique',1), 
            array('merchants_name','','店铺名称已被使用',0,'unique',1), 
            array('merchants_province','require','省份不能为空'), 
            array('merchants_city','require','城市不能为空'), 
            array('merchants_country','require','区县不能为空'), 
            array('merchants_address','require','请输入店铺详细地址'), 

        );

        $merchant = M("shop_merchants"); // 实例化User对象
        if (!$merchant->validate($rules)->create($params)){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            error($merchant->getError());
        }else{
             // 验证通过 可以进行其他数据操作
            /**********************增加用户初始密码*************************/
            if(!$user['pwd']){
                $user['pwd'] = md5('123456');
                M('user')->where(['user_id'=>$user["user_id"]])->save(['pwd'=>$user['pwd']]);
            }
            /**********************增加用户初始密码*************************/
            //证件验证
            $params["apply_state"] = 1;
            $params["member_id"] = $user["user_id"];
            $params["create_time"] = date("Y-m-d H:i:s");
            unset($params["uid"]);
            unset($params["token"]);
            $model = D('Merchants');
            if(!empty($params["business_img"])){
                $params["business_img"];
                $re = $model->edit_merchants($params);
                if($re){
                    success("提交成功，请等待审核");
                }else{
                    error("提交失败，请核对信息");
                }
            }else{
                if($params["legal_img"] && $params["legal_hand_img"] && $params["legal_face_img"] && $params["legal_opposite_img"]){
                    $re = $model->edit_merchants($params);
                    if($re){
                        success("提交成功，请等待审核");
                    }else{
                        error("提交失败，请核对信息");
                    }
                }else{
                    error("提交失败，请核对信息");
                }
            }
        }
        
    }

    /**
     *获取提交信息
     */
    public function  material_info(){
        $user = checklogin();
        $list = M("shop_merchants")->where(array('member_id'=>$user["user_id"]))
                                ->getField('member_id,business_number,merchants_id,merchants_name,contact_name,contact_mobile,merchants_address,business_img,legal_img,legal_hand_img,legal_face_img,legal_opposite_img,apply_state,pay_state');

        //押金支付信息
        $deposit = M("system")->where(array('id'=>1))->getField("deposit");
        $data = $list[$user["user_id"]];
        $data["deposit"] = $deposit;
        success($data);
    }

    /**
     *
     * 获取商家信息
     * 
     */
    public function get_merchant(){
       $user = checklogin();
       $list = M("shop_merchants")->where(array('member_id'=>$user["user_id"]))
               ->find();
       if($list){
           //押金支付信息
            $deposit = M("system")->where(array('id'=>1))->getField("deposit");
            $data = $list;
            $data["deposit"] = $deposit;
            success($data);
       }else{
            error('无商家信息');
       }
       

    }

    /**
     * 上传证件
     */
    public function upload(){
        $up = new \Think\Upload();// 实例化上传类
        $up->upload("Documen");
    }
    /**
     * 经营分类
     */
    public function operate_class(){
        $user = checklogin();
        $params = I('param.');
        //全部分类
        $data = ["class_state"=>1,'is_delete'=>0];
        $all_list = M("shop_goods_class")->field("class_name,class_id")->where($data)->select();
        if(!empty($params["operate_class"])){
            //修改商户经营分类
            $update["class_id"]=$params['operate_class'];
            $update['intime'] = date("Y-m-d H:i:s", time());
            if(M("shop_goods_merchants_class")->where(array('member_id'=>$user["user_id"]))->find()){
                $res = M("shop_goods_merchants_class")->where(array('member_id'=>$user["user_id"]))->save($update);
            }else{
                $update["member_id"]=$user["user_id"];
                $res = M("shop_goods_merchants_class")->where(array('member_id'=>$user["user_id"]))->add($update);
            }
            if(!$res){
                error("修改分类失败，请重新尝试修改");
            }
        }
        //商家选择已选的分类
        $class_id = M("shop_goods_merchants_class")->where(array('member_id'=>$user["user_id"]))->getField('class_id');
        $class_array = explode(",",$class_id);
        foreach ($all_list as $k=>$v){
            if(in_array($v["class_id"],$class_array)){
                $all_list[$k]["type"] = 1;
            }else{
                $all_list[$k]["type"] = 2;
            }
        }
        //$oper_list = DB::name("goods_class")->field("class_name,class_id")->where('class_id','in',$class_id)->select();
        success($all_list);
    }
    /**
     *清除已选经营分类
     */
    public function clean_class(){
        $user = checklogin();
        $re = M("shop_goods_merchants_class")->where(array('member_id'=>$user["user_id"]))->save(["class_id"=>0]);
        if($re){
            success("经营分类已清除完，建议您重新选择");
        }else{
            error("经营分类清除失败,请重新新尝试清除");
        }
    }
    /**
     * 商户入驻协议
     */
    public function agreement(){
        $id = I("id");
        $data = ["id"=>$id,'is_del'=>1];
        $content = M("shop_notice")->where($data)->getField('content');
        $content = htmlspecialchars_decode($content);
        $this->assign(['content'=>$content]);
        $this->display();
    }

    public function ajax_agreement(){
        $id = I("id");
        $data = ['id'=>$id,'is_del'=>1];
        $content = M("shop_notice")->where($data)->getField('content');
       $content = htmlspecialchars_decode($content);
        success($content);
    }

    /**
     *商户商品分类
     */
    public function merchants_class()
    {
        if (IS_POST) {
            $member = checklogin();
            $array[] = ['class_id'=>'','class_name'=>'全部','class_uuid'=>''];
            $merchants_id = $member['user_id'];//商家商户id
            if (!$merchants_id) error("商户店铺id不能为空");
            $list = M('shop_goods_merchants_class')->alias('a')
                ->field('b.class_id,b.class_name,b.class_uuid')
                ->join('m_shop_goods_class b ON FIND_IN_SET(b.class_id,a.class_id)')
                ->where(['a.member_id' => $merchants_id, 'b.is_delete' => 0])
                ->select();
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
     *商户分类商品
     */
    public function merchants_class_goods()
    {
        if (IS_POST) {
            // $member = checklogin();
            // $merchants_id = $member['user_id'];//商家商户id
            $name = I('name');
            $merchants_id = I('merchants_id');//商家商户id
            // if($name){

            // }else{
            //     if (!$merchants_id) error("商户店铺id不能为空");
            //     $where['a.merchants_id'] = ["in",$merchants_id];
            // }
            $p = I('p');
            empty($p) && $p = 1;
            $pageSize = I('pagesize');
            $pageSize ? $pageSize : $pageSize = 10;
            if(!$name){
                $class_uuid = I('class_uuid');
            }
            if ($class_uuid){
                $class = M('shop_goods_class')->where(['class_uuid' => $class_uuid])->find();
                if (!$class) error("商户分类id错误");
                $where['a.parent_class|a.seed_class'] = $class['class_id'];
            }
//            $where['b.merchants_id'] = $merchants_id;
            $where['a.is_delete'] = '0';
            $where['a.goods_state'] = '1';
            $where['a.is_review'] = '1';

            $name && $where['a.goods_name'] = ['like', '%' . $name . '%'];

            $where['b.open'] = 1;
            $where['b.apply_state'] = 2;
            $where['b.is_delete'] = 0;

            // $merchants_ids = M('shop_merchants')->where(array('apply_state'=>2, 'is_delete'=>0, 'is_all'=>1))->getField('member_id',true); 
            // array_push($merchants_ids,$merchants_id);
            // print_r($merchants_ids);exit;


            // $where['merchants_id'] = ["in",$merchants_ids];
            // $where['merchants_id'] = ["in",$merchants_id];
            $list = M('shop_goods')->alias('a')
                ->join('m_shop_merchants b ON a.merchants_id=b.member_id')
                ->field('a.goods_id,a.goods_name,a.goods_img,a.goods_origin_price,a.goods_pc_price,a.goods_now_price,a.goods_per,b.merchants_name,b.merchants_img')
                ->where($where)->order('a.important desc,a.is_tuijian desc,a.sort desc,a.create_time asc')
                ->limit(($p-1)*$pageSize,$pageSize)
                ->select();
            if($list){
                foreach ($list as $k => &$v) {
                    $v['is_all'] = warehouse($v['goods_id']);
                    $v['goods_per'] = $v['goods_per'].'%';
                    $v['price_per'] = sprintf('%.2f',($v['goods_per']/100) * $v['goods_now_price']);
                }
            }else{
                $list = [];
            }
            
            $count = M('shop_goods')->alias('a')
                ->join('m_shop_merchants b ON a.merchants_id=b.member_id')->where($where)->count();
            $page = ceil($count / $pageSize);
            return success(['page' => $page, 'list' => $list]);
        }
    }

    /**
     *直播商品
     */
    public function live_goods(){
        $member = checklogin();
        $live_id = I('live_id');

        $trends_id = I('trends_id');

        $a_id = I('a_id');

        if($live_id) {
            // error("直播错误");
            $list = M('shop_live_goods')->alias('a')
                ->field('a.live_goods_id,a.is_top,b.goods_id,b.goods_name,b.goods_img,b.goods_origin_price,b.goods_pc_price,b.goods_now_price')
                ->join('m_shop_goods b ON a.goods_id = b.goods_id')
                ->where(['a.live_id'=>$live_id,'a.is_delete'=>'0','b.is_delete'=>'0','b.goods_state'=>'1'])
                ->order("a.is_top desc")
                ->select();
            foreach ($list as $k => &$v) {
                $v['is_all'] = warehouse($v['goods_id']);
            }
        }else if($trends_id){
            $list = M('shop_live_goods')->alias('a')
                ->field('a.member_id,a.live_goods_id,a.is_top,b.goods_id,b.goods_name,b.goods_img,b.goods_origin_price,b.goods_pc_price,b.goods_now_price')
                ->join('m_shop_goods b ON a.goods_id = b.goods_id')
                ->where(['a.trends_id'=>$trends_id,'a.is_delete'=>'0','b.is_delete'=>'0','b.goods_state'=>'1'])
                ->order("a.is_top desc")
                ->select();
            foreach ($list as $k => &$v) {
                $v['is_all'] = warehouse($v['goods_id']);
            }
        }else if($a_id){
            $list = M('shop_live_goods')->alias('a')
                ->field('a.member_id,a.live_goods_id,a.is_top,b.goods_id,b.goods_name,b.goods_img,b.goods_origin_price,b.goods_pc_price,b.goods_now_price,a.a_id')
                ->join('m_shop_goods b ON a.goods_id = b.goods_id')
                ->where(['a.a_id'=>$a_id,'a.is_delete'=>'0','b.is_delete'=>'0','b.goods_state'=>'1'])
                ->order("a.is_top desc")
                ->select();
        // echo M()->getLastSql();
                
            foreach ($list as $k => &$v) {
                $v['is_all'] = warehouse($v['goods_id']);
            }
        }else{
            error("直播错误");
        }      
        success($list);
    }

    /**
     *商品置顶与取消
     */
    public function operateGoodsTop(){
        $member = checklogin();
        $live_goods_id = I('live_goods_id');
        $check = M('shop_live_goods')->where(['live_goods_id'=>$live_goods_id,'member_id'=>$member['user_id']])->find();
        if(!$check)         error("商品错误");
        if($check['is_top'] == '0'){
            $is_top = '1';
        }else{
            $is_top = '0';
        }
        $result = M('shop_live_goods')->where(['live_goods_id'=>$live_goods_id])->save(['is_top'=>$is_top]);
        if($result){
            if($is_top == '1'){
                M('shop_live_goods')->where(['live_id'=>$check['live_id'],'live_goods_id'=>['neq',$live_goods_id]])->save(['is_top'=>'0']);
            }
            success("操作成功");
        }else{
            error("操作失败");
        }
    }
    public function delGoods(){
        $member = checklogin();
        $live_goods_id = I('live_goods_id');
        $result = M('shop_live_goods')->where(['live_goods_id'=>$live_goods_id,'member_id'=>$member['user_id']])->save(['is_delete'=>'1']);
        if($result){
            success("操作成功");
        }else{
            error("操作失败");
        }
    }
    public function delAllGoods(){
        $member = checklogin();
        $live_id = I('live_id');

        $trends_id = I('trends_id');

        if($live_id){
           $result = M('shop_live_goods')->where(['live_id'=>$live_id,'member_id'=>$member['user_id']])->save(['is_delete'=>'1']); 
       }else if($trends_id){
           $result = M('shop_live_goods')->where(['trends_id'=>$trends_id,'member_id'=>$member['user_id']])->save(['is_delete'=>'1']);
       }
        
        if($result){
            success("操作成功");
        }else{
            error("操作失败");
        }
    }

    /**
     * @生成商家二维码
     * 测试
     */
    public function buildCode(){
        $url = 'http://tp3shoplive.zhongfeigou.com/';
        // $merchants_id = I('merchants_id');
        // $img = M('shop_merchants')->where(['merchants_id'=>$merchants_id])->getField('merchants_img');
        Vendor('phpqrcode.phpqrcode');
        \Qrcode::png($url,'456.jpg',500,500,true);
        success($url.'456.jpg');


    }





}