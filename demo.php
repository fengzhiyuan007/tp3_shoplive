<?php
 
$redis = new Redis();
 
$redis->connect('127.0.0.1',6379);
 
// $password = '123456';
 
// $redis->auth($password);
 
// $arr = array('a','b','c','d','e','f','g','h','i','j');
 
// foreach($arr as $k=>$v){
 
//   $redis->rpush("eng",$v);
 
// }

// $arr = array(
// 	   4 => serialize(array('1','2')),
// 	   5 => serialize(array('3','4')),
// 	   6 => serialize(array('5','6')),
// 	   7 => serialize(array('7','8')),
// 	);
// foreach($arr as $k=>$v){
 
//   $redis->rpush("number",$v);
 
// }

$list = $redis->lrange('notice', 0, -1);
print_r($list);

// $a = unserialize("a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}");
// print_r($a);
   