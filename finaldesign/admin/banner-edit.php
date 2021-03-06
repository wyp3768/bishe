<?php
    include '../config/config.php';
    include '../config/database.php';
    include './common/session.php';
    $id = empty($_GET['id']) ? 0 :$_GET['id'];
    $sql_select = "SELECT banner,banner_sort,banner_link,banner_desc FROM `wyp_banner` WHERE id = ".$id;
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
    </head>
    <body>
        <div class="x-body">
            <form class="layui-form">
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>轮播图
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
                    <img id="LAY_demo_upload" width="200" height="50" src="<?=$rows['banner']?>">
                </div>
                <div class="layui-form-item">
                    <label  class="layui-form-label">
                    </label>
                </div>
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>排序
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="sort" name="sort" required="" lay-verify="required"
                        autocomplete="off" class="layui-input" value="<?=$rows['banner_sort']?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>链接
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="link" name="link" required="" lay-verify="required" 
                        autocomplete="off" class="layui-input" value="<?=$rows['banner_link']?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="desc" class="layui-form-label">
                        <span class="x-red">*</span>描述
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="desc" name="desc" required="" lay-verify="required" 
                        autocomplete="off" class="layui-input" value="<?=$rows['banner_desc']?>">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">
                    </label>
                    <input  class="layui-btn sub" lay-filter="add" lay-submit="" value="修改" type="button">
                        
                </div>
            </form>
        </div>
        <script src="./js/jquery.min.js" charset="utf-8"></script>
        <script src="./lib/layui/layui.js" charset="utf-8"></script>
        <script src="./js/x-layui.js" charset="utf-8"></script>
        <script>
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
                    var banner =  $('#LAY_demo_upload').attr('src');
                    var banner_sort = $('[name="sort"]').val();
                    var banner_link = $('[name="link"]').val();
                    var banner_desc = $('[name="desc"]').val();
                    if('<?=$rows["banner"]?>' == $('#LAY_demo_upload').attr('src')){
                        var old_img = '';
                    }else{
                        var old_img = '<?=$rows["banner"]?>';
                    }
                    // $.getJSON(
                    //     '',
                    //     {},
                    //     function(json){

                    //     }
                    // );
                    // $.post(
                    //     '',
                    //     {},
                    //     function(){

                    //     },
                    //     'json'
                    //     )
                    $.ajax({
                        url:'../common/ajax.php?type=update_banner',
                        data:{
                            id:<?=$id?>,
                            banner:banner,
                            banner_sort:banner_sort,
                            banner_link:banner_link,
                            banner_desc:banner_desc,
                            old_img:old_img,
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