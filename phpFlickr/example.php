<?php
include_once("phpFlickr.php");
$f = new phpFlickr("e704cd9db046ac8956a1b930b1056d9f");
$setid = '72157629316923205';

$photos = $f->photosets_getPhotos($setid);
if(!empty($photos)){
	foreach($photos['photoset']['photo'] as $photo){
		$photoURL =  $f->buildPhotoURL($photo,"small");
		$photolink = $f->buildPhotoURL($photo,"LARGE");
		$phototag = "<a href='".$photolink."'><img src='".$photoURL."' /></a>";
		echo $phototag."<br />";
	}
}
?>