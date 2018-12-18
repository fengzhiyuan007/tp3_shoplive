<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/11/14
 * Time: 下午2:34
 */

namespace Admin\Model;
use Think\Model;
class TrendsModel extends MyModel
{
    protected $tableName="trends";
    //只读字段
    protected $readonly = ['id'];

    protected $pk = 'id';   //设置主键
    public function edit($data){

        $rules = array(
             // array('title','require','名称必须填写'), 
             array('img_url','require','视频封面图片必须存在'), 
             array('url','require','视频必须上传'), 
    
        );

        $User = M("trends"); // 实例化User对象
        if (!$User->validate($rules)->create()){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            $a['msg'] = $User->getError();
            $a['status'] = 'error';
            return $a;
        }else{
            // $str = 'http://msplay.qqyswh.com/';
            $str = 'http://dspxplay.tstmobile.com/';
            if(strpos($data['url'],$str) ===false){
                $data['url'] = $str.$data['url'];
            }
            // $data['img_url'] = domain($data['img_url']);
            if(empty($data['id'])){
                $data['creatime'] = time();
                $result = $this->add($data);
                $action = '新增';
            }else{
                $data['creatime'] = time();
                $result = $this->where(array('id'=>$data['id']))->save($data);
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