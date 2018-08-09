<?php
	if(!isset($_SESSION['user_id'])){
	    echo '<script>console.log("请先登录");location.href="login.html";</script>';
	    exit();
	}
	
?>
