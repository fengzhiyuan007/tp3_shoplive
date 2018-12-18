<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2017122501192470",

		//商户私钥
		'merchant_private_key' => "MIIEogIBAAKCAQEAz6kNiA2zMPiO3n0ggfiZLCHL/uWnuGMa92b9a4GyE6wVElmQu2orIo1UbUJwNZvHcsxVYrM17R2URhGeCX0YrMUMjcMC0eOqQQnx1Q3a5h9md7EszVusl4+lUBOt1Vi0wOOhlAf/fAdQLytA1VlTL5XNHr4n0hTY3W2iWOe7YYFYUXUycVQKrhf0U3OoihURmp8z1RnYFuKodV2T/0bVfkPNW1wvVJ2kXzXzZnw6mGhrFZSr9snmvOW4E5u1RlmWHiT91Zh11SF+sXCXRHTGyb6rpKMfS7K9Yyqcf1rQBsVs++MADRg7kibQ/si+8OIwPy+1y0W3j/GvAjyE08Y5LwIDAQABAoIBAAwXY9pQMebgEjGSR5pJx2FydlZZOPLbkm5laMwhuSS8GF4BKRRAklJouEnEXJRChdKBY1dj5/fuiPurevBCgHVO4/Q9LqTaBMfUtGgbbmuH2IePoXQzqlEI5C9Ndgm+KIgyuO3NqWqnYlvcwOGrWdSjfFYV7GunGxmJkLJsi9SZgHz7UMS6YIhLd53mNFrXRKFdskjzcdHi+zyCnB7f6RDNHbhFbqjEtLXjWiRajkd3FE9wldWzVjfiPUjU41UU6yy04cjws2H3qggxrBfagBSJ4Mem2whqfNbUPCRI3/W2QRb/H1TspVD+xEjqFEOnMhVOdR2uwzY6hA2WkbjMKYECgYEA/G8ijp5ENOkwpRTSh9hOknap0uA25kufB+i7NqiEvKZKgalIz65CAfYtbSqKkSX5fnIhVSMXElQgRUzfMUzeIKusXfRvQH/wWMhSf4uzSOgoxFJf+jZWsYwh6nJ8UoPT1TGMVTSPbvp30rtkHp/g0Xro4NZLNpZxJBVaCeL7sGkCgYEA0pgBNt+7OOCLAVVRApHeJXiZXDeWjIoAu/RcBCYvldgYhdVJHTil3c7/73HVk9gLYkW9DFelJk5xYNwO4tYLRhwPiPK0dQUFaHgqJhwjLF6AnbFHy4FmbW3FaQahBezKfsAgkvXJDSc970HkjBMN3ajejUy8MCL6wR+xsB16adcCgYB5o6PnTWRYirWiFrKMOzNBaGTU9K3/sxji2sa7w+CSdx8X89beHH46K8IgBIvY/Y+H2r8tI0eO0XLrcetq+jtfSto4O/0P+5Z5ca4vP8YYr6ZVU8xj6aNE0t3U923o5RVCeinBNR6Yv6DVru7Dww62Yp+tGBYOK9hBJvjIItRdYQKBgDIRO3CtXliWYdXuT7U5ssPb2TIocR12jdghr2K5JWUNnD7tR1WwKxcB6K0ntixRF9vEUr7Fc5kY2zG4/70EQGfpsfPQKAEOMYv1zaeD1wTsbs2O4U/LsutfRqjCj7PV6QqbaOMnliYPZ1UjqE95FDnXtRmI3dDf8BfMDjWdvIW/AoGAYDBvoYQiBZej1+/cwOC2cioHhqIwz2V89wBMRi3XoTsyTKYYLDHqJBqu1BQNcyrNof1uX45zTDE0Zgsx6uksAYz/Udof/92rqJS7PEpDf2IWdzXiZJaMDDhgHi8CP2qP+K+n1s3cxnUR3OtGDQfyXCIQCiXE0CTPmgAnRPLeY5A=",
		
		//异步通知地址
		'notify_url' => "http://www.zhongfeigou.com/api/pingxx/alipayCallback",
		
		//同步跳转
		'return_url' => "http://www.zhongfeigou.com",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxvpS5RFswbksxkRbAx5Qark/A4l40Aab53hFUYJUSqlnZNrMEwIM0SODjIGSu0taXQXrTmqi1hyj6+6RxVETZScES9YEd+ghhECQe26ZkYTBQTR6ff/oiDkUUqN8TO1amNXZJnaFCJKay+CS+d/SunsH0uEwJ4BbqyVqZ9A+xec7Af9kO+H7WMpcQ3q7KwHXsHcFAJUKQWZpeY7SGjstooWh0q533Hkl+4R0Ik08ma4QI0Ipv7ogJEHigCVmcjtmf1Hg3+wOUqDnwKvnsAqFOAL5J1m6ZEhP0riNmSGbkL5Q10I1sKkHw3D3yQ7LPjCYodvsLv6wRsLoOtM7vDPq0QIDAQAB",
);