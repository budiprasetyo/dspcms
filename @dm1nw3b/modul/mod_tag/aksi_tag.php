<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";
include "../../../config/fungsi_seo.php";
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

// Hapus Tag
if ($reqGet->getVarAlpha('module',3) == 'tag' AND $reqGet->getVarAlpha('act',5) == 'hapus'){
  mysql_query("DELETE FROM tag WHERE id_tag='".$reqGet->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}

// Input tag
elseif ($reqGet->getVarAlpha('module',3) =='tag' AND $reqGet->getVarAlpha('act',5) =='input'){
  $tag_seo = seo_title($reqPost->getVarAlphaOrNum('nama_tag'));
  mysql_query("INSERT INTO tag(nama_tag,tag_seo) VALUES('".$reqPost->getVarAlphaOrNum('nama_tag')."','".$tag_seo."')");
  header('location:../../media.php?module='.$module);
}

// Update tag
elseif ($reqGet->getVarAlpha('module',3) == 'tag' AND $reqGet->getVarAlpha('act',6) == 'update'){
  $tag_seo = seo_title($reqPost->getVarAlphaOrNum('nama_tag'));
  mysql_query("UPDATE tag SET nama_tag = '$_POST[nama_tag]', tag_seo='$tag_seo' WHERE id_tag = '".$reqPost->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}
}
?>
