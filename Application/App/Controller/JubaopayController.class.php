<?php
namespace App\Controller;
use Think\Controller;
vendor('php-demo.jubaopay.jubaopay');
// include("jubaopay.php");
class JubaopayController
{
	//生成订单
	public function create_order(){
        $user = checklogin();
        $price_id = I('price_id');
		$price = M('Price')->where(['price_id'=>$price_id])->find();
		if ($price){
            $meters = $price['meters']+$price['give'];  //钻石
        }else{
            error('价格未知错误!');
        }
        $amount = $price['price'];
        $type = I('type');
        if(!$type){
            $type="jby";
        }
        (empty($amount) || $amount==0 || $meters==0) ? error('参数错误!') : true;
        $pay_number = date('YmdHis').rand(100,999);
        $result = M('Recharge_record')->add(array('user_id'=>$user['user_id'],'pay_number'=>$pay_number,'amount'=>$amount,'meters'=>$meters,'pay_on'=>'','pay_return'=>'','pay_type'=>$type,'intime'=>time()));
        if($result){
            success(['pay_number'=>$pay_number,'amount'=>$amount]);
        }else{
        	error('生成订单失败');
        }
	}

	public function callback(){

		//此参数为传入的签名和信息
		$message = $_POST['message'];
		$signature = $_POST['signature'];
		
		$tt = "\n\n" . date("Y-m-d H:i:s", time()) . "\n" . var_export($_POST, true);
        file_put_contents("demo.txt", $tt, FILE_APPEND);

		$jubaopay=new \jubaopay();
		$jubaopay->decrypt($message);
		// 校验签名，然后进行业务处理
		$result=$jubaopay->verify($signature);

        file_put_contents("demo.txt", $result, FILE_APPEND);

		if($result == 1) {
			$data['payid'] = $jubaopay->getEncrypt("payid"); //订单号
			$data['mobile'] = $jubaopay->getEncrypt("mobile"); //手机
			$data['amount'] = $jubaopay->getEncrypt("amount");
			$data['remark'] = $jubaopay->getEncrypt("remark");
			$data['orderNo'] = $jubaopay->getEncrypt("orderNo");
			$data['state']= $jubaopay->getEncrypt("state");
			$data['modifyTime'] = $jubaopay->getEncrypt("modifyTime");
			$data['partnerid'] = $jubaopay->getEncrypt("partnerid");
			$data['realReceive'] = $jubaopay->getEncrypt("realReceive");

			$return = json_encode($data);
			
			//用户加钻石
			$record = M('Recharge_record')->where(array('pay_number'=>$data['payid']))->field('user_id,meters')->find();

            $t = "\n\n" . date("Y-m-d H:i:s", time()) . "\n" . var_export($data, true);
        	file_put_contents("demo.txt", $t, FILE_APPEND);

			if($data['state'] == '2'){
            	file_put_contents("demo.txt", '222', FILE_APPEND);

				//入库
				M('Recharge_record')->where(array('pay_number'=>$data['payid']))->save(array('pay_on'=>$data['orderNo'],'pay_return'=>$return,'uptime'=>time()));
				M('user')->where(array('user_id'=>$record['user_id']))->setInc('money',$record['meters']);
				M('Order')->add($data);
				echo "success";
			}
			
		}else{
			echo "verify failed";
		}
		
	}

	public function index(){
		
		$jubaopay = new \jubaopay();
		echo "111";
		var_dump($jubaopay);
		$c = $jubaopay->decrypt('IM+dU0KqeOukjmVZQcs4AUCpT3qC9jpM945lHwaH0nfHU7wzJGHQO5rwxUOfcvzf9KKu60Q5bXb0v8rX3msLF5OCwie+wT5WlIOKtUkbroROGyq09c+UM6ZbVv3WgRmKLfNoFsFDCbm5j/PyY6OWzowyO13Qw70AkaTrc7YeEvU=y8PvDkwjPz4kvuCG3CqXWpRtrQB2DxTqXnwMRPV65w2xukdSepZOn/1Wb53SYEnMnDf6f6IImiPS9MQlE1zEIptXIHmRuciEmk+Aw2BoQcSFrcsZ+JAsxLAlL4sU9zFVI0oRGkxcekzseXEwlQc03xu62GGtfEka99IOnBYmQ/k=2dZ/NFAhLOAo0kjzNJkBSvOoJte/pB+LnpRzDY+fUaMq7SMX/+wNSJT69IDd2NSX9rHvren9KW9/d8kfqnkhc2ZPm61QG9AuOMk6LHkOkiFifE3Nro9otagYcW08rilAl3tSjl1b42vTL4gwKuWDAURFgI97uXQAO48Y6HadOeq4D2ppdvqiZ34Cb3PXCxZLXw9L2lWjHsUMTvImbNBUtckeg7voMPi4v5iNTnXUgyz0uyL5g2Ad7lWTKRXAahYfYRrAMXDnm8BLhruG6sHRFthui2HqbLY1qw2vTKrWnBvPPslVtR01/vKEVkv9cLVBjnJ+vN2vDpAnSSOWFhdvWxFEw/a4s/X97n3Wy9zj5ra3RoN0lit01skRt7iZp7+KqC/LrrxwyxCOBUCZYqjUwg==');
		$result=$jubaopay->verify('WisEoJ4gh3+6Zn6jIXDR/pRfFQl5xrD/noVuHdGrb+KEHEqmYF+/gKTVntA7H6A1WaqEA1TYOrDrY+6FgaUcNVS0E2To8WzoEFYpZwXvIjbAJbh64ebTfpAMZVOR3kteqg3OfqyDt3Qc0+6Zfy/gzfPst8Ed4AO2pzHC0bTU6rM=');
		$payid = $jubaopay->getEncrypt("payid");
		// $b = $jubaopay->generateRandomString();
		// $r = new \RSA();
		// $c = $r->aaa();
		// var_dump($jubaopay);echo "<br/>";
		var_dump($c);
		var_dump($result);
		var_dump($payid);
	}

	
}