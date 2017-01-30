<?php
    require 'config.php';
	  
	  mysql_query("UPDATE lj_video SET 
		                                zan = '{$_POST['zan']}'
                                    WHERE
                                        id='{$_POST['id']}'   
		            ") or die('SQL执行错误'.mysql_error());
	  
	  echo mysql_affected_rows();
	  
	  mysql_close();
?>