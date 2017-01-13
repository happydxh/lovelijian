<?php
      require 'config.php';
	  
	  $_sql = mysql_query("SELECT COUNT(*) AS count FROM lj_comment WHERE articleid='{$_POST['articleid']}'");
?>