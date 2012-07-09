<?
$file = $_REQUEST['file'];
$dirT='img/thumbs/';
$dirF='img/fullsize/';
if(!unlink($dirT.$file)){
	die('failed');
}
else{
	if(!unlink($dirF.$file)){
		die('failed');
	}
}
echo "deleted";
?>