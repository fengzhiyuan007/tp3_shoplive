<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<!-- <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" /> -->
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1, user-scalable=no,width=device-width,height=device-height"/>
		<title>小视频</title>
		<link rel="stylesheet" href="/Public/share_video/css/reset.css" />
		<link rel="stylesheet" href="/Public/share_video/css/swiper.min.css" />
		<link rel="stylesheet" href="/Public/share_video/css/video.css" />
	</head>

	<body>
		<div class="video" id="player" style="height:400px">
			
			<video id="video" controls src="<?php echo ($info["url"]); ?>" poster="<?php echo ($info["img"]); ?>" preload="auto" x-webkit-airplay="true" x5-playsinline="true" webkit-playsinline="true" playsinline="true" width="100%" height="100%" style="object-fit:cover" ></video>

			<div class="head">
				<div class="m-head">
					<div class="head-left">品聚轻奢</div>
					<div class="head-right">
						<a href="#" onclick="openApp();">用App打开</a>
					</div>
				</div>
			</div>
			<div class="yin">
				<div class="title"><?php echo ($info["title"]); ?></div>
				<div class="num">
					<img src="<?php echo ($user["img"]); ?>" class="portrait" />
					<div class="name">
						<p class="bigname"><?php echo ($user["username"]); ?></p>
						<div class="playnum"><?php echo ($info["sheng"]); ?>-<?php echo ($info["count"]); ?>次播放</div>
					</div>
				</div>
			</div>
		</div>
		<div class="splist">
			<div class="sptitle">商品：<span><?php echo ($count); ?></span></div>
			
			<div class="swiper-container">
				
				<div class="swiper-wrapper">

					<?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="swiper-slide" onclick="openApp();">
							<div class="listxq1">
								<img src="<?php echo ($vo["goods_img"]); ?>" />
								<p class="intro"><?php echo ($vo["goods_name"]); ?></p>
							</div>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
					
				</div>

			</div>
		</div>
		
	
		<div class="hotvideo">

		   <div class="hottitle">热门小视频</div>
		   <div class="swiper-container">
		    <div class="swiper-wrapper">
		    	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="swiper-slide" onclick="openApp();"><img src="<?php echo ($vo["img"]); ?>" /></div><?php endforeach; endif; else: echo "" ;endif; ?>
		     
		    </div>
		   </div>

		 </div>

		</div>
		<div class="foot">已经到最后了哦，记住我们是品聚</div>
		<script type="text/javascript" src="/Public/share_video/js/jquery.min.js"></script>
		<script type="text/javascript" src="/Public/share_video/js/swiper.min.js"></script>
		<script>
  //       	 function height1(){
	 //            var hei = $(window).height()*0.8
		//         $('.video').height(hei)
		//     }
		    
		// $(function() {
		   
		//     height1()
		// })


		
			// $('#video').click(function() {

			// 	play()
				
				

			// 	if($('#img').css('display') == 'none') {
			// 		$('#img').show()
			// 	} else {
			// 		$('#img').hide()
			// 	}
			// })
			// $('#img').click(function() {
			// 	if($('#img').css('display') == 'none') {
			// 		$('#img').show()
			// 	} else {
			// 		$('#img').hide()
			// 	}
			// 	play()
			// })
			// var audio = document.getElementById("video");
			// audio.loop = false;
			// audio.addEventListener('ended', function() {
			// 	$('#img').show()
			// }, false);

			function play() {
				var player = document.getElementById("video");
				var time = document.getElementById("time");

				if(player.paused) {
					player.play();
					var hei = $(window).height() 
					// $('.video').height(hei)

				} else {
					player.pause();
           			// player.style.height="auto"

				}

			}

		// document.getElementById('player').play = function(e){
		//  var hei = window.screen.availHeight
		//  $('.video').css('height','auto')
		// }

		
        </script>
		<script>
			var swiper = new Swiper('.swiper-container', {
				slidesPerView: 3,
				spaceBetween: 30,
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
			});
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

				 window.location = "pinju://tp3shoplive.zhongfeigou.com?type=activity&atype=<?php echo ($info["type"]); ?>&aid=<?php echo ($info["a_id"]); ?>&uid=<?php echo ($info["user_id"]); ?>&liveid=0";

				 }else if (navigator.userAgent.match(/android/i)) {

				 var state = null;

				 try {

				 	window.location = "pinju://tp3shoplive.zhongfeigou.com?type=activity&atype=<?php echo ($info["type"]); ?>&aid=<?php echo ($info["a_id"]); ?>&uid=<?php echo ($info["user_id"]); ?>&liveid=0";

				 	setTimeout(function(){

							window.location= "http://baidu.com"; //android下载地址

						},500);

				 } catch(e) {}

				 }

			}

		}

		</script>

		<script>
			$('#player').click(function(){
				play()

				// var hei = $(window).height()
 			// 	$('.video').height(hei)

				alert($('.video').height(hei))  

				alert($(window).height())         


// 			 	var div = document.getElementById("video");
// 				var div2 =document.getElementById("player");
//                 var height=div.clientHeight;
//                  div2.style.height=height;

				// $('.splist').toggleClass('toggle')

				console.log($('#player').height())
				// alert($('.toggle').css('marginTop'))
				// alert(111)

			})

			var audioStatus = "paused"; 
			var audio = document.getElementById("video"); 
			audio.addEventListener("playing", function(){ 

				$('#video').css('height','auto')
// 				var div = document.getElementById("video");
// 				var div2 =document.getElementById("player");
//                 var height=div.clientHeight;
//                  div2.style.height=height;
                var hei = $('#video').height()
				$('#player').height(hei) 

				// var hei = $(window).height()
 			// 	$('.video').height(hei)
				// alert(111)

			})
			
			
		</script>
		

	</body>

</html>