<?
include('sec.php');
$cat = $_REQUEST['category'];
if(!convertCategory($cat)){
	echo "could not convert";
}
else{
	echo "converted";
}
?>