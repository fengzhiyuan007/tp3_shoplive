<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/11/14
 * Time: 下午2:34
 */

namespace Merchant\Model;
use Think\Model;
class VideoModel extends MyModel
{
    protected $tableName="video";
    //只读字段
    protected $readonly = ['video_id','member_id'];

    protected $pk = 'video_id';   //设置主键
    public function edit($data){

        $rules = array(
             array('title','require','名称必须填写'), 
             array('video_img','require','视频封面图片必须存在'), 
             array('url','require','视频必须上传'), 
    
        );

        $User = M("video"); // 实例化User对象
        if (!$User->validate($rules)->create()){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            $a['msg'] = $User->getError();
            $a['status'] = 'error';
            return $a;
        }else{
            $str = 'http://dspxplay.tstmobile.com/';
            if(strpos($data['url'],$str) ===false){
                $data['url'] = $str.$data['url'];
            }
            $data['video_img'] = domain($data['video_img']);
            if(empty($data['video_id'])){
                $data['intime'] = time();
                $result = $this->add($data);
                $action = '新增';
            }else{
                $data['uptime'] = time();
                $result = $this->where(array('video_id'=>$data['video_id']))->save($data);
                $action = '编辑';
            }
            if ($result) {
                $a['msg'] = '视频操作成功';
                $a['status'] = 'success';
                return $a;
            } else {
                $a['msg'] = '视频操作失败';
                $a['status'] = 'error';
                return $a;
            }
        }

    }
}