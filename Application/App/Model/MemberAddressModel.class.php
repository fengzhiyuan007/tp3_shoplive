<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/10/11
 * Time: 上午9:26
 */
namespace App\Model;
use Think\Model;
class MemberAddressModel extends MyModel
{
    protected $tableName="shop_member_address";
    //只读字段
    protected $readonly = ['address_id','member_id'];

    protected $pk = 'address_id';   //设置主键

    protected $_validate = array(
            array('member_id','require','用户ID必须填写'), 
            array('address_name','require','收货人名字必须填写'), 
            array('address_mobile','require','联系方式必须填写'), 
            array('address_province','require','省份必须填写'), 
            array('address_city','require','城市不能为空'), 
            array('address_country','require','区县不能为空'), 
            array('address_detailed','require','收货详细地址必须填写'),
    );

    public function edit_address($data){

        $member_address = D("MemberAddress"); // 实例化User对象
        if (!$member_address->create()){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
             error($member_address->getError());
        }else{
             // 验证通过 可以进行其他数据操作
            $model = new MemberAddressModel();
            $address = $data['address_province'].$data['address_city'].$data['address_country'].$data['address_detailed'];
            if(empty($data['address_id'])){
                $data['create_time'] = date("Y-m-d H:i:s",time());
                $position = $this->getLonLat($address);// 获取地址经纬度
                if($position[0]) {
                    $data['address_longitude'] = $position[0];
                    $data['address_latitude'] = $position[1];
                }
                $action = '新增';
                $check = $this->where(['member_id'=>$data['member_id'],'is_default'=>'1','is_delete'=>'0'])->find();//查询是否存在默认地址
                if(!$check){
                    $data['is_default'] = 1;
                }
                $result = $model->add($data);
                $address_id = $model->address_id;
            }else{
                $check = $this->queryAddressByID(['address_id'=>$data['address_id']]);
                $address2 = $check['address_province'].$check['address_city'].$check['address_country'].$check['address_detailed'];
                if($address != $address2){
                    $position = $this->getLonLat($address);// 获取地址经纬度
                    if($position[0]) {
                        $data['address_longitude'] = $position[0];
                        $data['address_latitude'] = $position[1];
                    }
                }
                $data['update_time'] = date("Y-m-d H:i:s",time());
                $where = [
                    'address_id'    =>  $data['address_id']
                ];
                $result = $model->where($where)->save($data);
                $address_id = $check['address_id'];
                $action = '编辑';
            }
            if($result){
                if($data['is_default'] == '1'){
                    $model->where(['member_id'=>$data['member_id'],'address_id'=>['neq',$address_id],'is_delete'=>'0'])->save(['is_default'=>'0']);
                }
                return success($action.'收货地址成功');
            }else{
                return error($action.'收货地址失败');
            }
        }


    }


    //根据条件查询单条记录
    public function queryAddressByID($where=[]){
        $address = $this->where($where)->find();
        return $address;
    }

    //根据查询记录总数
    public function queryAddressCount($where=[]){
        $count = $this->where($where)->count();
        return $count;
    }

    //根据相关条件查询并分页
    public function queryMember($where = []){
        $list = $this->where($where)
                ->order("is_default desc,create_time desc")->select();
        return $list;
    }

    /**
     * 软删除
     */
    public function soft_del($where){
        $data = [
            'is_delete'        => '1',
        ];
        $result = $this->where($where)->save($data);
        $check = $this->where($where)->find();
        if($result && $check['is_default'] == '1'){
            $last = $this->where(['member_id'=>$where['member_id'],'is_delete'=>'0'])->limit(1)->order("address_id desc")->find();
            if($last){
                $this->where(['address_id'=>$last['address_id']])->save(['is_default'=>'1']);
            }
        }
        return $result;
    }

    /**
     * 真实删除
     */
    public function del($id){
        $result = $this->where(['address_id'=>$id])->delete();
        return $result;
    }

    /**
     * 默认操作
     */
    public function defaultAddress($address_id,$member_id){
        $result = $this->where(['address_id'=>$address_id,'member_id'=>$member_id])->save(['is_default'=>'1']);
        if(!$result)    return false;
        $this->where(['address_id'=>['neq',$address_id],'member_id'=>$member_id,'is_delete'=>'0'])->save(['is_default'=>'0']);
        return true;
    }

}