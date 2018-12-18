<?php
namespace  Admin\Controller;
/**
 * 用户
 * @author 
 *
 */
use Think\Db;

class LiveController extends CommonController {
    function _initialize() {
        $nums = ['5','10','15','20','25','30','50','100'];
        $this->assign('nums',$nums);
    }
	/**
     * @直播列表
     */
	public function index(){
        if( !M()->autoCheckToken($_POST) ) $this->error('禁止站外提交！');
        unset($_POST['__hash__']);
        $data = [];
        if (!empty($_GET['username'])){
            $data['a.title|b.ID'] = ['like','%'.$_GET['username'].'%'];
            $this->assign('username',$_GET['username']);
        }
        if (!empty($_GET['live_status'])){
            $data['a.live_status'] = ['eq',$_GET['live_status']];
            $this->assign('live_status',$_GET['live_status']);
        }
        if (!empty($_GET['start']) && empty($_GET['end'])){
            $start = strtotime($_GET['start']);
            $data['a.intime'] = ['gt',$start];
            $this->assign('start',$_GET['start']);
        }elseif(empty($_GET['start']) && !empty($_GET['end'])){
            $end = strtotime($_GET['end'])+(24*60*60-1);
            $data['a.intime'] = ['lt',$end];
            $this->assign('end',$_GET['end']);
        }elseif(!empty($_GET['start']) && !empty($_GET['end'])){
            $start = strtotime($_GET['start']);
            $end = strtotime($_GET['end'])+(24*60*60-1);
            $data['a.intime'] = ['between',[$start,$end]];
            $this->assign('start',$_GET['start']);  $this->assign('end',$_GET['end']);
        }
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M('Live')->alias('a')->join('__USER__ b on a.user_id=b.user_id')->where($data)->count();//一共有多少条记录
        $p = getpage($count,$nus);
        $regular = M('System')->where(['id'=>1])->getField('regular');
        switch ($regular){
            case 1:
                $order = 'a.live_status asc,a.intime desc';
                break;
            case 2:
                $order = 'a.live_status asc,a.watch_nums desc';
                break;
            case 3:
                $order = 'a.live_status asc,b.get_money desc';
                break;
        }
        $list =  M('Live')
            ->alias('a')
            ->field('a.*,b.username,b.img,b.sex,b.phone,b.ID')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->limit($p->firstRow.','.$p->listRows)
            ->where($data)
            ->order($order)
            ->select();
        foreach ($list as $k=>$v){
            $gift_count = M('Give_gift')->where(['live_id'=>$v['live_id']])->sum('jewel');
            $gift_count ? $list[$k]['gift_count'] = $gift_count : $list[$k]['gift_count'] = '0';
        }
        $this->assign('list',$list);
        $this->assign("show",$p->show());
        $this->assign ( 'pagetitle', '直播列表' );
	    $this->display();
    }
    public function play_live(){
        $id = I('id');
        $live = M('Live')->find($id);
        $this->assign('l',$live);
        $this->display();
    }
    /**
     *@强制下线
     */
    public function offline(){
        $id = I('id');
        $live = M('Live')->where(['live_id'=>$id])->find();

        /**更改活动数据**/
        M('activity')->where(array('type'=>2,'a_id'=>$live['a_id']))->setField(array('type'=>3,'x_id'=>0,'store_status'=>2));
        /**更改活动数据**/

        $rs = M('Live')->where(['live_id'=>$id])->save(['live_status'=>2,'end_time'=>time(),'is_normal_exit'=>1,'is_offline'=>2]);
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
        echo $rs ? 1 : 2;
    }

    /**
     * @踢出热门
     */
    public function tichu(){
        $id = I('ids');
        $rs = M('Live')->where(['live_id'=>$id])->save(['is_hot'=>2,'uptime'=>time()]);
        echo $rs ? 1 : 2;
    }
    /**
     * @恢复热门
     */
    public function huifu(){
        $id = I('ids');
        $rs = M('Live')->where(['live_id'=>$id])->save(['is_hot'=>1,'uptime'=>time()]);
        echo $rs ? 1 : 2;
    }

    /**
     * @推荐跳转
     */
    public function tuijian(){
        $live_id = intval(I('live_id')); $val = I('val');
        $rs = M('Live')->where(['live_id'=>$live_id])->save(['is_tuijian'=>2,'location'=>$val,'uptime'=>time()]);
        echo $rs ? 1 : 2;
    }

