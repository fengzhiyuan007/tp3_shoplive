<?php

namespace App\Controller;
use Qiniu\Pili\Mac;
use Think\Controller;
use JPush\Client as JPush;
use Think\Upload;
class IndexController extends CommonController {


    public function erweimai(){
        $url = "weixin://wxpay/bizpayurl?pr=Zrr5Fyh";
        $qrcode_path = "./Public/" . time() . rand(100, 999) . '_qrcode.png';
        qrcode($url, $qrcode_path, 3, 4);
    }


    public function weixin(){
        header("Content-type: text/html; charset=utf-8");
        if(!isset($_GET['code'])){
            $APPID='wx46e268c7797cae0b';
            $REDIRECT_URI='http://www.duluozb.com/App/Index/weixin';
            $scope='snsapi_base';
            $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state=wx'.'#wechat_redirect';
            header("Location:".$url);
        }else{
            $appid = "wx46e268c7797cae0b";
            $secret = "f9f95e49f91333257696b50257a2535d";
            $code = $_GET["code"];
            $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$get_token_url);
            curl_setopt($ch,CURLOPT_HEADER,0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            $res = curl_exec($ch);
            curl_close($ch);
            $json_obj = json_decode($res,true);
            //根据openid和access_token查询用户信息
            $access_token = $json_obj['access_token'];
            $openid = $json_obj['openid'];
            $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';

            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$get_user_info_url);
            curl_setopt($ch,CURLOPT_HEADER,0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            $res = curl_exec($ch);
            curl_close($ch);

            //解析json
            $user_obj = json_decode($res,true);
            print_r($user_obj);
        }
    }

    /**
     * @获取access_token
     * @获取用户列表
     */
    public function get_access_token(){
        $appid = "wx46e268c7797cae0b";
        $secret = "f9f95e49f91333257696b50257a2535d";
        //$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
        $get_token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret.'';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$get_token_url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        $json_obj = json_decode($res,true);
        $list = $this->get_list($json_obj['access_token']);
        foreach ($list as $k=>$v){
            set_time_limit(0);
            M('Withdraw_wechat')->add(['openid'=>$v['openid'],'nickname'=>$v['nickname'],'sex'=>$v['sex'],'province'=>$v['province'],'city'=>$v['city'],'hearimgurl'=>$v['headimgurl'],'unionid'=>$v['unionid'],'intime'=>time()]);
        }
        print_r($list);
    }

    public function get_list($access_token){
        $next_openid = '';
        $get_token_url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$access_token.'&next_openid='.$next_openid.'';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$get_token_url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        $json_obj = json_decode($res,true);
        $arr = $json_obj['data']['openid'];
        $info = [];
        foreach ($arr as $k=>$v){
            $get_token_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$v.'&lang=zh_CN';
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$get_token_url);
            curl_setopt($ch,CURLOPT_HEADER,0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            $res = curl_exec($ch);
            curl_close($ch);
            $jsons = json_decode($res,true);
            $info[] = $jsons;
        }
        return $info;
    }












    public function test(){
        echo get_number();die;
//        $content = "您关注的11212开播啦，一起来，涨姿势，享健康~";
//        $alias = ['vae3xs3iermy','34l5b4zp2nka'];
//        push5(1,$content,$b['alias'],json_encode($live[$k]));
    }
    /**
     * @给聊天室发消息
     */
    public function send(){
//        $get_gradeinfo = get_gradeinfo(1);
//        $ext = [
//            'user_id'=>80,
//            'username'=>'爱你的玫瑰',
//            'userimg'=>C('IMG_PREFIX').'/Public/admin/Uploads/touxiang/eae4a64b9d3fa2f216487e1ceef1769f.jpg',
//            'intoroom'=>'16169533767681',
//            'usergrade'=>'1',
//            'authName'=>'111'
//        ];
//        //hx_send($fans[0]['hx_username'],$v['room_id'],"进入了直播间",$ext);   //给聊天室发消息
//       print_r(hx_send($fans[0]['hx_username'],$v['room_id'],"进入了直播间",$ext));
    }
    /**
     * @添加聊天室成员
     */
    public function addcreatroom(){
        $roomid = "14009903415299";
        $username = "dhuu2dqw7slx";
        $arr = adduserChatRoom($username,$roomid);
        print_r($arr);
    }


    /**
     * @支付宝
     */
    public function zhifu(){
        import('Vendor.aop.AopClient');
        $c = new \AopClient;
        $c->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $c->appId = "2017032306364899";
        $c->rsaPrivateKey = "MIIEowIBAAKCAQEAnblAtY601gwGLxnjOvH+2T3QXyW7c6cOSXwzeCDdMZgMEpzSucJYlW0XDvDsu6jBvL868ptc0cTXZfs6pFrvhKZubP3n42xyXgxj9Tyvy9hE70HqU7d8CN1lPvPw2eZ5lYuHZOogDBjfpKZfE9XtVOdFhAbfp5A2L5yZMELGkMOxdAnJjPvYX/N6fX+1VNAfVobNS8nd63/2H7g+IBNhwKT6yNwx+y6S4xvbxVRnfYhUzYVxEkaJvJtbYzJ5LtqEh10gKAoekX6ngThFPOea2lb4neKu50QP0ySeU2vllmWd89PJHRyrOxPTMXYhRN+mEGItRLYQBMr9owKGhaiGQwIDAQABAoIBAQCYfnh2Edf96/o+qATvBPKmEAHbPJwUobxKiG8rAntaa+ugQ0fqmmETeDoHFCGO/wbx+uJ/ln8TwgGQdGqqZdGWq2OwtXzygfPBwrESdu5xZFSiD1UERC8EUyqEx05jH1cGo7TweP0rNRFmHAVpJDknEcRAdnTfiasaNYpXAvkBFO9fVkLemcAF3uInib1WEHTLfWUjMiqAzFSLmNxL98U1sT8kXNgsc4QPLBT1+ctyAaGeU2sYNi9W5CABbRPBsar6euQIJAWHaBl2D5gcKOAeZmS86FXYPvjdbWY+kZ7sRC/hTr+5LAWW7DE86CeyLUU3j/GKg16uIj5nr8AzZfqBAoGBAM2aDQhiS/lsQz9U1b1Yon5UZvqGGGA21gxo2/lM+oAInNXU5Jw1QPTdVvSZPZy2HiwtOB7eQvEcP6ci8bCMd3O6ArUmoik0DrGMSSfqXMXKQ+Fvh8+PAt7OyVNFz52xctQZm3h/O5izB7R/Qq0sS4lG4Yl6vd3Bal+yPJ86fy7TAoGBAMRiv3LREvDgI3S+1CDOujbuLFyF1FezPw28jzcuhHVCW0mIubhaAkz/pMqXi72XvJAmsHoOhCv1TOvvI372j8/FdZLkzTbJD3I5GF0gHgWYkq6TjFx5UOEBGWQ/Zt0xx4rJqTFIGYriN11xeOCCDgvtogXsHPkY2usNE+UdiATRAoGADkb/VrC0w+pPtSsn+JEaH5mu2QDM2omUTaJOfD5rOs7eTT8ObQaJrzdbnXqyu5ot+DVfq00V6vZiOTIFBJSMiv3EyF2ZbzENQCkUv2/X52hHVHVRQgmVUnGbq2uyoim7Zp0sna6ALfdotpELyUjFKhBBAzIB009mGqUe7pO6Vz8CgYBzAIiwSfLXj8nzkdRTKfwuMqdTvyMsAFGKT8NmQx1aNXOTyjdH153FTWdJJBm2+uZ3W9C4iUupGkrjVvToYqawuycw0D/EN1WORBUaY7Zw/HnZNZpahMhyGtytsdsg6Qe7JICp1Vjv1a0qUUrB3icvoQbihPQqgv2f69acswB2IQKBgGzRqeaHi6Ip64YN2I2mLm4hlDYLMXpacZEFW4tW+9eecme5R4ylssnnuxTqjEibZmkyLZAprrKKx57P6FiToF44Ldx6rikk/IkEMMy9t4HKyMiU61BLXsQ6PqdaJ5Ddb9j6XlCC+VAwbZs+FbEAu4pgvoU6cILHh9iDyjIPsmpS" ;
        $c->signType= "RSA2";
        $c->alipayrsaPublicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnblAtY601gwGLxnjOvH+2T3QXyW7c6cOSXwzeCDdMZgMEpzSucJYlW0XDvDsu6jBvL868ptc0cTXZfs6pFrvhKZubP3n42xyXgxj9Tyvy9hE70HqU7d8CN1lPvPw2eZ5lYuHZOogDBjfpKZfE9XtVOdFhAbfp5A2L5yZMELGkMOxdAnJjPvYX/N6fX+1VNAfVobNS8nd63/2H7g+IBNhwKT6yNwx+y6S4xvbxVRnfYhUzYVxEkaJvJtbYzJ5LtqEh10gKAoekX6ngThFPOea2lb4neKu50QP0ySeU2vllmWd89PJHRyrOxPTMXYhRN+mEGItRLYQBMr9owKGhaiGQwIDAQAB";

        $request= new \AlipaySystemOauthTokenRequest();
        $request->setCode("e574614297fa44dfa562d2806c77VX28");
        $request->setGrantType("authorization_code");
        $response= $c->execute($request);
        $rs = json_decode($response,true);
        //echo $rs['alipay_system_oauth_token_response']['access_token'];
        //dump($rs);die;
        $request2= new \AlipayUserUserinfoShareRequest();
        $response2= $c->execute($request2,"kuaijieBf8bbee1dc6cf4364ab3e9d8ae9738C16");
        $rss = json_decode($response2,true);
        dump($rss);die;
    }

    /**
     * @等比例压缩
     */
    public function yasuo(){
        $filename = "./Public/admin/touxiang.png";
        $image = new \Think\Image();
        $image->open($filename);
       // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
        $path = './Public/'.time().'.jpg';
        $image->thumb(50, 50)->save($path);

    }


    /**
     * @七牛创建房间
     */
    public function creatroom(){
        $qiniu_room_id = time().rand(100, 999);
        $qiniu_room_name = GetfourStr(6);
        //$create_room = creatroom("901",$qiniu_room_name);    //七牛创建房间
        $system = M('System')->where(['id'=>1])->find();
        import('Vendor.Qiniu.Pili');
        $ak = $system['ak'];
        $sk = $system['sk'];
        //创建hub
        $mac = new \Qiniu\Pili\Mac($ak, $sk);
        $client = new \Qiniu\Pili\RoomClient($mac);
        try {
            $resp = $client->createRoom($qiniu_room_id, $qiniu_room_name);

            $resp = $client->getRoom($qiniu_room_name);
            print_r($resp);
            die();

//            $resp = $client->deleteRoom($qiniu_room_name);
//             dump($resp);

//            //鉴权的有效时间: 1个小时.
            $resp = $client->roomToken($qiniu_room_name, $qiniu_room_id, 'admin', (time()+3600*24*30));
            echo ($resp);die;
        } catch (\Exception $e) {
           // echo "Error:", $e, "\n";
        }
        $result = push_address();

        dump($result);

    }

    /**
     * @全部替换环信账号
     */
    public function changehx(){
        $page = I('page'); $pageSize = I('pagesize');
        $list = M('user')->field('user_id,hx_username,hx_password')->page($page,$pageSize)->select();
        foreach ($list as $key => &$v) {
            $re = $this->hx_zhuce();
            $data['hx_username'] = $re['hx_username'];
            $data['alias'] = $re['hx_username'];
            $re = M('user')->where(['user_id'=>$v['user_id']])->save($data);
        }
    }


