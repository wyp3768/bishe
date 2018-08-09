<?php
    include '../config/config.php';
    include '../config/database.php';
    include './common/session.php';
    $id = empty($_GET['id']) ? 0 :$_GET['id'];
    $sql_select = "SELECT series FROM `wyp_cate_series` WHERE id = ".$id;
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
                    <label for="cname" class="layui-form-label">
                        ID
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="cname" name="cname" required="" lay-verify="required"
                        autocomplete="off"  value="<?=$id?>" disabled="" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="cname" class="layui-form-label">
                        <span class="x-red">*</span>系列
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="cname" name="series" required="" lay-verify="required"
                        autocomplete="off" class="layui-input" value="<?=$rows['series']?>">
                    </div>
                </div>
                
                <!-- <div class="layui-form-item">
                    <label class="layui-form-label">所属分类</label>
                    <div class="layui-input-inline" >
                        <select name="fid">
                            <option value="0">顶级分类</option>
                            <option value="新闻">新闻</option>
                            <option value="新闻子类1">--新闻子类1</option>
                            <option value="新闻子类2">--新闻子类2</option>
                            <option value="产品">产品</option>
                            <option value="产品子类1">--产品子类1</option>
                            <option value="产品子类2">--产品子类2</option>
                        </select>
                    </div>
                </div> -->
                
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label"></label>
                    <input type="button" class="layui-btn" lay-filter="save" lay-submit="" value="保存">     
                </div>
            </form>
        </div>
         <script src="./js/jquery.min.js" charset="utf-8"></script>
        <script src="./lib/layui/layui.js" charset="utf-8"></script>
        <script src="./js/x-layui.js" charset="utf-8"></script>
        <script>
            $(function(){
                layui.use(['layer'], function(){
                    layer = layui.layer;
                    $('.layui-btn').click(function(){
                        var series = $('[name="series"]').val();
                        $.ajax({
                            url:'../common/ajax.php?type=update_cate_se',
                            data:{id:<?=$id?>,series:series},
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
            });
            
        </script>
    </body>

</html>