    /**
     * @推荐跳转
     */
    public function quxiao(){
        $live_id = intval(I('ids'));
        $rs = M('Live')->where(['live_id'=>$live_id])->save(['is_tuijian'=>1,'location'=>'','uptime'=>time()]);
        echo $rs ? 1 : 2;
    }


    /**
     * @热门排列规则
     */
    public function regular(){
        $id = intval(I('id'));
        if ($id){
            $data = [
                'id'=>$id,
                'regular'=>I('regular'),
                'uptime'=>time()
            ];
            if (M('System')->save($data)){
                $this->success('成功!',U('regular'));
            }else{
                $this->error('失败!',U('regular'));
            }
        }else{
            $system = M('System')->field('id,regular')->where(['id'=>1])->find();
            $this->assign('s',$system);
            $this->assign ( 'pagetitle', '热门排列规则' );
            $this->display();
        }
    }

    /******************************************录播列表********************************************************/

    /**
     * @录播列表
     */
    public function recorded(){
        if( !M()->autoCheckToken($_POST) ) $this->error('禁止站外提交！');
        unset($_POST['__hash__']);
        $data = [];
        if (!empty($_GET['username'])){
            $data['b.username|b.ID'] = ['like','%'.$_GET['username'].'%'];
            $this->assign('username',$_GET['username']);
        }
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M('Live_store')->alias('a')->join('__USER__ b on a.user_id=b.user_id')->where($data)->count();//一共有多少条记录
        $p = getpage($count,$nus);
        $list =  M('Live_store')
            ->alias('a')
            ->field('a.*,b.username,b.img,b.sex,b.phone,b.ID')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->limit($p->firstRow.','.$p->listRows)
            ->where($data)
            ->order('a.intime desc')->select();
        $this->assign('list',$list);
        $this->assign("show",$p->show());
        $this->assign ( 'pagetitle', '录播列表' );
        $this->display();
    }
    public function play(){
        $id = I('id');
        $live_store = M('Live_store')->find($id);
        $this->assign('l',$live_store);
        $this->display();
    }
    /**
     * @彻底删除
     */
    public function del(){
        $id = I('ids');
        $rs = M('Live_store')->where(['live_store_id'=>['in',$id]])->delete();
        echo $rs ? 1 : 2;
    }



    /******************************************视频列表********************************************************/

    /**
     * @视频列表
     */
    public function video(){
        if( !M()->autoCheckToken($_POST) ) $this->error('禁止站外提交！');
        unset($_POST['__hash__']);
        $data = [
            'a.is_del'=>1
        ];
        if (!empty($_GET['username'])){
            $data['b.username|a.title|b.ID'] = ['like','%'.$_GET['username'].'%'];
            $this->assign('username',$_GET['username']);
        }
        if (!empty($_GET['is_shenhe'])){
            $data['a.is_shenhe'] = ['eq',$_GET['is_shenhe']];
            $this->assign('is_shenhe',$_GET['is_shenhe']);
        }
        if (!empty($_GET['start']) && empty($_GET['end'])){
            $start = strtotime($_GET['start']);
            $data['a.intime'] = ['gt',$start];
            $this->assign('start',$_GET['start']);
        }elseif(empty($_GET['start']) && !empty($_GET['end'])){
            $end = strtotime($_GET['end'])+(24*60*60-1);
            $data['a.intime'] = ['lt',$end];
            $this->assign('end',$_GET['end']);
        }elseif(!empty($_GET['start']) && !empty($_GET['end'])){
            $start = strtotime($_GET['start']);
            $end = strtotime($_GET['end'])+(24*60*60-1);
            $data['a.intime'] = ['between',[$start,$end]];
            $this->assign('start',$_GET['start']);  $this->assign('end',$_GET['end']);
        }
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M('Video')
            ->alias('a')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where($data)
            ->count();//一共有多少条记录
        $p = getpage($count,$nus);
        $list =  M('Video')
            ->alias('a')
            ->field('a.*,b.username,b.ID')
            ->join('__USER__ b on a.user_id=b.user_id')
            ->where($data)
            ->order('a.intime desc')->select();
        $this->assign('list',$list);
        $this->assign("show",$p->show());
        $this->assign ( 'pagetitle', '视频列表' );
        $this->display();
    }

