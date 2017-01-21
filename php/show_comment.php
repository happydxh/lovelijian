<?php
    require 'config.php';
	
	$_sql = mysql_query("SELECT COUNT(*) AS count FROM lj_comment");
	$_result = mysql_fetch_array($_sql, MYSQL_ASSOC);
	
	$_pagesize = 15;
	$_count = ceil($_result['count'] / $_pagesize);
	$_page = 1;
	if (!isset($_POST['page'])) {
		$_page = 1;
	} else {
		$_page = $_POST['page'];
		if ($_page > $_count) {
			$_page = $_count;
		}
	}
	
	$_limit = ($_page - 1) * $_pagesize;
	
	
	
	$_commentquery = mysql_query("SELECT (SELECT face_url FROM lj_user WHERE user=a.user) AS faceurl,({$_count}) AS count,a.id ,a.comment,a.user,a.date FROM lj_comment a WHERE a.articleid='{$_POST['articleid']}' ORDER BY a.date DESC LIMIT {$_limit},{$_pagesize}") or die('SQL 错误！');
	


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