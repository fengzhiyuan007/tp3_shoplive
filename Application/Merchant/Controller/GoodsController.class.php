<?php
namespace Merchant\Controller;
class GoodsController extends SessionController {
	/**
     *商品列表
     */
    public function goods_list(){
        $merchant = session('shop');
        $map = [];

        $name = $_GET['name']; 

        if(strpos($name,'%') !== false){
            $name = urldecode($name);
        }

        $this->assign('name',$name);
        $goods_state = I('goods_state'); 
        $parent_class = I('parent_class'); 
        $seed_class = I('seed_class'); 
        !empty($name) &&  $map['goods_name'] = ['like', '%' . $name . '%'];
        !empty($goods_state) && $map['goods_state'] = $goods_state;
        !empty($parent_class) && $map['parent_class'] = $parent_class;
        !empty($seed_class) && $map['seed_class'] = $seed_class;
        $map['is_delete'] = '0';
        $map['merchants_id']    =   $merchant['member_id'];
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M('shop_goods')->where($map)->count();
        $p = getpage($count,$nus);
        $this->assign("show",$p->show());
        $data = M("shop_goods")
            	->where($map)
            	->order("goods_state asc,sort desc,create_time desc")
            	->limit($p->firstRow.','.$p->listRows)
                ->select();
        $parent_class = M('shop_goods_class')->alias('a')
            ->field('a.class_id,a.class_name')
            ->join('m_shop_goods_merchants_class b ON FIND_IN_SET(a.class_id,b.class_id)')
            ->where(['a.class_state'=>'1','a.is_delete'=>'0','b.member_id'=>$merchant['member_id']])
            ->select();
        $this->assign(['list' => $data,'count'=>$count, 'parent_class'=>$parent_class]);
        $url = $_SERVER['REQUEST_URI'];
        session('url', $url);
        $this->assign ('pagetitle', '商品列表');
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
     *@商品置顶
     */
    public function top(){
        if(IS_AJAX){
            $merchant = session('shop');
            $goods_id = I('goods_id');
            $name = I('name'); //
            $class_id = I('class_id');
            //$goods_state = input('goods_state'); //
            $parent_class = I('parent_class'); // 获取所有的post变量（原始数组）
            $seed_class = I('seed_class'); // 获取所有的post变量（原始数组）
            !empty($name) &&  $map['goods_name'] = ['like', '%' . $name . '%'];
            //!empty($goods_state) && $map['goods_state'] = $goods_state;
            !empty($goods_state) && $map['goods_state'] = $goods_state;
            !empty($parent_class) && $map['parent_class'] = $parent_class;
            !empty($seed_class) && $map['seed_class'] = $seed_class;
            //!empty($goods_state) && $map['goods_state'] = $goods_state;
            //!empty($class_id) && $map[] = ['exp','FIND_IN_SET('.$class_id.',goods_class)'];
            //$map['goods_state'] = 1;
            $map['is_delete'] = '0';
            $map['merchants_id'] = $merchant['member_id'];
            $check = M('shop_goods')->where(['goods_id'=>$goods_id])->find();
            if($check['goods_state'] != '1')        error("请先上架再操作");
            $map['sort'] = ['gt',$check['sort']];
            $last_goods = M('shop_goods')->where($map)
                ->order("sort desc,create_time asc")->limit(1)->select();
            if(empty($last_goods)){
                error('商品不能移动');
            }else{
                $sort = $last_goods[0]['sort']+1;
                $result = M('shop_goods')->where(['goods_id'=>$goods_id])->save(['sort'=>$sort]);
            }
            if($result){
                success("操作成功");
            }else{
                error('操作失败');
            }
        }
    }

    /**
     *@商品置后
     */
    public function after(){
        if(IS_AJAX){
            $merchant = session('shop');
            $goods_id = I('goods_id');
            $name = I('name'); //
            $parent_class = I('parent_class'); // 获取所有的post变量（原始数组）
            $seed_class = I('seed_class'); // 获取所有的post变量（原始数组）
            !empty($name) &&  $map['goods_name'] = ['like', '%' . $name . '%'];
            //!empty($goods_state) && $map['goods_state'] = $goods_state;
            !empty($goods_state) && $map['goods_state'] = $goods_state;
            !empty($parent_class) && $map['parent_class'] = $parent_class;
            !empty($seed_class) && $map['seed_class'] = $seed_class;
            !empty($class_id) && $map[] = ['exp','FIND_IN_SET('.$class_id.',goods_class)'];
            $map['goods_state'] = 1;
            $map['is_delete'] = '0';
            $map['merchants_id'] = $merchant['member_id'];
            $check = M('shop_goods')->where(['goods_id'=>$goods_id])->find();
            if($check['goods_state'] != '1')        error("请先上架再操作");
            $map['sort'] = ['lt',$check['sort']];
            $last_goods = M('shop_goods')->where($map)
                ->order("sort asc,create_time asc")->limit(1)->select();
            if(empty($last_goods)){
                error('商品不能移动');
            }else{
                $sort = $last_goods[0]['sort']-1;
                $result = M('shop_goods')->where(['goods_id'=>$goods_id])->save(['sort'=>$sort]);
            }
            if($result){
                success('操作成功');

            }else{
                error('操作失败');
            }
        }
    }


    /**
     *@商品上移排序
     */
    public function plus_goods_sort(){
        if(IS_AJAX){
            $merchant = session('shop');
            $goods_id = I('goods_id');
            $name = I('name'); //
            //$goods_state = input('goods_state'); //
            $parent_class = I('parent_class'); // 获取所有的post变量（原始数组）
            $seed_class = I('seed_class'); // 获取所有的post变量（原始数组）
            !empty($name) &&  $map['goods_name'] = ['like', '%' . $name . '%'];
            //!empty($goods_state) && $map['goods_state'] = $goods_state;
            !empty($goods_state) && $map['goods_state'] = $goods_state;
            !empty($parent_class) && $map['parent_class'] = $parent_class;
            !empty($seed_class) && $map['seed_class'] = $seed_class;
            $check = M('shop_goods')->where(['goods_id'=>$goods_id])->find();
            $map['sort'] = ['gt',$check['sort']];
            $map['goods_state'] = 1;
            $map['is_delete'] = '0';
            $map['merchants_id'] = $merchant['member_id'];
            if($check['goods_state'] != '1')        error("请先上架再操作");

            $last = M('shop_goods')->where($map)
                ->order("sort asc,create_time desc")->limit(1)->select();
            if(empty($last)){
                error('商品不能移动');
            }else{
                $sort = $last[0]['sort'];
                $result = M('shop_goods')->where(['goods_id'=>$goods_id])->save(['sort'=>$sort]);
                M('shop_goods')->where(['goods_id'=>$last[0]['goods_id']])->save(['sort'=>$check['sort']]);
            }
            if($result){
                success('操作成功');
            }else{
                error('操作失败');
            }
        }
    }

    /**
     *@下移排序
     */
    public function minus_goods_sort(){
        if(IS_AJAX){
            $merchant = session('shop');
            $goods_id = I('goods_id');
            $name = I('name'); //
            //$goods_state = input('goods_state'); //
            $parent_class = I('parent_class'); // 获取所有的post变量（原始数组）
            $seed_class = I('seed_class'); // 获取所有的post变量（原始数组）
            !empty($name) &&  $map['goods_name'] = ['like', '%' . $name . '%'];
            //!empty($goods_state) && $map['goods_state'] = $goods_state;
            !empty($goods_state) && $map['goods_state'] = $goods_state;
            !empty($parent_class) && $map['parent_class'] = $parent_class;
            !empty($seed_class) && $map['seed_class'] = $seed_class;
            $check = M('shop_goods')->where(['goods_id'=>$goods_id])->find();
            $map['sort'] = ['lt',$check['sort']];
            $map['goods_state'] = 1;
            $map['is_delete'] = '0';
            $map['merchants_id'] = $merchant['member_id'];
            if($check['goods_state'] != '1')        error("请先上架再操作");

            $last = M('shop_goods')->where($map)
                ->order("sort desc,create_time desc")->limit(1)->select();
            if(empty($last)){
                error('商品不能移动');
            }else{
                $sort = $last[0]['sort'];
                $result = M('shop_goods')->where(['goods_id'=>$goods_id])->save(['sort'=>$sort]);
                M('shop_goods')->where(['goods_id'=>$last[0]['goods_id']])->save(['sort'=>$check['sort']]);
            }
            if($result){
                success('操作成功');
            }else{
                error('操作失败');
            }
        }
    }

    /**
     *删除商品
     */
    public function del_goods(){
        if(IS_AJAX) {
            $ids = I('ids');
            if(empty($ids))     error("删除失败");
            $merchant = session('shop');
            $map['merchants_id']    =   $merchant['member_id'];
            $map['goods_id']    =   ['in',$ids];
            $model = D('Goods');
            $result = $model->soft_del($map);
        }
    }

    /**
     *添加商品
     */
    public function insert_goods(){
        $merchant = session('shop');
        if(IS_POST) {
            $data = I('post.');
            $data['merchants_id'] = $merchant['member_id'];
            $data['goods_class'] = join(',',$data['goods_class']);
            if(empty($data['goods_uuid'])){
                $data['goods_uuid'] = get_guid();
            }
            $model = D('Goods');
            $result = $model->edit($data);
            if($result['status'] == 'success'){
            	$this->success($result['msg']);
            }else{
            	$this->error($result['msg']);
            }
        }else{
            $parent_class = M('shop_goods_class')->alias('a')
                ->field('a.class_id,a.class_name')
                ->join('m_shop_goods_merchants_class b ON FIND_IN_SET(a.class_id,b.class_id)')
                ->where(['a.class_state'=>'1','a.is_delete'=>'0','b.member_id'=>$merchant['member_id']])
                ->select();
                
            $brand = M('shop_goods_brand')->where(['merchant_id'=>$merchant['member_id'],'is_delete'=>'0','brand_state'=>'1'])->select();
            $specification = M('shop_goods_specification')->where(['parent_id'=>'-1','is_delete'=>0])->select();

            //查询店铺默认对主播的分成比
            $re['goods_per'] = $merchant['goods_per'];
            
            $this->assign(['parent_class'=>$parent_class,'brand'=>$brand,'specification'=>$specification,'re'=>$re]);
            $this->display();
        }
    }

    /**
     *编辑商品
     */
    public function edit_goods(){
        $merchant = session('shop');
        if(IS_POST) {
            $data = I('post.');
            // print_r($data);exit;
            $data['merchants_id'] = $merchant['member_id'];
            $data['goods_class'] = join(',',$data['goods_class']);
            $data['imgs'] = join(',',$data['imgs']);
            if(empty($data['goods_uuid'])){
                $data['goods_uuid'] = get_guid();
            }
            $model = D('Goods');
            $result = $model->edit($data,'edit');

            if($result['status'] == 'success'){
            	$this->success($result['msg']);
            }else{
            	$this->error($result['msg']);
            }
        }else{
            $parent_class = M('shop_goods_class')->alias('a')
                ->field('a.class_id,a.class_name')
                ->join('m_shop_goods_merchants_class b ON FIND_IN_SET(a.class_id,b.class_id)')
                ->where(['a.class_state'=>'1','a.is_delete'=>'0','b.member_id'=>$merchant['member_id']])
                ->select();
            $brand = M('shop_goods_brand')->where(['merchant_id'=>$merchant['member_id'],'is_delete'=>'0','brand_state'=>'1'])->select();
            $goods_uuid = I('goods_uuid');
            $model = D('Goods');
            $where['goods_uuid'] = $goods_uuid;
            $goods = $model->queryGoods($where);
            $goods['imgs'] = explode(',',$goods['imgs']);
            if(!empty($goods['goods_tag']))  $goods['goods_tag'] = unserialize($goods['goods_tag']);
            if(!empty($goods['goods_nature']))  $goods['goods_nature'] = unserialize($goods['goods_nature']);
            $specification = M('shop_goods_specification')->where(['parent_id'=>'-1','is_delete'=>0])->select();
            //产品规格详情
            $goods_specification_relation = M('shop_goods_relation_specification')->where(['goods_id'=>$goods['goods_id'],'is_delete'=>'0'])->select();

            $arr = [];    //选中的规格
            foreach ($goods_specification_relation as $v){
                $arr1 = explode(',',$v['specification_ids']);
                foreach ($arr1 as $val){
                    array_push($arr,$val);
                }
            }

            
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
                $v['specification'] = M('shop_goods_specification')->where(['parent_id'=>$v['specification_id'],'is_delete'=>0,'is_delete'=>0,'merchants_id'=>['in',['0',$merchant['member_id']]]])->select();
            }

            $seed_class = M('shop_goods_class')->where(['parent_id'=>$goods['parent_class'],'is_delete'=>0])->select();


            $this->assign(['parent_class'=>$parent_class,'brand'=>$brand,'re'=>$goods,
                'specification'=>$specification,'goods_specification_relation'=>$goods_specification_relation]);
            $this->assign(['arr'=>$arr,'goodsSpecificationBeans'=>$goodsSpecificationBeans,'seed_class'=>$seed_class]);
            $this->display('Goods/insert_goods');
        }
    }

