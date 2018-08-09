<?php    
    if($_GET['action'] == "logout"){  
    	session_start();       
        $_SESSION=array(); 
    };




    // $idd = mysqli_insert_id($conn);   //刚生成的主键id

?>


<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>登录页面</title>
<link type="text/css" rel="stylesheet" href="css/normalize.css" />
<link type="text/css" rel="stylesheet" href="css/demo.css" />
<!--必要样式-->
<link type="text/css" rel="stylesheet" href="css/component.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<!--[if IE]>
<script src="js/html5.js"></script>
<![endif]-->
</head>

<body>
<div class="container demo-1">
	<div class="content">
		<div id="large-header" class="large-header">
			<canvas id="demo-canvas"></canvas>
			<div class="logo_box">
				<h3>欢迎登录</h3>
				<div>
					<div class="input_outer">
						<span class="u_user"></span>
						<input name="logname" class="text" style="color: #FFFFFF !important" type="text" placeholder="请输入账户">
					</div>
					<div class="input_outer">
						<span class="us_uer"></span>
						<input name="logpass" class="text" style="color: #FFFFFF !important; position:absolute; z-index:100;"value="" type="password" placeholder="请输入密码">
					</div>
					<div class="mb2" style="cursor:pointer;"><a class="act-but submit" style="color: #FFFFFF">登录</a></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/TweenLite.min.js"></script>
<script type="text/javascript" src="js/EasePack.min.js"></script>
<script type="text/javascript" src="js/rAF.js"></script>
<script type="text/javascript" src="js/demo-1.js"></script>
</body>
<script src="./lib/layui/layui.js" charset="utf-8"></script>       
<script type="text/javascript">
	$(function(){
		layui.use(['form'],
		function(){
			layer = layui.layer;
			$('.mb2').click(function(){
				var ad_name = /^[A-z]\w{3,17}$/; 
				var admin_name = $('[name="logname"]').val();
				if(admin_name == ''){
					layer.alert('用户名不能为空');
					return false;
				}
				if(ad_name.test(admin_name) == false){
					layer.alert('用户名格式不正确！');
					return false;	
				}
				var admin_pass = $('[name="logpass"]').val();
				if(admin_pass == ''){
					layer.alert('密码不能为空');
					return false;
				}
				$.ajax({
					url:'../common/ajax.php?type=login',
					data:{
						admin_name:admin_name,
						admin_pass:admin_pass,
					},
					type:'post',
					dataType:'json',
					success:function(json){
						if(json.errno == 1){
							layer.alert(json.error);
							location.href = json.url;	
						}else if(json.errno == 2){
							layer.alert(json.error);
							return false;	
						}else{
							layer.alert(json.error);
							return false;
						}			
					},
					error:function(e){
						console.log(e.responseText);
					},
				});
			});
		});
	});
</script>
</html>