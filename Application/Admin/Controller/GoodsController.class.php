<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/10/20
 * Time: 上午10:25
 */

namespace Admin\Controller;

use Think\Db;
use Psr\Log\Test\DummyTest;

use Org\Util\Date;
use Think\Upload;
use Think\Controller;
class GoodsController extends CommonController
{
    function _initialize() {
        header("Content-Type:text/html; charset=utf-8");
        $nums = ['5','10','15','20','25','30','50','100'];
        $this->assign('nums',$nums);
    }
    /**
     *@商品分类
     */
    public function index(){
        $map=[];
        $title = I('name');
        $title && $map['class_name'] = ['like','%'.$title.'%'];
        $map['parent_id'] = '-1';
        $map['is_delete'] = '0';
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M('shop_goods_class')->where($map)->count();
        $p = getpage($count,$nus);
        $list = M('shop_goods_class')
            ->where($map)
            ->order("sort desc")
            ->limit($p->firstRow.','.$p->listRows)
            ->select(); 
        $this->assign(['list'=>$list,'count'=>$count]);
        $this->assign("show",$p->show());
        $url =$_SERVER['REQUEST_URI'];
        session('url',$url);
        $this->assign ('pagetitle', '商品分类');
        $this->display();
    }

    /**
     *@删除
     */
    public function del_class(){
        $id = I('ids');
        if(empty($id))      error("参数错误");
        $model = D('GoodsClass');
        $map['class_id']    =   ['in',$id];
        $result = $model->del_class($map);
        echo json_encode($result);
    }


    /**
     *@改变分类状态
     */
    public function change_class_recommend(){
        if(IS_AJAX){
            $id = I('id');
            $status = M('shop_goods_class')->where(['class_id'=>$id])->getField('is_recommend');
            $abs = 1 - $status;
            $arr = ['0','1'];
            $result = M('shop_goods_class')->where(['class_id'=>$id])->save(['is_recommend'=>$abs]);
            if($result){
                return success($arr[1-$status]);
            }else{
                return error('切换状态失败');
            }
        }
    }

    /**
     *@改变分类状态
     */
    public function change_class_status(){
        if(IS_AJAX){
            $id = I('id');
            $status = M('shop_goods_class')->where(['class_id'=>$id])->getField('class_state');
            $abs = 1 - $status;
            $arr = ['0','1'];
            $result = M('shop_goods_class')->where(['class_id'=>$id])->save(['class_state'=>$abs]);
            // echo M('shop_goods_class')->getLastSql();exit;
            if($result){
                return success($arr[1-$status]);
            }else{
                return error('切换状态失败');
            }
        }
    }

    /**
     *@编辑商品一级分类
     */
    public function edit_parent_class(){
        if(IS_POST){
            $data = $_POST; // 获取所有的post变量（原始数组）
            if(empty($data['class_id'])){
                $data['class_uuid'] = get_guid();
            }
            $model = D('GoodsClass');
            $result = $model->edit_class($data,'edit');

            if($result['status'] == 'success'){
                $this->success($result['msg']);
            }else{
                $this->error($result['msg']);
            }

            // if($result == 'success'){
            //     $this->success('成功!',U('edit_parent_class',array('id'=>$data['class_id'])));
            // }else{
            //     $this->success('失败!',U('edit_parent_class',array('id'=>$data['class_id'])));
            // }
        }else{
            $id = I('id');
            $re = M('shop_goods_class')->where(['class_id'=>$id])->find();
            $re['class_color'] = explode('#',$re['class_color'])[1];
            $this->assign(['re'=>$re]);
            // $this->view->engine->layout(false);
            // return $this->fetch();
            $this->assign ('pagetitle', '编辑商品分类');
            $this->display();
        }
    }

    /**
     *@子分类
     */
    public function seed(){
        $map=[];
        $title = I('name');
        $title && $map['class_name'] = ['like','%'.$title.'%'];
        $uuid = I('uuid');
        $parent = M('shop_goods_class')->where(['class_uuid'=>$uuid])->find();
        $map['is_delete'] = '0';
        if(!empty($parent)){
            $map['parent_id'] = $parent['class_id'];
        }else{
            // $this->display();
        }
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M('shop_goods_class')->where($map)->count();
        $p = getpage($count,$nus);
        $data = M("shop_goods_class")
            ->where($map)
            ->order("sort desc")
            ->limit($p->firstRow.','.$p->listRows)
            ->select();
        // echo M("shop_goods_class")->getLastSql();exit;

        $first_category = M('shop_goods_class')->where(['parent_id'=>['eq','-1'],'is_delete'=>'0'])->select();
        $this->assign("show",$p->show());
        $this->assign(['list'=>$data,'first_category'=>$first_category,'count'=>$count,'parent'=>$parent]);
        $url =$_SERVER['REQUEST_URI'];
        session('url',$url);
        $this->assign ('pagetitle', '子集分类');
        $this->display();
    }

