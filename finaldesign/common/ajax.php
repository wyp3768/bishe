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
			// ***********************************************************************************
			//导航添加
			case 'add_nav':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['nav_name']) || empty($post['nav_link']) || empty($post['nav_sort'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_insert = "INSERT INTO `wyp_nav` (nav_name,nav_link,nav_sort) VALUES ('".$post['nav_name']."','".$post['nav_link']."','".$post['nav_sort']."')";
						if(!mysqli_query($conn,$sql_insert)){
							$arr['errno'] = 0;
							$arr['error'] = '添加失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '添加成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			//导航删除
			case 'del_nav':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_del = "DELETE FROM `wyp_nav` WHERE id='".$post['id']."'";
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
			//导航批量删除
			case 'delAllnav':
				$ids = $_POST['ids'];
				if(!isset($ids)){								
					exit(json_encode($arr));
				}else{
					if(empty($ids)){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_del = "DELETE FROM `wyp_nav` WHERE id IN (".$ids.")";
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
			//导航修改
			case 'update_nav':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['nav_name']) || empty($post['nav_link']) || empty($post['nav_sort'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_update = "UPDATE `wyp_nav` SET nav_name = '".$post['nav_name']."',nav_link = '".$post['nav_link']."',nav_sort = '".$post['nav_sort']."' WHERE id =".$post['id'];
						if(!mysqli_query($conn,$sql_update)){
							$arr['errno'] = 0;
							$arr['error'] = '修改失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '修改成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			// *********************************************************************************************
			// ***********************************************************************************
			//分类——系列添加
			case 'add_cate_se':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['series'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_insert = "INSERT INTO `wyp_cate_series` (series) VALUES ('".$post['series']."')";
						if(!mysqli_query($conn,$sql_insert)){
							$arr['errno'] = 0;
							$arr['error'] = '添加失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '添加成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			//系列删除
			case 'del_cate_se':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_del = "DELETE FROM `wyp_cate_series` WHERE id='".$post['id']."'";
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
			//系列批量删除
			case 'delAllseries':
				$ids = $_POST['ids'];
				if(!isset($ids)){								
					exit(json_encode($arr));
				}else{
					if(empty($ids)){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_del = "DELETE FROM `wyp_cate_series` WHERE id IN (".$ids.")";
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
			//系列修改
			case 'update_cate_se':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['series'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_update = "UPDATE `wyp_cate_series` SET series = '".$post['series']."' WHERE id =".$post['id'];
						if(!mysqli_query($conn,$sql_update)){
							$arr['errno'] = 0;
							$arr['error'] = '修改失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '修改成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			// *********************************************************************************************
			// ***********************************************************************************
			//分类——大小添加
			case 'add_cate_si':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['size'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_insert = "INSERT INTO `wyp_cate_size` (size) VALUES ('".$post['size']."')";
						if(!mysqli_query($conn,$sql_insert)){
							$arr['errno'] = 0;
							$arr['error'] = '添加失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '添加成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			//大小删除
			case 'del_cate_si':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_del = "DELETE FROM `wyp_cate_size` WHERE id='".$post['id']."'";
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
			//大小批量删除
			case 'delAllsize':
				$ids = $_POST['ids'];
				if(!isset($ids)){								
					exit(json_encode($arr));
				}else{
					if(empty($ids)){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_del = "DELETE FROM `wyp_cate_size` WHERE id IN (".$ids.")";
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
			//大小修改
			case 'update_cate_si':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['size'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_update = "UPDATE `wyp_cate_size` SET size = '".$post['size']."' WHERE id =".$post['id'];
						if(!mysqli_query($conn,$sql_update)){
							$arr['errno'] = 0;
							$arr['error'] = '修改失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '修改成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			// *********************************************************************************************
			// ***********************************************************************************
			//分类——形状添加
			case 'add_cate_sh':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['shape'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_insert = "INSERT INTO `wyp_cate_shape` (shape) VALUES ('".$post['shape']."')";
						if(!mysqli_query($conn,$sql_insert)){
							$arr['errno'] = 0;
							$arr['error'] = '添加失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '添加成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			//形状删除
			case 'del_cate_sh':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_del = "DELETE FROM `wyp_cate_shape` WHERE id='".$post['id']."'";
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
			//形状批量删除
			case 'delAllshape':
				$ids = $_POST['ids'];
				if(!isset($ids)){								
					exit(json_encode($arr));
				}else{
					if(empty($ids)){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_del = "DELETE FROM `wyp_cate_shape` WHERE id IN (".$ids.")";
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
			//形状修改
			case 'update_cate_sh':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['shape'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_update = "UPDATE `wyp_cate_shape` SET shape = '".$post['shape']."' WHERE id =".$post['id'];
						if(!mysqli_query($conn,$sql_update)){
							$arr['errno'] = 0;
							$arr['error'] = '修改失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '修改成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			// *********************************************************************************************
			// ************************************************************************************************************
			case 'upload':    //图片上传
				$typeArr = ['image/jpeg','image/gif','image/png'];//文件格式
				$path = '../uploads/';//文件存入地址				
				if(isset($_FILES['file'])){//文件是否存在
					$name = $_FILES['file']['name']; //文件的名字
					$type = $_FILES['file']['type'];//文件的类型
					$tmp  = $_FILES['file']['tmp_name'];//文件临时地址
					$erro = $_FILES['file']['error'];//错误类型
					$size = $_FILES['file']['size'];//文件大小
					if($erro == 4){ //判断文件是否存在
						$arr['error'] = '请先选择文件';
						exit(json_encode($arr));
					}else{
						if(!in_array($type,$typeArr)){ //判断文件类型是否正确
							$arr['error'] = '上传文件类型错误';
							exit(json_encode($arr));
						}
						if($size > (2*1024*1024)){ //判断文件大小
							$arr['error'] = '上传文件过大';
							exit(json_encode($arr));
						}
						$new_name = $path.date('d').time().rand(1000,9999).'.'.substr(strrchr($name,'.'),1);//移动文件重命名
						if(!move_uploaded_file($tmp,$new_name)){//判断移动成功？
							$arr['error'] = '上传失败';
							exit(json_encode($arr));
						}else{
							$arr = array(
								'errno' => 1,
								'error' => '上传成功',
								'url'   => $new_name,
							);
							exit(json_encode($arr));
						}
					}
				}else{
					exit(json_encode($arr));
				} 
			break;
			// **********************************************************************************************
			case 'add_banner':   //banner添加
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['banner']) || empty($post['banner_sort']) || empty($post['banner_link']) || empty($post['banner_desc'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_insert = "INSERT INTO `wyp_banner` (banner,banner_sort,banner_link,banner_desc) VALUES ('".$post['banner']."','".$post['banner_sort']."','".$post['banner_link']."','".$post['banner_desc']."')";
						if(!mysqli_query($conn,$sql_insert)){
							$arr['errno'] = 0;
							$arr['error'] = '添加失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '添加成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			case 'del_banner':   //banner删除
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_sel = "SELECT banner FROM `wyp_banner` WHERE id=".$post['id'];
						$res = mysqli_query($conn,$sql_sel);
    					$rows = mysqli_fetch_assoc($res);
						$sql_del = "DELETE FROM `wyp_banner` WHERE id='".$post['id']."'";
						if(!mysqli_query($conn,$sql_del)){
							$arr['errno'] = 0;
							$arr['error'] = '删除失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '删除成功';
							unlink($rows['banner']);
							exit(json_encode($arr));
						}
					}
				}
			break;
			//banner批量删除
			case 'delAllbanner':  
				$ids = $_POST['ids'];
				if(!isset($ids)){								
					exit(json_encode($arr));
				}else{
					if(empty($ids)){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_sel = "SELECT banner FROM `wyp_banner` WHERE id IN (".$ids.")";
						$res = mysqli_query($conn,$sql_sel);
    					while($rows = mysqli_fetch_assoc($res)){
					        $g_arr[] = $rows;
					    }
						$sql_del = "DELETE FROM `wyp_banner` WHERE id IN (".$ids.")";
						if(!mysqli_query($conn,$sql_del)){
							$arr['errno'] = 0;
							$arr['error'] = '删除失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '删除成功';
							foreach ($g_arr as $key => $v){
								unlink($v['banner']);
							};
							exit(json_encode($arr));
						}
					}
				}
			break;
			case 'update_banner':   //banner修改
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id']) || empty($post['banner']) || empty($post['banner_sort']) || empty($post['banner_link']) || empty($post['banner_desc'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_sel = "SELECT banner FROM `wyp_banner` WHERE id=".$post['id'];
						$res = mysqli_query($conn,$sql_sel);
    					$rows = mysqli_fetch_assoc($res);
						$sql_update = "UPDATE `wyp_banner` SET banner = '".$post['banner']."',banner_sort = '".$post['banner_sort']."',banner_link = '".$post['banner_link']."',banner_desc = '".$post['banner_desc']."' WHERE id =".$post['id'];
						if(!mysqli_query($conn,$sql_update)){
							$arr['errno'] = 0;
							$arr['error'] = '修改失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '修改成功';
							if($rows['banner'] != $post['banner']){
								unlink($rows['banner']);
							}
							exit(json_encode($arr));
						}
					}
				}
			break;
			 //banner状态修改
			case 'update_banner_state':  
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id']) || empty($post['banner_state'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						if($post['banner_state'] == 1){
							$banner_state = 2;
						}else{
							$banner_state = 1;
						}
						$sql_update = "UPDATE `wyp_banner` SET banner_state = '".$banner_state."' WHERE id =".$post['id'];
						if(!mysqli_query($conn,$sql_update)){
							$arr['errno'] = 0;
							$arr['error'] = '修改失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '修改成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			// *****************************************************************************
			// **********************************************************************************************
			case 'add_banner_l':   //banner2添加
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['banner']) || empty($post['banner_sort']) || empty($post['banner_link']) || empty($post['banner_desc'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_insert = "INSERT INTO `wyp_banner_little` (banner,banner_sort,banner_link,banner_desc) VALUES ('".$post['banner']."','".$post['banner_sort']."','".$post['banner_link']."','".$post['banner_desc']."')";
						if(!mysqli_query($conn,$sql_insert)){
							$arr['errno'] = 0;
							$arr['error'] = '添加失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '添加成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			case 'del_banner_l':   //banner2删除
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_sel = "SELECT banner FROM `wyp_banner_little` WHERE id=".$post['id'];
						$res = mysqli_query($conn,$sql_sel);
    					$rows = mysqli_fetch_assoc($res);
						$sql_del = "DELETE FROM `wyp_banner_little` WHERE id='".$post['id']."'";
						if(!mysqli_query($conn,$sql_del)){
							$arr['errno'] = 0;
							$arr['error'] = '删除失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '删除成功';
							unlink($rows['banner']);
							exit(json_encode($arr));
						}
					}
				}
			break;
			//banner2批量删除
			case 'delAllbanner_l':  
				$ids = $_POST['ids'];
				if(!isset($ids)){								
					exit(json_encode($arr));
				}else{
					if(empty($ids)){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_sel = "SELECT banner FROM `wyp_banner_little` WHERE id IN (".$ids.")";
						$res = mysqli_query($conn,$sql_sel);
    					while($rows = mysqli_fetch_assoc($res)){
					        $g_arr[] = $rows;
					    }
						$sql_del = "DELETE FROM `wyp_banner_little` WHERE id IN (".$ids.")";
						if(!mysqli_query($conn,$sql_del)){
							$arr['errno'] = 0;
							$arr['error'] = '删除失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '删除成功';
							foreach ($g_arr as $key => $v){
								unlink($v['banner']);
							};
							exit(json_encode($arr));
						}
					}
				}
			break;
			case 'update_banner_l':   //banner2修改
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id']) || empty($post['banner']) || empty($post['banner_sort']) || empty($post['banner_link']) || empty($post['banner_desc'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_sel = "SELECT banner FROM `wyp_banner_little` WHERE id=".$post['id'];
						$res = mysqli_query($conn,$sql_sel);
    					$rows = mysqli_fetch_assoc($res);
						$sql_update = "UPDATE `wyp_banner_little` SET banner = '".$post['banner']."',banner_sort = '".$post['banner_sort']."',banner_link = '".$post['banner_link']."',banner_desc = '".$post['banner_desc']."' WHERE id =".$post['id'];
						if(!mysqli_query($conn,$sql_update)){
							$arr['errno'] = 0;
							$arr['error'] = '修改失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '修改成功';
							if($rows['banner'] != $post['banner']){
								unlink($rows['banner']);
							}
							exit(json_encode($arr));
						}
					}
				}
			break;
			 //banner2状态修改
			case 'update_banner_state_l':  
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id']) || empty($post['banner_state'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						if($post['banner_state'] == 1){
							$banner_state = 2;
						}else{
							$banner_state = 1;
						}
						$sql_update = "UPDATE `wyp_banner_little` SET banner_state = '".$banner_state."' WHERE id =".$post['id'];
						if(!mysqli_query($conn,$sql_update)){
							$arr['errno'] = 0;
							$arr['error'] = '修改失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '修改成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			// *****************************************************************************
			// **********************************************************************************************
			//广告添加
			case 'add_ad':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['ad_pic']) || empty($post['ad_link']) || empty($post['ad_sort']) || empty($post['ad_desc']) || empty($post['ad_details'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_insert = "INSERT INTO `wyp_ad` (ad_pic,ad_link,ad_sort,ad_desc,ad_details,add_time) VALUES ('".$post['ad_pic']."','".$post['ad_link']."','".$post['ad_sort']."','".$post['ad_desc']."','".$post['ad_details']."','".time()."')";
						if(!mysqli_query($conn,$sql_insert)){
							$arr['errno'] = 0;
							$arr['error'] = '添加失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '添加成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			//广告删除
			case 'del_ad':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_sel = "SELECT ad_pic FROM `wyp_ad` WHERE id=".$post['id'];
						$res = mysqli_query($conn,$sql_sel);
    					$rows = mysqli_fetch_assoc($res);
						$sql_del = "DELETE FROM `wyp_ad` WHERE id='".$post['id']."'";
						if(!mysqli_query($conn,$sql_del)){
							$arr['errno'] = 0;
							$arr['error'] = '删除失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '删除成功';
							unlink($rows['ad_pic']);
							exit(json_encode($arr));
						}
					}
				}
			break;
			//产品批量删除
			case 'delAllad':  
				$ids = $_GET['ids'];
				if(!isset($ids)){								
					exit(json_encode($arr));
				}else{
					if(empty($ids)){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_sel = "SELECT ad_pic FROM `wyp_ad` WHERE id IN (".$ids.")";
						$res = mysqli_query($conn,$sql_sel);
    					while($rows = mysqli_fetch_assoc($res)){
					        $g_arr[] = $rows;
					    }
						$sql_del = "DELETE FROM `wyp_ad` WHERE id IN (".$ids.")";
						if(!mysqli_query($conn,$sql_del)){
							$arr['errno'] = 0;
							$arr['error'] = '删除失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '删除成功';
							foreach ($g_arr as $key => $v){
								unlink($v['ad_pic']);
							};
							exit(json_encode($arr));
						}
					}
				}
			break;
			//广告修改
			case 'update_ad':   
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id']) || empty($post['ad_pic']) || empty($post['ad_link']) || empty($post['ad_sort']) || empty($post['ad_desc']) || empty($post['ad_details'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_sel = "SELECT ad_pic FROM `wyp_ad` WHERE id=".$post['id'];
						$res = mysqli_query($conn,$sql_sel);
    					$rows = mysqli_fetch_assoc($res);
						$sql_update = "UPDATE `wyp_ad` SET ad_pic = '".$post['ad_pic']."',ad_sort = '".$post['ad_sort']."',ad_link = '".$post['ad_link']."',ad_desc = '".$post['ad_desc']."',ad_details = '".$post['ad_details']."',add_time = '".time()."' WHERE id =".$post['id'];
						if(!mysqli_query($conn,$sql_update)){
							$arr['errno'] = 0;
							$arr['error'] = '修改失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '修改成功';
							if($rows['ad_pic'] != $post['ad_pic']){
								unlink($rows['ad_pic']);
							}
							exit(json_encode($arr));
						}
					}
				}
			break;
			// **********************************************************************************************
			// **********************************************************************************************
			 //产品添加
			case 'add_goods':  
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['goods_name']) || empty($post['goods_img']) || empty($post['goods_price']) || empty($post['series_id']) || empty($post['size_id']) || empty($post['shape_id']) || empty($post['goods_hot']) || empty($post['goods_sort']) || empty($post['goods_summary']) || empty($post['goods_details']) || empty($post['zl']) || empty($post['color']) || empty($post['jd']) || empty($post['qg'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_insert = "INSERT INTO `wyp_goods_list` (goods_name,goods_img,goods_price,series_id,size_id,shape_id,goods_hot,goods_sort,goods_summary,goods_details,add_time,zl,color,jd,qg) VALUES ('".$post['goods_name']."','".$post['goods_img']."','".$post['goods_price']."','".$post['series_id']."','".$post['size_id']."','".$post['shape_id']."','".$post['goods_hot']."','".$post['goods_sort']."','".$post['goods_summary']."','".$post['goods_details']."','".time()."','".$post['zl']."','".$post['color']."','".$post['jd']."','".$post['qg']."')";
						if(!mysqli_query($conn,$sql_insert)){
							$arr['errno'] = 0;
							$arr['error'] = '添加失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '添加成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			 //产品删除
			case 'del_goods':  
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_sel = "SELECT goods_img FROM `wyp_goods_list` WHERE id=".$post['id'];
						$res = mysqli_query($conn,$sql_sel);
    					$rows = mysqli_fetch_assoc($res);
						$sql_del = "DELETE FROM `wyp_goods_list` WHERE id='".$post['id']."'";
						if(!mysqli_query($conn,$sql_del)){
							$arr['errno'] = 0;
							$arr['error'] = '删除失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '删除成功';
							unlink($rows['goods_img']);
							exit(json_encode($arr));
						}
					}
				}
			break;
			 //产品批量删除
			case 'delAllgoods':  
				$ids = $_GET['ids'];
				if(!isset($ids)){								
					exit(json_encode($arr));
				}else{
					if(empty($ids)){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_sel = "SELECT goods_img FROM `wyp_goods_list` WHERE id IN (".$ids.")";
						$res = mysqli_query($conn,$sql_sel);
    					while($rows = mysqli_fetch_assoc($res)){
					        $g_arr[] = $rows;
					    }
						$sql_del = "DELETE FROM `wyp_goods_list` WHERE id IN (".$ids.")";
						if(!mysqli_query($conn,$sql_del)){
							$arr['errno'] = 0;
							$arr['error'] = '删除失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '删除成功';
							foreach ($g_arr as $key => $v){
								unlink($v['goods_img']);
							};
							exit(json_encode($arr));
						}
					}
				}
			break;
			 //产品修改
			case 'update_goods':  
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id']) || empty($post['goods_name']) || empty($post['goods_img']) || empty($post['goods_price']) || empty($post['series_id']) || empty($post['size_id']) || empty($post['shape_id']) || empty($post['goods_hot']) || empty($post['goods_sort']) || empty($post['goods_summary']) || empty($post['goods_details']) || empty($post['zl']) || empty($post['color']) || empty($post['jd']) || empty($post['qg'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_update = "UPDATE `wyp_goods_list` SET goods_name = '".$post['goods_name']."',goods_img = '".$post['goods_img']."',goods_price = '".$post['goods_price']."',series_id = '".$post['series_id']."',size_id = '".$post['size_id']."',shape_id = '".$post['shape_id']."',goods_hot = '".$post['goods_hot']."',goods_sort = '".$post['goods_sort']."',goods_summary = '".$post['goods_summary']."',goods_details = '".$post['goods_details']."',add_time = '".time()."',zl = '".$post['zl']."',color = '".$post['color']."',jd = '".$post['jd']."',qg = '".$post['qg']."' WHERE id =".$post['id'];
						// exit($sql_update);
						if(!mysqli_query($conn,$sql_update)){
							$arr['errno'] = 0;
							$arr['error'] = '修改失败';
							exit(json_encode($arr));
						}else{
							if(!empty($post['old_img'])){
								unlink($post['old_img']);
							}
							$arr['errno'] = 1;
							$arr['error'] = '修改成功';
							exit(json_encode($arr));
						}
					}
				}
			break;	
			//产品状态修改
			case 'update_goods_state':  
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id']) || empty($post['goods_state'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						if($post['goods_state'] == 1){
							$banner_state = 2;
						}else if($post['goods_state'] == 2){
							$banner_state = 3;
						}else{
							$banner_state = 1;
						}
						$sql_update = "UPDATE `wyp_goods_list` SET goods_state = '".$banner_state."' WHERE id =".$post['id'];
						if(!mysqli_query($conn,$sql_update)){
							$arr['errno'] = 0;
							$arr['error'] = '修改失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '修改成功';
							exit(json_encode($arr));
						}
					}
				}
			break;		
			// *****************************************************************************
			// ***************************************************************************
			// 评论页操作
			 //评论删除
			case 'del_comment':  
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{	
						$sql_del = "DELETE FROM `wyp_comment` WHERE id='".$post['id']."'";
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
			 //评论批量删除
			case 'delAllcomment':  
				$ids = $_GET['ids'];
				if(!isset($ids)){								
					exit(json_encode($arr));
				}else{
					if(empty($ids)){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_del = "DELETE FROM `wyp_comment` WHERE id IN (".$ids.")";
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


			// ******************************************************************************
			// ******************************************************************************
			//订单状态修改
			case 'update_order_state':  
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id']) || empty($post['state'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						if($post['state'] == 1){
							$state = 2;
						}else if($post['state'] == 2){
							$state = 3;
						}else{
							$state = 3;
						}
						$sql_update = "UPDATE `wyp_order` SET state = '".$state."' WHERE id =".$post['id'];
						if(!mysqli_query($conn,$sql_update)){
							$arr['errno'] = 0;
							$arr['error'] = '修改失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '修改成功';
							exit(json_encode($arr));
						}
					}
				}
			break;		
			// *******************************************************************************************************
			// **********************************************************************************************
			 //管理员添加
			case 'add_admin':  
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['admin_name'])){
						$arr['error'] = '名字不能为空';
						exit(json_encode($arr));
					}elseif(empty($post['phone'])){
						$arr['error'] = '手机号不能为空';
						exit(json_encode($arr));
					}elseif(empty($post['email'])){
						$arr['error'] = '邮箱不能为空';
						exit(json_encode($arr));
					}elseif(empty($post['role_id'])){
						$arr['error'] = '权限不能为空';
						exit(json_encode($arr));
					}elseif(empty($post['admin_pass'])){
						$arr['error'] = '密码不能为空';
						exit(json_encode($arr));
					}else{
						$sql_select2 = "SELECT `id`,`admin_name` FROM `wyp_admin` WHERE admin_name='".$post['admin_name']."'";
						$db_select2 = mysqli_query($conn,$sql_select2);
						$data2 = mysqli_fetch_assoc($db_select2);
						if(!empty($data2)){						
							$arr['errno'] = 2;
							$arr['error'] = '该管理员已注册';
							exit(json_encode($arr));
						}	
						$post['admin_pass'] = passwd($post['admin_name'],$post['admin_pass']);
						$sql_insert = "INSERT INTO `wyp_admin` (admin_name,phone,email,role_id,admin_pass) VALUES ('".$post['admin_name']."','".$post['phone']."','".$post['email']."','".$post['role_id']."','".$post['admin_pass']."')";
						if(!mysqli_query($conn,$sql_insert)){
							$arr['errno'] = 0;
							$arr['error'] = '添加失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '添加成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			case 'del_admin':   //管理员删除
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_del = "DELETE FROM `wyp_admin` WHERE id='".$post['id']."'";
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
			//管理员批量删除
			case 'delAlladmin':  
				$ids = $_POST['ids'];
				if(!isset($ids)){								
					exit(json_encode($arr));
				}else{
					if(empty($ids)){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_del = "DELETE FROM `wyp_admin` WHERE id IN (".$ids.")";
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
			case 'update_admin':   //管理员修改
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id']) || empty($post['admin_name']) || empty($post['phone']) || empty($post['email']) || empty($post['role_id']) || empty($post['admin_pass'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						$sql_sel = "SELECT admin_pass FROM `wyp_admin` WHERE id=".$post['id'];
						$res = mysqli_query($conn,$sql_sel);
    					$rows = mysqli_fetch_assoc($res);
						if($post['admin_pass'] != $rows['admin_pass']){
							$post['admin_pass'] = passwd($post['admin_name'],$post['admin_pass']);
						}
						$sql_update = "UPDATE `wyp_admin` SET admin_name = '".$post['admin_name']."',phone = '".$post['phone']."',email = '".$post['email']."',role_id = '".$post['role_id']."',admin_pass = '".$post['admin_pass']."' WHERE id =".$post['id'];
						if(!mysqli_query($conn,$sql_update)){
							$arr['errno'] = 0;
							$arr['error'] = '修改失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '修改成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			 //管理员状态修改
			case 'update_admin_state':  
				$post = $_POST;
				if(!isset($post)){								
					exit(json_encode($arr));
				}else{
					if(empty($post['id']) || empty($post['state'])){
						$arr['error'] = '不能为空';
						exit(json_encode($arr));
					}else{
						if($post['state'] == 1){
							$state = 2;
						}else{
							$state = 1;
						}
						$sql_update = "UPDATE `wyp_admin` SET state = '".$state."' WHERE id =".$post['id'];
						if(!mysqli_query($conn,$sql_update)){
							$arr['errno'] = 0;
							$arr['error'] = '修改失败';
							exit(json_encode($arr));
						}else{
							$arr['errno'] = 1;
							$arr['error'] = '修改成功';
							exit(json_encode($arr));
						}
					}
				}
			break;
			// *******************************************************************************************************
			// *******************************************************************************************************
			/*管理员登录*/
			case 'login':
				$post = $_POST;
				if(!empty($_POST)){
					if(!isset($post['admin_name']) && !isset($post['admin_pass'])){
						$arr['error'] = '非法访问';
						exit(json_encode($arr));
					}else{
						$sql_select3 = "SELECT `id`,`admin_pass`,`state` FROM `wyp_admin` WHERE admin_name='".$post['admin_name']."'";
						$db_select3 = mysqli_query($conn,$sql_select3);
						$data3 = mysqli_fetch_assoc($db_select3);
						if(empty($data3)){
							$arr =array(
								'errno'=> 2,
								'error'=> '管理员账号错误',
							);
							exit(json_encode($arr));
						}
						if($data3['state'] == 2){
							$arr =array(
								'errno'=> 3,
								'error'=> '该管理员已禁用',
							);
							exit(json_encode($arr));
						}					
						$post['admin_pass'] = passwd($post['admin_name'],$post['admin_pass']);
						if($post['admin_pass'] != $data3['admin_pass']){
							$arr['error'] = '密码错误';
							exit(json_encode($arr));
						}else{
							// setcookie('user',$post['username'],time()+20);
							$_SESSION['id'] = $data3['id'];
							$arr =array(
							'errno'=> 1,
							'error'=> '登陆成功',
							'url'  => 'index.php',
							);
							exit(json_encode($arr));
						}	
					}
								
				}else{
					$arr['error'] = '非法访问';
					exit(json_encode($arr));
				}
			break;



			//******************************************************************************************************** 


			default:
				exit('接口参数错误');
			break;
		}
	}


function passwd($user,$pass){
	return md5(md5('W'.$user.'Y'.$pass.'P'));
}


?>