<?
include_once("phpFlickr/phpFlickr.php");
if(isset($_REQUEST['ajax'])){
	include('simpleImage.php');
	include('sec.php');
	include('settings.php');
	$imageFile = $_REQUEST['img'];
	$picid = $_REQUEST['id'];
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
}


if(logincheck()=="yes"){
	?>
	Post image to Page: <button onclick="postImage('<?=$imageFile?>','<?=$orient?>');">save</button>
	<?
	if(isset($_REQUEST['category'])){
		$category = $_REQUEST['category'];
	}
	else{
		$category = "";
	}
	if ($handle = opendir('md')) {
		echo "<select id='postimagecatselect'>";
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && substr($file,0,3)=="cat") {
					$cat = str_replace("cat_", "", $file);
					$category = str_replace(" ","ZZZspZZZ",$category);
					$catDisplay = str_replace("ZZZspZZZ"," ",$cat);
					$categoryChk = str_replace("_gal", "", $category);
					if($cat == $categoryChk){
						echo "<option selected value='".$cat."'>".$catDisplay."</option>";
					}
					else{
						echo "<option value='".$cat."'>".$catDisplay."</option>";
					}
		        }
		    }
		    closedir($handle);
		echo "</select>";
	}
}







echo "<br />";
if(!strstr($imageFile,"flickr")){
	if($showExif){
		$exif = exif_read_data($imageFile);
		echo "date & time: ".$exif['DateTime']." (GMT)";
		echo "<br />";
		echo "filename: ".$exif['FileName'];
		echo "<br />";
		echo "aperture: ".$exif['COMPUTED']['ApertureFNumber'];
		echo "<br />";
		echo "shutter speed: ".$exif['ExposureTime'];
		echo "<br />";
		echo "ISO: ".$exif['ISOSpeedRatings'];
		echo "<br />";
		echo "camera: ".$exif['Make'].":".$exif['Model'];
		echo "<br />";
		//echo "latitude: ".$exif['GPSLatitude'][0].", ".$exif['GPSLatitude'][1].", ".$exif['GPSLatitude'][2];
		//echo "<br />";
		//echo "longitude: ".$exif['GPSLongitude'][0].", ".$exif['GPSLongitude'][1].", ".$exif['GPSLongitude'][2];
		//echo "<br />";
	}
}
else{
	$f = new phpFlickr("e704cd9db046ac8956a1b930b1056d9f");
	$photo = $f->photos_getExif($picid);
	//print_r($photo['exif']);
	if(!empty($photo)){
		$num=0;
		$docoord=false;
		foreach($photo['exif'] as $exif){
			//print_r($exif);
			if(($exif['tag']=="Model")||($exif['tag']=="Make")||($exif['tag']=="ExposureTime")||($exif['tag']=="ISO")||($exif['tag']=="FocalLength")||($exif['tag']=="Lens")||($exif['tag']=="CreateDate")){
				echo trim($exif['tag']).": ".$exif['raw']."<br />";
			}
			if(($exif['tag']=="FNumber")||($exif['tag']=="GPSLatitude")||($exif['tag']=="GPSLongitude")){
				echo trim($exif['tag']).": ".$exif['clean']."<br />";
			}
			if(($exif['tag']=="GPSLatitude")){
				$coord1 = $exif['raw'];
				if(strstr($exif['clean'],"S")!=false){
					$coord1="-".$coord1;
				}
				$docoord=true;
			}
			if(($exif['tag']=="GPSLongitude")){
				$coord2 = $exif['raw'];
				if(strstr($exif['clean'],"W")!=false){
					$coord2="-".$coord2;
				}
			}
			$num++;
		}
		$coord1 = str_replace(" deg ",".",$coord1);
		$coord1 = str_replace('"','',$coord1);
		$coord1 = str_replace("' ","",$coord1);
		$exarr1 = explode(".",$coord1);
		$coord1 = $exarr1[0].".".$exarr1[1].$exarr1[2];
		
		$coord2 = str_replace(" deg ",".",$coord2);
		$coord2 = str_replace('"','',$coord2);
		$coord2 = str_replace("' ","",$coord2);
		$exarr2 = explode(".",$coord2);
		$coord2 = $exarr2[0].".".$exarr2[1].$exarr2[2];
		$link= "http://www.google.co.uk/#hl=en&safe=off&output=search&sclient=psy-ab&q=".$coord1.", ".$coord2."&pbx=1&oq=31.14829%2C+121.284991&aq=f&aqi=&aql=&gs_sm=3&gs_upl=1172l1172l0l1710l1l1l0l0l0l0l74l74l1l1l0&bav=on.2,or.r_gc.r_pw.r_qf.,cf.osb&fp=35891a278aa1f653&biw=1337&bih=698";
		if($docoord==true){
			//This isn't properly finished, and seems not to be accurate. The parsing and/or Google search needs to be sorted out
			//echo "<a href='".$link."'>Show Location</a>";
		}
	}
}

?>