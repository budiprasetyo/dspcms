<?php
  session_start();
  session_destroy();
  echo "<center>Anda telah sukses keluar sistem <b>[LOGOUT]<b>";
  echo "<script type = 'text/javascript'>
	window.location.href='index.php';
  </script>";
?>
