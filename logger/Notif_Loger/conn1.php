<?php
$server 	= "localhost";
$username 	= "root";
$password 	= "";
$database 	= "plant_alert";

// Koneksi dan memilih database di server
mysql_connect($server,$username,$password) or die("Koneksi gagal\n");
mysql_select_db($database) or die("Database tidak bisa dibuka");
?>