    /**
     * @审核
     */
    public function shenhe_video(){
        $id = I('id');
        $video_id = I('video_id');
        $rs = M('Video')->where(['video_id'=>$video_id])->save(['is_shenhe'=>$id,'uptime'=>time()]);
        echo $rs ? 1 : 2;
    }

    /**
     * @添加、修改映射
     */
    public function toadd_video(){
        if( !M()->autoCheckToken($_POST) ) $this->error('禁止站外提交！');
        unset($_POST['__hash__']);

        //省
        $sheng = M('Areas')->where("level=1")->select();
        $this->assign('sheng',$sheng);
        //标签
        $lebel = M('Lebel')->where(['type'=>1])->select();
        $this->assign('lebel',$lebel);
        $id = I('id');
        if ($id){
            $info = M('Video')->find($id);
            $info['intime'] = date('Y-m-d H:i:s',$info['intime']);
            $fid = M('Areas')->where(array('name' => $info['sheng'], 'level' => 1))->getField('id');
            if ($fid) {
                $data['fid'] = $fid;
                $data['level'] = 2;
                $info['shi2'] = M('Areas')->where($data)->select();  //市
            } else {
                $info['shi2'] = null;
            }
            $info['city_id'] = M('Areas')->where(array('name' => $info['shi'], 'level' => 2))->getField('id');
            $this->assign('u',$info);
            $sta = '编辑';
        }else{
            $sta = '添加';
        }
        $this->assign ( 'pagetitle', $sta );
        $this->display();
    }

    /**
     * @修改
     */
    public function doadd_video(){
        if( !M()->autoCheckToken($_POST) ) $this->error('禁止站外提交！');
        unset($_POST['__hash__']);
        $id = I('id');
        $logo = I('logo');
        $url = I('video');
        $riqi = I('riqi');
        if ($riqi){
            $time = strtotime($riqi);
        }else{
            $time = time();
        }
        $date = date('Y-m-d',$time);
        $data = [
            'play_img'=>$logo,
            'username'=>I('username'),
            'title'=>I('title'),
            'url'=>$url,
            'lebel'=>I('lebels'),
//            'sheng'=>M('Areas')->where(array('id'=>I('sheng')))->getField('name'),
//            'shi'=>M('Areas')->where(array('id'=>I('shi')))->getField('name'),
            'sheng'=>I('sheng'),
            'shi'=>I('shi'),
            'intime'=>$time,
            'date'=>$date,
        ];
        if ($id){
            $video = M('Video')->find($id);
            $data['uptime'] = time();
            if (M('Video')->where(['video_id'=>$id])->save($data)){
                if ($video['url']!=$url){
                    unlink($video['url']);
                }
                $this->success('成功!',U('video'));
            }else{
                $this->error('失败!',U('video'));
            }
        }else{
            M('Video')->add($data) ? $this->success('成功!',U('video')) : $this->error('失败!',U('video'));
        }
    }

    /**
     * @删除
     */
    public function del_video(){
        $id = I('ids');
        $rs = M('Video')->where(['video_id'=>['in',$id]])->save(['is_del'=>2,'uptime'=>time()]);
        echo $rs ? 1 : 2;
    }



    public function play_video(){
        $id = I('id');
        $video = M('Video')->find($id);
        $this->assign('l',$video);
        $this->display();
    }




    /*****************************************音乐管理*********************************************************/

