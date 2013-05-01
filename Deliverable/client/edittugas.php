<?php
	require "config.php";
	require "request.php";
	//$editfullname = $_POST['editname'];
	$idtask = $_REQUEST['idtask'];
	$deadline = $_REQUEST['deadline'];
	//$assignee = "stefan";
	//$tag = "lalal";
    $assignee = $_REQUEST['Assignee'];
	$tag = $_REQUEST['tag'];
	
	//$r = SendRequest("http://nicholasrio.ap01.aws.af.cm/rest/edit?editdob=$editdob&editpassword1=$editpassword&username=$username&editname=$editfullname", 'GET', array());
	
	$r = SendRequest("http://nicholasrio.ap01.aws.af.cm/rest/ubah?idtask=$idtask&deadline=$deadline&Assignee=$assignee&tag=$tag", 'GET', array());
	print $idtask."<br/>";
	print $deadline."<br />";
	print $assignee."<br />";
	print $tag."<br />";
	print $r;

?>