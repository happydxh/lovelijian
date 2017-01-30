<?php
    require 'config.php';
	  
	  $_sql = mysql_query("SELECT COUNT(*) AS count FROM lj_video_comment WHERE videoid='{$_POST['videoid']}'");
	  
	  $_rows = mysql_fetch_array($_sql,MYSQL_ASSOC);
	  
	  echo $_rows['count'];
?>