<?php

$host = "localhost";
$dbname = "surat";
$user = "root";
$pass = "";

$dbpdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);

$conn = mysqli_connect($host, $user, $pass, $dbname) or die("Koneksi Gagal: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Koneksi Gagal: %s\n", mysqli_connect_error());
    exit();
}

?>