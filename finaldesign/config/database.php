<?php
	$dbhost = 'localhost'; //mysql服务器主机地址
	$dbuser = 'root';      //mysql用户名
	$dbpass = 'root';      //mysql用户密码
	$conn   = mysqli_connect($dbhost,$dbuser,$dbpass) or die ('数据库连接失败');//数据库连接
	mysqli_select_db($conn,'wyp_diamonds') or die ('数据库不存在');//选择数据库
	mysqli_query($conn,'set names utf8');//设置数据库编码
?>