    /**
     *@编辑商品子分类分类
     */
    public function edit_seed_class(){
        if(IS_POST){
            $data = $_POST; // 获取所有的post变量（原始数组）
            // print_r($data);exit;
            if(empty($data['class_id'])){
                $data['class_uuid'] = get_guid();
            }
            $model = D('GoodsClass');
            $result = $model->edit_class($data,'edit');

            if($result['status'] == 'success'){
                $this->success($result['msg']);
            }else{
                $this->error($result['msg']);
            }

            // if($result == 'success'){
            //     $this->success('成功!',U('edit_seed_class',array('id'=>$data['class_id'])));
            // }else{
            //     $this->error('失败!',U('edit_seed_class',array('id'=>$data['class_id'])));
            // }
        }else{
            $id = I('id');
            $re = M('shop_goods_class')->where(['class_id'=>$id])->find();
            $re['class_color'] = explode('#',$re['class_color'])[1];
            $this->assign(['re'=>$re]);
            // $this->view->engine->layout(false);
            // return $this->fetch();
            $this->assign ('pagetitle', '编辑商品分类');
            $this->display();
        }
    }


    /**
     * @商品规格
     */
    public function specifications(){
        $map['parent_id'] = -1;
        $map['is_delete'] = 0;
        $title = I('name');
        $title && $map['specification_value'] = ['like','%'.$title.'%'];
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M('shop_goods_specification')->where($map)->count();
        $p = getpage($count,$nus);

        $list = M('shop_goods_specification')
                ->where($map)
                ->order("sort asc")
                ->limit($p->firstRow.','.$p->listRows)
                ->select();
        $this->assign("show",$p->show());
        $this->assign ('pagetitle', '规格设置');
        $this->assign(['list'=>$list,'count'=>$count]);
        $url =$_SERVER['REQUEST_URI'];
        session('url',$url);
        $this->display();
    }

    /**
     *@编辑规格属性
     */
    public function edit_specifications(){
        if(IS_POST){
            $data = $_POST; // 获取所有的post变量（原始数组）
            $model = D('GoodsSpecification');
            $result = $model->edit($data,'edit');

            if($result['status'] == 'success'){
                $this->success($result['msg']);
            }else{
                $this->error($result['msg']);
            }

            // if($result == 'success'){
            //     $this->success('成功!',U('edit_specifications',array('id'=>$data['specification_id'])));
            // }else{
            //     $this->error('失败!',U('edit_specifications',array('id'=>$data['specification_id'])));
            // }
        }else{
            $id = I('id');
            $re = M('shop_goods_specification')->where(['specification_id'=>$id,'is_delete'=>0])->find();
            $this->assign(['re'=>$re]);
            // $this->view->engine->layout(false);
            // return $this->fetch();
            $this->assign ('pagetitle', '编辑规格');
            $this->display();
        }
    }

    public function del_specifications(){
        if(IS_AJAX){
            $id = I('ids');
            if(empty($id))      error("参数错误");
            $model = D('GoodsSpecification');
            $map['specification_id']    =   ['in',$id];
            $result = $model->soft_del($map);
            echo json_encode($result);

        }
    }

    /**
     * @规格属性
     */
    public function seed_specifications(){
        $id = I('parent_id');
        $map['parent_id'] = $id;
        $map['is_delete'] = 0;
        $title = I('name');
        $title && $map['specification_value'] = ['like','%'.$title.'%'];
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M('shop_goods_specification')->where($map)->count();
        $p = getpage($count,$nus);

        $list = M('shop_goods_specification')
                ->where($map)
                ->order("sort asc")
                ->limit($p->firstRow.','.$p->listRows)
                ->select();
        $parent = M('shop_goods_specification')->where(['specification_id'=>$id,'is_delete'=>0])->find();
        $this->assign("show",$p->show());
        $this->assign ('pagetitle', '规格属性设置');
        $this->assign(['list'=>$list,'count'=>$count,'parent'=>$parent]);
        $url =$_SERVER['REQUEST_URI'];
        session('url',$url);
        $this->display();
    }

