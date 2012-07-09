<?
	function stripCat($fname){
	$part = substr($fname, 0, 6);
	$category = str_replace($part, "", $fname);
	return $category;
}
include('settings.php');
$file = $_REQUEST['file'];
if(getMD($file)==true){
	$MDchecked="checked";
}
else{
	$MDchecked="";
}
$myFile = "md/".$file;
$fh = fopen($myFile, 'r');
$theData = fread($fh, filesize($myFile));
$theData = str_replace("zzMARKDOWNzz","",$theData);
if(strpos($theData,"<title>")===false){
	$titletext = "";
}
else{
	$t1 = substr($theData,strpos($theData,"<title>")+7);
	$titletext = substr($t1,0,strpos($t1,"</title>"));
	$theData = str_replace("<title>".$titletext."</title>","",$theData);	
}

fclose($fh);
$category = stripCat($file);
?>
<input type="text" id="edittitle<?=$file?>" value="<?=$titletext?>"></input>
<textarea class="posttext" id="edittext<?=$file?>"><?=$theData?></textarea><button onclick="saveEdit('<?=$file?>')">save</button>
<?

if ($handle = opendir('md')) {
	echo "<select id='editpostcatselect'>";
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && substr($file,0,3)=="cat") {
				$cat = str_replace("cat_", "", $file);
				$catDisp = str_replace("ZZZspZZZ", " ", $cat);
				$categoryChk = str_replace("_gal", "", $category);
				if($cat == $categoryChk){
					echo "<option selected value='".$cat."'>".$catDisp."</option>";
				}
				else{
					echo "<option value='".$cat."'>".$catDisp."</option>";
				}
	        }
	    }
	    closedir($handle);
	echo "</select>";
	echo "<br /><input type='checkbox' id='markdowncheck' value='markdown' ".$MDchecked."/> use markdown<br />";			

}
?>
<script type="text/javascript">
	$('textarea').tabOverride(true);
</script>