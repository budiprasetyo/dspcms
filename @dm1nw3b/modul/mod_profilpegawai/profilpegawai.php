<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_profilpegawai/aksi_profilpegawai.php";
switch($reqGet->getVarAlpha('act',19)){
  // Tampil profil pegawai
  default:
    echo "<h2>Profil Pegawai</h2>
          <input type=button value='Tambah Profil Pegawai' onclick=\"window.location.href='?module=pegawai&act=tambahprofilpegawai';\">
          <table>
          <tr><th>no</th><th>nama</th><th>nip</th><th>jabatan<br />keterangan</th><th>seksi</th><th>foto</th><th>aksi</th></tr>";

    $tampil = mysql_query("SELECT id_pegawai,nama,nip,gambar,subdit,jabatan,concat(subdit,jabatan) seksijbtn, keterangan FROM profilpegawai ORDER BY seksijbtn");
  
    $no = 1;
    while($r=mysql_fetch_array($tampil)){
      echo "<tr><td>$no</td>
                <td>$r[nama]</td>
                <td>$r[nip]</td>
		<td>";
      			switch($r[jabatan]){
				case "1":
					echo "Direktur";
					break;
				case "2":
					echo "Kepala Sub Direktorat";
					break;
				case "3":
					echo "Kepala Seksi";
					break;
				case "4":
					echo "Pelaksana";
					break;
				case "5":
					echo "Programmer";
					break;
			};
	echo "<br />".$r[keterangan];
	echo "</td>
		<td>";
			switch($r[subdit]){
				case "1":
					echo "Direktur Sistem Perbendaharaan";
					break;
				case "2":
					echo "Subdit Peraturan dan Pembinaan Perbendaharaan I";
					break;
				case "3":
					echo "Subdit Peraturan dan Pembinaan Perbendaharaan II";
					break;
				case "4":
					echo "Subdit Pengembangan Aplikasi";
					break;
				case "5":
					echo "Subdit Pengelolaan Basis Data dan Dukungan Teknologi Informasi";
					break;
				case "6":
					echo "Subdit Pengembangan Profesi";
					break;
			}
	echo "</td>
		      <td>";
      if ($r[gambar]!=''){
	      echo "<img src='../foto_pegawai/kecil_".$r['gambar']."'>";  
      }
      echo "
		            <td><a href=?module=pegawai&act=editprofilpegawai&id=$r[id_pegawai]>Edit</a> | 
		                <a href=$aksi?module=pegawai&act=hapus&id=$r[id_pegawai]>Hapus</a></td>
		        </tr>";
      $no++;
    }
    echo "</table>";
    break;
// Tambah profil pegawai
  case "tambahprofilpegawai":
    echo "<h2>Tambah Profil Pegawai</h2>
          <form method=POST action='$aksi?module=pegawai&act=input' enctype='multipart/form-data'>
          <table>
          <tr><td width=70>Nama</td>     <td> : <input type=text name='nama' size=60 maxlength='40' /></td></tr>
          <tr><td>NIP</td>  <td> : <input type='text' name='nip' size='60' maxlength='18' /></td></tr>
	  <tr><td>Jabatan</td>  
		    			<td>   
		    					<select name='jabatan'>
		    						<option selected='selected'>--Pilih Jabatan--</option>
		    						<option value='1'>Direktur</option>
									<option value='2'>Kepala Sub Direktorat</option>
		    						<option value='3'>Kepala Seksi</option>
		    						<option value='4'>Pelaksana</option>
		    						<option value='5'>Programmer</option>
		    					</select>
		    			</td>
	  </tr>
	  <tr><td>Sub Direktorat</td>  
		    			<td> 
		    					<select name='subdit'>  
		    						<option selected='selected'>--Pilih Sub Direktorat--</option>
		    						<option value='1'>Direktur Sistem Perbendaharaan</option>
		    						<option value='2'>Subdit Peraturan dan Pembinaan Perbendaharaan I</option>
									<option value='3'>Subdit Peraturan dan Pembinaan Perbendaharaan II</option>
		    						<option value='4'>Subdit Pengembangan Aplikasi</option>
		    						<option value='5'>Subdit Pengelolaan Basis Data dan Dukungan Teknologi Informasi</option>
		    						<option value='6'>Subdit Pengembangan Profesi</option>
		    					</select>
		    				</td>
	  <tr>
		<td>Keterangan</td>
		<td><input type='text' name='keterangan' maxlength='150' /></td>
	  </tr>
	  </tr>
          <tr><td>Gambar</td>  <td> : <input type=file name='fupload' size=40> 
                   <br>Tipe gambar harus JPG/JPEG dan ukuran lebar maks <b><u>haruslah</u></b>: <b>100 px<b></td></tr>
          <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
//Edit profil pegawai
  case "editprofilpegawai":
    $edit = mysql_query("SELECT * FROM profilpegawai WHERE id_pegawai='".$reqGet->getVarInt('id')."'");
    $r    = mysql_fetch_array($edit);

    echo "<h2>Edit Profil Pegawai</h2>
          <form method=POST enctype='multipart/form-data' action=$aksi?module=pegawai&act=update>
          <input type=hidden name=id value=$r[id_pegawai]>
          <table>
          <tr><td width=70>Nama</td>  <td> : <input type=text name='nama' size=60 maxlength='40' value='$r[nama]' /></td></tr>
          <tr><td>NIP</td>   <td> :  <input type='text' name='nip' size='60' maxlength='18' value='$r[nip]' /></td></tr>
	  <tr><td>Jabatan</td>
		    <td>   
				<select name='jabatan'>
					<option selected='selected'>--Pilih Jabatan--</option>
					<option value='1'>Direktur</option>
					<option value='2'>Kepala Sub Direktorat</option>
					<option value='3'>Kepala Seksi</option>
					<option value='4'>Pelaksana</option>
		    		<option value='5'>Programmer</option>
				</select>
		    </td>
	  </tr>   
	  <tr><td>Seksi</td>  
		    <td> 
				<select name='subdit'>  
					<option selected='selected'>--Pilih Sub Direktorat--</option>
					<option value='1'>Direktur Sistem Perbendaharaan</option>
					<option value='2'>Subdit Peraturan dan Pembinaan Perbendaharaan I</option>
					<option value='3'>Subdit Peraturan dan Pembinaan Perbendaharaan II</option>
					<option value='4'>Subdit Pengembangan Aplikasi</option>
					<option value='5'>Subdit Pengelolaan Basis Data dan Dukungan Teknologi Informasi</option>
					<option value='6'>Subdit Pengembangan Profesi</option>
				</select>
		    </td>
	  </tr>
	  <tr>
		<td>Keterangan</td>
		<td><input type='text' name='keterangan' maxlength='150' value='$r[keterangan]' /></td>
	  </tr>
          <tr><td>Gambar</td>       <td> :  ";
          if ($r[gambar]!=''){
              echo "<img src='../foto_banner/$r[gambar]'>";  
          }
    echo "</td></tr>
          <tr><td>Ganti Gbr</td>    <td> : <input type=file name='fupload' size=40> *)</td></tr>
          <tr><td colspan=2>*) Apabila gambar tidak diubah, dikosongkan saja.</td></tr>";

    echo  "<tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
         </table></form>";
    break;  
}

}
?>
