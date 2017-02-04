<?php
	
	
	//sleep(1);
	require 'config.php';
	
	$query = "INSERT INTO lj_dongtai_comment (comment, user,articleid, date) VALUES ('{$_POST['comments']}', '{$_POST['user']}','{$_POST['articleid']}', NOW())";
	
	mysql_query($query) or die('新增失败！'.mysql_error());
	
	echo mysql_affected_rows();
	
	mysql_close();
?>