    public function edit_seed_specifications(){
        if(IS_POST){
            $data = $_POST; // 获取所有的post变量（原始数组）
            $model = D('GoodsSpecification');
            $result = $model->edit($data,'edit');
            if($result['status'] == 'success'){
                $this->success($result['msg']);
            }else{
                $this->error($result['msg']);
            }
            // if($result == 'success'){
            //     $this->success('成功!',U('edit_seed_specifications'));
            // }else{
            //     $this->error('失败!',U('edit_seed_specifications'));
            // }
        }else{
            $id = I('id');
            $re = M('shop_goods_specification')->where(['specification_id'=>$id,'is_delete'=>0])->find();
            $this->assign(['re'=>$re]);
            // $this->view->engine->layout(false);
            // return $this->fetch();
            $this->assign ('pagetitle', '编辑规格属性');
            $this->display();
        }
    }

    /**
     *商品列表
     */
    public function goods_list(){
        $map = [];
        $name = I('name'); // 获取所有的post变量（原始数组）
        $merchants_id = I('merchants_id');
        $goods_state = I('goods_state'); // 获取所有的post变量（原始数组）
        $parent_class = I('parent_class'); // 获取所有的post变量（原始数组）
        $seed_class = I('seed_class'); // 获取所有的post变量（原始数组）
        !empty($name) &&  $map['a.goods_name'] = ['like', '%' . $name . '%'];
        !empty($goods_state) && $map['a.goods_state'] = $goods_state;
        !empty($parent_class) && $map['a.parent_class'] = $parent_class;
        !empty($seed_class) && $map['a.seed_class'] = $seed_class;
        !empty($merchants_id) && $map['a.merchants_id'] = $merchants_id;
        $map['a.is_delete'] = '0';
        $map['b.open'] = 1;
        $map['b.apply_state'] = 2;
        $map['b.is_delete'] = 0;
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M('shop_goods')->alias('a')
                ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
                ->where($map)
                ->count();
        $p = getpage($count,$nus);
        $data = M("shop_goods")->alias('a')
                ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
                ->where($map)
                ->field('a.*')
                ->order("goods_state asc,sort desc,create_time desc")
                ->limit($p->firstRow.','.$p->listRows)
                ->select();
        $parent_class = M('shop_goods_class')
            ->field('class_id,class_name')
            ->where(['class_state'=>'1','is_delete'=>'0','parent_id'=>'-1'])
            ->select();
        $this->assign("show",$p->show());
        $this->assign ('pagetitle', '商品列表');   
        $this->assign(['list' => $data,'count'=>$count, 'parent_class'=>$parent_class]);
        $url = $_SERVER['REQUEST_URI'];
        session('url', $url);
        $this->display();
    }

    /**
     *分类联动
     */
    public function get_seed_class(){
        if(IS_AJAX){
            $parent = I('parent');
            $seed = M('shop_goods_class')->where(['parent_id'=>$parent,'is_delete'=>'0'])->select();
            $option= "<option value=''>选择二级分类</option>";
            if(!empty($seed)){
                foreach($seed as $k=>$v){
                    $option.="<option value=".$v['class_id'].">".$v['class_name']."</option>";
                }
            }else{
                $option= "<option value=''>暂无二级分类</option>";
            }
            echo $option;
        }
    }

    /**
     *删除商品
     */
    public function del_goods(){
        if(IS_AJAX) {
            $ids = I('ids');
            if(empty($ids))     error("删除失败");
            $map['goods_id']    =   ['in',$ids];
            $model = D('Goods');
            $result = $model->soft_del($map);
        }
    }

    /**
     *@改变商品的上架信息
     */
    public function change_goods_status(){
        if(IS_AJAX){
            $id = I('id');
            $status = M('shop_goods')->where(['goods_id'=>$id])->getField('goods_state');
            $abs = 3 - $status;
            $arr = ['1','2'];
            $result = M('shop_goods')->where(['goods_id'=>$id])->save(['goods_state'=>$abs]);
            if($result){
                success($arr[2-$status]);
            }else{
                error('切换状态失败');
            }
        }
    }

    /**
     *@改变商品的推荐信息
     */
    public function change_goods_tuijian(){
        if(IS_AJAX){
            $id = I('id');
            $status = M('shop_goods')->where(['goods_id'=>$id])->getField('is_tuijian');
            $abs = 1 - $status;
            $arr = ['1','2'];
            $result = M('shop_goods')->where(['goods_id'=>$id])->save(['is_tuijian'=>$abs]);
            if($result){
                success($arr[1-$status]);
            }else{
                error('切换状态失败');
            }
        }
    }