    public function music(){
        if( !M()->autoCheckToken($_POST) ) $this->error('禁止站外提交！');
        unset($_POST['__hash__']);
        $data = [];
        if (!empty($_GET['username'])){
            $data['song_name|singer'] = ['like','%'.$_GET['username'].'%'];
            $this->assign('username',$_GET['username']);
        }
        if (!empty($_GET['start']) && empty($_GET['end'])){
            $start = strtotime($_GET['start']);
            $data['intime'] = ['gt',$start];
            $this->assign('start',$_GET['start']);
        }elseif(empty($_GET['start']) && !empty($_GET['end'])){
            $end = strtotime($_GET['end'])+(24*60*60-1);
            $data['intime'] = ['lt',$end];
            $this->assign('end',$_GET['end']);
        }elseif(!empty($_GET['start']) && !empty($_GET['end'])){
            $start = strtotime($_GET['start']);
            $end = strtotime($_GET['end'])+(24*60*60-1);
            $data['intime'] = ['between',[$start,$end]];
            $this->assign('start',$_GET['start']);  $this->assign('end',$_GET['end']);
        }
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M('Music')
            ->where($data)
            ->count();//一共有多少条记录
        $p = getpage($count,$nus);
        $list =  M('Music')
            ->where($data)
            ->order('intime desc')
            ->limit($p->firstRow.','.$p->listRows)
            ->select();
        foreach ($list as $k=>$v){
            $list[$k]['path'] = C('IMG_PREFIX').$v['path'];
        }
        $this->assign('list',$list);
        $this->assign("show",$p->show());
        $this->assign ( 'pagetitle', '音乐列表' );
        $this->display();
    }
    /**
     * @添加、修改映射
     */
    public function toadd_music(){
        if( !M()->autoCheckToken($_POST) ) $this->error('禁止站外提交！');
        unset($_POST['__hash__']);
        $id = I('id');
        if ($id){
            $info = M('Music')->find($id);
            $this->assign('u',$info);
            $sta = '编辑';
        }else{
            $sta = '添加';
        }
        $this->assign ( 'pagetitle', $sta );
        $this->display();
    }

    /**
     * @修改
     */
    public function doadd_music(){
        if( !M()->autoCheckToken($_POST) ) $this->error('禁止站外提交！');
        unset($_POST['__hash__']);
        $id = I('id');
        $url = '.'.I('url');

        $getID3 = new \getID3();
        $FileInfo = $getID3->analyze($url); //分析文件，$path为音频文件的地址
        //var_dump($ThisFileInfo);
//       echo '播放时间：'.$FileInfo['playtime_string'] .'<br />';
//       echo '文件大小：'.$FileInfo['filesize'] .'<br />';
//       echo '文 件 名:'.$FileInfo['filename'] .'<br />';
//       echo '文件后缀：'.$FileInfo['audio']['dataformat'] .'<br />';
//       echo '标    题：'.$FileInfo['tags']['asf']['album'][0].'<br />';
//       echo '歌    名：'.$FileInfo['tags']['id3v2']['title'][0].'<br />';
//       echo '歌    手：'.$FileInfo['tags']['id3v2']['artist'][0].'<br />';
//       echo '比 特 率：'.round($FileInfo['audio']['bitrate']/1000,0).' kbps<br />';
//       print("<pre>");
//       print_r($FileInfo);
//       print("</pre>");
        $data = [
            'path'=>$url,
            'song_name'=>$FileInfo['tags']['id3v2']['title'][0],
            'singer'=>$FileInfo['tags']['id3v2']['artist'][0],
            'time'=>$FileInfo['playtime_string'],
            'size'=>$FileInfo['filesize'],
        ];
        if ($id){
            $video = M('Music')->find($id);
            $data['uptime'] = time();
            if (M('Music')->where(['music_id'=>$id])->save($data)){
                if ($video['path']!=$url){
                    unlink($video['path']);
                }
                $this->success('成功!',U('music'));
            }else{
                $this->error('失败!',U('music'));
            }
        }else{
            $data['intime'] = time();
            $data['date'] = date('Y-m-d',time());
            M('Music')->add($data) ? $this->success('成功!',U('music')) : $this->error('失败!',U('music'));
        }
    }

    /**
     * @删除
     */
    public function del_music(){
        $id = I('ids');
        $rs = M('Music')->where(['music_id'=>['in',$id]])->delete();
        echo $rs ? 1 : 2;
    }


    /**
     * 活动列表
     * 
     */
    public function activity_list(){
        $map = array();
        !empty($_GET['username']) && $map['a.title'] = array("like","%".I('username')."%");
        if(!empty($_GET['start_time'])) $start_time = strtotime(I('start_time')); else $start_time = 0;
        if(!empty($_GET['end_time']))   $end_time = strtotime(I('end_time')); else $end_time = time();
        $map['a.intime'] = ['between',[$start_time,$end_time]];
        $map['a.is_del'] = 1;
        $map['b.is_del'] = 1;
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);

