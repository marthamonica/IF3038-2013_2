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
?>