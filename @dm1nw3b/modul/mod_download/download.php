<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_download/aksi_download.php";
switch($reqGet->getVarAlpha('act',14)){
  // Tampil Download
  default:
    echo "<h2>Download</h2>
          <input type=button value='Tambah Download' onclick=location.href='?module=download&act=tambahdownload'>
          <table>
          <tr><th>no</th><th>judul</th><th>nama file</th><th>deskripsi</th><th>kategori aplikasi</th><th>tgl. posting</th><th>aksi</th></tr>";

    $p      = new Paging;
    $batas  = 15;
    $posisi = $p->cariPosisi($batas);

    $tampil=mysql_query("SELECT * FROM download ORDER BY id_download DESC LIMIT $posisi,$batas");

    $no = $posisi+1;
    while ($r=mysql_fetch_array($tampil)){
      $tgl=tgl_indo($r[tgl_posting]);
      echo "<tr><td>$no</td>
                <td>$r[judul]</td>
                <td>$r[nama_file]</td>
                <td>$r[deskripsi]</td>
                <td>$r[kategori_aplikasi]</td>
                <td>$tgl</td>
                <td><a href=?module=download&act=editdownload&id=$r[id_download]>Edit</a> | 
	                  <a href=$aksi?module=download&act=hapus&id=$r[id_download]>Hapus</a>
		        </tr>";
    $no++;
    }
    echo "</table>";
    $jmldata=mysql_num_rows(mysql_query("SELECT * FROM download"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";    
    break;
  
  // tambah download
  case "tambahdownload":
    echo "<h2>Tambah Download</h2>
          <form method=POST action='$aksi?module=download&act=input' enctype='multipart/form-data'>
          <table>
          <tr><td>Judul</td><td>  : <input type=text name='judul' size=30></td></tr>
          <tr><td>Deskripsi</td><td>  : <input type=text name='deskripsi' maxlength='300' size=30></td></tr>
          <tr><td>Kategori Aplikasi</td>
				<td>  : 
					<select name='kategori_aplikasi'>
						<option value='' selected='selected'>-- Pilih Kategori Aplikasi --</option>
						<option value='sp2d'>SP2D</option>
						<option value='spm'>SPM</option>
						<option value='bendum'>Bendum</option>
						<option value='vera'>Vera</option>
						<option value='sakpa'>SAKPA</option>
					</select>
				</td>
				</tr>
          <tr><td>File</td><td> : <input type=file name='fupload' size=40></td></tr>
          <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form><br><br><br>";
     break;
  
  
  // edit download 
  case "editdownload":
    $edit = mysql_query("SELECT * FROM download WHERE id_download='".$reqGet->getVarInt('id')."'");
    $r    = mysql_fetch_array($edit);

    echo "<h2>Edit Download</h2>
          <form method='post' enctype='multipart/form-data' action='".$aksi."?module=download&act=update'>
          <input type='hidden' name='id' value='".$r['id_download']."'>
          <table>
          <tr><td>Judul</td><td>     : <input type='text' name='judul' size='30' value='".$r['judul']."'></td></tr>
          <tr><td>Deskripsi</td><td>     : <input type=text name='deskripsi' size=30 value='$r[deskripsi]'></td></tr>
          <tr><td>File</td><td>    : $r[nama_file]</td></tr>
          <tr><td>Kategori Aplikasi</td>
				<td>  : 
					<select name='kategori_aplikasi'>
						<option value='$r[kategori_aplikasi]' selected='selected'>$r[kategori_aplikasi]</option>";
						$qKategori	= mysql_query("SELECT kategori_aplikasi FROM download WHERE id_download!='$_GET[id]'");
						while($rKategori	= mysql_fetch_row($qKategori)){
						echo "<option value='$rKategori[0]'>$rKategori[0]</option>";
						}
						echo "</select>
				</td>
				</tr>
          <tr><td>Ganti File</td><td> : <input type=file name='fupload' size=30> *)</td></tr>
          <tr><td colspan=2>*) Apabila file tidak diubah, dikosongkan saja.</td></tr>
          <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
}
?>
