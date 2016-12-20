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

// Hapus komentar
if ($reqGet->getVarAlpha('module',8) == 'komentar' AND $reqGet->getVarAlpha('act',5) == 'hapus'){
  mysql_query("DELETE FROM komentar WHERE id_komentar='".$reqGet->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}

// Update komentar
elseif ($reqGet->getVarAlpha('module',8) == 'komentar' AND $reqGet->getVarAlpha('act',6) == 'update'){
  mysql_query("UPDATE komentar SET nama_komentar = '".$reqPost->getVarString('nama_komentar')."',
                                   url           = '".$reqPost->getVarString('url')."', 
                                   isi_komentar  = '".$reqPost->getVarString('isi_komentar')."', 
                                   aktif         = '".$reqPost->getVarAlpha('aktif',1)."'
                             WHERE id_komentar   = '".$reqPost->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}
}
?>
