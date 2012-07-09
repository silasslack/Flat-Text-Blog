<?
include('sec.php');
include('settings.php');
//Check Browsers:
$varset=false;
if(strstr($_SERVER['HTTP_USER_AGENT'],"MSIE")){
	die('<font face="helvetica">This website used to work in Internet Explorer. But I got drunk and ended it all.</font>');
}
if(isset($_REQUEST['gocat'])){
	$gocat = $_REQUEST['gocat'];
	$cate=str_replace(" ","ZZZspZZZ",$gocat);
	$category=str_replace(" ","ZZZspZZZ",$gocat);
	$varset=true;
}
else{
	$gocat = str_replace(" ","ZZZspZZZ",$defaultCategory);
	$cate=str_replace(" ","ZZZspZZZ",$defaultCategory);
	$category=str_replace(" ","ZZZspZZZ",$defaultCategory);
}
if(isset($_REQUEST['gopost'])){
	$gopost = $_REQUEST['gopost'];
	$varset=true;
}
else{
	$gopost = false;
}
if(isset($_REQUEST['image'])){
	$goimage = $_REQUEST['image'];
	$varset=true;
}
else{
	$goimage = false;
}
$loggedin = logincheck();
if(isset($_REQUEST['go'])){
	$go = $_REQUEST['go'].".php";
}
else{
	$go = "text.php";
}
$pageneeded=$go;

$dispcat = str_replace("ZZZspZZZ"," ",$category);

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return str_replace("http://","",$pageURL);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
	<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	<title><?=$title?></title>
	<link rel="stylesheet" href="main.css" />
	<script src="http://code.jquery.com/jquery-1.4.4.js" type="text/javascript"></script>
	<script src="http://cssglobe.com/lab/tooltip/02/jquery.js" type="text/javascript"></script>
	<script src="main.js" type="text/javascript"></script>
	<script type="text/javascript">
		var _gaq = _gaq || [];
  		_gaq.push(['_setAccount', 'UA-31655720-1']);
  		_gaq.push(['_setDomainName', 'silasslack.net']);
  		_gaq.push(['_trackPageview']);

  		(function() {
  		  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  		  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  		  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  		})();
</script>
	</head>
	<!--<body onload="getMenu();getContent('<?=$go?>','<?=$cate?>','<?=$cate?>','<?=$gopost?>');">-->
		<body onload="loadNormal('<?=$dispcat?>');resizeToFitMain();">
		<div id="pw"></div>
		<div id="outer">
			<div id="topbar"><a id="titletext"><?include_once("getTitle.php");?></a>   <img align='right' height='15' id='topload' src=''></img>
				<div id="topmenu">
					<?
					include_once("topMenu.php");
					?>
				</div>
			</div>
			<div id="sidebar">
				<?
				include_once("categoryMenu.php");
				?>
			</div>
			<div class="leftdiv" id="categoryselected"><a id="catsel"></a></div>
			<div class="leftdiv" id="newpost"></div>
			<div class="leftdiv" id="mainbody">
			<?
			if($goimage){
				include_once("displayImage.php");
			}
			else{
				include_once($pageneeded);
			}
			?>
			</div>
		</div>
	</body>
</html>