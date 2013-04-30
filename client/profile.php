<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
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
			$user_profile = json_decode(SendRequest("http://localhost/_tubes4/profile?username=$cur_username", 'GET', array()), true);
			print $user_profile['username'];
		?>
    </body>
</html>