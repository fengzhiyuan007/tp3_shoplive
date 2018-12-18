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

<link rel="stylesheet" type="text/css" href="/Public/admin/js/uploadify.css" />
<script type="text/javascript" src="/Public/admin/js/swfobject.js"></script>
<script type="text/javascript" src="/Public/admin/js/jquery.uploadify.v2.1.4.min.js"></script>

<script type="text/javascript">
 $(function($) {
	$("#file_upload2").uploadify({
	 		'uploader'       : '/Public/admin/js/uploadify.swf',
	 		'script'         : '/Public/admin/js/uploadify.php',
	 		'cancelImg'      : '/Public/admin/images/cancel.png',
	 		'folder'         : '/Public/admin/Uploads/touxiang',
	 		'queueID'        : 'fileQueue2',
	 		'sizeLimit'      :	10 * 1000 * 1024,
			'buttonImg'      : '/Public/admin/images/llsc.jpg',
			'width'          :  85,
			'height'         :  28,
	 		'fileExt'        : '*.jpg;*.gif;*.png;', //允许文件上传类型,和fileDesc一起使用.
	 		'fileDesc'       : '*.jpg;*.gif;*.png;',  //选择文件对话框中的提示文本.
	 		'auto'           : true,
	 		'multi'          : false,	
	 		'onComplete':function(event,queueId,fileObj,response,data){
	 			$('input[name="logo"]').val(response);
	 			$('#pic2').attr('src', response);
	 		}
	 	});

	 });
</script>
<SCRIPT language=JavaScript>
    window.onload=function(){
        var day_switch = document.getElementsByName("day_switch");
        for (i=0; i<day_switch.length; i++) {
            if (day_switch[i].checked) {
                a = day_switch[i].value;
            }
        }
        if(a==1){
            document.getElementById("s_time").className="";
        }else{
            document.getElementById("s_time").className="s_time";
        }

    }
	     function checkss(){
             var id = $("#id").val();
	    	 var phone    = $("#phone").val();
             // var ID    = $("#ID").val();
             // var master_id = $("#master_id").val();
             // var day_switch = document.getElementsByName("day_switch");
             // for (i=0; i<day_switch.length; i++) {
             //     if (day_switch[i].checked) {
             //         a = day_switch[i].value;
             //     }
             // }
             // var start    = $("#start").val();
             // var end    = $("#end").val();
//	    	 if(phone==''){
//                 $(".yzphone").html('填写账号！');
//                 $("#phone").focus();
//                 return false;
//	    	 }
	    	 // if(a==1){
	    	 //     if (start==''){
       //               $(".yztime").html('选择开始日期！');
       //               $("#start").focus();
       //               return false;
       //           }else if (end==''){
       //               $(".yztime").html('选择结束日期！');
       //               $("#end").focus();
       //               return false;
       //           }
       //       }else 
             if(phone!='') {
                 $(".yzphone").html('');
                 var result=false;
                 $.ajax({async:false//要设置为同步的，要不CheckUserName的返回值永远为false
                     ,url:'<?php echo U("yzmobile");?>',data:{id:id,mobile:phone}
                     ,success:function(data){
                         if(data == 1){
                             $(".yzphone").html('账号已注册');
                             $("#phone").focus();
                             result = false;
                         }else if(data == 4){
                             $(".yzmaster_id").html('ID不存在');
                             // $("#master_id").focus();
                             result = false;
                         } else {
                             result = true;
                         }
                     }});
                 return result;
             }else if(phone == ''){
                $(".yzphone").html('请输入账号');
                $("#phone").focus();
                return false;

             }
	    	 
	     }

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
         function selday_switch(key) {
             if(key==1){
                 document.getElementById("s_time").className="";
             }else{
                 document.getElementById("s_time").className="s_time";
             }
         }

	</script>
<style>
    .s_time{display: none}
</style>
<div class="content">
<div id="big"></div>
<div id="big2"></div>

<div class="infoBox">
<form name="form" method="post">