    /**
     *编辑商品
     */
    public function edit_goods(){
        if(IS_POST) {
            $data = $_POST;
            $data['goods_class'] = join(',',$data['goods_class']);
            $data['imgs'] = join(',',$data['imgs']);
            if(empty($data['goods_uuid'])){
                $data['goods_uuid'] = get_guid();
            }
            $model = D('Goods');
            $result = $model->edit($data,'edit');

            if($result == 'success'){
                $this->success('成功!',U('goods_list'));
            }else{
                $this->error('失败!',U('goods_list'));
            }
        }else{
            $goods_uuid = I('goods_uuid');
            $model = D('Goods');
            $where['goods_uuid'] = $goods_uuid;
            $goods = $model->queryGoods($where);
            $goods['imgs'] = explode(',',$goods['imgs']);
            $merchant = M('user')->where(['user_id'=>$goods['merchants_id']])->find();//商家
            $parent_class = M('shop_goods_class')
                            ->alias('a')
                            ->field('a.class_id,a.class_name')
                            ->join('m_shop_goods_merchants_class b ON FIND_IN_SET(a.class_id,b.class_id)')
                            ->where(['a.class_state'=>'1','a.is_delete'=>'0','b.member_id'=>$merchant['user_id']])
                            ->select();

            $brand = M('shop_goods_brand')->where(['merchant_id'=>$merchant['member_id'],'is_delete'=>'0','brand_state'=>'1'])->select();
            if(!empty($goods['goods_tag']))  $goods['goods_tag'] = unserialize($goods['goods_tag']);
            if(!empty($goods['goods_nature']))  $goods['goods_nature'] = unserialize($goods['goods_nature']);

            $specification = M('shop_goods_specification')->where(['parent_id'=>'-1','is_delete'=>'0'])->select();
            //产品规格详情
            $goods_specification_relation = M('shop_goods_relation_specification')->where(['goods_id'=>$goods['goods_id'],'is_delete'=>'0'])->select();

            $arr = [];    //选中的规格
            foreach ($goods_specification_relation as $v){
                $arr1 = explode(',',$v['specification_ids']);
                foreach ($arr1 as $val){
                    array_push($arr,$val);
                }
            }

            //父级分类
//            $goodsSpecificationBeans = Db::name('goods_relation_specification')->alias('a')
//                ->field('c.specification_id,c.specification_value')
//                ->join('th_goods_specification b', 'FIND_IN_SET(b.specification_id,a.specification_ids)')
//                ->join('th_goods_specification c', 'b.parent_id=c.specification_id')
//                ->where(['a.is_delete' => '0', 'a.goods_id' => $goods['goods_id'], 'b.is_delete' => '0', 'c.is_delete' => '0'])
//                ->group('c.specification_id')
//                ->select();
            $beans = M('shop_goods_relation_specification')->where(['goods_id'=>$goods['goods_id'],'is_delete'=>'0'])->order("specification_id desc")->getField('specification_ids');
            $beans = explode(',',$beans);
            $goodsSpecificationBeans = array();
            foreach ($beans as $v){
                $arr1 = M('shop_goods_specification')->alias('a')
                    ->field('b.specification_id,b.specification_value')
                    ->join('m_shop_goods_specification b ON a.parent_id = b.specification_id')
                    ->where(['a.specification_id'=>$v,'a.is_delete'=>0])
                    ->find();

                if(!empty($arr1)) {
                    if (!in_array($arr1, $goodsSpecificationBeans)) {
                        array_push($goodsSpecificationBeans, $arr1);
                    }
                }
            }

            foreach ($goodsSpecificationBeans as &$v){
                $v['specification'] = M('shop_goods_specification')->where(['parent_id'=>$v['specification_id'],'is_delete'=>0,'merchants_id'=>['in',['0',$merchant['member_id']]]])->select();
            }
            $seed_class = M('shop_goods_class')->where(['parent_id'=>$goods['parent_class']])->select();
            $this->assign(['parent_class'=>$parent_class,'brand'=>$brand,'re'=>$goods,
                'specification'=>$specification,'goods_specification_relation'=>$goods_specification_relation]);
            $this->assign(['arr'=>$arr,'goodsSpecificationBeans'=>$goodsSpecificationBeans,'seed_class'=>$seed_class]);
            $this->assign ('pagetitle', '编辑商品');   
            $this->display('insert_goods');
        }
    }

