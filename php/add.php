<?php
	require 'config.php';
	
	
	
	$query = "INSERT INTO lj_user (user, pass, email, reg_date) 
												VALUES ('{$_POST['user']}', sha1('{$_POST['pass']}'), '{$_POST['email']}', NOW())";

	mysql_query($query) or die('新增失败！'.mysql_error());
	
	echo mysql_affected_rows();
	
	mysql_close();
?>