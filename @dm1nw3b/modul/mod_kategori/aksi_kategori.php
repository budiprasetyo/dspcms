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

$module	= $_GET[module];
$act	= $_GET[act];

// Input kategori
if ($reqGet->getVarAlpha('module',8) == 'kategori' AND $reqGet->getVarAlpha('act',5) == 'input'){
  $nama_kategori = $reqPost->getVarString('nama_kategori');
  $kategori_seo = seo_title($nama_kategori);
  mysql_query("INSERT INTO kategori(nama_kategori,kategori_seo) VALUES('".$nama_kategori."','".$kategori_seo."')");
  header('location:../../media.php?module='.$module);
}

// Update kategori
elseif ($reqGet->getVarAlpha('module',8) =='kategori' AND $reqGet->getVarAlpha('act',6) =='update'){
  $nama_kategori = $reqPost->getVarString('nama_kategori');
  $kategori_seo = seo_title($nama_kategori);
  mysql_query("UPDATE kategori SET nama_kategori='".$reqPost->getVarString('nama_kategori')."', kategori_seo='".$kategori_seo."', aktif='".$reqPost->getVarAlpha('aktif',1)."' 
               WHERE id_kategori = '".$reqPost->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}
}
?>
