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

// Update identitas
if ($reqGet->getVarAlpha('module',9) == 'identitas' AND $reqGet->getVarAlpha('act',6) == 'update'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];

  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
    UploadFavicon($nama_file);
    mysql_query("UPDATE identitas SET nama_website   = '".$reqPost->getVarString('nama_website')."',
                                      meta_deskripsi = '".$reqPost->getVarString('meta_deskripsi')."',
                                      meta_keyword   = '".$reqPost->getVarString('meta_keyword')."',
                                      favicon        = '$nama_file'    
                                WHERE id_identitas   = '".$reqPost->getVarInt('id')."'");
  }
  else{
    mysql_query("UPDATE identitas SET nama_website   = '".$reqPost->getVarString('nama_website')."',
                                      meta_deskripsi = '".$reqPost->getVarString('meta_deskripsi')."',
                                      meta_keyword   = '".$reqPost->getVarString('meta_keyword')."'
                                WHERE id_identitas   = '".$reqPost->getVarInt('id')."'");
  }
  header('location:../../media.php?module='.$module);
}
}
?>
