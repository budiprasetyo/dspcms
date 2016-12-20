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
include "../../../config/library.php";
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

// Hapus agenda
if ($reqGet->getVarAlpha('module',6) == 'agenda' AND $reqGet->getVarAlpha('act',5) == 'hapus'){
  mysql_query("DELETE FROM agenda WHERE id_agenda='".$reqGet->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}

// Input agenda
elseif ($reqGet->getVarAlpha('module',6) =='agenda' AND $reqGet->getVarAlpha('act',5) =='input'){
  $mulai=$reqPost->getVarInt('thn_mulai').'-'.$reqPost->getVarInt('bln_mulai').'-'.$reqPost->getVarInt('tgl_mulai');
  $selesai=$reqPost->getVarInt('thn_selesai').'-'.$reqPost->getVarInt('bln_selesai').'-'.$reqPost->getVarInt('tgl_selesai');
  
  $tema_seo = seo_title($reqPost->getVarString('tema'));

  mysql_query("INSERT INTO agenda(tema,
                                  tema_seo, 
                                  isi_agenda,
                                  tempat,
                                  jam,
                                  tgl_mulai,
                                  tgl_selesai,
                                  tgl_posting,
                                  pengirim, 
                                  username) 
					                VALUES('".$reqPost->getVarString('tema')."',
					                       '$tema_seo', 
                                 '".$_POST['isi_agenda']."',
                                 '".$reqPost->getVarString('tempat')."',
                                 '".$reqPost->getVarString('jam')."',
                                 '$mulai',
                                 '$selesai',
                                 '$tgl_sekarang',
                                 '".$reqPost->getVarAlphaOrNum('pengirim')."',
                                 '".$reqSession->getVarString('namauser')."')");
  header('location:../../media.php?module='.$module);
}

// Update agenda
elseif ($reqGet->getVarAlpha('module',6) == 'agenda' AND $reqGet->getVarAlpha('act',6) == 'update'){
  $mulai=$reqPost->getVarInt('thn_mulai').'-'.$reqPost->getVarInt('bln_mulai').'-'.$reqPost->getVarInt('tgl_mulai');
  $selesai=$reqPost->getVarInt('thn_selesai').'-'.$reqPost->getVarInt('bln_selesai').'-'.$reqPost->getVarInt('tgl_selesai');
  
  $tema_seo = seo_title($reqPost->getVarString('tema'));

  mysql_query("UPDATE agenda SET tema        = '".$reqPost->getVarString('tema')."',
                                 tema_seo    = '".$tema_seo."',
                                 isi_agenda  = '".$_POST['isi_agenda']."',
                                 tgl_mulai   = '".$mulai."',
                                 tgl_selesai = '".$selesai."',
                                 tempat      = '".$reqPost->getVarString('tempat')."',  
                                 jam         = '".$reqPost->getVarString('jam')."',  
                                 pengirim    = '".$reqPost->getVarAlphaOrNum('pengirim')."'  
                           WHERE id_agenda   = '".$reqPost->getVarInt('id')."'");
  header('location:../../media.php?module='.$module);
}
}
?>
