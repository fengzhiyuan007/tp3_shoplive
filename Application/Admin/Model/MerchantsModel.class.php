<?php
namespace Admin\Model;
use Think\Model;
use lib\Easemob;
class MerchantsModel extends MyModel
{
	protected $tableName="shop_merchants";
	//只读字段
    protected $readonly = ['merchants_id','member_id','hx_password'];
    protected $pk = 'merchants_id';   //设置主键

    public function add_merchants($params,$scene='')
    {
        
        $data['province'] = M('Areas')->where(array('id' => $params['sheng']))->getField('name');
        $data['city'] = M('Areas')->where(array('id' => $params['shi']))->getField('name');
        $data['area'] = M('Areas')->where(array('id' => $params['qu']))->getField('name');
        $merchants['merchants_province'] = M('Areas')->where(array('id' => $params['sheng']))->getField('name');
        $merchants['merchants_city'] = M('Areas')->where(array('id' => $params['shi']))->getField('name');
        $merchants['merchants_country'] = M('Areas')->where(array('id' => $params['qu']))->getField('name');

        //进行添加编辑判断
        $domain =  C('IMG_PREFIX');
        $merchants['merchants_img'] = $domain.$params['merchants_imgs'];
        $merchants['legal_img'] = $domain.$params['legal_imgs'];
        $merchants['legal_face_img'] = $domain.$params['legal_face_imgs'];
        $merchants['legal_opposite_img'] = $domain.$params['legal_opposite_imgs'];
        $merchants['legal_hand_img'] = $domain.$params['legal_hand_imgs'];
        $merchants['business_img'] = $domain.$params['business_imgs'];        
        $merchants['merchants_province'] = M('Areas')->where(array('id' => $params['sheng']))->getField('name');
        $merchants['merchants_city'] = M('Areas')->where(array('id' => $params['shi']))->getField('name');
        $merchants['merchants_country'] = M('Areas')->where(array('id' => $params['qu']))->getField('name');
        $merchants['merchants_province'] ? $merchants['merchants_province'] : $merchants['merchants_province'] = '';
        $merchants['merchants_city'] ? $merchants['merchants_city'] : $merchants['merchants_city'] = '';
        $merchants['merchants_country'] ? $merchants['merchants_country'] : $merchants['merchants_country'] = '';

        $merchants["merchants_per"] = $params['merchants_per'];
        $merchants["goods_per"] = $params['goods_per'];


        if (empty($params['member_id'])) {
            $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
            mt_srand(10000000 * (double)microtime());
            for ($i = 0, $str = '', $lc = strlen($chars) - 1; $i < 12; $i++) {
                $str .= $chars[mt_rand(0, $lc)];
            }
            for ($i = 0, $str1 = '', $lc = strlen($chars) - 1; $i < 13; $i++) {
                $str1 .= $chars[mt_rand(0, $lc)];
            }
            // $hx = new Easemob();
            $re = huanxin_zhuce($str, '123456');
            if (!$re) return error("添加用户失败");
            $hx_password = "123456";
            $data['pwd'] = empty($params["password"]) ? md5("123456") : md5($params['password']);
            $data['hx_password'] = $hx_password;
            $data["sex"] = empty($params["sex"]) ? 1 : $params["sex"];
            $data['hx_username'] = $str;
            $data['username'] = empty($params["username"]) ? "游荡者".rand(100000,999999) : $params["username"];
            // $data['alias'] = $str;
            $data["phone"] = $params["phone"];
            $data["img"] = empty($params["img"]) ? $domain . "/Public/upload/touxiang/touxiang.png" : $params["img"];
            $data["ID"] = get_number();
            $data["alias"] = $str;
            $data["autograph"] = "这个人很懒什么都没有留下！！";
            // $data["uuid"] = get_guid();
            $data['intime'] = time();
            $data["type"] = 2;
            // $tag = $params["tag"];
            // $data["live_tag"] = $tag;
            $action = '新增';
            //商户扩展信息
            $merchants["merchants_name"] = $params["merchants_name"];//店铺名称
            $merchants["contact_name"] = $params["contact_name"];//联系姓名
            $merchants["contact_mobile"] = $params["contact_mobile"];//联系电话
            $merchants["company_name"] = $params["company_name"];//公司名称
            $merchants["company_mobile"] = $params["company_mobile"];//公司电话
            $merchants["merchants_img"] = $domain.$params["merchants_imgs"];//店铺名称
            $merchants["merchants_address"] = $params["merchants_address"];//店铺地址
            // $merchants["dashang_scale"] = $params["dashang_scale"];//直播打赏比例
            // $merchants["sell_scale"] = $params["sell_scale"];//销售打赏比例
            // $merchants["tv_sell_scale"] = $params["tv_sell_scale"];//销售打赏比例
            $merchants["merchants_content"] = $params["merchants_content"];//店铺介绍
            $merchants["business_img"] = $domain.$params["business_imgs"];//营业执照1',
            // $merchants["business_img2"] = $domain.$params["business_img2"];//营业执照2',
            // $merchants["business_img3"] = $domain.$params["business_img3"];//营业执照3',
            $merchants["apply_state"] = 2;
            $merchants["pay_state"] = 0;
            $merchants['create_time'] = date("Y-m-d H:i:s");
            $merchants['update_time'] = date("Y-m-d H:i:s");

            $merchants["is_all"] = $params['is_all'];

            //商家经营分类
            $goodclass["class_id"] = $params["goods_class"];
            $where = [];
        } else {
            //用户基础信息修改
            empty($params["username"]) ? true : $data['username'] = $params["username"];
            empty($params["phone"]) ? true : $data["phone"] = $params["phone"];
            // empty($params["live_tag"]) ? true : $data["live_tag"] = $params["live_tag"];
            $data["img"] = empty($params["img"]) ? $domain . "/Public/upload/touxiang/touxiang.png" : $params["img"];
            $data['uptime'] = time();
            //商户扩展信息
            empty($params["merchants_name"]) ? true : $merchants["merchants_name"] = $params["merchants_name"];//店铺名称
            empty($params["contact_name"]) ? true : $merchants["contact_name"] = $params["contact_name"];//联系姓名
            empty($params["contact_mobile"]) ? true : $merchants["contact_mobile"] = $params["contact_mobile"];//联系电话
            empty($params["company_name"]) ? true : $merchants["company_name"] = $params["company_name"];//公司名称
            empty($params["company_mobile"]) ? true : $merchants["company_mobile"] = $params["company_mobile"];//公司电话
            empty($params["merchants_imgs"]) ? true : $merchants["merchants_img"] = $params["merchants_imgs"];//店铺名称
            empty($params["merchants_address"]) ? true : $merchants["merchants_address"] = $params["merchants_address"];//店铺地址
            empty($params["legal_img"]) ? true : $merchants["legal_img"] = $params["legal_img"];//法人照片
            empty($params["legal_face_img"]) ? true : $merchants["legal_face_img"] = $params["legal_face_img"];//身份证正面照
            empty($params["legal_opposite_img"]) ? true : $merchants["legal_opposite_img"] = $params["legal_opposite_img"];//身份证反面照
            empty($params["legal_hand_img"]) ? true : $merchants["legal_hand_img"] = $params["legal_hand_img"];//手持身份证照\
            // empty($params["sell_scale"]) ? true : $merchants["sell_scale"] = $params["sell_scale"];//销售打赏比例
            empty($params["merchants_content"]) ? true : $merchants["merchants_content"] = $params["merchants_content"];//店铺介
            empty($params["business_img"]) ? true : $merchants["business_img"] = $params["business_img"];//营业执照1',
            // empty($params["business_img2"]) ? true : $merchants["business_img2"] = $params["business_img2"];//营业执照2',
            // empty($params["business_img3"]) ? true : $merchants["business_img3"] = $params["business_img3"];//营业执照3',
            //商户经营商品分类
            empty($params["class_id"]) ? true : $goodclass["class_id"] = $params["class_id"];
            $merchants['update_time'] = date("Y-m-d H:i:s");

            $merchants["is_all"] = $params['is_all'];
            
            $action = '编辑';
        }
        file_put_contents('1.txt',json_encode($data),FILE_APPEND);
        $url = session('url');
        if(empty($params["member_id"])){
            $this->startTrans();
            try{
                $member_id = M("user")->add($data);
                $merchants["member_id"] = $member_id;
                $goodclass["member_id"] = $member_id;
                $mres = $this->add($merchants);
                $gres = M("shop_goods_merchants_class")->add($goodclass);
                $this->commit();
                // return success(['info'=>$action.'用户操作成功','url'=>$url]);
                return 'success';
            } catch (\Exception $e) {
                // 回滚事务
                $this->rollback();
                // return error($action.'用户操作失败');
                return 'error';
            }
        }else{
            $mres = M("user")->where(array('user_id'=>$params["member_id"]))->save($data);
            // $this->allowField(true)->save($data,$where);
            $ares = $this->where(["member_id"=>$params["member_id"]])->save($merchants);
            $gres = M("shop_goods_merchants_class")->where(["member_id"=>$params["member_id"]])->save($goodclass);
            if($ares || $mres || $gres){
                // return success(['info'=>$action.'用户操作成功','url'=>$url]);
                return 'success';
            }else{
                // return error($action.'用户操作失败');
                return 'error';
            }
        }
    }

