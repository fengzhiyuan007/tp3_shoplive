<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
<div id="a1" style="width: 1004px;height: 560px;"><?php echo ($l["play_img"]); ?></div>
</body>
</html>
<script type="text/javascript" src="/Public/admin/chplayer/chplayer.js" charset="utf-8"></script>
<script type="text/javascript">
    var videoObject = {
        container: '#a1',
        variable: 'player',
        volume: 0.6, //默认音量，范围是0-1
        poster: "<?php echo ($l["play_img"]); ?>", //封面图片地址
        autoplay: true,
        loop: false,
        live: false, //是否是直播，默认false=点播放，true=直播
        flashplayer: false, //制使用flashplayer
        html5m3u8: true, //是否使用hls，默认不选择，如果此属性设置成true，则不能设置flashplayer:true,
        debug: false, //是否开启调试模式，默认false，不开启
        video: {
            url: "<?php echo ($l["url"]); ?>",
            type: ['video/m3u8','video/mp4']
        }
    };
    var player = new chplayer(videoObject); //实例化播放器
</script>


<!-- <script src="/Public/admin/player/sewise.player.min.js"></script>
<div id="Player" style="width: 1000px;height: 567px;"></div>
<script>
    SewisePlayer.setup({
        server: 'vod',
        type: 'm3u8',
        autostart: 'true',    /*是否自动播放*/
        poster: "<?php echo ($l["play_img"]); ?>",    /*此处可填写封面地址*/
        videourl: "<?php echo ($l["url"]); ?>",    /*此处填写购买获取到的m3u8地址 必填*/
        skin: 'vodOrange',
        title: '<?php echo ($l["title"]); ?>',
        claritybutton: 'disable',
        lang: 'zh_CN'
    },'Player');

</script> -->