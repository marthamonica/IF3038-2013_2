<?php
	//include "login.php";
	require "config.php";
	$idTask = $_GET['q'];
	
	$sql1 = "DELETE FROM assignee WHERE id_task='$idTask'";
	$sql2 = "DELETE FROM comment WHERE id_task='$idTask'";
	$sql3 = "DELETE FROM task WHERE id_task='$idTask'";
	$sql4 = "DELETE FROM taskattachment WHERE id_task='$idTask'";
	$sql5 = "DELETE FROM tasktag WHERE id_task='$idTask'";
	
	mysql_query($sql1);
	mysql_query($sql2);
	mysql_query($sql3);
	mysql_query($sql4);
	mysql_query($sql5);
	
	echo "deleted";
?>