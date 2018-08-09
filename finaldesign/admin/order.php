<?php
    include '../config/config.php';
    include '../config/database.php';
    include './common/session.php';
    $sql_select = "SELECT o.id,o.user_id,o.goods_id,o.state,o.add_time,o.address_id,u.username,g.goods_name,a.address,a.area FROM `wyp_order` AS o  INNER JOIN `wyp_userinfo` AS u ON o.user_id=u.id INNER JOIN `wyp_goods_list` AS g ON o.goods_id=g.id INNER JOIN `wyp_address` AS a ON o.address_id=a.id WHERE 1";
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
                <a><cite>用户管理</cite></a>
                <a><cite>购物车列表</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>
        <div class="x-body">
            <xblock style="height:40px;"><span class="x-right" style="line-height:40px">共有数据：<?=$num?> 条</span></xblock>
            <table class="layui-table">
                <thead>
                    <tr>
                        <!-- <th><input type="checkbox" name="" value=""></th> -->
                        <th>ID</th>
                        <th>用户名</th>
                        <th>产品</th>
                        <th>显示状态</th>
                        <th>添加时间</th>
                        <th>地址</th>
                        <th>编辑</th>    
                    </tr>
                </thead>
                <tbody id="x-img">
                    <?php foreach ($arr as $key => $v): ?>
                    <tr>
                        <!-- <td><input type="checkbox" value="<?=$v['id']?>" name=""></td> -->
                        <td><?=$v['id']?></td>                    
                        <td><?=$v['username']?></td>
                        <td><?=$v['goods_name']?></td>
                        <td class="td-status">
                            <?php if($v['state'] == 1){ ?>
                            <span class="layui-btn layui-btn-normal layui-btn-mini">未发货</span>
                            <?php }else if($v['state'] == 2){ ?>
                            <span class="layui-btn layui-btn-normal layui-btn-mini">已发货</span>
                            <?php }else{ ?>
                            <span class="layui-btn layui-btn-normal layui-btn-mini">订单完成</span>
                            <?php } ?>
                        </td>
                        <td><?=date('Y-m-d H:i:s',$v['add_time'])?></td>
                        <td><?=$v['area']?><?=$v['address']?></td>
                        <td class="td-manage">
                            <a style="text-decoration:none" onclick="order(this,'<?=$v['id']?>','<?=$v['state']?>')" href="javascript:;">
                                <i class="layui-icon">
                                    <?php if($v['state'] == 1) echo "&#xe62f;";else if($v['state'] == 2) echo "&#xe62f;";else echo "&#x1005;";?>
                                </i>
                            </a>
                            <!-- <a title="编辑" href="javascript:;" onclick="ad_edit('编辑','ad-edit.php?id=<?=$v['id']?>','<?=$v['id']?>','','510')"
                            class="ml-5" style="text-decoration:none">
                                <i class="layui-icon">&#xe642;</i>
                            </a> -->
                            <!-- <a title="删除" href="javascript:;" onclick="ad_del(this,'<?=$v['id']?>')" 
                            style="text-decoration:none">
                                <i class="layui-icon">&#xe640;</i>
                            </a> -->
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
        <script type="text/javascript">
            //状态修改 
            function order(obj,id,state){
                $.ajax({
                    url:'../common/ajax.php?type=update_order_state',
                    data:{
                        id:id,
                        state:state,
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
                   layer.confirm('确认发货吗？',function(index){
                        layer.msg('已发架!',{icon: 6,time:1000});
                    }); 
                }else if(state == 2){
                    layer.confirm('确认完成订单吗？',function(index){
                        layer.msg('已成功!',{icon: 6,time:1000});
                    });
                }             
            }


        </script>
       
    </body>
</html>