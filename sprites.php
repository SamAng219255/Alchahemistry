<?php
	function outputSprites($path) {
		if ($handle = opendir($path)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && trim($file) != "..") {
					if(is_dir($path.$file)) {
						outputSprites($path.$file.'/');
					}
					elseif (substr($file,-4)=='.png') {
						if($GLOBALS['iter']>0) {
							echo ',';
						}
						$GLOBALS['iter']++;
						echo '"'.substr($path,14).substr($file,0,-4).'"';
					}
				}
			}
		}
	}
	echo '[';
	$GLOBALS['iter']=0;
	outputSprites('./img/sprites/');
	echo ']';
?>