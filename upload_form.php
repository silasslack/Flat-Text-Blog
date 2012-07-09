<?
$prefix =  substr($_REQUEST['file'],0,5);
?>
<form method="post" action="upload.php" enctype="multipart/form-data">
	<input type="hidden" name="galleryprefix" value="<?=$prefix?>" />
	<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
  	<input name="filesToUpload[]" id="filesToUpload" type="file" multiple=""/>
  	<input type="submit" value="Upload File" />
</form>