<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/11/2
 * Time: 下午5:04
 */

namespace Admin\Model;
use Think\Model;
class DressModel extends MyModel
{
    protected $tableName="shop_dress";
    //只读字段
    protected $readonly = ['dress_id'];
    protected $pk = 'dress_id';   //设置主键

    public function edit($data,$scene=''){

        $rules = array(
             array('title','require','标题名称不能为空'),
             array('img','require','必须上传图片'),
             array('type','require','请选择跳转类型'),
             array('layout','require','请选择下行布局长度'),

        );

        $User = M("shop_dress"); // 实例化User对象
        if (!$User->validate($rules)->create()){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            // exit($User->getError());
            $a['msg'] = $User->getError();
            $a['status'] = 'error';
            return $a;
        }else{
             // 验证通过 可以进行其他数据操作
            $data['img'] = domain($data['img']);
            $array = getimagesize($data['img']);
            $data['width'] = $array[0];
            $data['height'] = $array[1];

            switch ($data['type']){
                case 1:
                    break;
                case 2:
                    if(empty($data['url'])){
                        $this->error("请填写跳转链接");
                    }else{
                        $data['jump'] = $data['url'];
                    }
                    break;
                case 3:
                    if(empty($data['class_uuid'])){
                        $this->error("请选择分类");
                    }else{
                        $data['jump'] = $data['class_uuid'];
                    }
                    break;
                case 4:
                    if(empty($data['merchant'])){
                        $this->error("商家不能为空");
                    }else{
                        $data['jump'] = $data['merchant'];
                    }
                    break;
                case 5:
                    if(empty($data['goods'])){
                        $this->error("商品不能为空");
                    }else{
                        $data['jump'] = $data['goods'];
                    }
                    break;
                case 6:
                    if(empty($data['coupon'])){
                        $this->error("优惠券不能为空");
                    }else{
                        $data['jump'] = $data['coupon'];
                    }
                    break;
                case 8:
                    if(empty($data['user'])){
                       $this->error("用户名不能为空"); 
                    }else{
                        $data['jump'] = $data['user'];
                    }
                    break;
            }
            if(empty($data['dress_id'])){
                $data['create_time'] = date("Y-m-d H:i:s",time());
                $result = $this->add($data);
                $sort = $result;
                $this->where(array('dress_id'=>$result))->save(['sort' => $sort]);
                $action = '新增';
            }else{
                $data['update_time'] = date("Y-m-d H:i:s",time());
                $where['dress_id'] = $data['dress_id'];
                $result = $this->where($where)->save($data);
                $action = '编辑';
            }
        }

        
        $url = session('url');
        // if ($result) {
        //     return success(['info' => $action . '模块操作成功', 'url' => $url]);
        // } else {
        //     return error($action . '模块操作失败');
        // }

        if ($result) {
            $a['msg'] =  $action .'商品操作成功';
            $a['status'] = 'success';
            return $a;
        } else {
            $a['msg'] = $action .'商品操作失败';
            $a['status'] = 'error';
            return $a;
        }
    }

    public function edit_nature($data,$scene=''){
        $rules = array(
             array('title','require','标题名称不能为空'),
             array('img','require','必须上传图片'),
             array('type','require','请选择跳转类型'),
             array('layout','require','请选择下行布局长度'),

        );

        $User = M("shop_dress"); // 实例化User对象
        if (!$User->validate($rules)->create()){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            // $this->error($User->getError());
            $a['msg'] = $User->getError();
            $a['status'] = 'error';
            return $a;
        }else{
            $data['img'] = domain($data['img']);
            $array = getimagesize($data['img']);
            $data['width'] = $array[0];
            $data['height'] = $array[1];
            switch ($data['type']){
                case 1:
                    break;
                case 2:
                    if(empty($data['url'])){
                        $this->error("请填写跳转链接");
                    }else{
                        $data['jump'] = $data['url'];
                    }
                    break;
                case 3:
                    if(empty($data['class_uuid'])){
                        $this->error("请选择分类");
                    }else{
                        $data['jump'] = $data['class_uuid'];
                    }
                    break;
                case 4:
                    if(empty($data['merchant'])){
                        $this->error("商家不能为空");
                    }else{
                        $data['jump'] = $data['merchant'];
                    }
                    break;
                case 5:
                    if(empty($data['goods'])){
                        $this->error("商品不能为空");
                    }else{
                        $data['jump'] = $data['goods'];
                    }
                    break;
                case 6:
                    if(empty($data['coupon'])){
                        $this->error("优惠券不能为空");
                    }else{
                        $data['jump'] = $data['coupon'];
                    }
                    break;
                case 8:
                    if(empty($data['user'])){
                       $this->error("用户名不能为空"); 
                    }else{
                        $data['jump'] = $data['user'];
                    }
                    break;
            }
            if(empty($data['dress_id'])){
                $data['create_time'] = date("Y-m-d H:i:s",time());
                $result = $this->add($data);
                $sort = $result;
                $this->where(array('dress_id'=>$result))->save(['sort' => $sort]);
                $action = '新增';
            }else{
                $data['update_time'] = date("Y-m-d H:i:s",time());
                $where['dress_id'] = $data['dress_id'];
                $result = $this->where($where)->save($data);
                $action = '编辑';
            }
        }
        
        $url = session('url');
        // if ($result) {
        //     return success(['info' => $action . '属性操作成功', 'url' => $url]);
        // } else {
        //     return error($action . '属性操作失败');
        // }
        if ($result) {
            $a['msg'] =  $action .'商品操作成功';
            $a['status'] = 'success';
            return $a;
        } else {
            $a['msg'] = $action .'商品操作失败';
            $a['status'] = 'error';
            return $a;
        }
    }

    /**
     * 软删除
     */
    public function soft_del($id){
        $data = [
            'is_delete'        => '1'
        ];
        $result = $this->where(array('dress_id'=>['in',$id]))->save($data);
        return $result;
    }

    /**
     * 真实删除
     */
    public function del($id){
        $result = $this->where(['dress_id'=>['in',$id]])->delete();
        return $result;
    }

    /**
     *恢复数据
     */
    public function restore($id){
        $data = [
            'is_delete'        => '0',
        ];
        $result = $this->where(array('dress_id'=>['in',$id]))->save($data);
        return $result;
    }

    /**
     *修改状态
     */
    public function change_status($id){
        $status = $this->where(['dress_id'=>$id])->getField('status');
        if(!$status)     return false;
        $abs = 3 - $status;
        //$arr = ['默认状态','开启状态'];
        $result = $this->where(array('dress_id'=>$id))->save(['status'=>$abs]);
        if($result){
            return $abs;
        }else{
            return false;
        }
    }
}