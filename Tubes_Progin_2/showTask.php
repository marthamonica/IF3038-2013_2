<?php
	//include "cek.php";
	//$username = $_SESSION['username'];
	$username ="EndyDoank";
	$q=$_GET['q'];
	require "config.php";
	$hasil = "";
	if ($q == "0")
	{	
		$sql = "SELECT * FROM task WHERE id_task in (SELECT id_task FROM assignee WHERE username='$username')";
		$user = mysqli_query($con,$sql);
		while(($user != null) && ($data = mysqli_fetch_array($user)))
		{
			$idtask = $data['id_task'];
			$sql2 = "SELECT name FROM tag WHERE id_tag in (SELECT id_tag FROM tasktag WHERE id_task='$idtask')";
			$user2 = mysqli_query($con,$sql2);
			$tag = array();
			while(($user2 != null) && ($data2 = mysqli_fetch_array($user2)))
			{
				$tag[] .= $data2['name'];
			}
			$hasil .= "<br>".$data['name'].",".$data['deadline'].",".$data['status'].",".$data['Pemilik'];
			
			if ($username == $data['Pemilik'])
			{
				$hasil .= ",yes";
			}
			else
			{
				$hasil .= ",no";
			}
			
			for($i = 0; $i < count($tag); $i++)
			{
				$hasil .= ",".$tag[$i];
			}
		}
	} else
	{
		$sql = "SELECT task.id_task as id_task,task.name as name,task.deadline as deadline,task.status as status,task.Pemilik as pemilik FROM assignee INNER JOIN task ON assignee.id_task = task.id_task WHERE username='$username' AND task.id_cat in (SELECT id_cat FROM category WHERE name='$q')";
		$user = mysqli_query($con,$sql);
		while(($user != null) && ($data = mysqli_fetch_array($user)))
		{
			$idtask = $data['id_task'];
			$sql2 = "SELECT name FROM tag WHERE id_tag in (SELECT id_tag FROM tasktag WHERE id_task='$idtask')";
			$user2 = mysqli_query($con,$sql2);
			$tag = array();
			while(($user2 != null) && ($data2 = mysqli_fetch_array($user2)))
			{
				$tag[] .= $data2['name'];
			}
			$hasil .= "<br>".$data['name'].",".$data['deadline'].",".$data['status'].",".$data['pemilik'];
			
			if ($username == $data['pemilik'])
			{
				$hasil .= ",yes";
			}
			else
			{
				$hasil .= ",no";
			}
			
			for($i = 0; $i < count($tag); $i++)
			{
				$hasil .= ",".$tag[$i];
			}
		}
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
	exit;
?>