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

	if(isset($_SESSION['user_id'])){
	    $user_id = $_SESSION['user_id'];
		$sql_user = "SELECT username,user_phone,password,add_time FROM `wyp_userinfo` WHERE id=".$user_id;
		$res_user = mysqli_query($conn,$sql_user);
		$user = mysqli_fetch_assoc($res_user);
	}

?>




<!DOCTYPE html>
<html>
<head>
	<title>个人中心</title>
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
					<?php if($n['nav_name'] == '个人中心'): ?>
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
	<!-- 中间内容 -->
	<div class="cent858">
		<div class="uc_k"></div>
		<!-- 左边导航 -->
		<div class="uc_nav fl">
			<div class="uc_d tab">个人资料</div>
			<div class="uc_d tab">账户管理</div>
			<div class="uc_d tab">地址信息</div>
			<div class="uc_d tab">我的订单</div>
			<div><a href="shop_cart.php">购物车</a></div>
		</div>
		<div class="uc_con fr">
			<div class="content uc_con1">
				<li class="uc_one">用户名：<span><?=$user['username']?></span></li>
				<li class="uc_one">手机号：<span><?=$user['user_phone']?></span></li>
			</div>
			<div class="content uc_con1">
				<label class="uc_one">用户名：<input type="text" value="<?=$user['username']?>" class="name"> </label>
				<li class="uc_one">手机号：<span><?=$user['user_phone']?></span></li>
				<label class="uc_one">密码：<input type="password" value="<?=$user['password']?>" class="pass"></label><br>
				<input type="button" class="sub put_address" value="修改">
			</div>
			<div class="content uc_con1">
				<?php
					$sql_dz = "SELECT address,consignee,area,consig_phone,zipcode FROM `wyp_address` WHERE user_id=".$user_id;
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
					</tr>
					<?php foreach ($dizhi as $d): ?>
					<tr>
						<td><?=$d['consignee']?></td>
						<td><?=$d['area']?><?=$d['address']?></td>
						<td><?=$d['consig_phone']?></td>
						<td><?=$d['zipcode']?></td>
					</tr>
					<?php endforeach ?>
				</table>

				<div class="uc_con_div">添加新地址</div>
				<div class="uc_con_div">
					<label><span class="pink_color">*</span>所在地区</label>
					<input type="text" placeholder="山西省/太原市/小店区" class="add_area">
				</div>
				<div class="uc_con_div">
					<li class="fl"><span class="pink_color">*</span>详细地址</li>
					<textarea placeholder="请填写详细地址" class="add_detailed"></textarea>
				</div>
				<div class="uc_con_div">
					<label><span class="pink_color">*</span>收货人</label>
					<input type="text" placeholder="请使用真是姓名" class="add_consignee">
				</div>
				<div class="uc_con_div">
					<label><span class="pink_color">*</span>手机号码</label>
					<input type="text" placeholder="请填写有效的手机号" class="add_phone">
				</div>
				<div class="uc_con_div">
					<label><span class="pink_color">*</span>邮政编码</label>
					<input type="text" placeholder="" class="add_zipcode">
				</div>	
				<div><input type="button" value="提交地址" class="put_address sub2"></div>
				</div>
			<div class="content uc_con1">
				<?php
					$sql_order = "SELECT o.*,g.goods_name,g.goods_img,u.username,d.area,d.address,d.consignee FROM `wyp_order` AS o INNER JOIN wyp_goods_list AS g ON o.goods_id = g.id INNER JOIN wyp_userinfo AS u ON o.user_id = u.id INNER JOIN wyp_address AS d ON o.address_id = d.id WHERE o.user_id=".$user_id." ORDER BY o.add_time DESC";
    				$res_order = mysqli_query($conn,$sql_order); 
    				$order_num = mysqli_num_rows($res_order); 
    				$ord = array();  				
    				while($rows_order = mysqli_fetch_assoc($res_order)){
				        $ord[] = $rows_order;
				    }
				?>
				<?php if($order_num <= 0): ?>
					<div>暂无订单信息</div>
				<?php else: ?>
					<table border=1>
						<tr>
							<th>id</th>
							<th>产品名</th>
							<th>产品图</th>
							<th>价格</th>
							<th>手寸</th>
							<th>刻字</th>
							<th>地址</th>
							<th>收货人</th>
							<th>状态</th>
						</tr>
						<?php foreach ($ord as $o): ?>
							<tr>
								<td><?=$o['id']?></td>
								<td><?=$o['goods_name']?></td>
								<td><img src="<?=substr($o['goods_img'],3)?>" style="width:30px;height:30px;"></td>
								<td><?=$o['price']?></td>
								<td><?=$o['shoucun']?></td>
								<td><?=$o['kezi']?></td>
								<td><?=$o['area']?><?=$o['address']?></td>
								<td><?=$o['consignee']?></td>
								<td>
									<?php if($o['state'] == 1): ?>
										未发货
									<?php elseif($o['state'] == 2): ?>
										已发货	
									<?php elseif($o['state'] == 3): ?>
										订单已完成	
									<?php endif ?>
								</td>	
							</tr>
						<?php endforeach ?>
					</table>					
				<?php endif ?>	
			</div>
		</div>
		<!-- 右边内容 -->
	</div>
	<!-- 中间内容结束 -->
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
	
	layui.use(['laydate','element','laypage','layer'], function(){
        laydate = layui.laydate;//日期插件
        lement = layui.element();//面包导航
        laypage = layui.laypage;//分页
        layer = layui.layer;//弹出层
    });
	$(function(){
		$('.content').hide();
		$('.content').eq(0).show();
		$('.tab').eq(0).css({'color':'#ffb1a1'});
		$('.tab').click(function(){
			var index = $(this).index(); // 获取当前下标
			$('.tab').eq(index).css({'color':'#ffb1a1'}).siblings().css({'color':'#333'});
			$('.content').eq(index).show().siblings().hide(); // 将对应选项卡显示兄弟选项卡隐藏
		});
		// 修改用户信息
		$('.sub').click(function(){
			var name = $('.name').val();
			var pass = $('.pass').val();
            $.ajax({
                url:'./common/qajax.php?type=user_update',
                data:{
                	id:<?=$user_id?>,
                    username:name,
                    password:pass,
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
