<?php
	//include "login.php";
	require "config.php";
	
	$id_comment = $_GET['q'];
	
	$sql_del = "DELETE FROM comment WHERE id_comment='$id_comment'";
	mysql_query($sql_del);
	
	echo "deleted";
?>