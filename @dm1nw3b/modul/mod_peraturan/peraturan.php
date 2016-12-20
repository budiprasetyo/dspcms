<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	echo "<script>
	$(document).ready(function(){
		$('#date').datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '-40:+0'
		});
	});
	</script>";
	
	$aksi="modul/mod_peraturan/aksi_peraturan.php";
	switch($reqGet->getVarAlpha('act',15)){
	  // Tampil Download
	  default:
		echo "<h2>Upload Peraturan</h2>
			  <input type=button value='Tambah Peraturan' onclick=location.href='?module=peraturan&act=tambahperaturan'><br /><hr />
			  <form name='f_cari_peraturan' method='post' action='media.php?module=peraturan&act=cari'>
				<input type='text' name='cari' maxlength='75' size='30px' />
				<input type='submit' name='submit' value='Cari' />
			  </form>
			  <table>
			  <tr><th width='5%'>no</th><th width='10%'>no.peraturan</th><th>uraian</th><th width='8%'>tgl.peraturan</th><th width='10%'>klasifikasi</th><th width='12%'>tgl. posting</th><th width='10%'>Ket.</th><th width='12%'>aksi</th></tr>";

		$p      = new Paging;
		$batas  = 15;
		$posisi = $p->cariPosisi($batas);

		$tampil=mysql_query("SELECT * FROM peraturan ORDER BY idperaturan DESC LIMIT $posisi,$batas");

		$no = $posisi+1;
		while ($r=mysql_fetch_array($tampil)){
		  $tgl=tgl_indo($r[tglposting]);
		  $Tglaturan	= $r['tglaturan'];
		  $tglaturan	= $utility->dateConvert($Tglaturan);
		  echo "<tr height='70px'><td align='center'>$no</td>
					<td>$r[noaturan]</td>
					<td>$r[uraianaturan]</td>
					<td align='center'>$tglaturan</td>
					<td>$r[klasifikasi]</td>
					<td>$tgl</td>
					<td>$r[keterangan]</td>
					<td><a href=?module=peraturan&act=editperaturan&id=$r[idperaturan]>Edit</a> | 
						  <a href=$aksi?module=peraturan&act=hapus&id=$r[idperaturan]>Hapus</a>
					</tr>";
		$no++;
		}
		echo "</table>";
		$jmldata=mysql_num_rows(mysql_query("SELECT * FROM peraturan"));
		$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
		$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

		echo "<div id=paging>$linkHalaman</div><br>";    
		break;
	  
	  // cari peraturan
	  case "cari":
	  
			$Cari 	= $reqPost->getVarAlpha('cari');
			$cari	= str_replace(" ","%",$Cari);
		  
		  echo "
		  <br />
		  <br />
		  <table border='1'>
		  <tr><th width='5%'>no</th><th width='10%'>no.peraturan</th><th>uraian</th><th width='8%'>tgl.peraturan</th><th width='10%'>klasifikasi</th><th width='12%'>tgl. posting</th><th width='10%'>Ket.</th><th width='12%'>aksi</th></tr>";

			$p      = new Paging;
			$batas  = 15;
			$posisi = $p->cariPosisi($batas);

			$tampil=mysql_query("SELECT idperaturan,noaturan,uraianaturan,tglaturan,klasifikasi,keterangan,tglposting FROM peraturan WHERE noaturan LIKE '%" . $cari . "%' OR uraianaturan LIKE '%" . $cari . "%' ORDER BY idperaturan DESC LIMIT $posisi,$batas");

			$no = $posisi+1;
			while ($r=mysql_fetch_array($tampil)){
			  $tgl=tgl_indo($r['tglposting']);
			  $Tglaturan	= $r['tglaturan'];
			  $tglaturan	= $utility->dateConvert($Tglaturan);
			  echo "<tr height='70px'><td align='center'>$no</td>
						<td>$r[noaturan]</td>
						<td>$r[uraianaturan]</td>
						<td align='center'>$tglaturan</td>
						<td>$r[klasifikasi]</td>
						<td>$tgl</td>
						<td>$r[keterangan]</td>
						<td><a href=?module=peraturan&act=editperaturan&id=$r[idperaturan]>Edit</a> | 
							  <a href=$aksi?module=peraturan&act=hapus&id=$r[idperaturan]>Hapus</a>
						</tr>";
			$no++;
			}
			echo "</table>
			<br />
			<input type=button value=Kembali onclick=self.history.back()>
			<br />
			<br />";
			$jmldata=mysql_num_rows(mysql_query("SELECT * FROM peraturan"));
			$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
			$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);

			echo "<div id=paging>$linkHalaman</div><br>"; 
		break;
		
	  // tambah peraturan
	  case "tambahperaturan":
	  
		echo "<h2>Tambah Peraturan</h2>
			  <form method=POST action='$aksi?module=peraturan&act=input' enctype='multipart/form-data'>
			  <table>
			  <tr>
				<td>Jenis Peraturan</td>
				<td> : 
					<select name='jenaturan'>
					<option value='' selected='selected'>- Jenis Peraturan -</option>";
					$qPeraturan	= mysql_query("SELECT * FROM jenisperaturan");
					while($rPeraturan	= mysql_fetch_object($qPeraturan)){
					echo "<option value='$rPeraturan->jenaturan'>" . $rPeraturan->jenaturan . "</option>";
					}
			  echo "</select>
				</td>
			  </tr>
			  <tr><td>Nomor Peraturan</td><td>  : <input type=text name='noaturan' size='30' maxlength = '100' autofocus = 'autofocus' title = 'minimal 4 karakter' pattern = '(?=.*).{4,100}' required /></td></tr>
			  <tr><td>Uraian</td><td>  : <input type=text name='uraianaturan'  size=30  title = 'minimal 6 karakter dan maksimal 300 karakter' pattern = '[a-zA-Z0-9 .\-\/\(\)]{6,300}' required /></td></tr>
			  <tr><td>Tgl.Peraturan</td><td>  : <input id='date' type=text name='tglaturan' size=30 maxlength = '10' /></td></tr>
			  <tr>
				<td>Klasifikasi Peraturan</td>
				<td> : 
					<select name='klasifikasi'>
					<option value='' selected='selected'>- Klasifikasi Peraturan -</option>";
					$qKPeraturan	= mysql_query("SELECT * FROM klasifikasiperaturan ORDER BY idklasifikasi");
					while($rKPeraturan	= mysql_fetch_object($qKPeraturan)){
					echo "<option value='$rKPeraturan->klasifikasi'>" . $rKPeraturan->klasifikasi . "</option>";
					}
			  echo "</select>
				</td>
			  </tr>
			  <tr><td>Keterangan<td> : <input type='text' name='keterangan' size='30' pattern = '[a-zA-Z0-9 .\-\/\(\)]{6,200}' /></td></td></tr>
			  <tr><td>File</td><td> : <input type=file name='fupload' size=40></td></tr>
			  <tr><td colspan=2><input type=submit value=Simpan>
								<input type=button value=Batal onclick=self.history.back()></td></tr>
			  </table></form><br><br><br>";
		 break;
	  
	  
	  // edit download 
	  case "editperaturan":
		$edit = mysql_query("SELECT * FROM peraturan WHERE idperaturan='$_GET[id]'");
		$r    = mysql_fetch_array($edit);

		echo "<h2>Edit Peraturan</h2>
			  <form method=POST enctype='multipart/form-data' action=$aksi?module=peraturan&act=update>
			  <input type=hidden name='id' value=$r[idperaturan]>
			  <table>
			  <tr><td>Nomor Peraturan</td><td>     : <input type=text name='noaturan' size=30 maxlength = '100' autofocus = 'autofocus' title = 'minimal 4 karakter' pattern = '(?=.*).{4,100}' value='$r[noaturan]' required /></td></tr>
			  <tr><td>Jenis Peraturan</td>
				<td> :
					<select name='jenaturan'>";
						$qJenatur	= mysql_query("SELECT jenaturan FROM peraturan WHERE idperaturan='$_GET[id]'");
						$rJenatur	= mysql_fetch_object($qJenatur);
						$jenaturan = $rJenatur->jenaturan;
			  echo "<option value='$rJenatur->jenaturan' selected='selected'>" . $rJenatur->jenaturan . "</option>";
						$qJenaturan	= mysql_query("SELECT jenaturan FROM jenisperaturan WHERE jenaturan NOT LIKE '%$jenaturan%'");
						while($rJenaturan = mysql_fetch_object($qJenaturan)){
							echo "<option value='$rJenaturan->jenaturan'>" . $rJenaturan->jenaturan . "</option>";
						}
			echo "</select>
			  </td></tr>";
			  $Tglaturan	= explode("-",$r['tglaturan']);
			  $thnaturan	= $Tglaturan[0];
			  $blnaturan	= $Tglaturan[1];
			  $tglaturan	= $Tglaturan[2];
			  $tglAturan	= $tglaturan . "/" . $blnaturan . "/" . $thnaturan;
			  echo "<tr><td>Tgl.Peraturan</td><td>  : <input id='date' type=text value='$tglAturan' name='tglaturan' size=30 maxlength = '10' /></td></tr>
			  <tr><td>Klasifikasi Peraturan</td>
					<td> :
						<select name='klasifikasi'>";
							$qKlas	= mysql_query("SELECT klasifikasi FROM peraturan WHERE idperaturan='$_GET[id]'");
							$rKlas	= mysql_fetch_object($qKlas);
								$klasifikasi = $rKlas->klasifikasi;
							if($klasifikasi){
								echo "<option value='$klasifikasi' selected='selected'>$klasifikasi</option>";
								$qKlasifikasi = mysql_query("SELECT klasifikasi FROM klasifikasiperaturan WHERE klasifikasi NOT LIKE '%$klasifikasi%'");
								while($rKlasifikasi = mysql_fetch_object($qKlasifikasi)){
									echo "<option value='$rKlasifikasi->klasifikasi'>" . $rKlasifikasi->klasifikasi . "</option>";
								}
							}else{
								$qKlasifikasi = mysql_query("SELECT klasifikasi FROM klasifikasiperaturan");
								echo "<option value='' selected='selected'>-Klasifikasi Peraturan-</option>";
								while($rKlasifikasi = mysql_fetch_object($qKlasifikasi)){
									echo "<option value='$rKlasifikasi->klasifikasi'>" . $rKlasifikasi->klasifikasi . "</option>";
								}
							}
						echo "</select>
					</td>
			  </tr>
			  <tr><td>Uraian</td><td>     : <input type=text name='uraianaturan' value='$r[uraianaturan]' size='30'  title = 'minimal 6 karakter dan maksimal 300 karakter' pattern = '[a-zA-Z0-9 .\-\/\(\)]{6,300}' required /></td></tr>
			  <tr><td>Keterangan</td><td> : <input type='text' name='keterangan' size='30' value='$r[keterangan]'  pattern = '[a-zA-Z0-9 .\-\/\(\)]{6,200}' /></td></tr>
			  <tr><td>File</td><td>    : $r[file]</td></tr>
			  <tr><td>Ganti File</td><td> : <input type=file name='fupload' size=30> *)</td></tr>
			  <tr><td colspan=2>*) Apabila file tidak diubah, dikosongkan saja.</td></tr>
			  <tr><td colspan=2><input type=submit value=Update>
								<input type=button value=Batal onclick=location.href='?module=peraturan' /></td></tr>
			  </table></form>";
		break;  
	}
}
?>
