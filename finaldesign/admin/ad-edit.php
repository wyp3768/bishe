<?php
    include '../config/config.php';
    include '../config/database.php';
    include './common/session.php';
    $id = empty($_GET['id']) ? 0 :$_GET['id'];
    $sql_select = "SELECT ad_pic,ad_link,ad_sort,ad_desc,ad_details FROM `wyp_ad` WHERE id = ".$id;
    $res = mysqli_query($conn,$sql_select);
    $rows = mysqli_fetch_assoc($res);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>
            Diamond ring admin
        </title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="./css/x-admin.css" media="all">
        <link href="baidu/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="baidu/third-party/jquery.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="baidu/umeditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="baidu/umeditor.min.js"></script>
        <script type="text/javascript" src="baidu/lang/zh-cn/zh-cn.js"></script>
    </head>
    <body>
        <div class="x-body">
            <form class="layui-form">
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>广告图
                    </label>
                    <div class="layui-input-inline">
                      <div class="site-demo-upbar">
                        <input type="file" name="file" class="layui-upload-file" id="test">
                      </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label  class="layui-form-label">缩略图
                    </label>
                    <img id="LAY_demo_upload" width="200" height="50" src="<?=$rows['ad_pic']?>">
                </div>
                <div class="layui-form-item">
                    <label  class="layui-form-label">
                    </label>
                </div>
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>链接
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="ad_link" name="ad_link" required="" lay-verify="required"
                        autocomplete="off" class="layui-input" value="<?=$rows['ad_link']?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>排序
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="ad_sort" name="ad_sort" required="" lay-verify="required"
                        autocomplete="off" class="layui-input" value="<?=$rows['ad_sort']?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="desc" class="layui-form-label">
                        <span class="x-red">*</span>描述
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="ad_desc" name="ad_desc" required="" lay-verify="required"
                        autocomplete="off" class="layui-input" value="<?=$rows['ad_desc']?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>详情
                    </label>
                    <div class="layui-input-inline">
                        <script type="text/plain" id="myEditor" style="width:400px;height:240px;">
                            <?=$rows['ad_details']?>
                        </script>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">
                    </label>
                    <input  class="layui-btn sub" lay-filter="add" lay-submit="" value="修改" type="button">
                        
                </div>
            </form>
        </div>
        <script src="./lib/layui/layui.js" charset="utf-8"></script>
        <script src="./js/x-layui.js" charset="utf-8"></script>
        <script>
            var um = UM.getEditor('myEditor');
            layui.use(['form','layer','upload'], function(){
                // $ = layui.jquery;
                var layer = layui.layer;

              //图片上传接口
                layui.upload({
                    url: '../common/ajax.php?type=upload',//上传接口
                    success: function(res){ //上传成功后的回调
                        if(res.errno == 1){
                            layer.msg(res.error);
                            $('#LAY_demo_upload').attr('src',res.url); 
                        }else{
                            layer.msg(res.error);
                            return false;
                        }                    
                    }
                });
                $('.sub').click(function(){
                    var ad_pic = $('#LAY_demo_upload').attr('src');                    
                    var ad_link = $('[name="ad_link"]').val();
                    var ad_sort = $('[name="ad_sort"]').val();
                    var ad_desc = $('[name="ad_desc"]').val();
                    var ad_details = um.getContent();
                    $.ajax({
                        url:'../common/ajax.php?type=update_ad',
                        data:{
                            id:<?=$id?>,
                            ad_pic:ad_pic,
                            ad_link:ad_link,
                            ad_sort:ad_sort,                            
                            ad_desc:ad_desc,
                            ad_details:ad_details,
                        },
                        type:'post',
                        dataType:'json',
                        success:function(data){
                            if(data.errno==1){
                                layer.msg(data.error);
                               setInterval(function(){
                                    // 获得frame索引
                                    var index = parent.layer.getFrameIndex(window.name);
                                    //关闭当前frame
                                    parent.location.reload();
                                    parent.layer.close(index);                                        
                                },1500);
                            }else{
                                layer.msg(data.error);
                                return false;
                            }
                        },
                        error:function(e){
                            alert(e.responseText);
                        }
                    });
                });
              
              
            });
        </script>
    </body>

</html>