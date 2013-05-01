<?php
	//include "login.php";
	//$username = $_SESSION['username'];
	$username = "ArieDoank";
	
	require "config.php";
	
	$sql = "SELECT name FROM category WHERE id_cat in (SELECT id_cat FROM joincategory WHERE username='$username') UNION SELECT name FROM category WHERE id_cat in (SELECT id_cat FROM categorycreator WHERE username='$username')";
	$user = mysqli_query($con,$sql);
	$hasil = "";
	while(($user != null) && ($data = mysqli_fetch_array($user)))
	{
		$hasil .= "<br>".$data['name'];
	}
	
	if ($hasil == "")
	{
		$response="";
	}
	else
	{
	  $response=$hasil;
	}

	//output the response
	echo $response;
?>