<?php
$server = "localhost:3377";
$username = "adminmonitor2012";
$password = "4dm1nMonitor";
$database = "dsp_peraturan";

// Koneksi dan memilih database di server
mysql_connect($server,$username,$password) or die("Koneksi gagal");
mysql_select_db($database) or die("Database tidak bisa dibuka");
?>
