<?php
	include './config/config.php';
    include './config/database.php';
    $sql_select = "SELECT id,nav_name,nav_link FROM `wyp_nav` WHERE 1 ORDER BY id ASC";
    $res = mysqli_query($conn,$sql_select);
    $nav = array();
    while($rows = mysqli_fetch_assoc($res)){
        $nav[] = $rows;
    }

    $id = $_GET['id'];

    $sql_select2  = "SELECT g.id,g.goods_name,g.goods_img,g.goods_price,g.series_id,g.size_id,g.shape_id,g.goods_hot,g.goods_sort,g.goods_summary,g.goods_details,g.goods_state,g.add_time,g.zl,g.color,g.jd,g.qg,se.series,si.size,sh.shape FROM `wyp_goods_list` AS g INNER JOIN `wyp_cate_series` AS se ON g.series_id = se.id INNER JOIN `wyp_cate_size` AS si ON g.size_id = si.id INNER JOIN `wyp_cate_shape` AS sh ON g.shape_id = sh.id WHERE g.goods_state=2 AND g.id=".$id;
    $res = mysqli_query($conn,$sql_select2);
    $rows = mysqli_fetch_assoc($res);

	if(isset($_SESSION['user_id'])){
	    $user_id = $_SESSION['user_id'];
		$sql_user = "SELECT username,user_phone,password,add_time FROM `wyp_userinfo` WHERE id=".$user_id;
		$res_user = mysqli_query($conn,$sql_user);
		$user = mysqli_fetch_assoc($res_user);
	}else{
		$user_id = '';
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>钻戒详情</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/common.css">
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
				<?php foreach ($nav as $n): ?>
					<?php if($n['nav_name'] == '求婚钻戒'): ?>
						<li class="pink_now"><a href="<?=$n['nav_link']?>"><?=$n['nav_name']?><div class="pink_line"></div></a></li>
					<?php else: ?>
						<li><a href="<?=$n['nav_link']?>"><?=$n['nav_name']?><div class="pink_line"></div></a></li>	
					<?php endif ?>
					
				<?php endforeach ?>
				<?php if(!isset($_SESSION['user_id'])): ?>
					<li>
						<div class="fl"><a href="login.php">登录<div class="pink_line"></div></a></div>
						<div class="black_line fl"></div>
						<div class="fl"><a href="register.html">注册<div class="pink_line"></div></a></div>
					</li>
				<?php else: ?>
					<li>
						<div class="fl"><?=$user['username']?><div class="pink_line"></div></div>
						<div class="black_line fl"></div>
						<div class="fl tuichu"><a href="index.php?action=logout">退出<div class="pink_line"></div></a></div>
					</li>
				<?php endif ?>
			</ul>
		</div>
	</div>
	<!-- 导航结束 -->
	<div class="goods_detail">
		<div class="cent858">
			<!-- 信息 -->
			<div class="nav_info fl mb">
				<span><a href="index.php">首页</a></span>
				<span>></span>
				<span><a href="goods_list.php">求婚戒指</a></span>
				<span>></span>
				<span><a href="goods_list.php">所有商品</a></span>
				<span>></span>
				<span  class="pink_color"><?=$rows['series']?> 系列 <?=$rows['goods_name']?></span>
			</div>
			<!--  -->
			<!-- 商品选型 -->
			<div class="goods_model cl">
				<div class="model_pic fl">
					<div class="model_big_pic"><img src="<?=substr($rows['goods_img'],3)?>"></div>
					<div class="model_small_pic">
						<div class="pic1 fl"><img src="<?=substr($rows['goods_img'],3)?>"></div>
						<!-- <div class="pic1 fl"><img src="img/add2.jpg"></div>
						<div class="pic1 fl"><img src="img/add3.jpg"></div>
						<div class="pic2 fl"><img src="img/add_page.jpg"></div> -->
					</div> 	
				</div>
				<div class="model_choose fl">
					<p class="p1"><?=$rows['series']?> 系列 <?=$rows['goods_name']?></p>
					<div class="p2">
						<li><span class="one">价格：</span><span class="two">￥ <?=$rows['goods_price']?></span></li>
						<li><span class="three">售出：</span><span class="four">892</span></li>
						<li><span class="three">评价：</span><span class="four">579</span></li>
					</div>
					<div class="gray_line cl"></div>
					<div class="xuancai">
						<li><span>主钻重量：</span><span class="two"><?=$rows['zl']?></span></li>
					    <li><span>钻石颜色：</span><span class="two"><?=$rows['color']?></span></li>
					    <li><span>钻石净度：</span><span class="two"><?=$rows['jd']?></span></li>
					    <li><span>钻石切工：</span><span class="two"><?=$rows['qg']?></span></li>
					</div>
					<div class="gray_line cl"></div>
					<div class="choose_size">
						<div class="texture">
							<li class="li1">戒指材质</li>
							<li class="li2">PT950</li>
							<li class="li3">本商品价格为单只戒指售价，材质调整后金额会自动调整。</li>
						</div>
						<div class="main">
							<li class="li1">搭配主钻</li>
							<li class="li2">30分D色</li>
							<li class="li3">如何选择钻石？</li>
						</div>
						<div class="size">
							<li class="li1">选择手寸</li>
							<li>
								<select class="shoucun p4">
									<option value="0">选择手寸</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select>
								<!-- <p class="p4">选择手寸</p> -->
								<p class="p5">如何测量？</p>
							</li>
							<li>
								<input type="text" placeholder="免费刻字" class="kezi">
								<p class="p6">限输入5个汉字或10个字母</p>
							</li>
							<!-- <li class="li4"><a href="javascript:;">预览效果</a></li> -->
						</div>
					</div>
					<div class="gray_line cl"></div>
					<div class="choose_more">
						<li class="li1 fl">更多</li>
						<li class="li2 fl">选择其他同款现货</li>
						<li class="li2 fl">专属定制</li>
					</div>
					<div class="shop_cat">
						<li class="li1 fl">
							<div class="img1 fl"><img src="img/shopcat.png"></div>
							<span class="addcart">加入购物车</span>
						</li>
						<!-- <li class="li2 fl">立即购买</li> -->
						<!-- <li class="li3 fl">
							<div class="img2 fl"><img src="img/xin.png"></div>
							<span>收藏商品</span>
						</li>	 -->
					</div>
				</div>
			</div>
			<!-- end -->
			<!-- 四个选项 -->
			<div class="four_choose cl">
				<div class="f_c_title cl">
					<li class="tab">商品详情</li>
					<li class="tab">累计评论</li>
					<li class="tab">售后服务</li>
				</div>
			</div>
			<div class="four_choose cl">
				<div class="f_c_info content">
					<?=$rows['goods_details']?>
				</div>
					<!-- <div class="f_c_info_one">
						<li>产品分类：求婚戒指</li>
						<li>产品编号：J10085</li>
						<li>净度：IF</li>
						<li>戒指材质：PT950</li>
						<li>系列名称：WITH YOU 系列</li>
						<li>颜色：D</li>
						<li>副石材质：钻石</li>
						<li>主石大小：30分</li>
						<li>切工：EX</li>
						<li>副石数量：2</li>
						<li>主石材质：钻石</li>
						<li>副石总重：6分</li>
						<li>主石数量：1</li>
						<li>手寸：客订，手寸可改</li>
						<li>主石总重：30分</li>
						<li>形状：圆形</li>
						<li>抛光：EX</li>
						<li>对称：EX</li>
						<li>荧光：NON</li>
						<li>副石形状：圆形</li>
					</div>
					<div class="goods_info_picture"><img src="img/d1.jpg"></div>
					<div class="goods_info_picture"><img src="img/d2.jpg"></div>
					<div class="goods_info_picture"><img src="img/d3.jpg"></div>
					<div class="goods_info_picture"><img src="img/d4.jpg"></div> -->
				
				<div class="comment content">
					<div class="comment_title">
						<div class="fl">
							<div class="one fl">用户评分</div>
							<div class="comment_pic1 fl">
								<img src="img/an1.png">
							</div>
							<div class="comment_pic1 fl">
								<img src="img/an1.png">
							</div>
							<div class="comment_pic1 fl">
								<img src="img/an1.png">
							</div>
							<div class="comment_pic1 fl">
								<img src="img/an1.png">
							</div>
							<div class="comment_pic1 fl">
								<img src="img/an1.png">
							</div>
							<div class="two fl">(4.8分)</div>
						</div>
						<div class="fr">
							共570条评论
						</div>
					</div>
					<!-- 一条评论 -->
					<div class="comment_one">
						<div class="comment_logo fl">
							<div class="c_logo_pic"><img src="img/only.png"></div>
							<div class="p1">木...?</div>
						</div>
						<div class="comment_word fl">
							<div class="c_word_xing">
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
							</div>
							<p>有事中途加急，很及时的发出了，服务真的很到位，戒指很精致，太漂亮了，感谢只为你。</p>
						</div>
						<div class="comment_goods fl">
							<li>重量：3D</li>
							<li>颜色：D</li>
							<li>净度：IF</li>
							<li>切工：DX</li>
						</div>
						<div class="comment_from fl">
							<p>来自上海实体店面</p>
							<p>2018-05-04</p>
						</div>
					</div>
					<!-- 一条评论结束 -->
					<div class="comment_one">
						<div class="comment_logo fl">
							<div class="c_logo_pic"><img src="img/only.png"></div>
							<div class="p1">木...?</div>
						</div>
						<div class="comment_word fl">
							<div class="c_word_xing">
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
							</div>
							<p>有事中途加急，很及时的发出了，服务真的很到位，戒指很精致，太漂亮了，感谢只为你。</p>
						</div>
						<div class="comment_goods fl">
							<li>重量：3D</li>
							<li>颜色：D</li>
							<li>净度：IF</li>
							<li>切工：DX</li>
						</div>
						<div class="comment_from fl">
							<p>来自上海实体店面</p>
							<p>2018-05-04</p>
						</div>
					</div>
					<div class="comment_one">
						<div class="comment_logo fl">
							<div class="c_logo_pic"><img src="img/only.png"></div>
							<div class="p1">木...?</div>
						</div>
						<div class="comment_word fl">
							<div class="c_word_xing">
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
							</div>
							<p>有事中途加急，很及时的发出了，服务真的很到位，戒指很精致，太漂亮了，感谢只为你。</p>
						</div>
						<div class="comment_goods fl">
							<li>重量：3D</li>
							<li>颜色：D</li>
							<li>净度：IF</li>
							<li>切工：DX</li>
						</div>
						<div class="comment_from fl">
							<p>来自上海实体店面</p>
							<p>2018-05-04</p>
						</div>
					</div>
					<div class="comment_one">
						<div class="comment_logo fl">
							<div class="c_logo_pic"><img src="img/only.png"></div>
							<div class="p1">木...?</div>
						</div>
						<div class="comment_word fl">
							<div class="c_word_xing">
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
							</div>
							<p>有事中途加急，很及时的发出了，服务真的很到位，戒指很精致，太漂亮了，感谢只为你。</p>
						</div>
						<div class="comment_goods fl">
							<li>重量：3D</li>
							<li>颜色：D</li>
							<li>净度：IF</li>
							<li>切工：DX</li>
						</div>
						<div class="comment_from fl">
							<p>来自上海实体店面</p>
							<p>2018-05-04</p>
						</div>
					</div>
					<div class="comment_one">
						<div class="comment_logo fl">
							<div class="c_logo_pic"><img src="img/only.png"></div>
							<div class="p1">木...?</div>
						</div>
						<div class="comment_word fl">
							<div class="c_word_xing">
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
							</div>
							<p>有事中途加急，很及时的发出了，服务真的很到位，戒指很精致，太漂亮了，感谢只为你。</p>
						</div>
						<div class="comment_goods fl">
							<li>重量：3D</li>
							<li>颜色：D</li>
							<li>净度：IF</li>
							<li>切工：DX</li>
						</div>
						<div class="comment_from fl">
							<p>来自上海实体店面</p>
							<p>2018-05-04</p>
						</div>
					</div>
					<div class="comment_one">
						<div class="comment_logo fl">
							<div class="c_logo_pic"><img src="img/only.png"></div>
							<div class="p1">木...?</div>
						</div>
						<div class="comment_word fl">
							<div class="c_word_xing">
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
							</div>
							<p>有事中途加急，很及时的发出了，服务真的很到位，戒指很精致，太漂亮了，感谢只为你。</p>
						</div>
						<div class="comment_goods fl">
							<li>重量：3D</li>
							<li>颜色：D</li>
							<li>净度：IF</li>
							<li>切工：DX</li>
						</div>
						<div class="comment_from fl">
							<p>来自上海实体店面</p>
							<p>2018-05-04</p>
						</div>
					</div>
					<div class="comment_one">
						<div class="comment_logo fl">
							<div class="c_logo_pic"><img src="img/only.png"></div>
							<div class="p1">木...?</div>
						</div>
						<div class="comment_word fl">
							<div class="c_word_xing">
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
								<div class="comment_pic2 fl">
									<img src="img/an2.png">
								</div>
							</div>
							<p>有事中途加急，很及时的发出了，服务真的很到位，戒指很精致，太漂亮了，感谢只为你。</p>
						</div>
						<div class="comment_goods fl">
							<li>重量：3D</li>
							<li>颜色：D</li>
							<li>净度：IF</li>
							<li>切工：DX</li>
						</div>
						<div class="comment_from fl">
							<p>来自上海实体店面</p>
							<p>2018-05-04</p>
						</div>
					</div>
					<!-- 评论结束 -->
					<!-- 上一页下一页 -->
					<div class="change_page">
						<li><< 上一页</li>
						<li>1</li>
						<li>2</li>
						<li>&middot;&middot;&middot;</li>
						<li>23</li>
						<li>下一页>></li>
					</div>	
					<!-- 结束 -->
				</div>
				<!-- 评论页结束 -->
				<!-- 售后 -->
				<div class="content f_c_info">
					<?php
						$sql_select = "SELECT ad_details FROM `wyp_ad` WHERE id=9";
					    $res = mysqli_query($conn,$sql_select);
					    $ads = mysqli_fetch_assoc($res);
					?>
					<?=$ads['ad_details']?>
				</div>
				<!-- 售后结束 -->
			</div>
			<!--  -->
		</div>
	</div>
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

	$(function(){
		layui.use(['laydate','element','laypage','layer'], function(){
	        laydate = layui.laydate;//日期插件
	        lement = layui.element();//面包导航
	        laypage = layui.laypage;//分页
	        layer = layui.layer;//弹出层
	    });

		$('.content').eq(0).show();
		$('.tab').eq(0).css({'border-bottom':'2px solid #ffb1a1'});
		$('.tab').click(function(){
			var index = $(this).index(); // 获取当前下标
			$('.tab').eq(index).css({'border-bottom':'2px solid #ffb1a1'}).siblings().css({'border':'none'});
			$('.content').eq(index).show().siblings().hide(); // 将对应选项卡显示兄弟选项卡隐藏
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

		$('.addcart').click(function(){
			var user_id = '<?=$user_id?>';
			if(user_id == ''){
				layer.msg('请先登录');
				location.href='login.html';
			}
			var shoucun = $('.shoucun').val();
			var kezi = $('.kezi').val();
            $.ajax({
                url:'./common/qajax.php?type=addcart',
                data:{
                	user_id:user_id,
                    goods_id:<?=$id?>,
                    shoucun:shoucun,
 					kezi:kezi,
                },
                type:'post',
                dataType:'json',
                success:function(data){
                    if(data.errno==1){                       
                        location.href=data.url;                                    
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

	});

	
</script>
</html>