<?php

//load.php

$connect = new PDO('mysql:host=localhost;dbname=surat', 'root', '');

$data = array();

$query = "SELECT * FROM agenda ORDER BY id";
    $req = $connect->prepare($query);
    $req->execute();
    $events = $req->fetchAll();
?>