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
// instantiate request get class
$reqGet = new requestGet();
// instantiate request post class
$reqPost = new requestPost();
// instantiate request session class
$reqSession = new requestSession();

$module=$_GET[module];
$act=$_GET[act];

// Hapus Klasifikasi
if ($reqGet->getVarAlpha('module',11) == 'klasifikasi' AND $reqGet->getVarAlpha('act',5) == 'hapus'){
  mysql_query("DELETE FROM klasifikasiperaturan WHERE idklasifikasi='".$reqGet->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}

// Input klasifikasi
elseif ($reqGet->getVarAlpha('module',11) == 'klasifikasi' AND $reqGet->getVarAlpha('act',5) =='input'){
  mysql_query("INSERT INTO klasifikasiperaturan(klasifikasi) VALUES('".$reqPost->getVarAlphaOrNum('klasifikasi')."')");
  header('location:../../media.php?module='.$module);
}

// Update klasifikasi
elseif ($reqGet->getVarAlpha('module',11) == 'klasifikasi' AND $reqGet->getVarAlpha('act',6) == 'update'){
  mysql_query("UPDATE klasifikasiperaturan SET klasifikasi = '".$reqPost->getVarAlphaOrNum('klasifikasi')."' WHERE idklasifikasi = '".$reqPost->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}
}
?>
