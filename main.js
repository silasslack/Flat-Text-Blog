function loadNormal(category){
	$("#catsel").html(category);
}
function getContent(page,category,displayname,gopost){
	var catdisp = displayname.replace(/ZZZspZZZ/g,' ');
	$("#mainbody").html('');
	$.ajax({
	type: "POST",
	data: "category="+category+"&gopost="+gopost+"&ajax="+true,
	dataType: "html",
	url: page,
	success: function (returned) {
		$("#mainbody").html(returned);
	}
	});
	$("#catsel").html(catdisp);
	$("#newpost").html("");
	getMenu();
	getTopMenu(category);
	getTitleText();
}
function deleteImage(file){
	var doyou = confirm("Permanently delete image "+file+"?");
	var category = $("#catsel").html();
	if(doyou==true){
		$.ajax({
			type: "POST",
			data: "file="+file,
			url: "deleteImage.php",
			success: function (returned) {
				if(returned=='failed'){
					alert('Could not delete image');
				}
				getContent("text.php",category,category,"");
			}
		});
	}
}
function getMenu(){
	$.ajax({
	type: "POST",
	data: "ajax=true",
	url: "categoryMenu.php",
	success: function (returned) {
		$("#sidebar").html(returned);
	}
	});
}
function getTopMenu(cat){
	$.ajax({
	type: "POST",
	data: "category="+cat+"&ajax=true",
	url: "topMenu.php",
	success: function (returned) {
		$("#topmenu").html(returned);
	}
	});
	$("#newpost").html("");
}
function getTitleText(){
	$.ajax({
	type: "POST",
	data: "ajax=true",
	url: "getTitle.php",
	success: function (returned) {
		$("#titletext").html("<a style='cursor:pointer;' onclick='location.href=\"/#!\"'>"+returned+"</a>");
	}
	});
}
function getMd5(){
	var pwrd = $("#md5txt").val();
	$.ajax({
	type: "POST",
	data: "md5="+pwrd,
	url: "ptoolsServer.php",
	success: function (returned) {
		$("#md5res").html(returned);
	}
	});
}

function passGen(){
	var leng = $("#lentxt").val();
	$.ajax({
	type: "POST",
	data: "digits="+leng,
	url: "ptoolsServer.php",
	success: function (returned) {
		$("#pasres").html(returned);
	}
	});
}

$(document).ready(function() {
	$("#md5txt").keyup(function(){
	getMd5();
	});
});

function hashIt(){
	$("#md5txt").val($("#pasres").html());
	getMd5();
}