    /**
     *查找规格
     */
    public function querySpecification(){
        $specification_id = I('id');
        $list = M('shop_goods_specification')->where(['parent_id'=>$specification_id,'is_delete'=>0])->select();
        if(empty($list)){
            error("该规格暂无数据，请自行添加或更换另一个");
        }else{
            $value = M('shop_goods_specification')->where(['specification_id'=>$specification_id,'is_delete'=>0])->getField('specification_value');
            success(['value'=>$value,'list'=>$list]);
        }
    }


    /**
     *商品列表
     */
    public function is_del_goods(){
        $merchant = session('shop');
        $map = [];
        $name = I('name'); // 获取所有的post变量（原始数组）
        $merchants_id = $merchant['member_id'];
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

        // $parent_class = M('shop_goods_class')
        //     ->field('class_id,class_name')
        //     ->where(['class_state'=>'1','is_delete'=>'0','parent_id'=>'-1'])
        //     ->select();

        $parent_class = M('shop_goods_class')->alias('a')
            ->field('a.class_id,a.class_name')
            ->join('m_shop_goods_merchants_class b ON FIND_IN_SET(a.class_id,b.class_id)')
            ->where(['a.class_state'=>'1','a.is_delete'=>'0','b.member_id'=>$merchant['member_id']])
            ->select();

        $this->assign(['list' => $data,'count'=>$count, 'parent_class'=>$parent_class]);
        $url = $_SERVER['REQUEST_URI'];
        session('url', $url);
        $this->assign ('pagetitle', '已删除商品');
        $this->display();
    }

  
    /**
     *恢复删除商品
     */
    public function recovery_goods(){
        if(IS_AJAX) {
            $ids = I('ids');
            if(empty($ids))     error("删除失败");
            $merchant = session('shop');
            $map['merchants_id']    =   $merchant['member_id'];
            $map['goods_id']    =   ['in',$ids];
            $model = D('Goods');
            $result = $model->recovery_del($map);
        }
    }

