<?
include('settings.php');
include_once("phpFlickr/phpFlickr.php");
$imageFile = $_REQUEST['img'];
$picid = $_REQUEST['id'];

$f = new phpFlickr("e704cd9db046ac8956a1b930b1056d9f");
$photo = $f->photos_getInfo($picid);
echo "<b>".$photo['photo']['title']."</b> ".$photo['photo']['description'];
echo "<br />";
?>