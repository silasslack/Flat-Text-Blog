<?
include('settings.php');
$category = $_REQUEST['category'];
$imgfl = $_REQUEST['imgfl'];
$orientt = $_REQUEST['orientt'];
if($orientt=='portrait'){
	$wid="width='65%'";
}
else{
	$wid="width='95%'";
}
function getNext(){
	$dir = 'md/';
	if ($handle = opendir($dir)) {
		$current="00000";
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && substr($file,0,3)!="cat" && substr($file,0,5)!="title" && substr($file,0,11)!="flickr_cats" && substr($file,0,4)!="priv" && substr($file,0,8)!="settings") {
				$file = substr($file, 0, 6);
				if($file > $current){
					$current = $file;
				}
	        }
	    }
	    closedir($handle);
		$next = str_pad($current+1,5,'0',STR_PAD_LEFT);
		return $next;
	}
}
$next = getNext();
$fname = "md/".$next."_".$category.$typeRef;

$content = "<a href='".$imgfl."'><img src='".$imgfl."' ".$wid." /></a>";

$file = $fname;
$fh = fopen($file, 'w');
if(!fwrite($fh,$content)){
	echo "Could not write to new file!";
}
else{
	echo "File written!";
}


?>