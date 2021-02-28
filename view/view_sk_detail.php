<?php
$params = array(':id_sk' => trim($_GET['skid']));
$sk = $this->model->selectprepare("arsip_sk a INNER JOIN user b on a.id_user=b.id_user", $field=null, $params, "a.id_sk=:id_sk", "ORDER BY tgl_surat DESC");
if($sk->rowCount() >= 1){
	$data_sk= $sk->fetch(PDO::FETCH_OBJ);
	$idsk= $data_sk->id_sk;
	if(isset($_GET['act']) && $_GET['act'] == "del"){
		@unlink('berkas/'.$data_sk->file);
		$params = array(':id_sk' => $idsk);
		$delete = $this->model->hapusprepare("arsip_sk", $params, "id_sk=:id_sk");
		if($delete){
			$cek = $this->model->selectprepare("arsip_sk", $field=null, $params=null, $where=null);
			if($cek->rowCount() <= 0){
				$delete = $this->model->truncate("arsip_sk");
			}
			echo "<script type=\"text/javascript\">alert('Data Berhasil di Hapus...!!');window.location.href=\"./index.php?op=sk\";</script>";
		}else{
			die("<script>alert('Gagal menghapus data surat keluar, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
		}
	}?>
	<div class="card">
		<div class="card-body">
			<div class="pull-left" style="padding:0 9px;">
				<div class="card">
					<div class="card-body">
					<img class="profile-pic rounded" alt="John's Avatar" src="assets/images/avatars/<?php echo $data_sk->picture;?>" width="32" />
						<a href="#" class="sender"><?php echo $data_sk->nama;?></a>
						<i class="ace-icon fa fa-clock-o bigger-110 orange middle"></i>
						<span class="time grey"><?php echo tgl_indo($data_sk->tgl_surat);?></span>
					</div>
				</div>
				
			</div>
		</div>
		<div class="hr hr-double"></div>
		<div class="card-body">
		Perihal &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp : <span class="blue bigger-125"><b><?php echo $data_sk->perihal;?></b></span>
			<p>
				Tgl/No Agenda &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 	:<b> <?php echo tgl_indo($data_sk->tgl_surat);?> | <?php echo $data_sk->custom_noagenda;?></b>
			</p>
			<p>
			No surat &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :<b> <?php echo $data_sk->no_sk;?></b>
			</p>
			<p>
				Tujuan Surat&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp : <b> <?php echo $data_sk->tujuan_surat;?></b>
			</p>
			<p>
				Perihal &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp : <b> <?php echo $data_sk->perihal;?></b>
			</p>
			<p>
				Pengolah &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :<b> <?php echo $data_sk->pengolah;?></b>
			</p>
			<p>
				Keterangan &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :<b> <?php echo $data_sk->ket;?></b>
			</p><br>
			<div class="pager"><?php
				if($data_sk->file != ''){?>
					<span class="previous">
						<a href="./berkas/<?php echo $data_sk->file;?>" target="_blank" class="btn btn-primary">Lihat Surat &nbsp <i class="ace-icon fa fa-file-pdf-o align-top bigger-125 icon-on-right"></i></a>
					</span><?php
				}
				if($HakAkses->sk == "W"){?>
					<span class="next">
						<a href="./index.php?op=add_sk&skid=<?php echo $data_sk->id_sk;?>" class="btn btn-danger">Edit Surat &nbsp <i class="ace-icon fa fa-pencil align-top bigger-125 icon-on-right"></i></a>
					</span><?php
				}?>
			</div>
		</div>
	</div><?php
}else{?>
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">
			<i class="ace-icon fa fa-times"></i>
		</button>
		<p>
			<strong><i class="ace-icon fa fa-check"></i>Perhatian!</strong>
			Data Surat keluar tidak ditemukan. Terimakasih.
		</p>
		<p>
			<a href="./index.php?op=sk"><button class="btn btn-minier btn-danger">Kembali</button></a>
		</p>
	</div><?php
}?>