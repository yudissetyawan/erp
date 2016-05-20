<?php
// -- Host, Username dan Password Database
$host = "localhost";//db-host
$username = "root";//db-user
$password = "Sm4k3nz4";//db-password
$db = "form_erp";//db-name

// Melakukan koneksi ke database
mysql_connect($host,$username,$password) or die("Koneksi gagal");
mysql_select_db($db) or die("Database tidak bisa dibuka");
?>