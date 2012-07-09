<?
//Set default settings:
$defaultCategory = 'main';
$thumbSize = 150;
$thumbCropped = true;
$showExif = true;
//now check settings file:
if(file_exists("md/settings")){
	$f = fopen ("md/settings", "r");
	while ($line = fgets($f)) {
		$type = substr($line,0,strpos($line,':'));
		$sett = trim(substr($line,strpos($line,':')+1,strlen($line)));
		//echo "|".$type."|".$sett."|";
		if($type=='default_category'){
			$defaultCategory = $sett;
		}
		if($type=='thumb_size'){
			$thumbSize = (int)$sett;
		}
		if($type=='thumb_cropped'){
			if($sett=='true'){
				$thumbCropped = true;
			}
			if($sett=='false'){
				$thumbCropped = false;
			}
		}
		if($type=='show_exif'){
			if($sett=='true'){
				$showExif = true;
			}
			if($sett=='false'){
				$showExif = false;
			}
		}
	}
	fclose ($f);
}
/////Change these = have whether it is MD as the first line in the file
function getMD($file){
	$dir='md/';
	$myFile = $dir.$file;
	$fh = fopen($myFile, 'r');
	$theData = fread($fh, filesize($myFile));
	if(strpos($theData,"zzMARKDOWNzz")===false){
		$found=false;
	}
	else{
		$found=true;
	}
	fclose($fh);
	return $found;
}
if(file_exists("md/title")){
	$f = fopen ("md/title", "r");
	while ($line = fgets($f)){
		$title = strip_tags($line);
	}
}
else{
	$title = "No Title";
}
?>