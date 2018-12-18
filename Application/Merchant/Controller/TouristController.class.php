<?php

namespace Merchant\Controller;


class TouristController extends CommonController {
	
	function login(){
		
		if ($_SESSION["shop"]["merchants_id"]) {
			$this->redirect("Index/index");
		}
        $this->assign('title',M('System')->getFieldById(1,'title'));
		$this->display();
	}
	function checkLogin(){
		$code = I("checkcode");
		if(!checkCode($code)){
			$this->error("验证码错误",U('Tourist/login'));
		}
		$username = I("username");
		$password = I("password");
		$where["phone"]=$username;
		$where["pwd"]=md5($password);
		$where["type"]=2;
		$where["is_del"]=1;

		$U = D("User");
		$user = $U->where($where)->find();
		if(!$user){
			$this->error("用户名密码不正确",U('Tourist/login'));
		}else{
			$shop = M('shop_merchants')->where(array('member_id'=>$user['user_id'],'is_delete'=>0))->find();
			
			if(!$shop){
				$this->error ( '店铺不存在');
			}else{
				switch ($shop['apply_state']) {
				 	case '0':
						$this->error ( '未认证');
				 		break;
				 	case '1':
						$this->error ( '审核中');
				 		break;
				 	case '3':
						$this->error ( '申请被拒绝');
				 		break;
				 }
			}
		}
		
		session("shop",$shop);
		
		$this->success("登录成功",U('Index/index'));
	}
	public function logout() {
		session ( "shop", null );
		$this->success ( '注销成功！' ,U("Tourist/login"));
	}
	
}