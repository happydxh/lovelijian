<?php
    require 'config.php';
	
	$_commentquery = mysql_query("SELECT (SELECT user FROM lj_comment WHERE id=a.answerid) AS ansuser,a.id,a.answerid,a.comment,a.user,a.date FROM lj_comment a WHERE answerid='{$_POST['commentid']}' ORDER BY a.date DESC LIMIT 0,10") or die('SQL 错误！');
	


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