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

$module	= $_GET['module'];
$act	= $_GET['act'];

// Hapus download
if ($reqGet->getVarAlpha('module',8) == 'download' AND $reqGet->getVarAlpha('act',5) == 'hapus'){
  mysql_query("DELETE FROM download WHERE id_download='".$reqGet->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}

// Input download
elseif ($reqGet->getVarAlpha('module',8) =='download' AND $reqGet->getVarAlpha('act',5) =='input'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];

  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
  
	  $file_extension = strtolower(substr(strrchr($nama_file,"."),1));

	  switch($file_extension){
		case "pdf": $ctype="application/pdf"; break;
		case "exe": $ctype="application/octet-stream"; break;
		case "zip": $ctype="application/zip"; break;
		case "rar": $ctype="application/rar"; break;
		case "doc": $ctype="application/msword"; break;
		case "xls": $ctype="application/vnd.ms-excel"; break;
		case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
		case "gif": $ctype="image/gif"; break;
		case "png": $ctype="image/png"; break;
		case "jpeg":
		case "jpg": $ctype="image/jpg"; break;
		default: $ctype="application/proses";
	  }

	  if ($file_extension=='php'){
	   echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload tidak bertipe *.PHP');
			window.location=('../../media.php?module=download')</script>";
	  }
	  else{
		UploadFile($nama_file);
		mysql_query("INSERT INTO download(judul,
										deskripsi,
										nama_file,
										kategori_aplikasi,
										tgl_posting) 
								VALUES('".$reqPost->getVarString('judul')."',
									   '".$reqPost->getVarString('deskripsi')."',
									   '$nama_file',
									   '".$reqPost->getVarString('kategori_aplikasi')."',
									   '$tgl_sekarang')");
	  header('location:../../media.php?module='.$module);
	  }
  }
  else{
    mysql_query("INSERT INTO download(judul,
									deskripsi,
									kategori_aplikasi,
                                    tgl_posting) 
                            VALUES('".$reqPost->getVarString('judul')."',
								   '".$reqPost->getVarString('deskripsi')."',
								   '".$reqPost->getVarString('kategori_aplikasi')."',
                                   '$tgl_sekarang')");
  header('location:../../media.php?module='.$module);
  }
}

// Update donwload
elseif ($reqGet->getVarAlpha('module',8) == 'download' AND $reqGet->getVarAlpha('act',6) == 'update'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];

  // Apabila file tidak diganti
  if (empty($lokasi_file)){
    mysql_query("UPDATE download SET judul     = '".$reqPost->getVarString('judul')."', deskripsi= '".$reqPost->getVarString('deskripsi')."', kategori_aplikasi= '".$reqPost->getVarString('kategori_aplikasi')."'
                             WHERE id_download = '".$reqPost->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
  }
  else{
  $file_extension = strtolower(substr(strrchr($nama_file,"."),1));

  switch($file_extension){
    case "pdf": $ctype="application/pdf"; break;
    case "exe": $ctype="application/octet-stream"; break;
    case "zip": $ctype="application/zip"; break;
    case "rar": $ctype="application/rar"; break;
    case "doc": $ctype="application/msword"; break;
    case "xls": $ctype="application/vnd.ms-excel"; break;
    case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
    case "gif": $ctype="image/gif"; break;
    case "png": $ctype="image/png"; break;
    case "jpeg":
    case "jpg": $ctype="image/jpg"; break;
    default: $ctype="application/proses";
  }

  if ($file_extension=='php'){
   echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload tidak bertipe *.PHP');
        window.location=('../../media.php?module=download')</script>";
  }
  else{
    UploadFile($nama_file);
    mysql_query("UPDATE download SET judul     = '".$reqPost->getVarString('judul')."', deskripsi = '".$reqPost->getVarString('deskripsi')."', kategori_aplikasi = '".$reqPost->getVarString('kategori_aplikasi')."',
                                   nama_file    = '$nama_file'   
                             WHERE id_download = '".$reqPost->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
  }
  }
}
}
?>
