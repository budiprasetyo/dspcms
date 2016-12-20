<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
session_start();
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

// Hapus modul
if ($reqGet->getVarAlpha('module',5) == 'modul' AND $reqGet->getVarAlpha('act',5) == 'hapus'){
  mysql_query("DELETE FROM modul WHERE id_modul='".$reqGet->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}

// Input modul
elseif ($reqGet->getVarAlpha('module',5) == 'modul' AND $reqGet->getVarAlpha('act',5) =='input'){
  // Cari angka urutan terakhir
  $u=mysql_query("SELECT urutan FROM modul ORDER by urutan DESC");
  $d=mysql_fetch_array($u);
  $urutan=$d[urutan]+1;
  
  // Input data modul
  mysql_query("INSERT INTO modul(nama_modul,
                                 link,
                                 publish,
                                 aktif,
                                 status,
                                 urutan) 
	                       VALUES('".$reqPost->getVarString('nama_modul')."',
                                '".$reqPost->getVar('link')."',
                                '".$reqPost->getVarAlpha('publish',1)."',
                                '".$reqPost->getVarAlpha('aktif',1)."',
                                '".$reqPost->getVarAlpha('status')."',
                                '".$urutan."')");
  header('location:../../media.php?module='.$module);
}

// Update modul
elseif ($module=='modul' AND $act=='update'){
  mysql_query("UPDATE modul SET nama_modul = '".$reqPost->getVarString('nama_modul')."',
                                link       = '".$reqPost->getVar('link')."',
                                publish    = '".$reqPost->getVarAlpha('publish',1)."',
                                aktif      = '".$reqPost->getVarAlpha('aktif',1)."',
                                status     = '".$reqPost->getVarAlpha('status')."',
                                urutan     = '".$reqPost->getVarInt('urutan')."'  
                          WHERE id_modul   = '".$reqPost->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}
}
?>
