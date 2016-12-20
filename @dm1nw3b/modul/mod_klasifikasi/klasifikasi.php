<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_klasifikasi/aksi_klasifikasi.php";
switch($reqGet->getVarAlpha('act',17)){
  // Tampilkan Klasifikasi
  default:
    echo "<h2>Klasifikasi</h2>
          <input type=button value='Tambah Klasifikasi Peraturan' 
          onclick=\"window.location.href='?module=klasifikasi&act=tambahklasifikasi';\">
          <table>
          <tr><th>no</th><th>klasifikasi</th><th>aksi</th></tr>"; 
    $tampil=mysql_query("SELECT * FROM klasifikasiperaturan ORDER BY idklasifikasi DESC");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[klasifikasi]</td>
             <td><a href=?module=klasifikasi&act=editklasifikasi&id=$r[idklasifikasi]>Edit</a> | 
	               <a href=$aksi?module=klasifikasi&act=hapus&id=$r[idklasifikasi]>Hapus</a>
             </td></tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  // Form Tambah Klasifikasi
  case "tambahklasifikasi":
    echo "<h2>Tambah Klasifikasi</h2>
          <form method=POST action='$aksi?module=klasifikasi&act=input'>
          <table>
          <tr><td>Klasifikasi</td><td> : <input type=text name='klasifikasi'></td></tr>
          <tr><td colspan=2><input type=submit name=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit Klasifikasi
  case "editklasifikasi":
    $edit=mysql_query("SELECT * FROM klasifikasiperaturan WHERE idklasifikasi='".$reqGet->getVarInt('id')."'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Klasifikasi</h2>
          <form method=POST action=$aksi?module=klasifikasi&act=update>
          <input type=hidden name=id value='$r[idklasifikasi]'>
          <table>
          <tr><td>Klasifikasi</td><td> : <input type=text name='klasifikasi' value='$r[klasifikasi]'></td></tr>
          <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
}
?>