    /**
     *查找规格
     */
    public function querySpecification(){
        //if(Request::instance()->isAjax()) {
        $specification_id = I('id');
        $list = M('shop_goods_specification')->where(['parent_id'=>$specification_id,'is_delete'=>0])->select();
        if(empty($list)){
            error("该规格暂无数据，请自行添加或更换另一个");
        }else{
            $value = M('shop_goods_specification')->where(['specification_id'=>$specification_id,'is_delete'=>0])->getField('specification_value');
            success(['value'=>$value,'list'=>$list]);
        }
        //}
    }

    /**
     *商品列表
     */
    public function is_del_goods(){
        //$merchant = $this->merchant;
        $map = [];
        $name = I('name'); // 获取所有的post变量（原始数组）
        $merchants_id = I('merchants_id');
        $goods_state = I('goods_state'); // 获取所有的post变量（原始数组）
        $parent_class = I('parent_class'); // 获取所有的post变量（原始数组）
        $seed_class = I('seed_class'); // 获取所有的post变量（原始数组）
        !empty($name) &&  $map['goods_name'] = ['like', '%' . $name . '%'];
        !empty($goods_state) && $map['goods_state'] = $goods_state;
        !empty($parent_class) && $map['parent_class'] = $parent_class;
        !empty($seed_class) && $map['seed_class'] = $seed_class;
        !empty($merchants_id) && $map['merchants_id'] = $merchants_id;
        $map['is_delete'] = '1';
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M('shop_goods')->where($map)->count();
        $p = getpage($count,$nus);
        $data = M("shop_goods")
                ->where($map)
                ->order("goods_state asc,sort desc,create_time desc")
                ->limit($p->firstRow.','.$p->listRows)
                ->select();

        $this->assign("show",$p->show());
        $this->assign ('pagetitle', '商品删除列表');

        $parent_class = M('shop_goods_class')
            ->field('class_id,class_name')
            ->where(['class_state'=>'1','is_delete'=>'0','parent_id'=>'-1'])
            ->select();
        $this->assign(['list' => $data,'count'=>$count, 'parent_class'=>$parent_class]);
        $url = $_SERVER['REQUEST_URI'];
        session('url', $url);
        $this->display();
    }



    /**
     *删除商品
     */
    public function recovery_goods(){
        if(IS_AJAX) {
            $ids = I('ids');
            if(empty($ids))     error("删除失败");
            $map['goods_id']    =   ['in',$ids];
            $model = D('Goods');
            $result = $model->recovery_del($map);
        }
    }

    /**
     *@改变分类状态
     */
    public function change_goods_review(){
        if(IS_AJAX){
            $id = I('id');
            $status = M('shop_goods')->where(['goods_id'=>$id])->getField('is_review');
            $abs = 1 - $status;
            $arr = ['0','1'];
            $result = M('shop_goods')->where(['goods_id'=>$id])->save(['is_review'=>$abs]);
            if($result){
                return success($arr[1-$status]);
            }else{
                return error('切换状态失败');
            }
        }
    }

    /****************************我是华丽的分割线（以下是TP5内容）********************************/
    

    

    


    

    















    

    
    

    
    
    /**
     *添加商品
     */
    public function insert_goods(){
        if(Request::instance()->isAjax()) {
            $data = Request::instance()->post();
            $data['goods_class'] = join(',',$data['goods_class']);
            if(empty($data['goods_uuid'])){
                $data['goods_uuid'] = get_guid();
            }
            $model = model('Goods');
            $result = $model->edit($data);
        }else{
            $parent_class = Db::name('goods_class')
                ->field('class_id,class_name')
                ->where(['a.class_state'=>'1','a.is_delete'=>'0'])
                ->select();
            $brand = Db::name('goods_brand')->where(['is_delete'=>'0','brand_state'=>'1'])->select();
            $specification = Db::name('goods_specification')->where(['parent_id'=>'-1'])->select();
            $this->assign(['parent_class'=>$parent_class,'brand'=>$brand,'specification'=>$specification]);
            return $this->fetch();
        }
    }


