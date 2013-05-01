<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php
	// include "login.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>BANG! - Profile</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="css.css" media="screen" />
    </head>
    <body>
		<?php
			require "config.php";
			require "request.php";
			session_start();
			// $cur_username = $_SESSION['username'];
			$cur_username = "ArieDoank";
			$user_profile = json_decode(SendRequest("http://nicholasrio.ap01.aws.af.cm/rest/profile?username=$cur_username", 'GET', array()), true);
			
			$done_list = json_decode(SendRequest("http://nicholasrio.ap01.aws.af.cm/rest/getDoneList?username=$cur_username", 'GET', array()), true);
			
			$undone_list = json_decode(SendRequest("http://nicholasrio.ap01.aws.af.cm/rest/getUndoneList?username=$cur_username", 'GET', array()), true);
		?>
        <?php
			// require "header.php";
		?>
        <div id="panel"></div>
        <div id="donelist">
            <?php
				foreach ($done_list as $done_row){
					echo "<a href=\"rincitask.php?id=".$done_row['id_task']."\">".$done_row['name']."</a>";
					echo "<br />";
				}
			?>
        </div>
        <div id="todolist">
            <?php
				foreach ($undone_list as $undone_row){
					echo "<a href=\"rincitask.php?id=".$undone_row['id_task']."\">".$undone_row['name']."</a>";
					echo "<br />";
				}
			?>
        </div>
        <div id="biodata">
            <img id="foto" src="<?php echo $user_profile['avatar'];?>">
            <img id="badge" src="img/badge.png">
            <div id="biousername">
				<?php
					echo $user_profile['username'];
				?>
			</div>
            <div id="bioleft">
                Name<br>
                Date of Birth<br>
                Email<br>
            </div>
            <div id="bioright">: <?php echo $user_profile['fullname'];?><br>
                : <?php echo $user_profile['birthday'];?><br>
                : <?php echo $user_profile['email'];?><br>
            </div>
			<div id="editProfile">
				<a onclick="editProfile();">Edit Profile</a>
			</div>
        </div>
	<script type="text/javascript" src="validationedit.js"></script>
	<script type="text/javascript" src="script.js"></script>
    </body>
</html>