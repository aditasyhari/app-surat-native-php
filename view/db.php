<?php
define("HOST", "localhost"); // Host database
define("USER", "root"); // Usernama database
define("PASSWORD", ""); // Password database
define("DATABASE", "surat"); // Nama database

$mysqli = new PDO('mysql:host=localhost;dbname=surat', 'root', '');;

if($mysqli->connect_error){
	trigger_error('Koneksi ke database gagal: ' . $mysqli->connect_error, E_USER_ERROR);	
}

?>