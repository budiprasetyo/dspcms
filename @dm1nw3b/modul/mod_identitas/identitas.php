<?php
$aksi="modul/mod_identitas/aksi_identitas.php";
switch($reqGet->getVarAlpha('act')){
  // Tampil identitas
  default:
    $sql  = mysql_query("SELECT * FROM identitas LIMIT 1");
    $r    = mysql_fetch_array($sql);

    echo "<h2>Identitas Website</h2>
          <form method=POST enctype='multipart/form-data' action=$aksi?module=identitas&act=update>
          <input type=hidden name=id value=$r[id_identitas]>
          <table>
          <tr><td>Nama Website</td><td> : <input type=text name='nama_website' value='$r[nama_website]' size=75></td></tr>
          <tr><td>Meta Deskripsi</td><td> : <input type=text name='meta_deskripsi' value='$r[meta_deskripsi]' size=100></td></tr>
          <tr><td>Meta Keyword</td><td> : <input type=text name='meta_keyword' value='$r[meta_keyword]' size=100></td></tr>
          <tr><td>Gambar Favicon</td><td> : <img src=../$r[favicon]></td></tr>
          <tr><td>Ganti Favicon</td><td> : <input type=file size=20 name=fupload>
          <br>NB: nama file gambar favicon harus favicon.ico
          </td></tr>
          <tr><td colspan=2><input type=submit value=Update>
                           <input type=button value=Batal onclick=self.history.back()></td></tr>
         </form></table>";
    break;  
}
?>
