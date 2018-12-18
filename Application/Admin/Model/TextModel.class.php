<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/11/3
 * Time: 上午11:31
 */

namespace Admin\Model;
use Think\Model;
class TextModel extends MyModel
{   
    protected $tableName="shop_text";
    
    protected $pk = 'text_id';
    //只读字段
    protected $readonly = ['text_id'];
    public function edit($data){
        $rules = array(
             array('type','require','请选择轮播轮播图使用场景'),
             array('content','require','内容不能为空')

        );
        $User = M("shop_text"); // 实例化User对象
        if (!$User->validate($rules)->create()){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            $a['msg'] = $User->getError();
            $a['status'] = 'error';
            return $a;
        }else{ 
            if(empty($data['text_id'])){
                $data['create_time'] = date("Y-m-d h:i:s",time());
                $action = '新增';
                $result = $this->add($data);
            }else{
                $data['update_time'] = date("Y-m-d h:i:s",time());
                $action = '编辑';
                $result = $this->where(['text_id'=>$data['text_id']])->save($data);
            }
            $url = Session('url');
        }

        
        
        if($result){
            $a['msg'] = $action.'图文信息成功';
            $a['status'] = 'success';
            return $a;
        }else{
            $a['msg'] = $action.'图文信息失败';
            $a['status'] = 'error';
            return $a;
        }
    }

    /**
     * 软删除
     */
    public function soft_del($id){
        $data = [
            'is_delete'        => '1',
        ];
        $result = $this->where(['text_id'=>['in',$id]])->save($data);
        if($result){
            return 'success';
        }else{
            return 'error';
        }
    }
}