<?php 
namespace App\Controller;
/**
 * 用于省市区三级联运action
 * @author yyb
 *
 */
class AddressController extends CommonController{
	
	/**
	 * 通过省id获取市列表,并返回ajax数据
	 */
	function getCityByProvince(){
		$C = D("City");
		$where["pid"]=I("pid",0);
		$where["status"]=1;
		$city = $C->where($where)->select();
		if($city){
			$this->ajaxReturn(array("sta"=>1,"data"=>$city));
		}else{
			$this->ajaxReturn(array("sta"=>2,"msg"=>"城市列表获取失败,请稍候重试"));
		}
	}
	/**
	 * 通过省id获取市列表,并返回ajax数据
	 */
	function getAreaByCity(){
		$C = D("Area");
		$where["pid"]=I("pid",0);
		$where["status"]=1;
		$area = $C->where($where)->select();
		if($area){
			$this->ajaxReturn(array("sta"=>1,"data"=>$area));
		}else{
			$this->ajaxReturn(array("sta"=>2,"msg"=>"区县列表获取失败,请稍候重试"));
		}
	}

	/**
     *增加收获地址
     */
    public function insertAddress(){
        if (IS_POST) {
            $member = checklogin();
            $data = I('post.');
            $model = D('MemberAddress');
            $data['member_id'] = $member['user_id'];
            $result = $model->edit_address($data);
            return $result;
        }
    }

    /**
     *编辑收货地址
     */
    public function saveAddress(){
        if (IS_POST) {
            $member = checklogin();
            $data = I('post.');
            if(empty($data['address_id']))    error("编辑地址错误");
            $where = [
                'address_id'    =>  $data['address_id'],
                'member_id'     =>  $member['user_id']
            ];
            $model = D('MemberAddress');
            $check = $model->queryAddressByID($where);
            if(!$check)                      error("编辑地址错误");
            $data['member_id'] = $member['user_id'];
            $result = $model->edit_address($data);
            return $result;
        }
    }

    /**
     *地址列表
     */
    public function queryAddressList(){
        if (IS_POST) {
            $member = checklogin();
//            $p = input('p');
//            $p ? $p  :  $p = 1;
//            $pagesize = input('pagesize');
//            $pagesize  ?    $pagesize   :   $pagesize = 10;
            $model = D('MemberAddress');
            $where = [
                'member_id' =>  $member['user_id'],
                'is_delete' =>  '0'
            ];
//            $count = $model->queryAddressCount($where);
//            $page = ceil($count/$pagesize);
            $list = $model->queryMember($where);
            success($list);
        }
    }

    /**
     *地址查询单条
     */
    public function queryAddress(){
        if (IS_POST) {
            $member = checklogin();
            $address_id = I('address_id');
            if(!$address_id)        error("地址id错误");
            $where = [
                'member_id' =>  $member['user_id'],
                'address_id' => $address_id,
            ];
            $model = D('MemberAddress');
            $address = $model->queryAddressByID($where);
            if($address){
                success($address);
            }else{
                error("地址id错误");
            }
        }
    }

    /**
     *地址默认操作
     */
    public function saveDefaultAddress(){
        if (IS_POST) {
            $member = checklogin();
            $address_id = I('address_id');
            if(!$address_id)        error("地址id错误");
            $model = D('MemberAddress');
            $address = $model->defaultAddress($address_id,$member['user_id']);
            if($address){
                success("地址默认操作成功");
            }else{
                error("地址默认操作失败");
            }
        }
    }


    /**
     *删除地址
     */
    public function delAddress(){
        if (IS_POST) {
            $member = checklogin();
            $address_id = I('address_id');
            if(!$address_id)        error("地址id错误");
            $where = [
                'member_id' =>  $member['user_id'],
                'address_id' =>  $address_id
            ];
            $model = D('MemberAddress');
            $address = $model->soft_del($where);
            if($address){
                success("地址删除成功");
            }else{
                error("地址删除失败");
            }
        }
    }

    /**
     *查询默认地址
     */
    public function queryDefaultAddress(){
        if (IS_POST) {
            $member = checklogin();
            $where = [
                'member_id'     =>  $member['user_id'],
                'is_delete'     =>  '0',
                'is_default'    =>  '1'
            ];
            $model = D('MemberAddress');
            $address = $model->queryAddressByID($where);
            if($address){
                success($address);
            }else{
                success((object)null);
            }
        }
    }


}
	