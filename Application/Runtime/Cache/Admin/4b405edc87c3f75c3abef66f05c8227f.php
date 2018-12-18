<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>BLUSECMS</title>

<meta name="GENERATOR" content="MCBN">


<link rel="stylesheet" type="text/css" href="/Public/admin/css/base.css" />
<link rel="stylesheet" type="text/css" href="/Public/admin/css/H-ui.min.css" />

<link rel="stylesheet" type="text/css" href="/Public/admin/css/style.css" />
<link rel="stylesheet" type="text/css" href="/Public/common/mypage.css" /><!-- 分页样式css -->

<script type="text/javascript" src="/Public/admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/common/js/zczy-UI.js"></script>
<script type="text/javascript" src="/Public/admin/js/common.js"></script>
<script type="text/javascript" src="/Public/common/kindeditor/kindeditor.js"></script>

	<link rel="stylesheet" type="text/css" href="/Public/layui/css/layui.css" />
	<script type="text/javascript" src="/Public/layui/layui.js"></script>

	<script type="text/javascript" src="/Public/admin/layer/layer.js"></script>

	<script src="/Public/admin/player/sewise.player.min.js"></script>


<link href="/Public/home/css/qikoo.css" type="text/css" rel="stylesheet" />
<link href="/Public/home/css/store.css" type="text/css" rel="stylesheet" />

<!--升级后台框架-->
<link href="/Public/h-ui/css/H-ui.min.css" type="text/css" rel="stylesheet" />
<link href="/Public/h-ui.admin/css/H-ui.admin.css" type="text/css" rel="stylesheet" />
<link href="/Public/Hui-iconfont/1.0.7/iconfont.css" type="text/css" rel="stylesheet" />
<link href="/Public/h-ui.admin/skin/default/skin.css" type="text/css" rel="stylesheet" />
<link href="/Public/h-ui.admin/css/style.css" type="text/css" rel="stylesheet" />

<script type="text/javascript" src="/Public/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/Public/h-ui.admin/js/H-ui.admin.js"></script>

<!--升级后台框架-->

<script type="text/javascript" src="/Public/home/js/qikoo.js"></script>

<script type="text/javascript" charset="utf-8" src="/Public/admin/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/admin/js/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/admin/js/ueditor/lang/zh-cn/zh-cn.js"></script>

<script type="text/javascript">
    var editor = new UE.ui.Editor();
    $(document).keydown(function(event){
          switch(event.keyCode){
             case 13:return false; 
             }
      });
</script>

</head>
<body>
	

	<TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
		<TBODY>
			<TR>
				<TD vAlign=top background="/Public/admin/images/mail_leftbg.gif"
					width="17"><IMG
					src="/Public/admin/images/left-top-right.gif" width="17"
					height="29"></TD>
				<TD vAlign="top" background="/Public/admin/images/content-bg.gif">
					<TABLE id="table2" class="left_topbg" border="0" cellSpacing="0"
						cellPadding="0" width="100%" height="31">
						<TBODY>
							<TR>
								<TD height="31">
									<DIV class="titlebt">

										<?php if($pagetitle == ''): ?>系统基本信息 <?php else: ?>
										<?php echo ($pagetitle); endif; ?>

									</DIV>
								</TD>
							</TR>
						</TBODY>
					</TABLE>
				</TD>
				<TD vAlign="top"
					background="/Public/admin/images/mail_rightbg.gif" width="16">
					<IMG src="/Public/admin/images/nav-right-bg.gif" width="16"
					height="29">
				</TD>
			</TR>
			<TR>
				<TD vAlign="center"
					background="/Public/admin/images/mail_leftbg.gif">&nbsp;</TD>
				<TD align="left" vAlign="top" bgColor="#f7f8f9">


