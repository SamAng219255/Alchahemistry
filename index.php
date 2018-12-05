<?php
	session_start();
	if ((isset($_SESSION['last_active_a']) && (time() - $_SESSION['last_active_a'] > 1800)) || (!isset($_SESSION['last_active_a']) && isset($_SESSION['user_a']))) {
		session_unset();
		session_destroy();
	}
	$_SESSION['last_active_a']=time();
	if(isset($_SESSION['username']) || ($_SERVER['HTTP_HOST']=='localhost' && isset($_GET['bypasslogin']))) {
		if(isset($_SESSION['new']) && $_SESSION['new']===true) {
			require 'newPlayer.php';
		}
		echo '
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="theme.css">
	<script src="jquery.js"></script>
	<script src="pageHandler.js"></script>
	<title>Alchahemistry</title>
</head>
<body onload="canvasSetup(); loadAssets(generalSetup);">
	<canvas id="viewWindow"></canvas>
	<div id="alrtBlur" onload="alrtBlur=this;"></div>
</body>
</html>';
	}
	else {
		require 'login.php';
	}
?>