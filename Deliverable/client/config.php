<?php
	$db_host = "localhost";
	$db_username = "progin";
	$db_password = "progin";
	$db_name = "progin_405_13510032";
	
	$con = mysqli_connect("$db_host","$db_username","$db_password","$db_name");
	if(mysqli_connect_errno($con)){
		echo "Failed to connect to MySQL :" . mysqli_connect_error();
	}
?>