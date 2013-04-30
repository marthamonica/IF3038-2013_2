<?php
	//include "login.php";
	//$username = $_SESSION['username'];
	$username = "ArieDoank";
	$id_task = $_GET['q'];
	
	require "config.php";
	$result = "";
	
	//ALL IN DUMMY HERE
	$sql_assignee = "SELECT * FROM assignee WHERE id_task = '$id_task'";
	$assignee = mysql_query($sql_assignee);
	
	while(($assignee != null) && ($assignee_fetched = mysql_fetch_array($assignee))){
		$result .= $assignee_fetched['username'].",";
	}
	
	echo $result;
?>