<?php
	//include "login.php";
	//$username = $_SESSION['username'];
	$username = "ArieDoank";
	$id_task = $_GET['q'];
	
	require "config.php";
	$result = "";
	
	//ALL DUMMY HERE!
	$sql_comment = "SELECT * FROM comment WHERE id_task='$id_task'";
	$comment = mysql_query($sql_comment);
	
	while(($comment != null) && ($comment_fetched = mysql_fetch_array($comment))){
		$cur_username = $comment_fetched['username'];
		
		$sql_avatar = "SELECT * FROM user WHERE username = '$cur_username'";
		$avatar = mysql_query($sql_avatar);
		$avatar_fetched = mysql_fetch_array($avatar);
		
		$result .= "<br>".$avatar_fetched['avatar'].",".$comment_fetched['time'].",".$comment_fetched['content'].",".$comment_fetched['username'].",$cur_username,".$comment_fetched['id_comment'];
	}
	
	echo $result;
?>