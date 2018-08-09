<?php
	include './config/config.php';
    include './config/database.php';
    $sql_select = "SELECT id,nav_name,nav_link FROM `wyp_nav` WHERE 1 ORDER BY id ASC";
    $res = mysqli_query($conn,$sql_select);
    $nav = array();
    while($rows = mysqli_fetch_assoc($res)){
        $nav[] = $rows;
    }

    $sql_select = "SELECT id,banner FROM `wyp_banner` WHERE 1";
    $res = mysqli_query($conn,$sql_select);
    $big_banner = array();
    while($rows = mysqli_fetch_assoc($res)){
        $big_banner[] = $rows;
    }

    $sql_select = "SELECT id,banner FROM `wyp_banner_little` WHERE 1";
    $res = mysqli_query($conn,$sql_select);
    $little_banner = array();
    while($rows = mysqli_fetch_assoc($res)){
        $little_banner[] = $rows;
    }


    if(isset($_SESSION['user_id'])){
	    $user_id = $_SESSION['user_id'];
		$sql_user = "SELECT username,user_phone,password,add_time FROM `wyp_userinfo` WHERE id=".$user_id;
		$res_user = mysqli_query($conn,$sql_user);
		$user = mysqli_fetch_assoc($res_user);
	}

    // echo md5(md5('W'.'15735183768'.'Y'.'15735183768'.'P'));
    // exit;
	// if($_GET['action'] == "logout"){  
 //    	session_start();       
 //        $_SESSION=array();  //清除session
 //    };
?>