<style>
	.ibutton { padding: 3px 15px; *padding: 0 15px; *height: 24px;  font-size: 12px; text-align: center; text-shadow: #CF510B 0 1px 0; border:1px solid #ec5c0d; border-radius: 2px; background: #FC750A; background-image: -webkit-linear-gradient(top, #fc8746, #ec5d0e); color:#FFF; cursor: pointer; display: inline-block; }
	/*a  upload */
	.a-upload {
		padding: 4px 10px;
		/*height: 20px;*/
		line-height: 20px;
		position: relative;
		cursor: pointer;
		color: #888;
		background: #fafafa;
		border: 1px solid #ddd;
		border-radius: 4px;
		overflow: hidden;
		display: inline-block;
		*display: inline;
		*zoom: 1
	}

	.a-upload  input {
		position: absolute;
		font-size: 100px;
		right: 0;
		top: 0;
		opacity: 0;
		filter: alpha(opacity=0);
		cursor: pointer
	}

	.a-upload:hover {
		color: #444;
		background: #eee;
		border-color: #ccc;
		text-decoration: none
	}
	*{ margin:0px; padding:0px; font-family:Microsoft Yahei; box-sizing:border-box; -webkit-box-sizing:border-box;}
	.ul_pics{ float:left;}
	.ul_pics li{float:left; margin:0px; padding:0px; margin-left:5px; margin-top:5px; position:relative; list-style-type:none; border:1px solid #eee;}
	.ul_pics li img{width:80px;height:80px;}
	.ul_pics li i{ position:absolute; top:0px; right:-1px; background:red; cursor:pointer; font-style:normal; font-size:10px; width:14px;
		height:14px; text-align:center; line-height:12px; color:#fff;}
	.progress{position:relative;  background:#eee;height:15px;line-height:15px;}
	.bar {background-color: green; display:block; width:0%; height:15px; }
	.percent{ height:15px;  text-align:center;  left:0px; color:#666; line-height:15px; font-size:12px; }
</style>
	<div id="big"></div>
	<div id="big2"></div>
	<form class="form form-horizontal" action="<?php echo U('edit_video');?>" id="form" method="post">
		<!-- <div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>视频标题：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="title" class="input-text" value="<?php echo ($re['title']); ?>" placeholder="视频标题" id="title" />
			</div>
		</div> -->
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">图片：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<div class="droparea spot" id="image1" style="background-image: url('<?php echo ($re['img_url']); ?>');background-size: 220px 160px;" >
					<div class="instructions" onclick="del_image('1')">删除</div>
					<div id="uparea1"></div>
					<input type="hidden" name="con" id="content" value="" />
					<input type="hidden" name="img_url" id="image_1" value="<?php echo ($re['img_url']); ?>" />
					<div class="instructions" style="top: 135px;color: red;">建议尺寸750*350,图片小于2M</div>
				</div>
			</div>
		</div>
		<div id="upload" class="row cl">
			<label class="form-label col-xs-4 col-sm-2">视频：</label>
			<div  class="formControls col-xs-8 col-sm-9">
				<div href="javascript:void(0);" class="a-upload" rel="external nofollow" id="btn">
				<!--<input name="video" value="" id="video" type="file" accept="video/*"><?php echo ($_GET['id']?'点击这里更换视频':'点击这里上传视频'); ?>-->
					<!-- <?php echo ($uid?'点击这里更换视频':'点击这里上传视频'); ?> -->
					<?php if( $_GET['id'] != '' ): ?>点击这里更换视频<?php else: ?>点击这里上传视频<?php endif; ?>
				</div>
				<input name="url" type="hidden" id="url" value="<?php echo ($re['url']); ?>" />
				<san>建议上传mp4格式，大小不要超过700M</san>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"></label>
			<div  class="formControls col-xs-8 col-sm-9">
				<ul id="ul_pics" class="ul_pics clearfix">
				</ul>
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>会员：</label>
			<div  class="formControls col-xs-8 col-sm-9">
				<span class="select-box" style="width: 55%">
					<select id="user" name="user_id" class="select">
						<?php if(is_array($user)): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["user_id"]); ?>" <?php if($vo['user_id'] == $re['user_id']): ?>selected<?php else: endif; ?>><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</span>
				<input type="text"  class="input-text" style="width: 30%" value="" placeholder="会员名"  />
				<button type="button" onclick="searchUser($(this))" class="btn btn-success radius"  name=""><i class="Hui-iconfont">&#xe665;</i> 搜索 </button>
			</div>
		</div>

		<div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">标签：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <?php if(is_array($tag)): $k = 0; $__LIST__ = $tag;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><input name="tag[]" type="checkbox" <?php if($k > 1): ?>style="margin-top:1px;margin-left:10px;"<?php else: ?>style="margin-top:1px;"<?php endif; ?> <?php if(in_array($vo['name'],$tagids)): ?>checked<?php endif; ?> value="<?php echo ($vo['name']); ?>"><span style="margin-left: 5px;"><?php echo ($vo["name"]); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">简介：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="content"  oninput="textCounter(this,200)" onPropertyChange="textCounter(this,200)" style="width:100%;height:80px;" value="<?php echo ($re['content']); ?>" placeholder="请填写视频简介"><?php echo ($re['content']); ?></textarea>
				&nbsp;<span class="important">*</span>限定200字
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button  class="submit btn btn-primary radius"  type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
				<!--<button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>-->
				<button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
				<input type="hidden" class="input-text" value="<?php echo ($re["id"]); ?>" placeholder=""  name="id">
			</div>
		</div>
	</form>
</div>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/admin/plupload/js/moxie.js"></script>
<!--<script type="text/javascript" src="/assets/js/plupload/js/plupload.dev.js"></script>-->
<script type="text/javascript" src="https://cdn.staticfile.org/plupload/2.1.5/plupload.min.js"></script>
<script type="text/javascript" src="/Public/admin/plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="/Public/admin/qiniu-js-sdk/dist/qiniu.js"></script>
<script type="text/javascript">
		var  content ;
		KindEditor.ready(function(K) {
			content = K.create('#content',{
				allowFileManager : true,
				uploadJson:"<?php echo U('Common/upload');?>"
			});
		});

		KindEditor.ready(function(K) {
			K.create();
			var editor = K.editor({
				allowFileManager : true,
				uploadJson:"<?php echo U('Common/upload');?>"
				//sdl:false
			});
			K('#uparea1').click(function() {
				editor.loadPlugin('image', function() {
					editor.plugin.imageDialog({
						imageUrl : K('#image_1').val(),
						clickFn : function(url, title, width, height, border, align) {
							console.log(url);
							$('#image1').css('background-image','url('+url+')').css('background-size','220px 160px');
							K('#image_1').val(url);
							// K('#getImgUrl').val(url);
							editor.hideDialog();
						}
					});
				});
			});

		});


		$("#uparea1").mouseover(function(e){
			$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			var img = $('#image_1').val();
			if(img.length !== 0) {
				$("#big").html('<img src="' + $('#image_1').val() + '" width=380 height=300>');
				$("#big").show();        //show：显示
			}
		});
		$("#uparea1").mouseout(function(){
			$("#big").hide();
		});

//		$("#video").change(function(){
//			var index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
//			var formData = new FormData();
//			formData.append("video", $('#video')[0].files[0]);
//			$.ajax({
//				url: "<?php echo U('Tools/upload_video');?>" ,
//				type: 'POST',
//				data: formData,
//				async: true,
//				cache: false,
//				contentType: false,
//				processData: false,
//				dataType:"JSON",
//				success: function (data) {
//				    console.log(data);
//					layer.close(index);
//					if(data['status'] == 'ok'){
//						$('#url').val(data['url']);
//						$('.url').html('上传成功！');
//					}else{
//						$('.url').html(data['info']);
//					}
//				},
//				error: function (data) {
//					console.log(data);
//				}
//			});
//		});

		$(".preview").mouseover(function(e){
			$("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			var data = $(this).attr('data');
			console.log(data);
			var img = $('#preview_'+data).val();
			if(img.length !== 0) {
				$("#big").html('<img src="' + img + '" width=380 height=300>');
				$("#big").show();        //show：显示
			}
		});
		$(".preview").mouseout(function(){
			$("#big").hide();
		});

		$(".pic3").mouseover(function(e){
			$("#big2").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
			$("#big2").html('<img src="'+this.src+'" width=380 height=300>');
			$("#big2").show();        //show：显示
		});
		$(".pic3").mouseout(function(){
			$("#big2").hide();
		});
	function area_linke1(value){
		$.post("<?php echo U('get_area');?>", {value:value,type:1}, function(v){

			$("#shi").html(v);

		});
	}
	function area_linke2(value){
		$.post("<?php echo U('get_area');?>", {value:value,type:2}, function(v){

			$("#qu").html(v);

		});
	}

    function textCounter(field, maxlimit) {
        var num = $(field).val();
        if(num.length > maxlimit){
            $(field).val(num.substring(0,maxlimit));
        }
    }

    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',    //上传模式,依次退化
        browse_button: 'btn',       //上传选择的点选按钮，**必需**
        uptoken_url: "<?php echo U('Index/get_qiniu_token');?>",            //Ajax请求upToken的Url，**强烈建议设置**（服务端提供）
        // uptoken : '', //若未指定uptoken_url,则必须指定 uptoken ,uptoken由其他程序生成
        // unique_names: true, // 默认 false，key为文件名。若开启该选项，SDK为自动生成上传成功后的key（文件名）。
        // save_key: true,   // 默认 false。若在服务端生成uptoken的上传策略中指定了 `sava_key`，则开启，SDK会忽略对key的处理
        // domain: 'http://msplay.qqyswh.com',   //bucket 域名，下载资源时用到，**必需**
        domain: 'http://dspxplay.tstmobile.com',   //bucket 域名，下载资源时用到，**必需**
        get_new_uptoken: false,  //设置上传文件的时候是否每次都重新获取新的token
        container: 'upload',           //上传区域DOM ID，默认是browser_button的父元素，
        max_file_size: '1000mb',           //最大文件体积限制
        flash_swf_url: '/Public/admin/plupload/js/Moxie.swf',  //引入flash,相对路径
        silverlight_xap_url: "/Public/admin/plupload/js/Moxie.xap",
        max_retries: 3,                   //上传失败最大重试次数
        dragdrop: true,                   //开启可拖曳上传
        drop_element: 'upload',        //拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
        unique_names: true,
        chunk_size: '4mb',                //分块上传时，每片的体积
        auto_start: true,                 //选择文件后自动上传，若关闭需要自己绑定事件触发上传
        filters: {
            mime_types : [
                {title : "Image files", extensions: "mp4,3gp,mp3,flv,avi,m3u8"}
            ]
        },
        init: {
            'FilesAdded': function(up, files) {
                //do something
                if ($("#ul_pics").children("li").length > 0) {
                    alert("您上传的内容太多了！");
                    uploader.destroy();
                } else {
                    var li = '';
                    plupload.each(files, function(file) { //遍历文件
                        li += "<li id='" + file['id'] + "'><div class='progress'><span class='bar'></span></div><div class='percent'>上传中 0%</div></li>";
                    });
                    $("#ul_pics").append(li);
                    uploader.start();
                }
            },
            'BeforeUpload': function(up, file) {
                //do something
            },
            'UploadProgress': function(up, file) {
                //可以在这里控制上传进度的显示
                //可参考七牛的例子
                var percent = file.percent;
                $("#" + file.id).find('.bar').css({"width": percent + "%"});
                $("#" + file.id).find(".percent").text("上传中 "+percent + "%");
            },
            'UploadComplete': function() {
                //do something
            },
            'FileUploaded': function(up, file, info) {
                var str = $.parseJSON(info.response);
                console.log(str);
                console.log(str.key);
                $('#url').val(str.key);
                //每个文件上传成功后,处理相关的事情
                //其中 info 是文件上传成功后，服务端返回的json，形式如
                //{
                //  "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                //  "key": "gogopher.jpg"
                //}
//                var domain = up.getOption('domain');
//                var res = eval('(' + info + ')');
//                var sourceLink = domain + res.key;//获取上传文件的链接地址
                //do something
            },
            'Error': function(up, err, errTip) {
                alert(errTip);
            },
            'Key': function(up, file) {
                //当save_key和unique_names设为false时，该方法将被调用
                var key = "";
                $.ajax({
                    url: '/qiniu-token/get-key/',
                    type: 'GET',
                    async: false,//这里应设置为同步的方式
                    success: function(data) {
                        var ext = Qiniu.getFileExtension(file.name);
                        key = data + '.' + ext;
                    },
                    cache: false
                });
                return key;
            }
        }
    });

    function searchUser(v){
        var name = $(v).prev('input').val();
        var url  = "<?php echo U('searchUser');?>";
        $.post(url,{name:name},function(data){
			console.log(data);
        	
            $('#user').html(data);
        })
    }
 //    window.onload = function() {
	//     searchUser();//直接执行onclick中的函数就行
	// }
</script>
    
    
    
    
    </TD><TD background="/Public/admin/images/mail_rightbg.gif">&nbsp;</TD>
</TR>
<TR>
    <TD vAlign="bottom" background="/Public/admin/images/mail_leftbg.gif">
    <IMG src="/Public/admin/images/buttom_left2.gif" width="17" height="17"></TD>
    <TD background="/Public/admin/images/buttom_bgs.gif">
    <IMG src="/Public/admin/images/buttom_bgs.gif" width="17" height="17"></TD>
    <TD vAlign="bottom" background="/Public/admin/images/mail_rightbg.gif">
    <IMG src="/Public/admin/images/buttom_right2.gif" width="16" height="17">
    </TD>
</TR>

</TBODY>
</TABLE>
</body>
</html>