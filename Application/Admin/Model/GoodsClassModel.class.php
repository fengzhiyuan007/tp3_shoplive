<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/10/20
 * Time: 下午3:27
 */

namespace Admin\Model;
use Think\Model;
class GoodsClassModel extends MyModel
{   
    protected $tableName="shop_goods_class";
    //只读字段
    protected $readonly = ['class_id','class_uuid'];

    protected $pk = 'class_id';   //设置主键
    public function edit_class($data,$scene=''){

        $rules = array(
             array('class_name','require','请填写名称'), 
             array('class_imgs','require','图片必须上传'), 
             array('class_desc','require','请填写简介'), 
             array('template_img','require','banner图片必须上传'), 
             array('sort','require','请设置权重排序'), 
    
        );

        $User = M("shop_goods_class"); // 实例化User对象
        if (!$User->validate($rules)->create()){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            $a['msg'] = $User->getError();
            $a['status'] = 'error';
            return $a;
        }else{
            if(strpos($data['class_color'],'#') === false){
                    $data['class_color'] = '#'.$data['class_color'];
                }
                $data['class_img'] = domain($data['class_imgs']);
                $data['template_img'] = domain($data['template_img']);
                if(empty($data['class_id'])){
                    $data['create_time'] = date("Y-m-d H:i:s",time());
                    $action = '新增';
                    $where = [];
                    $result = $this->add($data);
                }else{
                    $data['update_time'] =   date("Y-m-d H:i:s",time());
                    $action = '编辑';
                    $where['class_id'] = $data['class_id'];
                    $result = $this->where($where)->save($data);
                }

                // $result = $this->allowField(true)->save($data,$where);
                $url = session('url');
                // if($result){
                //     // return success(['info'=>$action.'分类操作成功','url'=>$url]);
                //     return 'success';
                // }else{
                //     // return error($action.'分类操作失败');
                //     return 'error';
                // }
                if ($result) {
                    $a['msg'] =  $action .'分类操作成功';
                    $a['status'] = 'success';
                    return $a;
                } else {
                    $a['msg'] = $action .'分类操作失败';
                    $a['status'] = 'error';
                    return $a;
                }
            }
        }
        
        

    /**
     *删除
     */
    public function del_class($where){
        $result = $this->where($where)->save(['is_delete'=>'1']);
        if($result){
            $url = session('url');
            return 'success';
        }else{
            return 'error';
        }
    }
}