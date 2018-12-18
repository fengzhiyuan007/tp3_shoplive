<?php
namespace App\Controller;
use Behavior\CheckLangBehavior;

use Home\Controller\IndexController;
use Psr\Log\Test\DummyTest;

use Org\Util\Date;
use Think\Upload;
use Think\Controller;
class UserController extends CommonController {
    /**
     * 获取用户信息
     */
    public function user_info(){
        if (IS_POST) {
            //待优化
            $user = checklogin();
            $user['header_img'] = domain($user['img']);
            $user['img'] = domain($user['img']);
            $user['thumb_img'] = domain($user['thumb_img']);
            $user['follow'] = M('Follow')->alias('a')
                ->join('m_user b ON a.user_id2 = b.user_id')
                ->where(['a.user_id' => $user['user_id'],'a.is_delete'=>'1','b.is_del'=>'1'])->count();
            $user['follow_to'] = M('Follow')->alias('a')
                ->join('m_user b ON a.user_id = b.user_id')
                ->where(['a.user_id2' => $user['user_id'],'a.is_delete'=>'1','b.is_del'=>'1'])->count();
            $user['live_count'] = M('Live_store')->where(['user_id' => $user['user_id'], 'is_del' => 1])->count();
            $userinfo = M("shop_merchants")->where(['member_id'=>$user['user_id']])->find();
            if (!$userinfo) {
                $user["apply_state"] = '0';
            } else {
                $user["apply_state"] = $userinfo["apply_state"];
            }
            //商家状态
            $userinfo['pay_state'] ? $user["pay_state"] = $userinfo["pay_state"] : $user["pay_state"] = '0';
            //今日收益
            $user["today_earnings"] = (string)(M("give_gift")->where(["user_id2" => $user["user_id"], "date" => date("Y-m-d",time())])->sum("jewel"));
            //昨日收益
            $user["yesterday_earnings"] = (string)(M("give_gift")->where(["user_id2" => $user["user_id"], 'date' => date("Y-m-d", strtotime("-1 day"))])->sum("jewel"));
            //本月收益
            $this_month = strtotime(date("Y-m",time()));
            $user["month_earnings"] = (string)(M("give_gift")->where(['date'=>['gt',$this_month],'user_id2'=>$user['user_id']])->sum("jewel"));
            $get_count = M('give_gift')->where(['user_id2' => $user['user_id']])->sum('jewel');
            $get_count ? $user['get_count'] = (string)$get_count : $user['get_count'] = "0";
            //送出
            $give_count = M('user')->where(['user_id' => $user['user_id']])->getField('give_gift_count');
            $give_count ? $user['give_count'] = (string)$give_count : $user['give_count'] = "0";


            //待支付订单
            $user['wait_count'] = (string)(M('shop_order_merchants')->alias('a')
                ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
                ->where(['a.is_delete'=>'0','a.member_id'=>$user['user_id'],'a.order_state'=>'wait_pay'])
                ->count());
            $user['seed_count'] = (string)(M('shop_order_merchants')->alias('a')
                ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
                ->where(['a.is_delete'=>'0','a.member_id'=>$user['user_id'],'a.order_state'=>'wait_send'])
                ->count());
            $user['receive_count'] = (string)(M('shop_order_merchants')->alias('a')
                ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
                ->where(['a.is_delete'=>'0','a.member_id'=>$user['user_id'],'a.order_state'=>'wait_receive'])
                ->count());
            $user['assessment_count'] = (string)(M('shop_order_merchants')->alias('a')
                ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
                ->where(['a.is_delete'=>'0','a.member_id'=>$user['user_id'],'a.order_state'=>'wait_assessment'])
                ->count());
            $user['returns_count'] = (string)(M('shop_order_refund')->where(['is_delete'=>'0','member_id'=>$user['user_id']])->count());
//        $authen = M('User_authen')->where(['user_id'=>$user['user_id']])->find();
//        if ($authen){
//            $user['is_authen'] = $authen['status'];
//        }else{
//            $user['is_authen'] = "-1";
//        }
            success($user);
        }
    }

	/**
	 * 会员中心
	*/
    public function index(){
        $user = checklogin();
        $user['img'] = domain($user['img']);
        $user['thumb_img'] = domain($user['thumb_img']);
        $user['get_money'] = FormatMoney($user['get_money']);
        $follow = M('Follow')
            ->alias('a')
            ->join('__USER__ b on a.user_id2=b.user_id')
            ->where(['a.user_id'=>$user['user_id'],'b.is_del'=>1])
            ->count();
        $user['follow'] = FormatMoney($follow);
        $follow_to = M('Follow')->alias('a')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.user_id2'=>$user['user_id'],'b.is_del'=>1])
            ->count();
        $user['follow_to'] = FormatMoney($follow_to);
        $live_count = M('Live_store')
            ->alias('a')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.user_id'=>$user['user_id'],'a.is_del'=>1])
            ->count();
        $user['live_count'] = FormatMoney($live_count);
        $user['imgs_count'] = FormatMoney(M('User_imgs')->where(['user_id'=>$user['user_id']])->count());
        $give_count = M('Give_gift')->where(['user_id'=>$user['user_id']])->sum('jewel');
        $give_count ? $user['give_count'] = FormatMoney($give_count) : $user['give_count'] = "0";
        $get_gradeinfo = get_gradeinfo($user['grade']);
        $user['grade_img'] = $get_gradeinfo['img'];
        $user['name'] = $get_gradeinfo['name'];


        success($user);
    }
    /**
     * @录播列表
     */
    public function live_list(){
        $user = checklogin();
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $list = M('Live_store')
            ->alias('a')
            ->field('a.*,b.img,b.sex,b.username,b.ID,b.hx_username,b.grade,b.province,b.city,b.zan,b.money,b.get_money')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.user_id'=>$user['user_id'],'a.is_del'=>1])
            ->order('a.intime desc')
            ->page($page,$pageSize)
            ->select();
        if ($list){
            foreach ($list as $k=>$v){
                if (time()-$v['intime']<(7*24*60*60)){
                    $list[$k]['intime'] = get_times($v['intime']);
                }else{
                    $list[$k]['intime'] = $v['date'];
                }
                $list[$k]['play_img'] = domain($v['play_img']);
                $list[$k]['img'] = C('IMG_PREFIX').M('User')->where(['user_id'=>$v['user_id']])->getField('img');

                $get_gradeinfo = get_gradeinfo($v['grade']);
                $list[$k]['grade_img'] = $get_gradeinfo['img'];
                $list[$k]['name'] = $get_gradeinfo['name'];
            }
        }else{$list=[];}
        success($list);
    }

    /**
     * @点击录播视频播放+1
     */
    public function play_store(){
        $user = checklogin();
        $live_store_id = I('live_store_id');
        (empty($live_store_id)) ? error('参数错误!') : true;
        if (M('Live_store')->where(['live_store_id'=>$live_store_id])->setInc('play_number')){
            success('成功!');
        }else{
            error('失败!');
        }
    }

    /**
     * @删除录播
     */
    public function del_live(){
        $user = checklogin();
        $live_store_id = I('live_store_id');
        empty($live_store_id) ? error('参数错误!') : true;
        if (M('Live_store')->where(['live_store_id'=>['in',$live_store_id]])->save(['is_del'=>2,'uptime'=>time()])){
            success('成功');
        }else{
            error('失败!');
        }
    }


    /**
     * @相册上传图片
     */
    public function upload_imgs(){
        $user = checklogin();
        $config = [
            'maxSize'	=> 500*3145728,
            'rootPath'	=> './Public/upload/user_imgs/',
            'savePath'	=> '',
            'saveName'	=> ['uniqid',''],
            'exts'		=> ['png','jpg','jpeg','git','gif'],
            'autoSub'	=> true,
            'subName'	=> '',
        ];
        $uploader = new Upload($config);
        $info = $uploader->upload();
        if ($info){
            foreach($info as $file){
                $imgs = '/Public/upload/user_imgs/'.$file["savename"];
                $dataList[] = ['user_id'=>$user['user_id'],'imgs'=>$imgs,'intime'=>time(),'date'=>date('Y-m-d',time())];    //批量写入
            }
        }else {
            error($uploader->getError());
        }
        if (M('User_imgs')->addAll($dataList)){
            success('成功!');
        }else{
            error('失败!');
        }

    }

    /**
     * @相册列表
     */
    public function imgs_list(){
        $user = checklogin();
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $date = M('User_imgs')->field('date')->where(['user_id'=>$user['user_id']])->order('intime desc')->group('date')->select();
        if ($date){
            $ids = array_map(function($v){ return $v['date'];},$date);
            foreach ($ids as $k=>$v) {
                if ($v == date('Y-m-d', time())) {
                    $day = '今天';
                } else {
                    $day = $v;
                }
                $list[$k]['time'] = $day;
                $imgs_list = M('User_imgs')
                    ->where(['user_id'=>$user['user_id'],'date'=>$v])
                    ->order('intime desc')
                    ->select();
                foreach ($imgs_list as $a=>$b){
                    $imgs_list[$a]['imgs'] = C('IMG_PREFIX').$b['imgs'];
                }
                $list[$k]['list'] = $imgs_list;
            }
            $list = array_slice($list,($page-1)*$pageSize,$pageSize);
        }else{$list=[];}
        $result['count'] = M('User_imgs')->where(['user_id'=>$user['user_id']])->count();
        $result['list'] = array_values($list);
        success($result);
    }

    /**
     * @删除相册
     */
    public function del_imgs(){
        checklogin();
        $imgs_id = I('user_imgs_id');
        if (M('User_imgs')->where(['user_imgs_id'=>['in',$imgs_id]])->delete()){
            success('成功!');
        }else{
            error('失败!');
        }
    }


    /**
     * @日榜、周榜、总榜
     * $type  1:日榜   2:周榜  3:总榜
     */
    public function total_list(){
        $user = checklogin();
        $type = I('type');
        (empty($type)) ? error('参数错误!') : true;
        $page = I('page');
        $pageSize = I('pagesize');
        if($page){
            $pageSize ? $pageSize : $pageSize = 10;
        }
        //$page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        switch ($type){
            case 1:
                $where = [
                    'a.user_id2'=>$user['user_id'],
                    'b.is_del'=>1,
                    'a.date'=>date('Y-m-d',time())
                ];
                break;
            case 2:
                $where = [
                    'a.user_id2'=>$user['user_id'],
                    'b.is_del'=>1,
                    'a.intime'=>['gt',time()-(7*24*60*60)]
                ];
                break;
            case 3:
                $where = [
                    'a.user_id2'=>$user['user_id'],
                    'b.is_del'=>1,
                ];
                break;
        }
        $total = M('Give_gift')
            ->alias('a')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where($where)
            ->sum('a.jewel');
        $total ? $list['total'] = $total : $list['total'] = "0";
        $give_list = M('Give_gift')
            ->alias('a')
            ->field('b.user_id,b.img,b.username,b.hx_username,sum(jewel) as count,b.sex,b.grade')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->group('a.user_id')
            ->where($where)
            ->order('count desc')
            ->page($page,$pageSize)
            ->select();
        if ($give_list){
            foreach ($give_list as $k=>$v){
                $give_list[$k]['img'] = C('IMG_PREFIX').$v['img'];
                $is_follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                $is_follow ? $give_list[$k]['is_follow'] = "2" : $give_list[$k]['is_follow'] = "1";

                $get_gradeinfo = get_gradeinfo($v['grade']);
                $give_list[$k]['grade_img'] = $get_gradeinfo['img'];
                $give_list[$k]['name'] = $get_gradeinfo['name'];
            }
        }else{$give_list=[];}
        $list['list'] = $give_list;
        success($list);
    }



	
	/**
     * 直播A站 
     * @编辑个人资料
     */
