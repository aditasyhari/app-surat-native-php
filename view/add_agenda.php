<?php
	include('db.php');

	if($_SERVER['REQUEST_METHOD'] == 'POST'){	 
			$title = $_POST['title'];
			$lokasi = $_POST['lokasi'];
			$raw_tgl_awal = htmlentities($_POST['tgl_awal']);
			$raw_tgl_akhir = htmlentities($_POST['tgl_akhir']);
			$tgl_awal =  date('Y-m-d H:i:s', strtotime($raw_tgl_awal));;
			$tgl_akhir =  date('Y-m-d H:i:s', strtotime($raw_tgl_akhir));;
			if(!empty($title) and (!empty($lokasi))){ // Memeriksa apakah variabel judul dan pengarang sudah terisi,jika sudah jalankan query dibawah
				$sql="INSERT INTO agenda (title,lokasi,start_event,end_event) VALUES ('$title','$lokasi','$tgl_awal','$tgl_akhir')";
				echo '<script language="javascript">alert("Penambahan Agenda Berhasil!!!"); document.location="./index.php?op=view_event";</script>';
				if($mysqli->query($sql) === false) { // Jika gagal meng-insert data tampilkan pesan dibawah 'Perintah SQL Salah'
				  trigger_error('Perintah SQL Salah: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
				} else {
					header('location:./index.php?op=view_event');
				} // Jika berhasil alihkan ke halaman tampil.php
				
			}
			}
			
	

		
	
?>
	<div class="widget-header">
			<h4 class="widget-title">Tambah Agenda</h4>
		</div>
		
	<div class="card">
	
		<div class="card-body">
		
			<form class="form-horizontal"  enctype="multipart/form-data" method="POST"  action="">
				<div class="form-group">
					<label class="tx-14 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1"> Nama Agenda *</label>
					<div class="col-sm-6">
						<input class="form-control" data-rel="tooltip" placeholder="Perihal Agenda" type="text" name="title"  data-placement="bottom" id="form-field-mask-1" required/>
					</div>
				</div>		

				

				<div class="form-group">
					<label class="tx-14 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1"> Lokasi</label>
					<div class="col-sm-6">
						<input class="form-control" data-rel="tooltip" placeholder="Masukan Lokasi" type="text" name="lokasi"  data-placement="bottom" id="form-field-mask-1" required/>
					</div>
				</div>	
				<div class="form-group">
						<label class="tx-11 font-weight-bold mb-0 text-uppercase " for="form-field-mask-1"> Tanggal Dimulai </label>
						<span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Pilih tanggal awal.">?</span>
						<div class="col-sm-6">
							<input class="form-control  date datepicker" id="tgl_awal"  placeholder="Tanggal awal" type="text" name="tgl_awal"  required />
						</div>
				</div>

				<div class="form-group">
						<label class="tx-11 font-weight-bold mb-0 text-uppercase " for="form-field-mask-1"> Tanggal Diakhiri </label>
						<span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Pilih tanggal akhir.">?</span>
						<div class="col-sm-6">
							<input class="form-control  date datepicker" id="tgl_akhir"  placeholder="Tanggal akhir" type="text" name="tgl_akhir"  required />
						</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-10">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>