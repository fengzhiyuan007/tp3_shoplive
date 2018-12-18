<?php

namespace Admin\Controller;
Vendor('php-qiniu-sdk.autoload');
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class IndexController extends SessionController {
	private $accessKey = 'pR_CsEkFcTn1Kgf8ZNIh2zUB_w8bzaeLYEgjBItT';
    private $secretKey = 'Vr2R_DMBvVHAtVmcwVGKF_C-ol6jDtCXqpiXlZZY';
    // private $bucket = 'tstmobile';
    private $bucket = 'tst1';
    function head(){
        $this->assign('title',M('System')->getFieldById(1,'title'));
        $this->display();
    }
	function getMenus(){
		$menus = D ( 'Menus' );
		$roleid = 	session("roleid");
		if ($roleid == "admin") {
			$menulist = $menus->where ( array (
					'level' => 2,
					'status' => 1
			) )->order ( 'px asc' )->select ();
			for($i = 0; $i < countArray ( $menulist ); $i ++) {
				$menulist [$i] ['xjmenus'] = $menus->where ( array (
						'pid' => $menulist [$i] ['id'],'status' => 1
				) )->order ( 'px asc' )->select ();
			}
		}else{
			if ($roleid) {
				$mids = D("RoleMenu")->where(array("roleid"=>$roleid))->getField("menuid",true);
				$menulist = $menus->where ( array (
						'level' => 2,
						'status' => 1,
						"id"=>array("in",$mids)
				) )->order ( 'px asc' )->select ();
				for($i = 0; $i < countArray ( $menulist ); $i ++) {
					$menulist [$i] ['xjmenus'] = $menus->where ( array (
							'pid' => $menulist [$i] ['id'],
							'status' => 1,
							"id"=>array("in",$mids)
					) )->order ( 'px asc' )->select ();
				}
			}
		
		}
		$this->assign("list",$menulist);
		$this->display("menu");
	}
	// 后台首页 查看系统信息
	public function main() {
		$info = array (
				'操作系统' => PHP_OS,
				'运行环境' => $_SERVER ["SERVER_SOFTWARE"],
				'PHP运行方式' => php_sapi_name (),
				//'ThinkPHP版本' => THINK_VERSION . ' [ <a href="http://thinkphp.cn" target="_blank">查看最新版本</a> ]',
				'上传附件限制' => ini_get ( 'upload_max_filesize' ),
				'执行时间限制' => ini_get ( 'max_execution_time' ) . '秒',
				'服务器时间' => date ( "Y年n月j日 H:i:s" ),
				'北京时间' => gmdate ( "Y年n月j日 H:i:s", time () + 8 * 3600 ),
				'服务器域名/IP' => $_SERVER ['SERVER_NAME'] . ' [ ' . gethostbyname ( $_SERVER ['SERVER_NAME'] ) . ' ]',
				'剩余空间' => round ( (@disk_free_space ( "." ) / (1024 * 1024)), 2 ) . 'M',
				'register_globals' => get_cfg_var ( "register_globals" ) == "1" ? "ON" : "OFF",
				'magic_quotes_gpc' => (1 === get_magic_quotes_gpc ()) ? 'YES' : 'NO',
				'magic_quotes_runtime' => (1 === get_magic_quotes_runtime ()) ? 'YES' : 'NO'
		);
		$this->assign ( 'info', $info );
		$this->display ();
	}

	public function merchant_video(){
        $map = array();
        $name = I('content');
        
        !empty($name) && $map['a.content'] = array("like","%".$name."%");
        // $map['a.is_del'] = 1;
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M("trends")->alias('a')
        		->join("m_user b ON a.user_id = b.user_id",'LEFT')->where($map)->count(); // 查询满足要求的总记录数
        $p = getpage($count,$nus);
        $data= M("trends")->alias('a')
            ->field('a.content,a.id,a.img_url,a.url,a.play_number,a.creatime,a.tag,b.username')
            ->join("m_user b ON a.user_id = b.user_id",'LEFT')
            ->where($map)->order("a.creatime desc")->limit($p->firstRow.','.$p->listRows)
                ->select();

        $this->assign("show",$p->show());
        $this->assign(['list'=>$data,'count'=>$count]);
        $url =$_SERVER['REQUEST_URI'];
        session('url',$url);
        $this->assign ('pagetitle', '会员视频');
        $this->display();
    }

    /**
     *@删除视频
     */
    public function del_video(){
        if(IS_AJAX) {
            $id = I('ids');
            $data['id'] = array('in', $id);
            $user = M('trends')->where($data)->delete();
            if ($user) {
                echo json_encode(['status' => "ok", 'info' => '删除记录成功!']);
            } else {
                echo json_encode(['status' => "error", 'info' => '删除记录失败!']);
            }
        }
    }

    public function edit_video(){
        if(IS_POST){
            $data = I('post.');
            $data['tag'] = implode(',', $data['tag']);
            // print_r($data);exit;
            // $data['user_id'] = $merchant['member_id'];
            $data['type'] = 2;
            $model = D('trends');
            $result = $model->edit($data);

            if($result['status'] == 'success'){
            	$this->success($result['msg']);
            }else{
            	$this->error($result['msg']);
            }
        }else{
            // $data['user_id']  = $merchant['member_id'];
            $id = I('id');
            $re = M('trends')->where(['id'=>$id])->find();

            $map['is_del'] = '1';
	        // $map['is_titles'] = '1';
	        // $map['is_authen'] = '2';
            $user = M('user')->where($map)->field('user_id, username')->select();

            
            $this->assign(['re'=>$re]);
            $this->assign(['user'=>$user]);
        	$this->assign ('pagetitle', '编辑视频');
            $this->display('add_video');
        }
    }

    public function add_video(){
    	$id = I('id');
        $re = M('trends')->where(['id'=>$id])->find();
        $tagids = explode(',', $re['tag']);
        $map['is_del'] = '1';
        // $map['is_titles'] = '1';
        // $map['is_authen'] = '2';
        $user = M('user')->where($map)->field('user_id, username')->select();

        $tag = M('tag')->field('name')->select();
        $this->assign(['tag'=>$tag]);
        $this->assign(['tagids'=>$tagids]);
        $this->assign(['re'=>$re]);
        $this->assign(['user'=>$user]);
    	$this->assign ('pagetitle', '编辑视频');
        $this->display();
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
     *搜索会员
     */
    public function searchUser(){
        $name = I('name');
        $name && $map['username'] = ['like','%'.$name.'%'];
        $map['is_del'] = '1';
        $map['is_titles'] = '1';
        $map['is_authen'] = '2';

        $user = M('user')->where($map)->select();
        $type_list="<option value=''>请选择会员</option>";
        if($user){
            foreach ($user as $v){
                $type_list.='<option value='.$v['user_id'].'>'.$v['username'].'</option>';
            }
        }
        echo $type_list;
    }

    /**
     *七牛token
     */
    public function get_qiniu_token(){
        $accessKey = $this->accessKey;
        $secretKey = $this->secretKey;
        $bucket = $this->bucket;
        // 初始化Auth状态

        $auth = new Auth($accessKey, $secretKey);
        $expires = 3600;
        $policy = null;
        $upToken = $auth->uploadToken($bucket, null, $expires, $policy, true);
        echo json_encode(['uptoken'=>$upToken]);
    }
}