<!DOCTYPE html>
<html>
<head>
	<title>首页</title>
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
					<?php if($n['nav_link'] == 'index.php'): ?>
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
	<!-- 大轮播 -->
	<div class="swiper-container1">
		<div class="swiper-wrapper">
			<?php foreach ($big_banner as $key => $v): ?>
				<div class="swiper-slide"><img src="<?=substr($v['banner'],3)?>"></div>
			<?php endforeach ?>
		</div>
		<!-- 如果需要分页器 -->
	    <div class="swiper-pagination"></div>
	</div>
	<!-- 大轮播结束 -->
	<!-- 热销系列 -->
	<div class="hot_series">
		<div class="cent858">
			<div class="cont_title">
				<p class="p1">HOT SERIES</p>
				<p class="p2">—- 热销系列 -—</p>
			</div>
			<div class="hot_list">
				<?php
					$sql_select = "SELECT g.id,g.goods_name,g.goods_img,g.goods_summary,g.series_id,se.series FROM `wyp_goods_list` AS g INNER JOIN `wyp_cate_series` AS se ON g.series_id = se.id  WHERE g.goods_hot=1 LIMIT 3";
				    $res = mysqli_query($conn,$sql_select);
				    $hot = array();
				    while($rows = mysqli_fetch_assoc($res)){
				        $hot[] = $rows;
				    }
				?>
				<?php foreach ($hot as $h): ?>
					<li><a href="goods_detail.php?id=<?=$h['id']?>">
						<img src="<?=substr($h['goods_img'],3)?>">
						<div class="hot_word">
							<p class="p1"><?=strtoupper($h['series'])?></p>
							<p class="p2"><?=$h['goods_name']?></p>
							<p class="p3"><?=$h['goods_summary']?></p>
						</div>
						<div class="black_mengban"></div>
						</a>
					</li>
				<?php endforeach ?>
				<!-- <li><a href="javascript:;">
					<img src="img/hot1.jpg">
					<div class="hot_word">
						<p class="p1">FIRST HEART</p>
						<p class="p2">初心</p>
						<p class="p3">[不忘初心,方得始终]</p>
					</div>
					<div class="black_mengban"></div>
					</a>
				</li>
				<li><a href="javascript:;">
					<img src="img/hot2.jpg">
					<div class="hot_word">
						<p class="p1">ACCOMPANY</p>
						<p class="p2">陪伴</p>
						<p class="p3">[陪伴是最长情的告白]</p>
					</div>
					<div class="black_mengban"></div>
					</a>
				</li>
				<li><a href="javascript:;">
					<img src="img/hot3.jpg">
					<div class="hot_word">
						<p class="p1">FOREVER</p>
						<p class="p2">相守</p>
						<p class="p3">[相知相守,白首不离]</p>
					</div>
					<div class="black_mengban"></div>
					</a>
				</li> -->
			</div>
		</div>
	</div>
	<!-- 热销系列结束 -->
	<!-- 诉说你的爱情故事 -->
	<?php
		$sql_select = "SELECT ad_pic FROM `wyp_ad`  WHERE id=4";
		$res = mysqli_query($conn,$sql_select);
		$ad = mysqli_fetch_assoc($res);
	?>
	<div class="banner_only cl"><img src="<?=substr($ad['ad_pic'],3)?>"></div>
	<!-- 。。。。。结束 -->
	<!-- 系列产品 -->
	<div class="product">
		<div class="cent858">
			<div class="cont_title">
				<p class="p1">SERIES PRODUCT</p>
				<p class="p2">—- 系列产品 -—</p>
			</div>
			<!-- 小轮播 -->
			<div class="lunbo858">
				<div class="swiper-button-prev" style="position:absolute;left:-60px;"></div>
				<div class="swiper-container2">
					<div class="swiper-wrapper">
						<?php foreach ($little_banner as $vv): ?>
							<div class="swiper-slide swiper2"><img src="<?=substr($vv['banner'],3)?>"></div>
						<?php endforeach ?>
					</div>
					<!-- 如果需要导航按钮 -->
				</div>
				<div class="swiper-button-next" style="position:absolute;right:-60px;"></div>
			</div>
			<!-- 小轮播结束 -->		
			<ul class="pro_set">
				<?php
					$sql_select = "SELECT g.id,g.goods_name,g.goods_img,g.goods_summary,g.series_id,se.series FROM `wyp_goods_list` AS g INNER JOIN `wyp_cate_series` AS se ON g.series_id = se.id  WHERE g.series_id=12 LIMIT 4";
				    $res = mysqli_query($conn,$sql_select);
				    $hot = array();
				    while($rows = mysqli_fetch_assoc($res)){
				        $show1[] = $rows;
				    }
				?>
				<?php foreach ($show1 as $sh1): ?>
					<li>
						<div class="p1"><?=$sh1['goods_name']?></div>
						<p><?=$sh1['goods_summary']?></p>
						<a href="goods_detail.php?id=<?=$sh1['id']?>"><div class="button">立即选购 ></div></a>
						<img src="<?=substr($sh1['goods_img'],3)?>">
					</li>
				<?php endforeach ?>

				<!-- <li>
					<div class="p1">CONTAIN</div>
					<p>爱是包容，让你我相融</p>
					<a href="javascript:;"><div class="button">立即选购 ></div></a>
					<img src="img/set1.jpg">
				</li>
				<li>
					<div class="p1">BECKONING</div>
					<p>每一次心动都是因为你</p>
					<a href="javascript:;"><div class="button">立即选购 ></div></a>
					<img src="img/set2.jpg">
				</li>
				<li>
					<div class="p1">QUEEN</div>
					<p>爱情里,你是我的女王</p>
					<a href="javascript:;"><div class="button">立即选购 ></div></a>
					<img src="img/set3.jpg">
				</li>
				<li>
					<div class="p1">WYATT ENJOY</div>
					<p>有你在的每一秒我都愉悦</p>
					<a href="javascript:;"><div class="button">立即选购 ></div></a>
					<img src="img/set4.jpg">
				</li> -->
			</ul>
			<ul class="series_set cl">
				<?php
					$sql_select = "SELECT g.id,g.goods_name,g.goods_img,g.goods_summary,g.series_id,se.series FROM `wyp_goods_list` AS g INNER JOIN `wyp_cate_series` AS se ON g.series_id = se.id  WHERE g.series_id=13 LIMIT 3";
				    $res = mysqli_query($conn,$sql_select);
				    $hot = array();
				    while($rows = mysqli_fetch_assoc($res)){
				        $show2[] = $rows;
				    }
				?>
				<?php foreach ($show2 as $sh2): ?>
					<li>
						<div class="s_s_pic"><img src="<?=substr($sh2['goods_img'],3)?>"></div>
						<div class="s_s_p">
							<div class="s_s_k"></div>
							<p class="p1"><?=$sh2['goods_name']?></p>
							<a href="goods_detail.php?id=<?=$sh2['id']?>"><p class="p2">立即选购 ></p></a>
						</div>
					</li>
				<?php endforeach ?>
				<!-- <li>
					<div></div>
					<p class="p1">Honey 系列 甜如密耳坠</p>
					<a href=""><p class="p2">立即选购 ></p></a>
				</li>
				<li>
					<div></div>
					<p class="p1">Honey 系列 甜如密耳坠</p>
					<a href=""><p class="p2">立即选购 ></p></a>
				</li>
				<li>
					<div></div>
					<p class="p1">Honey 系列 甜如密耳坠</p>
					<a href=""><p class="p2">立即选购 ></p></a>
				</li> -->
			</ul>

		</div>
	</div>
	<!-- 系列产品结束 -->
    <!-- banner_only-->
    <?php
		$sql_select = "SELECT ad_pic FROM `wyp_ad`  WHERE id=6";
		$res = mysqli_query($conn,$sql_select);
		$ad = mysqli_fetch_assoc($res);
	?>
	<div class="banner_only cl"><img src="<?=substr($ad['ad_pic'],3)?>"></div>
    <!-- 结束 -->
    <!-- 定制案例 -->
    <div class="custom">
    	<div class="cent858">
    		<div class="cont_title">
				<p class="p1">CUSTOM CASE</p>
				<p class="p2">—- 定制案例 -—</p>
			</div>
			<div class="custom_case">
				<div class="custom_pic fl"><img src="img/custom.jpg"></div>
				<div class="custom_word fl">
					<p class="p1">创作元素</p>
					<div class="bla_line"></div>
					<p class="p2">电影胶片</p>
					<p class="p3">每看完一场电影，就像彼此相守过无数个生生世世。</p>
					<p class="p3">婚戒以“电影胶片”为设计元素</p>
					<p class="p3">代表着他们相识相爱的点点滴滴，寓意着他们的爱情是一场永不散场的电影。</p>
					<a href="javascript:;"><div class="button fr">立即选购 >></div></a>
				</div>
			</div>
			<div class="custom_case">
				<div class="custom_word fl">
					<p class="p1">创作元素</p>
					<div class="bla_line"></div>
					<p class="p2">可爱多</p>
					<p class="p3">她的舌尖迷恋上了可爱多，她的心从此爱上了他。</p>
					<p class="p3">婚戒是以“可爱多”为元素设计，女戒以可爱多的形象融入设计，男戒融入可爱多顶部的漩涡形</p>
					<p class="p3">象征爱情甜如蜜，以此纪念这段故事。</p>
					<a href="javascript:;"><div class="button fr">立即选购 >></div></a>
				</div>
				<div class="custom_pic fl"><img src="img/custom2.jpg"></div>
			</div>
    	</div>
    </div>
    <!-- 定制案例结束 -->
    <!-- banner only you 4 -->
    <?php
		$sql_select = "SELECT ad_pic FROM `wyp_ad`  WHERE id=7";
		$res = mysqli_query($conn,$sql_select);
		$ad = mysqli_fetch_assoc($res);
	?>
	<div class="banner_only cl"><img src="<?=substr($ad['ad_pic'],3)?>"></div>
	<!-- banner4 结束 -->
	<!-- 售后服务 -->
	<div class="after_sale">
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
<script type="text/javascript" src="js/swiper.min.js"></script>
<script>
// 轮播调用swiper js代码
	var mySwiper1 = new Swiper ('.swiper-container1', {
		//direction: 'vertical',//垂直滑动
		direction: 'horizontal',//水平滑动
		loop: true,
		autoplay: true,
		autoplay: {
			delay: 3000,//1秒切换一次
			disableOnInteraction: false, //操作后继续自动切换
		}, //设置自动切换时间，单位毫秒
		grabCursor:true,//鼠标覆盖Swiper时指针会变成手掌形状，拖动时指针会变成抓手形状
		speed: 1000, //设置滑动速度
		// paginationClickable: true, // 点击分页器的指示点分页器会控制Swiper切换
		continuous: true, //无限循环的图片切换效果
		effect : 'fade',//切换效果淡出
		// 如果需要分页器
		pagination: {
			el: '.swiper-pagination',
			// dynamicBullets:'true',//隐藏小点
			clickable:'true',//点击
   			type:'custom',//自定义分液器样式
   			renderCustom: function (swiper, current, total) {
		     	var customPaginationHtml = "";             
	            for(var i = 0; i < total; i++) {  
	                //判断哪个分页器此刻应该被激活  
	                if(i == (current - 1)) {  
	                    customPaginationHtml += '<span class="swiper-pagination-customs swiper-pagination-customs-active" style="cursor:pointer;"></span>';  
	                } else {  
	                    customPaginationHtml += '<span class="swiper-pagination-customs" style="cursor:pointer;"></span>';  
	                }  
	            }  
	            return customPaginationHtml;  
		    }
		}
	});
	// //鼠标滑过pagination控制swiper切换
	// for(i=0;i<mySwiper1.pagination.bullets.length;i++){
	// 	mySwiper1.pagination.bullets[i].index=i;
	// 	mySwiper1.pagination.bullets[i].onmouseover=function(){
	// 		mySwiper1.slideTo(this.index);
	//   	};
	// };
	$('.swiper-pagination').on('click','span',function(){
		var index = $(this).index() + 1;
		mySwiper1.slideTo(index, 500, false);//切换到第一个slide，速度为1秒
	});
	
	// 轮播二
	var mySwiper2 = new Swiper ('.swiper-container2', {
		//direction: 'vertical',//垂直滑动
		width:858,
		direction: 'horizontal',//水平滑动
		loop: true,
		autoplay: true,
		autoplay: {
			delay: 3000,//1秒切换一次
			disableOnInteraction: false, //操作后继续自动切换
		}, //设置自动切换时间，单位毫秒
		grabCursor:true,//鼠标覆盖Swiper时指针会变成手掌形状，拖动时指针会变成抓手形状
		speed: 1000, //设置滑动速度
		continuous: true, //无限循环的图片切换效果
		slidesPerView :4,//个数
		spaceBetween :35, //图片间距
		// 如果需要前进后退按钮
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
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
        
</script>
</html>