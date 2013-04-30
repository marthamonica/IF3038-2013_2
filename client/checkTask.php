<?php
	//include "login.php";
	
	require "config.php";

	$idtask = $_GET['q'];
	$hint = "";
	$sql = "SELECT status FROM task WHERE id_task = '$idtask'";
	$user = mysql_query($sql);
	$status = mysql_fetch_array($user);
	
	if ($status['status'] == 0)
	{
		$sql2 = "UPDATE task SET status='1' WHERE id_task = '$idtask'";
		mysql_query($sql2);
		$hint = "tugas done";
	} else if ($status['status'] == 1)
	{
		$sql2 = "UPDATE task SET status='0' WHERE id_task = '$idtask'";
		mysql_query($sql2);
		$hint = "tugas undone";
	}
	
	if ($hint == "")
	{
		$response="";
	}
	else
	{
	  $response=$hint;
	}
	
	echo $response;
?>