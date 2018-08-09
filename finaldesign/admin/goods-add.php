<?php
    include '../config/config.php';
    include '../config/database.php';
    include './common/session.php';
    $sql_select = "SELECT id,series FROM `wyp_cate_series` WHERE 1";
    $res = mysqli_query($conn,$sql_select);
    $series = array();
    while($rows = mysqli_fetch_assoc($res)){
        $series[] = $rows;
    }
    $sql_select = "SELECT id,size FROM `wyp_cate_size` WHERE 1";
    $res = mysqli_query($conn,$sql_select);
    $size = array();
    while($rows = mysqli_fetch_assoc($res)){
        $size[] = $rows;
    }
    $sql_select = "SELECT id,shape FROM `wyp_cate_shape` WHERE 1";
    $res = mysqli_query($conn,$sql_select);
    $shape = array();
    while($rows = mysqli_fetch_assoc($res)){
        $shape[] = $rows;
    }
    // print_r($arr);
    // exit();
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
                        <span class="x-red">*</span>产品图
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
                    <img id="LAY_demo_upload" width="50" src="" height="50">
                </div>
                <div class="layui-form-item">
                    <label  class="layui-form-label">
                    </label>
                </div>
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>产品名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="goods_name" name="goods_name" required="" lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>产品价格
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="goods_price" name="goods_price" required="" lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>系列
                    </label>
                    <div class="layui-input-inline">
                        <select lay-verify="required" id="series_id" name="series_id">
                            <option value="0">请选择系列分类</option>
                            <?php foreach($series as $v): ?>
                            <option value="<?=$v['id']?>"><?=$v['series']?></option>
                            <?php endforeach; ?>
                        </select>   
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>大小
                    </label>
                    <div class="layui-input-inline">
                        <select lay-verify="required" id="size_id" name="size_id">                            
                            <option value="0">请选择大小</option>
                            <?php foreach($size as $v): ?>
                            <option value="<?=$v['id']?>"><?=$v['size']?></option>
                            <?php endforeach; ?>
                        </select>   
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>形状
                    </label>
                    <div class="layui-input-inline">
                        <select lay-verify="required" id="shape_id" name="shape_id">
                            <option value="0">请选择形状</option>
                            <?php foreach($shape as $v): ?>
                            <option value="<?=$v['id']?>"><?=$v['shape']?></option>
                            <?php endforeach; ?>
                        </select>   
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>是否热门
                    </label>
                    <div class="layui-input-inline">
                        <select lay-verify="required" id="goods_hot" name="goods_hot">                           
                            <option value="1">是</option>
                            <option value="2">否</option>
                        </select>   
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>排序
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="goods_sort" name="goods_sort" required="" lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>产品简介
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="goods_summary" name="goods_summary" required="" lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item" style="margin-top:110px;">
                    <label for="desc" class="layui-form-label">
                        <span class="x-red">*</span>产品详情
                    </label>
                    <div class="layui-input-inline">
                       <script type="text/plain" id="myEditor" style="width:400px;height:240px;"></script>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="desc" class="layui-form-label">
                        <span class="x-red">*</span>主钻重量
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="zl" name="zl" required="" lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="desc" class="layui-form-label">
                        <span class="x-red">*</span>主钻颜色
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="color" name="color" required="" lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="desc" class="layui-form-label">
                        <span class="x-red">*</span>钻石净度
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="jd" name="jd" required="" lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="desc" class="layui-form-label">
                        <span class="x-red">*</span>钻石切工
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="qg" name="qg" required="" lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label"></label>
                    <input type="button"  class="layui-btn sub" lay-filter="add" lay-submit="" value="增加">
                </div>
            </form>
        </div>
        <script src="./lib/layui/layui.js" charset="utf-8"></script>
        <script src="./js/x-layui.js" charset="utf-8"></script>
        <script>
            //实例化编辑器
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
                    var goods_img =  $('#LAY_demo_upload').attr('src');
                    var goods_name = $('[name="goods_name"]').val();
                    var goods_price = $('[name="goods_price"]').val();
                    var series_id = $('[name="series_id"]').val();
                    var size_id = $('[name="size_id"]').val();
                    var shape_id = $('[name="shape_id"]').val();
                    var goods_hot = $('[name="goods_hot"]').val();
                    var goods_sort = $('[name="goods_sort"]').val();
                    var goods_summary = $('[name="goods_summary"]').val();
                    var zl = $('[name="zl"]').val();
                    var color = $('[name="color"]').val();
                    var jd = $('[name="jd"]').val();
                    var qg = $('[name="qg"]').val();
                    var goods_details = um.getContent();
                    $.ajax({
                        url:'../common/ajax.php?type=add_goods',
                        data:{
                            goods_name:goods_name,
                            goods_img:goods_img,
                            goods_price:goods_price,
                            series_id:series_id,
                            size_id:size_id,
                            shape_id:shape_id,
                            goods_hot:goods_hot,
                            goods_sort:goods_sort,
                            goods_summary:goods_summary,
                            goods_details:goods_details,
                            zl:zl,
                            color:color,
                            jd:jd,
                            qg:qg,
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
            

              // //监听提交
              // form.on('submit(add)', function(data){
              //   console.log(data);
              //   //发异步，把数据提交给php
              //   layer.alert("增加成功", {icon: 6},function () {
              //       // 获得frame索引
              //       var index = parent.layer.getFrameIndex(window.name);
              //       //关闭当前frame
              //       parent.layer.close(index);
              //   });
              //   return false;
              // });
              
              
            });
        </script>
    </body>


</html>