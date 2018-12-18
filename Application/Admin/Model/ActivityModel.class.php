<?php

namespace Admin\Model;
use Think\Model;
class ActivityModel extends MyModel
{
    protected $tableName="activity";
    //只读字段
    protected $readonly = ['a_id'];

    protected $pk = 'a_id';   //设置主键
    public function edit($data){

        $rules = array(
             array('title','require','名称必须填写'), 
             // array('img','require','视频封面图片必须存在'), 
             // array('url','require','视频必须上传'), 
    
        );

        $User = M("activity"); // 实例化User对象
        if (!$User->validate($rules)->create()){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            $a['msg'] = $User->getError();
            $a['status'] = 'error';
            return $a;
        }else{
            $str = 'http://dspxplay.tstmobile.com/';
            $strs = 'http://msplay.qqyswh.com/';
            $strss = 'http://play.100ytv.com';

            if(strpos($data['url'],$str) ===false && !empty($data['url']) && strpos($data['url'],$strs) ===false && strpos($data['url'],$strss) ===false){
                $data['url'] = $str.$data['url'];
            }
            $data['img'] = domain($data['img']);

            if(!is_array($data['imgs'])){
                $data['imgs'] = explode(',',$data['imgs']);
            }
            foreach ($data['imgs'] as $v) {
                if (!empty($v)) {
                    $img[] = domain($v);
                } else {
                    $img[] = '';
                }
            }
            $data['imgs'] = join(',', $img);

            if(empty($data['a_id'])){
                $data['intime'] = time();
                $result = $this->add($data);

                /****************************************百台云*************************************/
                    //添加直播商品
                    if($data['goods_id']){
                        $create_time = date("Y-m-d H:i:s",time());
                        $goods_id = explode(',',$data['goods_id']);
                        foreach ($goods_id as $v){
                            $merchants_id = M("shop_goods")->where(["goods_id"=>$v])->getField('merchants_id');
                            $live_goods = [
                                'goods_id' => $v,
                                'member_id' =>  $data['user_id'],
                                'create_time'=> $create_time,
                                'merchants_id'=> $merchants_id,
                                'a_id'=>$result
                            ];
                            M('shop_live_goods')->add($live_goods);
                        }
                    }

                /****************************************百台云*************************************/

                $action = '新增';
            }else{
                $data['intime'] = time();
                $result = $this->where(array('a_id'=>$data['a_id']))->save($data);

                /****************************************百台云*************************************/
                    //添加直播商品
                    if($data['goods_id']){
                        //删除原有活动商品  
                        M('shop_live_goods')->where(array('a_id'=>$data['a_id']))->delete();

                        $create_time = date("Y-m-d H:i:s",time());
                        $goods_id = explode(',',$data['goods_id']);
                        foreach ($goods_id as $v){
                            $merchants_id = M("shop_goods")->where(["goods_id"=>$v])->getField('merchants_id');
                            $live_goods = [
                                'goods_id' => $v,
                                'member_id' =>  $data['user_id'],
                                'create_time'=> $create_time,
                                'merchants_id'=> $merchants_id,
                                'a_id'=>$data['a_id']
                            ];
                            M('shop_live_goods')->add($live_goods);
                        }
                    }

                /****************************************百台云*************************************/

                $action = '编辑';
            }
            if ($result) {
                $a['msg'] = '活动操作成功';
                $a['status'] = 'success';
                return $a;
            } else {
                $a['msg'] = '活动操作失败';
                $a['status'] = 'error';
                return $a;
            }
        }

    }
}