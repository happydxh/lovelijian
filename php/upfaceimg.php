<?php
	require 'config.php';
	
	$now = time();
	
	$base64 = $_POST['baseurl'];
	$img = base64_decode($base64);
	$a = file_put_contents('../face/test'.$now.'.jpg', $img);//返回的是字节数
	$b = 'face/test'.$now.'.jpg';
	print_r($b);
	print_r($base64);
	
	//更新头像链接
	
	
	$query = "UPDATE lj_user SET 
		                                face_url ='{$b}'
		                                
                                WHERE
                                        id = 1
                                LIMIT
                                        1
                                 
	            ";

	mysql_query($query) or die('更新失败！'.mysql_error());
	
	sleep(3);
	echo mysql_affected_rows();
	
	mysql_close();

?>