<?php
	
	
	//sleep(1);
	require 'config.php';
	
	$query = "INSERT INTO lj_video_comment (type,comment, user,answerid, date) VALUES ('{$_POST['type']}','{$_POST['answer_comment']}', '{$_POST['user']}','{$_POST['commentid']}', NOW())";
	
	mysql_query($query) or die('新增失败！'.mysql_error());
	
	echo mysql_affected_rows();
	
	mysql_close();
?>