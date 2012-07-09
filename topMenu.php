<?
if(isset($_REQUEST['ajax'])){
	include('sec.php');
	include('settings.php');
	$loggedin = logincheck();
	$category = $_REQUEST['category'];
}
$priv = checkIfPrivate($category);
if($priv=="yes"){
	$convtext = "make category public";
}
else{
	$convtext = "make category private";
}

if($loggedin=="yes"){
	?>
	<div id="menu">
		<a style='cursor:pointer;' class="linktext" onclick="startTitCh();">change title</a> ‧ 
		<a style='cursor:pointer;' class="linktext" onclick="startAdd();">new post</a> ‧ 
		<a style='cursor:pointer;' class="linktext" onclick="startNewCat();">new category</a> ‧ 
		<a style='cursor:pointer;' class="linktext" onclick="convCat('<?=$category?>');"><?=$convtext?></a> ‧ 
		<a style='cursor:pointer;' class="linktext" onclick="delCat('<?=$defaultCategory?>');">delete category</a> ‧ 
		<a style='cursor:pointer;' class="linktext" onclick="togMenu();">menu</a> ‧ 
		<a style='cursor:pointer;' class="linktext" onclick="logout('<?=$defaultCategory?>');">logout</a>
	</div>
	<div id="menuoff">
		<a id="" style='cursor:pointer;' class="linktext" onclick="togMenu();">menu</a> ‧ 
		<a id="" style='cursor:pointer;' class="linktext" onclick="logout('<?=$defaultCategory?>');">logout</a>
	</div>
	<?
}
	?>