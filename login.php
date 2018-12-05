<html>
<head>
	<link rel="stylesheet" type="text/css" href="theme.css">
</head>
<body>
	<?php
		require 'db.php';
		if(isset($_POST['signup'])) {
			$query="SELECT `username` from `alchahemistry`.`users` where username='".addslashes($_POST['username'])."';";
			$hashed=password_hash($_POST['password'],PASSWORD_DEFAULT);
			$sql="INSERT INTO `alchahemistry`.`users` (`id`,`username`,`password`,`ip`) VALUES (0,'".addslashes($_POST['username'])."','".$hashed."','".$_SERVER['REMOTE_ADDR']."');";
			echo $sql;
			if(!($_POST['username']!='' && $_POST['password']!='')) {
				echo '<div class="errormsg">Username or Password missing.</div>';
			}
			elseif($_POST['password']!==$_POST['password2']) {
				echo '<div class="errormsg">Passwords do not match.</div>';
			}
			elseif(mysqli_query($conn,$query)->num_rows>0) {
				echo '<div class="errormsg">Username is taken.</div>';
			}
			elseif(mysqli_query($conn,$sql)) {
				$_POST['signin']=true;
				$_SESSION['new']=true;
			}
			else {
				echo '<div class="errormsg">Unknown Error.</div>';
			}
		}
		if(isset($_POST['signin'])) {
			$query="SELECT `username`,`password` FROM `alchahemistry`.`users` WHERE username='".addslashes($_POST['username'])."';";
			$queryresult=mysqli_query($conn,$query);
			if(!($_POST['username']!='' && $_POST['password']!='')) {
				echo '<div class="errormsg">Username or Password missing.</div>';
			}
			elseif($queryresult->num_rows<1) {
				echo '<div class="errormsg">Invalid Username. or Password.</div>';
			}
			elseif(password_verify($_POST['password'],mysqli_fetch_row($queryresult)[1])) {
				$_SESSION['username']=addslashes($_POST['username']);
				$ipsql="UPDATE `alchahemistry`.`users` SET `ip`='".$_SERVER['REMOTE_ADDR']."' WHERE `username`='".$_SESSION['username']."';";
				mysqli_query($conn,$ipsql);
				echo  '<meta http-equiv="refresh" content="0; URL=./">';
			}
			else {
				echo '<div class="errormsg">Invalid Username or Password.</div>';
			}
		}
	?>
	<div id="cphold">
		<div id="lcp" class="cp"><form class="loginform" action="./" method="post">
			<label for="frminuser">Username:</label>
			<input type="text" id="frminuser" placeholder="Username" name="username" required maxlength=16 autocomplete="username">
			<label for="frminpass">Password:</label>
			<input type="password" id="frminpass" placeholder="Password" name="password" required maxlength=16 autocomplete="current-password"><br>
			<input type="submit" value="Sign In" name="signin"><br>
		</form></div>
		<div class="vl"></div>
		<div id="rcp" class="cp"><form class="loginform" action="./" method="post">
			<label for="frmupuser">Username:</label>
			<input type="text" id="frmupuser" placeholder="Username" name="username" required maxlength=16 autocomplete="username" pattern="([A-Za-z0-9_\-*ᚠ-᛭<>@])+" title="Can only include letters, numbers, underscores, hyphens, asterisks, greater/less than signs, @ signs, and runes."><br>
			<label for="frmuppass">Password:</label>
			<input type="password" id="frmuppass" placeholder="Password" name="password" required maxlength=16 autocomplete="new-password"><br>
			<label for="frmupword">Retype Password:</label>
			<input type="password" id="frmupword" placeholder="Password" name="password2" required maxlength=16 autocomplete="new-password"><br>
			<input type="submit" value="Sign Up" name="signup"><br>
		</form></div>
	</div>
</body>
</html>