        $count = M('activity')->alias('a')
                ->join('__USER__ b ON a.user_id = b.user_id')
                ->where($map)
                ->count();
        $p = getpage($count,$nus);
        $this->assign("show",$p->show());

        $data = M('activity')->alias('a')
              ->join('__USER__ b ON a.user_id = b.user_id')
              ->where($map)
              ->field('a.*,b.username')
              ->order('a.sort desc,a.intime desc')
              ->limit($p->firstRow.','.$p->listRows)
              ->select();

        $this->assign ('pagetitle', '活动列表' );
        $this->assign(['list'=>$data,'count'=>$count]);
        $url =$_SERVER['REQUEST_URI'];
        session('url',$url);
        $this->display();
    }

    /**
     * 
     * 添加 编辑活动
     * @return [type] [description]
     */
    public function edit_activity(){

        if(IS_POST){
            $data = $_POST;
            $model = D('activity');
            if($data['type'] == 1){
                $user = M('User')->where(['user_id' =>$data['user_id']])->find();
                $user['username'] ? $name = $user['username'] : $name = "直播间" . rand(100, 999);
                $options = [
                    'name' => $name,
                    'description' => $name,
                    'maxusers' => 3000,
                    'owner' => $user['hx_username']
                ];
                $create = createChatRoom($options);
                // print_r($create);exit;
                $create['error'] ? $this->error('创建聊天室失败!') : true;

                $data['room_id'] = $create['data']['id'];
            }
            $data['tag'] = implode(',', $data['tag']);
            $data['goods_id'] = implode(',', $data['goods_id']);

            if(empty($data['tag'])){
                $this->error('请选择标签');
            }
            $sheng = I('sheng');
            $shi = I('shi');
            $qu = I('qu');
            $data['sheng'] = M('Areas')->where(array('id' => $sheng))->getField('name');
            $data['shi'] = M('Areas')->where(array('id' => $shi))->getField('name');
            $data['qu'] = M('Areas')->where(array('id' => $qu))->getField('name');
            $address = getLonLat($data['address']);
            $data['log'] = $address['0'];
            $data['lag'] = $address['1'];
            $result = $model->edit($data);

            if($result['status'] == 'success'){
                $this->success($result['msg']);
            }else{
                $this->error($result['msg']);
            }
        }else{
            $id = I('id');
            $re = M('activity')->where(['a_id'=>$id])->find();

            $re['imgs'] = explode(',',$re['imgs']);

            $tagids = explode(',', $re['tag']);
            $tag = M('tag')->field('name,(count+counts) as count')->order('count desc')->select();
            $sheng = M('Areas')->where(array('level'=>1))->select();
            if (!empty($re)) {
                $fid = M('Areas')->where(array('name' => $re['sheng'], 'level' => 1))->getField('id');

                if ($fid) {
                    $data['pid'] = $fid;
                    $data['level'] = 2;
                    $re['shis'] = M('Areas')->where($data)->select();  //市
                    
                } else {
                    $re['shis'] = null;
                }
                $fid2 = M('Areas')->where(array('name' => $re['shi'], 'level' => 2))->getField('id');
                
                if ($fid2) {
                    $date['pid'] = $fid2;
                    $date['level'] = 3;
                    $re['qus'] = M('Areas')->where($date)->select();  //区
                } else {
                    $re['qus'] = null;
                }
                $re['city_id'] = M('Areas')->where(array('name' => $re['shi'], 'level' => 2))->getField('id');
                $re['area_id'] = M('Areas')->where(array('name' => $re['qu'], 'level' => 3))->getField('id');
            }
            $map['is_del'] = '1';
            // $map['is_titles'] = '1';
            // $map['is_authen'] = '2';
            $user = M('user')->where($map)->field('user_id, username')->select();
            $goods = M('shop_goods')->where(['goods_id'=>['IN',$re['goods_id']]])->field('goods_id,goods_name,goods_img')->select();

            $this->assign(['goods'=>$goods]);
            $this->assign(['tag'=>$tag]);
            $this->assign(['user'=>$user]);
            $this->assign(['tagids'=>$tagids]);
            $this->assign(['sheng'=>$sheng]);
            $this->assign(['re'=>$re]);
            $this->display('add_activity');
        }
    }

    public function add_activity(){
        $map['is_del'] = '1';
        // $map['is_titles'] = '1';
        // $map['is_authen'] = '2';
        $user = M('user')->where($map)->field('user_id, username')->limit(50)->select();
        //省
        $sheng = M('Areas')->where(array('level'=>1))->select();
        $tag = M('tag')->field('name,(count+counts) as count')->order('count desc')->select();

        $this->assign(['sheng'=>$sheng]);
        $this->assign(['tag'=>$tag]);
        $this->assign(['user'=>$user]);
        $this->assign ('pagetitle', '添加活动');
        $this->display();
    }

    /**
     * 删除活动
     */
    public function del_activity(){
        if(IS_AJAX) {
            $id = I('ids');
            $data['a_id'] = array('in', $id);
            $user = M('activity')->where($data)->save(['is_del' => 2]);
            if ($user) {
                echo json_encode(['status' => "ok", 'info' => '删除记录成功!']);
            } else {
                echo json_encode(['status' => "error", 'info' => '删除记录失败!']);
            }
        }
    }

    /**
     *
     * 改变状态
     */
    public function change_activity_review(){
        if(IS_AJAX){
            $id = I('id');
            $status = M('activity')->where(['a_id'=>$id])->getField('state');
            $abs = 3 - $status;
            $result = M('activity')->where(['a_id'=>$id])->save(['state'=>$abs]);
            if($result){
                return success($abs);
            }else{
                return error('切换状态失败');
            }
        }
    }

    /**
     *@修改审核状态
     */
    public function change_activity_shenhe(){
        if(IS_AJAX){
            $id = I('id');
            $status = M('activity')->where(['a_id'=>$id])->getField('state');
            switch ($status) {
                case '1':
                    $abs = 3;
                    $result = M('activity')->where(['a_id'=>$id])->save(['state'=>$abs]);
                    break;
                case '2':
                    $abs = 3;
                    $result = M('activity')->where(['a_id'=>$id])->save(['state'=>$abs]);
                    break;
                case '3':
                    $abs = 1;
                    $result = M('activity')->where(['a_id'=>$id])->save(['state'=>$abs]);
                    break;
                default:
                    # code...
                    break;
            }
            //$arr = ['默认状态','开启状态'];
            if($result){
                echo json_encode(array('status'=>'ok','info'=>$abs));
                exit;
            }else{
                echo json_encode(array('status'=>'error','info'=>'切换状态失败'));
                exit;
            }
        }
    }


    /**
     *商品列表
     */
    public function goods_list(){
        $map = [];
        $name = I('name'); // 获取所有的post变量（原始数组）
        $merchants_id = I('merchants_id');
        $goods_state = I('goods_state'); // 获取所有的post变量（原始数组）
        $parent_class = I('parent_class'); // 获取所有的post变量（原始数组）
        $seed_class = I('seed_class'); // 获取所有的post变量（原始数组）
        !empty($name) &&  $map['goods_name'] = ['like', '%' . $name . '%'];
        !empty($goods_state) && $map['goods_state'] = $goods_state;
        !empty($parent_class) && $map['parent_class'] = $parent_class;
        !empty($seed_class) && $map['seed_class'] = $seed_class;
        !empty($merchants_id) && $map['merchants_id'] = $merchants_id;
        $map['is_delete'] = '0';
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M('shop_goods')->where($map)->count();
        $p = getpage($count,$nus);
        $data = M("shop_goods")
                ->where($map)
                ->order("goods_state asc,sort desc,create_time desc")
                ->limit($p->firstRow.','.$p->listRows)
                ->select();
        $parent_class = M('shop_goods_class')
            ->field('class_id,class_name')
            ->where(['class_state'=>'1','is_delete'=>'0','parent_id'=>'-1'])
            ->select();
        $this->assign("show",$p->show());
        $this->assign ('pagetitle', '商品列表');   
        $this->assign(['list' => $data,'count'=>$count, 'parent_class'=>$parent_class]);
        $url = $_SERVER['REQUEST_URI'];
        session('url', $url);
        $this->display();
    }


    /**
     * 添加商品
     * 
     */
    public function add_goods($kid){
        $map['goods_id'] = ['IN',$kid];
        $list = M('shop_goods')->where($map)->field('goods_id,goods_name,goods_img')->select();
        if(!$list){
            $list = [];
        }
        echo json_encode($list);
    }














	
}