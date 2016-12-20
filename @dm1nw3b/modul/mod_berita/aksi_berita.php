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
include "../../../config/fungsi_seo.php";
// include class_security
include "../../../config/class_security.php";

// instantiate requestGet Class
$reqGet = new requestGet();
// instantiate requestPost Class
$reqPost = new requestPost();
// instantiate requestSession Class
$reqSession = new requestSession();

$module=$_GET['module'];
$act=$_GET['act'];

// Hapus berita
if ($reqGet->getVarAlpha('module',6) == 'berita' AND $reqGet->getVarAlpha('act',5)=='hapus'){
  $data = mysql_fetch_array(mysql_query("SELECT gambar FROM berita WHERE id_berita = '".$reqGet->getVarInt('id')."'"));
  if ($data['gambar']!=''){
     mysql_query("DELETE FROM berita WHERE id_berita='".$reqGet->getVarInt('id')."'");
     unlink("../../../foto_berita/$_GET[namafile]");   
     unlink("../../../foto_berita/small_$_GET[namafile]");   
  }
  else{
     mysql_query("DELETE FROM berita WHERE id_berita='".$reqGet->getVarInt('id')."'");
  }
  header('location:../../media.php?module='.$module);
}

// Input berita
elseif ($reqGet->getVarAlpha('module',6)=='berita' AND $reqGet->getVarAlpha('act',5)=='input'){
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(1,99);
  $nama_file_unik = $acak.$nama_file; 
  
  if (!empty($_POST['tag_seo'])){
    $tag_seo = $_POST['tag_seo'];
    $tag=implode(',',$tag_seo);
  }
  $judul 		  = $reqPost->getVarString('judul');
  $judul_seo      = seo_title($judul);

  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
		if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
		echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
			window.location=('../../media.php?module=berita)</script>";
		}
		else{
			UploadImage($nama_file_unik);

			mysql_query("INSERT INTO berita(judul,
											judul_seo,
											id_kategori,
											headline,
											username,
											isi_berita,
											jam,
											tanggal,
											hari,
											tag, 
											gambar) 
									VALUES('".$reqPost->getVarString('judul')."',
										   '".$reqPost->getVarString('judul_seo')."',
										   '".$reqPost->getVarInt('kategori')."',
										   '".$reqPost->getVarAlpha('headline',1)."', 
										   '".$reqSession->getVarString('namauser')."',
										   '".$_POST['isi_berita']."',
										   '$jam_sekarang',
										   '$tgl_sekarang',
										   '$hari_ini',
										   '$tag',
										   '$nama_file_unik')");
		  header('location:../../media.php?module='.$module);
	  }
  }
  else{
    mysql_query("INSERT INTO berita(judul,
                                    judul_seo, 
                                    id_kategori,
                                    headline,
                                    username,
                                    isi_berita,
                                    jam,
                                    tanggal,
                                    tag, 
                                    hari) 
                            VALUES('".$reqPost->getVarString('judul')."',
                                   '$judul_seo',
                                   '".$reqPost->getVarInt('kategori')."',
                                   '".$reqPost->getVarAlpha('headline',1)."', 
                                   '".$reqSession->getVarString('namauser')."',
                                   '".$_POST['isi_berita']."',
                                   '$jam_sekarang',
                                   '$tgl_sekarang',
                                   '$tag',
                                   '$hari_ini')");
  header('location:../../media.php?module='.$module);
  }
  
  $jml=count($tag_seo);
  for($i=0;$i<$jml;$i++){
    mysql_query("UPDATE tag SET count=count+1 WHERE tag_seo='$tag_seo[$i]'");
  }
}

// Update berita
elseif ($reqGet->getVarAlpha('module',6) == 'berita' AND $reqGet->getVarAlpha('act',6) == 'update'){
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(1,99);
  $nama_file_unik = $acak.$nama_file; 

  if (!empty($_POST['tag_seo'])){
    $tag_seo = $_POST['tag_seo'];
    $tag=implode(',',$tag_seo);
  }

  $judul_seo = seo_title($_POST['judul']);

  // Apabila gambar tidak diganti
  if (empty($lokasi_file)){
    mysql_query("UPDATE berita SET judul       = '".$reqPost->getVarString('judul')."',
                                   judul_seo   = '".$judul_seo."', 
                                   id_kategori = '".$reqPost->getVarInt('kategori')."',
                                   headline    = '".$reqPost->getVarAlpha('headline',1)."',
                                   tag         = '".$tag."',
                                   isi_berita  = '".$_POST['isi_berita']."'  
                             WHERE id_berita   = '".$reqPost->getVarInt('id')."'");
  
  header('location:../../media.php?module='.$module);
  }
  else{
    if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
		echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
			window.location=('../../media.php?module=berita')</script>";
    }
    else{
		UploadImage($nama_file_unik);
		mysql_query("UPDATE berita SET judul       = '".$reqPost->getVarString('judul')."',
									   judul_seo   = '".$reqPost->getVarString('judul_seo')."', 
									   id_kategori = '".$reqPost->getVarInt('kategori')."',
									   headline    = '".$reqPost->getVarAlpha('headline',1)."',
									   tag         = '$tag',
									   isi_berita  = '".$_POST['isi_berita']."',
									   gambar      = '".$nama_file_unik."'   
								 WHERE id_berita   = '".$reqPost->getVarInt('id')."'");
								 
		header('location:../../media.php?module='.$module);
   }
  }
  
}

}
?>
