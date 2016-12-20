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

// Hapus hubungi
if ($reqGet->getVarAlpha('module',7) == 'hubungi' AND $reqGet->getVarAlpha('act',5) == 'hapus'){
  mysql_query("DELETE FROM hubungi WHERE id_hubungi='".$reqGet->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}
}
?>
