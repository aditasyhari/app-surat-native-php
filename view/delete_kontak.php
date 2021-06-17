<?php
require_once '../db/db2.php';

$id = $_GET['id'];


$result = mysqli_query($conn, "DELETE FROM kontak WHERE id_kt=$id");

echo '<script language="javascript">alert("Kontak Berhasil Dihapus!!!"); document.location="../index.php?op=kontak";</script>';
?>