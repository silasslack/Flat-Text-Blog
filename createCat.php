<?
include('sec.php');
$type = $_REQUEST['type'];
$newcat = str_replace(" ","ZZZspZZZ",$_REQUEST['newcat']);
if($type == "private"){
	addToPrivates($newcat);
}
$fname = "cat_".$newcat;
$newpath = "md/".$fname;
$content = "empty";

$fh = fopen($newpath, 'w');
if(!fwrite($fh,$content)){
	echo "could not create category!";
}
else{
	echo "category created!";
}
?>