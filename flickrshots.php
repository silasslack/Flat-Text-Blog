<?
//include('settings.php');
//$cat=$_REQUEST['category'];
$cat=$category;
function getThumbs($thumbSize,$cat){
	include_once("phpFlickr/phpFlickr.php");
	$f = new phpFlickr("e704cd9db046ac8956a1b930b1056d9f");
	$setid = (string)$cat;
	//$setid = '72157629316923205';
	
	$photos = $f->photosets_getPhotos($setid);
	if(!empty($photos)){
		$num=0;
		echo "<table border='0' width='100%' cellspacing='0' cellpadding='0'><tr>";
		foreach($photos['photoset']['photo'] as $photo){
			if ($num % 3 == 0) {
				echo "</tr><tr>";
			}
			$id=$photo['id'];
			$photoURL =  $f->buildPhotoURL($photo,"small");
			$photolink = $f->buildPhotoURL($photo,"large");
			$phototag = "<a ><img class='thumb' id='TN".$num."' onclick='getImage(\"".$photolink."\",\"".$id."\",\"".$setid."\")' src='".$photoURL."' /></a>";
			echo "<td width='75' padding='0' valign='middle' align='center' >".$phototag."</td>";
			$num++;
		}
		if($num<3){
			while($num<4){
				echo "<td width='75' padding='0' valign='middle' align='center' ></td>";
				$num++;
			}
		}
    	echo "</tr></table>";
	}
}
getThumbs($thumbSize,$cat);
?>