<?
include('simpleImage.php');
$imageFile = $_REQUEST['img'];
$image = new SimpleImage();
$image->load($imageFile);
$hei = $image->getHeight($imageFile);
$wid = $image->getWidth($imageFile);
if($hei>$wid){
	echo "portrait";
}
else{
	echo "landscape";
}
?>