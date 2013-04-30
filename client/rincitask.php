<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php
	//include "login.php";
	//$username = $_SESSION['username'];
	require "config.php";
	require "request.php";
	$id = $_GET["idtask"];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>BANG!!!-DASHBOARD</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="css.css" media="screen" />
        <script type="text/javascript" src="script.js"></script>
		<script>
		</script>
    </head>
    <body>
        
		<div id="category">
			
		</div>
		<div id="wanted">
			<img src="img/kertas2.png">
		</div>
		<div class="tugas" id="rincitugas">
                <b>Task Name : </b>
				<?php
					session_start();
					$user_task = json_decode(SendRequest("http://localhost/_tubes4/rincitugas?idtask=$id", 'GET', array()), true);
					print $user_task['name'];
					print "<br />";
				?>
				
				<b>Task Status : </b>
				<div id="status_detail"></div>
				
                <b>Attachment : </b>
                <div id="attachment"></div>
				
                <b>Deadline : </b>
				<?php
					print $user_task['deadline'];
				?>
				<br/>
                <b>Assignee : </b>
				<div id="assignee"></div>
				
                <b>Tag : </b><br> <div id="tag"></div>
				
                <b>Comments : <b><br/>
                <div id="list_comment"></div>
				
				<b>Submit Your Comment: </b><br/>
                <form id="submit_comment">
                    <textArea id="comment"></textarea>
                    <input type="button" name="submit" value="Submit" onClick="storeComment(<?php echo $id;?>);">
                </form>
				
                <br/><br/>
                <a href="edittask.php?id=<?php echo $id;?>" class="button">edit</a><br/>
            </div>
			<script>
				window.onload=generate_page(<?php echo $id;?>);
				setInterval(function(){generate_page(<?php echo $id;?>);},5000)
			</script>
    </body>
</html>
