<?php
	require "config.php";
	require "request.php";
	session_start();
	$username = $_SESSION['username'];
	$editfullname = str_replace(' ', '%20', $_POST['editname']);
	//$editfullname = $_POST['editname'];
	$editdob = $_POST['editdob'];
	$editpassword = $_POST['editpassword1'];
	$r = SendRequest("http://localhost/_tubes4/edit?editdob=$editdob&editpassword1=$editpassword&username=$username&editname=$editfullname", 'GET', array());
	print $username."<br/>";
	print $editfullname."<br />";
	print $editdob."<br />";
	print $editpassword."<br />";
	print $r;
	header('Location: profile.php');
?>