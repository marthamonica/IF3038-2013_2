<?php
	//include "login.php";
	//$username = $_SESSION['username'];
	$username = "ArieDoank";
	$id_task = $_GET['q'];
	
	require "config.php";
	$result = "";
	
	//ALL IN DUMMY HERE
	$sql_attachment = "SELECT * FROM attachment WHERE id_attachment in (SELECT id_attachment FROM taskattachment WHERE id_task = '$id_task')";
	$attachment = mysql_query($sql_attachment);
	
	while(($attachment != null) && ($attachment_fetched = mysql_fetch_array($attachment))){
		$result .= $attachment_fetched['path'].",";
	}
	
	echo $result;
?>