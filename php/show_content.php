<?php
	require 'config.php';
	
	$_sql = mysql_query("SELECT COUNT(*) AS count FROM lj_article");
	$_result = mysql_fetch_array($_sql, MYSQL_ASSOC);
	
	$_pagesize = 6;
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
	
	
	
	  //显示贴子
    $query = mysql_query("SELECT (SELECT face_url FROM lj_user WHERE user=a.user) AS faceurl,({$_count}) AS count,a.id,a.content,a.user,a.date , a.zan FROM lj_article a ORDER BY a.date DESC LIMIT {$_limit},{$_pagesize}") or die('SQL 错误！');
	
	$json = '';
	
	while (!!$row = mysql_fetch_array($query, MYSQL_ASSOC)) {
		foreach ( $row as $key => $value ) {
			$row[$key] = urlencode(str_replace("\n","", $value));
		}
		$json .= urldecode(json_encode($row)).',';
	}
    //sleep(1);
	echo '['.substr($json, 0, strlen($json) - 1).']';
	
	mysql_close();
?>