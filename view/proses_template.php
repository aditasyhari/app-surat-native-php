<?php 
ini_set('date.timezone', 'Asia/Jakarta');
require_once "../db/db2.php"; 

if (isset($_POST['submit_template'])){
    $id_pembuat = $_POST['id_pembuat'];
	$layout_kop = $_POST['layout_kop'];
	$id_klasifikasi = $_POST['id_klasifikasi'];
	$id_validator = $_POST['id_validator'];
	$ukuran_hal = $_POST['ukuran_hal'];
	$orientasi_hal = $_POST['orientasi_hal'];
    $m_atas = $_POST['m_atas'];
    $m_bawah = $_POST['m_bawah'];
    $m_kiri = $_POST['m_kiri'];
    $m_kanan = $_POST['m_kanan'];
	$layout_konten = $_POST['layout_konten'];
	$nama_template = $_POST['nama_template'];
    
    $nama_file = $_FILES['logo_kop']['name'];
    $ukuran_file = $_FILES['logo_kop']['size'];
    $tipe_file = $_FILES['logo_kop']['type'];
    $tmp_file = $_FILES['logo_kop']['tmp_name'];

    $logo_kop = "KOP-TEMPLATE"."_".date("d-m-Y_H-i-s", time())."_".$nama_file;

    $path = "../foto/kop/".$logo_kop;
    
    $sql = mysqli_query($conn, "INSERT INTO template(id_pembuat, layout_kop, logo_kop, id_klasifikasi, id_validator, ukuran_hal, orientasi_hal, m_atas, m_bawah, m_kiri, m_kanan, layout_konten, nama_template) VALUES('$id_pembuat','$layout_kop','$logo_kop','$id_klasifikasi','$id_validator','$ukuran_hal','$orientasi_hal','$m_atas','$m_bawah','$m_kiri','$m_kanan','$layout_konten','$nama_template')");
    
    if($sql) {
        move_uploaded_file($tmp_file, $path);
        header("location: ../index.php?op=template");
    } else {
        echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
        // header("location: ../index.php?op=add_template");
    }

}elseif(isset($_POST['submit_edit_template'])) {
    $id_template = $_POST['id_template'];
    $id_pembuat = $_POST['id_pembuat'];
	$layout_kop = $_POST['layout_kop'];
	$id_klasifikasi = $_POST['id_klasifikasi'];
	$id_validator = $_POST['id_validator'];
	$ukuran_hal = $_POST['ukuran_hal'];
	$orientasi_hal = $_POST['orientasi_hal'];
    $m_atas = $_POST['m_atas'];
    $m_bawah = $_POST['m_bawah'];
    $m_kiri = $_POST['m_kiri'];
    $m_kanan = $_POST['m_kanan'];
	$layout_konten = $_POST['layout_konten'];
	$nama_template = $_POST['nama_template'];
    $status = 'menunggu';
    $read_validator = 0;
    $tgl_diupdate = date("Y-m-d H:i:s", time());
    
    if(!file_exists($_FILES['logo_kop']['tmp_name']) || !is_uploaded_file($_FILES['logo_kop']['tmp_name'])) {
        $sql = mysqli_query($conn, "UPDATE template SET id_pembuat='$id_pembuat', layout_kop='$layout_kop', id_klasifikasi='$id_klasifikasi', id_validator='$id_validator', ukuran_hal='$ukuran_hal', orientasi_hal='$orientasi_hal', m_atas='$m_atas', m_bawah='$m_bawah', m_kiri='$m_kiri', m_kanan='$m_kanan', layout_konten='$layout_konten', nama_template='$nama_template', read_validator='$read_validator', tgl_diupdate='$tgl_diupdate' WHERE id_template='$id_template'");
    
        if($sql) {
            header("location: ../index.php?op=template");
        } else {
            echo "1. Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
            // header("location: ../index.php?op=add_template");
        }
    }else {
        $nama_file = $_FILES['logo_kop']['name'];
        $ukuran_file = $_FILES['logo_kop']['size'];
        $tipe_file = $_FILES['logo_kop']['type'];
        $tmp_file = $_FILES['logo_kop']['tmp_name'];
    
        $logo_kop = "KOP-TEMPLATE"."_".date("d-m-Y_H-i-s", time())."_".$nama_file;
    
        $path = "../foto/kop/".$logo_kop;
        
        $res = mysqli_query($conn, "SELECT * FROM template WHERE id_template='$id_template'");
        while ($row = $res->fetch_assoc()) {
            unlink("../foto/kop/".$row['logo_kop']);
        }

        $sql = mysqli_query($conn, "UPDATE template SET id_pembuat='$id_pembuat', layout_kop='$layout_kop', logo_kop='$logo_kop', id_klasifikasi='$id_klasifikasi', id_validator='$id_validator', ukuran_hal='$ukuran_hal', orientasi_hal='$orientasi_hal', m_atas='$m_atas', m_bawah='$m_bawah', m_kiri='$m_kiri', m_kanan='$m_kanan', layout_konten='$layout_konten', nama_template='$nama_template', read_validator='$read_validator', tgl_diupdate='$tgl_diupdate' WHERE id_template='$id_template'");
        
        if($sql) {
            move_uploaded_file($tmp_file, $path);
            header("location: ../index.php?op=template");
        } else {
            echo "2. Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
            // header("location: ../index.php?op=add_template");
        }
    }

}else {
    echo "Akses gagal";
}

?>