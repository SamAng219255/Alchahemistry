<?php

if(isset($_SESSION['username'])) {
	require 'db.php';
	$json=file_get_contents('./default_base.json');
	$jsonData=json_decode($json,true);
	$tileCount=count($jsonData);
	for($i=0; $i<$tileCount; $i++) {
		$sql="INSERT INTO `alchahemistry`.`base` (`id`,`username`,`x`,`y`,`z`,`name`,`sprite`,`data`) VALUES (0,'".$_SESSION['username']."',".$jsonData[$i]['x'].",".$jsonData[$i]['y'].",".$jsonData[$i]['z'].",'".$jsonData[$i]['id']."','".$jsonData[$i]['sprite']."','".$jsonData[$i]['data']."');";
		mysqli_query($conn,$sql);
		if($jsonData[$i]['id']=='spawnPoint') {
			$sql="UPDATE `alchahemistry`.`users` SET `x`=".$jsonData[$i]['x'].", `y`=".$jsonData[$i]['y']." WHERE `username`='".$_SESSION['username']."';";
		}
	}
}
else {
	echo "error";
}

?>