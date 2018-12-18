<?php
/**
 * Created by PhpStorm.
 * User: ljy
 * Date: 17/10/9
 * Time: 上午8:57
 */
namespace App\Controller;
use Think\Controller;
class HomeController extends CommonController
{
    //轮播
    public function banner_list(){
        /****轮播****/
        $type = I('type');
        $type ? $map['type'] = $type : $map['type'] = '1';
        $map['is_del'] = '1';
        $map['status'] = '2';
        $map['is_del'] = '1';
        $list = M('shop_banner')->field("b_id,b_img,url,b_type,title,jump")
            ->where($map)->order("sort asc")->select();
//        if(!empty($list)){
//            foreach($list as &$v){
//                switch($v['b_type']){
//                    case 1:
//                        $v['jump'] = '';
//                        break;
//                    case 2:
//                        $v['jump'] = $this->url.'/api/Home/banner_url/id/'.$v['b_id'];
//                        break;
//                    case 3:
//                        $v['jump'] = $v['value'];
//                        break;
//                    case 4:
//                        $v['jump'] = $v['value'];
//                        break;
//                }
//            }
//        }else{
//            $list = [];
//        }
        return success($list);
    }

    public function company_info(){
        $info = M('shop_aboutus')->where(['id'=>'1'])->find();
        if (empty($info))  $info =  (object)[];
        success($info);
    }

    /**
     *@轮播web跳转页
     */
    public function banner_url(){
        $id = I('id');
        $content = M('shop_banner')->where(['b_id'=>$id])->getField('content');
        $this->assign(['content'=>htmlspecialchars_decode($content)]);
        $this->display();
    }

    //模块
    public function dress(){
        $list = M('shop_dress')->where(['pid'=>'-1','is_delete'=>'0','status'=>'2'])->order('sort asc')->select();
        if(!empty($list)){
            foreach ($list as &$v){
                $dd = M('shop_dress')->where(['pid'=>$v['dress_id'],'is_delete'=>'0','status'=>'2'])->order('sort asc')->select();
                if($dd){
                    $v['seedBeans'] = $dd;
                }else{
                    $v['seedBeans'] = [];
                }
            }
        }
        success($list);
    }

    //模块
    public function dress_pc(){
        $list = M('shop_dress_pc')->where(['pid'=>'-1','is_delete'=>'0','status'=>'2'])->order('sort asc')->select();
        if(!empty($list)){
            foreach ($list as $k=>$v){
                $seedBeans = M('shop_dress_pc')->alias('a')
                    ->field('a.*,b.goods_name,b.goods_origin_price,b.goods_now_price,b.goods_img,b.goods_id,b.total_sales')
                    ->join('m_shop_goods b ON a.jump = b.goods_id')
                    ->where(['a.pid'=>$v['dress_id'],'a.is_delete'=>'0','a.status'=>'2'])
                    ->order('sort asc')->select();
                if($seedBeans){
                    foreach ($seedBeans as $key=>$val){
                        $seedBeans[$key]['comment_count'] = M('shop_goods_comment')->where(['goods_id'=>$val['goods_id'],'is_delete'=>'0'])->count();
                    }
                    $list[$k]['seedBeans'] = $seedBeans;
                }else{
                    $list[$k]['seedBeans'] = [];
                }
            }
        }
        success($list);
    }

    public function text(){
        $id = I('id');
        $re = M('shop_text')->where(['text_id'=>$id])->find();
        $this->assign(['re'=>$re]);
        $this->display();
    }

    public function home_class(){
        $list = M('shop_home_class')->where(['is_delete'=>'0','status'=>'2'])->order("sort asc")->select();
        success($list);
    }

    public function home_class_pc(){
        $list = M('shop_home_class_pc')->where(['is_delete'=>'0','status'=>'2'])->order("sort asc")->select();
        success($list);
    }

    public function city(){
        $name = I('name');
        !empty($name)   &&   $map['shouzimu'] = ['in',$name];
        $map['is_delete'] = 0;
        $list = M('shop_city')->field('city,shouzimu')
            ->where($map)->order('shouzimu asc')->select();
        success($list);
    }

    /**
     *推荐商品(猜你喜欢)
     */
    public function maybeEnjoy(){
        if (IS_POST) {
//            $uid = input('uid');
            $p = I('p');
            $p  ?   $p  :   $p = 1;
            $pagesize = I('pagesize');
            $pagesize ? $pagesize  :  $pagesize = 10;
            $map['a.is_delete'] = '0';
            $map['a.goods_state'] = '1';
            $map['a.is_review'] = 1;
            $map['a.is_tuijian'] = 1;

            $map['b.open'] = 1;
            $map['b.apply_state'] = 2;
            $map['b.is_delete'] = 0;

            $count = M('shop_goods')->alias('a')
                   ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
                   ->where($map)
                   ->count();
            $page = ceil($count/$pagesize);
            if($count) {
                $goods = M('shop_goods')->alias('a')
                    ->join('m_shop_merchants b ON a.merchants_id = b.member_id')
                    ->field("a.goods_id,a.goods_name,a.goods_img,a.goods_origin_price,a.goods_pc_price,a.goods_now_price,a.total_sales,a.month_sales,a.day_sales")
                    ->where($map)->order('a.important desc')->limit(($p - 1) * $pagesize, $pagesize)
                    ->select();
            }else{
                $goods = [];
            }
            success(['page'=>$page,'goods'=>$goods]);
        }
    }

    /**
     *@param 资讯文章分类
     */
    public function article_class(){
        $list = M('shop_article_class')->field('class_id,title,img')
            ->where(['is_del'=>'1','status'=>'2'])->select();
        success($list);
    }
    /**
     *@param 资讯文章列表
     */
    public function article(){
        $class_id = I('class_id');
        !empty($class_id)    &&  $map['class_id']   =   $class_id;
        $map['is_delete'] = '0';
        $map['status'] = '2';
        $p = I('p');
        $p  ?   $p  :   $p = 1;
        $pagesize = I('pagesize');
        $pagesize ? $pagesize  :  $pagesize = 10;
        $count = M('shop_article')->where($map)->count();
        $page = ceil($count/$pagesize);
        if($count){
            $list = M('shop_article')->field('id,title,img,browse,intime,author')
                ->where($map)->order('intime desc')
                ->limit(($p-1)*$pagesize,$pagesize)
                ->select();
        }else{
            $list = [];
        }
        success(['page'=>$page,'list'=>$list]);
    }

    /**
     *@param 资讯文章详情
     */
    public function article_view(){
        $id = I('id');
        $re = M('shop_article')->where(['id'=>$id])->find();
        if($re){
            $result = M('shop_article')->where(['id'=>$id])->setInc('browse');
            if($result){
                $re['browse'] ++;
            }
            success($re);
        }else{
            error("资讯错误");
        }
    }

    
}