<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
		<title>直播分享</title>
		<link rel="stylesheet" href="/Public/share/css/reset.css" />
		<link rel="stylesheet" href="/Public/share/css/zhibo.css" />
	</head>
	<body>
		<div class="video">
			<!-- <video id="video" controls="" src="<?php echo ($info["src"]); ?>" poster="<?php echo ($info["img"]); ?>" preload="auto" x-webkit-airplay="true" x5-playsinline="true" webkit-playsinline="true" playsinline="true"></video> -->

			 <!-- <video id="video" webkit-playsinline="true" x-webkit-airplay="true"  playsinline="true" x5-video-player-type="h5" x5-video-player-fullscreen="true" width="100%" height="100%" preload="auto" controls="" poster="<?php echo ($info["img"]); ?>" src="<?php echo ($info["src"]); ?>"> </video>-->

			<video id="video" src="<?php echo ($info["src"]); ?>" poster="<?php echo ($info["img"]); ?>" preload="auto" x-webkit-airplay="true" x5-playsinline="true" webkit-playsinline="true" playsinline="true" x5-video-player-type="h5"  x5-video-player-fullscreen="false"></video>

			 

			
			<div class="head">
				<div class="m-head">
					<div class="head-left">品聚轻奢</div>
					<div class="head-right">
						<a href="#" onclick="openApp();">用App打开</a>
					</div>
				</div>
			</div>
			<div class="portrait"><img src="<?php echo ($user["img"]); ?>"/><span><?php echo ($user["username"]); ?></span></div>
			<div class="foot">
				<div class="mfoot" onclick="openApp();">
					<p class="spname">商品<?php echo ($count); ?></p >
					<img src="/Public/share/images/buy.png" class="footimg1"/>
					<input type="text" disabled="disabled" placeholder="跟主播聊点什么？"/>
					<img src="/Public/share/images/gift.png" class="footimg2"/>
					<img src="/Public/share/images/zan.png" class="footimg3"/>
				</div>
			</div>
		</div>
		
		<script type="text/javascript" src="/Public/share/js/jquery.min.js" ></script>
		<script>
			$(function(){
				var hei = $(window).height()
				$('.video').height(hei)
			})
		</script>

		<script>
			
			$('#video').click(function(){
				play()
			})
			function play() {
				var player = document.getElementById("video");
				var time = document.getElementById("time");


				if(player.paused) {
					player.play();

				} else {
					player.pause();

				}
			}

		</script>

		<script>
			
		//打开（下载）App

		function openApp(){

			var ua = window.navigator.userAgent.toLowerCase();

			//微信

			if(ua.match(/MicroMessenger/i) == 'micromessenger'){

				// window.location.href='downLoadForPhone';
				alert('点击右上角，在浏览器打开')

			}else{
			//非微信浏览器

				if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {

				 var loadDateTime = new Date();

				 window.setTimeout(function() {

				 	var timeOutDateTime = new Date();

				 	if (timeOutDateTime - loadDateTime < 5000) {

				 		window.location = "http://itunes.apple.com/cn/app/id1425741783";//ios下载地址

				 	} else {

				 		window.close();

				 	}

				 },2000);

				 window.location = "pinju://tp3shoplive.zhongfeigou.com?type=activity&atype=<?php echo ($info["type"]); ?>&aid=<?php echo ($info["a_id"]); ?>&uid=<?php echo ($info["user_id"]); ?>&liveid=<?php echo ($info["x_id"]); ?>";

				 }else if (navigator.userAgent.match(/android/i)) {

				 var state = null;

				 try {

				 	window.location = "pinju://tp3shoplive.zhongfeigou.com?type=activity&atype=<?php echo ($info["type"]); ?>&aid=<?php echo ($info["a_id"]); ?>&uid=<?php echo ($info["user_id"]); ?>&liveid=<?php echo ($info["x_id"]); ?>";

				 	setTimeout(function(){

							window.location= "http://baidu.com"; //android下载地址

						},500);

				 } catch(e) {}

				 }

			}

		}
		</script>
	</body>
</html>