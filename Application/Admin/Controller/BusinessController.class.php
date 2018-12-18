<?php
namespace  Admin\Controller;
/**
 * 电商
 * @Business 
 *
 */
use Think\Db;
use Psr\Log\Test\DummyTest;

use Org\Util\Date;
use Think\Upload;
use Think\Controller;

use Qcloud\Sms\SmsSingleSender;
use Qcloud\Sms\SmsMultiSender;

class BusinessController extends CommonController {
    function _initialize() {
        header("Content-Type:text/html; charset=utf-8");
        $nums = ['5','10','15','20','25','30','50','100'];
        $this->assign('nums',$nums);
    }
    /**
     * @获取市,区
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

    /**
     * @添加（修改）验证手机号
     */
    public function yzmobile(){
        $id = I('id');
        $mobile = I('mobile');
        // $uid = I('uid');
        // $master_id = I('master_id');
        if ($id=='') {
            $me = M('User')->where(array('phone'=>$mobile))->find();
            //echo $me ? 1 : 2;
            // if (!empty($uid)){
            //     $user = M('User')->where(['ID'=>$uid])->find();
            // }
            // if (!empty($master_id)){
            //     $user2 = M('User')->where(['ID'=>$master_id])->find();
            // }
            if ($me){
                echo 1;
            }
            //  elseif ($user){
            //     echo 2;
            // }elseif (!empty($master_id) && !$user2){
            //     echo 4;
            // }
            else{
                echo 3;
            }
        }else {
            $mobile_ok = M('User')->where(array('user_id'=>$id))->getField('phone');
            $usid = M('User')->where(array('user_id'=>$id))->getField('ID');
            if ($mobile!=$mobile_ok){
                $me = M('User')->where(array('phone'=>$mobile))->find();
                if ($me){
                    $rs = "1";
                }else{
                    $rs = "3";
                }
            }
            // elseif ($usid!=$uid){
            //     $user = M('User')->where(['ID'=>$uid])->find();
            //     if ($user){
            //         $rs = "2";
            //     }else{
            //         $rs = "3";
            //     }
            // }elseif (!empty($master_id) && $usid!=$master_id){
            //     $user2 = M('User')->where(['ID'=>$master_id])->find();
            //     if (!$user2){
            //         $rs = "4";
            //     }else{
            //         $rs = "3";
            //     }
            // }
            echo $rs;
        }
    }


    public function seller(){
        if( !M()->autoCheckToken($_POST) ) $this->error('禁止站外提交！');
        unset($_POST['__hash__']);
    	$map=[];
        !empty($_GET['name']) && $map['phone|merchants_name|contact_mobile|contact_name'] = ['like','%'.I('name').'%'];
        $map['a.is_delete'] = 0;
        $map["a.apply_state"] = 2;
        $map["b.type"] = 2;
        $map['b.is_del'] = 1;

        $is_all = $_GET['is_all'];
        if ($is_all !== FALSE && $is_all !== "" && $is_all !== null){
            $map['is_all'] = $is_all;
            $this->assign('is_all',$is_all);
        }

        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);

        $count = M("shop_merchants")
                ->alias('a')
                ->join('__USER__ b ON a.member_id = b.user_id')
                ->where($map)
                ->count();
        $p = getpage($count,$nus);
        $this->assign("count",$count);
        $list = M("shop_merchants")->alias("a")
                ->field("a.create_time,a.dashang_scale,a.sell_scale,a.tv_sell_scale,a.spread_scale,a.merchants_id,a.merchants_name,a.merchants_img,a.contact_name,a.create_time,a.update_time,a.contact_mobile,a.member_id,b.phone,b.img,a.apply_state,a.pay_state,a.is_all,a.open")
                ->join('__USER__ b ON a.member_id = b.user_id')
                ->where($map)
                ->order('a.create_time desc')
                ->limit($p->firstRow.','.$p->listRows)
                ->select();
        // $list->toArray();
        foreach ($list as $k=>$v){
            $data = array();
            $data = $v;
            $data['merchant_scale'] = 100 - $v['sell_scale']- $v['tv_sell_scale'] - $v['spread_scale'];
            // $list->offsetSet($k,$data);
        }
        $url =$_SERVER['REQUEST_URI'];
        session('url',$url);
        $this->assign("list",$list);
        $this->assign("show",$p->show());
        $this->assign ('pagetitle', '商家列表' );

