<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2018060560322687",

		//商户私钥
		'merchant_private_key' => "MIIEuwIBADANBgkqhkiG9w0BAQEFAASCBKUwggShAgEAAoIBAQDOYI83rfmyY4oV+J210yqNszFmxpF4/mYo58ktJrHxKBOlFM5vK4mM8RA07EDYKKACsUqeYw3NaNjbhfzBFpIusLWo0ZWJXye9iCi7oNtrOecNq93OjHWJSYD4NX1stxgPrUNcFC9QZNsV2ItkAicjUdPdB7XPXWVooQLrDgZ672PEOzZbZqfDTUYNhI3Gcuswl/8rZr6nsPSEiFI3FPUTbiyU8TtzvsW/vmyBqSOiCUC1t1IkrSgeqBf7Xsdo8givOHGOJB713SGraaIBDzMbi0dhUTL/YDihboezRg+4999IZvWjRpbBDhrDHKs+pLwN90MHY//lWwR3VX9+CdorAgMBAAECggEAXMXxe9E8n2G50HirxPIBfiOgwJfhC2gpWpgfyqlLcqJWem5pAnaq5e30ICZYXBOfIra6WYsjyEQqwDxyTAaufki30QUuWMuq3LvZu8bq/D/SS0YIdvKTX7zoOiwpjvab3WhBEKKORnCgQCjROIrzNyBwwjrWEzrj/G3tFud+KEKoKgHEGOGp5hXlp6D0BNZhu6kVgSvprLGRcuzJkdVvAdAGazY7ysWNhrDZ83uDwDbNXV/zD7SiQnvTHbvDELLzZmCsBiBj5qRAKQGTzQbPAWgqwiRSzpC1DtDC2WdO8eJbg8uiwX6YR+zocdis0ho8aSad/eLuSCnR7QEoLDr2iQKBgQD0GaMKHu+lhhAo+P8lkax50MJQfzm5UcSmOXhT/DYDeUQNLxKjnnBZt8Bq2n5sIf6lU0GwOp6pbNifh1KNmjF+BwmxCRjFqo2uXHQvyo2heP8rMyTc7WVny8AwEcOG8ZuSwpsdf3qdvG2B1lbkiz/CuhD2EwdK8jgOo2nR30O0BwKBgQDYcCQdlIRmrstWDWYwXGDSzNY4OXIENZ0S+8B0R4x7cxZ5ScwBnlwj2sBrMTQXN4Oyu0w5M19H8zKlkGlD+p3Ib6X+cUfp/9dUQj+WE+ZA2OPAHyGLWtzHk2zuVt/zmu/7PXs4ADFqVS1LNWOoYpuraiuh7KES8Vh8jPY5xOBHvQJ/F9ZpFZPv0zpEWbv3LrQLI9o/H51NBcv2aEU0ev8mRzCQdLkkGNZgImLPZ5/uuKCZPYvj3lHbLLB0dx+/8BQewS/uwlshECyXqW9d6Uzeh+ZJBO75qpmETZ6YJhmV/peZmbtnanoIf17nUsabtbXjhCCnh2BUVf1RfBx5OQWUlwKBgBYUqrqR0kgfgQMQbuJ0KjSXTSuDQMyJI7MyF9pFCmH1xc8t5jAsFb5arNLCvEu6ECeF0CrtwMS4XOxjJToYMUynh0nECNAol7Ey6QXIle77sZCCHIv5AxkhQzW1izdxERaSmSWHb4MnmW1Yzwf4t2TvefAVEgG6uYpLXztZiIAJAoGBALOoNrMnR5096IxuXB1vymJVsNST9KXVMqhoH+Po+colusFSP+rJxRuuk4UBiduKeai0iN3z0oS0jc1PZ//YZCrxe7MVSEC23ypAKKUaWOIh9bG7CUeA28kOnQmd8KeWNTmnkPmtUXChp4q12yH3SsLF0awRq8JcXMXg90fNtjrE",
		
		//异步通知地址
		'notify_url' => "http://tp3shoplive.zhongfeigou.com/app/pingxx/alipayCallback",
		
		//同步跳转
		'return_url' => "http://tp3shoplive.zhongfeigou.com/#/portal/orderList",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAttL9r3/oEoTMnsPSJVKKXlLKHD/wPEPFzbXRdjWb/5kEOmZk+JoCPKq7lJO3dfnVeoroSZuIW6/J8iIeVsjPug8UGgq4MfMkei65q9aM/0f6B/tc+OKokDhae/CeSr1YRiY9DmNKdeUJfb2EZ7ZXPjSPBeXjQovlK1RzFIaUSohFmNF/078hyyQRwwU0L5wovg6FKgJZ2ScTlkJRx4tUNAMA8nmkEqdONcKLnKmTAy3vs0TfQtlZ3ztqTcJPW7sMtisXHOYYsJ+hJ4yoDT27TOyUkXiFbZtNKTTpwgaoqRbNUT/yI+9owSXk+OzMB5lJ5HbLvYSt99peiqApaD1LgQIDAQAB",
);