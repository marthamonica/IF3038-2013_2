<?php
	$db_host = "localhost";
	$db_username = "progin";
	$db_password = "progin";
	$db_name = "progin_405_13510032";
	
	$con = mysql_connect("$db_host","$db_username","$db_password");
	mysql_select_db($db_name,$con);
	/*if(mysql_connect_errno($con)){
		echo "Failed to connect to MySQL :" . mysql_connect_error();
	}*/
?>