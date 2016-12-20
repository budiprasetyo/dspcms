<?php
session_start();
//Deteksi hanya bisa diinclude, tidak bisa langsung dibuka (direct access) 
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}

if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";
include "../../../config/library.php";
include "../../../config/fungsi_thumb.php";
// include security class
include "../../../config/class_security.php";
// instantiate request get class
$reqGet = new requestGet();
// instantiate request post class
$reqPost = new requestPost();
// instantiate request session class
$reqSession = new requestSession();

$module=$_GET['module'];
$act=$_GET['act'];

// Hapus sekilas info
if ($reqGet->getVarAlpha('module',11) == 'sekilasinfo' AND $reqGet->getVarAlpha('act',5) == 'hapus'){
  
  $data = mysql_fetch_array(mysql_query("SELECT gambar FROM sekilasinfo WHERE id_sekilas='".$reqGet->getVarInt('id')."'"));
  if ($data['gambar']!=''){
  mysql_query("DELETE FROM sekilasinfo WHERE id_sekilas='".$reqGet->getVarInt('id')."'");
     unlink("../../../foto_info/$_GET[namafile]");   
     unlink("../../../foto_info/kecil_$_GET[namafile]");   
  }
  else{
  mysql_query("DELETE FROM sekilasinfo WHERE id_sekilas='".$reqGet->getVarInt('id')."'");  
  }
  
  header('location:../../media.php?module='.$module);
}

// Input sekilas info
elseif ($reqGet->getVarAlpha('module',11) =='sekilasinfo' AND $reqGet->getVarAlpha('act',5) =='input'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $tipe_file   = $_FILES['fupload']['type'];
  $nama_file   = $_FILES['fupload']['name'];   

  $mime = array(
   'image/png' => '.png',
   'image/x-png' => '.png',
   'image/gif' => '.gif',
   'image/jpeg' => '.jpg',
   'image/pjpeg' => '.jpg');
   
   $ekstensi = substr($nama_file, strrpos($nama_file, '.'));
  
  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
    if (!array_keys($mime, $ekstensi)){
      echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe JPG/GIF/PNG. Patch by eidelweiss');
      window.location=('../../media.php?module=sekilasinfo')</script>";
    }
    else{
    UploadInfo($nama_file);
    mysql_query("INSERT INTO sekilasinfo(info,
                                    tgl_posting,
                                    gambar) 
                            VALUES('".$reqPost->getVarString('info')."',
                                   '$tgl_sekarang',
                                   '$nama_file')");
  header('location:../../media.php?module='.$module);
  }
  }
  else{
    mysql_query("INSERT INTO sekilasinfo(info,
                                    tgl_posting) 
                            VALUES('".$reqPost->getVarString('info')."',
                                   '$tgl_sekarang')");
  header('location:../../media.php?module='.$module);
  }
}

// Update sekilas info
elseif ($reqGet->getVarAlpha('module',11) =='sekilasinfo' AND $reqGet->getVarAlpha('act',6) =='update'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $tipe_file   = $_FILES['fupload']['type'];
  $nama_file   = $_FILES['fupload']['name'];

	  // Apabila gambar tidak diganti
	  if (empty($lokasi_file)){
		mysql_query("UPDATE sekilasinfo SET info = '".$reqPost->getVar('info')."'
								 WHERE id_sekilas = '".$reqPost->getVarInt('id')."'");
	  header('location:../../media.php?module='.$module);
	  }
	  else{
		   if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
			echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
				window.location=('../../media.php?module=sekilasinfo')</script>";
			}
			else{
			UploadInfo($nama_file);
			mysql_query("UPDATE sekilasinfo SET info = '".$reqPost->getVar('info')."',
										   gambar    = '".$nama_file."'   
									 WHERE id_sekilas= '".$reqPost->getVarInt('id')."'");
		  header('location:../../media.php?module='.$module);
	  }
  }
}
}
?>
