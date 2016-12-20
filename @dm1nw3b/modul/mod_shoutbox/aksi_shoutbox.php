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

// Hapus shoutbox
if ($reqGet->getVarAlpha('module',8) == 'shoutbox' AND $reqGet->getVarAlpha('act',5) == 'hapus'){
  mysql_query("DELETE FROM shoutbox WHERE id_shoutbox='".$reqGet->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}

// Update shoutbox
elseif ($reqGet->getVarAlpha('module',8) == 'shoutbox' AND $reqGet->getVarAlpha('act',6) == 'update'){
  mysql_query("UPDATE shoutbox SET nama          = '".$reqPost->getVarAlphaOrNum('nama',100)."',
                                   website       = '".$reqPost->getVarString('website',50)."', 
                                   pesan         = '".$_POST['pesan']."', 
                                   aktif         = '".$reqPost->getVarAlpha('aktif',1)."'
                             WHERE id_shoutbox   = '".$reqPost->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}
}
?>