// 	public function edit_user(){
// 	    $user = checklogin();
//         $key = I('key'); $username = replace_string(I('username'));  $sex = I('sex');  $birth_day = I('birth_day');  $autograph = replace_string(I('autograph'));
//         $province = I('province'); $city = I('city');   $area = I('area');
// //        if (!empty($username)){
// //            $u = M('User')->where(['username'=>$username])->find();
// //            if ($u){error('昵称已存在!');}
// //        }
//         if(!empty($key)){
//             $config = [
//                 'maxSize'	=> 30*3145728,
//                 'rootPath'	=> './Public/admin/Uploads/touxiang/',
//                 'savePath'	=> '',
//                 'saveName'	=> ['uniqid',''],
//                 'exts'		=> ['png','jpg','jpeg','git','gif'],
//                 'autoSub'	=> true,
//                 'subName'	=> '',
//             ];
//             $uploader = new Upload($config);
//             $info = $uploader->upload();
//             if ($info){
//                 foreach($info as $file){
//                     $a = '/Public/admin/Uploads/touxiang/'.$file["savename"];
//                     $img= ".".$a;
//                     $image = new \Think\Image();
//                     $image->open($img);
//                     // 按照原图的比例生成一个最大为60*60的缩略图并保存为thumb.jpg
//                     $path = './Public/admin/Uploads/touxiang/thumb_img/'.time().rand(100, 999).'.jpg';
//                     $image->thumb(60, 60)->save($path);
//                     $data['img'] = $a;
//                     $data['thumb_img'] = $path;
//                 }
//             }else {
//                 error($uploader->getError());
//             }
//         }
//         (!empty($username)) ? $data['username'] = $username : true;           //姓名
//         (!empty($sex)) ? $data['sex'] = $sex : true;                         //性别
//         (!empty($birth_day))? $data['birth_day'] = $birth_day : true;     //生日
//         (!empty($autograph))? $data['autograph'] = $autograph : true;                 //个人简介
//         (!empty($province))? $data['province'] = $province : true;                 //省
//         (!empty($city))? $data['city'] = $city : true;                 //市
//         (!empty($area))? $data['area'] = $area : true;                 //区
//         $data['uptime'] = time();
//         $old_img = M('User')->where(['user_id'=>$user['user_id']])->getField('img');
//         if(M('User')->where(['user_id'=>$user['user_id']])->save($data)){
//             if ($a!=$old_img){
//                 unlink($old_img);
//             }
//             $imgs = C('IMG_PREFIX').M('User')->where(['user_id'=>$user['user_id']])->getField('img');
//             success($imgs);
//         }else{
//             error('失败!');
//         }
//     }


    /**
     * 百台云
     * @编辑个人资料
     */
    public function edit_user(){
        if (IS_POST) {
            $user = checklogin();
            $params = I('post.');
            empty($params["header_img"]) ? true : $data["img"] = $params["header_img"];
            empty($params["username"]) ? true : $data["username"] = replace_string($params["username"]);
            empty($params["sex"]) ? true : $data["sex"] = $params["sex"];
            empty($params["birth_day"]) ? true : $data["birth_day"] = $params["birth_day"];
            empty($params["province"]) ? true : $data["province"] = $params["province"];
            empty($params["city"]) ? true : $data["city"] = $params["city"];
            empty($params["area"]) ? true : $data["area"] = $params["area"];
            empty($params["signature"]) ?  true : $data["autograph"] = replace_string($params["signature"]);
            if (!empty($data["username"])) {
                $users = M('user')->where(['username' => $data["username"]])->find();
                if ($users) {
                    error('昵称已存在!');
                }
            }
            //待处理
            $data['uptime'] = time();
            $old_img = M('user')->where(['user_id' => $user['user_id']])->getField('img');
            if (M('user')->where(['user_id' => $user['user_id']])->save($data)) {
                //bug(旧文件的删除
                $imgs = M('user')->where(['user_id' => $user['user_id']])->getField('img');
                success($imgs);
            } else {
                error('失败!');
            }
        }
    }


    /**
     * @提交实名认证
     */
    public function commit_authen(){
        $user = checklogin();
        $realname = I('realname'); $idcard = I('idcard'); $mobile = I('mobile');  $band_card_where = I('band_card_where');  $band_card = I('band_card');
        (empty($realname) || empty($idcard) || empty($mobile) || empty($band_card_where) || empty($band_card)) ? error('参数错误!') : true;
        $data = [
            'user_id'=>$user['user_id'],
            'realname'=>$realname,
            'idcard'=>$idcard,
            'mobile'=>$mobile,
            'band_card_where'=>$band_card_where,
            'band_card'=>$band_card,
            'intime'=>time(),
        ];
        $config = [
            'maxSize'	=> 30*3145728,
            'rootPath'	=> './Public/admin/Uploads/touxiang/',
            'savePath'	=> '',
            'saveName'	=> ['uniqid',''],
            'exts'		=> ['png','jpg','jpeg','git','gif'],
            'autoSub'	=> true,
            'subName'	=> '',
        ];
        $uploader = new Upload($config);
        $info = $uploader->upload();
        if ($info){
            foreach($info as $file){
                $data['idcard_img'] = '/Public/admin/Uploads/touxiang/'.$file["savename"];
            }
        }else {
            error($uploader->getError());
        }
        if (M('User_authen')->add($data)){
            success('提交成功!');
        }else{
            error('失败!');
        }
    }

    /**
     * @编辑认证信息
     */
    public function edit_authen(){
        $user = checklogin();
        $user_authen_id = I('user_authen_id'); $realname = I('realname'); $idcard = I('idcard'); $idcard_img = I('idcard_img'); $mobile = I('mobile');  $band_card_where = I('band_card_where');  $band_card = I('band_card');
        (empty($user_authen_id) || empty($realname) || empty($idcard) || empty($idcard_img) || empty($mobile) || empty($band_card_where) || empty($band_card)) ? error('参数错误!') : true;
        $data = [
            'user_authen_id'=>$user_authen_id,
            'realname'=>$realname,
            'idcard'=>$idcard,
            'idcard_img'=>str_replace(C('IMG_PREFIX'),"",$idcard_img),
            'mobile'=>$mobile,
            'band_card_where'=>$band_card_where,
            'band_card'=>$band_card,
            'uptime'=>time()
        ];
        if (M('User_authen')->save($data)){
            success('成功!');
        }else{
            error('失败!');
        }
    }


    /**
     * @获取实名认证信息
     */
    public function get_authen(){
        $user = checklogin();
        $authen = M('User_authen')->where(['user_id'=>$user['user_id']])->find();
        $authen['idcard_img'] = C('IMG_PREFIX').$authen['idcard_img'];
        success($authen);
    }


    /**
     * @粉丝列表(关注列表)
     * $type   1:粉丝列表   2:关注列表
     */
    public function follow_list(){
        $user = checklogin();
        $type = I('type');
        empty($type) ? error('参数错误!') : true; ($type==1 || $type==2) ? true : error('传值错误!');
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        switch ($type){
            case 1:
                $list = M('Follow')
                    ->alias('a')
                    ->field('b.user_id,b.img,b.username,b.sex,b.autograph,b.hx_username,b.grade')
                    ->join('__USER__ b on a.user_id=b.user_id')
                    ->where(['a.user_id2'=>$user['user_id'],'b.is_del'=>1])
                    ->order('a.intime desc')
                    ->page($page,$pageSize)
                    ->select();
                if ($list){
                    foreach ($list as $k=>$v){
                        $list[$k]['img'] = C('IMG_PREFIX').$v['img'];
                        $is_follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                        $is_follow ? $list[$k]['is_follow'] = "2" : $list[$k]['is_follow'] = "1";

                        $get_gradeinfo = get_gradeinfo($v['grade']);
                        $list[$k]['grade_img'] = $get_gradeinfo['img'];
                        $list[$k]['name'] = $get_gradeinfo['name'];
                    }
                }else{$list=[];}
                break;
            case 2:
                $list = M('Follow')
                    ->alias('a')
                    ->field('b.user_id,b.img,b.username,b.sex,b.autograph,b.hx_username,b.grade')
                    ->join('__USER__ b on a.user_id2=b.user_id')
                    ->where(['a.user_id'=>$user['user_id'],'b.is_del'=>1])
                    ->order('a.intime desc')
                    ->page($page,$pageSize)
                    ->select();
                if ($list){
                    foreach ($list as $k=>$v){
                        $list[$k]['img'] = C('IMG_PREFIX').$v['img'];
                        $is_follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                        $is_follow ? $list[$k]['is_follow'] = "2" : $list[$k]['is_follow'] = "1";

                        $get_gradeinfo = get_gradeinfo($v['grade']);
                        $list[$k]['grade_img'] = $get_gradeinfo['img'];
                        $list[$k]['name'] = $get_gradeinfo['name'];
                    }
                }else{$list=[];}
                break;
        }
        success($list);
    }

    /**
     * @视频列表
     */
    public function video_list(){
        $user = checklogin();
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $list = M('Video')
            ->alias('a')
            ->field('a.*,b.img')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.user_id'=>$user['user_id'],'b.is_del'=>1])
            ->page($page,$pageSize)
            ->order('a.intime desc')
            ->select();
        if ($list){
            foreach ($list as $k=>$v){
                $list[$k]['video_img'] = C('IMG_PREFIX').$v['video_img'];
                $list[$k]['img'] = C('IMG_PREFIX').$v['img'];
            }
        }else{$list=[];}
        success($list);
    }

    /**
     * @删除视频
     */
    public function del_video(){
        $user = checklogin();
        $video_id = I('video_id');
        empty($video_id) ? error('参数错误!') : true;
        if (M('Video')->where(['video_id'=>['in',$video_id]])->save(['is_del'=>2,'uptime'=>time()])){
            success('成功');
        }else{
            error('失败!');
        }
    }

    /**
     * @黑名单
     */
    public function shield_list(){
        $user = checklogin();
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $list = M('Shield')
            ->alias('a')
            ->field('a.shield_id,a.intime,b.user_id,b.username,b.img,b.company,b.duty,b.ID,b.hx_username,b.sex,b.grade,b.autograph')
            ->join('__USER__ b on a.user_id2=b.user_id')
            ->where(['a.user_id'=>$user['user_id']])
            ->order('a.intime desc')
            ->page($page,$pageSize)
            ->select();
        if ($list){
            foreach ($list as $k=>$v) {
                $list[$k]['intime'] = date('Y-m-d H:i:s',$v['intime']);
                $list[$k]['img'] = C('IMG_PREFIX').$v['img'];

                $get_gradeinfo = get_gradeinfo($v['grade']);
                $list[$k]['grade_img'] = $get_gradeinfo['img'];
                $list[$k]['name'] = $get_gradeinfo['name'];
            }
        }else{$list=[];}
        success($list);
    }


    /**
     * @取消黑名单
     */
    public function del_shield(){
        $user = checklogin();
        $shield_id = I('shield_id');
        empty($shield_id) ? error('参数错误!') : true;
        $shield = M('Shield')->find($shield_id);
        if (M('Shield')->where(['shield_id'=>$shield_id])->delete()){
            $hx_username = M('User')->where(['user_id'=>$shield['user_id2']])->getField('hx_username');
            deleteUserFromBlacklist($user['hx_username'],$hx_username);  //环信移除黑名单
            success('成功!');
        }else{
            error('失败!');
        }
    }


    /**
     * @我的意见
     */
    public function feedback(){
        $user = checklogin();
        $content = I('content');
        empty($content) ? error('参数错误!') : true;
        if (M('Feedback')->add(['user_id'=>$user['user_id'],'content'=>$content,'intime'=>time()])){
            success('成功!');
        }else{
            error('失败!');
        }
    }

    /**
     * @意见列表
     */
    public function feedback_list(){
        $user = checklogin();
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $list = M('Feedback')
            ->alias('a')
            ->field('a.*,b.img')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.user_id'=>$user['user_id']])
            ->page($page,$pageSize)
            ->order('a.intime desc')
            ->select();
        if ($list){
            foreach ($list as $k=>$v){
                $list[$k]['img'] = domain($v['img']);
            }
        }else{$list=[];}
        //if (!$list){$list = [];}
        success($list);
    }

    /**
     * @关于我们
     */
    public function about_us(){
        $about_us = M('About_us')->field('about_us_id,imgs,mobile,email,qq,wechat')->where(['about_us_id'=>1])->find();
        $about_us['imgs'] = C('IMG_PREFIX').$about_us['imgs'];
        success($about_us);
    }

    /**
     * @常见问题
     */
    public function common_problems(){
        $clause = M('About_us')->where(['about_us_id'=>2])->getField('clause');
        $this->assign('about_us',htmlspecialchars_decode($clause));
        $this->display();
    }

        /**
     * @隐私服务条款
     */
    public function clause(){
        $clause = M('About_us')->where(['about_us_id'=>1])->getField('clause');
        $this->assign('about_us',htmlspecialchars_decode($clause));
        $this->display();
    }

    /**
     * @隐私服务条款
     */
    public function xieyi(){
        $clause = M('About_us')->where(['about_us_id'=>1])->getField('xieyi');
        $this->assign('about_us',htmlspecialchars_decode($clause));
        $this->display();
    }
    /**
     * @用户充值协议
     */
    public function agreement(){
        $clause = M('About_us')->where(['about_us_id'=>1])->getField('agreement');
        $this->assign('about_us',htmlspecialchars_decode($clause));
        $this->display();
    }


    /**
     * @开播提醒
     */
    public function remind(){
        $user = checklogin();
        $page = I('page');  $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $result['is_remind'] = $user['is_remind'];
        $list = M('Follow')
            ->alias('a')
            ->field('a.follow_id,a.is_remind,b.user_id,b.img,b.username,b.sex,b.autograph,b.hx_username,b.grade')
            ->join('__USER__ b on a.user_id2=b.user_id')
            ->where(['a.user_id'=>$user['user_id']])
            ->page($page,$pageSize)
            ->order('a.intime desc')
            ->select();
        if ($list){
            foreach ($list as $k=>$v){
                $list[$k]['img'] = C('IMG_PREFIX').$v['img'];
            }
        }else{$list=[];}
        $result['follow_list'] = $list;
        success($result);
    }

    /**
     * @更改提醒状态
     * @type   1:更改用户状态   2:更改关注列表状态
     * @is_remind   1:开启  2:关闭
     */
    public function up_remind(){
        $user = checklogin();
        $type = I('type');  $is_remind = I('is_remind');
        (empty($type) || empty($is_remind)) ? error('参数错误!') : true;
        switch ($type){
            case 1:
                if (M('User')->where(['user_id'=>$user['user_id']])->save(['is_remind'=>$is_remind,'uptime'=>time()])){
                    success('成功!');
                }else{
                    error('失败!');
                }
                break;
            case 2:
                $follow_id = I('follow_id');
                empty($follow_id) ? error('参数错误!') : true;
                if (M('Follow')->where(['follow_id'=>$follow_id])->save(['is_remind'=>$is_remind,'uptime'=>time()])){
                    success('成功!');
                }else{
                    error('失败!');
                }
                break;
        }
    }




    /**
     * @上传图片,返回路径
     */
    public function upload(){
        $config = [
            'maxSize'	=> 500*3145728,
            'rootPath'	=> './Public/admin/Uploads/touxiang/',
            'savePath'	=> '',
            'saveName'	=> ['uniqid',''],
            'exts'		=> ['png','jpg','jpeg','git','gif'],
            'autoSub'	=> true,
            'subName'	=> '',
        ];
        $uploader = new Upload($config);
        $info = $uploader->upload();
        if ($info){
            foreach($info as $file){
                $a = C('IMG_PREFIX').'/Public/admin/Uploads/touxiang/'.$file["savename"];
            }
            success($a);
        }else {
            error($uploader->getError());
        }

    }

    /**
     * @我的钻石
     */
    public function my_money(){
        $user = checklogin();
        success($user['money']);
    }

    /**
     * @我赞过的视频
     */
    public function zan_video_list(){
        $user = checklogin();
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $list = M('Video')
            ->alias('a')
            ->field('a.*,c.img,c.username,c.get_money')
            ->join('__VIDEO_ZAN__ b on a.video_id=b.video_id')
            ->join('__USER__ c on a.user_id=c.user_id')
            ->where(['b.user_id'=>$user['user_id'],'a.is_del'=>1])
            ->page($page,$pageSize)
            ->order('b.intime desc')
            ->select();
        if ($list){
            foreach ($list as $k=>$v){
                $list[$k]['video_img'] = C('IMG_PREFIX').$v['video_img'];
                $list[$k]['url'] = C('IMG_PREFIX').$v['url'];
                $list[$k]['img'] = C('IMG_PREFIX').$v['img'];
            }
        }else{$list=[];}
        success($list);
    }

    /**
     * @充值记录
     */
    public function recharge_record(){
        $user = checklogin();
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $list = M('Recharge_record')->where(['user_id'=>$user['user_id'],'pay_on'=>['neq','']])->page($page,$pageSize)->order('intime desc')->select();
        if ($list){
            foreach ($list as $k=>$v){
                $list[$k]['intime'] = date('Y-m-d H:i:s',$v['intime']);
            }
        }else{$list=[];}
        success($list);
    }


    /**
     * @获取版本号
     * @type  1:ios版本号   2:安卓版本号
     */
    public function get_version(){
        $type = I('type');
        empty($type) ? error('参数错误!') : true;
        switch ($type){
            case 1:
                $version = M('System')->where(['id'=>1])->getField('ios_version');
                break;
            case 2:
                $version = M('System')->where(['id'=>1])->getField('android_version');
                break;
        }
        success($version);
    }

    /**
     * @判断版本号
     */
    public function is_this(){
        $version = I('version');
        empty($version) ? error('参数错误!') : true;
        $ve = M('System')->where(['id'=>1])->getField('ios_version');
        if ($ve==$version){
            $result = "1";
        }else{
            $result = "2";
        }
        success($result);
    }



    /**
     * @我的收益
     */
    public function my_wallet(){
        $user = checklogin();
        $system = M('System')->field(['lowest_limit,convert_scale3,convert_scale4'])->where(['id'=>1])->find();
        $all_fire = $user['get_money'];
        $all_get_money = (string)floor($all_fire*($system['convert_scale4']/$system['convert_scale3']));
        $bili = ($system['convert_scale4']/$system['convert_scale3']);
        //提现说明
        $withdraw_dis = M('About_us')->where(['about_us_id'=>1])->getField('withdraw_dis');
        $result = ['lowest_limit'=>$system['lowest_limit'],'all_fire'=>$all_fire,'all_get_money'=>$all_get_money,'withdraw_dis'=>$withdraw_dis,'bili'=>$bili];
        success($result);
    }


    /**
     * @获取支付宝信息
     */
    public function get_alipay(){
        $user = checklogin();
        $alipay = M('Alipay')->where(['user_id'=>$user['user_id']])->find();
        $alipay ? $alipay = $alipay : $alipay = [];
        success($alipay);
    }

    /**
     * @绑定支付宝验证手机号
     */
    public function verify_phone(){
        $user = checklogin();
        $phone = I('phone');  $yzm = I('yzm');
        (empty($phone) || empty($yzm)) ? error('参数错误!') : true;
        $code = M('Mobile_sms')->where(['phone'=>$phone,'state'=>1])->order('intime desc')->limit(1)->find();
        if ($code) {
            $time = M('System')->getFieldById(1,'code_volidity');
            if (time()-$code['intime']>($time*60)){
                error('验证码已过期!');
            }
        }
        if ($code['code']==$yzm){
            success('成功!');
        }else{
            error('验证码不一致!');
        }
    }

    /**
     * @绑定支付宝
     */
    public function binding_alipay(){
        $user = checklogin();
        $phone = I('phone'); $alipay = I('alipay'); $relname = I('relname');
        (empty($phone) || empty($alipay) || empty($relname)) ? error('参数错误!') : true;
        $data = [
            'user_id'=>$user['user_id'],
            'phone'=>$phone,
            'alipay'=>$alipay,
            'relname'=>$relname,
            'intime'=>time()
        ];
        if (M('Alipay')->add($data)){
            success('成功!');
        }else{
            error('失败!');
        }
    }


    /**
     * @更换支付宝账号
     */
    public function edit_alipay(){
        $user = checklogin();
        $phone = I('phone'); $alipay = I('alipay'); $relname = I('relname');
        (empty($phone) || empty($alipay) || empty($relname)) ? error('参数错误!') : true;
        $ali = M('Alipay')->where(['user_id'=>$user['user_id']])->find();
        $data = [
            'phone'=>$phone,
            'alipay'=>$alipay,
            'relname'=>$relname,
            'uptime'=>time()
        ];
        if (M('Alipay')->where(['alipay_id'=>$ali['alipay_id']])->save($data)){
            success('成功!');
        }else{
            error('失败!');
        }
    }


    /**
     * @输入度票,返回可兑换金额
     */
    public function return_money(){
        $user = checklogin();
        $diamond = I('diamond');
        empty($diamond) ? error('参数错误!') : true;
        $system = M('System')->field(['lowest_limit,convert_scale3,convert_scale4'])->where(['id'=>1])->find();
        $get_money = (string)floor($diamond*($system['convert_scale4']/$system['convert_scale3']));
        success($get_money);
    }


    /**
     * @提现提交
     */
    public function withdraw(){
        $user = checklogin();
        $diamond = I('diamond'); $withdraw_way = I('withdraw_way'); $money = I('money');
        (empty($diamond) || empty($withdraw_way) || empty($money)) ? error('参数错误!') : true;
        $withdraw_table = M('Withdraw');  $user_table = M('User');
        $withdraw_table->startTrans();  //开启事物
        $user['get_money'] - $diamond < 0 ? error('余额不足') : true;
        $date = [
            'user_id'=>$user['user_id'],
            'k'=>$diamond,
            'money'=>$money,
            'withdraw_type'=>'支付宝',
            'withdraw_way'=>$withdraw_way,
            'intime'=>time(),
            'date'=>date('Y-m-d',time()),
        ];
        if (M('Withdraw')->add($date)){
            $get_money = $user['get_money'] - $diamond;
            $u = M('User')->where(['user_id'=>$user['user_id']])->save(['get_money'=>$get_money,'uptime'=>time()]);
            if (!$u){
                $user_table->rollback();
                error('失败!');
            }
            $user_table->commit();
            success('成功!');
        }else{
            $user_table->rollback();
            error('失败!');
        }
    }

    /**
     * @提现记录
     */
    public function withdraw_list(){
        $user = checklogin();
        $page = I('page');  $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
//        $list = M('Withdraw')
//            ->where(['user_id'=>$user['user_id']])
//            ->page($page,$pageSize)
//            ->order('intime desc')
//            ->select();
//        if ($list){
//            foreach ($list as $k=>$v){
//                $list[$k]['intime'] = date('Y-m-d H:i:s',$v['intime']);
//            }
//        }else{$list=[];}
        $list = M('Withdraw_record')
            ->where(['user_id'=>$user['user_id']])
            ->page($page,$pageSize)
            ->order('intime desc')
            ->select();
        if ($list){
            foreach ($list as $k=>$v){
                $list[$k]['intime'] = date('Y-m-d H:i:s',$v['intime']);
            }
        }else{$list=[];}
        success($list);
    }


    /**
     * @兑换比例列表
     */
    public function convert_scale(){
        $user = checklogin();
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $list = M('Convert_scale')->page($page,$pageSize)->select();
        if (!$list){$list=[];}
        success($list);
    }

    /**
     * @输入度票,返回兑换的钻石
     */
    public function return_diamond(){
        $user = checklogin();
        $money = I('money');
        empty($money) ? error('参数错误!') : true;
        $system = M('System')->field(['lowest_limit,convert_scale1,convert_scale2'])->where(['id'=>1])->find();
        $get_diamond = (string)floor($money*($system['convert_scale2']/$system['convert_scale1']));
        success($get_diamond);
    }

    /**
     * @度票兑换钻石
     */
    public function convert(){
        $user = checklogin();
        $money = I('money');  $diamond = I('diamond');
        (empty($money) || empty($diamond)) ? error('参数错误!') : true;
        if ($user['get_money']<$money){error('度票不足!');}
        $data = [
            'user_id'=>$user['user_id'],
            'k'=>$money,
            'meters'=>$diamond,
            'intime'=>time(),
            'date'=>date('Y-m-d',time())
        ];
        $money2 = $user['money']+$diamond;
        $get_money = $user['get_money']-$money;
        $date = [
            'user_id'=>$user['user_id'],
            'money'=>$money2,
            'get_money'=>$get_money,
            'uptime'=>time()
        ];
        if (M('Convert')->add($data) && M('User')->save($date)){
            $content = $money."度票已成功兑换".$diamond.'钻石!';
            M('Message')->add(['type'=>1,'user_id2'=>$user['user_id'],'content'=>$content,'intime'=>time(),'date'=>date('Y-m-d',time())]);
            success('成功');
        }else{
            error('失败!');
        }
    }

    /**
     * @兑换记录
     */
    public function convert_list(){
        $user = checklogin();
        $page = I('page');  $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $list = M('Convert')->where(['user_id'=>$user['user_id']])->page($page,$pageSize)->order('intime desc')->select();
        if ($list){
            foreach ($list as $k=>$v){
                $list[$k]['intime'] = date('Y-m-d H:i:s',$v['intime']);
            }
        }else{$list=[];}
        success($list);
    }


    /**
     * @支付宝一键认证
     */
    public function pay_user(){
        $user = checklogin();
        $openid = I('openid');
        empty($openid) ? error('参数错误!') : true;
        $pay = M('Pay_user')->where(['openid'=>$openid])->find();
        if ($pay){
            error('支付宝已被绑定!');
        }else{
            if (M('Pay_user')->add(['user_id'=>$user['user_id'],'openid'=>$openid,'intime'=>time(),'date'=>date('Y-m-d',time())])){
                success('成功!');
            }else{
                error('失败!');
            }
        }
    }

    /**
     * @判断是否已认证
     */
    public function is_pay(){
        $user = checklogin();
        $pay = M('Pay_user')->where(['user_id'=>$user['user_id']])->find();
        $pay ? $is_pay = "2" : $is_pay = "1";
        success($is_pay);
    }


    /**
     * @我的师傅
     */
    public function my_master(){
        $user = checklogin();
        $user_id = I('user_id');
        if ($user_id){
            $where = [
                'user_id'=>$user_id
            ];
        }else{
            $where = [
                'user_id'=>$user['user_id']
            ];
        }
        $master = M('User_master')->where($where)->find();
        if ($master){
            $is_master = "2";
            $img = C('IMG_PREFIX').M('User')->where(['user_id'=>$master['master_id']])->getField('img');
            $grade = M('User')->where(['user_id'=>$master['master_id']])->getField('grade');
            $get_gradeinfo = get_gradeinfo($grade);
            $grade_img = $get_gradeinfo['img'];
            $master_id = $master['master_id'];
        }else{
            $is_master = "1";
            $img = "";
            $master_id = "0";
            $grade_img = "";
        }
        $result = ['is_master'=>$is_master,'img'=>$img,'master_id'=>$master_id,'grade_img'=>$grade_img];
        success($result);
    }

    /**
     * @填写师傅ID,绑定
     */
    public function add_master(){
        $user = checklogin();
        $id = I('ID');
        empty($id) ? error('参数错误!') : true;
        $u = M('User')->where(['ID'=>$id])->find();
        if (!$u){error('ID不存在!');}
        if ($user['id']==$id){error('不能绑定自己!');}
        if (M('User_master')->add(['user_id'=>$user['user_id'],'master_id'=>$u['user_id'],'intime'=>time(),'date'=>date('Y-m-d',time())])){
            success('成功!');
        }else{
            error('失败!');
        }
    }



    /**
     * @我的等级
     */
    public function my_grade(){
        $user = checklogin();
        $result['img'] = C('IMG_PREFIX').$user['img'];
        $result['grade'] = $user['grade'];
        $level = M('Level')->where(['level'=>$user['grade']])->find();
        $new_grade = $user['grade']+1;
        $level2 = M('Level')->where(['level'=>$new_grade])->find();
        if ($level2){
            $result['is_highest'] = "1";
            $result['between'] = (string)($level2['experience']-$level['experience']);
            $result['percentage'] = (string)round(((($user['experience']-$level['experience'])/($level2['experience']-$level['experience']))*100),2);
        }else{
            $result['is_highest'] = "2";
            $result['between'] = "0";
            $result['percentage'] = "0";
        }
        success($result);
    }


    /**
     * @账号安全
     * @判断是否绑定
     */
    public function safe_user(){
        $user = checklogin();
        $user = M('User')->where(['user_id'=>$user['user_id']])->field('user_id,token,phone,openid,qq_openid,weibo')->find();
        empty($user['phone']) ? $result['is_phone'] = "1" : $result['is_phone'] = "2";
        empty($user['openid']) ? $result['is_openid'] = "1" : $result['is_openid'] = "2";
        empty($user['qq_openid']) ? $result['is_qq_openid'] = "1" : $result['is_qq_openid'] = "2";
        empty($user['weibo']) ? $result['is_weibo'] = "1" : $result['is_weibo'] = "2";
        success($result);
    }


    /**
     * @绑定第三方
     * @type  1:微信  2:qq  3:微博
     */
    public function bound(){
        checklogin();
        $user_id = I('uid'); $type = I('type'); $openid = I('openid');
        (empty($type) || empty($openid)) ? error('参数错误!') : true;
        ($type==1 || $type==2 || $type==3) ? true : error('传值错误!');
        switch ($type){
            case 1:
                if (M('User')->where(['openid'=>$openid])->find()){
                    error('已注册!');
                }else {
                    if (M('User')->where(['user_id'=>$user_id])->save(['openid'=>$openid,'uptime'=>time()])){
                        success('成功!');
                    }else {
                        error('失败!');
                    }
                }
                break;
            case 2:
                if (M('User')->where(['qq_openid'=>$openid])->find()){
                    error('已注册!');
                }else {
                    if (M('User')->where(['user_id'=>$user_id])->save(['qq_openid'=>$openid,'uptime'=>time()])){
                        success('成功!');
                    }else {
                        error('失败!');
                    }
                }
                break;
            case 3:
                if (M('User')->where(['weibo'=>$openid])->find()){
                    error('已注册!');
                }else {
                    if (M('User')->where(['user_id'=>$user_id])->save(['weibo'=>$openid,'uptime'=>time()])){
                        success('成功!');
                    }else {
                        error('失败!');
                    }
                }
                break;
        }

    }

    /**
     * @账号管理--绑定手机号
     */
    public function bound_phone(){
        $user = checklogin();
        $phone = I('phone'); $yzm = I('yzm');
        (empty($phone) || empty($yzm)) ? error('参数错误!') : true;
        $code = M('Mobile_sms')->where(['phone'=>$phone,'state'=>1])->order('intime desc')->limit(1)->find();
//        if ($code) {
//            $time = M('System')->getFieldById(1,'code_volidity');
//            if (time()-$code['intime']>($time*60)){
//                error('验证码已失效!');
//            }
//        }
        if ($code['code']==$yzm){
            if (M('User')->where(['phone'=>$phone])->find()){
                error('手机号已注册!');
            }
            if (M('User')->where(['user_id'=>$user['user_id']])->save(['phone'=>$phone,'uptime'=>time()])){
                success('成功!');
            }else{
                error('失败!');
            }
        }else{
            error('验证码不一致!');
        }
    }

    /**
     * @账号管理--修改密码
     */
    public function up_pwd(){
        $user = checklogin();
        $yzm = I('yzm');  $pwd = I('new_pwd');
        (empty($yzm) || empty($pwd)) ? error('参数错误!') : true;
        $code = M('Mobile_sms')->where(['phone'=>$user['phone'],'state'=>1])->order('intime desc')->limit(1)->find();
        if ($code) {
            $time = M('System')->getFieldById(1,'code_volidity');
            if (time()-$code['intime']>($time*60)){
                error('验证码已失效!');
            }
        }
        if ($code['code']==$yzm){
            if (M('User')->where(['user_id'=>$user['user_id']])->save(['pwd'=>md5($pwd),'uptime'=>time()])){
                success('成功!');
            }else{
                error('失败!');
            }
        }else{
            error('验证码不一致!');
        }
    }

