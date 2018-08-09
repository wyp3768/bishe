<?php
	include './config/config.php';
    include './config/database.php';
    $zl = isset($_GET['zl']) ? (int)$_GET['zl'] : 0; // 重量参数
    $xz = isset($_GET['xz']) ? (int)$_GET['xz'] : 0; // 形状参数
    $xl = isset($_GET['xl']) ? (int)$_GET['xl'] : 0; // 系列参数
    $sort = isset($_GET['sort']) ? (int)$_GET['sort'] : 0; //排序参数
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

    $sql_select2  = "SELECT g.id,g.goods_name,g.goods_img,g.goods_price,g.series_id,g.size_id,g.shape_id,g.goods_hot,g.goods_sort,g.goods_summary,g.goods_details,g.goods_state,g.add_time,se.series,si.size,sh.shape FROM `wyp_goods_list` AS g INNER JOIN `wyp_cate_series` AS se ON g.series_id = se.id INNER JOIN `wyp_cate_size` AS si ON g.size_id = si.id INNER JOIN `wyp_cate_shape` AS sh ON g.shape_id = sh.id";
    $sql_select2 .= " WHERE g.goods_state=2 AND 1";
    $sql_select2 .= " AND g.series_id != 12 AND g.series_id != 13";
    if(!empty($zl)){
    	$sql_select2 .= " AND g.size_id = ".$zl;
    }
    if(!empty($xz)){
    	$sql_select2 .= " AND g.shape_id = ".$xz;
    }
    if(!empty($xl)){
    	$sql_select2 .= " AND g.series_id = ".$xl;
    }
    $sql_select2 .= " ORDER BY id ASC";
    $res = mysqli_query($conn,$sql_select2);
    $num = mysqli_num_rows($res);

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $pageAll = 12;
    $sql_select2  = "SELECT g.id,g.goods_name,g.goods_img,g.goods_price,g.series_id,g.size_id,g.shape_id,g.goods_hot,g.goods_sort,g.goods_summary,g.goods_details,g.goods_state,g.add_time,se.series,si.size,sh.shape FROM `wyp_goods_list` AS g INNER JOIN `wyp_cate_series` AS se ON g.series_id = se.id INNER JOIN `wyp_cate_size` AS si ON g.size_id = si.id INNER JOIN `wyp_cate_shape` AS sh ON g.shape_id = sh.id";
    $sql_select2 .= " WHERE g.goods_state=2 AND 1";
    if(!empty($zl)){
    	$sql_select2 .= " AND g.size_id = ".$zl;
    }
    if(!empty($xz)){
    	$sql_select2 .= " AND g.shape_id = ".$xz;
    }
    if(!empty($xl)){
    	$sql_select2 .= " AND g.series_id = ".$xl;
    }
    $sql_select2 .= " AND g.series_id != 12 AND g.series_id != 13";
    if($sort == 1){
    	$sql_select2 .= " ORDER BY goods_sort DESC";
    }elseif($sort == -1){
    	$sql_select2 .= " ORDER BY goods_sort ASC";
    }elseif($sort == 2){
    	$sql_select2 .= " ORDER BY add_time DESC";
    }elseif($sort == -2){
    	$sql_select2 .= " ORDER BY add_time ASC";
    }elseif($sort == 3){
    	$sql_select2 .= " ORDER BY goods_price DESC";
    }elseif($sort == -3){
    	$sql_select2 .= " ORDER BY goods_price ASC";
    }else{
    	$sql_select2 .= " ORDER BY g.id ASC";
    }
    $sql_select2 .= " LIMIT ".($pageAll*($page - 1)).",".$pageAll;
    $res = mysqli_query($conn,$sql_select2);
    $goods = array();
    while($rows = mysqli_fetch_assoc($res)){
        $goods[] = $rows;
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
	<title>钻戒列表页</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/swiper.min.css">
	<link rel="stylesheet" href="./admin/css/x-admin.css" media="all">
	<script src="./admin/js/jquery.min.js" charset="utf-8"></script>
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
				<?php foreach ($nav as $n): ?>
					<?php if($n['nav_name'] == '求婚钻戒'): ?>
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
	<!-- 列表 -->
	<div class="product_list">
		<div class="goods_head cent858">
			<div class="nav_info fl">
				<span><a href="index.php">首页</a></span>
				<span>></span>
				<span><a href="goods_list.php">求婚戒指</a></span>
				<span>></span>
				<span><a href="goods_list.php" class="pink_color">所有商品</a></span>
			</div>
			<div class="search fr">
				<input type="text" placeholder="My heart 系列">
				<span>搜索</span>
			</div>
		</div>
		<div class="product_list_cont">
			<div class="cent858">
				<!-- 导航信息 -->
				<div class="cont_nav">
					<div class="one_line">
						<div class="fl p1">系列</div>
						<?php
							$sql_select = "SELECT id,series FROM `wyp_cate_series` WHERE 1 LIMIT 5";
						    $res = mysqli_query($conn,$sql_select);
						    $series = array();
						    while($rows_se = mysqli_fetch_assoc($res)){
						        $series[] = $rows_se;
						    }
						?>
						<?php foreach ($series as $se): ?>
						<?php if($xl == $se['id']): ?>
							<span style="background:#ffb1a1;" onclick="cate('xl','<?=$se['id']?>')"><?=$se['series']?> 系列</span>
						<?php else:  ?>
							<span onclick="cate('xl','<?=$se['id']?>')"><?=$se['series']?> 系列</span>
						<?php endif;  ?>
						<?php endforeach ?>
						<!-- <li >更多></li> -->
					</div>
					<div class="one_line">
						<div class="fl p1">重量(克拉)</div>
						<?php
							$sql_select = "SELECT id,size FROM `wyp_cate_size` WHERE 1";
						    $res = mysqli_query($conn,$sql_select);
						    $size = array();
						    while($rows_si = mysqli_fetch_assoc($res)){
						        $size[] = $rows_si;
						    }
						?>
						<?php foreach ($size as $si): ?>
						<?php if($zl == $si['id']): ?>
							<span style="background:#ffb1a1;" onclick="cate('zl','<?=$si['id']?>')"><?=$si['size']?></span>
						<?php else:  ?>
							<span onclick="cate('zl','<?=$si['id']?>')"><?=$si['size']?></span>
						<?php endif;  ?>							
						<?php endforeach ?>
						<!--<span>10分以下</span>
						<span>10分~30分</span>
						<span>30分~50分</span>
						<span>50分~1克拉 </span>
						<span>1克拉以上</span> -->
					</div>
					<div class="one_line">
						<div class="fl p1">钻石形状</div>
						<?php
							$sql_select = "SELECT id,shape FROM `wyp_cate_shape` WHERE 1";
						    $res = mysqli_query($conn,$sql_select);
						    $shape = array();
						    while($rows_sh = mysqli_fetch_assoc($res)){
						        $shape[] = $rows_sh;
						    }
						?>
						<?php foreach ($shape as $sh): ?>
						<?php if($xz == $sh['id']): ?>
							<span style="background:#ffb1a1;" onclick="cate('xz','<?=$sh['id']?>')"><?=$sh['shape']?></span>
						<?php else:  ?>
							<span onclick="cate('xz','<?=$sh['id']?>')"><?=$sh['shape']?></span>
						<?php endif;  ?>							
						<?php endforeach ?>


						<!-- <span>圆形</span>
						<span>心形</span>
						<span>方形</span>
						<span>椭圆形</span>
						<span>马眼形</span>
						<span>水滴形</span> -->
						<!-- <a href="javascript:;"><div class="more fr">筛选更多 ></div></a> -->
					</div>
				</div>
				<!-- 导航信息结束 -->
				<!-- 中间paixu -->
				<div class="list_sort">
					<li class="p1 fl">排序</li>
					<?php if($sort == 1): ?>
						<li class="p2 fl" onclick="cate('sort','-1')" style="color:#ffb1a1;">按人气&darr;</li>
					<?php elseif($sort == -1): ?>
						<li class="p2 fl" onclick="cate('sort','1')" style="color:#ffb1a1;">按人气&uarr;</li>
					<?php else: ?>
						<li class="p2 fl" onclick="cate('sort','1')">按人气</li>
					<?php endif ?>
					
					<?php if($sort == 2): ?>
						<li class="p2 fl" onclick="cate('sort','-2')" style="color:#ffb1a1;">按新品&darr;</li>
					<?php elseif($sort == -2): ?>
						<li class="p2 fl" onclick="cate('sort','2')" style="color:#ffb1a1;">按新品&uarr;</li>
					<?php else: ?>
						<li class="p2 fl" onclick="cate('sort','2')">按新品</li>
					<?php endif ?>	
					
					<?php if($sort == 3): ?>
						<li class="p2 fl" onclick="cate('sort','-3')" style="color:#ffb1a1;">按价格&darr;</li>
					<?php elseif($sort == -3): ?>
						<li class="p2 fl" onclick="cate('sort','3')" style="color:#ffb1a1;">按价格&uarr;</li>
					<?php else: ?>
						<li class="p2 fl" onclick="cate('sort','3')">按价格</li>
					<?php endif ?>	
					
					<!-- <li class="p3 fr">></li> -->
					<!-- <li class="p3 fr"><</li> -->
					<!-- <li class="p4 fr">1/20</li> -->
					<li class="p5 fr">共<?=$num?>件商品</li>
				</div>
				<!-- 结束 -->
				<ul class="list_list">
					<?php foreach ($goods as $g): ?>
						<li><a href="goods_detail.php?id=<?=$g['id']?>">
						<div class="list_pic"><img src="<?=substr($g['goods_img'],3)?>"></div>
						<p class="xilie"><?=$g['series']?> 系列 <?=$g['goods_name']?></p>
						<p class="list_price">￥ <?=$g['goods_price']?></p>
						<p class="list_sale fl">售出：892</p>
						<p class="comment fr">评价：579</p>
						<div class="bot_line"></div>
					</a></li> 
					<?php endforeach ?>
					<!-- <li><a href="goods_detail.html">
						<div class="list_pic"><img src="img/list1.jpg"></div>
						<p class="xilie">With you 系列 陪伴</p>
						<p class="list_price">￥ 85999</p>
						<p class="list_sale fl">售出：892</p>
						<p class="comment fr">评价：579</p>
						<div class="bot_line"></div>
					</a></li> 
					<li><a href="goods_detail.html">
						<div class="list_pic"><img src="img/list2.jpg"></div>
						<p class="xilie">Lust you 系列 守护</p>
						<p class="list_price">￥ 60979</p>
						<p class="list_sale fl">售出：2974</p>
						<p class="comment fr">评价：1179</p>
						<div class="bot_line"></div>
					</a></li>
					<li><a href="goods_detail.html">
						<div class="list_pic"><img src="img/list3.jpg"></div>
						<p class="xilie">Sweety 系列 心蓝</p>
						<p class="list_price">￥ 67809</p>
						<p class="list_sale fl">售出：1081</p>
						<p class="comment fr">评价：594</p>
						<div class="bot_line"></div>
					</a></li> 
					<li><a href="goods_detail.html">
						<div class="list_pic"><img src="img/list4.jpg"></div>
						<p class="xilie">Only you 系列 初心</p>
						<p class="list_price">￥ 199999</p>
						<p class="list_sale fl">售出：892</p>
						<p class="comment fr">评价：1579</p>
						<div class="bot_line"></div>
					</a></li> 
					<li><a href="goods_detail.html">
						<div class="list_pic"><img src="img/list5.jpg"></div>
						<p class="xilie">Wedding 系列 捧花</p>
						<p class="list_price">￥ 55999</p>
						<p class="list_sale fl">售出：1892</p>
						<p class="comment fr">评价：779</p>
						<div class="bot_line"></div>
					</a></li> 
					<li><a href="goods_detail.html">
						<div class="list_pic"><img src="img/list6.jpg"></div>
						<p class="xilie">Believe 系列 典雅</p>
						<p class="list_price">￥ 70679</p>
						<p class="list_sale fl">售出：2492</p>
						<p class="comment fr">评价：579</p>
						<div class="bot_line"></div>
					</a></li> 
					<li><a href="goods_detail.html">
						<div class="list_pic"><img src="img/list7.jpg"></div>
						<p class="xilie">Wedding 系列 捧花2</p>
						<p class="list_price">￥ 67809</p>
						<p class="list_sale fl">售出：2098</p>
						<p class="comment fr">评价：1590</p>
						<div class="bot_line"></div>
					</a></li> 
					<li><a href="goods_detail.html">
						<div class="list_pic"><img src="img/list8.jpg"></div>
						<p class="xilie">Only you 系列 Queen</p>
						<p class="list_price">￥ 285999</p>
						<p class="list_sale fl">售出：3792</p>
						<p class="comment fr">评价：2579</p>
						<div class="bot_line"></div>
					</a></li> 
					<li><a href="goods_detail.html">
						<div class="list_pic"><img src="img/list9.jpg"></div>
						<p class="xilie">I love 系列 拥抱</p>
						<p class="list_price">￥ 45729</p>
						<p class="list_sale fl">售出：2411</p>
						<p class="comment fr">评价：1567</p>
						<div class="bot_line"></div>
					</a></li> 
					<li><a href="goods_detail.html">
						<div class="list_pic"><img src="img/list10.jpg"></div>
						<p class="xilie">Wedding 系列 幸福</p>
						<p class="list_price">￥ 80570</p>
						<p class="list_sale fl">售出：1892</p>
						<p class="comment fr">评价：1379</p>
						<div class="bot_line"></div>
					</a></li> 
					<li><a href="goods_detail.html">
						<div class="list_pic"><img src="img/list11.jpg"></div>
						<p class="xilie">Lock Me 系列 心&middot;锁唯一</p>
						<p class="list_price">￥ 185999</p>
						<p class="list_sale fl">售出：892</p>
						<p class="comment fr">评价：579</p>
						<div class="bot_line"></div>
					</a></li> 
					<li><a href="goods_detail.html">
						<div class="list_pic"><img src="img/list12.jpg"></div>
						<p class="xilie">Only you 系列 心动</p>
						<p class="list_price">￥ 155999</p>
						<p class="list_sale fl">售出：2892</p>
						<p class="comment fr">评价：2579</p>
						<div class="bot_line"></div>
					</a></li>  -->
				</ul>
				<!-- liebiao jieshu  -->
				<!-- 上一页下一页 -->
				<div class="change_page">
					<div id="page"></div>
				</div>	
				<!-- 结束 -->
			</div>

			<div class="blonk cl"></div>
		</div>
	</div>
	<!-- 列表结束 -->
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
<script>
		
	layui.use(['laydate','element','laypage','layer'], function(){
        laydate = layui.laydate;//日期插件
        lement = layui.element();//面包导航
        laypage = layui.laypage;//分页
        layer = layui.layer;//弹出层

       //以上模块根据需要引入
        laypage({
            cont: 'page'
            ,pages: <?=ceil($num/$pageAll)?>
            ,first: 1
            ,last: <?=ceil($num/$pageAll)?>
            ,curr: <?=$page?>
            ,prev: '<em><</em>'
            ,next: '<em>></em>'
            ,jump: function(obj, first){
                
                if(!first){  
                    window.location.href="goods_list.php?page="+obj.curr;  
                }
            }
        }); 

    });       

    function cate(type,id){
    	var _url = 'goods_list.php?';
    	var zl = 'zl='+<?=$zl?>;
    	var xz = 'xz='+<?=$xz?>;
    	var xl = 'xl='+<?=$xl?>;
    	var sort = 'sort='+<?=$sort?>;
    	switch(type){
    		case 'zl':
    			_url += 'zl='+id+'&'+xz+'&'+xl+'&'+sort;
    		break;
    		case 'xz':
    			_url += 'xz='+id+'&'+zl+'&'+xl+'&'+sort;
    		break;
    		case 'xl':
    			_url += 'xl='+id+'&'+xz+'&'+zl+'&'+sort;
    		break;
    		case 'sort':
    			_url += 'sort='+id+'&'+xz+'&'+zl+'&'+xl;
    		break;
    	}
    	location.href = _url;
    }

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
	            for(var i = 0; i < total; i++){  
	                //判断哪个分页器此刻应该被激活  
	                if(i == (current - 1)) {  
	                    customPaginationHtml += '<span class="swiper-pagination-customs swiper-pagination-customs-active" style="cursor:pointer;"></span>';  
	                } else {  
	                    customPaginationHtml += '<span class="swiper-pagination-customs" style="cursor:pointer;"></span>';  
	                }  
	            };  
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