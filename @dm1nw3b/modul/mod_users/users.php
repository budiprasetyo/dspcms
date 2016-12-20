<?php
session_start();
 if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi	= "modul/mod_users/aksi_users.php";
switch($reqGet->getVarAlpha('act',10)){
		  // Tampil User
		  default:
			if ($reqSession->getVarAlpha('leveluser') == 'admin'){
			  $tampil = mysql_query("SELECT * FROM users ORDER BY username");
			  echo "<h2>User</h2>
				  <input type=button value='Tambah User' onclick=\"window.location.href='?module=user&act=tambahuser';\">";
			}
			else{
			  $tampil=mysql_query("SELECT * FROM users 
								   WHERE username='".$_SESSION['namauser']."'");
			  echo "<h2>User</h2>";
			}
			
			echo "<table>
				  <tr><th>no</th><th>username</th><th>nama lengkap</th><th>email</th><th>No.Telp/HP</th><th>Blokir</th><th>aksi</th></tr>"; 
			$no=1;
			while ($r=mysql_fetch_array($tampil)){
			   echo "<tr><td>$no</td>
					 <td>$r[username]</td>
					 <td>$r[nama_lengkap]</td>
						 <td><a href=mailto:$r[email]>$r[email]</a></td>
						 <td>$r[no_telp]</td>
						 <td align=center>$r[blokir]</td>
					 <td><a href=?module=user&act=edituser&id=$r[id_session]>Edit</a></td></tr>";
			  $no++;
			}
			echo "</table>";
			break;
		  
		  case "tambahuser":
			if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
			echo "<h2>Tambah User</h2>
				  <form method=POST action='$aksi?module=user&act=input'>
				  <table>
				  <tr><td>Username</td>     <td> : <input type=text name='username' minlength = '4' maxlength = '50' autofocus = 'autofocus' title = 'minimal 4 karakter' pattern = '(?=.*).{4,50}' required /></td></tr>
				  <tr><td>Password</td>     <td> : <input type=text name='password' minlength = '8' maxlength = '50' title = 'minimal 8 karakter terdiri dari minimal 1 angka, huruf besar, dan kecil' pattern = '(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,50}' required /></td></tr>
				  <tr><td>Nama Lengkap</td> <td> : <input type=text name='nama_lengkap' maxlength = '100' size='30' title = 'wajib diisi' required /></td></tr>  
				  <tr><td>E-mail</td>       <td> : <input type='email' name='email'  maxlength = '100' size='30' /></td></tr>
				  <tr><td>No.Telp/HP</td>   <td> : <input type=text name='no_telp'  maxlength = '20'  size='20' /></td></tr>
				  <tr><td colspan=2><input type=submit value=Simpan>
									<input type=button value=Batal onclick=self.history.back()></td></tr>
				  </table></form>";
			}
			else{
			  echo "Anda tidak berhak mengakses halaman ini.";
			}
			 break;
			
		  case "edituser":
			$cekSession = mysql_query("SELECT id_session FROM users WHERE username = '".$_SESSION['namauser']."'");
			$resSession = mysql_fetch_array($cekSession);
			
			$edit=mysql_query("SELECT * FROM users WHERE id_session='$_GET[id]'");
			$r=mysql_fetch_array($edit);

			if ($reqSession->getVarAlpha('leveluser',5)=='admin'){
			echo "<h2>Edit User</h2>
				  <form method=POST action=$aksi?module=user&act=update>
				  <input type=hidden name=id value='$r[id_session]'>
				  <input type=hidden name=leveluser value='".$_SESSION['leveluser']."'>
				  <table>
				  <tr><td>Username</td>     <td> : <input type=text name='username' value='$r[username]' disabled> **)</td></tr>
				  <tr><td>Password</td>     <td> : <input type=text name='password' minlength = '8' maxlength = '50' title = 'minimal 8 karakter terdiri dari minimal 1 angka, huruf besar, dan kecil' pattern = '(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,50}' /> *) </td></tr>
				  <tr><td>Nama Lengkap</td> <td> : <input type=text name='nama_lengkap' value='$r[nama_lengkap]' maxlength = '100' size='30' title = 'wajib diisi' required /></td></tr>
				  <tr><td>E-mail</td>       <td> : <input type='email' name='email' value='$r[email]' maxlength = '100' size='30' /></td></tr>
				  <tr><td>No.Telp/HP</td>   <td> : <input type=text name='no_telp' size=30 value='$r[no_telp]'  maxlength = '20' /></td></tr>";

				if ($r[blokir]=='N'){
				  echo "<tr><td>Blokir</td>     <td> : <input type=radio name='blokir' value='Y'> Y   
													   <input type=radio name='blokir' value='N' checked> N </td></tr>";
				}
				else{
				  echo "<tr><td>Blokir</td>     <td> : <input type=radio name='blokir' value='Y' checked> Y  
													  <input type=radio name='blokir' value='N'> N </td></tr>";
				}
				
				echo "<tr><td colspan=2>*) Apabila password tidak diubah, dikosongkan saja.<br />
										**) Username tidak bisa diubah.</td></tr>
					  <tr><td colspan=2><input type=submit value=Update>
										<input type=button value=Batal onclick=self.history.back()></td></tr>
					  </table></form>";     
			}
			elseif($_GET['id'] === $resSession['id_session'] && $reqSession->getVarAlpha('leveluser',4)=='user'){
				echo "<h2>Edit User</h2>
					  <form method=POST action=$aksi?module=user&act=update>
					  <input type=hidden name=id value='$r[id_session]'>
					  <input type=hidden name=leveluser value='".$_SESSION['leveluser']."'>
					  <input type=hidden name=blokir value='$r[blokir]'>
					  <table>
					  <tr><td>Username</td>     <td> : <input type=text name='username' value='$r[username]' disabled> **)</td></tr>
					  <tr><td>Password</td>     <td> : <input type=text name='password'  minlength = '8' maxlength = '50' title = 'minimal 8 karakter terdiri dari minimal 1 angka, huruf besar, dan kecil' pattern = '(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,50}' /> *) </td></tr>
					  <tr><td>Nama Lengkap</td> <td> : <input type=text name='nama_lengkap' value='$r[nama_lengkap]' maxlength = '100' size='30' title = 'wajib diisi' required /></td></tr>
					  <tr><td>E-mail</td>       <td> : <input type='email' name='email' value='$r[email]' size='30' maxlength = '100' /></td></tr>
					  <tr><td>No.Telp/HP</td>   <td> : <input type=text name='no_telp' size=30 value='$r[no_telp]' maxlength = '20' /></td></tr>";    
				echo "<tr><td colspan=2>*) Apabila password tidak diubah, dikosongkan saja.<br />
										**) Username tidak bisa diubah.</td></tr>
					  <tr><td colspan=2><input type=submit value=Update>
										<input type=button value=Batal onclick=self.history.back()></td></tr>
					  </table></form>";     
			}
			elseif($_GET['id'] !== $resSession['id_session']){
				echo "<script type='text/javascript'>
						alert('Anda tidak memiliki hak untuk melakukan tindakan ini');
						window.location.href='media.php?module=user';
					</script>'";
			}
			break;  
		}
}
?>
