<?
include('settings.php');
if(isset($_REQUEST['catdel'])){
	//$cat = str_replace(" ","~",$_REQUEST['catdel']);
	$cat = $_REQUEST['catdel'];
}
$file = str_replace(" ","ZZZspZZZ",$_REQUEST['file']);
echo $catnm = str_replace(" ","ZZZspZZZ",$defaultCategory);
if($file=='md/cat_'.$catnm){
	die("you cannot delete the default category!");
}
if(!unlink($file)){
	echo "could not delete!";
}
else{
	echo "deleted!";
}
if(isset($_REQUEST['catdel'])){
	if ($handle = opendir('md/')){
		$filesArray = array();
		while (false !== ($file = readdir($handle))) {
			if (substr($file,0,4) == 'priv') {
				$privFile = "md/".$file;
    	    }
    	}
    	closedir($handle);
	}
	$newPrivFile = str_replace("_".$cat,"",$privFile);
	rename($privFile,$newPrivFile);
}
?>