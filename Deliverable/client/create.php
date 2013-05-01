<?php
	require "config.php";
	include "login.php";
	$baseURL = "http://nicholasrio.ap01.aws.af.cm/soap/services.wsdl";
	$catname = $_GET["cat"];
	$username = $_SESSION['username'];
	$taskname = $_POST['namaTask'];
	$deadline = $_POST['deadline'];
	$assignee = $_POST['Assignee'];
	$tag = $_POST['tag'];
	$client = new SoapClient($baseURL);
	$response = $client->insertTask($username,$taskname,$catname,$deadline,$assignee,$tag);
	//echo $response;
	//cari id_kategori dari nama kategori
	/*$search_cat_sql = "SELECT id_cat FROM category where name='$catname'";
	$search_result = mysqli_query($con,$search_cat_sql);
	$cat = mysqli_fetch_array($search_result);
	$id_cat = $cat['id_cat'];
	$sqltask = "INSERT INTO task(`name`, `status`, `deadline`, `id_cat`, `pemilik`) VALUES ('$taskname','0','$deadline','$id_cat','$username')";
	//jalankan sql insert task
	mysqli_query($con,$sqltask);
	//cari id task
	$search_task_sql = "SELECT id_task FROM task where name='$taskname'";
	$search_task_result = mysqli_query($con,$search_task_sql);
	$task = mysqli_fetch_array($search_task_result);
	$id_task = $task['id_task'];
	$array_assignee = explode(",",$assignee);
	$arraylength1 = count($array_assignee);
	for($i=0;$i<$arraylength1-1;$i++)
		{
			$sqlassignee = "REPLACE INTO assignee SET username='$array_assignee[$i]', id_task='$id_task'";
			mysqli_query($con,$sqlassignee);
			//insert ke kategori
			$sqljoincat = "REPLACE INTO joincategory SET username='$array_assignee[$i]', id_cat='$id_cat'";
			mysqli_query($con,$sqljoincat);
		}
	$sqlassignee = "INSERT INTO assignee(`username`, `id_task`) VALUES ('$username','$id_task')";
	mysqli_query($con,$sqlassignee);
	
	$array_tag = explode(",",$tag);
	$arraylength2 = count($array_tag);
	for($j=0;$j<$arraylength2;$j++)
		{
			$searchtagsql = "SELECT name FROM tag WHERE name='$array_tag[$j]'";
			if($getsearchtagresult = mysqli_query($con,$searchtagsql)){
				$row_count = mysqli_num_rows($getsearchtagresult);
			}
			if($row_count===0){
				$sqltag = "INSERT INTO tag(`name`) VALUES ('$array_tag[$j]')";
				mysqli_query($con,$sqltag);
			}
			//cari id_tag
			$search_idtag_sql = "SELECT id_tag FROM tag where name='$array_tag[$j]'";
			$search_idtag_result = mysqli_query($con,$search_idtag_sql);
			$searchtag = mysqli_fetch_array($search_idtag_result);
			$id_tag = $searchtag['id_tag'];
			//insert tasktag
			$sqltasktag = "INSERT INTO tasktag(`id_task`, `id_tag`) VALUES ('$id_task','$id_tag')";
			mysqli_query($con,$sqltasktag);
		}
	$sqlcreator = "INSERT INTO taskcreator(`id_task`, `username`) VALUES ('$id_task','$username')";
	mysqli_query($con,$sqlcreator);*/
	if(!empty($_FILES['taskatt']["name"])){
		$taskatt = $_FILES['taskatt']["name"];
		$countatt = count($taskatt);
		for($k=0;$k<$countatt;$k++){
			$target = "att/".$idtask."att".$k.$_FILES['taskatt']["name"][$k];
			move_uploaded_file($_FILES['taskatt']["tmp_name"][$k],$target);
			$sqlatt = "INSERT INTO `attachment`(`path`) VALUES ('$target')";
			mysqli_query($con,$sqlatt);
			//cari id_att
			$search_att_sql = "SELECT id_attachment FROM attachment where path='$target'";
			$search_att_result = mysqli_query($con,$search_att_sql);
			$searchatt = mysqli_fetch_array($search_att_result);
			$id_att = $searchatt['id_attachment'];
			//insert taskattachment
			$sqltaskatt = "INSERT INTO taskattachment(`id_task`, `id_attachment`) VALUES ('$id_task','$id_att')";
			mysqli_query($con,$sqltaskatt);
		}
	}
	
	header("Location: rincitask.php?id=".$response);
?>