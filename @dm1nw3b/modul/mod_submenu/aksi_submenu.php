<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";
include "../../../config/fungsi_thumb.php";
include "../../../config/fungsi_seo.php";
// include security class
include "../../../config/class_security.php";
// instantiate request get
$reqGet = new requestGet();
// instantiate request post
$reqPost = new requestPost();
// instantiate request session
$reqSession = new requestSession();

$module=$_GET['module'];
$act=$_GET['act'];

// Hapus sub menu
if ($reqGet->getVarAlpha('module',7) == 'submenu' AND $reqGet->getVarAlpha('act',5) == 'hapus'){
  mysql_query("DELETE FROM submenu WHERE id_sub='".$reqGet->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}

// Input sub menu
elseif ($reqGet->getVarAlpha('module',7) == 'submenu' AND $reqGet->getVarAlpha('act',5) == 'input'){
    mysql_query("INSERT INTO submenu(nama_sub,
                                    id_main,
                                    link_sub) 
                            VALUES('".$reqPost->getVarString('nama_sub')."',
                                   '".$reqPost->getVarString('menu_utama')."',
                                   '".$reqPost->getVarString('link_sub')."')");
  header('location:../../media.php?module='.$module);
}

// Update sub menu
elseif ($reqGet->getVarAlpha('module',7) == 'submenu' AND $reqGet->getVarAlpha('act',6) == 'update'){
    mysql_query("UPDATE submenu SET nama_sub  = '".$reqPost->getVarString('nama_sub')."',
                                   id_main = '".$reqPost->getVarString('menu_utama')."',
                                   link_sub  = '".$reqPost->getVarString('link_sub')."'  
                             WHERE id_sub   = '".$reqPost->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}
}
?>
