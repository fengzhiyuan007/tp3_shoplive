<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/10/27
 * Time: 下午3:22
 */

namespace Merchant\Model;


class GoodsRelationSpecificationModel extends MyModel
{
    protected $tableName="shop_goods_relation_specification";

    protected $pk = 'specification_id';   //设置主键
    
    public function updateAllSpecification($data){

        $result = $this->save($data);
        return $result;
    }
}