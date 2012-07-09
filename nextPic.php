<?
$dirT='img/thumbs/';
$dirF='img/fullsize/';
if(isset($_REQUEST['ajax'])){
	$currpic = basename($_REQUEST['currpic']);
}
else{
	$currpic = $imageFile;
}
$prefix = substr($currpic,0,5);
if ($handle = opendir($dirT)) {
	$filesArray = array();
	$num=0;
	while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != ".." && substr($file,0,5)==$prefix) {
			$filesArray[$num] = $file;
			$num++;
		}
   	}
   	closedir($handle);
}
$num=0;
sort($filesArray);
foreach($filesArray as $fl){
	if($fl==$currpic){
		if(isset($filesArray[$num+1])){
			if(isset($_REQUEST['ajax'])){
				echo $dirF.$filesArray[$num+1];
			}
			else{
				$next = $dirF.$filesArray[$num+1];
			}
		}
		else{
			if(isset($_REQUEST['ajax'])){
				echo $dirF.$filesArray[0];
			}
			else{
				$next = $dirF.$filesArray[0];
			}
		}
	}
	$num++;
}
?>