function clearIt(){
	$("#md5txt").val('');
	$("#lentxt").val('');
	$("#pasres").html('');
	$("#md5res").html('');
}
function postText(){
	var gallery = $('#gallerycheck').attr('checked');
	var markdown = $('#markdowncheck').attr('checked');
	var category = $("#newpostcatselect").val();
	var content = $("#newposttext").val();
	var title = $("#newposttitle").val();
	if(gallery){
		var ptype = "gallery";
	}
	else{
		var ptype = "text";
	}
	$.ajax({
	type: "POST",
	data: "content="+content+"&category="+category+"&pagetype="+ptype+"&markdown="+markdown+"&title="+title,
	url: "createFile.php",
	success: function (returned) {
		$("#mdtext").html(returned);
	}
	});
	getContent('text.php',category,category,"");
	$("#newpost").html("");
}
function postImage(imgfl,orientt){
	var category = $("#postimagecatselect").val();
	$.ajax({
	type: "POST",
	data: "category="+category+"&imgfl="+imgfl+"&orientt="+orientt,
	url: "postImage.php",
	success: function (returned) {
		$("#mdtext").html(returned);
	}
	});
	getContent('text.php',category,category,"");
	$("#newpost").html("");
}
function deletePost(file){
	var div = file;
	var cat = $("#catsel").html();
	file = "md/"+file
	$.ajax({
	type: "POST",
	data: "file="+file,
	url: "delPost.php",
	success: function (returned) {
		$("#"+div).html(returned);
	}
	});
	getContent('text.php',cat,cat,"");
	$("#newpost").html("");
}
function editPost(file){
	var div = file;
	$("#"+div).html("yes");
	$.ajax({
	type: "POST",
	data: "file="+file,
	url: "editPost.php",
	success: function (returned) {
		$("#"+div).html(returned);
	}
	});
	$("#newpost").html("");
}
function addImages(file){
	var div = file;
	$("#"+div).html("yes");
	$.ajax({
	type: "POST",
	data: "file="+file,
	url: "upload_form.php",
	success: function (returned) {
		$("#"+div).html(returned);
	}
	});
	$("#newpost").html("");
}
function saveEdit(file){
	var div = file;
	var markdown = $('#markdowncheck').attr('checked');
	var texter = "#edittext"+file;
	var titer = "#edittitle"+file;
	var category = $("#editpostcatselect").val();
	var newcontent = $(texter).val();
	var newtitle = $(titer).val();
	$.ajax({
	type: "POST",
	data: "file="+file+"&newcontent="+newcontent+"&category="+category+"&markdown="+markdown+"&newtitle="+newtitle,
	url: "createFile.php",
	success: function (returned) {
		$("#"+div).html(returned);
	}
	});
	var cat = $("#catsel").html();
	getContent('text.php',cat,cat,"");
	$("#newpost").html("");
}
function startAdd(){
	var cat = $("#catsel").html();
	$.ajax({
	type: "POST",
	data: "category="+cat,
	url: "addPost.php",
	success: function (returned) {
		$("#newpost").html(returned);
	}
	});
}
function startTitCh(){
	$.ajax({
	type: "POST",
	data: "file=",
	url: "titChMenu.php",
	success: function (returned) {
		$("#newpost").html(returned);
	}
	});
}
function createCat(){
	var newcatname = $("#newcattxt").val();
	var newcattype = $("#catprivsel").val();
	$.ajax({
	type: "POST",
	data: "newcat="+newcatname+"&type="+newcattype,
	url: "createCat.php",
	success: function (returned) {
		$("#newpost").html(returned);
	}
	});
	getContent('text.php',newcatname,newcatname,"");
	$("#newpost").html("");
}
function startNewCat(){
	$.ajax({
	type: "POST",
	data: "file=",
	url: "newCatMenu.php",
	success: function (returned) {
		$("#newpost").html(returned);
	}
	});
}
function checkCatForContent(cat){
	$.ajax({
	type: "POST",
	data: "category="+cat,
	url: "checkCatContent.php",
	success: function (returned) {
		return parseInt(returned);
	}
	});
}
function delCat(defaultCategory){
	var cat = $("#catsel").html();
	var toDel = true;
	if(cat == defaultCategory){
		alert("You cannot delete the default category");
		toDel = false;
	}
	var numbercats;
	
	$.ajax({
	type: "POST",
	data: "category="+cat,
	url: "checkCatContent.php",
	success: function (returned) {
		numbercats = parseInt(returned);
		if(numbercats>0){
			if(toDel == true){
				alert("There are "+numbercats+" posts in this category. Please delete or move them and try again.");
			}
			toDel = false;
		}
		var file = "cat_"+cat;
		file = "md/"+file
		if(toDel == true){
			$.ajax({
			type: "POST",
			data: "file="+file+"&catdel="+cat,
			url: "delPost.php",
			success: function (returned) {
				$("#newpost").html(returned);
			}
			});
			getContent('text.php',cat,cat,"");
			getMenu();
			$("#newpost").html("");
		}
	}
	});
}
$(document).keypress(function(event) {
	if(event.which=='122'){
		$("#pw").html("");
	}
	else{
		$("#pw").html($("#pw").html()+event.which);
		checkP($("#pw").html());
	}
});
function checkP(sec){
	var cat = $("#catsel").html();
	var pw = $("#pw").html();
	$.ajax({
	type: "POST",
	data: "sec="+sec,
	url: "sec.php",
	success: function (returned) {
		if(returned=="yes"){
			$.ajax({
			type: "POST",
			data: "login=yes&pw="+pw,
			url: "sec.php",
			success: function (returned) {
				//alert(returned);
				getContent('text.php',cat,cat,"");
				getTopMenu();
			}
			});
		}
	}
	});
}
function logout(defcat){
	var cat = $("#catsel").html();
	$.ajax({
	type: "POST",
	data: "logout=yes",
	url: "sec.php",
	success: function (returned) {
		getContent('text.php',cat,cat,"");
		//setTimeout("getContent('text.php','"+cat+"')",2000);
	}
	});
}
function convCat(cat){
	$.ajax({
	type: "POST",
	data: "category="+cat,
	url: "convertCat.php",
	success: function (returned) {
		
	}
	});
	getContent('text.php',cat,cat,"");
}
function chTitle(){
	var cat = $("#catsel").html();
	var newtit = $("#titchtxt").val();
	$.ajax({
	type: "POST",
	data: "newtit="+newtit,
	url: "changeTitle.php",
	success: function (returned) {
		getContent('text.php',cat,cat,"");
	}
	});
}
function togMenu(){
	$("#menu").toggle();
	$("#menuoff").toggle();
	$("#menuofflogout").toggle();
}
function getImgOrientation(imagefile){
	$.ajax({
	type: "POST",
	data: "img="+imagefile,
	url: "getOrientation.php",
	success: function (returned) {
		window.mainOrient = returned;
	}
	});
}
function addRSS(file,category){
	$.ajax({
	type: "POST",
	data: "postname="+file+"&catname="+category,
	url: "addToRSS.php",
	success: function (returned) {
		alert(returned);
	}
	});
}
function getImage(imagefile,flickrid,setid){
	var imstr = "<td valign='middle' align='center'><a ><img id='bigimage' onclick='nextFlickrPic(\""+flickrid+"\",\""+setid+"\")' style='cursor:pointer;' id='mainimage' height='70%' src='"+imagefile+"' /></a>"
	var exifblock = "<div align='left' id='exif'></div>";
	var captionblock = "<div align='left' id='caption'></div>";
	//$("#mainbody").hide();
	$("#mainbody").html(imstr+captionblock+exifblock);
	//$("#mainbody").fadeIn(1000);
	getExif(imagefile,flickrid,"");
	getCaption(imagefile,flickrid);
	if($('#bigimage').width()>10){
		setTimeout('resizeToFit()',1000);
	}
	else{
		if($('#bigimage').width()>10){
			setTimeout('resizeToFit()',1000);
		}
		else{
			setTimeout('resizeToFit()',2000);
		}
	}
}
function resizeToFit(){
	var winheight = window.innerHeight-75;
	var wid=$('#bigimage').width();
	var hei=$('#bigimage').height();
	if(wid>hei){
		var w = 740;
		var h = Math.ceil(hei / wid * 740);
	}
	else{
		var h = winheight;	
		var w = Math.ceil(wid / hei * winheight);
	}
	$('#bigimage').animate({width: w,height: h}, 'slow');
}
function resizeToFitMain(){
	var winheight = window.innerHeight-75;
	var wid=$('#mainimage').width();
	var hei=$('#mainimage').height();
	if(wid>hei){
		var w = 740;
		var h = Math.ceil(hei / wid * 740);
	}
	else{
		var h = winheight;	
		var w = Math.ceil(wid / hei * winheight);
	}
	$('#mainimage').animate({width: w,height: h}, 'slow');
}
function showImage(theID,imagefile){
	if(theID==""){
		timeout=1500;
	}
	else{
		timeout=1500;
	}
	$("#topload").attr('src',"img/ajax-loader.gif");
	//$("#"+theID).fadeOut(1000);
	var orient = getImgOrientation(imagefile);
	window.mainOrient = orient;
	window.mainImage = imagefile;
	setTimeout('dispImage()',timeout);
}
function dispImage(){
	//alert(window.mainOrient);
	var orient = window.mainOrient;
	var img = window.mainImage;
	var extfile=false;
	if(orient=="portrait"){
		var winheight = window.innerHeight-75;
		var imstr = "<td valign='middle' align='center'><a ><img onclick='nextPic(\""+img+"\")' style='cursor:pointer;' id='mainimage' height='"+winheight.toString()+"' src='"+img+"' alt='gallery thumbnail' /></a>"
	}
	if(orient=="landscape"){
		var imstr = "<td valign='middle' align='center'><a ><img onclick='nextPic(\""+img+"\")' style='cursor:pointer;' id='mainimage' width='780' src='"+img+"' alt='gallery thumbnail' /></a>"
	}
	if((orient!="landscape")&&(orient!="portrait")){
		var imstr = "<td valign='middle' align='center'><a ><img onclick='nextPic(\""+img+"\")' style='cursor:pointer;' id='mainimage' height='70%' src='"+img+"' alt='gallery thumbnail' /></a>"
		extfile=true;
	}
	var exifblock = "<div align='left' id='exif'></div>";
	var loader = "<div align='left'><img width='20' src='img/blank.jpg' id='loader'/></div>";
	//$("#mainbody").hide();
	$("#mainbody").html(imstr+loader+exifblock);
	//$("#mainbody").fadeIn(1000);
	if(extfile==false){
		getExif(img,"none",$('#catsel').html());
	}
	$("#topload").attr('src',"img/blank.jpg");
}
function displayPrefix(file){
	alert(file.substring(0,5));
}
function getExif(imagefile,id,category){
	$.ajax({
		type: "POST",
		data: "img="+imagefile+"&id="+id+"&category="+category+"&ajax=true",
		url: "getExif.php",
		success: function (returned) {
			$("#exif").html(returned);
		}
	});
}
function getCaption(imagefile,id){
	$.ajax({
		type: "POST",
		data: "img="+imagefile+"&id="+id,
		url: "getCaption.php",
		success: function (returned) {
			$("#caption").html(returned);
		}
	});
}
function nextFlickrPic(imgid,setid){
	//$("#mainimage").fadeOut(1000);
	//$("#exif").fadeOut(1000);
	$.ajax({
		type: "POST",
		data: "imgid="+imgid+"&setid="+setid,
		url: "nextFlickrPic.php",
		success: function (returned) {
			var rets = returned.split("|");
			getImage(rets[0],rets[1],setid);
		}
	});
}
function nextPic(img){
	$("#mainimage").fadeOut(1000);
	$("#exif").fadeOut(1000);
	$.ajax({
		type: "POST",
		data: "currpic="+img+"&ajax=true",
		url: "nextPic.php",
		success: function (returned) {
			showImage("loader",returned);
			window.history.pushState('Object', 'Title', '?image='+returned);
		}
	});
}
function showSubMenu(ID){
	ID = '#'+ID;
	$(ID).show();
}
function hideSubMenu(ID){
	setTimeout(function() {$(ID).hide();},500);
}