<?php
session_start();
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
// instantiate request get
$reqGet = new requestGet();
// instantiate request post
$reqPost = new requestPost();
// instantiate request session
$reqSession = new requestSession();

$module=$_GET['module'];
$act=$_GET['act'];

// Hapus profil pegawai
if ($reqGet->getVarAlpha('module',13) == 'pegawai' AND $reqGet->getVarAlpha('act',5) == 'hapus'){
  mysql_query("DELETE FROM profilpegawai WHERE id_pegawai='".$reqGet->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}

// Input profil pegawai
elseif ($reqGet->getVarAlpha('module',13) == 'pegawai' AND $reqGet->getVarAlpha('act',5) == 'input'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];
echo $nama_file;
  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
    UploadPegawai($nama_file);
    mysql_query("INSERT INTO profilpegawai(nama,
                                    nip,
                                    jabatan,
									subdit,
									keterangan,
                                    gambar) 
                            VALUES('".$reqPost->getVarString('nama')."',
                                   '".$reqPost->getVarString('nip',18)."',
                                   '".$reqPost->getVarInt('jabatan')."',
								   '".$reqPost->getVarInt('subdit')."',
								   '".$reqPost->getVarAlphaNumSpace('keterangan')."',
                                   '".$nama_file."')");
  }
  else{
    mysql_query("INSERT INTO profilpegawai(nama,
                                    nip,
                                    jabatan,
                                    keterangan,
                                    subdit) 
                            VALUES('".$reqPost->getVarString('nama')."',
                                   '".$reqPost->getVarString('nip',18)."',
                                   '".$reqPost->getVarInt('jabatan')."',
                                   '".$reqPost->getVarAlphaNumSpace('keterangan')."',
								   '".$reqPost->getVarInt('subdit')."')");
  }
  header('location:../../media.php?module='.$module);
}

// Update profil pegawai
elseif ($module=='pegawai' && $act=='update'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];

  // Apabila gambar tidak diganti
  if (empty($lokasi_file)){
    mysql_query("UPDATE profilpegawai SET nama 		= '".$reqPost->getVarString('nama')."',
                                          nip 		= '".$reqPost->getVarString('nip',18)."',
										  jabatan 	= '".$reqPost->getVarInt('jabatan')."',
										  subdit 	= '".$reqPost->getVarInt('subdit')."',
										  keterangan= '".$reqPost->getVarAlphaNumSpace('keterangan')."'
                                    WHERE id_pegawai  = '".$reqPost->getVarInt('id')."'");
  }
  else{
    UploadPegawai($nama_file);
    mysql_query("UPDATE profilpegawai SET nama 		  = '".$reqPost->getVarString('nama')."',
                                          nip 		  = '".$reqPost->getVarString('nip',18)."',
										  jabatan 	  = '".$reqPost->getVarInt('jabatan')."',
										  subdit	  = '".$reqPost->getVarInt('subdit')."',
										  keterangan  = '".$reqPost->getVarAlphaNumSpace('keterangan')."',
                                          gambar      = '$nama_file'   
                                    WHERE id_pegawai  = '".$reqPost->getVarInt('id')."'");
  }
  header('location:../../media.php?module='.$module);
}
}
?>
