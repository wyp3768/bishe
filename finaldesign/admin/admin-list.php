<?php
    include '../config/config.php';
    include '../config/database.php';
    include './common/session.php';
    $sql_select = "SELECT a.id,a.admin_name,a.admin_pass,a.role_id,a.phone,a.email,a.state,a.add_time,r.role_name FROM `wyp_admin` AS a INNER JOIN `wyp_admin_role` AS r ON a.role_id = r.id WHERE 1";
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
              <a><cite>管理员管理</cite></a>
              <a><cite>管理员列表</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>
        <div class="x-body">
            <!-- <form class="layui-form x-center" action="" style="width:80%">
                <div class="layui-form-pane" style="margin-top: 15px;">
                  <div class="layui-form-item">
                    <label class="layui-form-label">日期范围</label>
                    <div class="layui-input-inline">
                      <input class="layui-input" placeholder="开始日" id="LAY_demorange_s">
                    </div>
                    <div class="layui-input-inline">
                      <input class="layui-input" placeholder="截止日" id="LAY_demorange_e">
                    </div>
                    <div class="layui-input-inline">
                      <input type="text" name="username"  placeholder="请输入登录名" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline" style="width:80px">
                        <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                    </div>
                  </div>
                </div> 
            </form> -->
            <xblock><button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button><button class="layui-btn" onclick="admin_add('添加用户','admin-add.php','600','500')"><i class="layui-icon">&#xe608;</i>添加</button><span class="x-right" style="line-height:40px">共有数据：<?=$num?> 条</span></xblock>
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
                            登录名
                        </th>
                        <th>
                            手机
                        </th>
                        <th>
                            邮箱
                        </th>
                        <th>
                            角色
                        </th>
                        <th>
                            加入时间
                        </th>
                        <th>
                            状态
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>                    
                </thead>
                <tbody>
                    <?php foreach ($arr as $key => $v): ?>
                    <tr>
                        <td>
                            <input type="checkbox" value="<?=$v['id']?>" name="" class="check">
                        </td>
                        <td>
                           <?=$v['id']?>
                        </td>
                        <td>
                            <?=$v['admin_name']?>
                        </td>
                        <td >
                            <?=$v['phone']?>
                        </td>
                        <td >
                            <?=$v['email']?>
                        </td>
                        <td >
                            <?=$v['role_name']?>
                        </td>
                        <td>
                            2017-01-01 11:11:42
                        </td>
                        <td class="td-status">
                            <?php if($v['state'] == 1){ ?>
                            <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
                            <?php }else{ ?>
                            <span class="layui-btn layui-btn-disabled layui-btn-mini">已禁止</span>
                            <?php } ?>
                        </td>
                        <td class="td-manage">
                            <a style="text-decoration:none" onclick="admin(this,'<?=$v['id']?>','<?=$v['state']?>')" href="javascript:;" >
                                <i class="layui-icon">
                                    <?php if($v['state'] == 1) echo "&#xe601;";else echo "&#xe62f;";?>
                                </i>
                            </a>
                            <a title="编辑" href="javascript:;" onclick="admin_edit('编辑','admin-edit.php?id=<?=$v['id']?>','<?=$v['id']?>','','510')"
                            class="ml-5" style="text-decoration:none">
                                <i class="layui-icon">&#xe642;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="admin_del(this,'<?=$v['id']?>')" 
                            style="text-decoration:none">
                                <i class="layui-icon">&#xe640;</i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- <div id="page"></div> -->
        </div>
        <script src="./js/jquery.min.js" charset="utf-8"></script>
        <script src="./lib/layui/layui.js" charset="utf-8"></script>
        <script src="./js/x-layui.js" charset="utf-8"></script>
        <script>
            layui.use(['laydate','element','laypage','layer'], function(){
                // $ = layui.jquery;//jquery
              laydate = layui.laydate;//日期插件
              lement = layui.element();//面包导航
              laypage = layui.laypage;//分页
              layer = layui.layer;//弹出层

              //以上模块根据需要引入

              laypage({
                cont: 'page'
                ,pages: 100
                ,first: 1
                ,last: 100
                ,prev: '<em><</em>'
                ,next: '<em>></em>'
              }); 
              
              var start = {
                min: laydate.now()
                ,max: '2099-06-16 23:59:59'
                ,istoday: false
                ,choose: function(datas){
                  end.min = datas; //开始日选好后，重置结束日的最小日期
                  end.start = datas //将结束日的初始值设定为开始日
                }
              };
              
              var end = {
                min: laydate.now()
                ,max: '2099-06-16 23:59:59'
                ,istoday: false
                ,choose: function(datas){
                  start.max = datas; //结束日选好后，重置开始日的最大日期
                }
              };
              
              document.getElementById('LAY_demorange_s').onclick = function(){
                start.elem = this;
                laydate(start);
              }
              document.getElementById('LAY_demorange_e').onclick = function(){
                end.elem = this
                laydate(end);
              }
              
            });

            //批量删除提交
             function delAll () {
                layer.confirm('确认要删除吗？',function(index){
                    //捉到所有被选中的，发异步进行删除
                    layer.msg('删除成功', {icon: 1});
                });
             }
             /*添加*/
            function admin_add(title,url,w,h){
                x_admin_show(title,url,w,h);
            }


            function admin(obj,id,state){
                $.ajax({
                    url:'../common/ajax.php?type=update_admin_state',
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
                   layer.confirm('确认要禁用吗？',function(index){
                        layer.msg('已禁用!',{icon: 6,time:1000});
                    }); 
                }else{
                    layer.confirm('确认要启用吗？',function(index){
                        layer.msg('已启用!',{icon: 6,time:1000});
                    });
                }                
            }
            //  /*停用*/
            // function admin_stop(obj,id){
            //     layer.confirm('确认要停用吗？',function(index){
            //         //发异步把用户状态进行更改
            //         $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="admin_start(this,id)" href="javascript:;" title="启用"><i class="layui-icon">&#xe62f;</i></a>');
            //         $(obj).parents("tr").find(".td-status").html('<span class="layui-btn layui-btn-disabled layui-btn-mini">已停用</span>');
            //         $(obj).remove();
            //         layer.msg('已停用!',{icon: 5,time:1000});
            //     });
            // }

            // /*启用*/
            // function admin_start(obj,id){
            //     layer.confirm('确认要启用吗？',function(index){
            //         //发异步把用户状态进行更改
            //         $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="admin_stop(this,id)" href="javascript:;" title="停用"><i class="layui-icon">&#xe601;</i></a>');
            //         $(obj).parents("tr").find(".td-status").html('<span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>');
            //         $(obj).remove();
            //         layer.msg('已启用!',{icon: 6,time:1000});
            //     });
            // }
            //编辑
            function admin_edit (title,url,id,w,h) {
                x_admin_show(title,url,w,h); 
            }
            /*删除*/
            function admin_del(obj,id){
               layer.confirm('确认要删除吗？',function(index){
                     $.ajax({
                        url:'../common/ajax.php?type=del_admin',
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