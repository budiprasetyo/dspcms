<?php
session_start();
 if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	  echo "<link href='style.css' rel='stylesheet' type='text/css'>
	 <center>Untuk mengakses modul, Anda harus login <br>";
	  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	include "../../../config/koneksi.php";
	include "../../../config/class_security.php";

	$module=$_GET['module'];
	$act=$_GET['act'];

	// Instantiate class_security with get method
	$reqGet	= new requestGet();

	// Input user
	if ($reqGet->getVarAlpha('module',4) == 'user' AND $reqGet->getVarAlpha('act',5) == 'input'){
	  // Instantiate class_security with post method
	  $reqPost = new requestPost();
	  $pass=md5($reqPost->getVar('password'));
	  mysql_query("INSERT INTO users(username,
									 password,
									 nama_lengkap,
									 email, 
									 no_telp,
									 id_session) 
							   VALUES('".$reqPost->getVarAlphaNum('username')."',
									'$pass',
									'".$reqPost->getVarAlphaNumSpace('nama_lengkap')."',
									'".$reqPost->getVarString('email')."',
									'".$reqPost->getVarString('no_telp')."',
									'$pass')");
	  header('location:../../media.php?module='.$module);
	}

	// Update user
	elseif ($reqGet->getVarAlpha('module',4) =='user' AND $reqGet->getVarAlpha('act',6) =='update'){
	  // Instantiate class_security with post method
	  $reqPost 	= new requestPost();
	  $pass		= $reqPost->getVar('password');
	  $username = $_SESSION['namauser'];
	  $cekSession = mysql_query("SELECT id_session FROM users WHERE username = '".$username."'");
	  $resSession = mysql_fetch_array($cekSession);
	  
	  if( $resSession['id_session'] == $reqPost->getVarString('id') OR $reqPost->getVarAlpha('leveluser',5) == 'admin' ){
		
			// Instantiate class_security with post method
				$reqPost = new requestPost();
				$pass=md5($reqPost->getVar('password'));
				mysql_query("UPDATE users SET password       = '$pass',
											 nama_lengkap    = '".$reqPost->getVarAlphaNumSpace('nama_lengkap')."',
											 email           = '".$reqPost->getVarString('email')."',  
											 blokir          = '".$reqPost->getVarAlphaSpace('blokir')."',  
											 no_telp         = '".$reqPost->getVarString('no_telp')."'  
									   WHERE id_session      = '".$reqPost->getVarString('id')."'");
		
	  }elseif($resSession['id_session'] != $reqPost->getVarString('id')){
			echo "<script type='text/javascript'>
						alert('Anda tidak memiliki hak untuk melakukan tindakan ini');
					</script>'";
	  }
	  echo "<script type='text/javascript'>
	  window.location.href='../../media.php?module=".$module."';
	  </script>";
	}
	
}
?>
