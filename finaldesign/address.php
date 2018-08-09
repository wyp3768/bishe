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
	<!-- 填写地址 -->
	<div class="cent858 posi_r">
		<div class="nav_info">
			<span><a href="index.html">首页</a></span>
			<span>></span>
			<span><a href="goods_list.html">求婚戒指</a></span>
			<span>></span>
			<span><a href="goods_list.html">所有商品</a></span>
			<span>></span>
			<span class="pink_color">购物车</span>
		</div>
		<div class="sh_schedule">
			<div class="sh_sc_left fl">填写地址</div>
			<div class="sh_sc_pic fr"><img src="img/shopcat3.png"></div>
		</div>
		<div class="address">
			<div>
				<label><span class="pink_color">*</span>所在地区</label>
				<input type="text" placeholder="山西省/太原市/小店区" class="add_area">
			</div>
			<div>
				<li class="fl"><span class="pink_color">*</span>详细地址</li>
				<textarea placeholder="请填写详细地址" class="add_detailed"></textarea>
			</div>
			<div>
				<label><span class="pink_color">*</span>收货人</label>
				<input type="text" placeholder="请使用真是姓名" class="add_consignee">
			</div>
			<div>
				<label><span class="pink_color">*</span>手机号码</label>
				<input type="text" placeholder="请填写有效的手机号" class="add_phone">
			</div>
			<div>
				<label><span class="pink_color">*</span>邮政编码</label>
				<input type="text" placeholder="" class="add_zipcode">
			</div>	
			<div><input type="button" value="提交地址" class="put_address sub2"></div>
		</div>
		<!-- 选择地址 -->
		<div class="choose_add">
			<?php
				$sql_dz = "SELECT id,address,consignee,area,consig_phone,zipcode FROM `wyp_address` WHERE user_id=".$user_id;
				// print_r($sql_dz);
				$res_dz = mysqli_query($conn,$sql_dz);  
				$ord = array();  				
				while($rows_dz = mysqli_fetch_assoc($res_dz)){
			        $dizhi[] = $rows_dz;
			    }
			?>
		
			<table border=1>
				<tr>
					<th>收货人</th>
					<th>地址</th>
					<th>手机号</th>
					<th>邮编</th>
					<th>选择地址</th>
				</tr>
				<?php foreach ($dizhi as $d): ?>
				<tr>
					<td><?=$d['consignee']?></td>
					<td><?=$d['area']?><?=$d['address']?></td>
					<td><?=$d['consig_phone']?></td>
					<td><?=$d['zipcode']?></td>
					<td><button value="<?=$d['id']?>" class="sub put_address" style="margin:0;">选择地址</button></td>
				</tr>
				<?php endforeach ?>
			</table>
			<div>选择地址进入结算页面</div>
		</div>
	</div>
	<!-- 填写地址结束 -->
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
<script src="./admin/lib/layui/layui.js" charset="utf-8"></script>
<script src="./admin/js/x-layui.js" charset="utf-8"></script>
<script type="text/javascript" src="js/swiper.min.js"></script>
<script type="text/javascript">
	$(function(){
		layui.use(['laydate','element','laypage','layer'], function(){
	        laydate = layui.laydate;//日期插件
	        lement = layui.element();//面包导航
	        laypage = layui.laypage;//分页
	        layer = layui.layer;//弹出层
	    });
	    // 传输地址
	    $('.sub').click(function(){
	    	var a_id = $(this).val();
	    	var arr = Array();
            var j = 0;
            $('.son').each(function(i,e){
                if($(this).prop('checked')){
                    arr[j] = $(this).attr("cartid");
                    j++;
                }
            });
	    	str = arr.join(',');
	    	location.href = 'true_order.php?a_id='+a_id+'&gc_ids='+str; 
	    	// console.log('true_order.php?a_id='+a_id+'&gc_ids='+str);  	
	    })  
		// 获取地址信息
		$('.sub2').click(function(){
			var area = $('.add_area').val();
			var detailed = $('.add_detailed').val();
			var address = area + detailed;
			var consig_phone = $('.add_phone').val();
			var consignee = $('.add_consignee').val();
			var zipcode = $('.add_zipcode').val();
            $.ajax({
                url:'./common/qajax.php?type=user_address',
                data:{
                	user_id:<?=$user_id?>,
                    address:address,
                    consig_phone:consig_phone,
                    consignee:consignee,
                    zipcode:zipcode,                 
                },
                type:'post',
                dataType:'json',
                success:function(data){
                    if(data.errno==1){
                    	layer.msg(data.error);
                       	setInterval(function(){
                            location=location;                                    
                        },1500);
                    }else{
                        layer.msg(data.error)
                        return false;
                    }
                },
                error:function(e){
                    console.log(e.responseText);
                }
            });
		});


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
	});
</script>
</html>