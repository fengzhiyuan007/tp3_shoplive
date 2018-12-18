<?php
return array(

	/**
	 * 网站全局配置
	 */
	//'配置项'=>'配置值'
	   'DB_TYPE'=> 'mysql', // 数据库类型
	
		// 'DB_HOST'=>'47.98.37.57',//139.196.178.64
		// //'DB_HOST'=> '192.168.1.2', // 数据库朋务器地址
		// 'DB_NAME'=>'zba', // 数据库名称
		// 'DB_USER'=>'root', // 数据库用户名wz_faker
		// 'DB_PWD'=>'Zha54321', // 数据库密码Wjs575471
		// 'DB_PORT'=>'3306', // 数据库端口
		// 'DB_PREFIX'=>'m_', // 数据表前缀
		// 'DB_CHAESET'=>'utf8',

	   'DB_HOST'=>'118.31.12.195',//139.196.178.64
		//'DB_HOST'=> '192.168.1.2', // 数据库朋务器地址
		'DB_NAME'=>'shoplive', // 数据库名称
		'DB_USER'=>'root', // 数据库用户名wz_faker
		'DB_PWD'=>'Zhengan88', // 数据库密码Wjs575471
		'DB_PORT'=>'3306', // 数据库端口
		'DB_PREFIX'=>'m_', // 数据表前缀
		'DB_CHAESET'=>'utf8',

		/*'DB_CONFIG1' => array(
	    'db_type'  => 'mysql',
        'db_host'  => 'localhost',
	    'db_user'  => 'root',
	    'db_pwd'   => '123456',
	    
	    'db_port'  => '3306',
	    'db_name'  => 'mcbns',
	    ),*/
		
		'MAIL_HOST' =>'smtp.163.com',//smtp服务器的名称
		'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
		'MAIL_USERNAME' =>'mcbntest@163.com',//你的邮箱名
		'MAIL_FROM' =>'mcbntest@163.com',//发件人地址
		'MAIL_FROMNAME'=>'管理员',//发件人姓名
		'MAIL_PASSWORD' =>'abc123',//邮箱密码
		'MAIL_CHARSET' =>'utf-8',//设置邮件编码
		'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件
		'MAIL_SEND_NAME'=>"管理员",//发送者名称
		'MAIL_SEND_TITLE_active'=>"XX网邮箱激活",//发送激活邮件时候的标题
		'MAIL_SEND_TITLE_sendcode'=>"XX网邮件验证码",//发送邮件验证码时候的标题
		'MAIL_SEND_JIANGE'=>"20",//邮件发送间隔，单位秒
		'MAIL_SEND_SHIXIAO'=>"1800",//邮件uuid生效时间
		
	'AUTH_CODE' => 'zheng_an',
	
	'TOKEN_ON'=>false,  
	'HTML_CACHE_ON'     =>  false,
	'HTML_CACHE_TIME'   =>  60,
	'HTML_CACHE_RULES'  =>  array(),
		
	'__PUBLIC__'=>"./Public",	
		
	'URL_MODEL' => 2,
	'URL_HTML_SUFFIX'=>'html',
    // 'IMG_PREFIX'	=> 'http://tp3-shoplive.tstmobile.com'
    'IMG_PREFIX'	=> 'http://tp3shoplive.zhongfeigou.com',
    // 'IMG_PREFIX'	=> 'http://www.pinju.com',
	
    //支付宝相关配置
    'PRIVATEKEY' => 'MIIEuwIBADANBgkqhkiG9w0BAQEFAASCBKUwggShAgEAAoIBAQDOYI83rfmyY4oV+J210yqNszFmxpF4/mYo58ktJrHxKBOlFM5vK4mM8RA07EDYKKACsUqeYw3NaNjbhfzBFpIusLWo0ZWJXye9iCi7oNtrOecNq93OjHWJSYD4NX1stxgPrUNcFC9QZNsV2ItkAicjUdPdB7XPXWVooQLrDgZ672PEOzZbZqfDTUYNhI3Gcuswl/8rZr6nsPSEiFI3FPUTbiyU8TtzvsW/vmyBqSOiCUC1t1IkrSgeqBf7Xsdo8givOHGOJB713SGraaIBDzMbi0dhUTL/YDihboezRg+4999IZvWjRpbBDhrDHKs+pLwN90MHY//lWwR3VX9+CdorAgMBAAECggEAXMXxe9E8n2G50HirxPIBfiOgwJfhC2gpWpgfyqlLcqJWem5pAnaq5e30ICZYXBOfIra6WYsjyEQqwDxyTAaufki30QUuWMuq3LvZu8bq/D/SS0YIdvKTX7zoOiwpjvab3WhBEKKORnCgQCjROIrzNyBwwjrWEzrj/G3tFud+KEKoKgHEGOGp5hXlp6D0BNZhu6kVgSvprLGRcuzJkdVvAdAGazY7ysWNhrDZ83uDwDbNXV/zD7SiQnvTHbvDELLzZmCsBiBj5qRAKQGTzQbPAWgqwiRSzpC1DtDC2WdO8eJbg8uiwX6YR+zocdis0ho8aSad/eLuSCnR7QEoLDr2iQKBgQD0GaMKHu+lhhAo+P8lkax50MJQfzm5UcSmOXhT/DYDeUQNLxKjnnBZt8Bq2n5sIf6lU0GwOp6pbNifh1KNmjF+BwmxCRjFqo2uXHQvyo2heP8rMyTc7WVny8AwEcOG8ZuSwpsdf3qdvG2B1lbkiz/CuhD2EwdK8jgOo2nR30O0BwKBgQDYcCQdlIRmrstWDWYwXGDSzNY4OXIENZ0S+8B0R4x7cxZ5ScwBnlwj2sBrMTQXN4Oyu0w5M19H8zKlkGlD+p3Ib6X+cUfp/9dUQj+WE+ZA2OPAHyGLWtzHk2zuVt/zmu/7PXs4ADFqVS1LNWOoYpuraiuh7KES8Vh8jPY5xOBHvQJ/F9ZpFZPv0zpEWbv3LrQLI9o/H51NBcv2aEU0ev8mRzCQdLkkGNZgImLPZ5/uuKCZPYvj3lHbLLB0dx+/8BQewS/uwlshECyXqW9d6Uzeh+ZJBO75qpmETZ6YJhmV/peZmbtnanoIf17nUsabtbXjhCCnh2BUVf1RfBx5OQWUlwKBgBYUqrqR0kgfgQMQbuJ0KjSXTSuDQMyJI7MyF9pFCmH1xc8t5jAsFb5arNLCvEu6ECeF0CrtwMS4XOxjJToYMUynh0nECNAol7Ey6QXIle77sZCCHIv5AxkhQzW1izdxERaSmSWHb4MnmW1Yzwf4t2TvefAVEgG6uYpLXztZiIAJAoGBALOoNrMnR5096IxuXB1vymJVsNST9KXVMqhoH+Po+colusFSP+rJxRuuk4UBiduKeai0iN3z0oS0jc1PZ//YZCrxe7MVSEC23ypAKKUaWOIh9bG7CUeA28kOnQmd8KeWNTmnkPmtUXChp4q12yH3SsLF0awRq8JcXMXg90fNtjrE',//商户应用私钥
    'PUBLICKEY' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAttL9r3/oEoTMnsPSJVKKXlLKHD/wPEPFzbXRdjWb/5kEOmZk+JoCPKq7lJO3dfnVeoroSZuIW6/J8iIeVsjPug8UGgq4MfMkei65q9aM/0f6B/tc+OKokDhae/CeSr1YRiY9DmNKdeUJfb2EZ7ZXPjSPBeXjQovlK1RzFIaUSohFmNF/078hyyQRwwU0L5wovg6FKgJZ2ScTlkJRx4tUNAMA8nmkEqdONcKLnKmTAy3vs0TfQtlZ3ztqTcJPW7sMtisXHOYYsJ+hJ4yoDT27TOyUkXiFbZtNKTTpwgaoqRbNUT/yI+9owSXk+OzMB5lJ5HbLvYSt99peiqApaD1LgQIDAQAB',//支付宝公钥
    'ALIAPPID' => '2018060560322687',//支付宝APPID

    'OPEN_APPID'=>'wxe7a205b9f444bb24',//wxd14cd141e60046e9
    'OPEN_MCHID'=>'1507374711',//1504947441
    'OPEN_KEY'=>'YouQiZhiBoDianShangYouQi12345678'//TianLanZhiBo1234567890TianLanZhi

);
?>