    public function upgrade_merchants($param){
        // $validate = validate('Merchants');
        // $result = $validate->scene('upgrade')->check($param,'');
        // if (!$result) {
        //     error($validate->getError());
        // }
        $param['merchants_img'] = C('IMG_PREFIX').$param['merchants_imgs'];
        $param['legal_img'] = C('IMG_PREFIX').$param['legal_img'];
        $param['legal_face_img'] = C('IMG_PREFIX').$param['legal_face_img'];
        $param['legal_opposite_img'] = C('IMG_PREFIX').$param['legal_opposite_img'];
        $param['legal_hand_img'] = C('IMG_PREFIX').$param['legal_hand_img'];
        $param['business_img'] = C('IMG_PREFIX').$param['business_img'];
        $param['apply_state'] = '2';
        $result = $this->where(["member_id"=>$params["member_id"]])->save($merchants);;
        if($result){
            M('user')->where(['user_id'=>$param['member_id']])->save(['type'=>'2']);
            $url = session('url');
            // return success(['info'=>'用户升级操作成功','url'=>$url]);
            return 'success';
        }else{
            // return error('用户操作失败');
            return 'error';
        }
    }

    /**
     * @param string $where
     * @param string $num
     * @return \think\paginator\Collection
     */

    //根据相关条件查询并分页
    public function queryMember($where = '',$num = ''){
        $list = $this->where($where)->order('intime desc')->paginate($num,false);
        return $list;
    }

