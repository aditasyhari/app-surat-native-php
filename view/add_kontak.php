<?php
include('db.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){	 
			$nama = $_POST['nama'];
			$alamat = $_POST['alamat'];
            $email = $_POST['email'];
            $perusahaan = $_POST['perusahaan'];
            $telepon = $_POST['no_telp'];
            $id_user = $_SESSION['id_user'];
            $created = htmlentities(date("Y-m-d H:i:s"));
			if(!empty($nama) and (!empty($email))){ 
				$sql="INSERT INTO kontak (id_kt,id_user,nama,perusahaan,email,telepon,alamat,created) VALUES ('','$id_user','$nama','$perusahaan','$email','$telepon','$alamat','$created')";
				echo '<script language="javascript">alert("Penambahan Kontak Berhasil!!!"); document.location="./index.php?op=kontak";</script>';
				if($mysqli->query($sql) === false) { 
				  trigger_error('Perintah SQL Salah: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
				} else {
					header('location:./index.php?op=kontak');
				} // Jika berhasil alihkan ke halaman tampil.php
				
			}
			}
			
            // $created =  date('d-m-Y H:i:s');

?>
	


  <?php
include('db.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){	 
			$nama = $_POST['nama'];
			$alamat = $_POST['alamat'];
            $email = $_POST['email'];
            $perusahaan = $_POST['perusahaan'];
            $telepon = $_POST['no_telp'];
            $id_user = $_SESSION['id_user'];
            $created = htmlentities(date("Y-m-d H:i:s"));
			if(!empty($nama) and (!empty($email))){ 
				$sql="INSERT INTO kontak (id_kt,id_user,nama,perusahaan,email,telepon,alamat,created) VALUES ('','$id_user','$nama','$perusahaan','$email','$telepon','$alamat','$created')";
				echo '<script language="javascript">alert("Penambahan Kontak Berhasil!!!"); document.location="./index.php?op=kontak";</script>';
				if($mysqli->query($sql) === false) { 
				  trigger_error('Perintah SQL Salah: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
				} else {
					header('location:./index.php?op=kontak');
				} // Jika berhasil alihkan ke halaman tampil.php
				
			}
			}
			
            // $created =  date('d-m-Y H:i:s');

?>
	


<div class="row justify-content-center ">
  <div class="col-md-8">
    <div class="card rounded">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h6 class="card-title mb-0">Tambah Kontak</h6>
          <div>
            <img class="profile-pic img-lg  rounded-circle" src="https://via.placeholder.com/100x100" alt="profile">
            <!-- <span class="profile-name"><b>Amiah Burton</b></span>  -->
          </div>
       
        </div>
        <form action="<?php echo $_SESSION['url'];?>" method="POST" enctype="multipart/form-data">
         
            <div class="mt-3 col-sm-8">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Nama:</label>
                <p class="text-muted"></p>
                <input type="text" class="form-control" id="exampleInputText1" name="nama" required>
              </div>
              <div class="mt-3 col-sm-8">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Alamat:</label>
                <p class="text-muted"></p>
                
								<textarea id="maxlength-textarea" class="form-control"  name="alamat"  maxlength="255" ></textarea>
							</div>
                <!-- <input type="text" class="form-control" id="exampleInputText1" name="alamat"> -->
              
              <div class="mt-3 col-sm-8">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
                <p class="text-muted"></p>
                <input type="email" class="form-control" id="exampleInputText1" name="email" required>
              </div>
              <div class="mt-3 col-sm-8">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Nomor Telepon:</label>
                  <p class="text-muted"></p>
                  <input type="text" class="form-control" id="exampleInputText1" name="no_telp"required>
                </div>
              <div class="mt-3 col-sm-8">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Bekerja di:</label>
                <p class="text-muted"></p>
                <input type="text" class="form-control" id="exampleInputText1" name="perusahaan">
              </div><br>
              <button class="btn btn-primary" type="submit">Tambahkan Ke Kontak</button>
        </form>
       </div>
      </div>
    </div>
  </div>
</div>
</div>
