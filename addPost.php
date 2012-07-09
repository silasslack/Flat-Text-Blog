<input type="text" id="newposttitle"></input>
<textarea class="posttext" id="newposttext"></textarea><button onclick="postText();">save</button>
<?
$category = $_REQUEST['category'];
if ($handle = opendir('md')) {
	echo "<select id='newpostcatselect'>";
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
	echo "<br /><input type='checkbox' id='gallerycheck' value='gallery' /> gallery page";
	echo "<br /><input type='checkbox' id='markdowncheck' value='markdown' checked/> use markdown<br />";
}
?>
<script type="text/javascript">
	$('textarea').tabOverride(true);
</script>