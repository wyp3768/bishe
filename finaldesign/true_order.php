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

	$gc_ids = isset($_GET['gc_ids']) ? $_GET['gc_ids'] : 0;
	// print_r($gc_ids);
	$sql_cart = "SELECT s.id,s.shoucun,s.kezi,s.goods_id,g.goods_img,g.goods_name,g.goods_price,g.series_id,g.color,g.zl FROM `wyp_shopcart` AS s INNER JOIN `wyp_goods_list` AS g ON s.goods_id = g.id WHERE s.id IN (".$gc_ids.")";
	$res_cart = mysqli_query($conn,$sql_cart);
    $cart = array();
    while($rows_cart = mysqli_fetch_assoc($res_cart)){
        $cart[] = $rows_cart;
    }


    $a_id = isset($_GET['a_id']) ? $_GET['a_id'] : 0;
    $sql_area = "SELECT address,consignee,area,consig_phone,zipcode FROM `wyp_address` WHERE id=".$a_id;
	$res_area = mysqli_query($conn,$sql_area);
	$area = mysqli_fetch_assoc($res_area);

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
	<!-- 确认支付 -->
	<div class="t_o_mengban">
		<div class="t_o_ewm">
			<img src="img/erweima.png">
			<input type="button" class="quxiao" value="取消支付">
			<input type="button" class="queding" value="确认支付">
		</div>	
	</div>	

	<!-- 导航 -->
	<div class="nav">
		<div>
			<ul class="nav_list">
				<div class="nav_logo fl">
					<img src="img/logo.jpg" class="img1">
					<img src="img/only.png" class="img2">
				</div>
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
			<div class="sh_sc_left fl">确认订单</div>
			<div class="sh_sc_pic fr"><img src="img/shopcat4.png"></div>
		</div>
		<div class="shopcart">
			<div class="shop_head">
				<li class="fl"><input type="checkbox" class="shop_box" checked="checked"><span>全选</span></li>
				<li class="li1 fl">商品</li>
				<li class="li2 fl">戒指内侧刻字</li>
				<li class="li3 fl">手寸</li>
				<li class="li4 fl">价格</li>
				<li class="li5 fl">操作</li>
			</div>
			<?php foreach ($cart as $c): ?>
				<div class="shop_goods cl">
					<div class="sh_go_select fl">
						<input type="checkbox" class="sh_select_box son" name="check" value="<?=$c['goods_price']?>" cartid="<?=$c['id']?>"  checked="checked">
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
			<div class="tijiao_footer">
				<div class="ti_fo_left fl">
					<li>留言：<input type="text" placeholder="选填：对本次交易进行说明"></li>
					<li>发货地址：<?=$area['area']?>（根据您的收获地址确定实体店面进行发货）</li>
				</div>
				<div class="ti_fo_cen fl">
					<li>运送方式：OY派送员<!-- <input type="text" placeholder="快递 含邮费"> --></li>
					<li>发货时间：付款后3个工作日内发货</li>
				</div>
				<!-- <div class="ti_fo_right">￥ <span class="yunfen">30.00</span></div> -->
			</div>
			<div class="ti_fo_end">
				<div class="div1 fr">实付款：<span class="pink_color">￥ <span class="total"></span></span></div>
				<li>寄送至：<?=$area['area']?> <?=$area['address']?></li>
				<li>收货人：<?=$area['consignee']?></li>
				<input type="button" class="tijiao fr" value="提交订单">
			</div>
			
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

<script type="text/javascript">
	$(function(){
		var s = 0.00;
		$("input[type='checkbox'][name='check']").each(function () {
        	if(this.checked == true){
	            var id = $(this).val();
	            s += parseInt(id);
	        }
	    });
	    // var yunfen = parseInt($('.yunfen').text());
	    // var total = parseInt(s + yunfen);
	    $(".total").text(s);



	    $('.tijiao').click(function(){
	    	$('.t_o_mengban').show();
	    });

	    $('.quxiao').click(function(){
	    	$('.t_o_mengban').hide();
	    })


	    $('.queding').click(function(){
	    	var arr = Array();
            var j = 0;
            $('.son').each(function(i,e){
                if($(this).prop('checked')){
                    arr[j] = $(this).attr("cartid");
                    j++;
                }
            });
            var cartstr = arr.join(',');
            var a_id = <?=$a_id?>;

            $.ajax({
                url:'./common/qajax.php?type=order_add',
                data:{a_id:a_id,cart_ids:cartstr,user_id:<?=$user_id?>},
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
	})
</script>
</html>