<?php
	include "login.php";
	//require "config.php";
	$baseURL = "http://nicholasrio.ap01.aws.af.cm/soap/services.wsdl";
	$username = $_SESSION['username'];
	$nama = $_POST['cate'];
	$join = $_POST['join'];
	
	$client = new SoapClient($baseURL);
	$response = $client->insertCategory($username,$nama,$join);

	header('Location: Dashboard.php');
?>