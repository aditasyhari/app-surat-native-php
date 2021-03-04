<?php
include('db.php');


if(isset($_POST['reset'])){
	$sql="DELETE FROM libur_pekan";	
	if($mysqli->query($sql) === false) { // Jika gagal meng-insert data tampilkan pesan dibawah 'Perintah SQL Salah'
		trigger_error('Perintah SQL Salah: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
	  } else {
		  header('location:./index.php?op=add_pekanan');
	  } // Jika berhasil alihkan ke halaman tampil.php
	  
}



if($_SERVER['REQUEST_METHOD'] == 'POST'){	 
		$hari = json_encode($_POST['hari']);
		// $raw_tahun = htmlentities($_POST['tahun'])
		$tahun =  date('Y-m-d');
		if(!empty($hari)){ // Memeriksa apakah variabel judul dan pengarang sudah terisi,jika sudah jalankan query dibawah
			$sql="INSERT INTO libur_pekan (dow,created) VALUES ('$hari','$tahun')";
			echo '<script language="javascript">alert("Data Berhasil Diperbaharui!!!"); document.location="./index.php?op=pekanan";</script>';
			if($mysqli->query($sql) === false) { // Jika gagal meng-insert data tampilkan pesan dibawah 'Perintah SQL Salah'
			  trigger_error('Perintah SQL Salah: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
			} else {
				header('location:./index.php?op=pekanan');
			} // Jika berhasil alihkan ke halaman tampil.php
			
		}
		}
		
		
		
?>
<div class="card">
			<div class="card-body">
				<form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" name="formku" action="<?php echo $_SESSION['url'];?>">
					<div class="form-group">
						<label class="tx-11 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1">Tahun</label>
						<div class="col-sm-6">
							<input class="form-control" placeholder="<?php echo date("Y");?>" type="text" name="tahun" id="form-field-mask-1" required disabled />
						</div>
					</div>
				<div class="form-group">
				<label  class="tx-11 font-weight-bold mb-0 text-uppercase">Hari</label>
					<div class="col-sm-6">
					<select class="js-example-basic-multiple w-100" name ="hari[]" multiple="multiple" required >
						<option value="1">Senin</option>
						<option value="2">Selasa</option>
						<option value="3">Rabu</option>
						<option value="4">Kamis</option>
						<option value="5">Jum'at</option>
						<option value="6">Sabtu</option>
						<option value="0">Minggu</option>
					</select>
					</div>
					</div>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-info pull-right">
									<i class="ace-icon fa fa-check bigger-110"></i>
									Generate
								</button>
							</div>
				</form>
				<form action="" method='post'>
					<input class="btn btn-warning pull-left" value = 'Reset Hari Libur ' type="submit" name="reset"/>
				</form>
			</div>
		</div>