<?php
    require 'config.php';
	
	$_sql = mysql_query("SELECT COUNT(*) AS count FROM lj_comment WHERE articleid='{$_POST['articleid']}'");
	$_result = mysql_fetch_array($_sql, MYSQL_ASSOC);
	
	$_pagesize = 6;
	$_allcount = $_result['count'];
	$_count = ceil($_result['count'] / $_pagesize);
	$_page = 1;
	if (!isset($_POST['commentpage'])) {
		$_page = 1;
	} else {
		$_page = $_POST['commentpage'];
		if ($_page > $_count) {
			$_page = $_count;
		}
	}
	
	$_limit = ($_page - 1) * $_pagesize;
	
	
	
	$_commentquery = mysql_query("SELECT (SELECT face_url FROM lj_user WHERE user=a.user) AS faceurl,({$_allcount}) AS count,a.id ,a.comment,a.user,a.date FROM lj_comment a WHERE a.articleid='{$_POST['articleid']}' ORDER BY a.date DESC LIMIT {$_limit},{$_pagesize}") or die('SQL 错误！');
	


	$json = '';
	
	while (!!$row = mysql_fetch_array($_commentquery, MYSQL_ASSOC)) {
		foreach ( $row as $key => $value ) {
			$row[$key] = urlencode(str_replace("\n","", $value));
		}
		$json .= urldecode(json_encode($row)).',';
	}
	
	//sleep(2);
	
	echo '['.substr($json, 0, strlen($json) - 1).']';
	
	mysql_close();
?>