<?php
	include '../config/config.php';
	include '../config/database.php';
	
	$arr = array(
		'errno'=> 0,
		'error'=> '非法访问',
	);
	if(!isset($_GET['type'])){
		exit(json_encode($arr));
	}else{
		$type = $_GET['type'];
		switch($type){
			// 前端注册
			case 'getUser'://手机号验证
				$get = $_GET;
				if(!empty($_GET)){										
					$sql_select = "SELECT `id`,`user_phone` FROM `wyp_userinfo` WHERE user_phone='".$get['user_phone']."'";
					$db_select = mysqli_query($conn,$sql_select);
					$data1 = mysqli_fetch_assoc($db_select);
					if(!empty($data1)){						
						$arr['errno'] = 2;
						$arr['error'] = '该手机号已注册';
						exit(json_encode($arr));
					}else{
						$arr['errno'] = 1;
						$arr['error'] = '手机号可以使用';
						exit(json_encode($arr));
					}
				}
			break;
			case 'user_register'://注册页面
				$post = $_POST;
				if(!empty($_POST)){
					$sql_select2 = "SELECT `id`,`user_phone` FROM `wyp_userinfo` WHERE user_phone='".$post['user_phone']."'";
					$db_select2 = mysqli_query($conn,$sql_select2);
					$data2 = mysqli_fetch_assoc($db_select2);
					if(!empty($data2)){						
						$arr['errno'] = 2;
						$arr['error'] = '该手机号已注册';
						exit(json_encode($arr));
					}					
					$post['password'] = passwd($post['user_phone'],$post['password']);
					$sql_insert = "INSERT INTO `wyp_userinfo`(`username`,`user_phone`,`password`, `add_time`) VALUES ('".rand(100000,999999)."','".$post["user_phone"]."','".$post["password"]."',".time().")";
					if(!mysqli_query($conn,$sql_insert)){
						$arr['error'] = '注册失败';
						exit(json_encode($arr));
					}else{
						$arr = array(
							'errno'=> 1,
							'error'=> '注册成功',
							'url'  => 'login.html',
						);
						exit(json_encode($arr));
	 				}
				}else{
					$arr['error'] = '请先输入用户名';
					exit(json_encode($arr));
				}				
			break;


			// 前端登录
			case 'user_login'://登录页面
				$post = $_POST;
				if(!empty($_POST)){
					if(!isset($post['user_phone']) || !isset($post['password'])){
						ex('','非法访问','');
					}else{
						$sql_select3 = "SELECT `id`,`password` FROM `wyp_userinfo` WHERE user_phone='".$post['user_phone']."'";
						$db_select3 = mysqli_query($conn,$sql_select3);
						$data3 = mysqli_fetch_assoc($db_select3);
						if(empty($data3)){
							ex(2,'该用户未注册','');
						}					
						$post['password'] = passwd($post['user_phone'],$post['password']);
						if($post['password'] != $data3['password']){
							ex('','密码错误','');
						}else{
							// setcookie('user',$post['username'],time()+20);
							$_SESSION['user_id'] = $data3['id'];
							ex(1,'登陆成功','usercenter.php');
						}	
					}
								
				}else{
					ex('','非法访问','');
				}
			break;

			// ***************************************************************************************************************
			// 用户信息更改
			case 'user_update':
				$post = $_POST;
				if(!empty($_POST)){
					if(!isset($post['username']) || !isset($post['password']) || !isset($post['id']) ){
						ex('','非法访问','');
					}else{
						$sql_select3 = "SELECT `password`,`user_phone` FROM `wyp_userinfo` WHERE id='".$post['id']."'";
						$db_select3 = mysqli_query($conn,$sql_select3);
						$data3 = mysqli_fetch_assoc($db_select3);
						if($data3['password'] != $post['password']){
							$post['password'] = passwd($data3['user_phone'],$post['password']);	
						}						
						$sql_update = "UPDATE `wyp_userinfo` SET username = '".$post['username']."',password = '".$post['password']."' WHERE id =".$post['id'];
						if(!mysqli_query($conn,$sql_update)){
							ex('0','修改失败','');
						}else{
							ex('1','修改成功','');
						}
					}
								
				}else{
					ex('','非法访问','');
				}
			break;
			// ***************************************************************************************************************
			// 清除session
			case 'out':
				$post = $_POST;
				unset($_SESSION["user_id"]);				
				ex('1','修改成功','index.php');				
			break;
			// ****************************************************************************************************************
			//添加地址页面
			case 'user_address':
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['user_id']) || empty($post['address']) || empty($post['consig_phone']) || empty($post['consignee']) || empty($post['zipcode'])){
						ex('','不能为空','');
					}else{
						$sql_insert = "INSERT INTO `wyp_address` (user_id,address,consig_phone,consignee,zipcode) VALUES ('".$post['user_id']."','".$post['address']."','".$post['consig_phone']."','".$post['consignee']."','".$post['zipcode']."')";
						if(!mysqli_query($conn,$sql_insert)){
							ex('0','添加失败','');
						}else{
							ex('1','添加成功','');
						}
					}
				}		
			break;
			// ****************************************************************************************************************
			//加入购物车
			case 'addcart':
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['user_id']) || empty($post['goods_id'])){
						ex('','不能为空','');
					}elseif(empty($post['shoucun'])){
						ex('','请选择手寸','');
					}else{
						$sql_insert = "INSERT INTO `wyp_shopcart` (user_id,goods_id,shoucun,kezi,add_time) VALUES ('".$post['user_id']."','".$post['goods_id']."','".$post['shoucun']."','".$post['kezi']."','".time()."')";
						if(!mysqli_query($conn,$sql_insert)){
							ex('0','添加失败','');
						}else{
							ex('1','添加成功','shop_cart.php');
						}
					}
				}		
			break;
			// *********************************************************************************************************
			//购物车删除
			case 'cart_del':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_del = "DELETE FROM `wyp_shopcart` WHERE id='".$post['id']."'";
						if(!mysqli_query($conn,$sql_del)){
							$arr['errno'] = 0;
							$arr['error'] = '删除失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '删除成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			// *********************************************************************************************************
			//购物车清空
			case 'cart_empty':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_del = "DELETE FROM `wyp_shopcart` WHERE user_id='".$post['id']."'";
						if(!mysqli_query($conn,$sql_del)){
							$arr['errno'] = 0;
							$arr['error'] = '删除失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '删除成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			// ***************************************************************************************************************
			// 订单添加
			case 'order_add':
				$post = $_POST;
				if(!empty($_POST)){
					if(empty($post['a_id']) || empty($post['cart_ids']) || empty($post['user_id'])){
						ex('','不能为空','');
					}else{
						$sql_cart = "SELECT s.id,s.shoucun,s.kezi,s.goods_id,g.goods_price FROM `wyp_shopcart` AS s INNER JOIN `wyp_goods_list` AS g ON s.goods_id = g.id WHERE s.id IN (".$post['cart_ids'].")";
						$res_cart = mysqli_query($conn,$sql_cart);
					    $cart = array();
					    while($rows_cart = mysqli_fetch_assoc($res_cart)){
					        $cart[] = $rows_cart;
					    }
						foreach ($cart as $c) {
							$sql_insert = "INSERT INTO `wyp_order` (user_id,goods_id,shoucun,kezi,add_time,price,address_id) VALUES ('".$post['user_id']."','".$c['goods_id']."','".$c['shoucun']."','".$c['kezi']."','".time()."','".$c['goods_price']."','".$post['a_id']."')";
							$rows = mysqli_query($conn,$sql_insert);
						}
						if($rows != true){
							ex('0','添加失败','');
						}else{
							foreach ($cart as $ca) {
								$sql_del = "DELETE FROM `wyp_shopcart` WHERE id='".$ca['id']."'";
								mysqli_query($conn,$sql_del);
							}
							ex('1','添加成功','usercenter.php');
						}
					}
								
				}else{
					ex('','非法访问','');
				}
			break;


			default:
				exit('接口参数错误');
			break;
		}
	}


function passwd($user,$pass){
	return md5(md5('W'.$user.'Y'.$pass.'P'));
}

function ex($errno,$error,$url){
	$arr =array(
		'errno'=> $errno,
		'error'=> $error,
		'url'  => $url,
	);
	exit(json_encode($arr));
}

?>