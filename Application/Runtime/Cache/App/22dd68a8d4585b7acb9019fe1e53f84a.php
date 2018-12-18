<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
		<title>商品分享</title>
		<link rel="stylesheet" href="/Public/share/css/reset.css" />
		<link rel="stylesheet" href="/Public/share/css/commodity.css" />
	</head>
	<body>
		<div class="banner">
			<img src="<?php echo ($info["goods_img"]); ?>"/>
			<div class="head">
				<div class="m-head">
					<div class="head-left">品聚轻奢</div>
					<div class="head-right">
						<a href="#" onclick="openApp();">用App打开</a>
					</div>
				</div>
			</div>
			
		</div>
		<div class="details">
			<div class="mdetails">
				<div class="price">￥<?php echo ($info["goods_now_price"]); ?>~<?php echo ($info["goods_origin_price"]); ?></div>
				<div class="name"><?php echo ($info["goods_name"]); ?></div>
				<div class="tishi">付款15天后发货</div>
			</div>
		</div>

		<div class="ts">假一赔十&nbsp;&nbsp;&nbsp;&nbsp;正品保证&nbsp;&nbsp;&nbsp;&nbsp;售后无忧</div>
		
		<div class="mall">
	    	<div class="mmall" onclick="openApp();">
	     		<img src="<?php echo ($info["merchants_img"]); ?>"/>
	     		<div class="mallright">
	      			<p class="mallname"><?php echo ($info["merchants_name"]); ?></p >
	      			<p class="malladdress"><?php echo ($info["merchants_province"]); echo ($info["merchants_city"]); ?></p >
	     		</div>
	    	</div>
	    </div>

		<div class="evaluate-head">
			<div class="ehead-left">评价<span>(<?php echo ($info["comments"]); ?>)</span></div>
			<div class="ehead-right" onclick="openApp();">更多>></div>
		</div>
	
		<?php if(is_array($comment)): $i = 0; $__LIST__ = $comment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="evaluate-list">
				<div class="el-head">
					<div class="elhead-left">
						<?php if($vo["pid"] != 0 ): ?><div class="elname"><?php echo ($vo["username"]); ?> @ <?php echo ($vo["to_name"]); ?></div>
						<?php else: ?>
							<div class="elname"><?php echo ($vo["username"]); ?></div><?php endif; ?>
						
						<ul class="star">
							<?php switch($vo["mark"]): case "1": ?><li><img src="/Public/share/images/star-true.png"</li><?php break;?>
							    <?php case "2": ?><li><img src="/Public/share/images/star-true.png"</li>
									<li><img src="/Public/share/images/star-true.png"</li><?php break;?>
							    <?php case "3": ?><li><img src="/Public/share/images/star-true.png"</li>
									<li><img src="/Public/share/images/star-true.png"</li>
									<li><img src="/Public/share/images/star-true.png"</li><?php break;?>
							    <?php case "4": ?><li><img src="/Public/share/images/star-true.png"</li>
									<li><img src="/Public/share/images/star-true.png"</li>
									<li><img src="/Public/share/images/star-true.png"</li>
									<li><img src="/Public/share/images/star-true.png"</li><?php break;?>
							    <?php case "5": ?><li><img src="/Public/share/images/star-true.png"</li>
									<li><img src="/Public/share/images/star-true.png"</li>
									<li><img src="/Public/share/images/star-true.png"</li>
									<li><img src="/Public/share/images/star-true.png"</li>
									<li><img src="/Public/share/images/star-true.png"</li><?php break;?>
							    <?php default: endswitch;?>
							
							
						</ul>
					</div>
					<div class="elhead-right"><?php echo ($vo["create_time"]); ?></div>
				</div>
				<div class="evaluate-detalis"><?php echo ($vo["comment_desc"]); ?></div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>

		
		<div class="spdetails">
			<div class="details-head">——&nbsp;详情&nbsp;——</div>
				
			<?php echo ($info["goods_detail"]); ?>

		</div>
		<div style='width: 100%; height: 70px;'></div>
		<div class="foot" onclick="openApp();">
			<ul class="foot-left">
				<li>
					<img src="/Public/share/images/icon.png"/>
					<p>店铺</p>
				</li>
				<li>
					<img src="/Public/share/images/news.png"/>
					<p>联系客服</p>
				</li>
				<li>
					<img src="/Public/share/images/heart.png"/>
					<p>收藏</p>
				</li>
			</ul>
			<div class="foot-mid">加入购物车</div>
			<div class="foot-right">立即购买</div>
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

				 window.location = "pinju://tp3shoplive.zhongfeigou.com?type=goods&goodid=<?php echo ($info["goods_id"]); ?>";

				 }else if (navigator.userAgent.match(/android/i)) {

				 var state = null;

				 try {

				 	window.location = "pinju://tp3shoplive.zhongfeigou.com?type=goods&goodid=<?php echo ($info["goods_id"]); ?>";

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