/**************************************************他人个人中心*******************************************************************/

    /**
     * @他人主页
     */
    public function other_center(){
        $user = checklogin();
        $user_id = I('user_id');
        empty($user_id) ? error('参数错误!') : true;
        $u = M('User')->find($user_id);
        $u['img'] = C('IMG_PREFIX').$u['img'];
        $u['get_money'] = FormatMoney($u['get_money']);
        $follow = M('Follow')
            ->alias('a')
            ->join('__USER__ b on a.user_id2=b.user_id')
            ->where(['a.user_id'=>$user_id,'b.is_del'=>1])
            ->count();
        $u['follow'] = FormatMoney($follow);
        $follow_to = M('Follow')->alias('a')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.user_id2'=>$user_id,'b.is_del'=>1])
            ->count();
        $u['follow_to'] = FormatMoney($follow_to);
        $u['collection'] = M('Collection')->where(['user_id'=>$user_id])->count();
        $is_follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$user_id])->find();
        $is_follow ? $u['is_follow'] = "2" : $u['is_follow'] = "1";
        //$u['video_count'] = M('Video')->where(['user_id'=>$user_id,'is_del'=>1])->count();    //视频数量
        $u['imgs_count'] = FormatMoney(M('User_imgs')->where(['user_id'=>$user_id])->count());
        $give_count = M('Give_gift')->where(['user_id'=>$user_id])->sum('jewel');
        $give_count ? $u['give_count'] = FormatMoney($give_count) : $u['give_count'] = "0";
        $live_count = M('Live_store')
            ->alias('a')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.user_id'=>$user_id,'a.is_del'=>1])
            ->count();
        $u['live_count'] = FormatMoney($live_count);

        $get_gradeinfo = get_gradeinfo($u['grade']);
        $u['grade_img'] = $get_gradeinfo['img'];
        $u['name'] = $get_gradeinfo['name'];



        //判断是否正在直播
        $live = M('Live')
            ->alias('a')
            ->field('a.*,b.username,b.img,b.grade,b.hx_username,b.ID,b.sex,b.province,b.city,b.money,b.get_money,b.type')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.user_id'=>$user_id,'a.live_status'=>1])
            ->find();
        if ($live){
            $u['is_live'] = "2";
            $live['img'] = domain($live['img']);
            $live['play_img'] = domain($live['play_img']);
            $live['qrcode_path'] = C('IMG_PREFIX').$live['qrcode_path'];
            $live['url'] = C('IMG_PREFIX')."/App/Index/share_live/live_id/" . base64_encode($live['live_id']);

            $get_gradeinfo = get_gradeinfo($live['grade']);
            $live['grade_img'] = $get_gradeinfo['img'];
            $live['name'] = $get_gradeinfo['name'];

            $u['live'] = $live;
        }else{
            $u['is_live'] = "1";
        }
        success($u);
    }

    /**
     * @相册列表
     */
    public function other_imgs_list(){
        checklogin();
        $user_id = I('user_id');
        empty($user_id) ? error('参数错误!') : true;
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $date = M('User_imgs')->field('date')->where(['user_id'=>$user_id])->order('intime desc')->group('date')->select();
        if ($date){
            $ids = array_map(function($v){ return $v['date'];},$date);
            foreach ($ids as $k=>$v) {
                if ($v == date('Y-m-d', time())) {
                    $day = '今天';
                } else {
                    $day = $v;
                }
                $list[$k]['time'] = $day;
                $imgs_list = M('User_imgs')
                    ->where(['user_id'=>$user_id,'date'=>$v])
                    ->order('intime desc')
                    ->select();
                foreach ($imgs_list as $a=>$b){
                    $imgs_list[$a]['imgs'] = C('IMG_PREFIX').$b['imgs'];
                }
                $list[$k]['list'] = $imgs_list;
            }
            $list = array_slice($list,($page-1)*$pageSize,$pageSize);
        }else{$list=[];}
        $result['count'] = M('User_imgs')->where(['user_id'=>$user_id])->count();
        $result['list'] = array_values($list);
        success($result);
    }


    /**
     * @他人粉丝列表
     * $type   1:粉丝列表   2:关注列表
     */
    public function other_follow_list(){
        $user = checklogin();
        $user_id = I('user_id');
        $type = I('type');
        (empty($type) || empty($user_id)) ? error('参数错误!') : true; ($type==1 || $type==2) ? true : error('传值错误!');
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        switch ($type){
            case 1:
                $list = M('Follow')
                    ->alias('a')
                    ->field('b.user_id,b.img,b.username,b.sex,b.autograph,b.hx_username,b.grade')
                    ->join('__USER__ b on a.user_id=b.user_id')
                    ->where(['a.user_id2'=>$user_id,'b.is_del'=>1])
                    ->order('a.intime desc')
                    ->page($page,$pageSize)
                    ->select();
                if ($list){
                    foreach ($list as $k=>$v){
                        $list[$k]['img'] = C('IMG_PREFIX').$v['img'];
                        $is_follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                        $is_follow ? $list[$k]['is_follow'] = "2" : $list[$k]['is_follow'] = "1";

                        $get_gradeinfo = get_gradeinfo($v['grade']);
                        $list[$k]['grade_img'] = $get_gradeinfo['img'];
                        $list[$k]['name'] = $get_gradeinfo['name'];
                    }
                }else{$list=[];}
                break;
            case 2:
                $list = M('Follow')
                    ->alias('a')
                    ->field('b.user_id,b.img,b.username,b.sex,b.autograph,b.hx_username,b.grade')
                    ->join('__USER__ b on a.user_id2=b.user_id')
                    ->where(['a.user_id'=>$user_id,'b.is_del'=>1])
                    ->order('a.intime desc')
                    ->page($page,$pageSize)
                    ->select();
                if ($list){
                    foreach ($list as $k=>$v){
                        $list[$k]['img'] = C('IMG_PREFIX').$v['img'];
                        $is_follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                        $is_follow ? $list[$k]['is_follow'] = "2" : $list[$k]['is_follow'] = "1";

                        $get_gradeinfo = get_gradeinfo($v['grade']);
                        $list[$k]['grade_img'] = $get_gradeinfo['img'];
                        $list[$k]['name'] = $get_gradeinfo['name'];
                    }
                }else{$list=[];}
                break;
        }
        success($list);
    }


    /**
     * @日榜、周榜、总榜
     * $type  1:日榜   2:周榜  3:总榜
     */
    public function other_total_list(){
        // $user = checklogin();
        $user_id = I('user_id');
        $type = I('type');
        (empty($type) || empty($user_id)) ? error('参数错误!') : true;
        $page = I('page');
        $pageSize = I('pagesize');
        //$pageSize ? $pageSize : $pageSize = 10;
        if($page){
            $pageSize ? $pageSize : $pageSize = 10;
        }
        switch ($type){
            case 1:
                $where = [
                    'a.user_id2'=>$user_id,
                    'b.is_del'=>1,
                    'a.date'=>date('Y-m-d',time())
                ];
                break;
            case 2:
                $where = [
                    'a.user_id2'=>$user_id,
                    'b.is_del'=>1,
                    'a.intime'=>['gt',time()-(7*24*60*60)]
                ];
                break;
            case 3:
                $where = [
                    'a.user_id2'=>$user_id,
                    'b.is_del'=>1,
                ];
                break;
        }
        $total = M('Give_gift')
            ->alias('a')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where($where)
            ->sum('a.jewel');
        $total ? $list['total'] = $total : $list['total'] = "0";
        if($page){
            $give_list = M('Give_gift')->alias('a')
                ->field('b.user_id,b.img,b.username,b.hx_username,sum(jewel) as count,b.sex,b.grade')
                ->join('__USER__ b on a.user_id=b.user_id')
                ->group('a.user_id')
                ->where($where)->order('count desc')
                ->page($page,$pageSize)
                ->select();
        }else{
            $give_list = M('Give_gift')->alias('a')
                ->field('b.user_id,b.img,b.username,b.hx_username,sum(jewel) as count,b.sex,b.grade')
                ->join('__USER__ b on a.user_id=b.user_id')
                ->group('a.user_id')
                ->where($where)->order('count desc')
                ->select();
        }
        if ($give_list){
            foreach ($give_list as $k=>$v){
                $give_list[$k]['img'] = C('IMG_PREFIX').$v['img'];
                $is_follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                $is_follow ? $give_list[$k]['is_follow'] = "2" : $give_list[$k]['is_follow'] = "1";

                $get_gradeinfo = get_gradeinfo($v['grade']);
                $give_list[$k]['grade_img'] = $get_gradeinfo['img'];
                $give_list[$k]['name'] = $get_gradeinfo['name'];
            }
        }else{$give_list=[];}
        $list['list'] = $give_list;
        success($list);
    }

    /*
     * @小时榜，日榜、周榜、月榜，总榜
     * $type  1:小时榜   2:日榜  3:周榜  4:月榜  5:总榜
     */
    public function charts(){
        // $user = checklogin();
        $uid = I('uid');
        $type = I('type');
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;
        $pageSize ? $pageSize : $pageSize = 1000;
        switch ($type){
            case 1:
                $where = [
                    'b.is_del'=>1,
                    'a.intime'=>['gt',time()-(60*60)]
                ];
                break;
            case 2:
                $where = [
                    'b.is_del'=>1,
                    'a.date'=>date('Y-m-d',time())
                ];
                break;
            case 3:
                $where = [
                    'b.is_del'=>1,
                    'a.intime'=>['gt',time()-(7*24*60*60)]
                ];
                break;
            case 4:
                $where = [
                    'b.is_del'=>1,
                    'a.intime'=>['gt',time()-(30*24*60*60)]
                ];
                break;
            case 5:
                $where = [
                    'b.is_del'=>1,
                ];
                break;
        }

        $give_list = M('Give_gift')->alias('a')
                ->field('b.user_id,b.img,b.username,b.hx_username,sum(jewel) as count,b.sex,b.grade')
                ->join('__USER__ b on a.user_id=b.user_id')
                ->group('a.user_id')
                ->where($where)
                ->order('count desc')
                ->page($page,$pageSize)
                ->select();
        // echo M('Give_gift')->getLastSql();exit;
        if ($give_list){
            foreach ($give_list as $k=>$v){
                $give_list[$k]['img'] = C('IMG_PREFIX').$v['img'];
                $is_follow = M('Follow')->where(['user_id'=>$uid,'user_id2'=>$v['user_id']])->find();
                $is_follow ? $give_list[$k]['is_follow'] = "2" : $give_list[$k]['is_follow'] = "1";

                $get_gradeinfo = get_gradeinfo($v['grade']);
                $give_list[$k]['grade_img'] = $get_gradeinfo['img'];
                $give_list[$k]['name'] = $get_gradeinfo['name'];
            }
        }else{$give_list=[];}
        success($give_list);
    }


    /**
     * @他人视频列表
     */
    public function other_video_list(){
        $user = checklogin();
        $user_id = I('user_id');
        empty($user_id) ? error('参数错误!') : true;
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $list = M('Video')
            ->alias('a')
            ->field('a.*,b.img,b.username,b.get_money')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.user_id'=>$user_id,'a.is_del'=>1])
            ->order('a.intime desc')
            ->page($page,$pageSize)
            ->select();
        if ($list){
            foreach ($list as $k=>$v){
                $list[$k]['img'] = C('IMG_PREFIX').$v['img'];
                $list[$k]['video_img'] = C('IMG_PREFIX').$v['video_img'];
                $list[$k]['url'] = C('IMG_PREFIX').$v['url'];
            }
        }else{$list=[];}
        success($list);
    }

    /**
     * @他人直播列表
     */
    public function other_live_list(){
        checklogin();
        $user_id = I('user_id');
        empty($user_id) ? error('参数错误!') : true;
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $list = M('Live_store')
            ->alias('a')
            ->field('a.*,b.img,b.sex,b.username,b.ID,b.hx_username,b.grade,b.province,b.city,b.zan,b.money,b.get_money')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.user_id'=>$user_id,'a.is_del'=>1])
            ->order('a.intime desc')
            ->page($page,$pageSize)
            ->select();
        if ($list){
            foreach ($list as $k=>$v){
                if (time()-$v['intime']<(7*24*60*60)){
                    $list[$k]['intime'] = get_times($v['intime']);
                }else{
                    $list[$k]['intime'] = $v['date'];
                }
                $list[$k]['play_img'] = domain($v['play_img']);
                $list[$k]['img'] = C('IMG_PREFIX').M('User')->where(['user_id'=>$v['user_id']])->getField('img');

                $get_gradeinfo = get_gradeinfo($v['grade']);
                $list[$k]['grade_img'] = $get_gradeinfo['img'];
                $list[$k]['name'] = $get_gradeinfo['name'];
            }
        }else{$list=[];}
        success($list);
    }


    /**
     * @举报视频
     */
    public function report_live_store(){
        $user = checklogin();
        $live_store_id = intval(I('live_store_id'));
        empty($live_store_id) ? error('参数错误') : true;
        $data = [
            'user_id'=>$user['user_id'],
            'live_store_id'=>$live_store_id,
            'intime'=>time(),
            'date'=>date('Y-m-d',time())
        ];
        if (M('Live_store_report')->add($data)){
            success('成功');
        }else{
            error('失败');
        }
    }



    /**
     * @举报
     */
    public function report(){
        $user = checklogin();
        $user_id = I('user_id'); $why = I('why');
        (empty($user_id) || empty($why)) ? error('参数错误!') : true;
        if (M('Report')->add(['user_id'=>$user['user_id'],'user_id2'=>$user_id,'why'=>$why,'intime'=>time(),'type'=>2])){
            success('成功!');
        }else{
            error('失败!');
        }
    }

    /**
     * @判断是否绑定手机号
     */
    public function is_bound_phone(){
        $user = checklogin();
        $user['phone'] ? $phone = "2" : $phone = "1";
        success($phone);
    }


    /**
     * @获取微信appsecret
     */
    public function get_secret(){
        $system = M('System')->field('appsecret')->where(['id'=>1])->find();
        success($system);
    }


