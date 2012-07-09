<?
include_once("phpFlickr/phpFlickr.php");
$f = new phpFlickr("e704cd9db046ac8956a1b930b1056d9f");
$setid = $_REQUEST['setid'];
$imgid = $_REQUEST['imgid'];

$photos = $f->photosets_getPhotos($setid);
if(!empty($photos)){
	$num=0;
	foreach($photos['photoset']['photo'] as $photo){
		if($num==0){
			$firstphotolink = $f->buildPhotoURL($photo,"LARGE");
			$firstphotoid = $photo['id'];
		}
		if($nextYes==true){
			$photolink = $f->buildPhotoURL($photo,"LARGE");
			echo $photolink."|".$photo['id'];
			exit;
		}
		else{
			if($photo['id']==$imgid){
				$nextYes=true;
			}
			else{
				$nextYes=false;
			}
		}
		$num++;
	}
	echo $firstphotolink."|".$firstphotoid;
}
?>