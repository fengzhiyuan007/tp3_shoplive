<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/10/23
 * Time: 上午10:49
 */

namespace Admin\Model;
use Think\Model;
use Think\Upload;
class GoodsModel extends MyModel
{   
    protected $tableName="shop_goods";
    //只读字段
    protected $readonly = ['goods_id','goods_uuid','merchants_id'];

    protected $pk = 'goods_id';   //设置主键
    public function edit($data,$scene='')
    {
        // $str = 'http://msplay.qqyswh.com/';
        $str = 'http://dspxplay.tstmobile.com/';
        if((strpos($data['url'],$str) ===false) && !empty($data['url'])){
            $data['url'] = $str.$data['url'];
        }
        $goods_img = $data['goods_img'];
        $data['goods_img'] = domain($data['goods_img']);
        $data['video_img'] ? domain($data['video_img']) : '';
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
        foreach ($data['goods_tag'] as $v) {
            if (!empty($v)) {
                $tag[] = $v;
            }
        }
        //file_put_contents('1.txt',json_encode($data['goods_nature_name']));
        !empty($tag) && $data['goods_tag'] = serialize($tag);
        foreach ($data['goods_nature_name'] as $k => $v) {
            if (!empty($v) && !empty($data['goods_nature_value'][$k])) {
                $nature[$k]['name'] = $v;
                $nature[$k]['value'] = $data['goods_nature_value'][$k];
            }
        }
        !empty($nature) && $data['goods_nature'] = serialize($nature);
        if (empty($data['goods_id'])) {
            $data['create_time'] = date("Y-m-d H:i:s", time());
            $action = '新增';

            $data['goods_img'] = domain($goods_img).'?imageView2/1/w/500/h/500';

            $result = $this->add($data);

            $url = $this->domain_url.'/mall_live/#/goodsDetails?goods_id='.$this->goods_id;

            
            // $qrcode_path = "/qrcode/" . time() . rand(100, 999) . '_qrcode.png';
            // $obj = new \Think\Upload();// 实例化上传类
            // $goods_img = $obj->save_thumb($goods_img,500);
            // if($goods_img)      $data['goods_img'] = domain($goods_img);
            // $path = qrcodeLogo($url,$data['goods_img'],'./'.$qrcode_path,8,9);
            $sort = $this->goods_id;

            $goods_stock = 0;
            if (!empty($data['specification_names'])) {    //规格
                foreach ($data['specification_names'] as $k => $v) {
                    if(!empty($data['specification_img'][$k])){
                        if($data['specification_img'][$k] !='/'){
                            $data['specification_img'][$k] = domain($data['specification_img'][$k]);
                        }else{
                            $data['specification_img'][$k] = $data['goods_img'];
                        }
                    }else{
                        $data['specification_img'][$k] = $data['goods_img'];
                    }
                    $specification[] = [
                        'goods_id' => $this->goods_id,
                        'specification_ids' => $data['specification_ids'][$k],
                        'specification_names' => $v,
                        'specification_sales' => $data['specification_sales'][$k],
                        'specification_stock' => $data['specification_stock'][$k],
                        'specification_img' => $data['specification_img'][$k],
                        'specification_price' => $data['specification_price'][$k],
                        'specification_cost_price' => $data['specification_cost_price'][$k],
                        'specification_sale_price' => $data['specification_sale_price'][$k],
                        'sale_ratio' => $data['specification_sale_ratio'][$k],
                        'create_time' => $data['create_time'],
                    ];
                    $goods_stock +=$data['specification_stock'][$k];
                }
                M('shop_goods_relation_specification')->addAll($specification);//批量添加规划
            }else{
                $goods_stock = $data['goods_stock'];
            }

            $this->where(['goods_id' => $this->goods_id])->save(['sort' => $sort,'goods_qrcode'=>domain($path),'goods_stock'=>$goods_stock]);
        } else {
            $data['update_time'] = date("Y-m-d H:i:s", time());
            $action = '编辑';
            $where['goods_id'] = $data['goods_id'];
            $check = $this->queryGoods(['goods_id'=>$data['goods_id']]);

            if($data['goods_img'] != $check['goods_img']){
                $url = $this->domain_url.'/mall_live/#/goodsDetails?goods_id='.$data['goods_id'];
                // $qrcode_path = "/qrcode/" . time() . rand(100, 999) . '_qrcode.png';
                // $obj = new \Think\Upload();// 实例化上传类
                // $goods_img = $obj->save_thumb($goods_img,500);
                
                // if($goods_img)      $data['goods_img'] = domain($goods_img);
                // $path = qrcodeLogo($url,$data['goods_img'],'./'.$qrcode_path,8,9);
                // $data['goods_qrcode'] = domain($path);
                $data['goods_img'] = domain($goods_img).'?imageView2/1/w/500/h/500';
                
            }

            M('shop_goods_relation_specification')->where(['goods_id' => $data['goods_id']])->save(['is_delete' => '1']);
//            Db::name('goods_relation_class')->where(['goods_id' => $data['goods_id']])->update(['is_delete' => '1']);
            
            $goods_stock = 0;
            if (!empty($data['specification_names'])) {   //规格
                $specification_ids = M('shop_goods_relation_specification')->where(['goods_id' => $data['goods_id']])->getField('specification_id,specification_ids');
//                foreach ($specification_ids as $v){
//                    $ids[] = sort(explode(',',$v));
//                }
                // echo M('shop_goods_relation_specification')->getLastSql();
                // print_r($specification_ids);exit;

                foreach ($data['specification_names'] as $k => $v) {
                    if(!empty($data['specification_img'][$k])){
                        if($data['specification_img'][$k] !='/'){
                            $data['specification_img'][$k] = domain($data['specification_img'][$k]);
                        }else{
                            $data['specification_img'][$k] = $data['goods_img'];
                        }
                    }else{
                        $data['specification_img'][$k] = $data['goods_img'];
                    }
                    if (!in_array($data['specification_ids'][$k], $specification_ids)) {

                        $specification[] = [
                            'goods_id' => $data['goods_id'],
                            'specification_ids' => $data['specification_ids'][$k],
                            'specification_names' => $v,
                            //'specification_sales' => $data['specification_sales'][$k],
                            'specification_stock' => $data['specification_stock'][$k],
                            'specification_img' => $data['specification_img'][$k],
                            'specification_price' => $data['specification_price'][$k],
                            'specification_cost_price' => $data['specification_cost_price'][$k],
                            'specification_sale_price' => $data['specification_sale_price'][$k],
                            'sale_ratio' => $data['specification_sale_ratio'][$k],
                            'create_time' => $data['update_time'],
                        ];

                    } else {
                        $specification_update[] = [
                            'specification_id' => array_search($data['specification_ids'][$k], $specification_ids),
                            'specification_names' => $v,
                            //'specification_sales' => $data['specification_sales'][$k],
                            'specification_stock' => $data['specification_stock'][$k],
                            'specification_img' => $data['specification_img'][$k],
                            'specification_price' => $data['specification_price'][$k],
                            'specification_cost_price' => $data['specification_cost_price'][$k],
                            'specification_sale_price' => $data['specification_sale_price'][$k],
                            'sale_ratio' => $data['specification_sale_ratio'][$k],
                            'update_time' => $data['update_time'],
                            'is_delete' => '0',
                        ];
                    }
                    $goods_stock +=$data['specification_stock'][$k];
                }
                
                if (!empty($specification)) {
                    foreach ($specification as $k => &$v) {
                        M('shop_goods_relation_specification')->add($v);
                    }
                    // M('shop_goods_relation_specification')->addAll($specification);
                    // echo M('shop_goods_relation_specification')->getLastSql();exit;
                }

                if (!empty($specification_update)) {
                    $model = D('GoodsRelationSpecification');
                    foreach ($specification_update as $k => &$v) {
                       $result = $model->updateAllSpecification($v);
                    }
                    
                }
            }else{
                $goods_stock = $data['goods_stock'];
            }

            $data['goods_stock'] = $goods_stock;
            $result = $this->where($where)->save($data);

        }
        $url = session('url');
        if ($result) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function queryGoods($where){
        $goods = $this->where($where)->find();
        return $goods;
    }

    /**
     *删除
     */
    public function soft_del($where){
        $result = $this->where($where)->save(['is_delete'=>'1']);
        if($result){
            $url = session('url');
            return success(['info'=>'删除'.'商品操作成功','url'=>$url]);
        }else{
            error("删除商品操作失败");
        }
    }

    /**
     *删除
     */
    public function recovery_del($where){
        $result = $this->where($where)->save(['is_delete'=>'0']);
        if($result){
            $url = session('url');
            return success(['info'=>'恢复'.'商品操作成功','url'=>$url]);
        }else{
            error("恢复商品操作失败");
        }
    }

    /**
     *删除
     */
    public function del($where){
        $result = $this->where($where)->delete();
        if($result){
            $url = session('url');
            return success(['info'=>'删除'.'商品操作成功','url'=>$url]);
        }else{
            error("删除商品操作失败");
        }
    }

    /**
     *查询
     */
    public function queryByCode($where){
        $result = $this->where($where)->find();
        return $result;
    }
}