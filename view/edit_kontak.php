<?php
require_once 'db/db2.php';

$id = $_GET['editid'];
$user = $_SESSION['id_user'];


$result = mysqli_query($conn, "SELECT * FROM kontak WHERE id_kt=$id");
$row    = mysqli_fetch_array($result);

// if($_SERVER['REQUEST_METHOD'] == 'POST'){	 
//     $nama = $_POST['nama'];
//     $alamat = $_POST['alamat'];
//     $email = $_POST['email'];
//     $perusahaan = $_POST['perusahaan'];
//     $telepon = $_POST['no_telp'];
//     $id_user = $_SESSION['id_user'];
//     $created = htmlentities(date("Y-m-d H:i:s"));
//     if(!empty($nama) and (!empty($email))){ 
//         $sql="UPDATE kontak SET nama = '$nama', alamat = '$alamat', email = '$email', perusahaan = '$perusahaan', telepon ='$telepon', id_user = '$id_user' WHERE id_kt = '$id'";
//         echo '<script language="javascript">alert("Kontak Berhasil Diperbaharui!!!"); document.location="../index.php?op=kontak";</script>';
//         if($mysqli->query($sql) === false) { 
//           trigger_error('Perintah SQL Salah: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
//         } else {
//             header('location:./index.php?op=kontak');
//         } // Jika berhasil alihkan ke halaman tampil.php
        
//     }
//     }

// echo '<script language="javascript">alert("Kontak Berhasil Dihapus!!!"); document.location="../index.php?op=kontak";</script>';
?>

<div class="row justify-content-center  ">
  <div class="col-md-9">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h6 class="card-title mb-0">Edit Kontak</h6>
          <div>
            <img class="profile-pic img-lg  rounded-circle" src="https://via.placeholder.com/100x100" alt="profile">
            <!-- <span class="profile-name"><b>Amiah Burton</b></span>  -->
          </div>
       
        </div>
        <form action="view/update_kontak.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" value=<?php echo $id ?> name="idkt">
        <input type="hidden" value=<?php echo $user ?> name="user">
         
            <div class="mt-3 col-sm-8">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Nama:</label>
                <p class="text-muted"></p>
                <input type="text" class="form-control" id="exampleInputText1" name="nama" value = <?=$row['nama']?>>
              </div>
              <div class="mt-3 col-sm-8">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Alamat:</label>
                <p class="text-muted"></p>
                <textarea id="maxlength-textarea" class="form-control"  name="alamat"  maxlength="255"  ><?=$row['alamat']?></textarea>
                <!-- <input type="text" class="form-control" id="exampleInputText1" name="alamat" value = <?=$row['alamat']?>> -->
              </div>
              <div class="mt-3 col-sm-8">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
                <p class="text-muted"></p>
                <input type="text" class="form-control" id="exampleInputText1" name="email" value = <?=$row['email']?>>
              </div>
              <div class="mt-3 col-sm-8">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Nomor Telepon:</label>
                  <p class="text-muted"></p>
                  <input type="text" class="form-control" id="exampleInputText1" name="no_telp"value = <?=$row['telepon']?>>
                </div>
              <div class="mt-3 col-sm-8">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Bekerja di:</label>
                <p class="text-muted"></p>
                <input type="text" class="form-control" id="exampleInputText1" name="perusahaan" value = <?=$row['perusahaan']?>>
              </div><br>
              <button class="btn btn-primary" type="submit" value="submit_edit" name="submit_edit">Update Kontak</button>
        </form>
       </div>
      </div>
    </div>
  </div>
</div>
</div>
