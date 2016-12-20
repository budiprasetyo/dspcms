<?php
  session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";
// include security class
include "../../../config/class_security.php";
// instantiate request get
$reqGet = new requestGet();
// instantiate request post
$reqPost = new requestPost();
// instantiate request session
$reqSession = new requestSession();

$module=$_GET[module];
$act=$_GET[act];

// Input templates
if ($reqGet->getVarAlpha('module',9) == 'templates' AND $reqGet->getVarAlpha('act',5) == 'input'){
  mysql_query("INSERT INTO templates(judul,pembuat,folder) VALUES('".$reqPost->getVarString('judul')."','".$reqPost->getVarString('pembuat')."','".$reqPost->getVar('folder')."')");
  header('location:../../media.php?module='.$module);
}

// Update templates
elseif ($reqGet->getVarAlpha('module',9) == 'templates' AND $reqGet->getVarAlpha('act',6) == 'update'){
  mysql_query("UPDATE templates SET judul  = '".$reqPost->getVarString('judul')."',
                                    pembuat= '".$reqPost->getVarString('pembuat')."',
                                    folder = '".$reqPost->getVarString('folder')."'
                              WHERE id_templates = '".$reqPost->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}

// Aktifkan templates
elseif ($reqGet->getVarAlpha('module',9) == 'templates' AND $reqGet->getVarAlpha('act',8) =='aktifkan'){
  $query1=mysql_query("UPDATE templates SET aktif='Y' WHERE id_templates='".$reqGet->getVarInt('id')."'");
  $query2=mysql_query("UPDATE templates SET aktif='N' WHERE id_templates!='".$reqGet->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}
}
?>
