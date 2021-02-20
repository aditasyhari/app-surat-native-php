<?php
require_once '../db/db2.php';

$id_template = $_GET['id_template'];

$res = mysqli_query($conn, "SELECT * FROM template WHERE id_template=".$_GET['id_template']);
while ($row = $res->fetch_assoc()) {
    unlink("../foto/kop/".$row['logo_kop']);
}

$result = mysqli_query($conn, "DELETE FROM template WHERE id_template=$id_template");

header("Location: ../index.php?op=template");
?>