    	$this->display();
    }



    public function toadd_seller(){
        if( !M()->autoCheckToken($_POST) ) $this->error('禁止站外提交！');
        unset($_POST['__hash__']);

        if(IS_POST){
            //添加或编辑
            $id = I('id');
            if ($id){//编辑
                $user = M('shop_merchants')->find($id);
                $fid = M('Areas')->where(array('name' => $user['province'], 'level' => 1))->getField('id');
                if ($fid) {
                    $data['fid'] = $fid;
                    $data['level'] = 2;
                    $user['shi'] = M('Areas')->where($data)->select();  //市
                } else {
                    $user['shi'] = null;
                }
                $fid2 = M('Areas')->where(array('name' => $user['city'], 'level' => 2))->getField('id');
                if ($fid2) {
                    $date['fid'] = $fid2;
                    $date['level'] = 3;
                    $user['qu'] = M('Areas')->where($date)->select();  //区
                } else {
                    $user['qu'] = null;
                }
                $user['city_id'] = M('Areas')->where(array('name' => $user['city'], 'level' => 2))->getField('id');
                $user['area_id'] = M('Areas')->where(array('name' => $user['area'], 'level' => 3))->getField('id');
                $user['master_id'] = M('User')->where(['user_id'=>M('User_master')->where(['user_id'=>$id])->getField('master_id')])->getField('ID');
                $this->assign('u',$user);
                $sta = '编辑';
            }else{
                //添加
                $params = $_POST;
                //商品分类
                $params["goods_class"] = implode(',',$params["goods_class"]);
                $sheng = I('sheng');
                $shi = I('shi');
                $qu = I('qu');
                $params['merchants_province'] = M('Areas')->where(array('id' => $sheng))->getField('name');
                $params['merchants_city'] = M('Areas')->where(array('id' => $shi))->getField('name');
                $params['merchants_country'] = M('Areas')->where(array('id' => $qu))->getField('name');
                $params['merchants_province'] ? $params['merchants_province'] : $params['merchants_province'] = '';
                $params['merchants_city'] ? $params['merchants_city'] : $params['merchants_city'] = '';
                $params['merchants_country'] ? $params['merchants_country'] : $params['merchants_country'] = '';

                $merchants["merchants_per"] = $params['merchants_per'];
                $merchants["goods_per"] = $params['goods_per'];
                
                $merchants = D("Merchants");
                $result = $merchants ->add_merchants($params);

                if($result == 'success'){
                    $res = $this->sendSMS($params['contact_mobile'],6);
                    if($res['status'] == 'error'){
                        $this->error($res['msg']);
                    }
                    $this->success('成功!',U('seller'));
                }else{
                    $this->error('失败!',U('seller'));
                }

            }
        }else{
            $sheng = M('Areas')->where(['level'=>1])->select();
            $re = array();
            $re['province']  = '';
            $re['shi'] = '';
            $re['qu']  = '';

            //查询默认分成比
                $per = M('system')->where(array('id'=>1))->field('merchants_per,goods_per')->find();
                $this->assign('per',$per);
            //获取主播直播标签
            // $list= M("shop_live_class")->where(array('is_del'=>1))->order("sort desc")->select();
            //商户商品分类
            $goods_class = M("shop_goods_class")->where(["parent_id"=>-1,"is_delete"=>0])->select();
            // $this->assign('class',$list);
            $this->assign("parent_class",$goods_class);
            $this->assign(['sheng'=>$sheng,'re'=>$re]);

            $sta = '添加';
            $this->assign ( 'pagetitle', $sta );
            $this->display();
        }
        
    }

    public function update_seller(){
        $params = I('param.');
        $member_id = $params["id"];
        if(IS_POST){
            // print_r($params);exit;
            $merchants_id = M("shop_merchants")->where(["member_id"=>$member_id])->getField("merchants_id");
            // $params["live_tag"] = implode(',',$params["tag"]);
            $params["class_id"] = implode(',',$params["goods_class"]);
            $merchants["company_name"] = empty($params["company_name"]) ? true : $params["company_name"];
            $merchants["contact_name"] = empty($params["contact_name"]) ? true : $params["contact_name"];
            $merchants["company_mobile"] = empty($params["company_mobile"]) ? true : $params["company_mobile"];
            $merchants["contact_mobile"] = empty($params["contact_mobile"]) ? true : $params["contact_mobile"];
            $merchants["merchants_address"] = empty($params["merchants_address"]) ? true : $params["merchants_address"];
            $merchants["merchants_img"] = empty($params["merchants_imgs"]) ? true : domain($params['merchants_imgs']);
            $merchants["legal_face_img"] = empty($params["legal_face_img"]) ? true : domain($params['legal_face_img']);
            $merchants["legal_hand_img"] = empty($params["legal_hand_img"]) ? true : domain($params['legal_hand_img']);
            $merchants["business_img"] = empty($params["business_img"]) ? true : domain($params['business_img']);
            $merchants["legal_img"] = empty($params["legal_img"]) ? true : domain($params['legal_img']);
            $merchants["legal_opposite_img"] = empty($params["legal_opposite_img"]) ? true : domain($params['legal_opposite_img']);
            $merchants["merchants_content"] = empty($params["merchants_content"]) ? true : $params["merchants_content"];
            // $merchants["dashang_scale"] = empty($params["dashang_scale"]) ? true : $params["dashang_scale"];
            // $merchants["sell_scale"] = empty($params["sell_scale"]) ? true : $params["sell_scale"];
            $merchants["update_time"] = date("Y-m-d H:i:s");

            $merchants["is_all"] = $params['is_all'];
            $merchants["merchants_per"] = $params['merchants_per'];
            $merchants["goods_per"] = $params['goods_per'];
            $merchants["merchants_name"] = $params['merchants_name'];

            $sheng = I('sheng');
            $shi = I('shi');
            $qu = I('qu');
            $merchants['merchants_province'] = M('Areas')->where(array('id' => $sheng))->getField('name');
            $merchants['merchants_city'] = M('Areas')->where(array('id' => $shi))->getField('name');
            $merchants['merchants_country'] = M('Areas')->where(array('id' => $qu))->getField('name');
            $merchants['merchants_province'] ? $merchants['merchants_province'] : $merchants['merchants_province'] = '';
            $merchants['merchants_city'] ? $merchants['merchants_city'] : $merchants['merchants_city'] = '';
            $merchants['merchants_country'] ? $merchants['merchants_country'] : $merchants['merchants_country'] = '';
            $up_merchants = M("shop_merchants")->where(["merchants_id"=>$merchants_id])->save($merchants);
            // $member["live_tag"] = empty($params["live_tag"]) ? true : $params["live_tag"];
            $member["uptime"] = time();
            $up_member = M("user")->where(["user_id"=>$member_id])->save($member);

            $class["class_id"] = empty($params["class_id"]) ? true : $params["class_id"];

            $class["intime"] = date("Y-m-d H:i:s");
            if(M('shop_goods_merchants_class')->where(["member_id"=>$member_id])->find() && isset($params["class_id"])){
                $upclass = M("shop_goods_merchants_class")->where(["member_id"=>$member_id])->save($class);
            }else{
                $addClass= array();
                $addClass['member_id'] = $member_id;
                $addClass['intime'] = date("Y-m-d H:i:s");
                $addClass['class_id'] = $class["class_id"];
                $upclass = M("shop_goods_merchants_class")->add($addClass);
            }


            if($up_merchants || $up_member || $upclass){
                // return success(['info'=>'资料编辑成功']);
                $this->success('编辑成功!',U('seller'));
            }else{
                // return error(['info'=>'无任何操作']);
                $this->error('无任何操作!',U('seller'));

            }
        }else{
            $map["a.member_id"] = $params["mid"];
            $res = M("shop_merchants")->alias("a")
                ->field('a.*,b.username,b.phone,c.class_id')
                ->join("__USER__ b ON a.member_id=b.user_id")
                ->join("m_shop_goods_merchants_class c ON a.member_id = c.member_id","left")
                ->where($map)
                ->find();

            $sheng = M('Areas')->where(array('level'=>1))->select();
            $this->assign('sheng', $sheng);
            if (!empty($res)) {
                $fid = M('Areas')->where(array('name' => $res['merchants_province'], 'level' => 1))->getField('id');
                if ($fid) {
                    $data['pid'] = $fid;
                    $data['level'] = 2;
                    $res['shi'] = M('Areas')->where($data)->select();  //市
                } else {
                    $res['shi'] = null;
                }
                $fid2 = M('Areas')->where(array('name' => $res['merchants_city'], 'level' => 2))->getField('id');
                if ($fid2) {
                    $date['pid'] = $fid2;
                    $date['level'] = 3;
                    $res['qu'] = M('Areas')->where($date)->select();  //区
                } else {
                    $res['qu'] = null;
                }
                $res['city_id'] = M('Areas')->where(array('name' => $res['merchants_city'], 'level' => 2))->getField('id');
                $res['area_id'] = M('Areas')->where(array('name' => $res['merchants_country'], 'level' => 3))->getField('id');
            }
            // if(!$res['sell_scale'])         $res['sell_scale'] = $this->system['sell_scale'];
            // if(!$res['dashang_scale'])      $res['dashang_scale'] = $this->system['dashang_scale'];
            //获取主播直播标签
            // $class= DB::name("live_class")->field("live_class_id,tag")->where("is_del",1)->order("sort desc")->select();
            // $live_tag = explode(',',$res["live_tag"]);
            // foreach ($class as $k=>$v){
            //     if(in_array($v["live_class_id"],$live_tag)){
            //         $class[$k]["is_selected"] = 1;
            //     }else{
            //         $class[$k]["is_selected"] = 0;
            //     }
            // }
            // if($res['tv_id']){
            //     $res['tv'] = Db::name('television')->where(['tv_id'=>$res['tv_id']])->value('username');
            // }else{
            //     $res['tv'] = '归属总平台';
            // }
            //商户商品分类
            $goods_class = M("shop_goods_class")->where(["parent_id"=>-1,"is_delete"=>0])->order("sort desc")->select();
            $goods_tag = explode(',',$res["class_id"]);
            foreach ($goods_class as $k=>$v){
                if(in_array($v["class_id"],$goods_tag)){
                    $goods_class[$k]["is_selected"] = 1;
                }else{
                    $goods_class[$k]["is_selected"] = 0;
                }
            }
            $this->assign("class",$class);
            $this->assign('parent_class',$goods_class);
            $this->assign("re",$res);
            $this->display();
            
        }

    }


    /**
     * @申请商户列表
     */
    public function apply_list(){
        $map=[];
        !empty($_GET['name']) && $map['phone|merchants_name|contact_mobile|contact_name'] = ['like','%'.I('name').'%'];
        $map['a.is_delete'] = 0;
        $map["a.apply_state"] = ["not in",['0','2']];

        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);

        $count = M("shop_merchants")
            ->alias('a')
            ->join('__USER__ b ON a.member_id = b.user_id')
            ->where($map)
            ->count();
        $p = getpage($count,$nus);
        
        $list = M("shop_merchants")
            ->alias("a")
            ->field("a.create_time,a.merchants_id,a.merchants_name,a.merchants_img,a.contact_name,a.create_time,a.update_time,a.contact_mobile,a.member_id,b.phone,b.username,b.img,a.apply_state,a.pay_state")
            ->join('__USER__ b ON a.member_id = b.user_id')
            ->where($map)
            ->order('a.create_time desc')
            ->limit($p->firstRow.','.$p->listRows)
            ->select();
        foreach ($list as $k => &$v) {
            $v['img'] = domain($v['img']);
        }

        $url =$_SERVER['REQUEST_URI'];
        session('url',$url);
        $this->assign("list",$list);
        $this->assign("show",$p->show());
        $this->assign ('pagetitle', '申请商家列表' );

        $this->display();
    }

    /**
     * @删除商户
     */
    public function del_merchants(){
        $id = I('ids');
        $data['merchants_id'] = ['in',$id];
        $user = M('shop_merchants')->where($data)->save(['is_delete'=>1]);
        $member_ids = M('shop_merchants')->where($data)->getField('member_id',true);
        if($user){
            M('user')->where(['user_id'=>['in',$member_ids]])->save(['type'=>'1']);
            M('shop_goods')->where(['merchants_id'=>['in',$member_ids]])->save(['goods_state'=>'2','is_tuijian'=>'0']);
            // echo json_encode(['status'=>"ok",'info'=>'删除记录成功!','url'=>session('url')]);
            echo 1;
        }else{
            // echo json_encode(['status'=>"error",'info'=>'删除记录失败!']);
            echo 2;
        }
    }

    /**
     * @审核商户
     */
    public function edit_merchants(){
        $id = I('mid');
        if(IS_POST){
            $params = I('param.');
            $apply_state = $params["apply_state"];
            $update = date("Y-m-d h:i:s");
            $map["apply_state"]=$apply_state;
            $map["update_time"]=$update;
            if($apply_state==2){
                M("user")->where(array('user_id'=>$params['id']))->save(["type"=>2]);
                $user = M("user")->where(array('user_id'=>$params['id']))->field('phone,pwd')->find();
                if(!$user['pwd']){
                    $user['pwd'] = md5('123456');
                    M("user")->where(array('user_id'=>$params['id']))->save(["pwd"=>$user['pwd']]);

                }

                $res = $this->sendSMS($user['phone'],6);
                if($res['status'] == 'error'){
                    $this->error($res['msg']);
                }

                //生成二维码
                $code = $this->buildCode($id);
                $map['code'] = $code;
                // //发送短信通知
                // $login = A('App/Login');
                // $res = $login->sendSMS($userphone,6);

            }
            M("shop_merchants")->where(array('member_id'=>$params['id']))->save($map);
            // success(array("satus"=>"ok","info"=>"编辑程成功"));
            $this->success('审核成功!',U('apply_list'));
        }else{
            $sheng = M('Areas')->where(array('level'=>1))->select();
            $this->assign('sheng', $sheng);
            $list = M("shop_merchants")->where(array('member_id'=>$id))->find();
            $re = $list;
            
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
            // print_r($re);exit;
            $this->assign("re",$re);
            $this->assign ('pagetitle', '审核商户信息');

            $this->display();
        }

    }

    

    /**
     * @彻底删除
     */
    public function del_true(){
        $id = I('ids');
        $rs = M('shop_merchants')->where(['merchants_id'=>['in',$id]])->delete();
        echo $rs ? 1 : 2;
    }



    /**
     *@导购视频
     */
    public function video(){
        $map = array();
        !empty($_GET['username']) && $map['a.title|c.merchants_name|c.contact_name|c.contact_mobile'] = array("like","%".I('username')."%");
        if(!empty($_GET['start_time'])) $start_time = strtotime(I('start_time')); else $start_time = 0;
        if(!empty($_GET['end_time']))   $end_time = strtotime(I('end_time')); else $end_time = time();
        $map['a.intime'] = ['between',[$start_time,$end_time]];
        $map['a.is_del'] = 1;
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);

        $data= M("Video")->alias('a')
            ->field("a.video_id,a.title,a.video_img,a.url,a.date,a.intime,a.is_shenhe,a.watch_nums,b.phone,b.username,c.merchants_name,c.merchants_img,c.contact_name,c.contact_mobile")
            ->join('m_shop_merchants c ON a.user_id = c.member_id',"LEFT")
            ->join("m_user b ON a.user_id = b.user_id",'LEFT')
            ->where($map)
            ->order('a.intime desc')
            ->limit($p->firstRow.','.$p->listRows)
            ->select();
        $count = M("Video")->alias('a')
            ->join('m_shop_merchants c ON a.user_id = c.member_id',"LEFT")
            ->join("m_user b ON a.user_id = b.user_id",'LEFT')
            ->where($map)
            ->count(); // 查询满足要求的总记录数;

        $p = getpage($count,$nus);
        $this->assign("show",$p->show());
        $this->assign ('pagetitle', '商户导购视频' );
        $this->assign(['list'=>$data,'count'=>$count,'page'=>$page]);
        $url =$_SERVER['REQUEST_URI'];
        session('url',$url);
        $this->display();
    }

    /**
     *@修改审核状态
     */
    public function change_video_shenhe(){
        if(IS_POST){
            $id = I('id');
            $status = M('Video')->where(['video_id'=>$id])->getField('is_shenhe');
            $abs = 3 - $status;
            //$arr = ['默认状态','开启状态'];
            $result = M('Video')->where(['video_id'=>$id])->save(['is_shenhe'=>$abs]);
            if($result){
                echo json_encode(array('status'=>'ok','info'=>$abs));
                exit;
            }else{
                echo json_encode(array('status'=>'error','info'=>'切换状态失败'));
                exit;
            }
        }
    }


    public function change_goods_review(){
        if(IS_AJAX){
            $id = I('id');
            $status = M('Video')->where(['video_id'=>$id])->getField('is_shenhe');
            $abs = 3 - $status;
            $result = M('Video')->where(['video_id'=>$id])->save(['is_shenhe'=>$abs]);
            if($result){
                return success($abs);
            }else{
                return error('切换状态失败');
            }
        }
    }

    /**
     *@删除视频
     */
    public function del_video(){
        $id = I('ids');
        $data['video_id'] = ['in',$id];
        $user = M('Video')->where($data)->save(['is_del'=>2]);
        if($user){
            echo json_encode(['status'=>"ok",'info'=>'删除记录成功!','url'=>session('url')]);
        }else{
            echo json_encode(['status'=>"error",'info'=>'删除记录失败!']);
        }
    }



    /**
     *
     * @总仓列表
     */
    public function warehouse(){
        if( !M()->autoCheckToken($_POST) ) $this->error('禁止站外提交！');
        unset($_POST['__hash__']);
        $map=[];
        !empty($_GET['name']) && $map['phone|merchants_name|contact_mobile|contact_name'] = ['like','%'.I('name').'%'];
        $map['a.is_delete'] = 0;
        $map["a.apply_state"] = 2;
        $map["b.type"] = 2;
        $map['b.is_del'] = 1;

        $map['a.is_all'] = 1;

        // $is_all = $_GET['is_all'];
        // if ($is_all !== FALSE && $is_all !== "" && $is_all !== null){
        //     $map['is_all'] = $is_all;
        //     $this->assign('is_all',$is_all);
        // }

        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);

        $count = M("shop_merchants")
                ->alias('a')
                ->join('__USER__ b ON a.member_id = b.user_id')
                ->where($map)
                ->count();
        $p = getpage($count,$nus);
        $this->assign("count",$count);
        $list = M("shop_merchants")->alias("a")
                ->field("a.dashang_scale,a.sell_scale,a.tv_sell_scale,a.spread_scale,a.merchants_id,a.merchants_name,a.merchants_img,a.contact_name,a.create_time,a.update_time,a.contact_mobile,a.member_id,b.phone,b.img,a.apply_state,a.pay_state,a.is_all")
                ->join('__USER__ b ON a.member_id = b.user_id')
                ->where($map)
                ->order('a.create_time desc')
                ->limit($p->firstRow.','.$p->listRows)
                ->select();
        // $list->toArray();
        foreach ($list as $k=>$v){
            $data = array();
            $data = $v;
            $data['merchant_scale'] = 100 - $v['sell_scale']- $v['tv_sell_scale'] - $v['spread_scale'];
            // $list->offsetSet($k,$data);
        }
        $url =$_SERVER['REQUEST_URI'];
        session('url',$url);
        $this->assign("list",$list);
        $this->assign("show",$p->show());
        $this->assign ('pagetitle', '总仓列表' );

        $this->display();
    }

    /**
     *
     * @添加总仓
     */
    public function toadd_warehouse(){
        if( !M()->autoCheckToken($_POST) ) $this->error('禁止站外提交！');
        unset($_POST['__hash__']);

        if(IS_POST){
            
                //添加
                $merchants_id = $_POST['merchants_id'];

                $result = M('shop_merchants')->where(['merchants_id'=>$merchants_id])->setField('is_all','1');
                
                if($result){
                    $this->success('成功!',U('warehouse'));
                }else{
                    $this->error('失败!',U('warehouse'));
                }

            
        }else{
            $map['a.is_all'] = 0;
            $map['a.is_delete'] = 0;
            $map["a.apply_state"] = 2;
            $map["b.type"] = 2;
            $map['b.is_del'] = 1;

            //查询不是总仓的店铺
            $list = M('shop_merchants')
                    ->alias("a")
                    ->field('a.merchants_id,a.merchants_name')
                    ->join('__USER__ b ON a.member_id = b.user_id')
                    ->where($map)
                    ->select();

            $this->assign ( 'pagetitle', '添加总仓' );
            $this->assign ( 'list', $list );
            $this->display();
        }
        
    }

    /**
     * @更改总仓为普通商户
     */
    public function del_warehouse(){
        $id = I('ids');
        $rs = M('shop_merchants')->where(['merchants_id'=>['in',$id]])->setField('is_all','0');;
        echo $rs ? 1 : 2;
    }

    /**
   * @发送短信
   * Enter description here ...
   */  
  public function sendSMS($phone,$type)
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


        $mobile = I('mobile')?I('mobile'):$phone;
       // !preg_match('#^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}|^17[0-9]\d{8}$#', $mobile)
        if (empty($mobile)) {
            $data['status'] = 'error';
            $data['msg'] = '手机格式不正确';
            return $data;
        }else{
            $system = M('System')->field('tengxun_appid,tengxun_appkey,code_volidity,sms_error')->where(['id'=>1])->find();

            $count = M('User_sms_error')->where(['phone'=>$mobile,'date'=>date('Y-m-d',time())])->count();
            if ($count>=$system['sms_error']){
                $data['status'] = 'error';
                $data['msg'] = '今日输入错误次数已达到上限';
                return $data;
            }

            $type = I("type")?I("type"):$type;
            empty($type) ?$this->error('参数错误!') :true;
            $date = M("User")->where(array('phone'=>$mobile))->find();
            $mobile_code = random(6, 1);
            $_SESSION['mobile_code'] = $mobile_code;
            if ($type==1){
                if ($date){
                    $data['status'] = 'error';
                    $data['msg'] = '已注册！';
                    return $data;
                }else {
                    //success($mobile_code);
                    $content = "您的验证码为".$mobile_code.",请于".$system['code_volidity']."分钟内正确输入，如非本人操作请忽略此消息。【品聚】";
                }
            }elseif ($type==2){
                if ($date){
                    $content = "您的验证码为".$mobile_code.",请于".$system['code_volidity']."分钟内正确输入，如非本人操作请忽略此消息。【品聚】";
                }else {
                    $data['status'] = 'error';
                    $data['msg'] = '未注册！';
                    return $data;
                }
            }elseif($type==3){
                if($date){
                    $content = "您的验证码为".$mobile_code.",请于".$system['code_volidity']."分钟内正确输入，如非本人操作请忽略此消息。【品聚】";
                }else{
                    $data['status'] = 'error';
                    $data['msg'] = '未注册！';
                    return $data;
                }
            }elseif($type==4){
                if($date){
                    $content = "您的验证码为".$mobile_code.",请于".$system['code_volidity']."分钟内正确输入，如非本人操作请忽略此消息。【品聚】";
                }else{
                    $data['status'] = 'error';
                    $data['msg'] = '未注册！';
                    return $data;
                }
            }elseif($type==5){
                $content = "您的验证码为".$mobile_code.",请于".$system['code_volidity']."分钟内正确输入，如非本人操作请忽略此消息。【品聚】";
            }elseif($type==6){
                $content = "您已通过平台商户审核,初始密码为APP登陆密码或123456,商户后台链接".'http://tp3shoplive.zhongfeigou.com/merchant'."【品聚】";
            }
            $contents = array(
                'content'   => $content,//短信内容必须含有“码”字
                'mobile'    => $mobile,//手机号码
            );

            $gateway =zhutong_sendSMS($contents);
            $arr = explode(',',$gateway);
            //$result = substr($gateway,0,2);
            switch ($arr['0']){
                case 1:
                    M('Mobile_sms')->add(['mobile'=>$mobile,'code'=>$mobile_code,'state'=>1,'date'=>date('Y-m-d',time()),'intime'=>time()]);
                    $data['status'] = 'ok';
                    $data['msg'] = '发送成功!';
                    return $data;
                    break;
                case 12:
                    $data['status'] = 'error';
                    $data['msg'] = '提交号码错误!';
                    return $data;
                    break;
                case 13:
                    $data['status'] = 'error';
                    $data['msg'] = '短信内容为空!';
                    return $data;
                    break;
                case 17:
                    $data['status'] = 'error';
                    $data['msg'] = '一分钟内一个手机号只能发两次!';
                    return $data;
                    break;
                case 19:
                    $data['status'] = 'error';
                    $data['msg'] = '号码为黑号!';
                    return $data;
                    break;
                case 26:
                    $data['status'] = 'error';
                    $data['msg'] = '一小时内只能发五条!';
                    return $data;
                    break;
                case 27:
                    $data['status'] = 'error';
                    $data['msg'] = '一天一手机号只能发20条!';
                    return $data;
                    break;
                default:
                    $data['status'] = 'error';
                    $data['msg'] = '发送失败!';
                    return $data;
            }
        }
    }
}