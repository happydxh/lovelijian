<?php
    require 'config.php';
	  
	  $_sql = mysql_query("SELECT zan FROM lj_video WHERE id='{$_POST['id']}'");
	  
	  $_rows = mysql_fetch_array($_sql,MYSQL_ASSOC);
	  
	  echo $_rows['zan'];
?>