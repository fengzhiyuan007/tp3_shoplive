<?php

namespace Merchant\Controller;


class SessionController extends CommonController {
	// function _initialize() {
	// 	if (empty(session('shop'))) {
	// 		if (IS_AJAX&&I("ajax")==1) {
	// 			$this->ajaxReturn ( array (
	// 					'sta' => 0,
	// 					'msg' => '请先登录'
	// 			) );
	// 		} else {
	// 			$this->redirect('Tourist/login');
	// 			header('Location: Merchant/Tourist/login');
	// 		}
	// 	}
	// }

	public function _first() {
		if (empty($_SESSION['shop'])) {
			if (IS_AJAX&&I("ajax")==1) {
				$this->ajaxReturn ( array (
						'sta' => 0,
						'msg' => '请先登录'
				) );
			} else {
				//$this->error ( "请先登录",U("Tourist/login") );
				$this->redirect('Tourist/login');
				// header('Location: Merchant/Tourist/login');
			}
		}
		
		/*if(C("quanxian")&&!hasQuanxian()){
			
			if (IS_AJAX||I("ajax")==1){
				$msg["sta"]=2;
				$msg["msg"]="没有权限";
				$this->ajaxReturn($msg);
			}else{
				$this->redirect("Tourist/error");
			}
		}
		*/
		
		
	}
	/*public function index() {
		
		$this->display ();
	}*/
}