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
	// include class_security
	include "../../../config/class_security.php";
	// Require class_utility
	require_once "../../../config/class_utility.php";


	$module	= $_GET['module'];
	$act	= $_GET['act'];

	// Instantiate class_utility
	$utility	= new class_utility();
	// Instantiate class_security with get method
	$reqGet	= new requestGet();
	// Instantiate class_security with post method
	$reqPost = new requestPost();
	
	// Hapus peraturan
	if ($reqGet->getVarAlpha('module', 9) == 'peraturan' AND $reqGet->getVarAlpha('act', 5) == 'hapus'){
		  $id = $reqGet->getVarString('id');
		  mysql_query("DELETE FROM peraturan WHERE idperaturan='".$id."'");
		  header('location:../../media.php?module='.$module);
	}
	// Verifikasi parameter input
	elseif(isset($_POST['klasifikasi']) AND $_POST['klasifikasi'] == ""){
		echo "<script type = 'text/javascript'>
			alert('Klasifikasi Peraturan belum dipilih');
			window.location.href = '../../media.php?module=peraturan&act=tambahperaturan';
		</script>";
	}

	elseif(isset($_POST['jenaturan']) AND $_POST['jenaturan'] == ""){
		echo "<script type = 'text/javascript'>
			alert('Jenis Aturan belum dipilih');
			window.location.href = '../../media.php?module=peraturan&act=tambahperaturan';
		</script>";
	}
	
	// Input peraturan
	elseif ($reqGet->getVarAlpha('module', 9) =='peraturan' AND $reqGet->getVarAlpha('act', 5) == 'input'){
		  $lokasi_file = $_FILES['fupload']['tmp_name'];
		  $nama_file   = $_FILES['fupload']['name'];

		  // Apabila ada file peraturan yang diupload
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
					window.location=('../../media.php?module=peraturan')</script>";
		  }
		  else{
				// Converting date to mysql date format
				$Tglaturan 	= $reqPost->getVarString('tglaturan');
				$tglaturan 	= $utility->dateConvert($Tglaturan);
				$tglposting	= date("Y-m-d");
				// Function UploadPeraturan
				UploadPeraturan($nama_file);
				$qCekPeraturan	= mysql_query("SELECT noaturan FROM peraturan WHERE noaturan REGEXP '".$reqPost->getVarString('noaturan')."'");
				$rCekPeraturan	= mysql_num_rows($qCekPeraturan);
				if($rCekPeraturan > 0){
					echo "<script type='text/javascript'>
						alert('Peraturan ini pernah di-upload');
						history.back(-1);
					</script>";
				}else{
				mysql_query("INSERT INTO peraturan(jenaturan,
												noaturan,
												tglaturan,
												uraianaturan,
												klasifikasi,
												keterangan,
												file,
												tglposting) 
										VALUES('".$reqPost->getVarAlpha('jenaturan')."',
											   '".$reqPost->getVarString('noaturan')."',
											   '$tglaturan',
											   '".$reqPost->getVarString('uraianaturan')."',
											   '".$reqPost->getVarString('klasifikasi')."',
											   '".$reqPost->getVarString('keterangan')."',
											   '$nama_file',
											   '$tglposting')");
			  header('location:../../media.php?module='.$module);
				}
			}
		  }
		  else{
			$qCekPeraturan	= mysql_query("SELECT noaturan FROM peraturan WHERE noaturan REGEXP '$_POST[noaturan]'");
			$rCekPeraturan	= mysql_num_rows($qCekPeraturan);
				if($rCekPeraturan > 0){
					echo "<script type='text/javascript'>
						alert('Peraturan ini pernah di-upload');
						history.back(-1);
					</script>";
				}else{
				// Converting date to mysql date format
				$Tglaturan 	= $reqPost->getVarString('tglaturan');
				$tglaturan 	= $utility->dateConvert($Tglaturan);
				$tglposting	= date("Y-m-d");
				mysql_query("INSERT INTO peraturan(jenaturan,
													noaturan,
													tglaturan,
													uraianaturan,
													klasifikasi,
													keterangan,
													tglposting) 
											VALUES('".$reqPost->getVarAlpha('jenaturan')."',
												   '".$reqPost->getVarString('noaturan')."',
												   '$tglaturan',
												   '".$reqPost->getVarString('uraianaturan')."',
												   '".$reqPost->getVarString('klasifikasi')."',
												   '".$reqPost->getVarString('keterangan')."',
												   '$tglposting')");
				header('location:../../media.php?module='.$module);
			}
		  }
	}
	
	// Update peraturan
	elseif ($reqGet->getVarAlpha('module', 9) == 'peraturan' AND $reqGet->getVarAlpha('act', 6) == 'update'){
		  $lokasi_file = $_FILES['fupload']['tmp_name'];
		  $nama_file   = $_FILES['fupload']['name'];
		  // Apabila file tidak diganti
		  if (empty($lokasi_file)){
			// Converting date to mysql date format
				$Tglaturan 	= $reqPost->getVarString('tglaturan');
				$tglaturan 	= $utility->dateConvert($Tglaturan);
			
			mysql_query("UPDATE peraturan SET jenaturan = '".$reqPost->getVarAlpha('jenaturan')."', 
												noaturan = '".$reqPost->getVarString('noaturan')."', 
												tglaturan = '$tglaturan', 
												uraianaturan = '".$reqPost->getVarString('uraianaturan')."', 
												klasifikasi = '".$reqPost->getVarString('klasifikasi')."', 
												keterangan = '".$reqPost->getVarString('keterangan')."'
									 WHERE idperaturan = '".$reqPost->getVarInt('id')."'");
									 
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
				UploadPeraturan($nama_file);
				// Converting date to mysql date format
				$Tglaturan 	= $reqPost->getVarString('tglaturan');
				$tglaturan 	= $utility->dateConvert($Tglaturan);
				
				mysql_query("UPDATE peraturan SET jenaturan = '".$reqPost->getVarAlpha('jenaturan')."', 
													noaturan = '".$reqPost->getVarString('noaturan')."', 
													tglaturan = '$tglaturan', 
													uraianaturan = '".$reqPost->getVarString('uraianaturan')."', 
													klasifikasi = '".$reqPost->getVarString('klasifikasi')."', 
													keterangan = '".$reqPost->getVarString('keterangan')."',
													file    = '$nama_file'   
										 WHERE idperaturan = '".$reqPost->getVarInt('id')."'");
										 
			  header('location:../../media.php?module='.$module);
		  }
		}
	}
	
}
?>
