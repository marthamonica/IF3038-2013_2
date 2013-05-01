<?php
	function insertUserName($username,$fullname,$date,$password,$email,$avatar){
		require "config.php";
		$insert_sql = "INSERT INTO `user`(`username`, `fullname`, `avatar`, `birthday`, `email`, `password`) VALUES ('$username','$fullname', '$avatar', '$date', '$email', '$password')";
		mysql_query($insert_sql);
		print mysql_error($con);
		return "success ".mysql_error($con);
	}
	
	function insertCategory($username,$nama,$join){
		require "config.php";
		$sql = "INSERT INTO category(`name`) VALUES ('$nama')";
		mysql_query($sql);
		
		$sql2 = "SELECT id_cat FROM category WHERE name = '$nama'";
		$user = mysql_query($sql2);
		$hasil = mysql_fetch_array($user);
		
		$idCat = $hasil['id_cat'];
		
		$sql3 = "INSERT INTO categorycreator(`username`, `id_cat`) VALUES ('$username', '$idCat')";
		mysql_query($sql3);
		if ($join != "")
		{
			$sql4 = "INSERT INTO joincategory (`id_cat`,`username`) VALUE ('$idCat','$join')";
			mysql_query($sql4);
		}
		
		$sql5 = "INSERT INTO joincategory (`id_cat`,`username`) VALUE ('$idCat','$username')";
		mysql_query($sql5);
		return "insert category success<br/>";
	}
	
	function insertTask($username,$taskname,$catname,$deadline,$asignee,$tag){
		require "config.php";
		$search_cat_sql = "SELECT id_cat FROM category where name='$catname'";
		$search_result = mysql_query($search_cat_sql);
		$cat = mysql_fetch_array($search_result);
		$id_cat = $cat['id_cat'];
		$sqltask = "INSERT INTO task(`name`, `status`, `deadline`, `id_cat`, `pemilik`) VALUES ('$taskname','0','$deadline','$id_cat','$username')";
		//jalankan sql insert task
		mysql_query($sqltask);
		//cari id task
		$search_task_sql = "SELECT id_task FROM task where name='$taskname'";
		$search_task_result = mysql_query($search_task_sql);
		$task = mysql_fetch_array($search_task_result);
		$id_task = $task['id_task'];
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
		$sqlassignee = "INSERT INTO assignee(`username`, `id_task`) VALUES ('$username','$id_task')";
		mysql_query($sqlassignee);
		
		$array_tag = explode(",",$tag);
		$arraylength2 = count($array_tag);
		for($j=0;$j<$arraylength2;$j++)
			{
				$searchtagsql = "SELECT name FROM tag WHERE name='$array_tag[$j]'";
				if($getsearchtagresult = mysql_query($searchtagsql)){
					$row_count = mysql_num_rows($getsearchtagresult);
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
				mysql_query($con,$sqltasktag);
			}
		$sqlcreator = "INSERT INTO taskcreator(`id_task`, `username`) VALUES ('$id_task','$username')";
		mysql_query($con,$sqlcreator);
		return $id_task;
	}
	
	ini_set("soap.wsdl_cache_enabled", "0");
	$server = new SoapServer("services.wsdl");	
	$server->addFunction("insertUserName");
	$server->addFunction("insertCategory");
	$server->addFunction("insertTask");
	$server->handle();
?>