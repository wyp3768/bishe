<?php
    include '../config/config.php';
    include '../config/database.php';
    include './common/session.php';
    $sql_select = "SELECT id,ad_pic,ad_link,ad_sort,ad_desc,add_time FROM `wyp_ad` WHERE 1";
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
                <a><cite>会员管理</cite></a>
                <a><cite>广告列表</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>
        <div class="x-body">
            <xblock><button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button><button class="layui-btn" onclick="ad_add('添加用户','ad-add.html','600','500')"><i class="layui-icon">&#xe608;</i>添加</button><span class="x-right" style="line-height:40px">共有数据：<?=$num?> 条</span></xblock>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="" value="" class="checkall"></th>
                        <th>ID</th>
                        <th>缩略图</th>
                        <th>链接</th>
                        <th>排序</th>                        
                        <th>描述</th>
                        <th>添加时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody id="x-img">
                    <?php foreach ($arr as $key => $v): ?>
                    <tr>
                        <td><input type="checkbox" value="<?=$v['id']?>" name="" class="check"></td>
                        <td><?=$v['id']?></td>
                        <td><img  src="<?=$v['ad_pic']?>" width="200" alt="" height="50"></td>                        
                        <td><?=$v['ad_link']?></td>
                        <td><?=$v['ad_sort']?></td>
                        <td><?=$v['ad_desc']?></td>
                        <td><?=date('Y-m-d H:i:s',$v['add_time'])?></td>
                        <td class="td-manage">
                            <a title="编辑" href="javascript:;" onclick="ad_edit('编辑','ad-edit.php?id=<?=$v['id']?>','<?=$v['id']?>','','510')"
                            class="ml-5" style="text-decoration:none">
                                <i class="layui-icon">&#xe642;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="ad_del(this,'<?=$v['id']?>')" 
                            style="text-decoration:none">
                                <i class="layui-icon">&#xe640;</i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div id="page"></div>
        </div>
        <script src="./js/jquery.min.js" charset="utf-8"></script>
        <script src="./lib/layui/layui.js" charset="utf-8"></script>
        <script src="./js/x-layui.js" charset="utf-8"></script>
        <script>
            layui.use(['laydate','element','laypage','layer'], function(){
              laydate = layui.laydate;//日期插件
              lement = layui.element();//面包导航
              laypage = layui.laypage;//分页
              layer = layui.layer;//弹出层

              //以上模块根据需要引入

                layer.ready(function(){ //为了layer.ext.js加载完毕再执行
                    layer.photos({
                        photos: '#x-img'
                        //,shift: 5 //0-6的选择，指定弹出图片动画类型，默认随机
                    });
                }); 
              
            });

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
                        url:'../common/ajax.php?type=delAllad',
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
             /*添加*/
            function ad_add(title,url,w,h){
                x_admin_show(title,url,w,h);
            }
            
             /*停用*/
            // function ad_stop(obj,id){
            //     layer.confirm('确认不显示吗？',function(index){
            //         //发异步把用户状态进行更改
            //         $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="ad_start(this,id)" href="javascript:;" title="显示"><i class="layui-icon">&#xe62f;</i></a>');
            //         $(obj).parents("tr").find(".td-status").html('<span class="layui-btn layui-btn-disabled layui-btn-mini">不显示</span>');
            //         $(obj).remove();
            //         layer.msg('不显示!',{icon: 5,time:1000});
            //     });
            // }

            /*启用*/
            // function ad_start(obj,id){
            //     layer.confirm('确认要显示吗？',function(index){
            //         //发异步把用户状态进行更改
            //         $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="ad_stop(this,id)" href="javascript:;" title="不显示"><i class="layui-icon">&#xe601;</i></a>');
            //         $(obj).parents("tr").find(".td-status").html('<span class="layui-btn layui-btn-normal layui-btn-mini">已显示</span>');
            //         $(obj).remove();
            //         layer.msg('已显示!',{icon: 6,time:1000});
            //     });
            // }
            // 编辑
            function ad_edit (title,url,id,w,h) {
                x_admin_show(title,url,w,h); 
            }
            /*删除*/
            function ad_del(obj,id){
                layer.confirm('确认要删除吗？',function(index){
                     $.ajax({
                        url:'../common/ajax.php?type=del_ad',
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
            // 全选
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