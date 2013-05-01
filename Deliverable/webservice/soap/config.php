<?php
	$services_json = json_decode(getenv("VCAP_SERVICES"),true);
	$mysql_config = $services_json["mysql-5.1"][0]["credentials"];
	$db_username = $mysql_config["username"];
	$db_password = $mysql_config["password"];
	$db_hostname = $mysql_config["hostname"];
	$port = $mysql_config["port"];
	$db = $mysql_config["name"];
	$con = mysql_connect("$db_hostname:$port", $db_username, $db_password);
	$db_selected = mysql_select_db($db, $con);

	/*$db_host = "localhost";
	$db_username = "progin";
	$db_password = "progin";
	$db_name = "progin_405_13510032";
	
	$con = mysqli_connect("$db_host","$db_username","$db_password","$db_name");
	if(mysqli_connect_errno($con)){
		echo "Failed to connect to MySQL :" . mysqli_connect_error();
	}*/
?>