<table width="90%" border="0" cellpadding="0" cellspacing="0" id="basic">
               <input type="hidden" value="<?php echo ($re["member_id"]); ?>" name="id" id="id">
                <tr>
                    <td  width="10%" class="infoBoxTd"><div style="width:65px;">姓名:</div></td>
                    <td ><input type="text" id="contact_name"  name="contact_name" readonly="readonly" value="<?php echo ($re['contact_name']); ?>" style="width:250px;">
                    <!-- &nbsp;&nbsp;<span class="yzphone" style="color:red"></span> -->
                    </td>
                </tr>
                <tr>
                    <td  width="10%" class="infoBoxTd"><div style="width:65px;">联系电话:</div></td>
                    <td ><input type="text" value="<?php echo ($re['contact_mobile']); ?>" readonly="readonly" id="contact_mobile" name="contact_mobile" style="width:250px;">&nbsp;&nbsp;<span class="yzmaster_id" style="color:red"></span>
                    </td>
                </tr>
                <tr>
                    <td  width="10%" class="infoBoxTd"><div style="width:65px;">店铺名称:</div></td>
                    <td ><input type="text" id="merchants_name" readonly="readonly" name="merchants_name" value="<?php echo ($re['merchants_name']); ?>" style="width:250px;">&nbsp;&nbsp;<span class="yzmaster_id" style="color:red"></span>
                    </td>
                </tr>
                
                
                <tr>
                  <td style="text-align:right;color:#2d52a5">地址:</td>
                  <td>
                      <select name="sheng" onchange="area_linke1(this.value)">
                          <option value="">请选择</option>
                          <?php if(is_array($sheng)): $i = 0; $__LIST__ = $sheng;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><option value="<?php echo ($l["id"]); ?>" <?php if( $re["merchants_province"] == $l["name"] ): ?>selected<?php else: endif; ?>><?php echo ($l["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                      </select>
                      <select name="shi" id="shi" onchange="area_linke2(this.value)">
                          <?php if( $re["shi"] == null ): else: ?>
                              <option value=''>请选择（市）</option>
                              <?php if(is_array($re["shi"])): $i = 0; $__LIST__ = $re["shi"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><option value="<?php echo ($s["id"]); ?>" <?php if( $re["city_id"] == $s["id"] ): ?>selected<?php else: endif; ?>><?php echo ($s["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                      </select>
                      <select name="qu" id="qu">
                          <?php if( $re["qu"] == null ): else: ?>
                              <option value=''>请选择（区/县）</option>
                              <?php if(is_array($re["qu"])): $i = 0; $__LIST__ = $re["qu"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><option value="<?php echo ($s["id"]); ?>" <?php if( $re["area_id"] == $s["id"] ): ?>selected<?php else: endif; ?>><?php echo ($s["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                      </select>
                      
                  </td>
                </tr>
                <tr>
                    <td  width="10%" class="infoBoxTd"><div style="width:65px;">店铺地址:</div></td>
                    <td ><input value="<?php echo ($re['merchants_address']); ?>" readonly="readonly" id="merchants_address" name="merchants_address" placeholder="具体地址" type="text" size="50"></span>
                    </td>
                </tr>
                
        <tr>
            <td  width="2%"  style="text-align:right;color:#2d52a5"><div style="width:65px;">店铺图片:</div></td>
            <td colspan="2">
                <div class="droparea spot" id="image1" style="background-image: url('<?php echo ($re["merchants_img"]); ?>');background-size: 220px 160px;" >
                    <div class="instructions">店铺图片</div>
                    
                </div>
            </td>
        </tr>

        <tr>
            <td  width="2%"  style="text-align:right;color:#2d52a5"><div style="width:65px;">法人照片:</div></td>
            <td style="width: 220px;">
                <div class="droparea spot" id="image2" style="background-image: url('<?php echo ($re["legal_img"]); ?>');background-size: 220px 160px;" >
                    <div class="instructions">法人照片</div>
                    
                </div>
            </td>

            <td >
                <div class="droparea spot" id="image3" style="background-image: url('<?php echo ($re["legal_face_img"]); ?>');background-size: 220px 160px;" >
                    <div class="instructions">正面照</div>
                    
                </div>
            </td>

        </tr>
        <tr>
            <td  width="2%"  style="text-align:right;color:#2d52a5"><div style="width:65px;"></div></td>
            <td style="width: 220px;">
                <div class="droparea spot" id="image4" style="background-image: url('<?php echo ($re["legal_opposite_img"]); ?>');background-size: 220px 160px;" >
                    <div class="instructions">反面照</div>
                    
                </div>
            </td>

            <td >
                <div class="droparea spot" id="image5" style="background-image: url('<?php echo ($re["legal_hand_img"]); ?>');background-size: 220px 160px;" >
                    <div class="instructions">手持照</div>
                    
                </div>
            </td>
        </tr>
        <tr>
            <td  width="2%"  style="text-align:right;color:#2d52a5"><div style="width:65px;">营业执照:</div></td>
            <td style="width: 220px;">
                <div class="droparea spot" id="image6" style="background-image: url('<?php echo ($re["business_img"]); ?>');background-size: 220px 160px;" >
                    <div class="instructions">营业执照</div>
                    
                </div>
            </td>
        </tr>
        
        <tr>
            <td  width="2%"  style="text-align:right;color:#2d52a5"><div style="width:65px;">审核状态:</div></td>
            <td>
                <select name="apply_state" class="select input-text" >
                    <option value="1" <?php if( $re['apply_state'] == 1 ): ?>selected<?php endif; ?>>审核中</option>
                    <option value="2" <?php if( $re['apply_state'] == 2 ): ?>selected<?php endif; ?>>审核通过</option>
                    <option value="3" <?php if( $re['apply_state'] == 3 ): ?>selected<?php endif; ?>>拒绝</option>
                </select>
            </td>
        </tr>
        
                
              
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="infoBoxTd">&nbsp;</td>
<td align="left"><input type="submit" name="submit" value="保存" class="formInput01" /></td>
</tr>
</table>
</form>
</div>
<script>
KindEditor.ready(function(K) {
    k1 = K.create('#content', {});
    k2 = K.create('#content2', {});
    k3 = K.create('#content3', {});

});
///var ue = UE.getEditor('content');
///var ue = UE.getEditor('content2');
///var ue = UE.getEditor('content3');
</script>
    <script>
        layui.use('laydate', function(){
            var laydate = layui.laydate;
            var start = {
                elem: '#start',
                format: 'YYYY-MM-DD hh:mm:ss',
                min: laydate.now(), //设定最小日期为当前日期
                max: '2099-06-16 23:59:59', //最大日期
                istime: false,
                istoday: false,
                choose: function(datas){
                    $("#start").attr("value",datas);
                    end.min = datas; //开始日选好后，重置结束日的最小日期
                    end.start = datas //将结束日的初始值设定为开始日
                }
            };
            var end = {
                elem: '#end',
                format: 'YYYY-MM-DD hh:mm:ss',
                min: laydate.now(),
                max: '2099-06-16 23:59:59',
                istime: false,
                istoday: false,
                choose: function(datas){
                    $("#end").attr("value",datas);
                    start.max = datas; //结束日选好后，重置开始日的最大日期
                }
            };
            document.getElementById('start').onclick = function(){
                start.elem = this;
                laydate(start);
            }
            document.getElementById('end').onclick = function(){
                end.elem = this
                laydate(end);
            }
        });

        KindEditor.ready(function(K) {
                K.create('#image_1');
                var editor = K.editor({
                    allowFileManager : true,
                    uploadJson:"<?php echo U('Common/upload');?>"
                    //sdl:false
                });
                K('#uparea1').click(function() {
                    console.log(1);
                    editor.loadPlugin('image', function() {
                        editor.plugin.imageDialog({
                            imageUrl : K('#image_1').val(),
                            clickFn : function(url, title, width, height, border, align) {
                                console.log(url);
                                $('#image1').css('background-image','url('+url+')').css('background-size','220px 160px');
                                K('#image_1').val(url);
                                K('#image_11').val(url);
                                // K('#getImgUrl').val(url);
                                editor.hideDialog();
                            }
                        });
                    });
                });

                K('#uparea2').click(function() {
                    console.log(2);
                    editor.loadPlugin('image', function() {
                        editor.plugin.imageDialog({
                            imageUrl : K('#image_2').val(),
                            clickFn : function(url, title, width, height, border, align) {
                                console.log(url);
                                $('#image2').css('background-image','url('+url+')').css('background-size','220px 160px');
                                K('#image_2').val(url);
                                K('#image_22').val(url);
                                // K('#getImgUrl').val(url);
                                editor.hideDialog();
                            }
                        });
                    });
                });

                K('#uparea3').click(function() {
                    console.log(3);
                    editor.loadPlugin('image', function() {
                        editor.plugin.imageDialog({
                            imageUrl : K('#image_3').val(),
                            clickFn : function(url, title, width, height, border, align) {
                                console.log(url);
                                $('#image3').css('background-image','url('+url+')').css('background-size','220px 160px');
                                K('#image_3').val(url);
                                K('#image_33').val(url);
                                // K('#getImgUrl').val(url);
                                editor.hideDialog();
                            }
                        });
                    });
                });

                K('#uparea4').click(function() {
                    console.log(4);
                    editor.loadPlugin('image', function() {
                        editor.plugin.imageDialog({
                            imageUrl : K('#image_4').val(),
                            clickFn : function(url, title, width, height, border, align) {
                                console.log(url);
                                $('#image4').css('background-image','url('+url+')').css('background-size','220px 160px');
                                K('#image_4').val(url);
                                K('#image_44').val(url);
                                // K('#getImgUrl').val(url);
                                editor.hideDialog();
                            }
                        });
                    });
                });

                K('#uparea5').click(function() {
                    console.log(5);
                    editor.loadPlugin('image', function() {
                        editor.plugin.imageDialog({
                            imageUrl : K('#image_5').val(),
                            clickFn : function(url, title, width, height, border, align) {
                                console.log(url);
                                $('#image5').css('background-image','url('+url+')').css('background-size','220px 160px');
                                K('#image_5').val(url);
                                K('#image_55').val(url);
                                // K('#getImgUrl').val(url);
                                editor.hideDialog();
                            }
                        });
                    });
                });

                K('#uparea6').click(function() {
                    console.log(6);
                    editor.loadPlugin('image', function() {
                        editor.plugin.imageDialog({
                            imageUrl : K('#image_6').val(),
                            clickFn : function(url, title, width, height, border, align) {
                                console.log(url);
                                $('#image6').css('background-image','url('+url+')').css('background-size','220px 160px');
                                K('#image_6').val(url);
                                K('#image_66').val(url);
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

            $("#uparea2").mouseover(function(e){
                $("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
                var img = $('#image_2').val();
                if(img.length !== 0) {
                    $("#big").html('<img src="' + $('#image_2').val() + '" width=380 height=300>');
                    $("#big").show();        //show：显示
                }
            });
            $("#uparea2").mouseout(function(){
                $("#big").hide();
            });

            $("#uparea3").mouseover(function(e){
                $("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
                var img = $('#image_3').val();
                if(img.length !== 0) {
                    $("#big").html('<img src="' + $('#image_3').val() + '" width=380 height=300>');
                    $("#big").show();        //show：显示
                }
            });
            $("#uparea3").mouseout(function(){
                $("#big").hide();
            });

            $("#uparea4").mouseover(function(e){
                $("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
                var img = $('#image_4').val();
                if(img.length !== 0) {
                    $("#big").html('<img src="' + $('#image_4').val() + '" width=380 height=300>');
                    $("#big").show();        //show：显示
                }
            });
            $("#uparea4").mouseout(function(){
                $("#big").hide();
            });

            $("#uparea5").mouseover(function(e){
                $("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
                var img = $('#image_5').val();
                if(img.length !== 0) {
                    $("#big").html('<img src="' + $('#image_5').val() + '" width=380 height=300>');
                    $("#big").show();        //show：显示
                }
            });
            $("#uparea5").mouseout(function(){
                $("#big").hide();
            });

            $("#uparea6").mouseover(function(e){
                $("#big").css({top:e.pageY,right:e.pageX});//鼠标定位一个点
                var img = $('#image_6').val();
                if(img.length !== 0) {
                    $("#big").html('<img src="' + $('#image_6').val() + '" width=380 height=300>');
                    $("#big").show();        //show：显示
                }
            });
            $("#uparea6").mouseout(function(){
                $("#big").hide();
            });
        ///var ue = UE.getEditor('content');
        ///var ue = UE.getEditor('content2');
        ///var ue = UE.getEditor('content3');
        function del_image(num){
            var img = $('#image_'+num).val();
            if(img.length !=0) {
                //if (confirm('是否要删除该图片?\n删除该图片将会连服务器的图片一起删除')) {
                //    $.post('/system.php/tools/del_img', {url: img}, function (data) {
                //        if (data['status'] == 'ok') {
                //            console.log(data);
                //            $('#image' + num).css('background-image', '');
                //            $('#image_' + num).val('');
                //        }
                //    }, 'json');
                if (confirm('是否要删除该图片?')) {
                    $('#image' + num).css('background-image', '');
                    $('#image_' + num).val('');

                };
                return false;
            } else {
                return false;
            }
        }
    </script>
<!-----------------------------------------内容结束--------------------------------------------------->
</div>
    
    
    
    
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