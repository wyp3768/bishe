<?php
	include './config/config.php';
    include './config/database.php';
    include './config/session.php';
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

	$sql_cart = "SELECT s.id,s.shoucun,s.kezi,g.goods_img,g.goods_name,g.goods_price,g.series_id,g.color,g.zl FROM `wyp_shopcart` AS s INNER JOIN `wyp_goods_list` AS g ON s.goods_id = g.id WHERE s.user_id =".$user_id;
	$res_cart = mysqli_query($conn,$sql_cart);
    $cart = array();
    while($rows_cart = mysqli_fetch_assoc($res_cart)){
        $cart[] = $rows_cart;
    }

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
					<?php if($n['nav_name'] == '购物车'): ?>
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
	<!-- 购物车 -->
	<div class="cent858">
		<div class="nav_info">
			<span><a href="index.php">首页</a></span>
			<span>></span>
			<span><a href="goods_list.php">求婚戒指</a></span>
			<span>></span>
			<span><a href="goods_list.php">所有商品</a></span>
			<span>></span>
			<span class="pink_color">购物车</span>
		</div>
		<div class="sh_schedule">
			<div class="sh_sc_left fl">购物车</div>
			<div class="sh_sc_pic fr"><img src="img/shopcat2.png"></div>
		</div>
		<div class="shopcart">
			<div class="shop_head">
				<li class="fl"><input type="checkbox" class="shop_box" id="checkall"><span>全选</span></li>
				<li class="li1 fl">商品</li>
				<li class="li2 fl">戒指内侧刻字</li>
				<li class="li3 fl">手寸</li>
				<li class="li4 fl">价格</li>
				<li class="li5 fl">操作</li>
			</div>
			<?php foreach ($cart as $c): ?>
				<div class="shop_goods cl">
					<div class="sh_go_select fl">
						<input type="checkbox" class="sh_select_box son" name="check" value="<?=$c['goods_price']?>" cartid="<?=$c['id']?>">
					</div>
					<div class="sh_go_pic fl"><img src="<?=substr($c['goods_img'],3)?>"></div>
					<div class="sh_go_word fl">
						<p class="p1"><?php 
							$sql_series = "SELECT series FROM wyp_cate_series WHERE id=".$c['series_id'];
							$res_series = mysqli_query($conn,$sql_series);
							$rows_series = mysqli_fetch_assoc($res_series);
							echo $rows_series['series'];
							?> 系列 <?=$c['goods_name']?></p>
						<p class="p2"><?=$c['color']?>；<?=$c['zl']?>；钻石女戒</p>
					</div>
					<!-- 刻字 -->
					<div class="sh_go_engraved fl"><?=$c['kezi']?></div>	
					<div class="sh_go_handinch fl"><?=$c['shoucun']?></div>
					<div class="sh_go_price fl">￥ <?=$c['goods_price']?></div>	
					<div class="sh_go_delete fl" onclick="del('<?=$c['id']?>')">删除</div>		
				</div>
			<?php endforeach ?>
			<div class="shop_footer">
				<div class="sh_fo_empty fl" onclick="cartempty('<?=$user_id?>')">清空购物车</div>
				<div class="sh_fo_goon fl"><a href="goods_list.php">继续购物</a></div>
				<div class="sh_fo_payable fr">
					本次应付：<span class="pink_color">￥ 
						<span class="allprice"></span>
					</span>
				</div>
				<div class="sh_fo_total fr">
					订单总额：<span>￥
						<span class="allprice"></span>
					</span>
				</div>
				<div class="sh_fo_selected fr">已选<span class="pink_color checked_num">0</span>件商品</div>
			</div>
			<div class="jiezhang fr jiesuan" style="cursor:pointer">去结算</div>
		</div>
	</div>
	<!-- 购物车结束 -->
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
<script type="text/javascript" src="js/total.js"></script>
<script type="text/javascript">
	$('.tuichu').click(function(){
        $.ajax({
            url:'./common/qajax.php?type=out',
            type:'post',
            dataType:'json',
            success:function(data){
                if(data.errno==1){
                        location.href = data.url;
                }else{
                    return false;
                }
            },
            error:function(e){
                console.log(e.responseText);
            }
        });

	});	
	$(function(){
		$('.jiesuan').click(function(){
			var arr = Array();
            var j = 0;
            $('.son').each(function(i,e){
                if($(this).prop('checked')){
                    arr[j] = $(this).attr("cartid");
                    j++;
                }
            });
            str = arr.join(',');
            // console.log(str);
			var goods_num = parseInt($('.checked_num').text());
			if(goods_num != 0){
				location.href = 'address.php?gc_ids='+str;
			}
		});

	});
</script>
</html>