<?php
	
	
	
	require 'config.php';
	
	$query = "INSERT INTO lj_dongtai (content, title, date) VALUES ('{$_POST['content']}', '{$_POST['title']}', NOW())";
	
	mysql_query($query) or die('新增失败！'.mysql_error());
	
	echo mysql_affected_rows();
	
	mysql_close();
?>