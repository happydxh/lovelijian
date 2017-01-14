<?php
    require 'config.php';
	  
	  mysql_query("UPDATE lj_article SET 
		                                zan = '{$_POST['zan']}'
                                    WHERE
                                        id='{$_POST['articleid']}'   
		            ") or die('SQL执行错误'.mysql_error());
	  
	  echo mysql_affected_rows();
	  
	  mysql_close();
?>