<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/9/27
 * Time: 上午10:11
 */

namespace Admin\Model;
use Think\Model;
class BannerModel extends MyModel
{
    protected $tableName="shop_banner";
    //只读字段
    protected $pk = 'b_id';   //设置主键

    /**
     *新增或编辑
     */
    public function edit_banner($data){
        $rules = array(
             array('b_img','require','请上传轮播banner图'),
             array('b_type','require','请选择轮播图类型'),
             array('title','require','请填写轮播主题'),
             array('type','require','请选择轮播轮播图使用场景'),

        );
        $User = M("shop_banner"); // 实例化User对象
        if (!$User->validate($rules)->create()){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            $a['msg'] = $User->getError();
            $a['status'] = 'error';
            return $a;
        }else{ 

            switch ($data['b_type']){
                case 1:
                    break;
                case 2:
                    if(empty($data['url'])){
                        $a['msg'] = "请填写跳转链接";
                        $a['status'] = 'error';
                        return $a;
                    }else{
                        $data['jump'] = $data['url'];
                    }
                    break;
                case 3:
                    if(empty($data['class_uuid'])){
                        $a['msg'] = "请选择分类";
                        $a['status'] = 'error';
                        return $a;
                    }else{
                        $data['jump'] = $data['class_uuid'];
                    }
                    break;
                case 4:
                    if(empty($data['merchant'])){
                        $a['msg'] = "商家不能为空";
                        $a['status'] = 'error';
                        return $a;
                    }else{
                        $data['jump'] = $data['merchant'];
                    }
                    break;
                case 5:
                    if(empty($data['goods'])){
                        $a['msg'] = "商品不能为空";
                        $a['status'] = 'error';
                        return $a;
                    }else{
                        $data['jump'] = $data['goods'];
                    }
                    break;
                case 6:
                    $data['jump'] = $data['coupon'];
                    break;
                case 8:
                    if(empty($data['user'])){
                        $a['msg'] = "用户名不能为空";
                        $a['status'] = 'error';
                        return $a;
                    }else{
                        $data['jump'] = $data['user'];
                    }
                    break;
            }
            $data['b_img'] = domain($data['b_img']);
            if(empty($data['b_id'])){
                $data['b_intime'] = date("Y-m-d h:i:s",time());
                $action = '新增';
                $result = $this->add($data);
            }else{
                $data['uptime'] = date("Y-m-d h:i:s",time());
                $action = '编辑';
                $result = $this->where(['b_id'=>$data['b_id']])->save($data);
            }

            
            if ($result) {
                $a['msg'] = '轮播banner图成功';
                $a['status'] = 'success';
                return $a;
            } else {
                $a['msg'] = '轮播banner图失败';
                $a['status'] = 'error';
                return $a;
            }
        }
        
    }

    /**
     * 软删除
     */
    public function soft_del($id){
        $data = [
            'is_del'        => '2',
            'delete_time'   => date("Y-m-d H:i:s")
            ];
        $result = $this->where(['b_id'=>['in',$id]])->save($data);
        if($result){
            return 'success';
        }else{
            return 'error';
        }
    }

    /**
     * 真实删除
     */
    public function del($id){
        $result = $this->where(['b_id'=>['in',$id]])->delete();
        if($result){
            return 'success';
        }else{
            return 'error';
        }
    }

    /**
     *恢复数据
     */
    public function restore($id){
        $data = [
            'is_del'        => '1',
            'delete_time'   => date("Y-m-d H:i:s")
        ];
        $result = $this->where(['b_id'=>['in',$id]])->save($data);
        if($result){
            return 'success';
        }else{
            return 'error';
        }
    }

    /**
     *修改banner状态
     */
    public function change_status($id){
        $status = $this->where(['b_id'=>$id])->getField('status');
        if(!$status)     return false;
        $abs = 3 - $status;
        //$arr = ['默认状态','开启状态'];
        $result = $this->where(['b_id'=>$id])->save(['status'=>$abs]);
        if($result){
            return $abs;
        }else{
            return false;
        }
    }

}