<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/11/6
 * Time: 下午5:51
 */
namespace Admin\Model;
use Think\Model;
class GoodsSpecificationModel extends MyModel
{   
    protected $tableName="shop_goods_specification";
    //只读字段
    protected $readonly = ['specification_id','parent_id','merchants_id'];

    protected $pk = 'specification_id';   //设置主键

    public function edit($data,$scene=''){
        $rules = array(
             array('specification_value','require','请填写名称'), 
             array('specification_desc','require','请填写简介'), 
             
    
        );

        $User = M("shop_goods_specification"); // 实例化User对象
        if (!$User->validate($rules)->create()){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            $a['msg'] = $User->getError();
            $a['status'] = 'error';
            return $a;
        }else{
            if(empty($data['specification_id'])){
                $data['create_time'] = date("Y-m-d H:i:s",time());
                $result = $this->add($data);
                $sort = $result;
                $this->where(array('specification_id'=>$result))->save(['sort' => $sort]);
                $action = '新增';
            }else{
                $data['update_time'] = date("Y-m-d H:i:s",time());
                $where['specification_id'] = $data['specification_id'];
                $result = $this->where($where)->save($data);
                $action = '编辑';
            }
            $url = session('url');;
            // if ($result) {
            //     // return success(['info' => $action . '规格操作成功', 'url' => $url]);
            //     return 'success';
            // } else {
            //     // return error($action . '规格操作失败');
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
     * 软删除
     */
    public function soft_del($where){
        $data = [
            'is_delete'        => '1'
        ];
        $result = $this->where($where)->save($data);
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
        $result = $this->where(['specification_id'=>['in',$id]])->delete();
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
            'is_delete'        => '0',
        ];
        $result = $this->where(['specification_id'=>['in',$id]])->save($data);
        if($result){
            return 'success';
        }else{
            return 'error';
        }
    }

}