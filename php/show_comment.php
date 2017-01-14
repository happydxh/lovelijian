<?php
    require 'config.php';
	
	$_commentquery = mysql_query("SELECT (SELECT face_url FROM lj_user WHERE user=a.user) AS faceurl,a.comment,a.user,a.date FROM lj_comment a WHERE a.articleid='{$_POST['articleid']}' ORDER BY a.date DESC LIMIT 0,10") or die('SQL 错误！');
	


	$json = '';
	
	while (!!$row = mysql_fetch_array($_commentquery, MYSQL_ASSOC)) {
		foreach ( $row as $key => $value ) {
			$row[$key] = urlencode(str_replace("\n","", $value));
		}
		$json .= urldecode(json_encode($row)).',';
	}
	
	echo '['.substr($json, 0, strlen($json) - 1).']';
	
	mysql_close();
?>