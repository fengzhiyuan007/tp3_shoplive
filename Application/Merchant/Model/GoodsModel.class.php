<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/10/23
 * Time: 上午10:49
 */

namespace Merchant\Model;
use Think\Model;
use Think\Upload;
class GoodsModel extends MyModel
{
    protected $tableName="shop_goods";
    //只读字段
    protected $readonly = ['goods_id','goods_uuid'];

    protected $pk = 'goods_id';   //设置主键
    public function edit($data,$scene='')
    {
        // print_r($data);exit;
        $rules = array(
             array('merchants_id','require','商家信息必须填写'), 
             // array('goods_uuid','require','商家信息必须填写'),
             // array('goods_uuid','','商品uuid必须唯一',0,'unique',1), 
             array('goods_name','require','商品名称必须填写'), 
             array('code','require','商品编码必须填写'),
             array('code','','商品编码已存在',0,'unique',1),
             array('parent_class','require','产品一级分类必须选择'),
             array('seed_class','require','产品二级分类必须选择'),
             array('goods_origin_price','require','商品原价必须填写'),
             array('goods_now_price','require','商品现价必须填写'),
             array('goods_stock','require','商品库存必须填写'),
             array('goods_desc','require','商品简介必须填写'),
             array('goods_img','require','商品图片必须上传'),
             // array('imgs','require','商品轮播图片必须上传'),
             array('goods_detail','require','商品图文信息必须填写'),
             // array('video_img','require','视频图片必须填写'),

        );

        $User = M("shop_goods"); // 实例化User对象
        if (!$User->validate($rules)->create()){
             // 如果创建失败 表示验证没有通过 输出错误提示信息
            $a['msg'] = $User->getError();
            $a['status'] = 'error';
            return $a;
        }else{
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


                $url = $this->domain_url.'/mall_live/#/goodsDetails?goods_id='.$result;
                // $qrcode_path = "/qrcode/" . time() . rand(100, 999) . '_qrcode.png';
                // $obj = new \Think\Upload();// 实例化上传类
                // $goods_img = $obj->save_thumb($goods_img,500);
                // if($goods_img)      $data['goods_img'] = domain($goods_img);
                // $path = qrcodeLogo($url,$data['goods_img'],'./'.$qrcode_path,8,9);
                $sort = $result;

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
                            'goods_id' => $result,
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
                    foreach ($specification as $k => &$v) {
                        M('shop_goods_relation_specification')->add($v);
                    }
                    // M('shop_goods_relation_specification')->addAll($specification);//批量添加规划
                }else{
                    $goods_stock = $data['goods_stock'];
                }

                // $this->where(['goods_id' => $result])->save(['sort' => $sort,'goods_qrcode'=>domain($path),'goods_stock'=>$goods_stock]);
                $this->where(['goods_id' => $result])->save(['sort' => $sort,'goods_stock'=>$goods_stock]);

            } else {
                $data['update_time'] = date("Y-m-d H:i:s", time());
                $action = '编辑';
                $check = $this->queryGoods(['goods_id'=>$data['goods_id']]);
                if($data['goods_img'] != $check['goods_img']){
                    $url = $this->domain_url.'/mall_live/#/goodsDetails?goods_id='.$data['goods_id'];
                    // $qrcode_path = "/qrcode/" . time() . rand(100, 999) . '_qrcode.png';
                    // $obj = new \Think\Upload();// 实例化上传类
                    // $goods_img = $obj->save_thumb($goods_img,500);

                    // if($goods_img)      $data['goods_img'] = $this->domain($goods_img);
                    // $path = qrcodeLogo($url,$data['goods_img'],'./'.$qrcode_path,8,9);
                    // $data['goods_qrcode'] = $this->domain($path);
                    $data['goods_img'] = domain($goods_img).'?imageView2/1/w/500/h/500';
                    
                }
                $where['goods_id'] = $data['goods_id'];
                M('shop_goods_relation_specification')->where(['goods_id' => $data['goods_id']])->save(['is_delete' => '1']);
                $goods_stock = 0;
                if (!empty($data['specification_names'])) {   //规格
                    $specification_ids = M('shop_goods_relation_specification')->where(['goods_id' => $data['goods_id']])->getField('specification_id,specification_ids');
                    file_put_contents('url.txt',json_encode($data['specification_img']),FILE_APPEND);
                    foreach ($data['specification_names'] as $k => $v) {
                        if(!empty($data['specification_img'][$k])){
                            if($data['specification_img'][$k] !='/'){
                                $data['specification_img'][$k] = $this->domain($data['specification_img'][$k]);
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
                        // Db::name('goods_relation_specification')->insertAll($specification);
                        foreach ($specification as $k => &$v) {
                            M('shop_goods_relation_specification')->add($v);
                        }
                    }
                    if (!empty($specification_update)) {
                        $model = D('GoodsRelationSpecification');
                        // $result = $model->updateAllSpecification($specification_update);
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
                $a['msg'] =  $action .'商品操作成功';
                $a['status'] = 'success';
                return $a;
                // return success(['info' => $action . '商品操作成功']);
            } else {
                $a['msg'] = $action .'商品操作失败';
                $a['status'] = 'error';
                return $a;
                // return error($action . '商品操作失败');
            }

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