    /**
     * @随机注册环信账号
     */
    public function hx_zhuce(){
        $chars = "abcdefghijklmnopqrstuvwxyz123456789";
        mt_srand(10000000*(double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < 12; $i++){
            $str .= $chars[mt_rand(0, $lc)];
        }
        $hx_password="123456";
        huanxin_zhuce($str,$hx_password); //环信注册
        $result = ['hx_username'=>$str,'hx_password'=>$hx_password];
        return $result;
    }
    /**
     * @根据环信用户名，返回用户信息
     */
    public function get_user_info(){
        $hx_username = I('hx_username');
        if (empty($hx_username)) {
            error("不存在");
        } else {
            $user = M('User')->field('user_id,username,company,duty,img,sex,hx_username,ID,grade')->where(['hx_username' => $hx_username])->find();
            $user['img'] = C('IMG_PREFIX') . $user['img'];
            $get_gradeinfo = get_gradeinfo($user['grade']);
            $user['grade_img'] = $get_gradeinfo['img'];
            $user['name'] = $get_gradeinfo['name'];
            success($user);
        }
    }
    /**
     * @判断是否认证
     */
    public function is_user(){
        $user = checklogin();
        success($user['is_authen']);
    }

    /**
     * @创建活动  预播
     */
    public function create_activity(){
        $user = checklogin();

        if ($user['is_banned']!=1){error('已被禁播');}

        $data = [];
        $data['title'] = I('title')?I('title'):'';
        $data['img'] = I('img')?I('img'):$user['img'];
        $data['img'] = domain($data['img']);

        $aa = getimagesize($data['img']);
        $data['img_width'] = $aa[0];
        $data['img_height'] = $aa[1];

        $data['summary'] = I('summary')?I('summary'):'';
        $data['log'] = I('log')?I('log'):'';
        $data['lag'] = I('lag')?I('lag'):'';
        $data['tag'] = I('tag')?I('tag'):'';
        $data['type'] = I('type');
        $data['user_id'] = I('uid');
        $data['goods_id'] = I('goods_id')?I('goods_id'):'';
        $data['intime'] = time();
        $data['plate'] = I('plate')?I('plate'):'';

        if ($data['log'] && $data['lag']){
            $gwd = $data['lag'].','.$data['log'];
            $baidu_apikey = M('System')->getFieldById(1,'baidu_apikey');
            $file_contents = file_get_contents('http://api.map.baidu.com/geocoder/v2/?ak='.$baidu_apikey.'&location='.$gwd.'&output=json');
            $rs = json_decode($file_contents,true);
            $data['sheng'] = $rs['result']['addressComponent']['province'];
            $data['shi'] = $rs['result']['addressComponent']['city'];
            $data['qu'] = $rs['result']['addressComponent']['district'];
            $data['address'] = $rs['result']['formatted_address'];
        }

        switch ($data['type']) {
            case '1':
                $user['username'] ? $name = $user['username'] : $name = "直播间" . rand(100, 999);
                $options = [
                    'name' => $name,
                    'description' => $name,
                    'maxusers' => 3000,
                    'owner' => $user['hx_username']
                ];
                $create = createChatRoom($options);
                // print_r($create);exit;
                $create['error'] ? error('创建聊天室失败!') : true;
                $data['room_id'] = $create['data']['id'];

                $data['url'] = I('url');
                $data['play_time'] = I('play_time');
                // (empty($data['url'])) ? error('视频不能为空!') : true;
                
                $res = M('activity')->add($data);

                //添加直播商品
                if($data['goods_id']){
                    $create_time = date("Y-m-d H:i:s",time());
                    $goods_id = explode(',',$data['goods_id']);
                    foreach ($goods_id as $v){
                        $merchants_id = M("shop_goods")->where(["goods_id"=>$v])->getField('merchants_id');
                        $live_goods = [
                            'goods_id' => $v,
                            'member_id' =>  $user['user_id'],
                            'create_time'=> $create_time,
                            'merchants_id'=> $merchants_id,
                            'a_id'=>$res
                        ];
                        M('shop_live_goods')->add($live_goods);
                    }
                }

                break;
            case '4':
                $data['url'] = I('url');
                (empty($data['url'])) ? error('视频不能为空!') : true;

                empty($data['tag']) ? error('标签不能为空!') : true;
                
                $res = M('activity')->add($data);

                //添加直播商品
                if($data['goods_id']){
                    $create_time = date("Y-m-d H:i:s",time());
                    $goods_id = explode(',',$data['goods_id']);
                    foreach ($goods_id as $v){
                        $merchants_id = M("shop_goods")->where(["goods_id"=>$v])->getField('merchants_id');
                        $live_goods = [
                            'goods_id' => $v,
                            'member_id' =>  $user['user_id'],
                            'create_time'=> $create_time,
                            'merchants_id'=> $merchants_id,
                            'a_id'=>$res
                        ];
                        M('shop_live_goods')->add($live_goods);
                    }
                }

                break;
            case '5':
                $data['imgs'] = $data['img'];

                $res = M('activity')->add($data);

                //添加直播商品
                if($data['goods_id']){
                    $create_time = date("Y-m-d H:i:s",time());
                    $goods_id = explode(',',$data['goods_id']);
                    foreach ($goods_id as $v){
                        $merchants_id = M("shop_goods")->where(["goods_id"=>$v])->getField('merchants_id');
                        $live_goods = [
                            'goods_id' => $v,
                            'member_id' =>  $user['user_id'],
                            'create_time'=> $create_time,
                            'merchants_id'=> $merchants_id,
                            'a_id'=>$res
                        ];
                        M('shop_live_goods')->add($live_goods);
                    }
                }

                break;
            default:
                error('活动类型错误');
                break;
        }
        

        // $res = M('activity')->add($data);



        if($res){
            success(['a_id'=>$res]);
        }else{
            error('活动创建失败');
        }


    }

    /**
     * @开启直播------新
     */
    public function start_activity(){
        $u = checklogin();
        $a_id = I('a_id');
        (empty($a_id)) ? error('参数错误!') : true;
        $activity = M('activity')->where(array('a_id'=>$a_id))->find();

        if($activity['type'] != 1){
            error('活动类型错误');
        }

        if ($activity['img']){
            $play_img = $activity['img'];
        }else{
            $play_img = $u['img'];
        }
        $play_address = push_address(); //七牛生成流地址
        $qiniu_room_id = time().rand(100, 999);
        $qiniu_room_name = GetfourStr(6);
        $create_room = creatroom($qiniu_room_id,$qiniu_room_name);    //七牛创建房间
        $time = time();
        $data = [
            'user_id'=>$u['user_id'],
            'play_img'=>$play_img,
            'title'=>$activity['title'],
            'push_flow_address'=>$play_address['url'],
            'play_address'=>$play_address['url2'],
            'play_address_m3u8'=>$play_address['m3u8'],
            'start_time'=>$time,
            'stream_key'=>$play_address['streamKey'],
            'live_status'=>1,
            'live_time'=>0,
            'room_id'=>$activity['room_id'],
            'intime'=>$time,
            'date'=>date('Y-m-d',$time),
            'log'=>$activity['log'],
            'lag'=>$activity['lag'],
            'sheng'=>$activity['sheng'],
            'shi'=>$activity['shi'],
            'qu'=>$activity['qu'],
            'address'=>$activity['address'],
            'qiniu_room_id'=>$create_room['room_id'],
            'qiniu_room_name'=>$create_room['room_name'],
            'qiniu_token'=>$create_room['token'],
            //fzy添加是否付费，付费金额
            // 'is_pay'=>$is_pay,
            // 'pay_num'=>$pay_num,
            'tag'=>$activity['tag'],
            'plate'=>$activity['plate'],
            'a_id'=>$a_id
        ];
        if ($live_id=M('Live')->add($data)) {

            /*更改活动数据*/
            M('activity')->where(array('a_id'=>$a_id))->setField(array('type'=>2,'x_id'=>$live_id));

            $unionid = $u['unionid'];
            if($unionid){
                $url = 'http://www.uyugame.com/main/main.php?target=invitee&gameKey=pj&parent='.$unionid.'&rd='.urlencode(C('IMG_PREFIX').'/App/Index/share_zhibo?a_id='.$a_id);

            }else{
                $url = C('IMG_PREFIX').'/App/Index/share_zhibo?a_id='.$a_id;

            }
            //二维码
            // $url = C('IMG_PREFIX')."/App/Index/share_live/live_id/" . base64_encode($live_id);
            $qrcode_path = "./Public/upload/qrcode/" . time() . rand(100, 999) . '_qrcode.png';
            qrcode($url, $qrcode_path, 3, 4);
            M('Live')->where(['live_id'=>$live_id])->save(['qrcode_path' => $qrcode_path,'uptime' => time()]);

            $get_gradeinfo = get_gradeinfo($u['grade']);

        /****************************************百台云*************************************/
            //添加直播商品
            // if($activity['goods_id']){
            //     $create_time = date("Y-m-d H:i:s",time());
            //     $goods_id = explode(',',$activity['goods_id']);
            //     foreach ($goods_id as $v){
            //         $merchants_id = M("shop_goods")->where(["goods_id"=>$v])->getField('merchants_id');
            //         $live_goods = [
            //             'goods_id' => $v,
            //             'member_id' =>  $u['user_id'],
            //             'live_id'   =>  $live_id,
            //             'create_time'=> $create_time,
            //             'merchants_id'=> $merchants_id,
            //             'a_id'=>$a_id
            //         ];
            //         M('shop_live_goods')->add($live_goods);
            //     }
            // }

        /****************************************百台云*************************************/

            $result = ['nums' => '0','push_flow_address' => $play_address['url'],'play_address'=>$play_address['url2'], 'room_id' => $activity['room_id'], 'ID' => $u['id'], 'money' => $u['get_money'], 'start_time' =>(string)$time, 'url' => $url,'qrcode_path'=>C('IMG_PREFIX').$qrcode_path,'live_id'=>$live_id,'time'=>date('Y.m.d',$time),'qiniu_room_id'=>$create_room['room_id'],'qiniu_room_name'=>$create_room['room_name'],'qiniu_token'=>$create_room['token'],'is_wheat'=>$u['is_wheat'],'grade_img'=>$get_gradeinfo['img'],'name'=>$get_gradeinfo['name'],'tag'=>$activity['tag'],'img'=>domain($play_img),'plate'=>$activity['plate']];
            success($result);
        } else {
            error('开启失败!');
        }

    }

    /**
     * @开启直播
     */
    public function start_live(){
        $u = checklogin();
        $param = I('param.');
        $log = I('log');  $lag = I('lag');
        $title = I('title');
        //(empty($title)) ? error('参数错误!') : true;
        //is_pay  付费类型  0: 免费  1: 按场次付费  2:按时长付费（分钟）
        $is_pay = I('is_pay')?I('is_pay'):'0';
        $pay_num = I('pay_num')?I('pay_num'):'0';
        $tag     = I('tag');
        if ($u['is_banned']!=1){error('已被禁播');}

        if ($log && $lag){
            $gwd = $lag.','.$log;
            $baidu_apikey = M('System')->getFieldById(1,'baidu_apikey');
            $file_contents = file_get_contents('http://api.map.baidu.com/geocoder/v2/?ak='.$baidu_apikey.'&location='.$gwd.'&output=json');
            $rs = json_decode($file_contents,true);
            $sheng = $rs['result']['addressComponent']['province'];
            $shi = $rs['result']['addressComponent']['city'];
            $qu = $rs['result']['addressComponent']['district'];
            $address = $rs['result']['formatted_address'];
        }

        $config = [
            'maxSize' => 30 * 3145728,
            'rootPath' => './Public/upload/playimg/',
            'savePath' => '',
            'saveName' => ['uniqid', ''],
            'exts' => ['png', 'jpg', 'jpeg', 'git', 'gif'],
            'autoSub' => true,
            'subName' => '',
        ];
        $uploader = new Upload($config);
        $info = $uploader->upload();
        if ($info) {
            foreach ($info as $file) {
                $img = '/Public/upload/playimg/' . $file["savename"];
            }
        }
//        else {
//            error($uploader->getError());
//        }
        if ($img){
            $play_img = $img;
        }else{
            $play_img = $u['img'];
        }
        $user = M('User')->where(['user_id' =>$u['user_id']])->find();
        $user['username'] ? $name = $user['username'] : $name = "直播间" . rand(100, 999);
        $options = [
            'name' => $name,
            'description' => $name,
            'maxusers' => 3000,
            'owner' => $user['hx_username']
        ];
        $create = createChatRoom($options);
        $create['error'] ? error('创建聊天室失败!') : true;
        $play_address = push_address(); //七牛生成流地址
        $qiniu_room_id = time().rand(100, 999);
        $qiniu_room_name = GetfourStr(6);
        $create_room = creatroom($qiniu_room_id,$qiniu_room_name);    //七牛创建房间
        $time = time();
        $data = [
            'user_id'=>$u['user_id'],
            'play_img'=>$play_img,
            'title'=>$title,
            'push_flow_address'=>$play_address['url'],
            'play_address'=>$play_address['url2'],
            'play_address_m3u8'=>$play_address['m3u8'],
            'start_time'=>$time,
            'stream_key'=>$play_address['streamKey'],
            'live_status'=>1,
            'live_time'=>0,
            'room_id'=>$create['data']['id'],
            'intime'=>$time,
            'date'=>date('Y-m-d',$time),
            'log'=>$log,
            'lag'=>$lag,
            'sheng'=>$sheng,
            'shi'=>$shi,
            'qu'=>$qu,
            'address'=>$address,
            'qiniu_room_id'=>$create_room['room_id'],
            'qiniu_room_name'=>$create_room['room_name'],
            'qiniu_token'=>$create_room['token'],
            //fzy添加是否付费，付费金额
            'is_pay'=>$is_pay,
            'pay_num'=>$pay_num,
            'tag'=>$tag,
            'plate'=>$_POST['plate']
        ];
        if ($live_id=M('Live')->add($data)) {
            //二维码
            $url = C('IMG_PREFIX')."/App/Index/share_live/live_id/" . base64_encode($live_id);
            $qrcode_path = "./Public/upload/qrcode/" . time() . rand(100, 999) . '_qrcode.png';
            qrcode($url, $qrcode_path, 3, 4);
            M('Live')->where(['live_id'=>$live_id])->save(['qrcode_path' => $qrcode_path,'uptime' => time()]);

            $get_gradeinfo = get_gradeinfo($u['grade']);

        /****************************************百台云*************************************/

            // //商户添加live_id
            // M("shop_merchants")->where(["member_id"=>$user["user_id"]])->save(["live_id"=>$live_id]);
            // M("user")->where(["user_id"=>$user["user_id"]])->save(["mlive_id"=>$live_id]);
            // M('live')->where(['user_id'=>$user['user_id'],'live_id'=>['neq',$live_id]])->save(['live_status'=>'2']);

            // $merchants_id = M("shop_merchants")->where(["member_id"=>$user["user_id"]])->getField('merchants_id');
            //添加直播商品
            if($param['goods_id']){
                $create_time = date("Y-m-d H:i:s",time());
                $goods_id = explode(',',$param['goods_id']);
                foreach ($goods_id as $v){
                    $merchants_id = M("shop_goods")->where(["goods_id"=>$v])->getField('merchants_id');
                    $live_goods = [
                        'goods_id' => $v,
                        'member_id' =>  $user['user_id'],
                        'live_id'   =>  $live_id,
                        'create_time'=> $create_time,
                        'merchants_id'=> $merchants_id
                    ];
                    M('shop_live_goods')->add($live_goods);
                }
            }

        /****************************************百台云*************************************/

            $result = ['nums' => '0','push_flow_address' => $play_address['url'],'play_address'=>$play_address['url2'], 'room_id' => $create['data']['id'], 'ID' => $user['id'], 'money' => $user['get_money'], 'start_time' =>(string)$time, 'url' => $url,'qrcode_path'=>C('IMG_PREFIX').$qrcode_path,'live_id'=>$live_id,'time'=>date('Y.m.d',$time),'qiniu_room_id'=>$create_room['room_id'],'qiniu_room_name'=>$create_room['room_name'],'qiniu_token'=>$create_room['token'],'is_wheat'=>$u['is_wheat'],'grade_img'=>$get_gradeinfo['img'],'name'=>$get_gradeinfo['name'],'is_pay'=>$data['is_pay'],'pay_num'=>$data['pay_num'],'tag'=>$data['tag'],'img'=>domain($play_img)];
            success($result);
        } else {
            error('开启失败!');
        }

    }

    /**
     * @获取用户是否开启连麦功能
     */
    public function is_wheat(){
        $user = checklogin();
        $user_id = I('user_id');
        $is_wheat = M('User')->where(['user_id'=>$user_id])->getField('is_wheat');
        success($is_wheat);
    }

    /**
     * @开启连麦(关闭连麦)
     * @type  1:开启   2:关闭
     */
    public function save_wheat(){
        $user = checklogin();
        $type = I('type');
        empty($type) ? error('参数错误!') : true;  ($type==1 || $type==2) ? true : error('传值错误!');
        if (M('User')->where(['user_id'=>$user['user_id']])->save(['is_wheat'=>$type,'uptime'=>time()])){
            success('成功!');
        }else{
            error('失败!');
        }
    }

    /**
     * @分享直播界面
     */
    public function share_live(){
        $live_id = base64_decode(I('live_id'));
        $live = M('Live')
            ->alias('a')
            ->field('a.live_id,a.play_img,a.title,a.play_address_m3u8,b.img,b.username,b.company,b.duty,b.ID')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.live_id'=>$live_id,'a.live_status'=>1])
            ->find();
        if (!$live){
            $live = M('Live_store')
                ->alias('a')
                ->field('a.live_id,a.play_img,a.title,a.url,b.img,b.username,b.company,b.duty,b.ID')
                ->join('__USER__ b on a.user_id=b.user_id')
                ->where(['live_id'=>$live_id])
                ->find();
            $live['play_address_m3u8'] = $live['url'];
        }
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            $url = 'https://itunes.apple.com/cn/app/度珞/id1230012812?mt=8';
        }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            $url = 'http://www.duluozb.com/download/duluo.apk';
        }
        $live['down_url'] = $url;
        $this->assign('live',$live);
        $this->display();
    }

    /**
     * @主播非正常退出,再次进入,判断
     */
    public function check_to_live(){
        $user = checklogin();
        $live = M('Live')->where(['user_id'=>$user['user_id'],'live_status'=>1])->find();
        if ($live){
            $result = ['state'=>1,'nums' => $live['nums'],'push_flow_address' => $live['push_flow_address'],'play_address'=>$live['play_address'], 'room_id' => $live['room_id'], 'ID'=>$user['id'], 'money' => $user['money'], 'start_time' =>$live['start_time'], 'url' => $user['url'],'live_id'=>$live['live_id'],'time'=>date('Y.m.d',$live['start_time']),'qiniu_room_id'=>$live['qiniu_room_id'],'qiniu_room_name'=>$live['qiniu_room_name'],'qiniu_token'=>$live['qiniu_token'],'is_wheat'=>$user['is_wheat']];
        }else{
            $result = ['state'=>2];
        }
        success($result);
    }
    /**
     * @如果不再继续直播,关闭直播,删掉流
     */
    public function shut_down_live(){
        $user = checklogin();
        $live = M('Live')->where(['user_id'=>$user['user_id'],'live_status'=>1])->find();
        if ($live){
            //强制下线
            import('Vendor.Qiniu.Pili');
            $system = M('System')->where(['id' => 1])->find();
            $ak = $system['ak'];
            $sk = $system['sk'];
            $hubName = $system['hubname'];
            $mac = new \Qiniu\Pili\Mac($ak, $sk);
            $client = new \Qiniu\Pili\Client($mac);
            $hub = $client->hub($hubName);
            //获取stream
            $streamKey = $live['stream_key'];
            $stream = $hub->stream($streamKey);
            $result = $stream->disable();
            M('Live')->where(['live_id'=>$live['live_id']])->save(['end_time'=>time(),'live_status'=>2]);

            /**更改活动数据**/
            M('activity')->where(array('type'=>2,'a_id'=>$live['a_id']))->setField(array('type'=>3,'x_id'=>0,'store_status'=>2));
            /**更改活动数据**/
        }
        success('成功!');
    }

    /**
     * @活动列表
     * type  1:关注  2:热门(按浏览数排列)  3:附近
     * a_type   1:预播  2:直播  3:录播  4:视频  5:图片  6:文章
     * tag  标签
     * title  搜索活动
     */
    public function activity_list(){
        $type = I('type'); 
        // (empty($type))? error('参数错误') : true;
        $page = I('page'); $pageSize = I('pagesize');
        $tag = I('tag');
        $uid = I('uid');
        $a_type = I('a_type');

        $keyworks = I('title');
        
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;

        $version_number = I('version_number');
        $ios_version = M('System')->where(['id'=>1])->getField('ios_version');

        import('Vendor.Qiniu.Pili');
        $system = M('System')->where(['id' => 1])->find();
        $ak = $system['ak'];
        $sk = $system['sk'];
        $hubName = $system['hubname'];
        $mac = new \Qiniu\Pili\Mac($ak, $sk);
        $client = new \Qiniu\Pili\Client($mac);
        $hub = $client->hub($hubName);
        $resp = $hub->listLiveStreams("php-sdk-test", 100000, "");
        $resp = $resp[keys];
        if ($resp){
            $rs = M('Live')->where(['stream_key'=>['in',$resp],'is_normal_exit'=>2])->save(['live_status'=>1,'uptime'=>2]);
        }
        switch ($type) {
             case '1':
                $user = checklogin();
                $follow = M('Follow')->where(['user_id'=>$user['user_id']])->select();
                if ($follow){
                    $ids = array_map(function($v){ return $v['user_id2'];},$follow);
                    array_push($ids, $user['user_id']);
                    $dat = [
                        'a.user_id'=>['not in',$ids],
                        'a.is_fans'=>1,
                        'a.is_del'=>1,
                        'b.store_status'=>1,
                        'b.is_del'=>1,
                        // 'b.state'=>2
                    ];
                    if($tag){
                        $dat['_string']='FIND_IN_SET("'.$tag.'", b.tag)';
                    }

                    if($a_type){
                       switch ($a_type) {
                            case '1':
                                $dat['b.type'] = 1;
                                break;
                            case '2':
                                $dat['b.type'] = 2;
                                break;
                            case '3':
                                $dat['b.type'] = 3;
                                break;
                            case '4':
                                $dat['b.type'] = 4;
                                break;
                            case '5':
                                $dat['b.type'] = 5;
                                break;
                            case '6':
                                $dat['b.type'] = 6;
                                break;
                            default:
                                # code...
                                break;
                        } 
                    }
                    if ($keyworks){
                        $dat['b.title'] = ['like','%'.$keyworks.'%'];
                        
                    }

                    $tuijian = M('User')
                        ->alias('a')
                        ->join('__ACTIVITY__ b on a.user_id=b.user_id','RIGHT')
                        ->field('a.user_id,a.phone,a.img as header_img,a.sex,a.username,a.autograph,a.grade,a.ID,a.hx_username,a.province,a.city,a.money,a.get_money,b.url,b.sheng,b.type,b.a_id,b.img')
                        ->where($dat)
                        ->group('a.user_id')
                        ->order('rand()')
                        ->limit(5)
                        ->select();
                    // echo M()->getLastSql();exit;
                    // print_r($tuijian);exit;    
                    if ($tuijian){
                        foreach ($tuijian as $k=>$v){
                            $tuijian[$k]['img'] = domain($v['img']);
                            $tuijian[$k]['header_img'] = domain($v['header_img']);
                            $is_follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                            $is_follow ? $tuijian[$k]['is_follow'] = "2" : $tuijian[$k]['is_follow'] = "1";

                            $get_gradeinfo = get_gradeinfo($v['grade']);
                            $tuijian[$k]['grade_img'] = $get_gradeinfo['img'];
                            $tuijian[$k]['name'] = $get_gradeinfo['name'];

                            /*检测是否收藏*/
                            $tuijian[$k]['is_collect'] = '2';
                            if (!empty($uid)) {
                                $map['member_id'] = $uid;
                                $map['a_id'] = $v['a_id'];
                                $map['is_delete'] = '1';
                                $check = M('activity_collection')->where($map)->find();
                                if ($check) {
                                    $tuijian[$k]['is_collect'] = '1';
                                }

                            }
                        }
                        
                    }else{$tuijian = [];}
                }else{
                    $dat = [
                        'a.is_fans'=>1,
                        'a.is_del'=>1,
                        // 'b.live_status'=>1,
                        'a.user_id'=>['neq',$user['user_id']],
                        'b.store_status'=>1,
                        'b.is_del'=>1,
                    ];
                    if($tag){
                        $dat['_string']='FIND_IN_SET("'.$tag.'", b.tag)';
                    }

                    if($a_type){
                       switch ($a_type) {
                            case '1':
                                $dat['b.type'] = 1;
                                break;
                            case '2':
                                $dat['b.type'] = 2;
                                break;
                            case '3':
                                $dat['b.type'] = 3;
                                break;
                            case '4':
                                $dat['b.type'] = 4;
                                break;
                            case '5':
                                $dat['b.type'] = 5;
                                break;
                            case '6':
                                $dat['b.type'] = 6;
                                break;
                            default:
                                # code...
                                break;
                        } 
                    }

                    if ($keyworks){
                        $dat['b.title'] = ['like','%'.$keyworks.'%'];
                        
                    }
                    $tuijian = M('User')
                        ->alias('a')
                        ->join('__ACTIVITY__ b on a.user_id=b.user_id','RIGHT')
                        ->field('a.user_id,phone,a.img as header_img,sex,username,autograph,grade,ID,hx_username,province,city,money,get_money,b.url,b.sheng,b.type,b.a_id,b.img')
                        ->where($dat)
                        ->group('a.user_id')
                        ->order('rand()')
                        ->limit(5)
                        ->select();
                    if ($tuijian){
                        foreach ($tuijian as $k=>$v){
                            $tuijian[$k]['img'] = domain($v['img']);
                            $tuijian[$k]['header_img'] = domain($v['header_img']);
                            $is_follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                            $is_follow ? $tuijian[$k]['is_follow'] = "2" : $tuijian[$k]['is_follow'] = "1";

                            $get_gradeinfo = get_gradeinfo($v['grade']);
                            $tuijian[$k]['grade_img'] = $get_gradeinfo['img'];
                            $tuijian[$k]['name'] = $get_gradeinfo['name'];

                            /*检测是否收藏*/
                            $tuijian[$k]['is_collect'] = '2';
                            if (!empty($uid)) {
                                $map['member_id'] = $uid;
                                $map['a_id'] = $v['a_id'];
                                $map['is_delete'] = '1';
                                $check = M('activity_collection')->where($map)->find();
                                if ($check) {
                                    $tuijian[$k]['is_collect'] = '1';
                                }

                            }
                        }
                    }else{$tuijian = [];}
                }
                $list['tuijian'] = $tuijian;
                //活动
                if($tag){
                    $da['_string']='FIND_IN_SET("'.$tag.'", b.tag)';
                }

                if($a_type){
                   switch ($a_type) {
                        case '1':
                            $da['b.type'] = 1;
                            break;
                        case '2':
                            $da['b.type'] = 2;
                            break;
                        case '3':
                            $da['b.type'] = 3;
                            break;
                        case '4':
                            $da['b.type'] = 4;
                            break;
                        case '5':
                            $da['b.type'] = 5;
                            break;
                        case '6':
                            $da['b.type'] = 6;
                            break;
                        default:
                            # code...
                            break;
                    } 
                }

                if ($keyworks){
                    $da['b.title'] = ['like','%'.$keyworks.'%'];
                    
                }
                $da['a.user_id'] = $user['user_id'];
                // $da['b.state'] = 2;
                $da['c.is_del'] = 1;
                $da['b.store_status'] = 1;
                $da['b.is_del'] = 1;


                $live = M('Follow')
                    ->alias('a')
                    ->field('b.*,c.phone,c.img as header_img,c.sex,c.username,c.ID,c.hx_username,c.grade,c.province,c.city,c.money,c.get_money')
                    ->join('__ACTIVITY__ b on a.user_id2=b.user_id','RIGHT')
                    ->join('__USER__ c on c.user_id=b.user_id','LEFT')
                    // ->where(['a.user_id'=>$user['user_id'],'b.state'=>2,'c.is_del'=>1,'b.store_status'=>1,'b.is_del'=>1])
                    ->where($da)
                    ->group('a.user_id')
                    ->order('b.sort desc,b.count desc')
                    ->limit(($page-1)*$pageSize,$pageSize)
                    ->select();
                //     echo M()->getLastSql();exit;
                // print_r($live);exit;
                if ($live){
                    foreach ($live as $k=>$v){
                        $live[$k]['img'] = domain($v['img']);
                        $live[$k]['header_img'] = domain($v['header_img']);
                        // $live[$k]['play_img'] = domain($v['play_img']);
                        // $live[$k]['url'] = C('IMG_PREFIX')."/App/Index/share_live/live_id/" . base64_encode($v['x_id']);
                        // $live[$k]['qrcode_path'] = C('IMG_PREFIX').$v['qrcode_path'];
                        $live[$k]['is_type'] = "1";
                        $follow2 = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                        $follow2 ? $live[$k]['is_follow'] = "2" : $live[$k]['is_follow'] = "1";

                        $get_gradeinfo = get_gradeinfo($v['grade']);
                        $live[$k]['grade_img'] = $get_gradeinfo['img'];
                        $live[$k]['name'] = $get_gradeinfo['name'];

                        $create_room = creatroom1($user['user_id'],$v['qiniu_room_name']); 
                        $live[$k]['qiniu_token'] = $create_room['token'];

                        /*检测是否收藏*/
                            $live[$k]['is_collect'] = '2';
                            if (!empty($uid)) {
                                $map['member_id'] = $uid;
                                $map['a_id'] = $v['a_id'];
                                $map['is_delete'] = '1';
                                $check = M('activity_collection')->where($map)->find();
                                if ($check) {
                                    $live[$k]['is_collect'] = '1';
                                }

                            }
                    }
                }else{$live=[];}
                
                $list['list'] = $live;
                if(empty($list)){
                    $list = [];
                }
                success($list);
                 break;
             case '2':
                $data = [
                    // 'a.state'=>2,
                    'b.is_del'=>1,
                    'a.store_status'=>1,
                    'a.is_del'=>1,
                ];
                if($tag){
                    $data['_string']='FIND_IN_SET("'.$tag.'", a.tag)';
                }

                if($a_type){
                   switch ($a_type) {
                        case '1':
                            $data['a.type'] = 1;
                            break;
                        case '2':
                            $data['a.type'] = 2;
                            break;
                        case '3':
                            $data['a.type'] = 3;
                            break;
                        case '4':
                            $data['a.type'] = 4;
                            break;
                        case '5':
                            $data['a.type'] = 5;
                            break;
                        case '6':
                            $data['a.type'] = 6;
                            break;
                        default:
                            # code...
                            break;
                    } 
                }

                if ($keyworks){
                    $data['a.title'] = ['like','%'.$keyworks.'%'];
                    
                }
                $list = M('Activity')
                    ->alias('a')
                    ->field('a.*,b.phone,b.img as header_img,b.sex,b.username,b.ID,b.hx_username,b.grade,b.province,b.city,b.zan,b.money,b.get_money')
                    ->join('__USER__ b on a.user_id=b.user_id')
                    ->where($data)
                    ->order('a.sort desc,a.count desc')
                    ->page($page,$pageSize)
                    ->select();
                if ($list){
                    foreach ($list as $k=>$v){
                        $list[$k]['img'] = domain($v['img']);
                        $list[$k]['header_img'] = domain($v['header_img']);
                        // $list[$k]['play_img'] = domain($v['play_img']);
                        // $list[$k]['url'] = C('IMG_PREFIX')."/App/Index/share_live/live_id/" . base64_encode($v['live_id']);
                        // $list[$k]['qrcode_path'] = C('IMG_PREFIX').$v['qrcode_path'];

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
                break;
                
             case '3':
                $log = I('log'); $lag = I('lag');  $sex = I('sex');
                $data = [
                    // 'a.state'=>2,
                    'b.is_del'=>1,
                    'a.store_status'=>1,
                    'a.is_del'=>1,
                ];
                if($tag){
                    $data['_string']='FIND_IN_SET("'.$tag.'", a.tag)';
                }

                if($a_type){
                   switch ($a_type) {
                        case '1':
                            $data['a.type'] = 1;
                            break;
                        case '2':
                            $data['a.type'] = 2;
                            break;
                        case '3':
                            $data['a.type'] = 3;
                            break;
                        case '4':
                            $data['a.type'] = 4;
                            break;
                        case '5':
                            $data['a.type'] = 5;
                            break;
                        case '6':
                            $data['a.type'] = 6;
                            break;
                        default:
                            # code...
                            break;
                    } 
                }
                if ($keyworks){
                    $data['a.title'] = ['like','%'.$keyworks.'%'];

                }
                !empty($sex) ? $data['b.sex'] = $sex : true;
                $list = M('Activity')->alias('a')
                    ->field('a.*,b.phone,b.img as header_img,b.sex,b.username,b.ID,b.hx_username,b.grade,b.province,b.city,b.zan,b.money,b.get_money')
                    ->join('__USER__ b on a.user_id=b.user_id')
                    ->where($data)
                    ->order('a.sort desc,a.count desc')
                    ->page($page,$pageSize)
                    ->select();
                if ($list){
                    foreach ($list as $k=>$v){
                        $list[$k]['img'] = domain($v['img']);
                        $list[$k]['header_img'] = domain($v['header_img']);
                        // $list[$k]['play_img'] = domain($v['play_img']);
                        // $list[$k]['url'] = C('IMG_PREFIX')."/App/Index/share_live/live_id/" . base64_encode($v['live_id']);
                        // $list[$k]['qrcode_path'] = C('IMG_PREFIX').$v['qrcode_path'];

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
                if ($log && $lag){
                    foreach ($list as $k=>$v){
                        $list[$k]['distance'] = (string)round(getDistance($lag,$log,$v['lag'],$v['log'])/1000,2);   //算出距离（公里），保留两位小数点(四舍五入)
                    }
                    // foreach ($list as $k=>$v){
                    //     if ($v['distance']>200){
                    //         unset($list[$k]);
                    //     }
                    //     if ($v['distance']<2){
                    //         $list[$k]['distance'] = "2";
                    //     }
                    // }
                }else{
                    foreach ($list as $k=>$v){
                        $list[$k]['distance'] = $v['shi'];
                    }
                }
                $list = array_values($list);
                success($list);
                 break;
             default:
                 $data = [
                    // 'a.state'=>2,
                    'b.is_del'=>1,
                    'a.store_status'=>1,
                    'a.is_del'=>1,
                ];
                if($tag){
                    $data['_string']='FIND_IN_SET("'.$tag.'", a.tag)';
                }

                if($a_type){
                   switch ($a_type) {
                        case '1':
                            $data['a.type'] = 1;
                            break;
                        case '2':
                            $data['a.type'] = 2;
                            break;
                        case '3':
                            $data['a.type'] = 3;
                            break;
                        case '4':
                            $data['a.type'] = 4;
                            break;
                        case '5':
                            $data['a.type'] = 5;
                            break;
                        case '6':
                            $data['a.type'] = 6;
                            break;
                        default:
                            # code...
                            break;
                    } 
                }

                if ($keyworks){
                    $data['a.title'] = ['like','%'.$keyworks.'%'];
                }
                // print_r($data);exit;

                $list = M('Activity')
                    ->alias('a')
                    ->field('a.*,b.phone,b.img as header_img,b.sex,b.username,b.ID,b.hx_username,b.grade,b.province,b.city,b.zan,b.money,b.get_money')
                    ->join('__USER__ b on a.user_id=b.user_id')
                    ->where($data)
                    ->page($page,$pageSize)
                    ->order('a.sort desc')
                    ->select();
                // echo M()->getLastSql();
                if ($list){
                    foreach ($list as $k=>$v){
                        $list[$k]['img'] = domain($v['img']);
                        $list[$k]['header_img'] = domain($v['header_img']);
                        // $list[$k]['play_img'] = domain($v['play_img']);
                        // $list[$k]['url'] = C('IMG_PREFIX')."/App/Index/share_live/live_id/" . base64_encode($v['live_id']);
                        // $list[$k]['qrcode_path'] = C('IMG_PREFIX').$v['qrcode_path'];

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
                 break;
         } 
    }

    /**
     * @直播列表
     * @type  1:热门  2:关注  3:附近   4:官方
     */
    public function live_list(){
        $user = checklogin();
        $type = I('type'); (empty($type))? error('参数错误') : true;
        $page = I('page'); $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;

        $version_number = I('version_number');
        $ios_version = M('System')->where(['id'=>1])->getField('ios_version');

        import('Vendor.Qiniu.Pili');
        $system = M('System')->where(['id' => 1])->find();
        $ak = $system['ak'];
        $sk = $system['sk'];
        $hubName = $system['hubname'];
        $mac = new \Qiniu\Pili\Mac($ak, $sk);
        $client = new \Qiniu\Pili\Client($mac);
        $hub = $client->hub($hubName);
        $resp = $hub->listLiveStreams("php-sdk-test", 100000, "");
        $resp = $resp[keys];
        if ($resp){
            $rs = M('Live')->where(['stream_key'=>['in',$resp],'is_normal_exit'=>2])->save(['live_status'=>1,'uptime'=>2]);
//            foreach ($rs as $k=>$v){
//                if ($v['live_status']==2){
//                    M('Live')->where(['live_id'=>$v['live_id']])->save(['live_status'=>1,'uptime'=>2]);
//                }
//            }
        }


        switch ($type){
            case 1:
                $regular = M('System')->where(['id'=>1])->getField('regular');
                $data = [
                    'a.live_status'=>1,
                    // 'b.type'=>1,
                    'b.is_del'=>1,
                    'a.is_hot'=>1,
                ];
                $date = [
                    'a.live_status'=>1,
                    // 'b.type'=>1,
                    'b.is_del'=>1,
                    'a.is_hot'=>1,
                ];
                $sex = I('sex');  $province = I('province');
                if($sex){
                    $data['b.sex'] = intval($sex);
                    $date['b.sex'] = intval($sex);
                }
                if($province){
                    $data['a.sheng'] = $province;
                    $date['a.sheng'] = $province;
                }

                switch ($regular){
                    case 1:
                        $order = 'a.is_tuijian desc,a.intime desc';
                        break;
                    case 2:
                        $order = 'a.is_tuijian desc,a.watch_nums desc';
                        break;
                    case 3:
                        $order = 'a.is_tuijian desc,b.get_money desc';
                        break;
                }

                $list =  M('Live')
                    ->alias('a')
                    ->field('a.*,b.phone,b.img,b.sex,b.username,b.ID,b.hx_username,b.grade,b.province,b.city,b.zan,b.money,b.get_money,b.url,b.type')
                    ->join('__USER__ b on a.user_id=b.user_id')
                    ->where($data)->limit(($page-1)*$pageSize,$pageSize)
                    ->order($order)
                    ->select();
                // echo M()->getLastSql();
                if ($list){
                    foreach ($list as $k=>$v){
                        // if($v['play_img']){
                        //     $list[$k]['img'] = C('IMG_PREFIX').$v['play_img'];

                        // }else{
                            $list[$k]['img'] = domain($v['img']);
                        // }
                        $list[$k]['play_img'] = domain($v['play_img']);
                        // $list[$k]['img'] = C('IMG_PREFIX').$v['img'];
                        $list[$k]['url'] = C('IMG_PREFIX')."/App/Index/share_live/live_id/" . base64_encode($v['live_id']);
                        $list[$k]['qrcode_path'] = C('IMG_PREFIX').$v['qrcode_path'];
                        $follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                        $follow ? $list[$k]['is_follow'] = "2" : $list[$k]['is_follow'] = "1";
                        $list[$k]['is_type'] = "1";

                        $get_gradeinfo = get_gradeinfo($v['grade']);
                        $list[$k]['grade_img'] = $get_gradeinfo['img'];
                        $list[$k]['name'] = $get_gradeinfo['name'];
                        // $list[$k]['watch_nums'] = $v['nums'];
        $count = M('Live_number')->alias('a')
            ->field('a.user_id2,b.user_id,b.img,b.thumb_img,b.username,b.grade,b.autograph,b.ID,b.hx_username,b.hx_password,b.money,b.get_money,b.sex,b.province,b.city,b.type')
            ->join('__USER__ b on a.user_id2 = b.user_id')
            ->where(['a.live_id'=>$v['live_id']])
            ->count();
        $list[$k]['watch_nums'] = $count;

                        $create_room = creatroom1($user['user_id'],$v['qiniu_room_name']); 
                        $list[$k]['qiniu_token'] = $create_room['token'];
                    }

                }else{$list=[];}


//                if ($version_number==$ios_version){
//                    $dat = [
//                        'a.is_del'=>1,
//                        'b.is_del'=>1,
//                    ];
//                    $live_store = M('Live_store')
//                        ->alias('a')
//                        ->field('a.*,b.phone,b.img,b.sex,b.username,b.ID,b.hx_username,b.grade,b.province,b.city,b.money,b.get_money,c.watch_nums,c.sheng,c.shi,c.qu,b.type')
//                        ->join('__USER__ b on a.user_id=b.user_id')
//                        ->join('__LIVE__ c on a.live_id=c.live_id')
//                        ->where($dat)
//                        ->order('rand()')
//                        ->limit(10)
//                        ->select();
//                    if ($live_store){
//                        foreach ($live_store as $k=>$v){
//                            $live_store[$k]['play_img'] = C('IMG_PREFIX').$v['play_img'];
//                            $live_store[$k]['img'] = C('IMG_PREFIX').$v['img'];
//                            $live_store[$k]['lebel'] = explode(',',$v['lebel']);
//                            $live_store[$k]['is_type'] = "2";
//
//                            $is_follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
//                            $is_follow ? $live_store[$k]['is_follow'] = "2" : $live_store[$k]['is_follow'] = "1";
//                        }
//                    }else{$live_store=[];}
//                    $list = array_merge($list,$live_store);
//                }


                success($list);
                break;
            case 2:
                $follow = M('Follow')->where(['user_id'=>$user['user_id']])->select();
                if ($follow){
                    $ids = array_map(function($v){ return $v['user_id2'];},$follow);
                    array_push($ids, $user['user_id']);
                    $dat = [
                        'a.user_id'=>['not in',$ids],
                        'a.is_fans'=>1,
                        'a.is_del'=>1,
                        'b.live_status'=>1
                    ];
                    $tuijian = M('User')
                        ->alias('a')
                        ->join('__LIVE__ b on a.user_id=b.user_id')
                        ->field('a.user_id,phone,img,sex,username,autograph,grade,ID,hx_username,province,city,money,get_money,url,b.sheng,type')
                        ->where($dat)
                        ->order('rand()')
                        ->limit(5)
                        ->select();
                    if ($tuijian){
                        foreach ($tuijian as $k=>$v){
                            $tuijian[$k]['img'] = C('IMG_PREFIX').$v['img'];
                            $is_follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                            $is_follow ? $tuijian[$k]['is_follow'] = "2" : $tuijian[$k]['is_follow'] = "1";

                            $get_gradeinfo = get_gradeinfo($v['grade']);
                            $tuijian[$k]['grade_img'] = $get_gradeinfo['img'];
                            $tuijian[$k]['name'] = $get_gradeinfo['name'];
                        }
                    }else{$tuijian = [];}
                }else{
                    $dat = [
                        'a.is_fans'=>1,
                        'a.is_del'=>1,
                        'b.live_status'=>1,
                        'a.user_id'=>['neq',$user['user_id']]
                    ];
                    $tuijian = M('User')
                        ->alias('a')
                        ->join('__LIVE__ b on a.user_id=b.user_id')
                        ->field('a.user_id,phone,img,sex,username,autograph,grade,ID,hx_username,province,city,money,get_money,url,b.sheng,type')
                        ->where($dat)
                        ->order('rand()')
                        ->limit(5)
                        ->select();
                    if ($tuijian){
                        foreach ($tuijian as $k=>$v){
                            $tuijian[$k]['img'] = C('IMG_PREFIX').$v['img'];
                            $is_follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                            $is_follow ? $tuijian[$k]['is_follow'] = "2" : $tuijian[$k]['is_follow'] = "1";

                            $get_gradeinfo = get_gradeinfo($v['grade']);
                            $tuijian[$k]['grade_img'] = $get_gradeinfo['img'];
                            $tuijian[$k]['name'] = $get_gradeinfo['name'];
                        }
                    }else{$tuijian = [];}
                }
                $list['tuijian'] = $tuijian;
                //直播
                $live = M('Follow')
                    ->alias('a')
                    ->field('b.*,c.phone,c.img,c.sex,c.username,c.ID,c.hx_username,c.grade,c.province,c.city,c.money,c.get_money,c.type')
                    ->join('__LIVE__ b on a.user_id2=b.user_id')
                    ->join('__USER__ c on c.user_id=b.user_id')
                    ->where(['a.user_id'=>$user['user_id'],'b.live_status'=>1,'c.is_del'=>1])
                    ->order('b.watch_nums desc')
                    ->limit(($page-1)*$pageSize,$pageSize)
                    ->select();
                if ($live){
                    foreach ($live as $k=>$v){
                        // if($v['play_img']){
                        //     $list[$k]['img'] = C('IMG_PREFIX').$v['play_img'];

                        // }else{
                            $list[$k]['img'] = domain($v['img']);
                        // }
                        
                        $live[$k]['play_img'] = domain($v['play_img']);
                        // $live[$k]['img'] = C('IMG_PREFIX').$v['img'];
                        $live[$k]['url'] = C('IMG_PREFIX')."/App/Index/share_live/live_id/" . base64_encode($v['live_id']);
                        $live[$k]['qrcode_path'] = C('IMG_PREFIX').$v['qrcode_path'];
                        $live[$k]['is_type'] = "1";
                        $follow2 = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                        $follow2 ? $live[$k]['is_follow'] = "2" : $live[$k]['is_follow'] = "1";

                        $get_gradeinfo = get_gradeinfo($v['grade']);
                        $live[$k]['grade_img'] = $get_gradeinfo['img'];
                        $live[$k]['name'] = $get_gradeinfo['name'];

                        $create_room = creatroom1($user['user_id'],$v['qiniu_room_name']); 
                        $live[$k]['qiniu_token'] = $create_room['token'];

        $count = M('Live_number')->alias('a')
            ->field('a.user_id2,b.user_id,b.img,b.thumb_img,b.username,b.grade,b.autograph,b.ID,b.hx_username,b.hx_password,b.money,b.get_money,b.sex,b.province,b.city,b.type')
            ->join('__USER__ b on a.user_id2 = b.user_id')
            ->where(['a.live_id'=>$live[$k]['live_id']])
            ->count();
        $live[$k]['watch_nums'] = $count;
                    }
                }else{$live=[];}
                //录播
                /* $live_store = M('Follow')
                     ->alias('a')
                     ->field('b.*,c.phone,c.img,c.sex,c.username,c.ID,c.hx_username,c.grade,c.province,c.city,c.money,c.get_money,d.watch_nums,d.sheng,d.shi,d.qu,c.type')
                     ->join('__LIVE_STORE__ b on a.user_id2=b.user_id')
                     ->join('__USER__ c on b.user_id=c.user_id')
                     ->join('__LIVE__ d on d.live_id=b.live_id')
                     ->where(['a.user_id'=>$user['user_id'],'c.is_del'=>1,'b.is_del'=>1])
                     ->select();
                 if ($live_store){
                     foreach ($live_store as $k=>$v){
                         $live_store[$k]['play_img'] = C('IMG_PREFIX').$v['play_img'];
                         $live_store[$k]['img'] = C('IMG_PREFIX').$v['img'];
                         $live_store[$k]['is_type'] = "2";
                         $follow2 = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                         $follow2 ? $live_store[$k]['is_follow'] = "2" : $live_store[$k]['is_follow'] = "1";

                         $get_gradeinfo = get_gradeinfo($v['grade']);
                         $live_store[$k]['grade_img'] = $get_gradeinfo['img'];
                         $live_store[$k]['name'] = $get_gradeinfo['name'];
                     }
                 }else{$live_store=[];}
                 $lista = array_merge($live,$live_store);
                 $list['list'] = array_slice($lista,($page-1)*$pageSize,$pageSize);*/
                $list['list'] = $live;
                if(empty($list)){
                    $list = [];
                }
                success($list);
                break;
            case 3:
                $log = I('log'); $lag = I('lag');  $sex = I('sex');
                $data = [
                    'a.live_status'=>1,
                    'b.type'=>1,
                    'b.is_del'=>1,
                ];
                !empty($sex) ? $data['b.sex'] = $sex : true;
                $list = M('Live')->alias('a')
                    ->field('a.*,b.phone,b.img,b.sex,b.username,b.ID,b.hx_username,b.grade,b.province,b.city,b.zan,b.money,b.get_money,b.url,b.type')
                    ->join('__USER__ b on a.user_id=b.user_id')
                    ->where($data)
                    ->order('a.watch_nums desc')
                    ->page($page,$pageSize)
                    ->select();
                if ($list){
                    foreach ($list as $k=>$v){
                        // if($v['play_img']){
                        //     $list[$k]['img'] = C('IMG_PREFIX').$v['play_img'];

                        // }else{
                            $list[$k]['img'] = domain($v['img']);
                        // }
                        $list[$k]['play_img'] = domain($v['play_img']);
                        // $list[$k]['img'] = C('IMG_PREFIX').$v['img'];
                        $list[$k]['url'] = C('IMG_PREFIX')."/App/Index/share_live/live_id/" . base64_encode($v['live_id']);
                        $list[$k]['qrcode_path'] = C('IMG_PREFIX').$v['qrcode_path'];
                        $follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                        $follow ? $list[$k]['is_follow'] = "2" : $list[$k]['is_follow'] = "1";

                        $get_gradeinfo = get_gradeinfo($v['grade']);
                        $list[$k]['grade_img'] = $get_gradeinfo['img'];
                        $list[$k]['name'] = $get_gradeinfo['name'];

                        $create_room = creatroom1($user['user_id'],$v['qiniu_room_name']); 
                        $list[$k]['qiniu_token'] = $create_room['token'];

        $count = M('Live_number')->alias('a')
            ->field('a.user_id2,b.user_id,b.img,b.thumb_img,b.username,b.grade,b.autograph,b.ID,b.hx_username,b.hx_password,b.money,b.get_money,b.sex,b.province,b.city,b.type')
            ->join('__USER__ b on a.user_id2 = b.user_id')
            ->where(['a.live_id'=>$list[$k]['live_id']])
            ->count();
        $list[$k]['watch_nums'] = $count;
                    }
                }else{$list=[];}
                if ($log && $lag){
                    foreach ($list as $k=>$v){
                        $list[$k]['distance'] = (string)round(getDistance($lag,$log,$v['lag'],$v['log'])/1000,2);   //算出距离（公里），保留两位小数点(四舍五入)
                    }
                    foreach ($list as $k=>$v){
                        if ($v['distance']>200){
                            unset($list[$k]);
                        }
                        if ($v['distance']<2){
                            $list[$k]['distance'] = "2";
                        }
                    }
                }else{
                    foreach ($list as $k=>$v){
                        $list[$k]['distance'] = $v['shi'];
                    }
                }
                $list = array_values($list);
                success($list);
                break;
            case 4:
                $data = [
                    'a.live_status'=>1,
                    'b.type'=>2,
                    'b.is_del'=>1,
                ];
                $list = M('Live')
                    ->alias('a')
                    ->field('a.*,b.phone,b.img,b.sex,b.username,b.ID,b.hx_username,b.grade,b.province,b.city,b.zan,b.money,b.get_money,b.url,b.type')
                    ->join('__USER__ b on a.user_id=b.user_id')
                    ->where($data)
                    ->order('a.watch_nums desc')
                    ->page($page,$pageSize)
                    ->select();
                if ($list){
                    foreach ($list as $k=>$v){
                        // if($v['play_img']){
                        //     $list[$k]['img'] = C('IMG_PREFIX').$v['play_img'];

                        // }else{
                            $list[$k]['img'] = domain($v['img']);
                        // }
                        $list[$k]['play_img'] = domain($v['play_img']);
                        // $list[$k]['img'] = C('IMG_PREFIX').$v['img'];
                        $list[$k]['url'] = C('IMG_PREFIX')."/App/Index/de_live/live_id/" . base64_encode($v['live_id']);
                        $list[$k]['qrcode_path'] = C('IMG_PREFIX').$v['qrcode_path'];
                        $follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                        $follow ? $list[$k]['is_follow'] = "2" : $list[$k]['is_follow'] = "1";

                        $list[$k]['is_type'] = "1";

                        $get_gradeinfo = get_gradeinfo($v['grade']);
                        $list[$k]['grade_img'] = $get_gradeinfo['img'];
                        $list[$k]['name'] = $get_gradeinfo['name'];

                        $create_room = creatroom1($user['user_id'],$v['qiniu_room_name']); 
                        $list[$k]['qiniu_token'] = $create_room['token'];

        $count = M('Live_number')->alias('a')
            ->field('a.user_id2,b.user_id,b.img,b.thumb_img,b.username,b.grade,b.autograph,b.ID,b.hx_username,b.hx_password,b.money,b.get_money,b.sex,b.province,b.city,b.type')
            ->join('__USER__ b on a.user_id2 = b.user_id')
            ->where(['a.live_id'=>$list[$k]['live_id']])
            ->count();
        $list[$k]['watch_nums'] = $count;
                    }
                }else{$list=[];}
                if ($version_number==$ios_version){
                    $dat = [
                        'a.is_del'=>1,
                        'b.is_del'=>1,
                    ];
                    $live_store = M('Live_store')
                        ->alias('a')
                        ->field('a.*,b.phone,b.img,b.sex,b.username,b.ID,b.hx_username,b.grade,b.province,b.city,b.money,b.get_money,c.watch_nums,c.sheng,c.shi,c.qu,b.type')
                        ->join('__USER__ b on a.user_id=b.user_id')
                        ->join('__LIVE__ c on a.live_id=c.live_id')
                        ->where($dat)
                        ->order('rand()')
                        ->limit(10)
                        ->select();
                    if ($live_store){
                        foreach ($live_store as $k=>$v){
                            // if($v['play_img']){
                            //     $live_store[$k]['img'] = C('IMG_PREFIX').$v['play_img'];

                            // }else{
                                $live_store[$k]['img'] = domain($v['img']);
                            // }
                            $live_store[$k]['play_img'] = domain($v['play_img']);
                            // $live_store[$k]['img'] = C('IMG_PREFIX').$v['img'];
                            $live_store[$k]['lebel'] = explode(',',$v['lebel']);
                            $live_store[$k]['is_type'] = "2";

                            $is_follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                            $is_follow ? $live_store[$k]['is_follow'] = "2" : $live_store[$k]['is_follow'] = "1";

        $count = M('Live_number')->alias('a')
            ->field('a.user_id2,b.user_id,b.img,b.thumb_img,b.username,b.grade,b.autograph,b.ID,b.hx_username,b.hx_password,b.money,b.get_money,b.sex,b.province,b.city,b.type')
            ->join('__USER__ b on a.user_id2 = b.user_id')
            ->where(['a.live_id'=>$live_store[$k]['live_id']])
            ->count();
        $live_store[$k]['watch_nums'] = $count;
                        }
                    }else{$live_store=[];}
                    $list = array_merge($list,$live_store);
                }
                success($list);
                break;
        }
    }


    /**
     * @音乐列表
     */
    public function music_list(){
        $keyworks = I('keyworks');
        $page = I('page'); $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        if ($keyworks){
            $data = [
                'song_name|singer'=>['like','%'.$keyworks.'%']
            ];
        }
        $list = M('Music')->where($data)->order('intime desc')->page($page,$pageSize)->select();
        if($list){
            foreach ($list as $k=>$v){
                $list[$k]['path'] = C('IMG_PREFIX').$v['path'];
            }
        }else{$list=[];}
        success($list);
    }


    /**
     * @地区列表
     */
    public function area_list(){
        $page = I('page'); $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $list = M('Live')
            ->field('sheng,count(sheng) as count')
            ->group('sheng')
            ->where(['live_status'=>1])
            ->order('count desc')
            ->page($page,$pageSize)
            ->select();
        $all['sheng'] = "热门";
        $all['count'] = M('Live')->where(['live_status'=>1])->count();
        array_unshift($list, $all);//向数组插入元素(放在第一位)
        $list ? $list = $list : $list = [];
        success($list);
    }

    /**
     * @进入直播间
     */
    public function into_live(){
        $user = checklogin();
        $user_id = I('uid');
        $live_id = I('live_id');
        empty($live_id) ? error('参数错误!') : true;
        $live = M('Live')->where(['live_id'=>$live_id])->find();
        if($live['live_status'] != '1')             error("直播已结束");
        M('Live_kicking')->where(['live_id'=>$live_id,'user_id'=>$user_id])->find() ? error('被踢出,无法进入!') : true;

        
        
        //M('Shield')->where(['user_id'=>M('Live')->getFieldByLive_id($live_id,'user_id'),'user_id2'=>$user_id])->find() ? error('被拉黑,无法进入!') : true;
        //进入直播间,把进入的其他正在直播的记录删除

        //fzy查询直播间是否付费，付费金额
        // $live = M('Live')->where(array('live_id'=>$live_id))->field('is_pay,pay_num')->find();
        // if ($live['is_pay'] == '1') {
        //     //判断记录表中是否付费过
        //     $pay_status = M('Live_pay_record')->where(array('live_id'=>$live_id,'user_id'=>$user_id))->getField('pay_status');
            // if ($pay_status == '1') {
            //    //用户对直播间付费过

            // } else {
               // //未付费，扣除用户的钻石
               //  //查询用户的钻石数量
               //  $user_money = M('User')->where(array('user_id'=>$user_id))->getField('money');
               //  if ($user_money >= $live['pay_num']) {
               //      //减去用户钻石
               //      $info = M('User')->where(array('user_id'=>$user_id))->setDec('money',$live['pay_num']);
               //      //插入付费记录表
               //      if($info != False){
               //          $arr['live_id'] = $live_id;
               //          $arr['user_id'] = $user_id;
               //          $arr['pay_status'] = 1;
               //          $arr['pay_num'] = $live['pay_num'];
               //          $arr['pay_time'] = time();
               //          M('Live_pay_record')->add($arr);
               //      }
                    

               //  } else {
               //      error('钻石不足，请先充值');
               //  }
                // error('请先付费');
            // }
        // }
        M('Live_number')->where(['user_id2'=>$user_id])->delete();
        $user_id2 = $live['user_id'];
        if (M('Live_number')->add(['live_id'=>$live_id,'user_id'=>$user_id2,'user_id2'=>$user_id,'intime'=>time()])){
            M('Live')->where(['live_id'=>$live_id])->save(['nums'=>$live['nums']+1,'watch_nums'=>$live['watch_nums']+1]);
            $is_follow = M('Follow')->where(['user_id' => $user_id, 'user_id2' => $user_id2])->find();
            $is_follow ? $is_follow = "2" : $is_follow = "1";
            $lignt_up = M('Live_light_up')->where(['live_id'=>$live_id,'user_id'=>$user_id,'user_id2'=>$user_id2])->find();
            $lignt_up ? $is_lignt_up = "2" : $is_lignt_up = "1";
            $prompt = M('System')->where(['id'=>1])->getField('prompt');
            $get_gradeinfo = get_gradeinfo($user['grade']);
            
            $result = ['is_follow'=>$is_follow,'is_lignt_up'=>$is_lignt_up,'prompt'=>$prompt,'grade_img'=>$get_gradeinfo['img'],'name'=>$get_gradeinfo['name'],'is_pay'=>$live['is_pay'],'pay_num'=>$live['pay_num']];
        }else{
            error('失败!');
        }
        success($result);
    }

    /**
     * @判断用户是否付费
     */
    public function check_pay(){
        $user = checklogin();
        $user_id = I('uid');
        $live_id = I('live_id');
        empty($live_id) ? error('参数错误!') : true;
        //查询房间付费记录表，用户是否付费
        $record = M('Live_pay_record')->where(array('user_id'=>$user_id,'live_id'=>$live_id))->find();
        if($record){
            $pay_status = $record['pay_status'];
            $is_pay = M('live')->where(array('live_id'=>$live_id))->getField('is_pay');
            if($is_pay == '2'){
                $pay_status = '0';
            }
        }else{
            $is_pay = M('live')->where(array('live_id'=>$live_id))->getField('is_pay');
            if($is_pay == '0'){
                $pay_status = '1';
            }else{
                $pay_status = '0';
            }
        }

        //查询用户的余额
        $money = M('User')->where(array('user_id'=>$user_id))->getField('money');
        $result = ['pay_status'=>$pay_status,'money'=>$money];

        success($result);
    }

    /**
     * @直播间付费
     */
    public function live_pay(){
        $user = checklogin();
        $user_id = I('uid');
        $live_id = I('live_id');
        empty($live_id) ? error('参数错误!') : true;
        $live = M('Live')->where(['live_id'=>$live_id])->find();
        if($live['live_status'] != '1')             error("直播已结束");
        M('Live_kicking')->where(['live_id'=>$live_id,'user_id'=>$user_id])->find() ? error('被踢出,无法进入!') : true;

        //判断直播类型是否付费，扣除钻石
        switch ($live['is_pay']) {
            case '0':
                //免费直播
                $pay_num = '0';
                success('免费直播');
                break;
            case '1':
                //按场次付费
                //先判断用户是否付过费
                $history = M('Live_pay_record')->where(array('user_id'=>$user_id,'live_id'=>$live_id))->find();
                if($history){
                    //已经付费过
                    $pay_num = '0';
                    success('直播已付费');

                }else{
                    $pay_num = $live['pay_num'];
                    if($user['money'] >= $pay_num){
                        M('user')->startTrans(); 
                        $info = M('user')->where(array('user_id'=>$user_id))->setDec('money',$pay_num);
                        //插入付费记录表
                        if($info != False){
                            $arr['live_id'] = $live_id;
                            $arr['user_id'] = $user_id;
                            $arr['pay_status'] = 1;
                            $arr['pay_num'] = $pay_num;
                            $arr['pay_time'] = time();
                            M('Live_pay_record')->add($arr);
                            M('user')->commit();
                            success('付费成功');
                        }else{
                            M('user')->rollback();
                            error('付费失败');
                        }
                    }else{
                        error('钻石余额不足');
                    }
                }
                
                break;
            case '2':
                //按时长付费（分钟）支付金额 = 分钟数($mins) * 收费金额（$live['pay_num']）
                $mins = I('mins')?I('mins'):'1';
                $pay_num = $live['pay_num'] * $mins;
                if($user['money'] >= $pay_num){
                    M('user')->startTrans(); 
                    $info = M('user')->where(array('user_id'=>$user_id))->setDec('money',$pay_num);
                    //插入付费记录表
                    if($info != False){
                        $arr['live_id'] = $live_id;
                        $arr['user_id'] = $user_id;
                        $arr['pay_status'] = 1;
                        $arr['pay_num'] = $pay_num;
                        $arr['pay_time'] = time();
                        M('Live_pay_record')->add($arr);
                        M('user')->commit();
                        success('付费成功');
                    }else{
                        M('user')->rollback();
                        error('付费失败');
                    }
                }else{
                    error('钻石余额不足');
                }
                break;
            default:
                # code...
                break;
        }

        // //查询直播间付费金额
        // $pay_num = M('Live')->where(array('live_id'=>$live_id))->getField('pay_num')?M('Live')->where(array('live_id'=>$live_id))->getField('pay_num'):'0';
        //  //查询用户的钻石数量
        // $user_money = M('User')->where(array('user_id'=>$user_id))->getField('money');
        // if ($user_money >= $pay_num) {
        //     //减去用户钻石
        //     $info = M('User')->where(array('user_id'=>$user_id))->setDec('money',$pay_num);
        //     //插入付费记录表
        //     if($info != False){
        //         $arr['live_id'] = $live_id;
        //         $arr['user_id'] = $user_id;
        //         $arr['pay_status'] = 1;
        //         $arr['pay_num'] = $pay_num;
        //         $arr['pay_time'] = time();
        //         M('Live_pay_record')->add($arr);
        //         success('付费成功');
        //     }else{
        //         error('付费失败');
        //     }
        // }

    }

    /**
     * @获取主播信息
     */
    public function get_live_info(){
        checklogin();
        $uid = I('uid');
        $user_id = I('user_id');
        empty($user_id) ? error('参数错误!') : true;
        $info = M('User')->where(['user_id'=>$user_id])->find();
        $city = M('Live')->where(['user_id'=>$user_id,'live_status'=>1])->getField('shi');
        if ($city){
            $info['city'] = $city;
        }elseif($info['city']){
            $info['city'] = $info['city'];
        }else{
            $info['city'] = "火星";
        }
        $info['img'] = domain($info['img']);
        $info['money'] = FormatMoney($info['money']);
        $info['follow_count'] = FormatMoney(M('Follow')->comment('关注数')->where(['user_id' =>$user_id])->count());
        $info['fans_count']  = FormatMoney(M('Follow')->comment('粉丝数')->where(['user_id2' =>$user_id])->count());
        $give_count = M('Give_gift')->comment('送礼数')->where(['user_id'=>$user_id])->sum('jewel');
        $give_count ? $info['give_count'] = FormatMoney($give_count) : $info['give_count'] = "0";
        //$info['give_count'] = FormatMoney(M('Give_gift')->comment('送礼数')->where(['user_id'=>$user_id])->count());
        $get_money = M('Give_gift')->where(['user_id2'=>$user_id])->sum('jewel');
        $get_money ? $info['get_money'] = FormatMoney($get_money) : $info['get_money'] = "0";
        $is_follow = M('Follow')->where(['user_id'=>$uid,'user_id2'=>$user_id])->find();
        $is_follow ? $info['is_follow'] = "2" : $info['is_follow'] = "1";



        $get_gradeinfo = get_gradeinfo($info['grade']);
        $info['grade_img'] = $get_gradeinfo['img'];
        $info['name'] = $get_gradeinfo['name'];
        success($info);
    }

    /**
     * @根据用户名获取用户信息
     */
    public function get_username_info(){
        checklogin();
        $uid = I('uid');
        $username = I('username');
        empty($username) ? error('参数错误!') : true;
        $user_id = M('User')->where(['username'=>$username])->getField('user_id');
        $info = M('User')->where(['user_id'=>$user_id])->find();
        $city = M('Live')->where(['user_id'=>$user_id,'live_status'=>1])->getField('shi');
        if ($city){
            $info['city'] = $city;
        }elseif($info['city']){
            $info['city'] = $info['city'];
        }else{
            $info['city'] = "火星";
        }
        $info['img'] = C('IMG_PREFIX').$info['img'];
        $info['money'] = FormatMoney($info['money']);
        $info['follow_count'] = FormatMoney(M('Follow')->comment('关注数')->where(['user_id' =>$user_id])->count());
        $info['fans_count']  = FormatMoney(M('Follow')->comment('粉丝数')->where(['user_id2' =>$user_id])->count());
        $info['give_count'] = FormatMoney(M('Give_gift')->comment('送礼数')->where(['user_id'=>$user_id])->count());
        $get_money = M('Give_gift')->where(['user_id2'=>$user_id])->sum('jewel');
        $get_money ? $info['get_money'] = $get_money : $info['get_money'] = "0";
        $is_follow = M('Follow')->where(['user_id'=>$uid,'user_id2'=>$user_id])->find();
        $is_follow ? $info['is_follow'] = "2" : $info['is_follow'] = "1";



        $get_gradeinfo = get_gradeinfo($info['grade']);
        $info['grade_img'] = $get_gradeinfo['img'];
        $info['name'] = $get_gradeinfo['name'];
        success($info);
    }

    public function show_viewer(){
        checklogin();
        $user_id = I('uid');
        $live_id = I('live_id');
        $page = I('page'); $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $live = M('live')->where(['live_id'=>$live_id])->find();
        empty($live_id) ? error('参数错误!') : true;
        $list = M('Live_number')->alias('a')
            ->field('a.user_id2,b.user_id,b.img,b.thumb_img,b.username,b.grade,b.autograph,b.ID,b.hx_username,b.hx_password,b.money,b.get_money,b.sex,b.province,b.city,b.type')
            ->join('__USER__ b on a.user_id2 = b.user_id')
            ->where(['a.live_id'=>$live_id])
            ->order('b.type desc,b.grade desc,b.is_fans asc')
            ->page($page,$pageSize)
            ->select();
        $count = M('live')->where(['live_id'=>$live_id])->getField('nums');
//        $management = M('Live_management')->comment("判断是否为管理员")->where(['user_id'=>$live['user_id']])->getField('user_id2',true);//管理员
//        $banned = M('Banned')->comment("判断是否禁言")->where(['live_id'=>$live_id])->getField('user_id2',true); //禁言
//        $follow = M('Follow')->where(['user_id'=>$user_id])->getField('user_id2',true);
        if ($list){
            foreach ($list as $k=>$v) {
                $list[$k]['img'] = C('IMG_PREFIX').$v['thumb_img'];
//                $list[$k]['follow_count'] = FormatMoney(M('Follow')->comment('关注数')->where(['user_id' =>$v['user_id2']])->count());
//                $list[$k]['fans_count']  = FormatMoney(M('Follow')->comment('粉丝数')->where(['user_id2' =>$v['user_id2']])->count());
                //查询是否关注
//                in_array($v['user_id2'],$follow) ? $list[$k]['is_follow'] = "2" : $list[$k]['is_follow'] = "1";
//                //查询是否被禁言
//                in_array($v['user_id2'],$banned) ? $list[$k]['is_banned'] = "2" : $list[$k]['is_banned'] = "1";
//                //查询是否是管理
//                in_array($v['user_id2'],$management) ? $list[$k]['is_management'] = "2" : $list[$k]['is_management'] = "1";

//                $give_count = M('Give_gift')->where(['user_id'=>$v['user_id']])->sum('jewel');
//                $give_count ? $list[$k]['give_count'] = FormatMoney($give_count) : $list[$k]['give_count'] ="0";
                //$list[$k]['give_count'] = FormatMoney(M('Give_gift')->comment('送礼数')->where(['user_id'=>$v['user_id']])->count());

                $get_gradeinfo = get_gradeinfo($v['grade']);
                $list[$k]['grade_img'] = $get_gradeinfo['img'];
                $list[$k]['name'] = $get_gradeinfo['name'];
//
//                $get_money = M('Give_gift')->where(['user_id2'=>$v['user_id']])->sum('jewel');
//                $get_money ? $list[$k]['get_money'] = FormatMoney($get_money) : $list[$k]['get_money'] = "0";
                $list[$k]['get_money'] = '0';
                $list[$k]['give_count'] ='0';
                $list[$k]['fans_count'] = '0';
                $list[$k]['follow_count'] = '0';
                $list[$k]['is_follow'] = "1";
                $list[$k]['is_banned'] = "1";
                $list[$k]['is_management'] = "1";
                if($v['city']){
                    $list[$k]['city'] = $v['city'];
                }else{
                    $list[$k]['city'] = "火星";
                }
            }
        }else{$list=[];}
        $result = ['count'=>$count,'list'=>$list];
        success($result);
    }


    /**
     * @踢人
     */
    public function kicking(){
        checklogin();
        $live_id = I('live_id');  $user_id = I('user_id');
        (empty($live_id) || empty($user_id)) ? error('参数错误!') : true;
        $table_live_kicking = M('Live_kicking'); $table_live_number = M('Live_number');
        $table_live_kicking->startTrans();  //开启事物
        if ($table_live_kicking->add(['live_id'=>$live_id,'user_id'=>$user_id,'intime'=>time(),'date'=>date('Y-m-d',time())])){
            $live_number = $table_live_number->where(['live_id'=>$live_id,'user_id2'=>$user_id])->delete();
            if (!$live_number){
                $table_live_kicking->rollback();
                error('失败!');
            }
            $table_live_kicking->commit();
            success('成功!');
        }else{
            $table_live_kicking->rollback();
            error('失败!');
        }
    }

    /**
     * @禁言(取消禁言)
     */
    public function banned(){
        checklogin();
        $user_id = I('uid');
        $user_id2 = I('user_id'); $type = I('type'); $live_id = I('live_id');
        (empty($user_id2) || empty($type) || empty($live_id)) ? error('参数错误!') : true;
        $uid = M('Live')->getFieldByLive_id($live_id,'user_id');   //主播id
        $ba = M('Banned')->where(['live_id'=>$live_id,'user_id'=>$uid,'user_id2'=>$user_id2])->find();
        switch ($type){
            case 1:
                if ($ba){
                    error('已被禁言!');
                }else{
                    if (M('Banned')->add(['live_id'=>$live_id,'user_id'=>$uid,'user_id2'=>$user_id2,'intime'=>time()])){
                        success('成功!');
                    }else{
                        error('失败!');
                    }
                }
                break;
            case 2:
                if ($ba){
                    if (M('Banned')->where(['banned_id'=>$ba['banned_id']])->delete()){
                        success('成功!');
                    }else{
                        error('失败!');
                    }
                }else{
                    error('还未被禁言!');
                }
        }
    }

    /**
     * @判断是否被禁言
     */
    public function get_banned(){
        checklogin();
        $user_id = I('uid');
        $live_id = I('live_id');
        empty($live_id) ? error('参数错误!') : true;
        $user_id2 = M('Live')->getFieldByLive_id($live_id,'user_id');
        if (M('Banned')->where(['live_id'=>$live_id,'user_id'=>$user_id2,'user_id2'=>$user_id])->find()){
            $result = "1";
        }else{
            $result = "2";
        }
        success($result);
    }

    /**
     * @设为管理(取消管理)
     * @type  1:设为管理   2:取消管理
     */
    public function live_manag(){
        checklogin();
        $user_id = I('uid'); $user_id2 = I('user_id'); $type = I('type');
        (empty($user_id2) || empty($type)) ? error('参数错误!') : true;
        ($type==1 || $type==2) ? true : error('传值错误!');
        $man = M('Live_management')->where(['user_id'=>$user_id,'user_id2'=>$user_id2])->find();
        switch ($type){
            case 1:
                if ($man){
                    error('已经设为管理!');
                }else{
                    if (M('Live_management')->add(['user_id'=>$user_id,'user_id2'=>$user_id2,'intime'=>time()])){
                        success('成功!');
                    }else{
                        error('失败!');
                    }
                }
                break;
            case 2:
                if (!$man){
                    error('还未设为管理!');
                }else{
                    if (M('Live_management')->where(['live_management_id'=>$man['live_management_id']])->delete()){
                        success('成功!');
                    }else{
                        error('失败!');
                    }
                }
                break;
        }
    }
    /**
     * @管理列表
     */
    public function management_list(){
        $user = checklogin();
        $live_id = I('live_id');
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $live = M('Live')->find($live_id);
        empty($live_id) ? error('参数错误!') : true;
        $list = M('Live_management')
            ->alias('a')
            ->field('b.user_id,b.username,b.img,b.ID,b.hx_username,b.grade')
            ->join('__USER__ b on a.user_id2=b.user_id')
            ->where(['a.user_id'=>$live['user_id']])
            ->page($page,$pageSize)
            ->order('a.intime desc')
            ->select();
        if ($list){
            foreach ($list as $k=>$v) {
                $list[$k]['img'] = C('IMG_PREFIX').$v['img'];
                $follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$v['user_id']])->find();
                $follow ? $list[$k]['is_follow'] = "2" : $list[$k]['is_follow'] = "1";

                $get_gradeinfo = get_gradeinfo($v['grade']);
                $list[$k]['grade_img'] = $get_gradeinfo['img'];
                $list[$k]['name'] = $get_gradeinfo['name'];
            }
        }else{$list=[];}
        success($list);
    }


    /**
     * @判断是否是管理
     */
    public function is_mangement(){
        checklogin();
        $user_id = I('uid');
        $live_id = I('live_id');
        empty($live_id) ? error('参数错误!') : true;
        $user_id2 = M('Live')->getFieldByLive_id($live_id,'user_id');
        if (M('Live_management')->where(['user_id'=>$user_id2,'user_id2'=>$user_id])->find()){
            $result = "2";
        }else{
            $result = "1";
        }
        success($result);
    }

    /**
     * @退出直播间
     */
    public function out_live(){
        checklogin();
        $user_id = I('uid');
        $live_id = I('live_id');
        empty($live_id) ? error('参数错误!') : true;
        $user_id2 = M('Live')->getFieldByLive_id($live_id,'user_id');
        $count = M('Live')->getFieldByLive_id($live_id,'watch_nums');
        if ($count==0){
            M('Live_number')->comment('删除记录')->where(['live_id'=>$live_id,'user_id'=>$user_id2,'user_id2'=>$user_id])->delete();
            success('成功!');
        }
        if (M('Live')->where(['live_id' =>$live_id])->setDec('watch_nums')){
            M('Live_number')->comment('删除记录')->where(['live_id'=>$live_id,'user_id'=>$user_id2,'user_id2'=>$user_id])->delete();
            success('成功!');
        }else{
            error('失败!');
        }
    }

    /**
     * @点亮
     */
    public function lignt_up(){
        checklogin();
        $user_id = I('uid');
        $live_id = I('live_id');
        empty($live_id) ? error('参数错误!') : true;
        $user_id2 = M('Live')->getFieldByLive_id($live_id,'user_id');
        $lignt_up = M('Live_light_up')->where(['live_id'=>$live_id,'user_id'=>$user_id,'user_id2'=>$user_id2])->find();
        if($lignt_up){
            error('已点亮!');
        }else{
            if (M('Live_light_up')->add(['live_id'=>$live_id,'user_id'=>$user_id,'user_id2'=>$user_id2,'intime'=>time()])){
                M('Live')->comment('点亮数加1')->where(['live_id'=>$live_id])->setInc('light_up_count');
                success('成功!');
            }else{
                error('失败!');
            }
        }
    }


    /**
     * @日榜、周榜、总榜
     * $type  1:日榜   2:周榜  3:总榜
     */
    public function total_list(){
        $user = checklogin();
        $type = I('type'); $user_id = I('user_id'); //主播id
        (empty($type) || empty($user_id)) ? error('参数错误!') : true;
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        switch ($type){
            case 1:
                $where = [
                    'a.user_id2'=>$user_id,
                    'a.date'=>date('Y-m-d',time())
                ];
                break;
            case 2:
                $where = [
                    'a.user_id2'=>$user_id,
                    'a.intime'=>['gt',time()-(7*24*60*60)]
                ];
                break;
            case 3:
                $where = [
                    'a.user_id2'=>$user_id,
                ];
                break;
        }
        $list = M('Give_gift')
            ->alias('a')
            ->field('b.user_id,b.img,b.username,b.hx_username,sum(jewel) as count,b.grade')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->group('a.user_id')
            ->where($where)
            ->order('count desc')
            ->page($page,$pageSize)
            ->select();
        if ($list){
            $count = count($list);
            foreach ($list as $k=>$v){
                if ($count>=2){     //第一位置和第二位置调换
                    $a=$list[0];
                    $list[0]=$list[1];
                    $list[1]=$a;
                }
            }
            foreach ($list as $k=>$v){
                $list[$k]['img'] = C('IMG_PREFIX').$v['img'];
                $is_follow = M('Follow')->where(['user_id'=>$user['user_id'],'user_id2'=>$user_id])->find();
                $is_follow ? $list[$k]['is_follow'] = "2" : $list[$k]['is_follow'] = "1";

                $get_gradeinfo = get_gradeinfo($v['grade']);
                $list[$k]['grade_img'] = $get_gradeinfo['img'];
                $list[$k]['name'] = $get_gradeinfo['name'];
            }
        }else{$list=[];}
        success($list);
    }



    /**
     * @举报类型列表(原因)
     * @type   1:直播间举报主播   2:举报用户
     */
    public function report_why(){
        $type = I('type');
        empty($type) ? error('参数错误!') : true;
        $list = M('Report_why')->where(['type'=>$type])->select();
        if (!$list){$list=[];}
        success($list);
    }


    /**
     * @举报(直播间举报)
     */
    public function report(){
        $user = checklogin();
        $live_id = I('live_id'); $user_id = I('user_id'); //主播id
        $why = I('why');
        (empty($live_id) || empty($user_id)) ? error('参数错误!') : true;
        if (M('Report')->add(['user_id'=>$user['user_id'],'live_id'=>$live_id,'user_id2'=>$user_id,'why'=>$why,'intime'=>time(),'type'=>1])){
            success('成功!');
        }else{
            error('失败!');
        }
    }







    /**
     * @关注（取消关注）
     * @type  1:关注   2：取消关注
     */
    public function follow(){
        checklogin();
        $user_id = I('uid');
        $user_id2 = I('user_id2');
        $type = I('type');
        (empty($type) || empty($user_id2)) ? error('参数错误!') : true;
        ($type == 1 || $type == 2) ? true : error('传值错误!');
        if ($user_id == $user_id2) error("传值错误");
        $check = M('Follow')->where(['user_id' => $user_id, 'user_id2' => $user_id2])->find();
        if ($type == 1) {
            if ($check) error("已关注");
            if (M('Shield')->where(['user_id'=>$user_id2,'user_id2'=>$user_id])->find()){success('成功!');} //如果被拉黑,返回成功,但是不是真正的成功
            if (M('Follow')->add(['user_id' => $user_id, 'user_id2' => $user_id2, 'intime' => time()])) {
                success('成功!');
            } else {
                error('失败!');
            }
        } else {
            if (!$check) error("未关注");
            if (M('Follow')->where(['user_id' => $user_id, 'user_id2' => $user_id2])->delete()) {
                success('成功!');
            } else {
                error('失败!');
            }
        }
    }

    /**
     * 结束直播(主播端)
     */
    public function end_live(){
        checklogin();
        $user_id = I('uid');
        $live_id = I('live_id');
        empty($live_id) ? error('参数错误!') : true;

        
        if (M('Live')->where(['live_id'=>$live_id])->save(['end_time'=>time(),'live_status'=>2,'is_normal_exit'=>1])){
            $live = M('Live')->alias('a')
                ->field('a.live_id,a.user_id,a.play_img,a.title,a.start_time,a.end_time,a.watch_nums,a.share,a.stream_key,a.room_id,b.img,b.username,b.company,b.duty,b.autograph,b.ID,a.a_id')
                ->join('__USER__ b on a.user_id=b.user_id')
                ->where(['live_id'=>$live_id])
                ->find();

                /**更改活动数据**/
                    M('activity')->where(array('type'=>2,'a_id'=>$live['a_id']))->setField(array('type'=>3,'x_id'=>0,'store_status'=>2));
                /**更改活动数据**/
            if (time()-$live['start_time']>10) {
                //保存视频
                import('Vendor.Qiniu.Pili');
                $system = M('System')->where(['id' => 1])->find();
                $ak = $system['ak'];
                $sk = $system['sk'];
                $hubName = $system['hubname'];
                $mac = new \Qiniu\Pili\Mac($ak, $sk);
                $client = new \Qiniu\Pili\Client($mac);
                $hub = $client->hub($hubName);
                //获取stream
                $streamKey = $live['stream_key'];
                $stream = $hub->stream($streamKey);

                

                //保存直播数据
                $fname = $stream->save(0, 0);
                if ($fname['fname']) {
                    $url = 'http://dspxplay.tstmobile.com/' . $fname['fname'];
                    $data = [
                        'live_id' => $live_id,
                        'user_id' => $live['user_id'],
                        'play_img' => $live['play_img'],
                        'title' => $live['title'],
                        'url' => $url,
                        'intime' => time(),
                        'room_id' => $live['room_id'],
                        'date' => date('Y-m-d', time())
                    ];
                    $res = M('Live_store')->add($data);
                }

                /**更改活动数据**/
                    M('activity')->where(array('type'=>3,'a_id'=>$live['a_id']))->setField(array('x_id'=>$res,'store_status'=>1));
                /**更改活动数据**/
            }
            $url ? $live['url'] = $url : $live['url'] = "";
            $list = M('Live')->where(['date'=>date('Y-m-d',time())])->order('nums desc')->select();
            foreach ($list as $k=>$v){
                if ($v['live_id']==$live_id){
                    $aa = $k;
                }
            }
            $cout = count($list);
            $live['beat'] = (string)(floor((($cout-$aa)/$cout)*100));

            $live['play_img'] = domain($live['play_img']);
            $live['img'] = domain($live['img']);
            $timediff = $live['end_time']-$live['start_time'];
            //计算小时数
            $remain = $timediff%86400;
            $hours = intval($remain/3600);
            //计算分钟数
            $remain = $remain%3600;
            $mins = intval($remain/60);
            //计算秒数
            $secs = $remain%60;
            $live['time'] = $hours.":".$mins.":".$secs;
            $get_fire = M('Give_gift')->where(['live_id'=>$live_id])->sum('jewel');
            $get_fire ? $live['get_fire'] = $get_fire : $live['get_fire'] = "0";


            success($live);
        }else{
            error('失败!');
        }
    }

    /**
     * @强制下线
     */
    public function forced_offline(){
        $live_id = I('live_id');
        empty($live_id) ? error('参数错误!') : true;
        $live = M('Live')->find($live_id);

        /**更改活动数据**/
            M('activity')->where(array('type'=>2,'a_id'=>$live['a_id']))->setField(array('type'=>3,'x_id'=>0,'store_status'=>2));
        /**更改活动数据**/

        //保存视频
        import('Vendor.Qiniu.Pili');
        $system = M('System')->where(['id' => 1])->find();
        $ak = $system['ak'];
        $sk = $system['sk'];
        $hubName = $system['hubname'];
        $mac = new \Qiniu\Pili\Mac($ak, $sk);
        $client = new \Qiniu\Pili\Client($mac);
        $hub = $client->hub($hubName);
        //获取stream
        $streamKey = $live['stream_key'];
        $stream = $hub->stream($streamKey);
        $result = $stream->disable();
        M('Live')->where(['live_id'=>$live_id])->save(['end_time'=>time(),'live_status'=>2,'is_normal_exit'=>2]);
        success('成功!');
    }

    /**
     * @结束直播(观看端)
     */
    public function live_end(){
        //$user = checklogin();
        $user_id = I('uid');
        $live_id = I('live_id');
        empty($live_id) ? error('参数错误!') : true;
        $live = M('Live')->alias('a')
            ->field('a.live_id,a.user_id,a.play_img,a.title,a.start_time,a.end_time,a.watch_nums,b.img,b.username,b.company,b.duty,b.autograph')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['live_id'=>$live_id])
            ->find();
        $live['play_img'] = domain($live['play_img']);
        $live['img'] = domain($live['img']);
        $timediff = $live['end_time']-$live['start_time'];
        //计算小时数
        $remain = $timediff%86400;
        $hours = intval($remain/3600);
        //计算分钟数
        $remain = $remain%3600;
        $mins = intval($remain/60);
        //计算秒数
        $secs = $remain%60;
        $live['time'] = $hours.":".$mins.":".$secs;
        if (empty($user_id)){
            $live['is_follow'] = "1";
        }else{
            $is_follow = M('Follow')->where(['user_id'=>$user_id,'user_id2'=>$live['user_id']])->find();
            $is_follow ? $live['is_follow'] = "2" : $live['is_follow'] = "1";
        }
        success($live);
    }

    /**
     * @礼物列表
     */
    public function gift_list(){
        checklogin();
        $list = M('Gift')->order('intime desc')->select();
        if ($list){
            foreach($list as $k=>$v){
                $list[$k]['img'] = C('IMG_PREFIX').$v['img'];
            }
        }else{$list=[];}
        success($list);
    }
    /**
     * @送礼
     */
    public function give_gift(){
        $user = checklogin();
        // $live_id = I('live_id'); 
        $a_id = I('a_id'); 
        $gift_id = I('gift_id');
        (empty($a_id) || empty($gift_id)) ? error('参数错误!') : true;
        $user_table = M('User');  $gift_table = M('Gift'); $live_table = M('Live'); $give_gift_table = M('Give_gift');
        $user_table->startTrans();  //开启事物
        $gift = $gift_table->where(['gift_id' => $gift_id])->find();
        $user['money'] - $gift['price'] < 0 ? error('余额不足!') : true;

        $user_money = $user['money']-$gift['price'];       //用户扣除之后的金额
        $user_experience = $user['experience'] + $gift['experience'];   //计算用户经验

        $up_myinfo = $user_table->where(['user_id' =>$user['user_id']])->save(['money' => $user_money,'experience'=>$user_experience,'uptime' => time()]);

        if ($up_myinfo) {

            // $user_id2 = $live_table->getFieldByLive_id($live_id,'user_id');    //主播id
            $user_id2 = M('activity')->where(['a_id'=>$a_id])->getField('user_id');    //主播id
            $get_money = $user_table->getFieldByUser_id($user_id2, 'get_money') + $gift['price'];   //主播获得之后的金额
            $up_live_info = $user_table->where(['user_id' => $user_id2])->save(['get_money' => $get_money, 'uptime' => time()]);
            if (!$up_live_info){
                $user_table->rollback();
                error('点击太快!');
            }

            $data = [
                'user_id' => $user['user_id'],
                // 'live_id'=>$live_id,
                'a_id'=>$a_id,
                'user_id2' => $user_id2,
                'gift_id' => $gift_id,
                'intime' => time(),
                'date' => date('Y-m-d', time()),
                'jewel' => $gift['price'],
                'experience' => $gift['experience']
            ];
            $add_give_gift = $give_gift_table->add($data);
            if (!$add_give_gift){
                $user_table->rollback();
                error('点击太快!');
            }

            //等级提升
            ascension_grade($user['user_id'],$user_experience);


            $user_table->commit();
            success('成功!');
        } else {
            $user_table->rollback();
            error('失败!');
        }
    }

    /**
     * @私信送礼
     */
    public function direct_give_gift(){
        $user = checklogin();
        $user_id2 = I('user_id');  $gift_id = intval(I('gift_id'));
        (empty($user_id2) || empty($gift_id)) ? error('参数错误!') : true;
        $user_table = M('User');  $gift_table = M('Gift'); $give_gift_table = M('Give_gift');
        $user_table->startTrans();  //开启事物
        $gift = $gift_table->where(['gift_id' => $gift_id])->find();
        $user['money'] - $gift['price'] < 0 ? error('余额不足!') : true;
        $user_money = $user['money']-$gift['price'];       //用户扣除之后的金额
        $user_experience = $user['experience'] + $gift['experience'];   //计算用户经验
        $up_myinfo = $user_table->where(['user_id' =>$user['user_id']])->save(['money' => $user_money,'experience'=>$user_experience,'uptime' => time()]);
        if ($up_myinfo) {
            $get_money = $user_table->getFieldByUser_id($user_id2, 'get_money') + $gift['price'];   //主播获得之后的金额
            $up_live_info = $user_table->where(['user_id' => $user_id2])->save(['get_money' => $get_money, 'uptime' => time()]);
            if (!$up_live_info){
                $user_table->rollback();
                error('点击太快!');
            }$data = [
                'user_id' => $user['user_id'],
                'user_id2' => $user_id2,
                'gift_id' => $gift_id,
                'intime' => time(),
                'date' => date('Y-m-d', time()),
                'jewel' => $gift['price'],
                'experience' => $gift['experience'],
                'type'=>2
            ];
            $add_give_gift = $give_gift_table->add($data);
            if (!$add_give_gift){
                $user_table->rollback();
                error('点击太快!');
            }

            //等级提升
            ascension_grade($user['user_id'],$user_experience);


            $user_table->commit();
            success('成功!');
        } else {
            $user_table->rollback();
            error('失败!');
        }
    }

    /**
     * @弹幕扣钱
     */
    public function screen_price(){
        $user = checklogin();
        $live_id = I('live_id');  empty($live_id) ? error('参数错误!') : true;
        $system_table = M('System'); $user_table = M('User');  $live_table = M('Live'); $screen_table = M('Screen');
        $user_table->startTrans();  //开启事物
        $price = $system_table->where(['id'=>1])->field('screen_price,experience')->find();
        $user['money']-$price['screen_price']<0 ? error('余额不足!') : true;
        $user_money = $user['money']-$price['screen_price'];
        $user_experience = $user['experience'] + $price['experience'];   //计算用户经验
        $up_myinfo = $user_table->where(['user_id'=>$user['user_id']])->save(['money'=>$user_money,'experience'=>$user_experience,'uptime'=>time()]);

        if ($up_myinfo){
            $live_user_id = $live_table->where(['live_id'=>$live_id])->getField('user_id'); //主播id
            $u_money = $user_table->where(['user_id'=>$live_user_id])->getField('get_money')+$price['screen_price'];
            $up_live_info = $user_table->where(['user_id'=>$live_user_id])->save(['get_money'=>$u_money,'uptime'=>time()]);
            if (!$up_live_info){
                $user_table->rollback();
                error('失败!');
            }

            $add_screen = $screen_table->add(['live_id'=>$live_id,'user_id'=>$live_user_id,'user_id2'=>$user['user_id'],'intime'=>time()]);
            if (!$add_screen){
                $user_table->rollback();
                error('失败!');
            }

            //等级提升
            ascension_grade($user['user_id'],$user_experience);

            $user_table->commit();
            success('成功!');
        }else{
            $user_table->rollback();
            error('失败!');
        }
    }

    /**
     * @按home键
     * $type   1:退出   2:进入
     */
    public function home_live(){
        checklogin();
        $user_id = I('uid');
        $type = I('type');
        empty($type) ? error('参数错误!') : true;   ($type==1 || $type==2) ? true : error('传值错误!');
        $live = M('Live')->where(['user_id'=>$user_id,'live_status'=>1])->find();
        switch ($type){
            case 1:
                if ($live){
                    M('Live')->where(['live_id'=>$live['live_id']])->save(['live_time'=>time(),'uptime'=>time()]);
                }
                success('成功!');
                break;
            case 2:
                if ($live){
                    if (!empty($live['live_time'])){
                        if (time() - $live['live_time'] > 3 * 60) {
                            M('Live')->where(['live_id'=>$live['live_id']])->save(['live_status'=>2,'end_time'=>time(),'uptime'=>time()]);
                            //保存视频
                            import('Vendor.Qiniu.Pili');
                            $system = M('System')->where(['id' => 1])->find();
                            $ak = $system['ak'];
                            $sk = $system['sk'];
                            $hubName = $system['hubname'];
                            $mac = new \Qiniu\Pili\Mac($ak, $sk);
                            $client = new \Qiniu\Pili\Client($mac);
                            $hub = $client->hub($hubName);
                            //获取stream
                            $streamKey = $live['stream_key'];
                            $stream = $hub->stream($streamKey);

                    /**更改活动数据**/
                    M('activity')->where(array('type'=>2,'a_id'=>$live['a_id']))->setField(array('type'=>3,'x_id'=>0,'store_status'=>2));
                    /**更改活动数据**/

                            //保存直播数据
                            $fname = $stream->save(0, 0);
                            if ($fname['fname']) {
                                $data = [
                                    'live_id' => $live['live_id'],
                                    'user_id' => $live['user_id'],
                                    'play_img' => $live['play_img'],
                                    'title' => $live['title'],
                                    'url' => 'http://dspxplay.tstmobile.com/' . $fname['fname'],
                                    'intime' => time(),
                                    'room_id' => $live['room_id'],
                                    'date'=>date('Y-m-d',time())
                                ];
                                $stream->disable();
                                $res = M('Live_store')->add($data);
                            }

                    /**更改活动数据**/
                    M('activity')->where(array('type'=>3,'a_id'=>$live['a_id']))->setField(array('x_id'=>$res,'store_status'=>1));
                    /**更改活动数据**/
                            error("直播结束");
                        }else{
                            $result = ['nums' => $live['watch_nums'], 'push_flow_address' => $live['push_flow_address'], 'room_id' => $live['room_id'], 'ID' => M('User')->getFieldByUser_id($user_id,'ID'), 'money' => M('User')->getFieldByUser_id($user_id,'get_money'), 'start_time' =>$live['start_time'], 'url' => M('User')->getFieldByUser_id($user_id,'url')];
                        }
                    }else{
                        M('Live')->save(['live_status'=>1,'live_time'=>0,'uptime'=>time()]);
                        $result = ['nums' => $live['watch_nums'], 'push_flow_address' => $live['push_flow_address'], 'room_id' => $live['room_id'], 'ID' => M('User')->getFieldByUser_id($user_id,'ID'), 'money' => M('User')->getFieldByUser_id($user_id,'get_money'), 'start_time' =>$live['start_time'], 'url' => M('User')->getFieldByUser_id($user_id,'url')];
                    }
                    success($result);
                }else{
                    error('没有直播!');
                }
                break;
        }
    }
    /**
     *判断主播是否下线
     */
    public function check_anchor_state(){
            checklogin();
            $anchor_id = I('user_id');
            $live = M('Live')->where(['user_id'=>$anchor_id,'live_status'=>1])->find();
            if(!$live){
                error("主播已下线");
            }else{
                success("ok");
            }
    }


//    /**
//     * @拉黑
//     */
//    public function shield(){
//        checklogin();
//        $user_id = I('uid');
//        $user_id2 = I('user_id'); $live_id = I('live_id');
//        $uid = M('Live')->getFieldByLive_id($live_id,'user_id');
//        (empty($user_id2) || empty($live_id)) ? error('参数错误!') : true;
//        $shield = M('Shield')->where(['user_id'=>$uid,'user_id2'=>$user_id2])->find();
//        if ($shield){
//            error('已拉黑!');
//        }else{
//            if (M('Shield')->add(['live_id'=>$live_id,'user_id'=>$uid,'user_id2'=>$user_id2,'intime'=>time()])){
//                //环信拉黑
//                $hx_username = M('User')->getFieldByUser_id($user_id,'hx_username');
//                $hx_username2 = M('User')->getFieldByUser_id($user_id2,'hx_username');
//                addUserForBlacklist($hx_username,$hx_username2);
//
//                //把拉黑的从直播间踢出去
//                M('Live_number')->where(['live_id'=>$live_id,'user_id'=>$uid,'user_id2'=>$user_id2])->delete();
//
//                success($user_id2);
//            }else{
//                error('失败!');
//            }
//        }
//    }

    /**
     * @拉黑
     * @type  1:拉黑   2:取消拉黑
     */
    public function shield(){
        $user = checklogin();
        $live_id = I('live_id');
        $user_id2 = I('user_id2'); $type = I('type');
        if ($live_id){
            $user_id = M('Live')->where(['live_id'=>$live_id])->getField('user_id');
        }else{
            $user_id = $user['user_id'];
        }
        (empty($user_id2) || empty($type)) ? error('参数错误!') : true;
        $shield = M('Shield')->where(['user_id'=>$user_id,'user_id2'=>$user_id2])->find();
        switch ($type){
            case 1:
                if ($shield){
                    error('已拉黑!');
                }else{
                    if (M('Shield')->add(['user_id'=>$user_id,'user_id2'=>$user_id2,'intime'=>time()])){
                        //环信拉黑
                        $hx_username = M('User')->getFieldByUser_id($user_id,'hx_username');
                        $hx_username2 = M('User')->getFieldByUser_id($user_id2,'hx_username');
                        addUserForBlacklist($hx_username,$hx_username2);

                        //关注关系取消
                        $follow = M('Follow')->where(['user_id'=>$user_id,'user_id2'=>$user_id2])->find();
                        if ($follow){M('Follow')->where(['follow_id'=>$follow['follow_id']])->delete();}
                        $follow2 = M('Follow')->where(['user_id'=>$user_id2,'user_id2'=>$user_id])->find();
                        if ($follow2){M('Follow')->where(['follow_id'=>$follow2['follow_id']])->delete();}

                        success($user_id2);
                    }else{
                        error('失败!');
                    }
                }
                break;
            case 2:
                if ($shield){
                    if (M('Shield')->where(['shield_id'=>$shield['shield_id']])->delete()){
                        $hx_username = M('User')->getFieldByUser_id($user_id,'hx_username');
                        $hx_username2 = M('User')->getFieldByUser_id($user_id2,'hx_username');
                        deleteUserFromBlacklist($hx_username,$hx_username2);  //环信移除黑名单
                        success('成功!');
                    }else{
                        error('失败!');
                    }
                }else{
                    error('未拉黑!');
                }
                break;
        }

    }

    /**
     * @判断直播间中用户是否被拉黑、禁言、是否是管理
     */
    public function check_user(){
        $user = checklogin();
        $live_id = I('live_id');   $user_id = I('user_id');
        empty($live_id) ? error('参数错误!') : true;
        $live = M('Live')->find($live_id);
        $shield = M('Shield')->where(['user_id'=>$live['user_id'],'user_id2'=>$user_id])->find();    //是否被拉黑
        $shield ? $is_shield = "2" : $is_shield = "1";
        $banned = M('Banned')->where(['live_id'=>$live_id,'user_id2'=>$user_id])->find();      //是否被禁言
        $banned ? $is_banned = "2" : $is_banned = "1";
        $management = M('Live_management')->where(['user_id'=>$live['user_id'],'user_id2'=>$user_id])->find();  //是否是管理
        $management ? $is_management = "2" : $is_management = "1";
        $result = ['is_shield'=>$is_shield,'is_banned'=>$is_banned,'is_management'=>$is_management];
        success($result);
    }

    /**
     * @当前登录用户的余额
     */
    public function get_money(){
        $user = checklogin();
        $result = ['money'=>$user['money'],'grade'=>$user['grade']];
        success($result);
    }

    /**
     * @获取用户火力
     */
    public function get_get_money(){
//        $user = checklogin();
//        $user_id = I('user_id');
//        if (empty($user_id)){
//            $money = $user['get_money'];
//        }else{
//            $money = M('User')->getFieldByUser_id($user_id,'get_money');
//        }
        $user = checklogin();
        $user_id = I('user_id');
        if (empty($user_id)){
            $money = M('Give_gift')->where(['user_id2'=>$user['user_id']])->sum('jewel');
            $money ? $money = $money : $money = "0";
        }else{
            $money = M('Give_gift')->where(['user_id2'=>$user_id])->sum('jewel');
            $money ? $money = $money : $money = "0";
        }
        success($money);
    }


    /**
     * @每分钟更新一下,
     */
    public function is_receive(){
        $live_id = I('live_id');
        $user_id = I('user_id');
        (empty($live_id) || empty($user_id)) ? error('参数错误!') : true;
        $re = M('Receive')->where(['live_id'=>$live_id,'user_id'=>$user_id])->find();
        if ($re){
            M('Receive')->where(['receive_id'=>$re['receive_id']])->save(['intime'=>time()]);
        }else{
            M('Receive')->add(['live_id'=>$live_id,'user_id'=>$user_id,'intime'=>time()]);
        }
        success('成功!');
    }

    /**
     * @充值价格列表
     */
    public function price_list(){
        checklogin();
        $list = M('Price')->select();
        if (!$list){$list=[];}
        success($list);
    }



    // /**
    //  * @轮播图
    //  */
    // public function banner_list(){
    //     $list = M('Banner')->order('remark desc')->select();
    //     if ($list){
    //         foreach ($list as $k=>$v){
    //             $list[$k]['b_img'] = C('IMG_PREFIX').$v['b_img'];
    //             $list[$k]['url'] = C('IMG_PREFIX')."/App/Index/banner/b_id/" . base64_encode($v['b_id']);
    //             $list[$k]['content'] = "";
    //         }
    //     }else{$list=[];}
    //     success($list);
    // }

    //轮播
    public function banner_list(){
        /****轮播****/
        $type = I('type');
        $type ? $map['type'] = $type : $map['type'] = '1';
        $map['is_del'] = '1';
        $map['status'] = '2';
        $list = M('shop_banner')->field("b_id,b_img,url,b_type,title,jump")
            ->where($map)->order("sort asc")->select();
       if(!empty($list)){
           // foreach($list as &$v){
           //     switch($v['b_type']){
           //         case 1:
           //             $v['jump'] = '';
           //             break;
           //         case 2:
           //             $v['jump'] = $this->url.'/api/Home/banner_url/id/'.$v['b_id'];
           //             break;
           //         case 3:
           //             $v['jump'] = $v['value'];
           //             break;
           //         case 4:
           //             $v['jump'] = $v['value'];
           //             break;
           //     }
           // }
       }else{
           $list = [];
       }
        return success($list);
    }
    /**
     * @轮播图内容
     */
    public function banner(){
        $b_id = base64_decode(I('b_id'));
        $content = M('Banner')->where(['b_id'=>$b_id])->getField('content');
        $this->assign('content',htmlspecialchars_decode($content));
        $this->display();
    }

    /**
     *@轮播web跳转页
     */
    public function banner_url(){
        $b_id = input('id');
        $content = M('Banner')->where(['b_id'=>$b_id])->getField('content');
        $this->assign(['content'=>htmlspecialchars_decode($content)]);
        $this->display();
        
    }




    /****************************************************关注********************************************************************/

    /**
     * @关注列表
     */
    public function follow_list(){
        $user = checklogin();
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        //直播列表
        $list1 = M('Follow')
            ->alias('a')
            ->field('a.follow_id,b.user_id,b.username,b.img,b.ID,b.get_money,b.hx_username,c.live_id,c.play_img,c.title,c.play_address,c.start_time,c.room_id,c.watch_nums,c.nums')
            ->join('__USER__ b on a.user_id2=b.user_id')
            ->join('__LIVE__ c on a.user_id2=c.user_id')
            ->where(['a.user_id'=>$user['user_id'],'c.live_status'=>1])
            ->order('a.intime desc')
            ->select();
        if ($list1){
            foreach ($list1 as $k=>$v){
                $list1[$k]['img'] = domain($v['img']);
                $list1[$k]['play_img'] = domain($v['play_img']);
            }
        }else{$list1=[];}
        //视频列表
        $list2 = M('Follow')
            ->alias('a')
            ->field('a.follow_id,b.img,b.username,b.get_money,c.*')
            ->join('__USER__ b on a.user_id2=b.user_id')
            ->join('__VIDEO__ c on a.user_id2=c.user_id')
            ->where(['a.user_id'=>$user['user_id'],'c.is_del'=>1])
            ->order('a.intime desc')
            ->page($page,$pageSize)
            ->select();
        if ($list2){
            foreach ($list2 as $k=>$v){
                $list2[$k]['img'] = C('IMG_PREFIX').$v['img'];
                $list2[$k]['url'] = C('IMG_PREFIX').$v['url'];
                $list2[$k]['video_img'] = C('IMG_PREFIX').$v['video_img'];
            }
        }else{$list2=[];}
        $list = ['list1'=>$list1,'list2'=>$list2];
        success($list);
    }





    /**********************************************视频**********************************************************/

    /**
     * @上传视频
     */
    public function add_video(){
        $user = checklogin();
        $title = I('title');
        $title ? $title = replace_string($title) : $title = "";
        $data = [
            'title'=>$title,
            'user_id'=>$user['user_id'],
            'intime'=>time(),
            'date'=>date('Y-m-d',time()),
        ];
        $config = [
            'maxSize'	=> 30*3145728,
            'rootPath'	=> './Public/admin/Uploads/video/',
            'savePath'	=> '',
            'saveName'	=> ['uniqid',''],
            'exts'		=> ['png','jpg','jpeg','git','gif','mp4','flv','avi','mov'],
            'autoSub'	=> true,
            'subName'	=> '',
        ];
        $uploader = new Upload($config);
        $info = $uploader->upload();
        if ($info){
            foreach($info as $file){
                if ($file['key']=='video_img'){
                    $data['video_img'] = '/Public/admin/Uploads/video/'.$file["savename"];
                }
                if ($file['key']=='video'){
                    $data['url'] = '/Public/admin/Uploads/video/'.$file["savename"];
                }
            }
        }else {
            error($uploader->getError());
        }
        if (M('Video')->add($data)){
            success('成功!');
        }else{
            error('失败!');
        }
    }


    /**
     * @上传视频
     */
    public function up_video(){
        $config = [
            'maxSize'	=> 30*3145728,
            'rootPath'	=> './Public/admin/Uploads/video/',
            'savePath'	=> '',
            'saveName'	=> ['uniqid',''],
            'exts'		=> ['png','jpg','jpeg','git','gif','mp4','flv','avi','mov'],
            'autoSub'	=> true,
            'subName'	=> '',
        ];
        $uploader = new Upload($config);
        $info = $uploader->upload();
        if ($info){
            foreach($info as $file){
               $a = '/Public/admin/Uploads/video/'.$file["savename"];
            }
            success(C('IMG_PREFIX').$a);
        }else {
            error($uploader->getError());
        }
    }



    /**
     * @视频列表
     */
    public function video_list(){
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;
        $list = M('Video')
            ->alias('a')
            ->field('a.*,b.img,b.username,b.get_money')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.is_del'=>1,'a.is_shenhe'=>2])
            ->order('rand()')
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
     * @点击进入视频
     */
    public function video_details(){
        $user_id = I('user_id');
        $video_id = I('video_id');
        empty($video_id) ? error('参数错误!') : true;
        M('Video')->comment('观看数加1')->where(['video_id'=>$video_id])->setInc('watch_nums');
        $details = M('Video')
            ->alias('a')
            ->field('a.*,b.img,b.username,b.hx_username')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.video_id'=>$video_id])
            ->find();
        $details['video_img'] = C('IMG_PREFIX').$details['video_img'];
        $details['url'] = C('IMG_PREFIX').$details['url'];
        $details['img'] = C('IMG_PREFIX').$details['img'];
        if ($user_id){
            $is_zan = M('Video_zan')->where(['video_id'=>$video_id,'user_id'=>$user_id])->find();
            $is_zan ? $details['is_zan'] = "2" : $details['is_zan'] = "1";
            $is_follow = M('Follow')->where(['user_id'=>$user_id,'user_id2'=>$details['user_id']])->find();
            $is_follow ? $details['is_follow'] = "2" : $details['is_follow'] = "1";
        }else{
            $details['is_zan'] = "1";
            $details['is_follow'] = "1";
        }
        success($details);
    }

    /**
     * @视频点赞(取消点赞)
     * @state   1:点赞   2:取消点赞
     */
    public function video_zan(){
        $user = checklogin();
        $state = I('state');  $video_id = I('video_id');
        (empty($video_id) || empty($state)) ? error('参数错误!') : true;  ($state==1 || $state==2) ? true : error('传值错误!');
        $zan = M('Video_zan')->where(['video_id'=>$video_id,'user_id'=>$user['user_id']])->find();
        switch ($state){
            case 1:
                if ($zan){
                    error('已点过赞');
                }else{
                    if (M('Video_zan')->add(['video_id'=>$video_id,'user_id'=>$user['user_id'],'intime'=>time()])){
                        M('Video')->comment('赞加1')->where(['video_id'=>$video_id])->setInc('zan');
                        //添加消息
                        $d = [
                            'type'=>3,
                            'user_id'=>$user['user_id'],
                            'user_id2'=>M('Video')->where(['video_id'=>$video_id])->getField('user_id'),
                            'intime'=>time(),
                            'date'=>date('Y-m-d',time()),
                            'video_id'=>$video_id
                        ];
                        M('Message')->add($d);
                        success('成功!');
                    }else{
                        error('失败!');
                    }
                }
                break;
            case 2:
                if ($zan){
                    if (M('Video_zan')->where(['video_zan_id'=>$zan['video_zan_id']])->delete()) {
                        M('Video')->comment('赞减1')->where(['video_id' => $video_id])->setDec('zan');
                        success('成功!');
                    }else{
                        error('失败!');
                    }
                }else{
                    error('未点过赞!');
                }
                break;
        }
    }


    /**
     * @评论视频
     * @type   1:评论动态   2:评论评论
     */
    public function comment_video(){
        $user = checklogin();
        $type = I('type');
        $video_id = I('video_id'); $video_comments_id = I('video_comments_id'); $content = I('content');
        (empty($video_id) || empty($type) || empty($content)) ? error('参数错误!') : true;  ($type==1 || $type==2) ? true : error('传值错误!');
        $content = replace_string($content);
        $data = [
            'video_id'=>$video_id,
            'user_id'=>$user['user_id'],
            'content'=>$content,
            'intime'=>time(),
            'type'=>$type,
        ];
        switch ($type){
            case 1:
                $data['fid'] = "0";
                break;
            case 2:
                empty($video_comments_id) ? error('参数错误!') : true;
                $data['fid'] = $video_comments_id;
                break;
        }
        $v = M('Video_comments')->add($data);
        if ($v){
            M('Video')->comment('评论数加1')->where(['video_id'=>$video_id])->setInc('comments');
            $m =[
                'type'=>2,
                'user_id'=>$user['user_id'],
                'user_id2'=>M('Video')->where(['video_id'=>$video_id])->getField('user_id'),
                'content'=>$content,
                'intime'=>time(),
                'date'=>date('Y-m-d',time()),
                'video_id'=>$video_id,
            ];
            if ($type==1){
                $m['status'] = 1;
            }else{
                $m['video_comments_id'] = $v;
                $m['status'] = 2;
            }
            M('Message')->add($m);
            success('成功!');
        }else{
            error('失败!');
        }
    }

    /**
     * @评论列表
     */
    public function comment_list(){
        $user_id = I('user_id');
        $video_id = I('video_id');
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;
        $pageSize ? $pageSize : $pageSize = 10;
        empty($video_id) ? error('参数错误!') : true;
        $list = M('Video_comments')
            ->alias('a')
            ->field('a.*,b.username,b.img,b.hx_username')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.video_id' => $video_id])
            ->page($page, $pageSize)
            ->order('a.intime desc')
            ->select();
        if ($list) {
            foreach ($list as $k => $v) {
                $list[$k]['img'] = C('IMG_PREFIX') . $v['img'];
                $list[$k]['intime'] = date('Y-m-d H:i', $v['intime']);
                $list[$k]['times'] = get_times($v['intime']);
                if ($user_id){
                    $is_zan = M('Video_comments_zan')->comment('查询是否点赞')->where(['video_id_comments_id' => $v['video_comments_id'], 'user_id' => $user_id])->find();
                    $is_zan ? $list[$k]['is_zan'] = "2" : $list[$k]['is_zan'] = "1";
                }else{
                    $list[$k]['is_zan'] = "1";
                }
                if ($v['type']==2){
                    $user_id2 = M('Video_comments')->where(['video_comments_id'=>$v['fid']])->getField('user_id');
                    $list[$k]['username2'] = M('User')->where(['user_id'=>$user_id2])->getField('username');
                }
            }
        } else {
            $list = [];
        }
        success($list);
    }

    /**
     * @评论点赞
     * @state 1:赞  2:取消赞
     */
    public function comment_zan(){
        $user = checklogin();
        $state = I('state');  $video_comments_id = I('video_comments_id');
        (empty($video_comments_id) || empty($state)) ? error('参数错误!') : true;
        ($state==1 || $state==2) ? true : error('传值错误!');
        $zan = M('Video_comments_zan')->where(['video_comments_id'=>$video_comments_id,'user_id'=>$user['user_id']])->find();
        switch ($state){
            case 1:
                if ($zan){
                    error('已赞过!');
                }else{
                    if (M('Video_comments_zan')->add(['video_comments_id'=>$video_comments_id,'user_id'=>$user['user_id'],'intime'=>time()])){
                        M('Video_comments')->comment('赞加1')->where(['video_comments_id'=>$video_comments_id])->setInc('zan');
                        success('成功!');
                    }else{
                        error('失败!');
                    }
                }
                break;
            case 2:
                if ($zan){
                    if (M('Video_comments_zan')->where(['video_comments_zan_id'=>$zan['video_comments_zan_id']])->delete()){
                        M('Video_comments')->comment('赞减1')->where(['video_comments_id'=>$video_comments_id])->setDec('zan');
                        success('成功!');
                    }else{
                        error('失败!');
                    }
                }else{
                    error('未赞过!');
                }
                break;
        }
    }

    /**
     * @视频分享
     */
    public function share(){
        $video_id = I('video_id');
        empty($video_id) ? error('参数错误!') : true;
        if (M('Video')->where(['video_id'=>$video_id])->setInc('share')){
            success('成功!');
        }else{
            error('失败!');
        }
    }





    /**
     * @搜索关键词
     */
    public function search(){
        $user = checklogin();
        $keywords = I('keywords');
        $page = I('page');   $pageSize = I('pagesize');
        $page ? $page : $page = 1;   $pageSize ? $pageSize : $pageSize = 10;
        empty($keywords) ? error('参数错误!') : true;
        $data['username|ID|autograph'] = ['like','%'.$keywords.'%'];
        $data['is_del'] = 1;
        $list = M('User')
            ->field('user_id,username,img,sex,autograph,hx_username,ID,grade')
            ->where($data)
            ->order('get_money desc')
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
        success($list);
    }


    /**
     * @推荐主播
     */
    public function recommend_list(){
        $user = checklogin();
        $page = I('page');   $pageSize = I('pagesize');
        $page ? $page : $page = 1;   $pageSize ? $pageSize : $pageSize = 10;
        $data = [
            'a.live_status'=>1,
            'b.type'=>1,
            'b.is_del'=>1,
        ];
        $list = M('Live')
            ->alias('a')
            ->field('a.*,b.phone,b.img,b.sex,b.username,b.ID,b.hx_username,b.grade,b.province,b.city,b.zan,b.money,b.get_money,b.url')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where($data)
            ->order('a.watch_nums desc')
            ->page($page,$pageSize)
            ->select();
        if ($list){
            foreach ($list as $k=>$v){
                $list[$k]['play_img'] = domain($v['play_img']);
                $list[$k]['img'] = domain($v['img']);
                $list[$k]['url'] = C('IMG_PREFIX')."/App/Index/share_live/live_id/" . base64_encode($v['live_id']);
                $list[$k]['qrcode_path'] = C('IMG_PREFIX').$v['qrcode_path'];

                $get_gradeinfo = get_gradeinfo($v['grade']);
                $list[$k]['grade_img'] = $get_gradeinfo['img'];
                $list[$k]['name'] = $get_gradeinfo['name'];
            }
        }else{$list=[];}
        success($list);
    }

    /**
     * @认证QQ
     */
    public function is_authen(){
        $qq = M('Qq')->where(array('id'=>1))->getField('qq');
        if($qq){
            success($qq);
        }else{
            error('平台尚未添加认证QQ');
        }
    }


    /**
     *搜索商家
     */
    public function searchMerchant(){
        $name = I('name');
        $name && $map['merchants_name'] = ['like','%'.$name.'%'];
        $map['is_delete'] = '0';
        $map['apply_state'] = '2';
        $map['open'] = '1';
        $merchants = M('shop_merchants')->where($map)->field('merchants_id,merchants_name,merchants_img,contact_name,contact_mobile')->select();
        if(!$merchants){
           $merchants = [];
        }else{
            foreach ($merchants as $k => &$v) {
                $v['merchants_img'] = domain($v['merchants_img']);
            }
        }
        success($merchants);
    }

    /**
     *搜索商品
     */
    public function searchGoods(){
        $name = I('name');
        $merchants_id = I('merchants_id');
        $name && $map['goods_name|goods_uuid|code'] = ['like','%'.$name.'%'];
        $merchants_id && $map['merchants_id'] = $merchants_id;
        $map['is_delete'] = '0';
        $map['goods_state'] = '1';
        $map['is_review'] = '1';
        $goods = M('shop_goods')->where($map)->order('important desc')->field('merchants_id,goods_id, goods_name')->limit(50)->select();
        if(!$goods){
            $goods = [];
        }
        success($goods);
    }

    /**
     * 搜索买手
     */
    public function searchUser(){
        $name = I('name');
        $name && $map['username|autograph|ID'] = ['like','%'.$name.'%'];
        $map['is_del'] = 1;
        $map['is_titles'] = 1;
        $map['is_authen'] = 2;
        $user = M('user')->where($map)->field('user_id,username,img,autograph,get_money')->order('get_money desc')->limit(50)->select();
        foreach ($user as $k => &$v) {
            $v['img'] = domain($v['img']);
            $v['fans'] = M('follow')->where(array('user_id2'=>$v['user_id'],'is_delete'=>1))->count();

        }
        success($user);


    }


    /**
     * @进入活动count+1
     * 
     */

    public function activity_count(){
        $a_id = I('a_id');
        $res = M('activity')->where(array('a_id'=>$a_id))->setInc('count');
        if($res){
            success('成功');
        }
    }


    /**
     *
     * @ 收藏活动与取消收藏
     */
    public function collect_activity(){
        if (IS_POST) {
            $member = checklogin();
            $id = I('a_id');
            if (!$id) error("活动参数错误");
            $check = M('activity_collection')->where(['a_id' => $id, 'member_id' => $member['user_id']])->find();
            if ($check) {
                if ($check['is_delete'] == '1') {
                    $update['is_delete'] = '2';

                } else {
                    $update['is_delete'] = '1';
                }
                $result = M('activity_collection')->where(['collection_id' => $check['collection_id']])->save($update);
                if ($result) {
                    success($update['is_delete']);
                } else {
                    error("操作失败");
                }
            } else {
                $data['member_id'] = $member['user_id'];
                $data['a_id'] = $id;
                $data['intime'] = date("Y-m-d H:i:s", time());
                $result = M('activity_collection')->add($data);
                if ($result) {
                    success('1');
                } else {
                    error("操作失败");
                }
            }
        }
    }

    /**
     *@活动收藏列表
     */
    public function collect(){
        if (IS_POST) {
            $member = checklogin();
            $map['a.is_delete'] = 1;
            $map['b.is_del'] = 1;
            // $map['b.state'] = 2;
            $map['a.member_id'] = $member['user_id'];
            $p = I('p');
            $count = M('activity_collection')->alias('a')
                ->join('m_activity b ON a.a_id = b.a_id')
                ->where($map)->count();
            empty($p) && $p = 1;
            $num = I('pagesize');
            $num ? $num : $num = 10;
            $page = ceil($count / $num);
            $list =M('activity_collection')->alias('a')
                ->field("a.collection_id,a.a_id,b.title,b.img,b.type,b.img_width,b.img_height")
                ->join('m_activity b ON a.a_id = b.a_id')
                ->where($map)->limit(($p - 1) * $num, $num)
                ->select();
            if(!$list){
                $list = [];
            }
            success(['page' => $page, 'list' => $list]);
        }
    }

    /**
     *@删除活动收藏
     */
    public function del_collect(){
        if (IS_POST) {
            $member = checklogin();
            $ids = I('ids');
            $map['collection_id'] = ['in',$ids];
            $map['member_id'] = $member['user_id'];
            $result = M('activity_collection')->where($map)->save(['is_delete'=>'2']);
            if($result){
                success("操作成功");
            }else{
                error("操作失败");
            }
        }
    }


    /**
     * @活动详情
     */
    public function activity_detail($uid,$aid=0){
        // $user = checklogin();
        $user_id = I('uid')?I('uid'):$uid;
        $unionid = M('user')->where(['user_id'=>$user_id])->getField('unionid');
        $a_id = I('a_id')?I('a_id'):$aid;
        empty($a_id) ? error('参数错误!') : true;

        /*进入活动浏览量加一*/
        M('activity')->where(array('a_id'=>$a_id))->setInc('count');
        /*进入活动浏览量加一*/
        if($user_id){
            $user = M('user')->where(['user_id'=>$user_id])->find();
            /*插入活动浏览记录表*/
            $result = M('activity_histroy')->where(['a_id'=>$a_id,'user_id'=>$user_id])->find();
            if($result){
                M('activity_histroy')->where(['id'=>$result['id']])->setInc('count');
            }else{
                M('activity_histroy')->add(['a_id'=>$a_id,'user_id'=>$user_id,'intime'=>time()]);
            }
            /*插入活动浏览记录表*/
        }
        

        $info = M('activity')->where(array('a_id'=>$a_id))->find();

        /**主播昵称*/
        $info['nickname'] = M('user')->where(['user_id'=>$info['user_id']])->getField('username');
 
        /*检测是否收藏*/
        $info['is_collect'] = '2';
        if (!empty($user_id)) {
            $map['member_id'] = $user_id;
            $map['a_id'] = $info['a_id'];
            $map['is_delete'] = '1';
            $check = M('activity_collection')->where($map)->find();
            if ($check) {
                $info['is_collect'] = '1';
            }

        }

        //活动点赞数
        $info['zan'] = M('activity_zan')->where(array('a_id'=>$a_id,'status'=>1))->count();
        //是否点赞
        $is_zan = M('activity_zan')->where(array('a_id'=>$a_id,'user_id'=>$user_id,'status'=>1))->find();
        $is_zan ? $is_zan = "2" : $is_zan = "1";
        $info['is_zan'] = $is_zan;
                

        //活动收藏数
        $info['collect'] = M('activity_collection')->where(array('a_id'=>$a_id,'is_delete'=>1))->count();

        //评论数
        $info['comments'] = M('activity_comments')->where(array('a_id'=>$a_id))->count();
        
        $info['share_links'] = 'https://www.baidu.com/';
        $type = $info['type'];
        switch ($type) {
            case '1'://预播
                $user_id2 = $info['user_id'];
                $is_follow = M('Follow')->where(['user_id' => $user_id, 'user_id2' => $user_id2])->find();
                $is_follow ? $is_follow = "2" : $is_follow = "1";
                $lignt_up = M('Live_light_up')->where(['live_id'=>$info['x_id'],'user_id'=>$user_id,'user_id2'=>$user_id2])->find();
                $lignt_up ? $is_lignt_up = "2" : $is_lignt_up = "1";
                $prompt = M('System')->where(['id'=>1])->getField('prompt');
                $get_gradeinfo = get_gradeinfo($user['grade']);
                
                $info['is_follow'] = $is_follow;
                $info['is_lignt_up'] = $is_lignt_up;
                $info['prompt'] = $prompt;
                $info['grade_img'] = $get_gradeinfo['img'];
                $info['name'] = $get_gradeinfo['name'];
                $header_img = M('user')->where(['user_id'=>$info['user_id']])->getField('img');

                $info['header_img'] = $header_img;

                if($unionid){
                    $info['share_links'] = 'http://www.uyugame.com/main/main.php?target=invitee&gameKey=pj&parent='.$unionid.'&rd='.urlencode(C('IMG_PREFIX').'/App/Index/share_video?a_id='.$info['a_id']);

                }else{
                    $info['share_links'] = C('IMG_PREFIX').'/App/Index/share_video?a_id='.$info['a_id'];

                }

                break;
            case '2'://直播
                // $live = M('Live')->where(['live_id'=>$info['x_id']])->find();
                $live = M('live')->alias('a')
                        ->field('a.*,b.username,b.img as header_img,b.user_id as member_id,b.ID')
                        ->join('m_user b ON a.user_id = b.user_id')
                        ->where(['a.live_id'=>$info['x_id']])
                        ->find();

                if($live['live_status'] != '1')             error("直播已结束");
                M('Live_kicking')->where(['live_id'=>$info['x_id'],'user_id'=>$user_id])->find() ? error('被踢出,无法进入!') : true;
                M('Live_number')->where(['user_id2'=>$user_id])->delete();
                $user_id2 = $live['user_id'];
                if (M('Live_number')->add(['live_id'=>$info['x_id'],'user_id'=>$user_id2,'user_id2'=>$user_id,'intime'=>time()])){
                    M('Live')->where(['live_id'=>$info['x_id']])->save(['nums'=>$live['nums']+1,'watch_nums'=>$live['watch_nums']+1]);
                    $is_follow = M('Follow')->where(['user_id' => $user_id, 'user_id2' => $user_id2])->find();
                    $is_follow ? $is_follow = "2" : $is_follow = "1";
                    $lignt_up = M('Live_light_up')->where(['live_id'=>$info['x_id'],'user_id'=>$user_id,'user_id2'=>$user_id2])->find();
                    $lignt_up ? $is_lignt_up = "2" : $is_lignt_up = "1";
                    $prompt = M('System')->where(['id'=>1])->getField('prompt');
                    $get_gradeinfo = get_gradeinfo($user['grade']);
                    
                    $info['is_follow'] = $is_follow;
                    $info['is_lignt_up'] = $is_lignt_up;
                    $info['prompt'] = $prompt;
                    $info['grade_img'] = $get_gradeinfo['img'];
                    $info['name'] = $get_gradeinfo['name'];
                    $info['play_address'] = $live['play_address'];

                    $info['share_url'] = C('IMG_PREFIX').'/mall_live/#/liveRoom_mobile?live_id='.$info['x_id'].'&room_id='.$info['room_id'];
                    $info['header_img'] = domain($live['header_img']);
                    $info['play_img'] = domain($live['play_img']);
                    $info['qrcode_path'] = domain($live['qrcode_path']);
                    $info['qiniu_room_id'] = $live['qiniu_room_id'];
                    $info['qiniu_room_name'] = $live['qiniu_room_name'];
                    $info['qiniu_token'] = $live['qiniu_token'];

                    if($unionid){
                        $info['share_links'] = 'http://www.uyugame.com/main/main.php?target=invitee&gameKey=pj&parent='.$unionid.'&rd='.urlencode(C('IMG_PREFIX').'/App/Index/share_zhibo?a_id='.$info['a_id']);

                    }else{
                        $info['share_links'] = C('IMG_PREFIX').'/App/Index/share_zhibo?a_id='.$info['a_id'];

                    }

                    
                }else{
                    error('失败!');
                }
                break;
            case '3':
                if($info['x_id'] == 0){
                    error('直播时长太短，未生成录播');
                }
                $live = M('Live_store')->where(['live_store_id'=>$info['x_id']])->find();
                $user_id2 = $live['user_id'];
                $is_follow = M('Follow')->where(['user_id' => $user_id, 'user_id2' => $user_id2])->find();
                $is_follow ? $is_follow = "2" : $is_follow = "1";
                $lignt_up = M('Live_light_up')->where(['live_id'=>$info['x_id'],'user_id'=>$user_id,'user_id2'=>$user_id2])->find();
                $lignt_up ? $is_lignt_up = "2" : $is_lignt_up = "1";
                $prompt = M('System')->where(['id'=>1])->getField('prompt');
                $get_gradeinfo = get_gradeinfo($user['grade']);
                
                $info['is_follow'] = $is_follow;
                $info['is_lignt_up'] = $is_lignt_up;
                $info['prompt'] = $prompt;
                $info['grade_img'] = $get_gradeinfo['img'];
                $info['name'] = $get_gradeinfo['name'];
                $info['play_address'] = $live['url'];

                $header_img = M('user')->where(['user_id'=>$info['user_id']])->getField('img');

                $info['header_img'] = $header_img;

                if($unionid){
                    $info['share_links'] = 'http://www.uyugame.com/main/main.php?target=invitee&gameKey=pj&parent='.$unionid.'&rd='.urlencode(C('IMG_PREFIX').'/App/Index/share_zhibo?a_id='.$info['a_id']);
                }else{
                    $info['share_links'] = C('IMG_PREFIX').'/App/Index/share_zhibo?a_id='.$info['a_id'];

                }

                
                break;
            case '4':
                $user_id2 = $info['user_id'];
                $is_follow = M('Follow')->where(['user_id' => $user_id, 'user_id2' => $user_id2])->find();
                $is_follow ? $is_follow = "2" : $is_follow = "1";
                $lignt_up = M('Live_light_up')->where(['live_id'=>$info['x_id'],'user_id'=>$user_id,'user_id2'=>$user_id2])->find();
                $lignt_up ? $is_lignt_up = "2" : $is_lignt_up = "1";
                $prompt = M('System')->where(['id'=>1])->getField('prompt');
                $get_gradeinfo = get_gradeinfo($user['grade']);
                $info['is_follow'] = $is_follow;
                $info['is_lignt_up'] = $is_lignt_up;
                $info['prompt'] = $prompt;
                $info['grade_img'] = $get_gradeinfo['img'];
                $info['name'] = $get_gradeinfo['name'];

                $header_img = M('user')->where(['user_id'=>$info['user_id']])->getField('img');

                $info['header_img'] = $header_img;

                if($unionid){
                    $info['share_links'] = 'http://www.uyugame.com/main/main.php?target=invitee&gameKey=pj&parent='.$unionid.'&rd='.urlencode(C('IMG_PREFIX').'/App/Index/share_video?a_id='.$info['a_id']);

                }else{
                    $info['share_links'] = C('IMG_PREFIX').'/App/Index/share_video?a_id='.$info['a_id'];

                }


                break;
            case '5':
                $user_id2 = $info['user_id'];
                $is_follow = M('Follow')->where(['user_id' => $user_id, 'user_id2' => $user_id2])->find();
                $is_follow ? $is_follow = "2" : $is_follow = "1";
                $lignt_up = M('Live_light_up')->where(['live_id'=>$info['x_id'],'user_id'=>$user_id,'user_id2'=>$user_id2])->find();
                $lignt_up ? $is_lignt_up = "2" : $is_lignt_up = "1";
                $prompt = M('System')->where(['id'=>1])->getField('prompt');
                $get_gradeinfo = get_gradeinfo($user['grade']);
                
                $info['is_follow'] = $is_follow;
                $info['is_lignt_up'] = $is_lignt_up;
                $info['prompt'] = $prompt;
                $info['grade_img'] = $get_gradeinfo['img'];
                $info['name'] = $get_gradeinfo['name'];

                $header_img = M('user')->where(['user_id'=>$info['user_id']])->getField('img');

                $info['header_img'] = $header_img;

                if($unionid){
                    $info['share_links'] = 'http://www.uyugame.com/main/main.php?target=invitee&gameKey=pj&parent='.$unionid.'&rd='.urlencode(C('IMG_PREFIX').'/App/Index/share_picture?a_id='.$info['a_id']);

                }else{
                    $info['share_links'] = C('IMG_PREFIX').'/App/Index/share_picture?a_id='.$info['a_id'];

                }


                break;
            case '6':
                $user_id2 = $info['user_id'];
                $is_follow = M('Follow')->where(['user_id' => $user_id, 'user_id2' => $user_id2])->find();
                $is_follow ? $is_follow = "2" : $is_follow = "1";
                $lignt_up = M('Live_light_up')->where(['live_id'=>$info['x_id'],'user_id'=>$user_id,'user_id2'=>$user_id2])->find();
                $lignt_up ? $is_lignt_up = "2" : $is_lignt_up = "1";
                $prompt = M('System')->where(['id'=>1])->getField('prompt');
                $get_gradeinfo = get_gradeinfo($user['grade']);
                
                $info['is_follow'] = $is_follow;
                $info['is_lignt_up'] = $is_lignt_up;
                $info['prompt'] = $prompt;
                $info['grade_img'] = $get_gradeinfo['img'];
                $info['name'] = $get_gradeinfo['name'];

                $header_img = M('user')->where(['user_id'=>$info['user_id']])->getField('img');

                $info['header_img'] = $header_img;

                if($unionid){
                    $info['share_links'] = 'http://www.uyugame.com/main/main.php?target=invitee&gameKey=pj&parent='.$unionid.'&rd='.urlencode(C('IMG_PREFIX').'/App/Index/share_article?a_id='.$info['a_id']);

                }else{
                    $info['share_links'] = C('IMG_PREFIX').'/App/Index/share_article?a_id='.$info['a_id'];

                }


            break;
            default:
                
                break;
        }

        success($info);
    }

    /**
     * 活动详情上滑下滑
     * type  1:上滑  2:下滑 
     */
    public function slide(){
        $user_id = I('uid')?I('uid'):0;

        $type = I('type')?I('type'):error('参数错误');
        $a_id = I('id')?I('id'):error('参数错误');
        if($type == 1){
            //上滑
            $id = $a_id - 1;

            if($id == 0){
                error('已经到顶了');
            }else{
                $res = M('activity')->where(['a_id'=>['lt',$a_id],'is_del'=>1,'store_status'=>1,'type'=>4])->order('a_id desc')->getField('a_id');
                if(empty($res)){
                    error('已经到顶了');
                }else{

                    $this->activity_detail($user_id,$res);
                }
            }

        }else if($type == 2){
            //下滑
            // $id = $a_id + 1;
            $res = M('activity')->where(['a_id'=>['gt',$a_id],'is_del'=>1,'store_status'=>1,'type'=>4])->order('a_id asc')->getField('a_id');
            if(empty($res)){
                error('已经到底了');
            }else{
                $this->activity_detail($user_id,$res);
            }

        }
    }

    
    /**
     * * 点赞活动
     */
    public function activity_zan(){
        $user = checklogin();
        $data['user_id'] = I('uid');
        $data['a_id'] = I('a_id');
        empty($data['a_id']) ? error('参数错误!') : true;
        $data['creatime'] = time();
        //查询动态点赞表
        $result = M('activity_zan')->where(array('user_id'=>$data['user_id'],'a_id'=>$data['a_id']))->find();
        if($result){
            if($result['status'] == 1){
                //已经点赞过，点击取消赞
                $list = M('activity_zan')->where(array('id'=>$result['id']))->setInc('status');
                if($list){
                    success('2');
                }else{
                    error('取消赞失败');
                }
                
            }else{
                //已经取消赞，点击点赞
                $list = M('activity_zan')->where(array('id'=>$result['id']))->setDec('status');
                if($list){
                    success('1');
                }else{
                    error('点赞失败');
                }
            }
        }else{
            //第一次点赞，入库
            $list = M('activity_zan')->add($data);
            if($list){
                success('1');
            }else{
                error('点赞失败');
            }
        }

    }


    /**
     * @评论活动
     * @type   1:评论活动   2:评论评论
     */
    public function comment_activity(){
        $user = checklogin();
        $type = I('type');
        $a_id = I('a_id'); $activity_comments_id = I('activity_comments_id'); 
        $content = $_POST['content'];
        (empty($a_id) || empty($type) || empty($content)) ? error('参数错误!') : true;  ($type==1 || $type==2) ? true : error('传值错误!');
        $content = replace_string($content);
        $data = [
            'a_id'=>$a_id,
            'user_id'=>$user['user_id'],
            'content'=>$content,
            'intime'=>time(),
            'type'=>$type,
        ];
        switch ($type){
            case 1:
                $data['fid'] = "0";
                break;
            case 2:
                empty($activity_comments_id) ? error('参数错误!') : true;
                $data['fid'] = $activity_comments_id;
                break;
        }
        $v = M('activity_comments')->add($data);
        if ($v){
            M('activity')->comment('评论数加1')->where(['a_id'=>$a_id])->setInc('comments');
            
            success('成功!');
        }else{
            error('失败!');
        }
    }


    /**
     * @评论列表
     */
    public function activity_comment_list(){
        $user_id = I('user_id');
        $a_id = I('a_id');
        $page = I('page');
        $pageSize = I('pagesize');
        $page ? $page : $page = 1;
        $pageSize ? $pageSize : $pageSize = 10;
        empty($a_id) ? error('参数错误!') : true;
        $list = M('activity_comments')
            ->alias('a')
            ->field('a.*,b.username,b.img,b.hx_username')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where(['a.a_id' => $a_id])
            ->page($page, $pageSize)
            ->order('a.intime desc')
            ->select();
        if ($list) {
            foreach ($list as $k => $v) {
                $list[$k]['img'] = domain($v['img']);
                $list[$k]['intime'] = date('Y-m-d H:i', $v['intime']);
                $list[$k]['times'] = get_times($v['intime']);
                if ($user_id){
                    $is_zan = M('activity_comments_zan')->comment('查询是否点赞')->where(['activity_comments_id' => $v['activity_comments_id'], 'user_id' => $user_id])->find();
                    $is_zan ? $list[$k]['is_zan'] = "2" : $list[$k]['is_zan'] = "1";
                }else{
                    $list[$k]['is_zan'] = "1";
                }
                if ($v['type']==2){
                    $user_id2 = M('activity_comments')->where(['activity_comments_id'=>$v['fid']])->getField('user_id');
                    $list[$k]['username2'] = M('User')->where(['user_id'=>$user_id2])->getField('username');
                }
            }
        } else {
            $list = [];
        }
        success($list);
    }

    /**
     * @活动评论点赞
     */
    public function activity_comment_zan(){
        $user = checklogin();
        $data['user_id'] = I('uid');
        $data['activity_comments_id'] = I('activity_comments_id');
        $data['intime'] = time();
        //查询活动评论点赞表
        $result = M('activity_comments_zan')->where(array('user_id'=>$data['user_id'],'activity_comments_id'=>$data['activity_comments_id']))->find();
        if($result){
            if($result['status'] == 1){
                //已经点赞过，点击取消赞
                $list = M('activity_comments_zan')->where(array('activity_comments_zan_id'=>$result['activity_comments_zan_id']))->setInc('status');
                M('activity_comments')->where(array('activity_comments_id'=>$data['activity_comments_id']))->setDec('zan');
                if($list){
                    success('2');
                }else{
                    error('取消赞失败');
                }
                
            }else{
                //已经取消赞，点击点赞
                $list = M('activity_comments_zan')->where(array('activity_comments_zan_id'=>$result['activity_comments_zan_id']))->setDec('status');
                M('activity_comments')->where(array('activity_comments_id'=>$data['activity_comments_id']))->setInc('zan');
                if($list){
                    success('1');
                }else{
                    error('点赞失败');
                }
            }
        }else{
            M('activity_comments')->where(array('activity_comments_id'=>$data['activity_comments_id']))->setInc('zan');
            //第一次点赞，入库
            $list = M('activity_comments_zan')->add($data);
            if($list){
                success('1');
            }else{
                error('点赞失败');
            }
        }
    }

    
    /**
     * @视频分享
     */
    public function activity_share(){
        $a_id = I('a_id');
        empty($a_id) ? error('参数错误!') : true;
        if (M('activity')->where(['a_id'=>$a_id])->setInc('share')){
            success('成功!');
        }else{
            error('失败!');
        }
    }

    /**
     * @预播列表
     */
    public function pre_play(){
        $u = checklogin();
        $list = M('activity')
                ->where(array('user_id'=>I('uid'),'type'=>1,'is_del'=>1,'store_status'=>1))
                ->field('a_id,title,img,play_time')
                ->select();
        if($list){
            foreach ($list as $k => &$v) {
                $v['img'] = domain($v['img']);
            }
        }else{
            $list = [];
        }
        success($list);
    }


    /**
     * @活动记录
     */
    public function activity_record(){
        $u = checklogin();

        $page = I('page'); $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;

        $uid = I('uid');
        $list = M('activity')
              ->where(array('user_id'=>$uid,'is_del'=>1))
              ->field('a_id,title,img,FROM_UNIXTIME(intime) as intime,tag,count,type,user_id,comments')
              ->order('intime desc')
              ->page($page,$pageSize)
              ->select();
        if($list){
            foreach ($list as $k => &$v) {
                $v['img'] = domain($v['img']);
            }
        }else{
            $list = [];
        }

        success($list);

    }

    /**
     * @删除活动记录
     */
    public function del_activity(){
        $u = checklogin();
        $ids = I('a_id');
        $map['a_id'] = ['in',$ids];
        $map['user_id'] = $u['user_id'];
        $result = M('activity')->where($map)->save(['is_del'=>'2']);
        if($result){
            success("操作成功");
        }else{
            error("操作失败");
        }

    }



    public function share_video(){
        $a_id = I('a_id');
        $info = M('activity')->where(['a_id'=>$a_id])->find();
        $info['img'] = domain($info['img']);
        $info['goods_id'] = explode(',', $info['goods_id']);
        $goods = [];
        foreach ($info['goods_id'] as $k => &$v) {
            $goods[$k] = M('shop_goods')->where(array('goods_id'=>$v))->field('goods_name,goods_img')->find();
        }
        $count = count($goods);
        $user = M('user')->where(['user_id'=>$info['user_id']])->field('username,img')->find();
        $user['img'] = domain($user['img']);

        $dat['_string']='FIND_IN_SET("'.精选.'", tag)';
        $dat['type'] = 4;
        $list = M('activity')->where($dat)->field('img,url')->select();
        foreach ($list as $k => &$v) {
            $v['img'] = domain($v['img']);
        }
        
        // success($user);
        $this->assign('info',$info);
        $this->assign('count',$count);
        $this->assign('goods',$goods);
        $this->assign('user',$user);
        $this->assign('list',$list);
        $this->display();
    }


    public function share_article(){
        // print_r($_GET);exit;
        // $url = urldecode(I('rd'));
        // $arr = parse_url($url);
        // $arrs = explode('=', $arr['query']);
        $a_id = I('a_id');
        $info = M('activity')->where(['a_id'=>$a_id])->find();
        $info['img'] = domain($info['img']);
        $info['goods_id'] = explode(',', $info['goods_id']);
        $count = count($info['goods_id']);

        $user = M('user')->where(['user_id'=>$info['user_id']])->field('username,img')->find();
        $user['img'] = domain($user['img']);

        //评论
        $info['comments'] = M('activity_comments')->where(array('a_id'=>$a_id))->count();
        $comment = M('activity_comments')->alias('a')
                 ->join('m_activity b ON a.a_id = b.a_id','LEFT')
                 ->join('m_user c ON a.user_id = c.user_id','RIGHT')
                 ->field('a.*,b.title,c.username')
                 ->where(['a.a_id'=>$a_id])
                 ->order('a.intime desc')
                 ->limit(10)
                 ->select();
        if($comment){
            foreach ($comment as $k => &$v) {
                if($v['type'] == 2){
                    //回复的人
                    $touser = M('activity_comments')->where(['activity_comments_id'=>$v['fid']])->getField('user_id');
                    $v['to_name'] = M('user')->where(['user_id'=>$touser])->getField('username');
                }
            }
        }

        //活动点赞数
        $info['zan'] = M('activity_zan')->where(array('a_id'=>$a_id,'status'=>1))->count();
        //活动收藏数
        $info['collect'] = M('activity_collection')->where(array('a_id'=>$a_id,'is_delete'=>1))->count();


        $this->assign('info',$info);
        $this->assign('user',$user);
        $this->assign('count',$count);
        $this->assign('comment',$comment);

        $this->display();

    }

    public function share_goods(){
        $goods_id = I('goods_id');
        $info = M('shop_goods')->alias('a')
              ->join('m_shop_merchants b ON a.merchants_id = b.member_id','RIGHT')
              ->field('a.goods_id,a.goods_img,a.goods_now_price,a.goods_origin_price,a.goods_name,b.merchants_img,a.goods_detail,b.merchants_name,b.merchants_province,b.merchants_city')
              ->where(['a.goods_id'=>$goods_id])
              ->find();
        //评价数
        $info['comments'] = M('shop_goods_comment')->where(['goods_id'=>$goods_id])->count();
        $comment = M('shop_goods_comment')->alias('a')
                 ->join('m_shop_goods b ON a.goods_id = b.goods_id','RIGHT')
                 ->join('m_user c ON a.member_id = c.user_id','RIGHT')
                 ->field("a.*,DATE_FORMAT(a.create_time,'%Y-%m-%d') as create_time,c.username")
                 ->where(['a.goods_id'=>$goods_id])
                 ->order('a.create_time desc')
                 ->limit(10)
                 ->select();
        if($comment){
            foreach ($comment as $k => &$v) {
                if($v['pid'] != 0){
                    //回复的人
                    $touser = M('shop_goods_comment')->where(['comment_id'=>$v['pid']])->getField('member_id');
                    $v['to_name'] = M('user')->where(['user_id'=>$touser])->getField('username');
                }
            }
        }

        $this->assign('info',$info);
        $this->assign('comment',$comment);

        $this->display();
        
    }

    public function share_picture(){
        $a_id = I('a_id');
        $info = M('activity')->where(['a_id'=>$a_id])->find();
        $info['img'] = domain($info['img']);
        $info['goods_id'] = explode(',', $info['goods_id']);
        $count = count($info['goods_id']);
        $user = M('user')->where(['user_id'=>$info['user_id']])->field('username,img')->find();
        $user['img'] = domain($user['img']);
        //图片
        $imgs = explode(',', $info['imgs']);

        //评论
        $info['comments'] = M('activity_comments')->where(array('a_id'=>$a_id))->count();
        $comment = M('activity_comments')->alias('a')
                 ->join('m_activity b ON a.a_id = b.a_id','LEFT')
                 ->join('m_user c ON a.user_id = c.user_id','RIGHT')
                 ->field('a.*,b.title,c.username')
                 ->where(['a.a_id'=>$a_id])
                 ->order('a.intime desc')
                 ->limit(10)
                 ->select();
        if($comment){
            foreach ($comment as $k => &$v) {
                if($v['type'] == 2){
                    //回复的人
                    $touser = M('activity_comments')->where(['activity_comments_id'=>$v['fid']])->getField('user_id');
                    $v['to_name'] = M('user')->where(['user_id'=>$touser])->getField('username');
                }
            }
        }

        //活动点赞数
        $info['zan'] = M('activity_zan')->where(array('a_id'=>$a_id,'status'=>1))->count();
        //活动收藏数
        $info['collect'] = M('activity_collection')->where(array('a_id'=>$a_id,'is_delete'=>1))->count();

        $this->assign('info',$info);
        $this->assign('user',$user);
        $this->assign('count',$count);
        $this->assign('imgs',$imgs);
        $this->assign('comment',$comment);

        $this->display();
        
    }

    public function share_zhibo(){
        $a_id = I('a_id');
        $info = M('activity')->where(['a_id'=>$a_id])->find();
        if($info['type'] == 2){
            //直播
            $info['src'] = M('live')->where(['live_id'=>$info['x_id']])->getField('play_address_m3u8');
        }else if($info['type'] == 3){
            //录播
            $info['src'] = M('live_store')->where(['live_store_id'=>$info['x_id']])->getField('url');
        }
        $info['img'] = domain($info['img']);
        $info['goods_id'] = explode(',', $info['goods_id']);
        $count = count($info['goods_id']);
        $user = M('user')->where(['user_id'=>$info['user_id']])->field('username,img')->find();
        $user['img'] = domain($user['img']);

        $this->assign('info',$info);
        $this->assign('user',$user);
        $this->assign('count',$count);
        $this->display();
        
    }


    /**
     * 活动浏览足迹
     */
    public function activity_histroy(){
        $u = checklogin();

        $page = I('page'); $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;

        $uid = I('uid');
        $list = M('activity_histroy')->alias('a')
              ->join('m_activity b ON a.a_id = b.a_id')
              ->field('a.id,a.a_id,FROM_UNIXTIME(a.intime) as intime,a.user_id,a.count,b.title,b.img,b.type')
              ->where(['a.user_id'=>$uid])
              ->order('a.count desc')
              ->page($page,$pageSize)
              ->select();
        if(!$list){
            $list = [];
        }else{
            foreach ($list as $k => &$v) {
                $v['img'] = domain($v['img']);
                $aa = getimagesize($v['img']);
                $v['img_width'] = $aa[0];
                $v['img_height'] = $aa[1];
            }
        }
        success($list);

    }

    /**
     * 清空活动足迹
     */
    public function del_activity_histroy(){
        $u = checklogin();
        $uid = I('uid');

        $list = M('activity_histroy')->where(['user_id'=>$uid])->delete();
        if($list){
            success('清空成功');
        }else{
            error('清空失败');
        }
    }

    /**
     * 商品浏览足迹
     */
    public function goods_histroy(){
        $u = checklogin();

        $page = I('page'); $pageSize = I('pagesize');
        $page ? $page : $page = 1;  $pageSize ? $pageSize : $pageSize = 10;

        $uid = I('uid');
        $list = M('shop_goods_histroy')->alias('a')
              ->join('m_shop_goods b ON a.goods_id = b.goods_id')
              ->field('a.id,a.goods_id,FROM_UNIXTIME(a.intime) as intime,a.user_id,a.count,b.goods_name,b.goods_img,b.goods_origin_price,b.goods_now_price')
              ->where(['a.user_id'=>$uid])
              ->order('a.count desc')
              ->page($page,$pageSize)
              ->select();
        if(!$list){
            $list = [];
        }else{
            foreach ($list as $k => &$v) {
                $v['goods_img'] = domain($v['goods_img']);
                $aa = getimagesize($v['goods_img']);
                $v['img_width'] = $aa[0];
                $v['img_height'] = $aa[1];

            }
        }
        success($list);

    }


    /**
     * 清空商品足迹
     */
    public function del_goods_histroy(){
        $u = checklogin();
        $uid = I('uid');

        $list = M('shop_goods_histroy')->where(['user_id'=>$uid])->delete();
        if($list){
            success('清空成功');
        }else{
            error('清空失败');
        }
    }


    /**
     * 非产品链接分享
     */
    public function links(){
        $u = checklogin();

        $data = [];
        $data['title'] = '【品聚分享购】';
        $data['content'] = '邀您分享全球好货，好友买的放心省钱，自己赚钱还赢口碑！上品聚，带好友共享省钱高招！';
        $data['img'] = C('IMG_PREFIX').'/Public/admin/touxiang.png';
        if($u['unionid']){
            $data['url'] = 'http://www.uyugame.com/main/main.php?target=invitee&gameKey=pj&game=z&parent='.$u['unionid'];
        }else{
            $data['url'] = 'http://qr01.cn/EWjb3m';
        }
        success($data);
        
    }

    public function demo(){
        // echo md5(uniqid(mt_rand(), true));
        // echo(strtotime("now") . "<br />");
        // echo(strtotime("+1 hours,2018-11-02 17:05:45") . "<br />");
        $a = D('userr');
        // print_r($a);
    }






}







