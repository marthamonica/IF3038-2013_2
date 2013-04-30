<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<?php
	//include "login.php";
	//$username = $_SESSION['username'];
	require "config.php";
	require "request.php";
	$id = $_GET["id"];
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
			//include "header.php";
		?>
		<div id="category">
		</div>
		<div id="wanted">
			<img src="img/kertas2.png">
		</div>
		<div class="tugas" id="edittask"><br/>
			<form id="editTaskForm" method="post" action="ubahtask.php?idtask=<?php echo $id;?>" enctype="multipart/form-data">
                Task Name: 
				<div class="nama">
				<?php	
					$cur_task = json_decode(SendRequest("http://localhost/_tubes4/curtask?idtask=$id", 'GET', array()), true);
					print $cur_task['name'];
				?>
				</div><br/>
                Deadline:
				<div class="deadline">
					<input type="date" name="deadline" value="<?php echo $cur_task['deadline'];?>" onchange="changeDeadline();" required><img id="validtask3" src="">
				</div><br/>
                Assignee: 
				<div class="asignee">
				<?php
					$curassignee = json_decode(SendRequest("http://localhost/_tubes4/curassigne?idtask=$id", 'GET', array()), true);
					
				
						echo "<input type=\"text\" value=\"";
						foreach ($curassignee as $cur_row){
							echo $cur_row["username"].",";
						}
						echo "\" autocomplete=\"off\" name=\"Assignee\" id=\"Assignee\" onkeyup=\"showAssignee(this.value);\">";
				
					?>
					</div><br/>
				<div id="hasilsearchassigneeedit"></div>
                Tag: 
				<div class="tag">
				<?php
					$curtag = json_decode(SendRequest("http://localhost/_tubes4/curtag?idtask=$id", 'GET', array()), true);
					
				
						echo "<input type=\"text\" value=\"";
						foreach ($curtag as $cur_row){
							echo $cur_row["name"].",";
						}
						echo "\" id=\"tag\" name=\"tag\" autocomplete=\"off\" onkeyup=\"showTag(this.value);\">";
				
					?>
				</div> <br/>
                <br/>
				<div id="hasilsearchtag"></div>
				<input type="submit" id="editbut" name="submit" value="Edit Task">
				<!--Back to Detail Task-->
				<input type="button" id="cancelEditTask" name="cancelEditTask" value="Cancel" onclick="">
				<div id="deletebutton">
					<input type="button" id="deleteTas" name="deleteTas" value="Delete This Task" onclick="deleteTask(<?php echo $cur_task['id_task'];?>);">
				</div>
				
			</form>
		</div>
		<script type="text/javascript" src="script.js"></script>
		<script type="text/javascript" src="validationedittask.js"></script>
    </body>
</html>