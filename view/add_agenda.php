<?php
	include('db.php');

	if($_SERVER['REQUEST_METHOD'] == 'POST'){	 
			$title = $_POST['title'];
			$lokasi = $_POST['lokasi'];
			$raw_tgl_awal = htmlentities($_POST['tgl_awal']);
			$raw_tgl_akhir = htmlentities($_POST['tgl_akhir']);
			$tgl_awal =  date('Y-m-d H:i:s', strtotime($raw_tgl_awal));;
			$tgl_akhir =  date('Y-m-d H:i:s', strtotime($raw_tgl_akhir));;
			if(!empty($title) and (!empty($lokasi))){ 
				$sql="INSERT INTO agenda (title,lokasi,start_event,end_event) VALUES ('$title','$lokasi','$tgl_awal','$tgl_akhir')";
				echo '<script language="javascript">alert("Penambahan Agenda Berhasil!!!"); document.location="./index.php?op=view_event";</script>';
				if($mysqli->query($sql) === false) { 
				  trigger_error('Perintah SQL Salah: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
				} else {
					header('location:./index.php?op=view_event');
				} // Jika berhasil alihkan ke halaman tampil.php
				
			}
			}
			
			$date = date('d/m/Y ', time());
	

		
	
?>
	<div class="widget-header">
		<h4 class="widget-title">Tambah Agenda</h4>
	</div>
		
	<div class="card mt-3">
	
		<div class="card-body">
		
			<form class="form-horizontal"  enctype="multipart/form-data" method="POST"  action="">
				<div class="form-group">
					<label class="tx-14 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1"> Nama Agenda </label>
					<div class="col-sm-6">
						<input class="form-control" data-rel="tooltip" placeholder="Perihal Agenda" type="text" name="title"  data-placement="bottom" id="form-field-mask-1" required/>
					</div>
				</div>		
				<div class="form-group">
					<label class="text-uppercase" for="form-field-mask-1"> Lokasi</label>
					<div class="col-sm-6">
						<input class="form-control" data-rel="tooltip" placeholder="Masukan Lokasi" type="text" name="lokasi"  data-placement="bottom" id="form-field-mask-1" required/>
					</div>
				</div>	
				<div class="form-group">
						<label class="tx-11 font-weight-bold mb-0 text-uppercase " for="form-field-mask-1"> Tanggal Dimulai </label>
						<div class="col-sm-6">
							<input class="form-control  date "  placeholder="Tanggal awal" type="date" name="tgl_awal" value ="<?php echo date('Y-m-d',strtotime($date))?>"  required />
						</div>
				</div>

				<div class="form-group">
						<label class="tx-11 font-weight-bold mb-0 text-uppercase " for="form-field-mask-1"> Tanggal Diakhiri </label>
						<div class="col-sm-6">
							<input class="form-control  date"   placeholder="Tanggal akhir" type="date"  name="tgl_akhir" value ="<?php echo date('Y-m-d',strtotime($date))?>"  required />
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