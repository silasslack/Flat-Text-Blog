<?
if (!function_exists('array_combine'))
{
	function array_combine($arr1,$arr2) {
	   $out = array();
	   foreach ($arr1 as $key1 => $value1) {
	    $out[$value1] = $arr2[$key1];
	   }
	   return $out;
	}
}
function sortFiles($filesArray){
	foreach($filesArray as $thisFile){
		$justNums[] = substr($thisFile,0,5);
	}
	$filesArray = array_combine($justNums,$filesArray);
	sort($filesArray);
	return $filesArray;
}
function convertCategory($cat){
	if(checkIfPrivate($cat)=="yes"){
		$dir = 'md/';
		if ($handle = opendir($dir)){
			$filesArray = array();
			while (false !== ($file = readdir($handle))) {
				if (substr($file,0,4) == 'priv') {
					$search = "_".$cat;
					$filenm = str_replace($search,"",$file);
					rename('md/'.$file,'md/'.$filenm);
					return true;
    		    }
    		}
    		closedir($handle);
		}
	}
	else{
		addToPrivates($cat);
		return true;
	}
}
function getPrviFilename(){
	$dir = 'md/';
	if ($handle = opendir($dir)){
		$filesArray = array();
		while (false !== ($file = readdir($handle))) {
			if (substr($file,0,4) == 'priv') {
				return $file;
    	    }
    	}
    	closedir($handle);
	}
}
function addToPrivates($cat){
	$dir = 'md/';
	if ($handle = opendir($dir)){
		$filesArray = array();
		while (false !== ($file = readdir($handle))) {
			if (substr($file,0,4) == 'priv') {
				$filenm = $file."_".$cat;
				rename('md/'.$file,'md/'.$filenm);
    	    }
    	}
    	closedir($handle);
	}
}
function checkIfPrivate($cat){
	$privFile = getPrviFilename();
	$toCheckFor = "_".$cat;
	if(strstr($privFile,$toCheckFor)){
		return "yes";
	}
	else{
		return "no";
	}
}
function logincheck(){
	$ip = $_SERVER["REMOTE_ADDR"];
	$fh = fopen('sec/sec','r');
	if(!file_exists('sec/sec')){
		die("no");
	}
	$contents = fread($fh,100);
	if($contents == $ip){
		return "yes";
	}
	else{
		return "no";
	}
}




$ip = $_SERVER["REMOTE_ADDR"];

if(isset($_REQUEST['sec'])){
	$pwd = $_REQUEST['sec'];
	if($pwd == '100111103103101114'){
		echo "yes";
	}
	else{
		echo "no";
	}
}
if(isset($_REQUEST['login'])){
	$pw = $_REQUEST['pw'];
	if($pw == '100111103103101114'){
		$fh = fopen('sec/sec','w');
		fwrite($fh, $ip);
		fclose($fh);
		echo "logged in";
	}
	else{
		echo "could not log in";
	}
}
if(isset($_REQUEST['logout'])){
	if(!unlink('sec/sec')){
		echo "could not log out";
	}
	else{
		$fh = fopen('sec/sec','w');
		fclose($fh);
		echo "logged out";
	}
}
if(isset($_REQUEST['check'])){
	$fh = fopen('sec/sec','r');
	$contents = fread($fh, filesize('sec/sec'));
	if($contents == $ip){
		echo "yes";
	}
	else{
		echo "no";
	}
}