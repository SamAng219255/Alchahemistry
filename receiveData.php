<?php
	session_start();
	if ((isset($_SESSION['last_active_a']) && (time() - $_SESSION['last_active_a'] > 1800)) || (!isset($_SESSION['last_active_a']) && isset($_SESSION['user_a']))) {
		session_unset();
		session_destroy();
	}
	$_SESSION['last_active_a']=time();
	
?>