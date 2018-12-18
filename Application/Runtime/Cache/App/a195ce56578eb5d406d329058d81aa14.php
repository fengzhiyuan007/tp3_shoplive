<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
		<title>文章分享</title>
		<link rel="stylesheet" href="/Public/share/css/reset.css" />
		<link rel="stylesheet" href="/Public/share/css/article.css" />
	</head>
	<body>
		<div class="banner">
			<img src="<?php echo ($info["img"]); ?>"/>
			<div class="head">
				<div class="m-head">
					<div class="head-left">品聚轻奢</div>
					<div class="head-right">
						<a href="#" onclick="openApp();">用App打开</a>
					</div>
				</div>
			</div>
			
		</div>
		<div class="intro">
			<div class="mintro">
				<div class="intro-left">
					<img src="<?php echo ($user["img"]); ?>"/>
					<span><?php echo ($user["username"]); ?></span>
				</div>
				<div class="intro-right" onclick="openApp();"><span>关注</span></div>
			</div>
		</div>
		<hr style="margin-top: -5px" />

		<div class="title">
			<div class="title-left">
				<?php echo ($info["title"]); ?>
			</div>

			<div class="title-right" onclick="openApp();"><p class="buyzi">商品<?php echo ($count); ?></p ><img src="/Public/share/images/buy.png" /></div>
		</div>

		<div class="details">
			<?php echo ($info["detail"]); ?>
		</div>
		<div class="evaluate-head">
			<div class="ehead-left">评价<span>(<?php echo ($info["comments"]); ?>)</span></div>
			<div class="ehead-right" onclick="openApp();">更多>></div>
		</div>

		<?php if(is_array($comment)): $i = 0; $__LIST__ = $comment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="evaluate-list">
				<div class="el-head">
					<div class="elhead-left">
						<?php if($vo["type"] == 2 ): ?><div class="elname"><?php echo ($vo["username"]); ?> @ <?php echo ($vo["to_name"]); ?></div>
						<?php else: ?>
							<div class="elname"><?php echo ($vo["username"]); ?></div><?php endif; ?>

						<ul class="star">
							<li><img src="/Public/share/images/star-true.png"</li>
							<li><img src="/Public/share/images/star-true.png"</li>
							<li><img src="/Public/share/images/star-true.png"</li>
							<li><img src="/Public/share/images/star-true.png"</li>
						</ul>
					</div>
					<div class="elhead-right"><?php echo (date("Y-m-d",$vo["intime"])); ?></div>
				</div>
				<div class="evaluate-detalis"><?php echo ($vo["content"]); ?></div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>

		
		
		<div style="width: 100%; height: 40px;"></div>
		<div class="foot">
			<div class="mfoot" onclick="openApp();">
				<div class="collect"><?php echo ($info["collect"]); ?></div>
				<div class="txt"><?php echo ($info["comments"]); ?></div>
				<div class="zan"><?php echo ($info["zan"]); ?></div>
			</div>
		</div>

		<script type="text/javascript" src="/Public/share/js/jquery.min.js" ></script>

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

				 window.location = "pinju://tp3shoplive.zhongfeigou.com?type=activity&atype=6&aid=<?php echo ($info["a_id"]); ?>&uid=<?php echo ($info["user_id"]); ?>&liveid=0";

				 }else if (navigator.userAgent.match(/android/i)) {

				 var state = null;

				 try {

				 	window.location = "pinju://tp3shoplive.zhongfeigou.com?type=activity&atype=6&aid=<?php echo ($info["a_id"]); ?>&uid=<?php echo ($info["user_id"]); ?>&liveid=0";

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