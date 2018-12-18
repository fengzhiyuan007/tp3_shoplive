<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/11/7
 * Time: 下午6:00
 */

namespace App\Model;
use Think\Model;
class OrderRefundModel extends MyModel
{
    protected $tableName="shop_order_refund";
    //只读字段
    protected $readonly = ['refund_id','member_id','order_merchants_id'];

    protected $pk = 'refund_id';   //设置主键

    public function edit($data){
        if(empty($data['refund_id'])){
            $data['refund_state'] = 'wait_review';
            $data['create_time'] = date("Y-m-d H:i:s",time());
            $result = $this->add($data);
        }
        return $result;
    }
}