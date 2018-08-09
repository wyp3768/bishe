<?php 
    include '../config/config.php';
    include '../config/database.php';
    include './common/session.php';
    $sql_select = "SELECT g.id,g.goods_name,g.goods_img,g.goods_price,g.series_id,g.size_id,g.shape_id,g.goods_hot,g.goods_sort,g.goods_summary,g.goods_details,g.goods_state,g.add_time,se.series,si.size,sh.shape FROM `wyp_goods_list` AS g INNER JOIN `wyp_cate_series` AS se ON g.series_id = se.id INNER JOIN `wyp_cate_size` AS si ON g.size_id = si.id INNER JOIN `wyp_cate_shape` AS sh ON g.shape_id = sh.id WHERE 1 ORDER BY id ASC";
    $res = mysqli_query($conn,$sql_select);
    $num = mysqli_num_rows($res);

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $pageAll = 10;
    $sql_select = "SELECT g.id,g.goods_name,g.goods_img,g.goods_price,g.series_id,g.size_id,g.shape_id,g.goods_hot,g.goods_sort,g.goods_summary,g.goods_details,g.goods_state,g.add_time,g.zl,g.color,g.jd,g.qg,se.series,si.size,sh.shape FROM `wyp_goods_list` AS g INNER JOIN `wyp_cate_series` AS se ON g.series_id = se.id INNER JOIN `wyp_cate_size` AS si ON g.size_id = si.id INNER JOIN `wyp_cate_shape` AS sh ON g.shape_id = sh.id WHERE 1 ORDER BY id ASC LIMIT ".($pageAll*($page - 1)).",".$pageAll;
    $res = mysqli_query($conn,$sql_select);
    $arr = array();
    while($rows = mysqli_fetch_assoc($res)){
        $arr[] = $rows;
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
    </head>
    <body>
        <div class="x-nav">
            <span class="layui-breadcrumb">
                <a><cite>首页</cite></a>
                <a><cite>产品管理</cite></a>
                <a><cite>产品列表</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>
        <div class="x-body">
            <xblock><button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button><button class="layui-btn" onclick="goods_add('添加产品','goods-add.php','600','500')"><i class="layui-icon">&#xe608;</i>添加</button><span class="x-right" style="line-height:40px">共有数据：<?=$num?> 条</span></xblock>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="" value="" class="checkall"></th>
                        <th>ID</th>
                        <th>产品名</th>
                        <th>缩略图</th>
                        <th>产品价格</th>
                        <th>系列</th>
                        <th>大小</th>
                        <th>形状</th>
                        <th>是否热门</th>                        
                        <th>产品状态</th>
                        <th>添加时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody id="x-img">
                    <?php foreach ($arr as $key => $v): ?>
                    <tr>
                        <td><input type="checkbox" value="<?=$v['id']?>" name="" class="check"></td>
                        <td><?=$v['id']?></td>
                        <td><?=$v['goods_name']?></td>
                        <td><img  src="<?=$v['goods_img']?>" width="50" alt="" height="50"></td>
                        <td><?=$v['goods_price']?></td>
                        <td><?=$v['series']?></td>
                        <td><?=$v['size']?></td>
                        <td><?=$v['shape']?></td>
                        <td>
                            <?php if($v['goods_hot'] == 1){ ?>
                            是
                            <?php }else{ ?>
                            否
                            <?php } ?>
                        </td>
                        <td>
                            <?php if($v['goods_state'] == 1){ ?>
                            审核中
                            <?php }else if($v['goods_state'] == 2){ ?>
                            已上架
                            <?php }else{ ?>
                            已下架
                            <?php } ?>
                        </td>
                        <td><?=date("Y-m-d H:i:s",$v['add_time'])?></td>
                        <!-- <td class="td-status">
                            <span class="layui-btn layui-btn-normal layui-btn-mini">
                                已显示
                            </span>
                        </td> -->
                        <td class="td-manage">
                            <a style="text-decoration:none" onclick="goods(this,'<?=$v['id']?>','<?=$v['goods_state']?>')" href="javascript:;">
                                <i class="layui-icon">
                                    <?php if($v['goods_state'] == 1) echo "&#xe62f;";else if($v['goods_state'] == 2) echo "&#xe601;";else echo "&#xe62f;";?>
                                </i>
                            </a>
                            <a title="编辑" href="javascript:;" onclick="goods_edit('编辑','goods-edit.php?id=<?=$v['id']?>','<?=$v['id']?>','','510')"
                            class="ml-5" style="text-decoration:none">
                                <i class="layui-icon">&#xe642;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="goods_del(this,'<?=$v['id']?>')" 
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
                laypage({
                    cont: 'page'
                    ,pages: <?=ceil($num/$pageAll)?>
                    ,first: 1
                    ,last: <?=ceil($num/$pageAll)?>
                    ,curr: <?=$page?>
                    ,prev: '<em><</em>'
                    ,next: '<em>></em>'
                    ,jump: function(obj, first){
                        
                        if(!first){  
                            window.location.href="goods-list.php?page="+obj.curr;  
                        }
                    }
                }); 

               

                layer.ready(function(){ //为了layer.ext.js加载完毕再执行
                    layer.photos({
                        photos: '#x-img'
                        //,shift: 5 //0-6的选择，指定弹出图片动画类型，默认随机
                    });
                }); 
              
            });
            //状态修改 
            function goods(obj,id,state){
                $.ajax({
                    url:'../common/ajax.php?type=update_goods_state',
                    data:{
                        id:id,
                        goods_state:state,
                    },
                    type:'post',
                    dataType:'json',
                    success:function(data){
                        if(data.errno==1){
                            console.log(data.error);
                            setInterval(function(){
                                location=location;
                            },1500)
                        }else{
                            console.log(data.error);
                            return false;
                        }
                    },
                    error:function(e){
                        alert(e.responseText);
                    }
                });
                if(state == 1){
                   layer.confirm('确认上架吗？',function(index){
                        layer.msg('已上架!',{icon: 6,time:1000});
                    }); 
                }else if(state == 2){
                    layer.confirm('确认要下架吗？',function(index){
                        layer.msg('已下架!',{icon: 6,time:1000});
                    });
                }else{
                    layer.confirm('确认要上架吗？',function(index){
                        layer.msg('审核中!',{icon: 6,time:1000});
                    });
                }                
            }
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
                        url:'../common/ajax.php?type=delAllgoods',
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
            function goods_add(title,url,w,h){
                x_admin_show(title,url,w,h);
            }
            // 编辑
            function goods_edit (title,url,id,w,h) {
                x_admin_show(title,url,w,h); 
            }
            /*删除*/
            function goods_del(obj,id){
                layer.confirm('确认要删除吗？',function(index){
                     $.ajax({
                        url:'../common/ajax.php?type=del_goods',
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