    /**
     *品牌列表
     */
    public function brand(){
        $map = [];
        $name = input('name'); //
        $brand_state = input('brand_state'); //
        !empty($name) &&  $map['brand_name'] = ['like', '%' . $name . '%'];
        !empty($brand_state) && $map['brand_state'] = $brand_state;
        $map['is_delete'] = '0';
        $num = input('num');
        if (empty($num)) {
            $num = 10;
        }
        $this->assign('nus', $num);
        $count = Db::name('goods_brand')->where($map)->count();
        $data = Db::name("goods_brand")->where($map)->order("brand_state asc,sort desc")
            ->paginate($num,false,$config = ['query'=>array('name'=>$name,'brand_state'=>$brand_state)]);
        $page = $data->render();
        $this->assign(['list' => $data, 'page' => $page,'count'=>$count]);
        $url = $_SERVER['REQUEST_URI'];
        session('url', $url);
        return $this->fetch();
    }

    /**
     *添加品牌
     */
    public function edit_brand(){
        $model = model('GoodsBrand');
        if(Request::instance()->isAjax()){
            $data = Request::instance()->post(false); // 获取所有的post变量（原始数组）
//            $merchant = $this->merchant;
//            $data['merchant_id']    =   $merchant['member_id'];
            if(empty($data['brand_id'])){
                $data['brand_uuid'] = get_guid();
            }
            $result = $model->edit($data,'edit');
        }else{
            $brand_uuid = input('uuid');
            $where['brand_uuid'] = $brand_uuid;
            $re = $model->queryByCode($where);
            $this->assign(['re'=>$re]);
            return $this->fetch('goods/insert_brand');
        }
    }

    /**
     *删除品牌
     */
    public function del_brand(){
        if(Request::instance()->isAjax()) {
            $ids = input('ids');
            if(empty($ids))     error("删除失败");
            $merchant = $this->merchant;
            $map['merchant_id']    =   $merchant['member_id'];
            $map['brand_id']    =   ['in',$ids];
            $model = model('GoodsBrand');
            $result = $model->soft_del($map);
        }
    }

    /**
     *@品牌状态
     */
    public function change_brand_state(){
        if(Request::instance()->isAjax()){
            $id = input('id');
            $status = Db::name('goods_brand')->where(['brand_id'=>$id])->value('brand_state');
            $abs = 3 - $status;
            $arr = ['1','2'];
            $result = Db::name('goods_brand')->where(['brand_id'=>$id])->update(['brand_state'=>$abs]);
            if($result){
                echo json_encode(array('status'=>'ok','info'=>$arr[2-$status]));
                exit;
            }else{
                echo json_encode(array('status'=>'error','info'=>'切换状态失败'));
                exit;
            }
        }

    }

    
    

    

    

    
    

    
    

    

    /**
     *复制商品
     */
    public function copy_goods(){
        if(Request::instance()->isAjax()) {
            $id = input('id');
            $goods = Db::name('goods')->where(['goods_id'=>$id])->find();
            unset($goods['goods_id']);
            $goods['goods_state'] = '2';
            $goods['goods_uuid'] = get_guid();
            $goods['code'] = uniqid();
            $goods['create_time'] = date("Y-m-d H:i:s",time());
            $lastId = Db::name('goods')->insertGetId($goods);
            $create_time = date("Y-m-d H:i:s",time());
            if($lastId){
                Db::name('goods')->where(['goods_id'=>$lastId])->update(['sort'=>$lastId]);

                $specification = Db::name('goods_relation_specification')->where(['goods_id'=>$id,'is_delete'=>'0'])->select();
                if(!empty($specification)){
                    foreach ($specification as $v){
                        $newSpecification[] = [
                            'goods_id' => $lastId,
                            'specification_sku' => $v['specification_sku'],
                            'specification_ids' => $v['specification_ids'],
                            'specification_names'=> $v['specification_names'],
                            'specification_sales'=> $v['specification_sales'],
                            'specification_stock'=> $v['specification_stock'],
                            'specification_img'=> $v['specification_img'],
                            'specification_price'=> $v['specification_price'],
                            'specification_cost_price'=> $v['specification_cost_price'],
                            'specification_sale_price'=> $v['specification_sale_price'],
                            'create_time'=> $create_time

                        ];
                    }
                    if(!empty($newSpecification)){
                        Db::name('goods_relation_specification')->insertAll($newSpecification);
                    }
                }
                success("复制商品成功");
            }else{
                error("复制商品失败");
            }
        }
    }

    

    

    
    //二维码
    public function goods_qrcode(){
        $this->view->engine->layout(false);
        $goods_id = input('goods_id');
        $goods = Db::name('goods')->where(['goods_id'=>$goods_id])->find();
        $this->assign(['goods'=>$goods]);
        return $this->fetch();
    }
    // 空方法
    public function _empty(){
        $this->view->engine->layout(false);
        return $this->fetch('common/error');
    }


}