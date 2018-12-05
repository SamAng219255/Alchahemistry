<?php
	session_start();
	if ((isset($_SESSION['last_active_a']) && (time() - $_SESSION['last_active_a'] > 1800)) || (!isset($_SESSION['last_active_a']) && isset($_SESSION['user_a']))) {
		session_unset();
		session_destroy();
	}
	$_SESSION['last_active_a']=time();
	if(isset($_SESSION['user_a'])) {
		require 'db.php';
		if($_POST['action']=='load') {
			
		}
		elseif($_POST['action']=='move') {
			$delta=([[1,0],[0,-1],[-1,0],[0,1]])[$_POST['direction']%4];

		}
	}
	else {
		echo 'Not Logged In.';
	}
?>