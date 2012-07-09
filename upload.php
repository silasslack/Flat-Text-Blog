<?
$target_path = "img/fullsize/";
$prefix = $_REQUEST['galleryprefix'];
//places files into same dir as form resides
foreach ($_FILES["filesToUpload"]["error"] as $key => $error) {
   if ($error == UPLOAD_ERR_OK) {
       //echo $error_codes[$error];
       if(move_uploaded_file($_FILES["filesToUpload"]["tmp_name"][$key],$target_path.$prefix."_".$_FILES["filesToUpload"]["name"][$key])){
       		echo "<font face='helvetica'>File: ".$_FILES["filesToUpload"]["name"][$key]." uploaded</font><br />";
       }
       else{
       		die("Problems with upload");
       	}
   }
}
?>
<p><a href="/#!">back</a></p>