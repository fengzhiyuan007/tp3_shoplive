<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/10/31
 * Time: 下午4:14
 */

namespace Merchant\Model;
use Think\Model;
class MerchantsModel extends MyModel
{
    protected $tableName="shop_merchants";
    //只读字段
    protected $readonly = ['merchants_id','member_id'];

    protected $pk = 'merchants_id';   //设置主键

    public function check($data){
        $rules = array(
             array('merchants_name','require','店铺名称必须填写'), 
             array('contact_name','require','联系人必须填写'), 
             array('contact_mobile','require','联系方式必须填写'), 
             array('company_name','require','公司名称必须填写'), 
             array('company_mobile','require','公司电话必须填写'), 
             array('merchants_province','require','省份必须选择'), 
             array('merchants_city','require','城市必须选择'), 
             array('merchants_country','require','区域必须选择'), 
             array('merchants_address','require','详细地址必须填写'), 
             array('merchants_img','require','商家图片必须填写'), 
             array('legal_img','require','法人照片必须上传'), 
             array('legal_face_img','require','法人身份证正面照必须上传'), 
             array('legal_opposite_img','require','法人身份证反面照必须上传'), 
             array('legal_hand_img','require','法人身份证手持照必须上传'), 
             array('business_img','require','请上传三证合一营业执照'), 
             array('merchants_content','require','店铺简介必须填写'), 
             // array('goods_class','require','店铺经营分类必须填写')
    
        );

        $User = M("shop_merchants"); // 实例化User对象
        if (!$User->validate($rules)->create()){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            $a['msg'] = $User->getError();
            $a['status'] = 'error';
            return $a;
        }else{
             // 验证通过 可以进行其他数据操作

            $data['apply_state'] = '1';
            $data['merchants_img'] = $this->domain($data['merchants_img']);
            $data['legal_img'] = $this->domain($data['legal_img']);
            $data['legal_face_img'] = $this->domain($data['legal_face_img']);
            $data['legal_opposite_img'] = $this->domain($data['legal_opposite_img']);
            $data['legal_hand_img'] = $this->domain($data['legal_hand_img']);
            $data['business_img'] = $this->domain($data['business_img']);
            $result = $this->where(array('merchants_id'=>$data['merchants_id']))->save($data);
            if($result !==false){
                $member = $this->where(array('merchants_id'=>$data['merchants_id']))->find();
                M('user')->where(['user_id'=>$member['member_id']])->save(['type'=>1]);
                $class_id = join(',',$data['goods_class']);
                $check = M('shop_goods_merchants_class')->where(['member_id'=>$member['member_id']])->find();
                if($check){
                    M('shop_goods_merchants_class')->where(['member_id'=>$member['member_id']])->save(['class_id'=>$class_id]);
                }else{
                    $merchants_class['class_id'] = $class_id;
                    $merchants_class['member_id'] = $member['member_id'];
                    $merchants_class['intime'] = date("Y-m-d H:i:s",time());
                    M('shop_goods_merchants_class')->add($merchants_class);
                }
                $a['msg'] = '编辑成功';
                $a['status'] = 'success';
                return $a;
            }else{
                $a['msg'] = '编辑失败';
                $a['status'] = 'error';
                return $a;
            }

        }
    }
}