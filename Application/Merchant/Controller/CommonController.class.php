<?php

namespace Merchant\Controller;

use Think\Controller;
Vendor('php-qiniu-sdk.autoload');
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
class CommonController extends Controller {
    private $accessKey = 'pR_CsEkFcTn1Kgf8ZNIh2zUB_w8bzaeLYEgjBItT';
    private $secretKey = 'Vr2R_DMBvVHAtVmcwVGKF_C-ol6jDtCXqpiXlZZY';
    private $bucket = 'tst1';
	
	function _initialize() {

		if (method_exists ( $this, '_first' ))
			$this->_first ();
		if (method_exists ( $this, '_second' ))
			$this->_second ();

		
	}

    /*
    上传图片
     */
    public function upload(){
        $file = $_FILES;
        // print_r($file);

        $v = explode('/', $_FILES['imgFile']['type']);
        $vs = explode('/', $_FILES['img']['type']);
        // echo '11';
        // print_r($v);
        // print_r($vs);exit;
        if($v[0] == 'image'){
            // 构建鉴权对象
            $auth = new Auth($this->accessKey, $this->secretKey);
            // 生成上传 Token
            $token = $auth->uploadToken($this->bucket);
            // 要上传文件的本地路径
            $filePath = $_FILES['imgFile']['tmp_name'];
            // print_r($_FILES['file']['tmp_name']);exit;
            // 上传到七牛后保存的文件名
            $end = explode('.', $_FILES['imgFile']['name']);
            $en = $end[1];
            $key = md5(uniqid(mt_rand(), true)).'.'.$en;
            // $key = $_FILES['imgFile']['name'];
            // 初始化 UploadManager 对象并进行文件的上传。
            $uploadMgr = new UploadManager();

            // 调用 UploadManager 的 putFile 方法进行文件的上传。
            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);

            
            if($ret){
                // $ret['link'] = 'http://dspxplay.tstmobile.com/'.$ret['key'];
                // success($ret);
                $url = 'http://dspxplay.tstmobile.com/'.$ret['key'];
                echo json_encode(array('error' => 0, 'url' => $url));
                die;
            }else{
                $this->error($err);
            }
        }else if($vs[0] == 'image'){
            // 构建鉴权对象
            $auth = new Auth($this->accessKey, $this->secretKey);
            // 生成上传 Token
            $token = $auth->uploadToken($this->bucket);
            // 要上传文件的本地路径
            $filePath = $_FILES['img']['tmp_name'];
            // print_r($_FILES['file']['tmp_name']);exit;
            // 上传到七牛后保存的文件名
            $end = explode('.', $_FILES['img']['name']);
            $en = $end[1];
            $key = md5(uniqid(mt_rand(), true)).'.'.$en;
            // $key = $_FILES['img']['name'];
            // 初始化 UploadManager 对象并进行文件的上传。
            $uploadMgr = new UploadManager();

            // 调用 UploadManager 的 putFile 方法进行文件的上传。
            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);

            
            if($ret){
                // $ret['link'] = 'http://dspxplay.tstmobile.com/'.$ret['key'];
                // success($ret);
                $url = 'http://dspxplay.tstmobile.com/'.$ret['key'];
                echo json_encode(array('error' => 0, 'url' => $url));
                die;
            }else{
                $this->error($err);
            }
        }
    }


	// function upload(){
 //        $upload = new \Think\Upload();// 实例化上传类
 //        $upload->maxSize   =     3145728 ;// 设置附件上传大小
 //        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
 //        $upload->rootPath  =      './Public/upload/user_imgs/'; // 设置附件上传根目录
 //        // 上传单个文件 
 //        if($_FILES['imgFile']){
 //            $info   =   $upload->uploadOne($_FILES['imgFile']);
 //        }else{
 //            $info   =   $upload->uploadOne($_FILES['img']);
 //        }
        
 //        if(!$info) {// 上传错误提示错误信息
 //            $this->error($upload->getError());
 //        }else{// 上传成功 获取上传文件信息
 //             $re =  $info['savepath'].$info['savename'];
 //             $url = C('IMG_PREFIX').'/Public/upload/user_imgs/'.$re;
 //        }
 //        echo json_encode(array('error' => 0, 'url' => $url));
 //        die;
 //    }


// 	function _empty(){
// 		 header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码 
//         $this->display("Public:404"); 
// 	}
    /**
     *操作记录时新增日志
     */
    protected function work_log($table,$record_id,$type,$work){
        $data['table'] = $table;
        $user = session('shop');
        $data['user_id'] = $user['member_id'];
        $data['type'] = $type;   //判断是修改那类型。
        $data['record_id'] = $record_id;
        $data['title'] = $work;
        $data['intime'] = date("Y-m-d H:i:s",time());
        $data['user_type'] = '1';
        M('shop_work_log')->add($data);
    }

    /**
     *判断订单锁定人
     */
    protected function check_order_locker($order_id){
        $order = M('shop_order_merchants')->where(['order_no'=>$order_id])->find();
        $user = session('merchants');
        if($order['is_lock'] == '1' && $user['uname'] !=='admin'){
//          echo json_encode(array('status'=>'cannot','info'=>'你没有权限,无法进行操作!'));
            echo json_encode(array('status'=>'ok'));
            exit;
        }else{
//          if($order['locker_id'] == $user['id'] || $user['uname'] == 'admin'){
//              echo json_encode(array('status'=>'ok'));
//              exit;
//          }else{
//              echo json_encode(array('status'=>'cannot','info'=>'你没有权限,无法进行操作!'));
//              exit;
//          }
            echo json_encode(array('status'=>'ok'));
            die;
        }
    }

}