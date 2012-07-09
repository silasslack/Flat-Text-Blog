<?
include('simpleImage.php');
$imageFile = $goimage;
include_once("nextPic.php");
$image = new SimpleImage();
$image->load($imageFile);
$hei = $image->getHeight($imageFile);
$wid = $image->getWidth($imageFile);
if($hei>$wid){
	$orient = "portrait";
}
else{
	$orient = "landscape";
}
if($orient=="portrait"){
	$imstr = "<td valign='middle' align='center'><a ><img onclick='nextPic(\"".$imageFile."\")' style='cursor:pointer;' id='mainimage' height='780' src='".$imageFile."' alt='gallery thumbnail' /></a>";
}
if($orient=="landscape"){
	$imstr = "<td valign='middle' align='center'><a ><img onclick='nextPic(\"".$imageFile."\")' style='cursor:pointer;' id='mainimage' width='780' src='".$imageFile."' alt='gallery thumbnail' /></a>";
}
echo $imstr."<br />";
include_once("getExif.php");
?>