<?php
	require "config.php";
	require_once "request.php";
	session_start();
	$username = $_SESSION['username'];
	// $username = "ArieDoank";
	$current_user = json_decode(SendRequest("http://nicholasrio.ap01.aws.af.cm/rest/profile?username=$username", 'GET', array()), true);
?>

<header>
	<a href="dashboard.php" title="Home"><img id="logo-small" src="img/Logo_Small2.png" alt="" /></a>
	<div id="dashboard"><a title="Go to Dashboard" href="dashboard.php">Dashboard</a></div>
	<div >
	<div id="foto_header"><img src="<?php echo $current_user['avatar']?>" alt="profil picture"></div>
	<div id="profile"><a title="Go to Profile" href="profile.php?currentuser=<?php echo $current_user['username'];?>"><?php echo $current_user['username'];?></a></div>
	<div id="logout"><a title="Log out from here" href="logout.php">Log Out</a></div>
	<form id="search" action="search.php" method="post">
		<span>
			<input type="text" autocomplete="off" name="Search" id="box" onkeyup="showHint(this.value,'<?php echo $username; ?>);')">
			<input id="selectedKategori" name="namafilter" type="hidden" value="all result">
			<label onclick="showfilter();"></label>
			<div id="filter">
				<div onclick="filter(this.innerHTML);">all result</div>
				<div onclick="filter(this.innerHTML);">username</div>
				<div onclick="filter(this.innerHTML);">category</div>
				<div onclick="filter(this.innerHTML);">task</div>
			</div>
		</span>
		
		<div id="hasilsearch"></div>
	</form>
</header>