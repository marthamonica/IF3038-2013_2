<?php
	//include "login.php";
	$id_task = $_GET["id"];
	//$username = $_SESSION['username'];
	
	require "config.php";
	$result = "";
	
	//PLEASE CHANGE EndyDoank with $username!!!!!!!!!!!!!!!!!
	$sql_status = "SELECT * FROM task WHERE id_task='$id_task'";
	$status = mysql_query($sql_status);
	$status_fetched = mysql_fetch_array($status);
	
	$result .= $status_fetched['id_task'].",".$status_fetched['status'];
	
	echo $result;
?>