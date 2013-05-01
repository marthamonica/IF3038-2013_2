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
			$cur_username = $_SESSION['username'];
			// $cur_username = "ArieDoank";
			$user_profile = json_decode(SendRequest("http://localhost/_tubes4/profile?username=$cur_username", 'GET', array()), true);
			
			$done_list = json_decode(SendRequest("http://localhost/_tubes4/getDoneList?username=$cur_username", 'GET', array()), true);
			
			$undone_list = json_decode(SendRequest("http://localhost/_tubes4/getUndoneList?username=$cur_username", 'GET', array()), true);
		?>
        <?php
			require "header.php";
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
		<div id='edit'>
			<div id='editProfileForm'>
					Full Name<br>
					Date of birth<br>
					Avatar<br>
					Password<br>
					Confirm Password<br>
			</div>
			<div id='inputEditProfile'>
				<form id="editForm" method="post" action="editprofile.php" enctype="multipart/form-data">
					<input type="text" name="editname" id="editname" value="<?php echo $current_user['fullname'];?>" pattern="^.+ .+$" required><img id="edit1" src=""><br>
					<input type="date" name="editdob" id="editdob" value="<?php echo $current_user['birthday'];?>" onchange="dateChange2();"><img id="edit2" src=""><br>
					<input type="file" name="editavatar" id="editavatar" onchange="checkImage2();"><img id="edit3" src=""><br>
					<input type="password" name="editpassword1" id="editpassword1" pattern="^.{8,}$" required><img id="edit4" src=""><br>
					<input type="password" name="editpassword2" id="editpassword2" pattern="^.{8,}$" required><img id="edit5" src=""><br>
					<input type="submit" id="editbutton" value="edit">
					<input type="button" onclick="profileRestore();" value="cancel">
				</form>
			</div>
		</div>
	<script type="text/javascript" src="validationedit.js"></script>
	<script type="text/javascript" src="script.js"></script>
    </body>
</html>