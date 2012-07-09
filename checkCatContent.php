<?
function stripCat($fname){
	$part = substr($fname, 0, 6);
	$category = str_replace($part, "", $fname);
	return $category;
}
$category = $_REQUEST['category'];
$dir = 'md';
$num=0;
if ($handle = opendir($dir)) {
	while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != ".." && substr($file,0,3)!="cat" && stripCat($file) == $category) {
			$num++;
        }
    }
    closedir($handle);
}
echo $num;
?>