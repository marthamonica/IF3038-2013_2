<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<?php
	require "config.php";
	include "login.php";
	session_start();
	$username = $_SESSION['username'];
	//dummy here
	$category = $_GET["namakategori"];
	
	
	$sql = "SELECT * FROM user WHERE username = '$username'";
	$user = mysqli_query($con,$sql);
	$current_user = mysqli_fetch_array($user);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>BANG!!!-DASHBOARD</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="css.css" media="screen" />
    </head>
    <body>
        <?php
			include "header.php";
		?>
		<div id="category">
			<!--category here-->
		</div>
		<div id="wanted">
			<img src="img/kertas2.png">
		</div>
		<div class="tugas" id="buattugas"><br/>
			<form id="createForm" method="post" action="create.php?cat=<?php echo $category;?>" enctype="multipart/form-data">
                Name: <div class="nama"><input type="text" id="namaTask" name="namaTask" pattern="^[a-zA-Z0-9]{5,25}$" required><img id="validtask1" src=""></div><br/>
                Attachment: 
				<div class="attachment">
					<input name="taskatt[]" type="file" multiple>
				</div><br/>
                Deadline: <div class="deadline"><input type="date" name="deadline" onchange="changeDeadline();" required><img id="validtask3" src=""></div><br/>
                Assignee: 
				<div class="asignee">
				<input type="text" autocomplete="off" name="Assignee" id="Assignee" onkeyup="showAssignee(this.value);">
				</div><br/>
				<div id="hasilsearchassignee"></div>
                Tag: <div class="tag"> <input type="text" id="tag" name="tag"></div> <br/>
                <br/>
				<input type="submit" id="createbut" name="submit" value="Create Task">
			</form>
		</div>
		<script type="text/javascript" src="script.js"></script>
		<script type="text/javascript" src="validationcreate.js"></script>
    </body>
</html>
