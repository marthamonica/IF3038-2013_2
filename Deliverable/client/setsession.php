<?php
	session_start();
	$_SESSION['username'] = $_GET['username'];
	
	//SET COOKIES, EXPIRED 30 DAYS
	$expire=time()+60*60*24*30;
	setcookie("username", $result['username'], $expire);
	header("Location: Dashboard.php");
?>