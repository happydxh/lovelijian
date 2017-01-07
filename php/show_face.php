<?php
	require 'config.php';
	
//	$_url = $_POST['user'];
//	echo $_url;
	
	
	
	$query = mysql_query("SELECT face_url FROM lj_user WHERE user='{$_POST['user']}' LIMIT 1") or die('SQL 错误！');
	
	
	
	$row = mysql_fetch_array($query, MYSQL_ASSOC);
	$_face_url = $row['face_url'];
	
	echo $_face_url;
	
	mysql_close();
?>