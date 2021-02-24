<?php 
require_once 'db/db2.php';
$idsk = $_GET['idsk'];

$query = mysqli_query($conn, "SELECT * FROM surat_keluar WHERE id_skeluar='$idsk'");
while($data =  $query->fetch_assoc()) {
    if($data['pembuat'] == $_SESSION['id_user']) {
        if($data['id_template'] == '') {
            require_once 'view/edit_surat_nontemplate.php';
        }else {

        }
    }else{
        require_once 'view/invalid_akses.php';
    }
}

?>