<?php
namespace App\Model;
use Think\Model;
class MerchantsModel extends MyModel
{
	protected $tableName="shop_merchants";

    protected $readonly = ['merchants_id','member_id'];

    protected $pk = 'merchants_id';   //设置主键

    public function edit_merchants($param){
    	$sys = M('system')->where(array('id'=>1))->field('merchants_per,goods_per')->find();
    	$param['merchants_per'] = $sys['merchants_per'];
    	$param['goods_per'] = $sys['goods_per'];

        $result = $this->add($param);
        return $result;
    }
    

	
}