    //查询单条会员数据
    public function queryMemberById($id){
        $re = $this->where(['member_id'=>$id])->find();
        return $re;
    }

    /***********************/
	public function getCart($vipid)
	{	
		
		$shop_info = M('shop_set')->field('id,name,isyf,yf')->where("id IN (SELECT CASE WHEN shop_id<1 THEN 1 ELSE shop_id END FROM gll_shop_basket WHERE vipid=$vipid)")->select();
		// dd($shop_info);
		foreach ($shop_info as $k => $v) {
			($v['id']==1) && $shop_info[$k]['id']=0;
			$where = 'c.vipid='.$vipid.' AND g.shop_id='.$shop_info[$k]['id'];
			$goods = $this->get_goods($where);
			foreach ($goods as $key => &$value) {
				$value['pic'] = getPic2($value['pic']);
				if($value['issku']==1) {
					$value['skuinfo']=unserialize($value['skuinfo']);
					$sku= M('shop_goods_sku')->field('skuattr,price,num')->where('id='.$value['sku'])->find();
					$value['sku']=$sku['skuattr'];
					$value['skunum'] = $sku['num'];
					$value['price'] = $sku['price'];

				}
				$value['totalPrice'] = $value['price']*$value['num'];
				($value['sku']!='') && $value['skumsg'] = array_filter(explode(',',$value['sku']));
	

			}
			$shop_info[$k]['goods']=$goods;
		}
		return $shop_info?$shop_info:array();
		
	}

	public function get_goods($where)
	{
		$goods = $this->alias('c')
			->field('c.id,c.vipid,c.goodsid,c.sku,c.num,g.name,g.price,g.pic,g.issku,skuinfo')
			->join('gll_shop_goods g ON g.id=c.goodsid')
			->where($where)->select();
		return $goods;
	}

	public function get_one($where)
	{	
		$good = $this->alias('c')
			->field('c.id,c.vipid,c.goodsid,c.sku,c.num,c.shop_id,g.name,g.price,g.pic,g.issku,skuinfo')
			->join('gll_shop_goods g ON g.id=c.goodsid')
			->where($where)->find();
		return $good;
	}
}