/**************************************支付宝认证**********************************************************/

    /**
     * @返回生成的签名
     */
    public function get_sign(){
        $params = $_POST['params'];
        $get_sign = sign($params);
        success(rawurlencode($get_sign));
    }

    /**
     * @支付宝认证信息
     */
    public function alipay_approve(){
        $user = checklogin();
        $code = trim(I('code'));
        empty($code) ? error('参数错误!') : true;
        $system = M('System')->field('alipay_appid,alipay_privatekey,alipay_publickey')->where(['id'=>1])->find();
        import('Vendor.aop.AopClient');
        $c = new \AopClient;
        $c->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $c->appId = $system['alipay_appid'];
        $c->rsaPrivateKey = $system['alipay_privatekey'];
        $c->signType= "RSA2";
        $c->alipayrsaPublicKey = $system['alipay_publickey'];

        $request= new \AlipaySystemOauthTokenRequest();
        $request->setCode($code);
        $request->setGrantType("authorization_code");
        $response= $c->execute($request);
        $rs = json_decode($response,true);
        if ($rs['error_response']){
            error('未知错误');
        }else{
            $request2= new \AlipayUserUserinfoShareRequest();
            $response2= $c->execute($request2,$rs['alipay_system_oauth_token_response']['access_token']);
            $rss = json_decode($response2,true);
            if ($rss['error_response']){
                error('未知错误');
            }else{
                if ($rss['alipay_user_userinfo_share_response']['is_certified']=='F'){
                    error('支付宝未实名认证!');
                }elseif($rss['alipay_user_userinfo_share_response']['is_certified']=='T'){
                    $alipay = M('User_alipay')->where(['user_id'=>$user['user_id']])->find();
                    $alipay ? error('已认证过') : true;
                    $result = $rss['alipay_user_userinfo_share_response'];
                    $date = [
                        'user_id'=>$user['user_id'],
                        'avatar'=>$result['avatar'],
                        'nick_name'=>$result['nick_name'],
                        'province'=>$result['province'],
                        'city'=>$result['city'],
                        'gender'=>$result['gender'],
                        'alipay_user_id'=>$result['alipay_user_id'],
                        'user_type'=>$result['user_type'],
                        'user_status'=>$result['user_status'],
                        'is_certified'=>$result['is_certified'],
                        'is_student_certified'=>$result['is_student_certified'],
                        'intime'=>time()
                    ];
                    if (M('User_alipay')->add($date)){
                        M('User')->where(['user_id'=>$user['user_id']])->save(['is_authen'=>2,'uptime'=>time()]);
                        success('认证成功!');
                    }else{
                        error('认证失败!');
                    }
                }else{
                    error('未知错误');
                }
            }
        }
    }



    /**
     * @支付宝支付
     */
    public function get_pay_sign(){
        $user = checklogin();
        $params = $_POST['params'];
        $pay_number = I('order_number');
        $price_id = I('price_id');
        (empty($price_id) || empty($order_number) || empty($params)) ? error('参数错误!') : true;
        $price = M('Price')->find($price_id);
        $amount = $price['price'];  //金额
        $meters = $price['meters'];  //福分
        $type = 'alipay';
        M('recharge_record')->add(array('user_id'=>$user['user_id'],'pay_number'=>$pay_number,'amount'=>$amount,'meters'=>$meters,'pay_on'=>'','pay_return'=>'','pay_type'=>$type,'intime'=>time()));

        $get_sign = sign($params);
        success(rawurlencode($get_sign));
    }


    /**
     * @支付成功
     */
    public function pay_success(){
        $user = checklogin();
        $pay_number = I('order_number');
        empty($pay_number) ? error('参数错误!') : true;
        $data = array(
            "pay_on"=>$pay_number
        );
        $rec = M('recharge_record')->where(array('pay_number'=>$pay_number))->find();
        M('recharge_record')->where(array('recharge_record_id'=>$rec['recharge_record_id']))->save($data); //支付成功!
        $money = (M('User')->where(array('user_id'=>$rec['user_id']))->getField('money'))+$rec['meters'];
        M('User')->where(array('user_id'=>$rec['user_id']))->save(array('money'=>$money,'uptime'=>time()));  //修改会员钻石数量
        success('成功!');
    }

    /**
     * @支付宝支付回调
     */
    public function pay_callback(){
        $result = I();
        print_r($result);
    }


    public function btyxieyi()
     {
         $type = I('type','1');
         $db = M('shop_notice')->where(['state'=>1,'type'=>$type])->order('is_top asc')->select();
         success($db);
     }



    public function message(){
        $member = checklogin();
        $type = I('type');
        $p = I('p');
        $p  ?   $p  :   $p = 1;
        $pagesize = I('pagesize');
        $pagesize   ?   $pagesize   :   $pagesize = 10;
        $type ?    $type = $type    :   $type = 1;
        switch ($type){
            case 1://系统消息
//                $intime = date("Y-m-d H:i:s",$member['intime']);
//                $map['intime'] = ['gt',$intime];
                $map['is_delete'] = '0';
                $count = M('shop_system_notice')->where($map)->count();
                $page = ceil($count/$pagesize);
                $list = M('shop_system_notice')->field('intime,content as message,title')
                    ->where($map)->limit(($p-1)*$pagesize,$pagesize)
                    ->order('intime desc')
                    ->select();
                if(!empty($list)){
                    M('shop_message')->where(['member_id'=>$member['user_id'],'type'=>1])->save(['is_read'=>'2']);
                }else{
                    $list = [];
                }
                break;
            case 2://订单消息
                $map['member_id'] = $member['user_id'];
                $map['type'] = '2';
                $count = M('shop_message')->where($map)->count();
                $page = ceil($count/$pagesize);
                $list = M('shop_message')->field('message,intime,order_id')
                    ->where($map)->limit(($p-1)*$pagesize,$pagesize)->order('intime desc')->select();
                if(!empty($list)){
                    M('shop_message')->where($map)->save(['is_read'=>'2']);
                    foreach ($list as $k=>$v){
                        $list[$k]['goods'] = M('shop_order_goods')->alias('a')
                            ->field('a.*,b.order_no')
                            ->join('m_shop_order_merchants b ON a.order_merchants_id = b.order_merchants_id')
                            ->where(['a.order_merchants_id'=>$v['order_id']])->limit(1)->find();
                    }
                }else{
                    $list = [];
                }
                break;
            case 3://其他消息
                $map['member_id'] = $member['user_id'];
                $map['type'] = '3';
                $count = M('shop_message')->where($map)->count();
                $page = ceil($count/$pagesize);
                $list = M('shop_message')->field('message,intime,order_id')
                    ->where($map)->limit(($p-1)*$pagesize,$pagesize)->order('intime desc')->select();
                if(!empty($list)){
                    M('shop_message')->where($map)->save(['is_read'=>'2']);
                }else{
                    $list = [];
                }
                break;
        }
        success(['page'=>$page,'list'=>$list]);

    }

    /**
     * @提现记录
     */
    public function tx_list(){
        $user = checklogin();
        $list = M('withdraw_record')->where(array('user_id'=>$user['user_id']))->field('pay_return',true)->order('intime desc')->select();
        if(empty($list)){
            $list = [];
        }
        success($list);


    }


    /**
     * @关注（取消关注）

     */
    public function follow_merchants(){
        $user = checklogin();
        $user_id2 = I('user_id2');
        if(!$user_id2)      error("参数错误");
        if ($user["user_id"] == $user_id2) error("传值错误");
        $check = M('shop_follow_merchants')->where(['user_id' => $user['user_id'], 'user_id2' => $user_id2])->find();
        if ($check) {
            if ($check['is_delete'] == '1') {
                $update['is_delete'] = '2';
                $action = '取消关注成功!';

            } else {
                $update['is_delete'] = '1';
                $action = '关注成功!';
            }
            $update['uptime'] = time();
            $result = M('shop_follow_merchants')->where(['follow_id' => $check['follow_id']])->save($update);
            if ($result) {
                success($update['is_delete']);
            } else {
                error("操作失败");
            }
        } else {
            $data['user_id'] = $user['user_id'];
            $data['user_id2'] = $user_id2;
            $data['intime'] = time();
            $result = M('shop_follow_merchants')->add($data);
            if ($result) {
                success('1');
            } else {
                error("失败");
            }
        }
    }

    /**
     *@用户关注列表
     */
    public function user_follow(){
        $member = checklogin();
        $p = I('p');
        $p  ?   $p  :   $p = 1;
        $pagesize = I('pagesize');
        $pagesize   ?   $pagesize   :   $pagesize = 10;
        $where = [
            'a.user_id' =>  $member['user_id'],
            'a.is_delete'   =>  '1',
            'b.is_delete'   => '0'
        ];
        $count = M('shop_follow_merchants')->alias('a')
            ->join('m_shop_merchants b ON a.user_id2 = b.member_id')
            ->where($where)->count();
        $list =  M('shop_follow_merchants')->alias('a')
            ->field('a.follow_id,b.member_id,b.live_id,b.merchants_name,b.merchants_img,b.merchants_content,b.month_sales')
            ->join('m_shop_merchants b ON a.user_id2 = b.member_id')
            ->where($where)->order("a.intime desc")
            ->limit(($p-1)*$pagesize,$pagesize)->select();
        $page = ceil($count/$pagesize);
        success(['page'=>$page,'list'=>$list]);
    }

    /**
     *@取消关注
     */
    public function del_user_follow(){
        $member = checklogin();
        $follow_id = I('follow_id');
        if(!$follow_id)         error("参数错误");
        $result = M('shop_follow_merchants')->where(['user_id'=>$member['user_id'],'follow_id'=>$follow_id])->save(['is_delete'=>'2','uptime'=>time()]);
        if($result){
            success("操作成功");
        }else{
            error("操作失败");
        }
    }

    /**
     *@取消关注
     */
    public function del_all_follow(){
        $member = checklogin();
        $result = M('shop_follow_merchants')->where(['user_id'=>$member['user_id']])->save(['is_delete'=>'2','uptime'=>time()]);
        if($result){
            success("操作成功");
        }else{
            error("操作失败");
        }
    }

    /**
     *@判断是否有未读消息
     */
    public function has_message(){
        $member = checklogin();
        // $map[] = ['exp','FIND_IN_SET('.$member['type'].',object)'];
        $map['is_delete'] = '0';
        $map['state'] = '2';
        $check = M('shop_message')->where(['type'=>'1','member_id'=>$member['user_id']])->getField('system_notice_id',true);
        $notice = M('shop_system_notice')->where($map)->getField('id',true);
        
        // echo M()->getLastSql();exit;

        $list = array_diff($notice,$check);
        if($list){
            $intime = date("Y-m-d H:i:s",time());
            foreach ($list as $v){
                $message[]=[
                    'type' => '1',
                    'member_id' =>  $member['user_id'],
                    'system_notice_id'   =>  $v,
                    'intime'    => $intime
                ];
            }
            if($message){
                M('shop_message')->addAll($message);
            }
            success('1');
        }else{
            $count = M('shop_message')->where(['member_id'=>$member['user_id'],'is_read'=>'1'])->count();
            if($count){
                success('1');
            }else{
                success('2');
            }
        }
    }


    /**
     *@优惠券领券中心
     */
    public function coupon(){
        $uid = I('uid');
        $p = I('p');
        empty($p) && $p = 1;
        $pagesize = I('pagesize');
        $pagesize ? $pagesize : $pagesize = 10;
        $where['is_delete'] = '0';
        $where['status'] = '2';
        $where['end_strtotime'] = ['gt',time()];
        $count = M('shop_coupon')->where($where)->count();
        $list = M('shop_coupon')->field('coupon_id,title,start_time,end_time,value,balance,number,type,merchants_id')
              ->where($where)->order('intime desc')->select();
        $page = ceil($count/$pagesize);
        if(!empty($uid)) {
            $member_coupon = M('shop_member_coupon')->where(['member_id' => $uid])->getField('coupon_id',true);
        }else{
            $member_coupon = [];
        }
        foreach($list as $k=>$v){
            if($v['type'] == 2){
                $merchants = M('shop_merchants')->where(['merchants_id'=>$v['merchants_id']])->find();
                $list[$k]['merchants_name'] = $merchants['merchants_name'];
                $list[$k]['merchants_img'] = $merchants['merchants_img'];
            }else{
                $list[$k]['name'] = '通用优惠券';
                $list[$k]['merchants_name'] = '';
                $list[$k]['merchants_img'] = '';
            }
            if(in_array($v['coupon_id'],$member_coupon)){
                $list[$k]['is_check'] = '1';
            }else{
                $list[$k]['is_check'] = '2';
            }
        }
        success(['page'=>$page,'list'=>$list]);

    }

    /**
     *@领取优惠券
     */
    // public function draw_coupon(){
    //     if(IS_POST){
    //         $member = checklogin();
    //         $coupon_id = I('coupon_id');
    //         if(empty($coupon_id))          error("参数错误");
    //         $coupon = M('shop_coupon')->where(['coupon_id'=>$coupon_id])->find();
    //         if(!$coupon)                   error('参数错误');
    //         if($coupon['balance']<=$coupon['number'])    error("该优惠券没有库存");
    //         $map['coupon_id'] = $coupon_id;
    //         $map['member_id'] = $member['user_id'];
    //         $check = M('shop_member_coupon')->where($map)->find();
    //         if($check)                  error("已领取，不能重复领取");
    //         M('shop_coupon')->where(['coupon_id'=>$coupon_id])->setInc('number');
    //         $data['coupon_id'] = $coupon_id;
    //         $data['member_id'] = $member['user_id'];
    //         $data['intime'] = date("Y-m-d H:i:s",time());
    //         $data['start_strtotime'] = $coupon['start_strtotime'];
    //         $data['end_strtotime'] = $coupon['end_strtotime'];
    //         $result = M('shop_member_coupon')->add($data);
    //         if($result){
    //             if($coupon['number']>$coupon['balance']){
    //                 M('shop_coupon')->where(['coupon_id'=>$coupon_id])->setInc('balance');
    //             }
    //             success("领取成功");
    //         }else{
    //             error("领取失败");
    //         }
    //     }
    // }

    /**
     * @领取优惠券
     */
    public function draw_coupon(){
        if(IS_POST){
            $member = checklogin();
            $coupon_id = I('coupon_id');
            if(empty($coupon_id))          error("参数错误");
            $coupon = M('shop_coupon')->where(['coupon_id'=>$coupon_id])->find();
            if(!$coupon)                   error('参数错误');
            if($coupon['balance']<=0)    error("该优惠券没有库存");
            $map['coupon_id'] = $coupon_id;
            $map['member_id'] = $member['user_id'];
            $check = M('shop_member_coupon')->where($map)->find();
            if($check)                  error("已领取，不能重复领取");
            M('shop_coupon')->where(['coupon_id'=>$coupon_id])->setInc('number');
            $data['coupon_id'] = $coupon_id;
            $data['member_id'] = $member['user_id'];
            $data['intime'] = date("Y-m-d H:i:s",time());
            $data['start_strtotime'] = $coupon['start_strtotime'];
            $data['end_strtotime'] = $coupon['end_strtotime'];
            $result = M('shop_member_coupon')->add($data);
            if($result){
                if($coupon['balance']>0){
                    M('shop_coupon')->where(['coupon_id'=>$coupon_id])->setDec('balance');
                }
                success("领取成功");
            }else{
                error("领取失败");
            }
        }
    }

    /**
     *@优惠券
     * @param $status 1未使用；2已使用；3已过期
     */
    public function my_coupon()
    {
        $member = checklogin();
        $status = I('status');
        $status ? $status : $status = '1';
        $data = M('shop_member_coupon')->alias('a')
            ->field('a.intime,b.end_time,b.end_strtotime,a.id')
            ->join('m_shop_coupon b ON a.coupon_id = b.coupon_id')
            ->where(['a.member_id' => $member['user_id'], 'a.status' => '1', 'b.is_delete' => '0', 'b.status' => '2'])->select();
        if(!$data){
            foreach ($data as $key => $val) {
                if (time() > $val['end_strtotime']) {
                    M('shop_member_coupon')->where(['id' => $val['id']])->save(['status' => 3]);
                }
            }
        }else{
            $data = [];
        }
        
        $p = I('p');
        empty($p) && $p = 1;
        $pagesize = I('pagesize');
        $pagesize ? $pagesize : $pagesize = 10;
        $count = M('shop_member_coupon')->alias('a')
            ->field('a.id,b.title,b.img,b.limit_value,b.value,b.start_strtotime as start_time,b.end_strtotime as end_time,b.type,b.merchants_id')
            ->join('m_shop_coupon b ON a.coupon_id = b.coupon_id')
            ->where(['a.member_id' => $member['user_id'], 'a.status' => $status, 'b.is_delete' => '0', 'b.status' => '2'])
            ->count();
        $list = M('shop_member_coupon')->alias('a')
            ->field('a.*,b.title,b.img,b.limit_value,b.value,b.type,b.merchants_id,b.start_strtotime as start_time,b.end_strtotime as end_time')
            ->join('m_shop_coupon b ON a.coupon_id = b.coupon_id')
            ->where(['a.member_id' => $member['user_id'], 'a.status' => $status, 'b.is_delete' => '0', 'b.status' => '2'])
            ->order('a.intime desc')->limit(($p - 1) * $pagesize, $pagesize)->select();

        $page = ceil($count / $pagesize);
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                if ($v['type'] == 2) {
                    $merchants = M('shop_merchants')->where(['member_id' => $v['merchants_id']])->find();
                    $list[$k]['merchants_name'] = $merchants['merchants_name'];
                    $list[$k]['merchants_img'] = $merchants['merchants_img'];
                } else {
                    $list[$k]['name'] = '通用优惠券';
                    $list[$k]['merchants_name'] = '';
                    $list[$k]['merchants_img'] = '';
                }
            }
        }else{
            $list = [];
        }
        success(['page'=>$page,'list'=>$list]);
    }


    /**
     *@确认订单优惠券
     */

     public function confirm_coupon(){
         $member = checklogin();
         $amount = I('amount');
         if(!$amount)           error("参数错误");
         $merchants = I('merchants');
         //!empty($merchants)   &&      $map['merchants_id'] = ['in',$merchants];
         $data = M('shop_member_coupon')->alias('a')
             ->field('a.intime,b.end_time,b.end_strtotime,a.id')
             ->join('m_shop_coupon b ON a.coupon_id = b.coupon_id')
             ->where(['a.member_id'=>$member['user_id'],'a.status'=>'1','b.is_delete'=>'0','b.status'=>'2'])->select();
         foreach($data as $key=>$val){
             if(time()>$val['end_strtotime']){
                 M('shop_member_coupon')->where(['id'=>$val['id']])->save(['status'=>3]);
             }
         }
         $map['a.member_id'] = $member['user_id'];
         $map['a.status']    = '1';
         $map['b.is_delete'] = '0';
         $map['b.status'] = '2';
         $map['b.limit_value'] = ['elt',$amount];
         $list = M('shop_member_coupon')->alias('a')
             ->field('a.id,b.title,b.img,b.limit_value,b.value,b.start_strtotime as start_time,b.end_strtotime as end_time,b.type,b.merchants_id')
             ->join('m_shop_coupon b ON a.coupon_id = b.coupon_id')
             ->where($map)->order('a.intime desc')->select();
         if (!empty($list)) {
             foreach ($list as $k => $v) {
                 if ($v['type'] == 2) {
                     $merchants = M('shop_merchants')->where(['member_id' => $v['merchants_id']])->find();
                     $list[$k]['merchants_name'] = $merchants['merchants_name'];
                     $list[$k]['merchants_img'] = $merchants['merchants_img'];
                 } else {
                     $list[$k]['name'] = '通用优惠券';
                     $list[$k]['merchants_name'] = '';
                     $list[$k]['merchants_img'] = '';
                 }
             }
         }
         success($list);
     }

     /**
      * 我的视频
      */
        
    public function my_video(){
        $user = checklogin();
        $page = I('page');   $pageSize = I('pagesize');
        $page ? $page : $page = 1;   $pageSize ? $pageSize : $pageSize = 10;

        $map['type'] = 4;
        $map['is_del'] = 1;
        $map['user_id'] = I('uid');
        $list = M('activity')
              ->where($map)
              ->order('intime desc')
              ->page($page,$pageSize)
              ->select();
        if(empty($list)){
            $list = [];
        }

        success($list);

    }

    /**
     * @删除视频
     */
    public function del_myvideo(){
        $user = checklogin();
        $id = I('id');
        empty($id) ? error('参数错误!') : true;
        if (M('activity')->where(['a_id'=>['in',$id]])->save(['is_del'=>2,'intime'=>time()])){
            success('成功');
        }else{
            error('失败!');
        }
    }

    /**
     *
     * @我的直播记录
     */
    public function my_live(){
        $user = checklogin();
        $page = I('page');   $pageSize = I('pagesize');
        $page ? $page : $page = 1;   $pageSize ? $pageSize : $pageSize = 10;

        $map['is_del'] = 1;
        $map['user_id'] = I('uid');
        $list = M('live_store')
              ->where($map)
              ->order('intime desc')
              ->page($page,$pageSize)
              ->select();
        if(empty($list)){
            $list = [];
        }else{
            foreach ($list as $key => &$val) {
                $val['play_img'] = domain($val['play_img']);
                $val['intime'] = date('Y-m-d H:i:s',$val['intime']);
            }
        }

        success($list);
    }

    /**
     * @删除我的直播记录
     */
    public function del_mylive(){
        $user = checklogin();
        $id = I('id');
        empty($id) ? error('参数错误!') : true;
        if (M('live_store')->where(['live_store_id'=>['in',$id]])->save(['is_del'=>2,'intime'=>time()])){
            success('成功');
        }else{
            error('失败!');
        }
    }

    /**
     * @主播资料
     */
    public function anchor_info(){
        $uid = I('uid');
        $user_id = I('user_id');
        empty($user_id) ? error('参数错误!') : true;

        $u = M('user')->where(array('user_id'=>$user_id))->field('user_id,img,username,autograph,province,city,area,address,hx_username')->find();
        $u['img'] = domain($u['img']);
        $u['fans'] = M('follow')->where(array('user_id2'=>$user_id,'is_delete'=>1))->count();
        if($uid){
            $res = M('follow')->where(array('user_id'=>$uid,'user_id2'=>$user_id,'is_delete'=>1))->count();
            if($res>0){
                $u['follow'] = 2;//已关注
            }else{
                $u['follow'] = 1;//未关注
            }

        }else{
            $u['follow'] = 1;//未关注
        }
        success($u);

    }

    /**
     * @主播资料页查询直播，录播
     */
    public function anchor_activity(){
        $user_id = I('user_id');
        // $where = [];
        $where['type'] = ['in', '1,2'];
        $where['is_del'] = 1;
        $list = M('activity')->where(array('user_id'=>$user_id))->where($where)->field('a_id,title,play_time,type')->order('type desc,intime desc')->select();

        if(!$list){
            $list = [];
        }
        success($list);

    }


    /**
     * @主播资料页的回放
     */
    public function anchor_store(){
        $user_id = I('user_id');
        $uid = I('uid');
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;

        $where['a.type'] = ['in', '3,4,5,6'];
        $where['a.is_del'] = 1;
        $where['a.user_id'] = $user_id;

        // $list = M('activity')
        //       ->where(array('user_id'=>$user_id))
        //       ->where($where)->field('a_id,title,play_time,type,img')
        //       ->order('intime desc')
        //       ->page($page,$pageSize)
        //       ->select();
        $list = M('Activity')
                ->alias('a')
                ->field('a.*,b.phone,b.img as header_img,b.sex,b.username,b.ID,b.hx_username,b.grade,b.province,b.city,b.zan,b.money,b.get_money,b.url')
                ->join('__USER__ b on a.user_id=b.user_id')
                ->where($where)
                ->order('intime desc')
                ->page($page,$pageSize)
                ->select();

        if ($list){
            foreach ($list as $k=>$v){
                $list[$k]['img'] = domain($v['img']);
                $list[$k]['header_img'] = domain($v['header_img']);

                /*检测是否收藏*/
                    $list[$k]['is_collect'] = '2';
                    if (!empty($uid)) {
                        $map['member_id'] = $uid;
                        $map['a_id'] = $v['a_id'];
                        $map['is_delete'] = '1';
                        $check = M('activity_collection')->where($map)->find();
                        if ($check) {
                            $list[$k]['is_collect'] = '1';
                        }

                    }

            }
        }else{$list=[];}
        success($list);
    }

    /**
     * 用户销售收益记录列表
     * 
     */
    public function user_income(){
        $u = checklogin();
        $uid = I('uid');
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        //收益记录
        $list = M('shop_per')->alias('a')
              ->join('m_shop_order_goods b ON a.order_goods_id = b.order_goods_id')
              ->join('m_shop_order_merchants c ON b.order_merchants_id = c.order_merchants_id')
              ->join('m_activity d ON a.a_id = d.a_id','LEFT')
              ->field('a.*,b.goods_name,b.goods_img,b.specification_price,b.goods_num,b.create_time,c.order_no,d.title,d.intime,d.type')
              ->where(array('a.anchor_id'=>$uid))
              ->order('time desc')
              ->page($page,$pageSize)
              ->select();
        if($list){
            foreach ($list as $k => &$v) {
                $v['time'] = date('Y-m-d H:i:s',$v['time']);
                if($v['a_id'] == 0){
                    $v['title'] = '';
                    $v['intime'] = '';
                    $v['type'] = '';
                }else{
                    $v['intime'] = date('Y-m-d H:i:s',$v['intime']);

                }
                
                $v['merchants_name'] = M('shop_merchants')->where(array('member_id'=>$v['member_id']))->getField('merchants_name');

                
            }
            
        }else{
            $list = [];
        }

        success($list);

    }

    /**
     * 用户销售收益
     * 
     */
    public function income(){
        $u = checklogin();
        $uid = I('uid');
        // $u = M('user')->where(['user_id'=>$uid])->find();
        //总收益（结算完成的）
        $map['anchor_id'] = $uid;
        $map['settle'] = 2;//结算完成
        $list = [];
        $list['sum_end'] = M('shop_per')
                     ->where($map)
                     ->sum('anchor');
        if($list['sum_end'] == null){
            $list['sum_end'] = '0.00';
        }
        //待结算
        $ma['anchor_id'] = $uid;
        $ma['settle'] = 1;//待结算
        $list['sum_wait'] = M('shop_per')
                     ->where($ma)
                     ->sum('anchor');
        if($list['sum_wait'] == null){
            $list['sum_wait'] = '0.00';
        }
        //收益余额
        $list['seller_money'] = $u['seller_money'];
        //已提现
        $list['tx_end'] = M('withdraw_income')->where(['user_id'=>$uid,'type'=>2])->sum('amount');
        if($list['tx_end'] == null){
            $list['tx_end'] = '0.00';
        }
        //正在提现
        $list['ready_end'] = M('withdraw_income')->where(['user_id'=>$uid,'type'=>1])->sum('amount');
        if($list['ready_end'] == null){
            $list['ready_end'] = '0.00';
        }
        success($list);
    }

    /**
     * @活动收益记录
     */
    public function activity_income(){
        $u = checklogin();
        $uid = I('uid');
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $list = M('give_gift')->alias('a')
              ->join('m_gift b ON a.gift_id = b.gift_id')
              ->where(array('a.user_id2'=>$uid))
              ->field('a.give_gift_id,a.user_id,a.live_id,a.user_id2,a.gift_id,FROM_UNIXTIME(a.intime) as intime,a.jewel,a.experience,a.type,a.number,(jewel * number) as sum,b.name,b.img')
              ->order('a.intime desc')
              ->page($page,$pageSize)
              ->select();
        if($list){
            foreach ($list as $k => &$v) {
                $v['img'] = domain($v['img']);
                //查询活动标题，封面
                $a_id = M('live')->where(['live_id'=>$v['live_id']])->getField('a_id');
                $res = M('activity')->where(['a_id'=>$a_id])->field('title,img')->find();
                if($res){
                    $v['title'] = $res['title'];
                    $v['a_img'] = domain($res['img']);
                }else{
                    $v['title'] = '';
                    $v['a_img'] = '';
                }
            }
        }else{
            $list = [];
        }
        success($list);

    }

    /**
     * 活动收益（钻石）
     */
    public function earnings(){
        $u = checklogin();
        $uid = I('uid');
        // $u = M('user')->where(['user_id'=>$uid])->find();
        $list = [];
        //总收益
        $list['all'] = M('give_gift')->where(['user_id2'=>$uid])->sum('jewel * number');
        if($list['all'] == null){
            $list['all'] = '0';
        }
        //余额
        $list['get_money'] = $u['get_money'];
        //已提现
        $list['tx_end'] = M('withdraw_record')->where(['user_id'=>$uid,'type'=>2])->sum('total_number');
        if($list['tx_end'] == null){
            $list['tx_end'] = '0';
        }
        //正在提现
        $list['ready_end'] = M('withdraw_record')->where(['user_id'=>$uid,'type'=>1])->sum('total_number');
        if($list['ready_end'] == null){
            $list['ready_end'] = '0';
        }
        success($list);
        //

    }






    public function demo(){
        echo md5('123456');
    }

}