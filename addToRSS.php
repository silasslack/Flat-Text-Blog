<?
$postname = $_REQUEST['postname'];
$catname = $_REQUEST['catname'];
$dir = "md/";
$myFile = $dir.$postname;
$fh = fopen($myFile, 'r');
$theData = fread($fh, filesize($myFile));
fclose($fh);
if(strpos($theData,"<title>")===false){
	$titletext='Untitled';
}
else{
	$t1 = substr($theData,strpos($theData,"<title>")+7);
	$titletext = substr($t1,0,strpos($t1,"</title>"));
}
//Build rss item:
//Template:
/*
<item>
<title>China 2011</title>
<description>Pics from China</description>
<link>http://silasslack.net/rssredirect.php?link=gocat=Main|gopost=00031_Main_gal</link>
</item>
*/

$rssstr = "\n<item><title>".$titletext."</title><description>Item on silasslack.net</description><link>http://silasslack.net/rssredirect.php?link=gocat=".$catname."xxzxxgopost=".$postname."</link></item>";

//Read current rss data to edit it:
$rssfile = "feed.rss";
$fh = fopen($rssfile, 'r');
$rssData = fread($fh, filesize($rssfile));
fclose($fh);
if(strstr($rssData,$rssstr)){
	die("Item already exists in feed");
}
$rssData = str_replace("</channel></rss>",$rssstr,$rssData)."\n</channel></rss>";
$fh = fopen($rssfile, 'w');
if(!fwrite($fh,$rssData)){
	echo "Failed to add to feed";
}
else{
	echo "Added to feed";
}
?>