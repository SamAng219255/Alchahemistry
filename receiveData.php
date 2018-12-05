<?php
	session_start();
	if ((isset($_SESSION['last_active_a']) && (time() - $_SESSION['last_active_a'] > 1800)) || (!isset($_SESSION['last_active_a']) && isset($_SESSION['user_a']))) {
		session_unset();
		session_destroy();
	}
	$_SESSION['last_active_a']=time();
	if(isset($_SESSION['username'])) {
		require 'db.php';
		$gamestate='none';
		if(!isset($_SESSION['state']) || $_SESSION['state']=='load') {
			$gamestate='load';
			$_SESSION['state']='load';
		}
		echo '{"state":"'.$gamestate.'",';
		$userdataquery="SELECT `color`,`prefix`,`suffix`,`permissions`,`x`,`y`,`health`,`xp`,`zone` FROM `alchahemistry`.`users` WHERE `username`='".$_SESSION['username']."';";
		$userdataqueryresult=mysqli_query($conn,$userdataquery);
		$userdatarow=mysqli_fetch_row($userdataqueryresult);
		echo '"user":{"color":"'.($_SESSION['color']=$userdatarow[0]).'",';
		echo '"prefix":"'.($_SESSION['prefix']=$userdatarow[1]).'",';
		echo '"suffix":"'.($_SESSION['suffix']=$userdatarow[2]).'",';
		echo '"permissions":"'.($_SESSION['permissions']=$userdatarow[3]).'",';
		echo '"x":"'.($_SESSION['x']=$userdatarow[4]).'",';
		echo '"y":"'.($_SESSION['y']=$userdatarow[5]).'",';
		echo '"health":"'.($_SESSION['health']=$userdatarow[6]).'",';
		echo '"xp":"'.($_SESSION['xp']=$userdatarow[7]).'",';
		echo '"zone":"'.($_SESSION['zone']=$userdatarow[8]).'"},';
		$itemsquery="SELECT `name`,`count`,`new`,`slot`,`data` FROM `alchahemistry`.`items` WHERE `username`='".$_SESSION['username']."';";
		$itemsqueryresult=mysqli_query($conn,$itemsquery);
		echo '"items":[';
		for($i=0; $i<$itemsqueryresult->num_rows; $i++) {
			$itemsrow=mysqli_fetch_row($itemsqueryresult);
			if($i>0) {echo ',';}
			echo '{"name":"'.($_SESSION['name']=$itemsrow[0]).'",';
			echo '"count":"'.($_SESSION['count']=$itemsrow[1]).'",';
			echo '"new":"'.($_SESSION['new']=$itemsrow[2]).'",';
			echo '"slot":"'.($_SESSION['slot']=$itemsrow[3]).'",';
			echo '"data":"'.($_SESSION['data']=$itemsrow[4]).'"}';
		}
		echo '],';
		$zone;
		$whereusername=" AND `username`='".$_SESSION['username']."'";
		if($_SESSION['zone']==0) {
			$zone='base';
		}
		elseif($_SESSION['zone']==1) {
			$zone='battlefield';
			$whereusername='';
		}
		else {
			$zone='dungeon';
		}
		$cell=[floor(intval($_SESSION['x'])/7),floor(intval($_SESSION['y'])/5)];
		$roomquery="SELECT `x`,`y`,`z`,`name`,`sprite`,`data` FROM `alchahemistry`.`".$zone."` WHERE `x` BETWEEN ".($cell[0]-1)." AND ".($cell[0]+8)." AND `y` BETWEEN ".($cell[1]-1)." AND ".($cell[1]+6).$whereusername.";";
		$roomqueryresult=mysqli_query($conn,$roomquery);
		$_SESSION['viewMap']=array();
		for($z=0; $z<3; $z++) {
			array_push($_SESSION['viewMap'],array());
			for($y=0; $y<7; $y++) {
				array_push($_SESSION['viewMap'][$z],array());
				for($x=0; $x<9; $x++) {
					array_push($_SESSION['viewMap'][$z][$y],array("x"=>$x,"y"=>$y,"z"=>$z,"name"=>"blank","sprite"=>"none","data"=>""));
				}
			}
		}
		for($i=0; $i<$roomqueryresult->num_rows; $i++) {
			$roomrow=mysqli_fetch_row($roomqueryresult);
			$_SESSION['viewMap'][intval($roomrow[2])][(intval($roomrow[1])-$cell[1]+1)][(intval($roomrow[0])-$cell[0]+1)]=array("x"=>$roomrow[0],"y"=>$roomrow[1],"z"=>$roomrow[2],"name"=>$roomrow[3],"sprite"=>$roomrow[4],"data"=>$roomrow[5]);
		}
		echo '"viewMap":[';
		for($z=0; $z<3; $z++) {
			if($z>0) {echo ',';}
			echo '[';
			for($y=0; $y<7; $y++) {
				if($y>0) {echo ',';}
				echo '[';
				for($x=0; $x<9; $x++) {
					if($x>0) {echo ',';}
					echo json_encode($_SESSION['viewMap'][$z][$y][$x]);
				}
				echo ']';
			}
			echo ']';
		}
		echo ']}';
	}
	else {
		echo '{"error":"No user logged in."}';
	}
?>