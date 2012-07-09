<?
$links = "/?".str_replace("xxzxx","&",$_REQUEST['link']);
header("Location: ".$links)
?>