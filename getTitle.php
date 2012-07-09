<?

if(file_exists("md/title")){
	$f = fopen ("md/title", "r");
	while ($line = fgets($f)){
		$title = $line;
	}
}
else{
	$title = "No Title";
}
if(isset($_REQUEST['ajax'])){
	die("");
	echo $title;
}
else{
	echo "<a style='cursor:pointer;' onclick='location.href=\"/#!\"'>";
	echo $title;
	echo "</a>";
}
?>