<?php
session_start();
error_reporting(0);
include "timeout.php";

if($_SESSION[login]==1){
	if(!cek_login()){
		$_SESSION[login] = 0;
	}
}
if($_SESSION[login]==0){
  header('location:logout.php');
}
else{
if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
}
else{
?>
<html>
<head>
<title></title>
<script language="javascript" type="text/javascript">
    tinyMCE_GZ.init({
    plugins : 'style,layer,table,save,advhr,advimage, ...',
		themes  : 'simple,advanced',
		languages : 'en',
		disk_cache : true,
		debug : false
});
</script>
<script language="javascript" type="text/javascript"
src="../tinymcpuk/tiny_mce_src.js"></script>
<script type="text/javascript">
tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		plugins : "table,youtube,advhr,advimage,advlink,emotions,flash,searchreplace,paste,directionality,noneditable,contextmenu",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,preview,zoom,separator,forecolor,backcolor,liststyle",
		theme_advanced_buttons2_add_before: "cut,copy,paste,separator,search,replace,separator",
		theme_advanced_buttons3_add_before : "tablecontrols,separator,youtube,separator",
		theme_advanced_buttons3_add : "emotions,flash",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		extended_valid_elements : "hr[class|width|size|noshade]",
		file_browser_callback : "fileBrowserCallBack",
		paste_use_dialog : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
		apply_source_formatting : true
});

	function fileBrowserCallBack(field_name, url, type, win) {
		var connector = "../../filemanager/browser.html?Connector=connectors/php/connector.php";
		var enableAutoTypeSelection = true;
		
		var cType;
		tinymcpuk_field = field_name;
		tinymcpuk = win;
		
		switch (type) {
			case "image":
				cType = "Image";
				break;
			case "flash":
				cType = "Flash";
				break;
			case "file":
				cType = "File";
				break;
		}
		
		if (enableAutoTypeSelection && cType) {
			connector += "&Type=" + cType;
		}
		
		window.open(connector, "tinymcpuk", "modal,width=600,height=400");
	}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

<link href="../jQueryUI/development-bundle/themes/eggplant/jquery.ui.all.css" rel="stylesheet"type="text/css" />
<script type="text/javascript" src="../jQueryUI/development-bundle/jquery-1.7.1.js"></script>
<script type="text/javascript" src="../jQueryUI/development-bundle/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../jQueryUI/development-bundle/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../jQueryUI/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-id.js"></script>
<script type="text/javascript" src="../jQueryUI/development-bundle/ui/jquery.ui.dialog.js"></script>
<script type="text/javascript" src="../jQueryUI/jquery.validate.js"></script>
</head>
<body>

<?php 
	// Require classes
	require_once("../config/class_utility.php");
	// Instantiate class
	$utility = new class_utility();
?>
<div id="header">
	<div id="menu">
      <ul>
        <li><a href=?module=home>&#187; Home</a></li>
        <?php include "menu.php"; ?>
        <li><a href=logout.php>&#187; Logout</a></li>
      </ul>
	    <p>&nbsp;</p>
 	</div>

  <div id="content">
		<?php include "content.php"; ?>
  </div>
  
		<div id="footer">
			Copyleft 
			<span style="-webkit-transform: rotate(180deg); -moz-transform: rotate(180deg); -o-transform: rotate(180deg); -khtml-transform: rotate(180deg); -ms-transform: rotate(180deg); transform: rotate(180deg); display: inline-block;">
			&copy;
			</span> 2012 by Direktorat Sistem Perbendaharaan. All wrongs reserved.
		</div>
</div>
</body>
</html>
<?php
}
}
?>
