<?php

require_once '../db/db2.php';


if(isset($_POST['submit_edit'])) {
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $email = $_POST['email'];
        $perusahaan = $_POST['perusahaan'];
        $telepon = $_POST['no_telp'];
        $id_user = $_POST['user'];
        $idkt = $_POST['idkt'];

        $sql = mysqli_query($conn, "UPDATE kontak SET nama='$nama', alamat='$alamat', email = '$email', perusahaan = '$perusahaan', telepon = '$telepon' WHERE id_kt='$idkt'");
        if($sql) {
            // header("location: ../index.php?op=approval_template");
            echo "<script type=\"text/javascript\">alert('Data berhasil Tersimpan...!!');window.location.href=\"../index.php?op=kontak\";</script>";
        } else {
			die("<script>alert('Gagal menyimpan ke database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
            // echo "2. Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
            // header("location: ../index.php?op=add_template");
        }


  
    // $created = htmlentities(date("Y-m-d H:i:s"));
    // if(!empty($nama) and (!empty($email))){ 
    //     $sql="UPDATE kontak SET nama = '$nama', alamat = '$alamat', email = '$email', perusahaan = '$perusahaan', telepon ='$telepon', id_user = '$id_user', created ='$created' WHERE id_kt = '$idkt'";
    //     // echo '<script language="javascript">alert("Kontak Berhasil Diperbaharui!!!"); document.location="../index.php?op=kontak";</script>';
    //     if($mysqli->query($sql) === false) { 
    //       trigger_error('Perintah SQL Salah: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
    //     } 
    //     else {
    //         header('location:./index.php?op=kontak');
    //     } // Jika berhasil alihkan ke halaman tampil.php
    // }
}
?>
