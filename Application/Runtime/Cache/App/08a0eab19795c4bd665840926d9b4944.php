<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name = "format-detection" content = "telephone=no">
    <title><?php echo ($re["title"]); ?></title>
</head>
<style>
    p{padding: 0;margin: 0;}
    img{width: 100%}
    /*p{font-size:1.5rem}*/
    p img{margin:0}
    body{display: block;margin: 0}
</style>
<body>
<div><?php echo ($re["content"]); ?></div>
</body>
</html>