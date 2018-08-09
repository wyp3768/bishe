<?php
    include '../config/config.php';
    include '../config/database.php';
    include './common/session.php';
    $sql_select = "SELECT id,role_name FROM `wyp_admin_role`  WHERE 1";
    $res = mysqli_query($conn,$sql_select);
    while($rows = mysqli_fetch_assoc($res)){
        $arr[] = $rows;
    }
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
                    <label for="username" class="layui-form-label">
                        <span class="x-red">*</span>登录名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="admin_name" name="admin_name" required="" lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>将会成为您唯一的登入名
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="phone" class="layui-form-label">
                        <span class="x-red">*</span>手机
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="phone" name="phone" required="" lay-verify="phone"
                        autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>将会成为您唯一的登入名
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_email" class="layui-form-label">
                        <span class="x-red">*</span>邮箱
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_email" name="email" required="" lay-verify="email"
                        autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="role" class="layui-form-label">
                        <span class="x-red">*</span>角色
                    </label>
                    <div class="layui-input-inline">
                      <select name="role_id">
                        <option value="">请选择角色</option>
                        <?php foreach($arr as $v): ?>
                        <option value="<?=$v['id']?>"><?=$v['role_name']?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_pass" class="layui-form-label">
                        <span class="x-red">*</span>密码
                    </label>
                    <div class="layui-input-inline">
                        <input type="password" id="L_pass" name="admin_pass" required="" lay-verify="pass"
                        autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        6到16个字符
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">
                        <span class="x-red">*</span>确认密码
                    </label>
                    <div class="layui-input-inline">
                        <input type="password" id="L_repass" name="repass" required="" lay-verify="repass"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">
                    </label>
                    <input  type="button" class="layui-btn sub" lay-filter="add" lay-submit="" value="增加">
                </div>
            </form>
        </div>
        <script src="./js/jquery.min.js" charset="utf-8"></script>
        <script src="./lib/layui/layui.js" charset="utf-8"></script>
        <script src="./js/x-layui.js" charset="utf-8"></script>
        <script>
            layui.use(['form','layer'], function(){
              var form = layui.form()
              ,layer = layui.layer;
            
              //自定义验证规则
              form.verify({
                nikename: function(value){
                  if(value.length < 5){
                    return '昵称至少得5个字符啊';
                  }
                }
                ,pass: [/(.+){5,12}$/, '密码必须6到12位']
                ,repass: function(value){
                    if($('#L_pass').val()!=$('#L_repass').val()){
                        return '两次密码不一致';
                    }
                }
              });

              $('.sub').click(function(){
                    var admin_name = $('[name="admin_name"]').val();
                    if(admin_name == ''){
                        layer.msg('管理员名不能为空');
                        return false;
                    }
                    var phone = $('[name="phone"]').val();
                    if(admin_name == ''){
                        layer.msg('手机号不能为空');
                        return false;
                    }
                    var email = $('[name="email"]').val();
                    if(admin_name == ''){
                        layer.msg('邮箱不能为空');
                        return false;
                    }
                    var role_id = $('[name="role_id"]').val();
                    if(admin_name == ''){
                        layer.msg('请选择权限');
                        return false;
                    }
                    var admin_pass = $('[name="admin_pass"]').val();
                    if(admin_name == ''){
                        layer.msg('密码不能为空');
                        return false;
                    }
                    
                    $.ajax({
                        url:'../common/ajax.php?type=add_admin',
                        data:{
                            admin_name:admin_name,
                            phone:phone,
                            email:email,
                            role_id:role_id,
                            admin_pass:admin_pass,
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