<?php
    include '../config/config.php';
    include '../config/database.php';
    include './common/session.php';
    $sql_select = "SELECT id,series FROM `wyp_cate_series` WHERE 1";
    $res = mysqli_query($conn,$sql_select);
    $arr = array();
    while($rows = mysqli_fetch_assoc($res)){
        $arr[] = $rows;
    }
    $num = mysqli_num_rows($res);
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
        <div class="x-nav">
            <span class="layui-breadcrumb">
              <a><cite>首页</cite></a>
              <a><cite>产品管理</cite></a>
              <a><cite>分类管理</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>
        <div class="x-body">
            <form class="layui-form x-center" action="" style="width:50%">
                <div class="layui-form-pane" style="margin-top: 15px;">
                  <div class="layui-form-item">
                    <!-- <label class="layui-form-label" style="width:60px">所属分类</label> -->
                    <!-- <div class="layui-input-inline" style="width:120px;text-align: left">
                        <select name="fid">
                            <option value="0">顶级分类</option>
                            <option value="新闻">新闻</option>
                            <option value="新闻子类1">--新闻子类1</option>
                            <option value="新闻子类2">--新闻子类2</option>
                            <option value="产品">产品</option>
                            <option value="产品子类1">--产品子类1</option>
                            <option value="产品子类2">--产品子类2</option>
                        </select>
                    </div> -->
                    <div class="layui-input-inline" style="width:120px">
                        <input type="text" name="series"  placeholder="系列" autocomplete="off" class="layui-input">
                    </div>
                    <!-- <div class="layui-input-inline" style="width:120px">
                        <input type="text" name="cate_name_e"  placeholder="英文名" autocomplete="off" class="layui-input">
                    </div> -->
                    <div class="layui-input-inline" style="width:80px">
                        <input type="button" class="layui-btn sub" lay-submit="" lay-filter="add" value="增加" />
                    </div>
                  </div>
                </div> 
            </form>
            <xblock><button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button><span class="x-right" style="line-height:40px">共有数据：<?=$num?> 条</span></xblock>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="" value="" class="checkall">
                        </th>
                        <th>ID</th>
                        <th>系列</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody id="x-link">
                    <?php foreach ($arr as $key => $v): ?>
                    <tr>
                        <td>
                            <input type="checkbox" value="<?=$v['id']?>" name="" class="check">
                        </td>
                        <td><?=$v['id']?></td>
                        <td><?=$v['series']?></td>
                        <td class="td-manage">
                            <a title="编辑" href="javascript:;" onclick="cate_edit('编辑分类','cate-edit-se.php?id=<?=$v['id']?>','<?=$v['id']?>','','510')"
                            class="ml-5" style="text-decoration:none">
                                <i class="layui-icon">&#xe642;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="cate_del(this,'<?=$v['id']?>')" 
                            style="text-decoration:none">
                                <i class="layui-icon">&#xe640;</i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <script src="./js/jquery.min.js" charset="utf-8"></script>
        <script src="./lib/layui/layui.js" charset="utf-8"></script>
        <script src="./js/x-layui.js" charset="utf-8"></script>
        <script>
            $(function(){
                layui.use('layer',function(){
                    var layer = layui.layer;
                    $('.sub').click(function(){
                        var series = $('[name="series"]').val();
                        $.ajax({
                            url:'../common/ajax.php?type=add_cate_se',
                            data:{series:series},
                            type:'post',
                            dataType:'json',
                            success:function(data){
                                if(data.errno==1){
                                    layer.msg(data.error);
                                    setInterval(function(){
                                        location=location;
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
            })



              
            //批量删除提交
             function delAll () {
                layer.confirm('确认要删除吗？',function(index){
                    //捉到所有被选中的，发异步进行删除
                    var arr = Array();
                    var j = 0;
                    $('.check').each(function(i,e){
                        if($(this).prop('checked')){
                            arr[j] = $(this).val();
                            j++;
                        }
                    });
                    str = arr.join(',');
                    $.ajax({
                        url:'../common/ajax.php?type=delAllseries',
                        data:{ids:str},
                        type:'post',
                        dataType:'json',
                        success:function(data){
                            if(data.errno==1){
                                layer.msg(data.error);
                                //发异步删除数据
                                setInterval(function(){
                                    location=location;
                                },1500)
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
             }

             //-编辑
            function cate_edit (title,url,id,w,h) {
                x_admin_show(title,url,w,h);
            }
           
            /*-删除*/
            function cate_del(obj,id){
                layer.confirm('确认要删除吗？',function(index){

                    $.ajax({
                        url:'../common/ajax.php?type=del_cate_se',
                        data:{id:id},
                        type:'post',
                        dataType:'json',
                        success:function(data){
                            if(data.errno==1){
                                layer.msg(data.error);
                                //发异步删除数据
                                $(obj).parents("tr").remove();
                                layer.msg('已删除!',{icon:1,time:1000});
                                setInterval(function(){
                                    location=location;
                                },1500)
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
            }
            //全选
            
            $(".checkall").click(function() {  
                var flag=this.checked;  
                $(".check").prop('checked',flag);  
            });  
                  
            //  
            $(".check").click(function(){
                if($(".check").length==$(".check:checked").length){
                    $(".checkall").prop("checked",true);
                }else{
                    $(".checkall").prop("checked",false);
                }
                  
            });  
            </script>
    </body>
</html>