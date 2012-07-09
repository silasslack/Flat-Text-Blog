<?
include('settings.php');
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
if(!isset($_REQUEST['newcontent'])){
	if(isset($_REQUEST['pagetype'])){
		if($_REQUEST['pagetype']=="gallery"){
			$typeRef = "_gal";
		}
		else{
			$typeRef = "";
		}
	}
	else{
		$typeRef = "";
	}
	if($_REQUEST['markdown']=="true"){
		$md=true;
	}
	else{
		$md=false;
	}
	$content = $_REQUEST['content']." ";
	$titletext = "<title>".$_REQUEST['title']."</title>";
	$category = $_REQUEST['category'];
	$next = getNext();
	$fname = "md/".$next."_".$category.$typeRef;
}
else{
	$file = $_REQUEST['file'];
	
	if($pos = strpos($file,"_gal")){
		if(($pos+4)==strlen($file)){
			$typeRef = "_gal";
		}
		else{
			$typeRef = "";
		}
	}
	else{
		$typeRef = "";
	}
	if($_REQUEST['markdown']=="true"){
		$md=true;
	}
	else{
		$md=false;
	}
	$fnum = substr($file, 0, 6);
	$category = $_REQUEST['category'];
	$oldfname = "md/".$file;
	unlink($oldfname);
	$fname = "md/".$fnum.$category.$typeRef;
	$content = $_REQUEST['newcontent']." ";
	$titletext = "<title>".$_REQUEST['newtitle']."</title>";
}
if($md==true){
	$content="zzMARKDOWNzz".$titletext.$content;
}
else{
	$content=$titletext.str_replace("zzMARKDOWNzz","",$content);
}
$file = $fname;
$fh = fopen($file, 'w');
if(!fwrite($fh,$content)){
	echo "Could not write to new file!";
}
else{
	echo "File written!";
}


?>