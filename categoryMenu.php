<?
if(isset($_REQUEST['ajax'])){
	include('sec.php');
}
if ($handle = opendir('md')) {
	while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != ".." && substr($file,0,3)=="cat") {
			$file = str_replace("cat_", "", $file);
			if(logincheck()=="yes" || checkIfPrivate($file)=="no"){
				$filesArray[] = $file;
			}
        }
    }
    closedir($handle);
}
sort($filesArray);


foreach($filesArray as $file){
	$displayTxt = str_replace("ZZZspZZZ"," ",$file);
	echo "<p style='margin-left:7px;cursor:pointer;' class='linktext'><a style='text-decoration:none;' onclick='location.href=\"?gocat=".$displayTxt."\"'>‧".$displayTxt."</a></p>";
}

include_once("phpFlickr/phpFlickr.php");
//Get list of acceptable cats into an array:


if(file_exists("md/flickr_cats")){
	$f = fopen ("md/flickr_cats", "r");
	while ($line = fgets($f)) {
		$fcats[]=trim($line);
	}
	fclose ($f);
}


$f = new phpFlickr("e704cd9db046ac8956a1b930b1056d9f");
$sets = $f->photosets_getList('40787699@N03');
if(!empty($sets)){
	foreach($sets['photoset'] as $set){
		if(in_array($set['title'],$fcats)){
			echo "<p style='margin-left:7px;cursor:pointer;' class='linktext'><a style='text-decoration:none;' onclick='location.href=\"?go=flickrshots&gocat=".$set['id']."\"'>‧".$set['title']."</a></p>";
		}
	}
}


?>