<?php
namespace Admin\Model;
use Think\Model;
class HomeClassModel extends MyModel
{
    protected $tableName="shop_home_class";
    //只读字段
    protected $readonly = ['id'];
    protected $pk = 'id';   //设置主键

    public function edit($data,$scene=''){
        $rules = array(
             array('title','require','标题名称不能为空'),
             array('img','require','必须上传图片'),
        );

        $User = M("shop_home_class"); // 实例化User对象
        if (!$User->validate($rules)->create()){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            // exit($User->getError());
            $a['msg'] = $User->getError();
            $a['status'] = 'error';
            return $a;
        }else{
             // 验证通过 可以进行其他数据操作
            switch ($data['type']){
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
            $data['img'] = domain($data['img']);
            if(empty($data['id'])){
                $data['create_time'] = date("Y-m-d H:i:s",time());
                $result = $this->add($data);
                $sort = $result;
                $this->where(['id' => $result])->save(['sort' => $sort]);
                $action = '新增';
            }else{
                $data['update_time'] = date("Y-m-d H:i:s",time());
                $where['id'] = $data['id'];
                $result = $this->where($where)->save($data);
                $action = '编辑';
            }
        }

        
        $url = session('url');
        
        // if ($result) {
        //     return success(['info' => $action . '首页分类操作成功', 'url' => $url]);
        // } else {
        //     return error($action . '首页分类操作失败');
        // }
        if ($result) {
            $a['msg'] =  $action .'首页分类操作成功';
            $a['status'] = 'success';
            return $a;
        } else {
            $a['msg'] = $action .'首页分类操作失败';
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
        $result = $this->where(['id'=>['in',$id]])->save($data);
        return $result;
    }

    /**
     * 真实删除
     */
    public function del($id){
        $result = $this->where(['id'=>['in',$id]])->delete();
        return $result;
    }

    /**
     *恢复数据
     */
    public function restore($id){
        $data = [
            'is_delete'        => '0',
            'delete_time'   => date("Y-m-d H:i:s")
        ];
        $result = $this->where(['dress_id'=>['in',$id]])->save($data);
        return $result;
    }

    /**
     *修改状态
     */
    public function change_status($id){
        $status = $this->where(['id'=>$id])->getField('status');
        if(!$status)     return false;
        $abs = 3 - $status;
        //$arr = ['默认状态','开启状态'];
        $result = $this->where(['id'=>$id])->save(['status'=>$abs]);
        if($result){
            return $abs;
        }else{
            return false;
        }
    }
}