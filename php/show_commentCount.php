<?php
    require 'config.php';
	  
	  $_sql = mysql_query("SELECT COUNT(*) AS count FROM lj_comment WHERE articleid='{$_POST['articleid']}'");
	  
	  $_rows = mysql_fetch_array($_sql,MYSQL_ASSOC);
	  
	  echo $_rows['count'];
?>