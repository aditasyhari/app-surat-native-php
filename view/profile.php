<?php
$params = array(':id_user' => $_SESSION['id_user']);
$user = $this->model->selectprepare("user", $field=null, $params, "id_user=:id_user");
if($user->rowCount() >= 1){
	$data_user = $user->fetch(PDO::FETCH_OBJ);
	$nama = 'value="'.$data_user->nama .'"';
	$uname = 'value="'.$data_user->uname .'"';
	$email = 'value="'.$data_user->email .'"';
	$ttd = $data_user->ttd;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
	//print_r($_POST);
	$nama = htmlspecialchars($purifier->purify(trim($_POST['nama'])), ENT_QUOTES);
	$email = htmlspecialchars($purifier->purify(trim($_POST['email'])), ENT_QUOTES);
	$uname = htmlspecialchars($purifier->purify(trim($_POST['uname'])), ENT_QUOTES);
	$upass = htmlspecialchars($purifier->purify(trim($_POST['upass'])), ENT_QUOTES);
	$nama_ttd = $_FILES['ttd_image']['name'];
	$ukuran_ttd = $_FILES['ttd_image']['size'];
	$tipe_ttd = $_FILES['ttd_image']['type'];
	$tmp_ttd = $_FILES['ttd_image']['tmp_name'];

	$scan_ttd = "TTD"."_".date("d-m-Y_H-i-s", time())."_".$nama_ttd;

	$path = 'foto/ttd/'.$scan_ttd;

	if(empty($upass)){
		if(empty($nama_ttd)){
			$field = array('nama' => $nama, 'uname' => $uname, 'email' => $email);
		}else{
			$field = array('nama' => $nama, 'uname' => $uname, 'email' => $email, 'ttd' => $scan_ttd);
			move_uploaded_file($tmp_ttd, $path);
		}
	}else{
		$upass = md5($upass);
		if(empty($nama_ttd)) {
			$field = array('nama' => $nama, 'uname' => $uname, 'upass' => $upass, 'email' => $email);
		} else {
			$field = array('nama' => $nama, 'uname' => $uname, 'upass' => $upass, 'email' => $email, 'ttd' => $scan_ttd);
			move_uploaded_file($tmp_ttd, $path);
		}
	}
	$params = array(':id_user' => $_SESSION['id_user']);
	$update = $this->model->updateprepare("user", $field, $params, "id_user=:id_user");
	if($update){?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">
				<i class="ace-icon fa fa-times"></i>
			</button>
			<p>
				<strong><i class="ace-icon fa fa-check"></i>Sukses!</strong>
				Data Sukses di Perbaharui. Silahkan Logout dan Login kembali. Terimakasih.
			</p>
			<p>
				<a href="./keluar"><button class="btn btn-minier btn-primary">Logout</button></a>
			</p>
		</div><?php
	}
}else{?>
	<!-- PAGE CONTENT BEGINS -->
	<form class="form-horizontal" role="form" method="POST" name="formku" action="<?php echo $_SESSION['url'];?>" enctype="multipart/form-data">
		<div class="row">
			<div class="col-sm-12">
				<div class="widget">
					<div class="widget-header">
						<h4 class="widget-title">Edit Profil</h4>
					</div>
					<div class="card">
						<div class="card-body">
							<label for="id-date-range-picker-1">Nama Lengkap</label><br>
							<div class="row">
								<div class=" col-sm-6">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user bigger-110"></i>
										</span>
										<input class="form-control" placeholder="Nama Lengkap" type="text" name="nama" <?php if(isset($nama)){ echo $nama; }?> id="form-field-mask-1" required/>
									</div>
								</div>
							</div><br>

							<label for="id-date-range-picker-1">Email</label><br>
							<div class="row">
								<div class=" col-sm-6">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user bigger-110"></i>
										</span>
										<input class="form-control" placeholder="Username" type="text" name="email" <?php if(isset($email)){ echo $email; }?> id="form-field-mask-1" required/>
									</div>
								</div>
							</div><br>

							<label for="id-date-range-picker-1">Username</label><br>
							<div class="row">
								<div class=" col-sm-6">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user bigger-110"></i>
										</span>
										<input class="form-control" placeholder="Username" type="text" name="uname" <?php if(isset($uname)){ echo $uname; }?> id="form-field-mask-1" required/>
									</div>
								</div>
							</div><br>

							<label for="id-date-range-picker-1">Password</label><br>
							<div class="row">
								<div class=" col-sm-6">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user bigger-110"></i>
										</span>
										<input class="form-control" placeholder="Password" type="text" name="upass"  id="form-field-mask-1"/>
									</div>
								</div>
							</div><br>

							<div class="form-group">
								<label for="">Scan Tanda Tangan</label><br>
								<img src="foto/ttd/<?= $ttd; ?>" class="mb-2 img-fluid" style="max-width: 300px;">
								<p class="card-description">*Abaikan form ini jika tidak mengganti tanda tangan.</p>
								<input type="file" name="ttd_image" class="" accept=".jpg,.jpeg,.png">
							</div>

							<br>
							<div class="row">
								<div class=" col-sm-6">
									<div class="input-group">
										<button type="submit" class="btn btn-primary" type="button">
											<i class="ace-icon fa fa-check bigger-110"></i>
											Submit
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form><?php
}?>