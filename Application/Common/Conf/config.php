<?php
$array = array(
	//'配置项'=>'配置值'
		'MODULE_ALLOW_LIST'    =>    array('Home','Admin','App','Merchant'),
		'DEFAULT_MODULE'       =>    'Home',
);
$Global = require './Conf/Global_config.php';
$temp = array_merge($Global,$array);
return array_merge($temp);
?>
