<?php
 include '../config/config.php';
    include '../config/database.php';
    include './common/session.php';
    $sql_select = "SELECT c.id,c.user_id,c.goods_id,c.comment,c.from,c.add_time,us.username,g.goods_name FROM `wyp_comment` AS c INNER JOIN `wyp_userinfo` AS us ON c.user_id = us.id INNER JOIN `wyp_goods_list` AS g ON c.goods_id = g.id WHERE 1";
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
              <a><cite>评论管理</cite></a>
              <a><cite>评论列表</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>
        <div class="x-body">
            <xblock><button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button><span class="x-right" style="line-height:40px">共有数据：<?=$num?> 条</span></xblock>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="" value="" class="checkall"> 
                        </th>
                        <th>
                            ID
                        </th>
                        <th>
                            用户
                        </th>
                        <th>
                            产品
                        </th>
                        <th>
                            评论
                        </th>
                        <th>
                            来自
                        </th>
                        <th>
                            评论时间
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>
                </thead>
                <tbody id="x-link">
                    <?php foreach ($arr as $key => $v): ?>
                    <tr>
                        <td>
                            <input type="checkbox" value="<?=$v['id']?>" name="" class="check">
                        </td>
                        <td>
                            <?=$v['id']?>
                        </td>
                        <td>
                            <?=$v['username']?>
                        </td>
                        <td >
                            <?=$v['goods_name']?>
                        </td>
                        <td >
                            <?=$v['comment']?>
                        </td> 
                        <td >
                            <?=$v['from']?>
                        </td>
                        <td >
                            <?=date('Y-m-d H:i:s',$v['add_time'])?>
                        </td>
                        <td class="td-manage">
                            <a title="删除" href="javascript:;" onclick="commemt_del(this,'<?=$v['id']?>')" 
                            style="text-decoration:none">
                                <i class="layui-icon">&#xe640;</i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <div id="page"></div>
        </div>
        <script src="./js/jquery.min.js" charset="utf-8"></script>
        <script src="./lib/layui/layui.js" charset="utf-8"></script>
        <script src="./js/x-layui.js" charset="utf-8"></script>
        <script>
            layui.use(['element','laypage','layer','form'], function(){
                $ = layui.jquery;//jquery
              lement = layui.element();//面包导航
              laypage = layui.laypage;//分页
              layer = layui.layer;//弹出层
              form = layui.form();//弹出层


          })

              

              //以上模块根据需要引入

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
                        url:'../common/ajax.php?type=delAllcomment',
                        data:{ids:str},
                        type:'get',
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
            
            
            /*删除*/
            function commemt_del(obj,id){
                layer.confirm('确认要删除吗？',function(index){
                     $.ajax({
                        url:'../common/ajax.php?type=del_comment',
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