<?php
 
$redis = new Redis();
 
$redis->connect('127.0.0.1',6379);
 
// $password = '123456';
 
// $redis->auth($password);
 
//list类型出队操作
 
$value = $redis->lpop('mylist');
 
if($value){
 
 echo "出队的值".$value;
 
}else{
 
  echo "出队完成";
 
}
 
?>