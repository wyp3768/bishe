<?php
	include './config/config.php';
    include './config/database.php';
    $sql_select = "SELECT id,nav_name,nav_link FROM `wyp_nav` WHERE 1 ORDER BY id ASC";
    $res = mysqli_query($conn,$sql_select);
    $nav = array();
    while($rows = mysqli_fetch_assoc($res)){
        $nav[] = $rows;
    }

    // SESSION 判断用户ID
    if(isset($_SESSION['user_id'])){
	    $user_id = $_SESSION['user_id'];
		$sql_user = "SELECT username,user_phone,password,add_time FROM `wyp_userinfo` WHERE id=".$user_id;
		$res_user = mysqli_query($conn,$sql_user);
		$user = mysqli_fetch_assoc($res_user);
	}

	$gc_ids = isset($_GET['gc_ids']) ? $_GET['gc_ids'] : 0;
	$sql_cart = "SELECT id FROM `wyp_shopcart` WHERE id IN (".$gc_ids.")";
	$res_cart = mysqli_query($conn,$sql_cart);
    $cart = array();
    while($rows_cart = mysqli_fetch_assoc($res_cart)){
        $cart[] = $rows_cart;
    }
    // print_r($cart);
    // $str = implode(",",$cart[]);
    // print_r($str);
?>


<!DOCTYPE html>
<html>
<head>
	<title>购物车</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/swiper.min.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
	<div style="display:none;">
		<?php foreach ($cart as $c): ?>
			<input type="checkbox" class="son" cartid="<?=$c['id']?>" checked="checked">
		<?php endforeach ?>
	</div>
	<!-- 导航 -->
	<div class="nav">
		<div>
			<ul class="nav_list">
				<div class="nav_logo fl">
					<img src="img/logo.jpg" class="img1">
					<img src="img/only.png" class="img2">
				</div>
				<!-- <li class="pink_now"><a href="index.php">首页<div class="pink_line"></div></a></li> -->
				<?php foreach ($nav as $n): ?>
					<?php if($n['nav_name'] == '品牌文化'): ?>
						<li class="pink_now"><a href="<?=$n['nav_link']?>"><?=$n['nav_name']?><div class="pink_line"></div></a></li>
					<?php else: ?>
						<li><a href="<?=$n['nav_link']?>"><?=$n['nav_name']?><div class="pink_line"></div></a></li>	
					<?php endif ?>
					
				<?php endforeach ?>
				<?php if(!isset($_SESSION['user_id'])): ?>
					<li>
						<div class="fl"><a href="login.html">登录<div class="pink_line"></div></a></div>
						<div class="black_line fl"></div>
						<div class="fl"><a href="register.html">注册<div class="pink_line"></div></a></div>
					</li>
				<?php else: ?>
					<li>
						<div class="fl"><?=$user['username']?><div class="pink_line"></div></div>
						<div class="black_line fl"></div>
						<div class="fl tuichu"><a href="">退出<div class="pink_line"></div></a></div>
					</li>
				<?php endif ?>
			</ul>
		</div>
	</div>
	<!-- 导航结束 -->
	<!--  -->
	<div class="b_c_one">
		<div class="bco_pic"><img src="img/culture1.png"></div>
		<div class="bco_pic"><img src="img/culture2.png"></div>
		<div class="bco_pic"><img src="img/culture3.png"></div>
		<div class="bco_pic"><img src="img/culture4.jpg"></div>
	</div>
	<!--  -->
	<!-- 售后 -->
	<div class="after_sale cl">
		<div class="cent858">
			<div class="after_sale_pic"><img src="img/bottom.png"></div>
			<ul class="after_sale_list">
				<li>
					<p class="p1">服务保障</p>
					<p class="p2">珠宝课堂</p>
					<p class="p2">帮助中心</p>
					<p class="p2">新闻资讯</p>
				</li>
				<li>
					<p class="p1">售后服务</p>
					<p class="p2">售后政策</p>
					<p class="p2">15天退货</p>
					<p class="p2">以大换小</p>
				</li>
				<li>
					<p class="p1">购物指南</p>
					<p class="p2">购物流程</p>
					<p class="p2">订单处理</p>
					<p class="p2">订单查询</p>
				</li>
				<li>
					<p class="p1">支付方式</p>
					<p class="p2">在线支付</p>
					<p class="p2">货到付款</p>
					<p class="p2">银行汇款</p>
				</li>
				<li>
					<p class="p1">关于我们</p>
					<p class="p2">品牌简介</p>
					<p class="p2">联系我们</p>
					<p class="p2">加入我们</p>
				</li>
			</ul>
		</div>
	</div>
	<!-- 售后结束 -->
	<!-- 版权信息 -->
	<div class="copyright">
		<div class="cent858">
			<p>Copyright &copy; 2006-2018 www.onlyyou.com 只为你珠宝 All Right Reserved. 京ICP备11012085号-2</p>
		</div>
	</div>
	<!-- 版权信息结束 -->
</body>
</html>