<?php
	//include "login.php";
	//$username = $_SESSION['username'];
	$username = "ArieDoank";
	$id_task = $_GET['q'];
	require "config.php";
	$result = "";
	
	$sql_tags = "SELECT * FROM tag WHERE id_tag in (SELECT id_tag FROM tasktag WHERE id_task = '$id_task')";
	$tags = mysql_query($sql_tags);
	
		while(($tags != null) && ($tags_fetched = mysql_fetch_array($tags))){
			$result .= $tags_fetched['name'].",";
		}	
	
	echo $result;
?>