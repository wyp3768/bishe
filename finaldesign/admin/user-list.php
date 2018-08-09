<?php
    include '../config/config.php';
    include '../config/database.php';
    include './common/session.php';
    $sql_select = "SELECT id,username,user_phone,password,add_time FROM `wyp_userinfo` WHERE 1";
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
                <a><cite>用户列表</cite></a>
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
                        <th>手机号</th>
                        <th>密码</th>                       
                        <th>添加时间</th>
                        <th>购物车</th>
                    </tr>
                </thead>
                <tbody id="x-img">
                    <?php foreach ($arr as $key => $v): ?>
                    <tr>
                        <!-- <td><input type="checkbox" value="<?=$v['id']?>" name=""></td> -->
                        <td><?=$v['id']?></td>                    
                        <td><?=$v['username']?></td>
                        <td><?=$v['user_phone']?></td>
                        <td><?=$v['password']?></td>
                        <td><?=date('Y-m-d H:i:s',$v['add_time'])?></td>
                        <td class="td-manage">
                            <a title="购物车" href="javascript:;" onclick="shopcart('购物车','user-shopcart.php?id=<?=$v['id']?>','610','510')"
                            class="ml-5" style="text-decoration:none">
                                <i class="layui-icon">&#xe628;</i>
                            </a>
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

       
    </body>
    <script>
            layui.use(['laydate','element','laypage','layer'], function(){
                
              laydate = layui.laydate;//日期插件
              lement = layui.element();//面包导航
              laypage = layui.laypage;//分页
              layer = layui.layer;//弹出层

              //以上模块根据需要引入
            });

            
             /*添加*/
            function shopcart(title,url,w,h){
                x_admin_show(title,url,w,h);
            }
    </script>
</html>