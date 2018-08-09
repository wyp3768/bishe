<?php
	header('content-type:text/html;charset=utf-8');
	session_start(); //开启session
	header("Access-Control-Allow-Origin:*");
	header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); 
	date_default_timezone_set('Asia/Shanghai');


	error_reporting(0);   // 屏蔽所有错误   	
	// 开启所有错误     error_reporting(E_ALL);



?>