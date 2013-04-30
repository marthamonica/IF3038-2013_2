<?php
	require "config.php";
	$id_task = $_GET['idtask'];
	//dummy here
	$username = "ArieDoank";
	$deadline = $_POST['deadline'];
	$assignee = $_POST['Assignee'];
	$updatedeadline = "UPDATE task SET deadline='$deadline' WHERE id_task='$id_task'";
	mysql_query($updatedeadline);
	//id cat
	$search_cat_sql = "SELECT id_cat FROM task where id_task='$id_task'";
	$search_result = mysql_query($search_cat_sql);
	$cat = mysql_fetch_array($search_result);
	$id_cat = $cat['id_cat'];
	
	//delete semua assignee yg berhub dgn task kecuali task creator
	$delassquery = "DELETE FROM assignee WHERE id_task='$id_task'";
	mysql_query($delassquery);
	//cari creator
	$searchcreator = "SELECT pemilik from task where id_task='$id_task'";
	$creator_result = mysql_query($searchcreator);
	$creator = mysql_fetch_array($creator_result);
	$id_creator = $creator['pemilik'];
	
	$sqlassignee = "INSERT INTO assignee(`username`, `id_task`) VALUES ('$id_creator','$id_task')";
	mysql_query($sqlassignee);
	
	//delete semua tag yg berhub dgn task
	$deltagquery = "DELETE FROM tasktag WHERE tasktag.id_task='$id_task'";
	mysql_query($deltagquery);
	$array_assignee = explode(",",$assignee);
	$arraylength1 = count($array_assignee);
	for($i=0;$i<$arraylength1-1;$i++)
		{
			$sqlassignee = "REPLACE INTO assignee SET username='$array_assignee[$i]', id_task='$id_task'";
			mysql_query($sqlassignee);
			//insert ke kategori
			$sqljoincat = "REPLACE INTO joincategory SET username='$array_assignee[$i]', id_cat='$id_cat'";
			mysql_query($sqljoincat);
		}
	
	$tag = $_POST['tag'];
	$array_tag = explode(",",$tag);
	$arraylength2 = count($array_tag);
	for($j=0;$j<$arraylength2;$j++)
		{
			$searchtagsql = "SELECT name FROM tag WHERE name='$array_tag[$j]'";
			if($getsearchtagresult = mysql_query($searchtagsql)){
				$row_count = mysqli_num_rows($getsearchtagresult);
			}
			if($row_count===0){
				$sqltag = "INSERT INTO tag(`name`) VALUES ('$array_tag[$j]')";
				mysql_query($sqltag);
			}
			//cari id_tag
			$search_idtag_sql = "SELECT id_tag FROM tag where name='$array_tag[$j]'";
			$search_idtag_result = mysql_query($search_idtag_sql);
			$searchtag = mysql_fetch_array($search_idtag_result);
			$id_tag = $searchtag['id_tag'];
			//insert tasktag
			$sqltasktag = "INSERT INTO tasktag(`id_task`, `id_tag`) VALUES ('$id_task','$id_tag')";
			mysql_query($sqltasktag);
		}
	header("Location: rincitask.php?idtask=$id_task");
?>