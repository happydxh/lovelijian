<?php
    require 'config.php';
	
	$_commentquery = mysql_query("SELECT comment,user,date FROM lj_comment WHERE articleid='{$_POST['articleid']}' ORDER BY date DESC LIMIT 0,10") or die('SQL 错误！');
	


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