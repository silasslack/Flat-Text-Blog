<?
$newtit = $_REQUEST['newtit'];
$file = "md/title";
$f = fopen($file,'w');
if(!fwrite($f,$newtit)){
	echo "Could not update title";
}
else{
	echo "Title updated";
}
?>