    /******************邮费模板管理*********************/
    public function postage()
    {
        $map = [];
        $title = I('name');
        $title && $map['postage_name'] = ['like', '%' . $title . '%'];
        $num = I('num');
        $map['is_delete'] = 0;
        //每页显示几条
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);
        $count = M('shop_postage')->where($map)->count();
        $p = getpage($count,$nus);
        $list = M('shop_postage')
              ->where($map)
              ->limit($p->firstRow.','.$p->listRows)
              ->select();

        $this->assign("show",$p->show());
        $this->assign ('pagetitle', '商品删除列表');


        $this->assign(['list' => $list, 'count' => $count]);
        $url = $_SERVER['REQUEST_URI'];
        session('url', $url);
        $this->assign ('pagetitle', '邮费模版');
        $this->display();
    }


    //设置默认
    public function default_postage() {
        $id = I('id');
        $member_id = session('shop')['member_id'];

        M('shop_postage')->where(['merchants_id'=>$member_id,'default'=>1])->save(['default'=>0]);

        M('shop_postage')->where(['merchants_id'=>$member_id,'postage_id'=>$id])->save(['default'=>1]);

        echo json_encode(array('status' => 'ok', 'info' => '操作成功', 'url' => session('url')));exit;

    }

    //删除邮费模板
    public function del_postage() {
        if (IS_AJAX) {
            $id = I('ids');
            if (empty($id)) error("参数错误");
            $map['postage_id'] = ['in', $id];
            $map['merchants_id'] = session('shop')['member_id'];
            $result = M('shop_postage')->where($map)->delete();
            if (empty($result) ) error("删除操作失败");
            foreach($id as $vo) {
                M('shop_postage_city')->where(['postage_id'=>$vo])->delete();
            }
            echo json_encode(array('status' => 'ok', 'info' => '删除记录成功', 'url' => session('url')));exit;
        }
    }

    //添加邮费模板
    public function postage_create()
    {
        $id = I('id');
        $data = I('post.'); // 获取所有的post变量（原始数组）
        if (IS_POST) {
            if ($id) {
                if (empty($data['postage_name'])) error('模板名称不能为空');
                //模板 DB
                $postage_id = M('shop_postage')->where(array('postage_id'=>$id))->save([
                    'postage_name'=>$data['postage_name'],
                    'merchants_id'=>session('shop')['member_id'],
                    'postage_way'=>$data['postage_way'],
                    'create_time'=>date('Y-m-d H:i:s',time()),
                    'update_time'=>date('Y-m-d H:i:s',time()),
                ]);
                if (empty($postage_id) ) error('服务器错误');

                foreach($data['postage_city_id'] as $key=>$vo) {
                    unset($tmp);
                    $data['postage_range'][$key] === ''?$tmp['postage_range']=1:$tmp['postage_range']=$data['postage_range'][$key];
                    $data['postage_price'][$key] === ''?$tmp['postage_price']=0:$tmp['postage_price']=$data['postage_price'][$key];
                    $data['postage_add_range'][$key] === ''?$tmp['postage_add_range']=1:$tmp['postage_add_range']=$data['postage_add_range'][$key];
                    $data['postage_add_price'][$key] === ''?$tmp['postage_add_price']=0:$tmp['postage_add_price']=$data['postage_add_price'][$key];
                    $tmp['update_time'] = date('Y-m-d H:i:s',time());
                    if ($vo) {
                        $tmp['postage_city_id'] = $vo;
                        $tmp['postage_id'] = $id;
                        $tmp['city_names'] = str_replace('-' ,',' ,$data['city_names'][$key] );
                        M('shop_postage_city')->where(array('postage_city_id'=>$vo))->save($tmp);
                    } else {
                        $tmp['create_time'] = date('Y-m-d H:i:s',time());
                        $tmp['postage_id'] = $id;
                        $tmp['city_names'] = str_replace('-' ,',' ,$data['city_names'][$key] );
                        M('shop_postage_city')->add($tmp);
                    }

                }
                // success(array('status' => 'ok', 'info' => '操作成功', 'url' => session('url')) );
                $this->success('操作成功');
            } else {
                if (empty($data['postage_name'])) error('模板名称不能为空');
                //模板 DB
                $postage_id = M('shop_postage')->add([
                    'postage_name'=>$data['postage_name'],
                    'merchants_id'=>session('shop')['member_id'],
                    'postage_way'=>$data['postage_way'],
                    'create_time'=>date('Y-m-d H:i:s',time()),
                    'update_time'=>date('Y-m-d H:i:s',time()),
                ]);
                if (empty($postage_id) ) error('服务器错误');

                foreach($data['postage_price'] as $key=>$vo) {
                    $data['postage_range'][$key] === ''?$tmp['postage_range']=1:$tmp['postage_range']=$data['postage_range'][$key];
                    $vo === ''?$tmp['postage_price']=0:$tmp['postage_price']=$vo;
                    $data['postage_add_range'][$key] === ''?$tmp['postage_add_range']=1:$tmp['postage_add_range']=$data['postage_add_range'][$key];
                    $data['postage_add_price'][$key] === ''?$tmp['postage_add_price']=0:$tmp['postage_add_price']=$data['postage_add_price'][$key];
                    $tmp['create_time'] = date('Y-m-d H:i:s',time());
                    $tmp['update_time'] = date('Y-m-d H:i:s',time());
                    $tmp['postage_id'] = $postage_id;
                    $tmp['city_names'] = str_replace('-' ,',' ,$data['city_names'][$key] );
                    M('shop_postage_city')->add($tmp);
                }
                // success(array('status' => 'ok', 'info' => '添加成功', 'url' => session('url')) );
                $this->success('操作成功');

            }

        } else {
            //省
            $sheng = M('Areas')->where(array('level'=>1))->select();
            $re = M('shop_postage')->where(['postage_id' => $id,'is_delete'=>0])->find();
            if ($re) $re['list'] = M('shop_postage_city')->where(['postage_id'=>$re['postage_id']])->select();
//            $re['course_class'] = explode('#',$re['class_color'])[1];
            $this->assign(['re' => $re, 'sheng' => $sheng]);
            $this->display();
        }
    }

    /**
     * 优惠卷
    */
    public function coupon()
    {
        $member_id = session('shop')['member_id'];
        $count = M('shop_coupon')->where(['is_delete'=>'0','merchants_id'=>$member_id])->count();
        $title = I('title');
        $title && $where['title'] = ['like', '%' . $title . '%'];

        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);

        $p = getpage($count,$nus);
        $this->assign("show",$p->show());

        $params = I('param.');
        $where['is_delete'] = 0;
        $where['merchants_id'] = $member_id;
        $list = M('shop_coupon')->alias('a')
                ->where($where)
                ->order('coupon_id desc')
                ->limit($p->firstRow.','.$p->listRows)
                ->select();
        $this->assign(['list'=>$list,'count'=>$count]);
        $url = $_SERVER['REQUEST_URI'];
        session('url', $url);
        $this->assign ('pagetitle', '优惠券列表');
        $this->display();
        
    }

    public function coupon_create()
    {
        $member = session('shop');
        $id = I('id');
        $data = I('post.'); // 获取所有的post变量（原始数组）
        if (IS_POST) {

            $rules = array(
                 array('title','require','必填项不能为空'), 
                 array('value','require','必填项不能为空'), 
                 array('limit_value','require','必填项不能为空'), 
                 array('balance','require','必填项不能为空'), 
            );

            $User = M("shop_coupon"); // 实例化User对象
            if (!$User->validate($rules)->create()){
                 // 如果创建失败 表示验证没有通过 输出错误提示信息
                 $this->error($User->getError());
            }
            if($data['value'] >= $data['limit_value']) $this->error('优惠卷价值必须小于满减');
            if (!empty($data['start_time']) && !empty($data['end_time'])){
                
                $data['start_strtotime'] = strtotime($data['start_time']);
                $data['end_strtotime'] = strtotime($data['end_time']);
            }
            unset($data['id']);
            if (empty($id)) {
                $data['intime'] = date('Y-m-d H:i:s',time());
                $data['uptime'] = date('Y-m-d H:i:s',time());
                $data['merchants_id'] = $member['member_id'];
                $ret = M('shop_coupon')->add($data);
            } else {
                $ret = M('shop_coupon')->where(['coupon_id'=>$id])->save($data);
            }

            if ($ret) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }

        }else{
            $ret = M('shop_coupon')->where(['coupon_id'=>$id])->find();
        
            $this->assign(['re'=>$ret]);
            $this->assign ('pagetitle', '添加优惠券');
            $this->display();
        }

        
    }

    public function coupon_del()
    {
        if(IS_AJAX){
            $id = I('ids');
            if(empty($id))      error("参数错误");
            $map['coupon_id']    =   ['in',$id];
            $result = M('shop_coupon')->where($map)->save(['is_delete'=>1]);
            if($result){
                $url = $_SERVER['REQUEST_URI'];
                success(['info'=>'删除'.'操作成功','url'=>$url]);
            }else{
                error("操作失败");
            }
        }
    }

    /**
     *@优惠卷状态
     */
    public function coupon_state(){
        if(IS_AJAX){
            $id = I('id');
            $status = M('shop_coupon')->where(['coupon_id'=>$id])->getField('status');
            $abs = 3 - $status;
            $arr = ['1','2'];
            $result = M('shop_coupon')->where(['coupon_id'=>$id])->save(['status'=>$abs]);
            if($result){
                echo success(array('status'=>'ok','info'=>$arr[2-$status]));
                exit;
            }else{
                echo success(array('status'=>'error','info'=>'切换状态失败'));
                exit;
            }
        }

    }



    /**
     * 评论 查 删
     */
    public function comment()
    {
        $member_id = session('shop')['member_id'];
        $count = M('shop_goods_comment')->alias('a')
               ->where(['a.is_delete'=>'0','a.merchants_id'=>$member_id,'a.pid'=>0])
               ->join('m_user b ON a.member_id=b.user_id')
               ->join('m_shop_goods g ON a.goods_id=g.goods_id')
               ->count();
        $title = I('title');
        $title && $where['g.goods_name'] = ['like', '%' . $title . '%'];
        
        if (isset($_GET['nums'])){
            $nus  = intval($_GET['nums']);
        }else {
            $nus  = 10;
        }
        $this->assign("nus",$nus);

        $p = getpage($count,$nus);
        $this->assign("show",$p->show());

        $params = I('param.');
        $where['a.is_delete'] = 0;
        $where['a.pid'] = 0;
        $where['a.merchants_id'] = $member_id;
        $list = M('shop_goods_comment')->alias('a')
            ->field('a.*,b.username,g.goods_name')
            ->join('m_user b ON a.member_id=b.user_id')
            ->join('m_shop_goods g ON a.goods_id=g.goods_id')
            ->where($where)
            ->order('comment_id desc')
            ->limit($p->firstRow.','.$p->listRows)
            ->select();
        $this->assign(['list'=>$list,'count'=>$count]);
        $this->assign ('pagetitle', '商品评论');
        
        $this->display();
    }
    //查评论
    public function comment_show()
    {
        $id = I('id');
        $db = M('shop_goods_comment')->alias('a')
            ->field('a.*,b.username,g.goods_name')
            ->join('m_user b ON a.member_id=b.user_id')
            ->join('m_shop_goods g ON a.goods_id=g.goods_id')
            ->where(['a.comment_id'=>$id])->find();
        $db['img'] = explode(',',$db['img']);

        $this->assign('re',$db);
        $huifu = M('shop_goods_comment')->where(['pid'=>$id])->getField('comment_desc');
        $this->assign('huifu',$huifu);
        $this->assign ('pagetitle', '商品评论');
        $this->display();
    }

    //删评论
    public function comment_del()
    {
        if(IS_AJAX){
            $id = I('ids');
            if(empty($id))      error("参数错误");
            $map['comment_id']    =   ['in',$id];
            $result = M('shop_goods_comment')->where($map)->save(['is_delete'=>1]);
            if($result){
                success(['info'=>'删除'.'操作成功','url'=>$url]);
            }else{
                error("操作失败");
            }
        }
    }

    //评论回复
    public function comment_reply()
    {
        $id = I('id');
        $content = I('content')?I('content'):'谢谢你的支持...';

        $db = M('shop_goods_comment')->where(['pid'=>$id])->find();
        if ($db) {
            $this->error('你已经回复了..');
        }

        $db = M('shop_goods_comment')->where(['comment_id'=>$id])->find();
        if (empty($db)) {
            $this->error('数据不存在');
        }


        $db['pid'] = $id;
        $db['create_time'] = $id;
        $db['update_time'] = $id;
        $db['comment_desc'] = $content;
        unset($db['comment_id']);
        $tmp = M('shop_goods_comment')->add($db);
        if ($tmp) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }


    //删除邮费
    public function del_postage_city() {
        if (IS_AJAX) {
            $id = I('ids');
            if (empty($id)) error("参数错误");
            $map['postage_city_id'] = ['in', $id];
            $result = M('shop_postage_city')->where($map)->delete();
            if (empty($result) ) error("删除操作失败");
            echo json_encode(array('status' => 'ok', 'info' => '删除记录成功', 'url' => session('url')));exit;
        }
    }



}