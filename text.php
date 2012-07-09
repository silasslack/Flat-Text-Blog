<?
include('simpleImage.php');

if(isset($_REQUEST['ajax'])){
	include('sec.php');
	include('settings.php');
	if(isset($_REQUEST['gocat'])&&$_REQUEST['gocat']!=""){
		$gocat=$_REQUEST['gocat'];
	}
	else{
		$gocat=false;
	}
	if(isset($_REQUEST['gopost'])&&$_REQUEST['gopost']!=""){
		$gopost=$_REQUEST['gopost'];
	}
	else{
		$gopost=false;
	}
}


$loggedin = logincheck();
function stripCat($fname){
	$part = substr($fname, 0, 6);
	$category = str_replace($part, "", $fname);
	return $category;
}
function checkThumbs($picPrefix,$thumbSize,$thumbCropped){
	$dirF='img/fullsize/';
	$dirT='img/thumbs/';
	if ($handle = opendir($dirF)) {
		$filesArray = array();
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && substr($file,0,5)==$picPrefix) {
				if(!file_exists($dirT.$file)){	
					$image = new SimpleImage();
					$image->load($dirF.$file);
					$hei = $image->getHeight($dirF.$file);
					$wid = $image->getWidth($dirF.$file);
					if($thumbCropped){
						$image->crop($thumbSize,$thumbSize);
					}
					else{
						if($hei>$wid){
							$image->resizeToWidth($thumbSize);
						}
						else{
							$image->resizeToHeight($thumbSize);
						}
					}
					
					$image->save($dirT.$file);
				}
			}
    	}
    	closedir($handle);
	}
}
function getThumbs($picPrefix,$thumbSize,$thumbCropped){
	$dirT='img/thumbs/';
	$dirF='img/fullsize/';
	$url = $_SERVER['REQUEST_URI'];
	$loggedin = logincheck();
	if ($handle = opendir($dirT)) {
		$filesArray = array();
		echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
		$num=0;
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && substr($file,0,5)==$picPrefix) {
				if($loggedin=="yes"){
					$oncontext = "oncontextmenu='javascript:deleteImage(\"".$file."\");return false;'";
				}
				else{
					$oncontext="";
				}
				if ($num % 5 == 0) {
					echo "</tr><tr>";
				}
				if(file_exists($dirT.$file)){
					$image = new SimpleImage();
					$image->load($dirF.$file);
					$hei = $image->getHeight($dirF.$file);
					$wid = $image->getWidth($dirF.$file);
					if($hei>$wid){
						$orstr = "height='".$thumbSize."'";
					}
					else{
						$orstr = "width='".$thumbSize."'";
					}
					if($thumbCropped==true){
						$orstr = "height='".$thumbSize."' width='".$thumbSize."'";
					}
				}
				else{
					$orstr = "";
				}
				echo "<td ".$orstr." padding='0' valign='middle' align='center' ><a href='?image=".$dirF.$file."'><img ".$oncontext."  ".$orstr." style='display:block;' class='thumb' id='TN".$num."' src='".$dirT.$file."' alt='gallery thumbnail' /></a><br /></td>";
				//test image url:
				//echo "<td width='".$thumbSize."' height='".$thumbSize."' valign='middle' align='center'><a href='http://www.silasslack.com?image=".$file."'><img ".$oncontext." style='display:block;' class='thumb' id='TN".$num."' src='".$dirT.$file."' alt='gallery thumbnail' /></a></td>";
				$num++;
			}
    	}
    	echo "</tr></table>";
    	closedir($handle);
	}
}
include('markdown.php');
if($gocat==false){
	$category = str_replace(" ","ZZZspZZZ",$_REQUEST['category']);
	$catdisp=$_REQUEST['category'];
}
else{
	$category = str_replace(" ","ZZZspZZZ",$gocat);
	$catdisp=$gocat;
}
$priv = checkIfPrivate($category);

if($loggedin=="yes" || $priv=="no"){
	$show = "yes";
}
else{
	$show = "no";
}
$dir = "md/";


if ($handle = opendir($dir)) {
	$filesArray = array();
	while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != ".." && substr($file,0,3)!="cat" && stripCat(str_replace("_gal","",$file)) == $category && $show == "yes") {
			if($gopost==false){
				$filesArray[] = $file;
			}
			else{
				if($file==$gopost){
					$filesArray[] = $file;
				}
			}
        }
    }
    closedir($handle);
}
if(count($filesArray)<1){
	die("there are no posts in this category");
}



$filesArray = sortFiles($filesArray);
$filesArray = array_reverse($filesArray);
foreach($filesArray as $file){
	if($pos = strpos($file,"_gal")){
		if(($pos+4)==strlen($file)){
			$gallery=true;
		}
		else{
			$gallery=false;
		}
	}
	else{
		$gallery=false;
	}
	$myFile = $dir.$file;
	$fh = fopen($myFile, 'r');
	$theData = fread($fh, filesize($myFile));
	fclose($fh);
	if(strpos($theData,"<title>")===false){
		$titletext='';
	}
	else{
		$t1 = substr($theData,strpos($theData,"<title>")+7);
		$titletext = substr($t1,0,strpos($t1,"</title>"));
	}
	
	if(strpos($theData,"zzMARKDOWNzz")===false){
		if($titletext!=''){
			$titstr = "<h2>".$titletext."</h2>";
		}
		else{
			$titstr = "";
		}
		$my_html = $titstr.str_replace("\n","<br />",$theData);
	}
	else{
		if($titletext!=''){
			$titstr = "##".$titletext."##";
		}
		else{
			$titstr = "";
		}
		$my_html = Markdown($titstr."\n".str_replace("\n","\n",str_replace("zzMARKDOWNzz","",$theData)));
	}
	echo "<div id='".$file."'>";
	if($gallery){
		//if($loggedin=="yes"){
		//	echo "★";
		//}
		
		$picPrefix = substr($file,0,5);
		checkThumbs($picPrefix,$thumbSize,$thumbCropped);
		echo $my_html;
		getThumbs($picPrefix,$thumbSize,$thumbCropped);
		$imageEditLink=" ‧ <a style='cursor:pointer;' class='linktext' onclick='addImages(\"$file\")'>add images</a>";
		$displayFilenameLink=" ‧ <a style='cursor:pointer;' class='linktext' onclick='displayPrefix(\"$file\")'>display image prefix for post</a>";
	}
	else{
		$imageEditLink="";
		$displayFilenameLink="";
		echo $my_html;
	}
	$rssaddlink = "<a style='cursor:pointer;' class='linktext' onclick='addRSS(\"$file\",\"$category\")'>add to rss feed</a> ‧ ";
	if($loggedin=="yes"){
		echo "<br />
		$rssaddlink<a style='cursor:pointer;' class='linktext' onclick='deletePost(\"$file\")'>delete</a> ‧ <a style='cursor:pointer;' class='linktext' onclick='editPost(\"$file\")'>edit</a>".$imageEditLink.$displayFilenameLink."
		</div>";
		echo "Last Updated: ".date('d M Y - H:i',filemtime($myFile))."  [<a style='text-decoration:none;' href='?gocat=".$category."&gopost=".$file."'>direct link</a>]<hr /><br />";
	}
	else{
		echo "<br />
		</div>";
		echo "Last Updated: ".date('d M Y - H:i',filemtime($myFile))."  [<a style='text-decoration:none;' href='?gocat=".$category."&gopost=".$file."'>direct link</a>]<hr /><br />";
	}
}
?>
