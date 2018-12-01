<?php
	session_start();
	if ((isset($_SESSION['last_active_a']) && (time() - $_SESSION['last_active_a'] > 1800)) || (!isset($_SESSION['last_active_a']) && isset($_SESSION['user_a']))) {
		session_unset();
		session_destroy();
	}
	$_SESSION['last_active_a']=time();
?>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="theme.css">
	<script src="jquery.js"></script>
	<script src="pageHandler.js"></script>
	<title>Alchahemistry</title>
</head>
<body onload="canvasSetup(); generalSetup();">
	<canvas id="viewWindow"></canvas>
</body>
</html>