<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$kode = htmlspecialchars($purifier->purify(trim($_POST['kode'])), ENT_QUOTES);
	$nama = htmlspecialchars($purifier->purify(trim($_POST['nama'])), ENT_QUOTES);
	$tgl = date("Y-m-d H:i:s", time());
	if(isset($_GET['idklasik'])){
		$id_klas = htmlspecialchars($purifier->purify(trim($_GET['idklasik'])), ENT_QUOTES);
		$params = array(':id_klas' => $id_klas);
		$Klasifikasi = $this->model->selectprepare("klasifikasi", $field=null, $params, "id_klas=:id_klas");
		if($Klasifikasi->rowCount() >= 1){
			$data_Klasifikasi= $Klasifikasi->fetch(PDO::FETCH_OBJ);
			$idklasifikasi = $data_Klasifikasi->id_klas;
			$field = array('nama' => $nama);
			$params = array(':id_klas' => $id_klas);
			$update = $this->model->updateprepare("klasifikasi", $field, $params, "id_klas=:id_klas");
			if($update){
				echo "<script type=\"text/javascript\">alert('Data Berhasil diperbaharui...!!');window.location.href=\"./index.php?op=klasifikasi\";</script>";
			}else{
				die("<script>alert('Data menyimpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
			}
		}
	}else{
		$field = array('kode' => $kode, 'nama' => $nama, 'created'=>$tgl);
		$params = array(':kode' => $kode, ':nama'=>$nama, ':created'=>$tgl);
		$insert = $this->model->insertprepare("klasifikasi", $field, $params);
		if($insert->rowCount() >= 1){
			echo "<script type=\"text/javascript\">alert('Data Berhasil Tersimpan...!!');window.location.href=\"./index.php?op=klasifikasi\";</script>";
		}else{
			die("<script>alert('Data Gagal di simpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
		}
	}
}else{
	if(isset($_GET['idklasik']) && empty($_GET['act'])){
		$id_klas = htmlspecialchars($purifier->purify(trim($_GET['idklasik'])), ENT_QUOTES);
		$params = array(':id_klas' => $id_klas);
		$cek_klas = $this->model->selectprepare("klasifikasi", $field=null, $params, "id_klas=:id_klas");
		if($cek_klas->rowCount() >= 1){
			$data_cek_klas = $cek_klas->fetch(PDO::FETCH_OBJ);
			$title= "Edit Data Klasifikasi Surat Masuk (Unit Kerja : <b>$_SESSION[unit_kerja]</b>)";
			$kode = 'value="'.$data_cek_klas->kode .'" disabled';
			$nama = 'value="'.$data_cek_klas->nama .'"';
		}else{
			$title= "Entri Data Klasifikasi Surat Masuk";
		}
	}else{
		$title= "Entri Data Klasifikasi Surat Masuk";
	}
	if(isset($_GET['idklasik']) && (isset($_GET['act']) && $_GET['act'] == "del")){
		$id_klas = htmlspecialchars($purifier->purify(trim($_GET['idklasik'])), ENT_QUOTES);
		$params = array(':klasifikasi' => $id_klas);
		$lihat_sm = $this->model->selectprepare("arsip_sm", $field=null, $params, "klasifikasi=:klasifikasi");
		if($lihat_sm->rowCount() >= 1){
			die("<script>alert('Nama klasifikasi ini tidak dapat dihapus karena terkait dengan data Surat Masuk. Jika tetap ingin menghapus, silahkan hapus data Surat Masuk terkait terlebih dahulu. Terimakasih');window.history.go(-1);</script>");
		}else{
			$params = array(':id_klas' => $id_klas);
			$delete = $this->model->hapusprepare("klasifikasi", $params, "id_klas=:id_klas");
			if($delete){
				echo "<script type=\"text/javascript\">alert('Data Berhasil di Hapus...!!');window.location.href=\"./index.php?op=klasifikasi\";</script>";
			}else{
				die("<script>alert('Gagal menghapus data klasifikasi, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
			}
		}
	}?>
	<div class="card">
		<div class="card-body">
			<h4 class="widget-title"><?php echo $title;?></h4>
		</div>
		<div class="widget-body">
			<div class="widget-main">
				<form class="form-horizontal" role="form" method="POST" name="formku" action="<?php echo $_SESSION['url'];?>">
					<div class="form-group">
						<label class="col-sm-6 control-label no-padding-right" for="form-field-mask-1"> Kode </label>
						<div class="col-sm-6">
							<input class="form-control" placeholder="Kode klasifikasi" type="text" name="kode" <?php if(isset($kode)){ echo $kode; }?> id="form-field-mask-1" required/>
						</div>
					</div>
					<div class="space-6"></div>
					<div class="form-group">
						<label class="col-sm-6 control-label no-padding-right" for="form-field-mask-1"> Nama Klasifikasi </label>
						<div class="col-sm-6">
							<input class="form-control" placeholder="Nama/ket klasifikasi surat" type="text" name="nama" <?php if(isset($nama)){ echo $nama; }?> id="form-field-mask-1" required/>
						</div>
					</div>
					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							<div class="col-sm-2">
								<button type="submit" class="btn btn-primary" type="button">
									<i class="ace-icon fa fa-check bigger-110"></i>
									Submit
								</button>
							</div>
						</div>
					</div>
				</form><br>
			</div>
		</div>
	</div>
	<div class="space-4"></div>
	<div class="widget-box"><?php
	$GetKlasifikasi = $this->model->selectprepare("klasifikasi", $field=null, $params=null, $where=null, "order by nama ASC");
	if($GetKlasifikasi->rowCount() >= 1){
		while($data_GetKlasifikasi = $GetKlasifikasi->fetch(PDO::FETCH_OBJ)){
			$dump_klasifikasi[]=$data_GetKlasifikasi;
		}?>
		<div class="card">
			<div class="card-body">
				<table id="dataTableExample" class="table">
					<thead>
						<tr>
							<th width="50">No</th>
							<th width="150">Kode</th>
							<th>Nama/Ket klasifikasi</th>
							<th width="100">ACT</th>
						</tr>
					</thead>
					<tbody><?php
						$no=1;
						foreach($dump_klasifikasi as $key => $object){?>
							<tr>
								<td><?php echo $no;?></td>
								<td><?php echo $object->kode;?></td>
								<td><?php echo $object->nama;?></td>
								<td><center>
									<div class="hidden-sm hidden-xs btn-group">
										<a href="./index.php?op=klasifikasi&idklasik=<?php echo $object->id_klas;?>">								
											<button class="btn btn-minier btn-info">
												<i class="ace-icon fa fa-pencil bigger-100"></i>
											</button>
										</a>
										<a href="./index.php?op=klasifikasi&idklasik=<?php echo $object->id_klas;?>&act=del" onclick="return confirm('Anda yakin akan menghapus data ini??')">
											<button class="btn btn-minier btn-danger">
												<i class="ace-icon fa fa-trash-o bigger-110"></i>
											</button>
										</a>
									</div></center>
								</td>
							</tr><?php
						$no++;
						}?>
					</tbody>
				</table>
			</div>
		</div><?php
	}?>
	</div><?php
}?>