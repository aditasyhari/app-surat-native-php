<?php
$params = array(':id_sm' => trim($_GET['smid']));
$sm = $this->model->selectprepare("arsip_sm a INNER JOIN user b on a.id_user=b.id_user", $field=null, $params, "a.id_sm=:id_sm", "ORDER BY tgl_terima DESC");
if($sm->rowCount() >= 1){
	$data_sm = $sm->fetch(PDO::FETCH_OBJ);
	$idsm= $data_sm->id_sm;
	$field = array('view' => 1);
	$params = array(':id_sm' => $idsm);
	$update = $this->model->updateprepare("arsip_sm", $field, $params, "id_sm=:id_sm");
	$bagian = $this->model->selectprepare("bagian", $field=null, $params=null, $where=null, $other=null);
	while($data_bagian= $bagian->fetch(PDO::FETCH_OBJ)){
		$dump_bagian[]=$data_bagian;
	}?>
	<div class="card">
		<div class="message-header clearfix">
			<div class="pull-left" style="padding:0 9px;">
				<span class="blue bigger-125">
					<?php echo $data_sm->perihal;?>
				</span>
				<img class="middle" alt="John's Avatar" src="assets/images/avatars/<?php echo $data_sm->picture;?>" width="32" />
				<a href="#" class="sender"><?php echo $data_sm->nama;?></a>
				<i class="ace-icon fa fa-clock-o bigger-110 orange middle"></i>
				<span class="time grey"><?php echo tgl_indo($data_sm->tgl_terima);?></span>
			</div>
		</div>
		<div class="hr hr-double"></div>
		<div class="message-body">
				Tgl terima/No agenda: <br/><b><?php echo tgl_indo($data_sm->tgl_terima);?> | <?php echo $data_sm->custom_noagenda;?></b>
			<p>
			</p>
			<p>
				Dari: <br/><b><?php echo $data_sm->pengirim;?></b>
			</p>
			<p>
				Tgl/No surat: <br/><b><?php echo tgl_indo($data_sm->tgl_surat);?> | <?php echo $data_sm->no_sm;?></b>
			</p>
			<p>
				Perihal: <br/><b><?php echo $data_sm->perihal;?></b>
			</p>
			<p>
				Ket: <br/><b><?php echo $data_sm->ket; ?></b>
			</p>
			<p>
				Detail Surat:<br/>
				<!-- <span class="label label-xs label-primary label-white middle">
					<a href="./index.php?op=memoprint&memoid=<?php echo $data_sm->id_sm;?>" target="_blank"><b>Lihat</b></a>
				</span> -->
				<span class="label label-xs label-danger label-white middle">
					<a href="./index.php?op=memoprint&memoid=<?php echo $data_sm->id_sm;?>&act=pdf" target="_blank"><b>Cetak</b> <i class="ace-icon fa fa-file-pdf-o align-top bigger-125 icon-on-right"></i></a>
				</span>
			</p><?php			
			$params = array(':id_sm' => $idsm);
			$cek_memo = $this->model->selectprepare("memo a inner join bagian b on a.disposisi=b.id_bag", $field=null, $params, "a.id_sm=:id_sm");
			if($cek_memo->rowCount() >= 1){
				$data_cek = $cek_memo->fetch(PDO::FETCH_OBJ);
				$id_status = $data_cek->id_status;
				$title= "Edit Disposisi Surat";
			}else{
				$title= "Disposisi Surat";
			}
			if($data_cek->tembusan != '' AND $data_cek->tembusan != 'null'){
				$cek_tembusan = json_decode($data_cek->tembusan, true);
			}else{
				$dummy_arr = '[""]';
				$cek_tembusan = json_decode($dummy_arr, true);
			}
			if($cek_memo->rowCount() >= 1){?>
			<p>
				Disposisi Surat:<br/>
				<!-- <span class="label label-xs label-primary label-white middle">
					<a href="./index.php?op=disposisiprint&smid=<?php echo $data_sm->id_sm;?>" target="_blank"><b>Lihat</b></a>
				</span> -->
				<span class="label label-xs label-danger label-white middle">
					<a href="./index.php?op=disposisiprint&smid=<?php echo $data_sm->id_sm;?>&act=pdf" target="_blank"><b>Cetak</b> <i class="ace-icon fa fa-file-pdf-o align-top bigger-125 icon-on-right"></i></a>
				</span>
			</p><?php
			}
			
			if(isset($_GET['act']) && $_GET['act'] == "disposisi"){
				if(isset($_GET['act2']) && $_GET['act2'] == "del"){
					$params = array(':id_status' => $id_status);
					$delete = $this->model->hapusprepare("memo", $field=null, $params, "id_status=:id_status");
					if($delete){
						//echo "<script type=\"text/javascript\">alert('Data Disposisi berhasil di Hapus...!!');window.location.href=\"$_SESSION[url]\";</script>";?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">
								<i class="ace-icon fa fa-times"></i>
							</button>
							<p>
								<strong><i class="ace-icon fa fa-check"></i>Sukses!</strong>
								Data Disposisi berhasil di Hapus.
							</p>
							<p>
								<a href="./index.php?op=sm&smid=<?php echo $data_sm->id_sm;?>"><button class="btn btn-sm btn-success">Kembali</button></a>
							</p>
						</div><?php
					}else{
						die("<script>alert('Gagal menghapus data disposisi, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
					}
				}else{
					if ($_SERVER["REQUEST_METHOD"] == "POST"){
						//print_r($_POST);
						$tgl = date("Y-m-d");
						$note = htmlspecialchars($purifier->purify(trim($_POST['note'])), ENT_QUOTES);
						$disposisi = htmlspecialchars($purifier->purify(trim($_POST['bagian'])), ENT_QUOTES);
						$tembusan = json_encode($_POST['tembusan']);
						if($cek_memo->rowCount() >= 1){
							$field = array('disposisi' => $disposisi, 'note' => $note, 'tembusan' => $tembusan);
							$params = array(':id_status' => $id_status);
							$update = $this->model->updateprepare("memo", $field, $params, "id_status=:id_status");
							if($update){
								//echo "<script type=\"text/javascript\">alert('Data Disposisi berhasil di Perbaharui...!!');window.location.href=\"./index.php?\";</script>";
								echo "<script type=\"text/javascript\">alert('Data Berhasil diperbaharui...!!');window.location.href=\"./index.php?op=sm&smid=$idsm\";</script>";
							}else{
								//die("<script>alert('Gagal memperbaharui data, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
							}
						}else{
							$field = array('id_user' => $_SESSION['id_user'], 'id_sm'=>$idsm, 'disposisi'=>$disposisi, 'note'=>$note, 'tembusan'=>$tembusan, 'tgl'=>$tgl);
							$params = array(':id_user' => $_SESSION['id_user'], ':id_sm'=>$idsm, ':disposisi'=>$disposisi, ':note'=>$note, ':tembusan'=>$tembusan, ':tgl'=>$tgl);
							$insert = $this->model->insertprepare("memo", $field, $params);
							if($update){
								echo "<script type=\"text/javascript\">alert('Data Disposisi berhasil disimpan...!!');window.location.href=\"$_SESSION[url]\";</script>";
							}else{
								die("<script>alert('Gagal menyimpan data disposisi, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
							}
						}
					}else{
						if($cek_memo->rowCount() >= 1){?>
							<a href="./index.php?op=sm&smid=<?php echo $data_sm->id_sm;?>&act=disposisi&act2=del"><button class="btn btn-danger btn-minier ">Hapus Disposisi <i class="ace-icon fa fa-trash align-center bigger-100 icon-on-right"></i></button></a><p></p><?php
						}?>
						<div class="widget-box">
							<div class="widget-header">
								<h4 class="widget-title"><?php echo $title;?></h4>
								<div class="widget-toolbar">
									<a href="#" data-action="collapse">
										<i class="ace-icon fa fa-chevron-up"></i>
									</a>
									<a href="#" data-action="close">
										<i class="ace-icon fa fa-times"></i>
									</a>
								</div>
							</div>
							<div class="widget-body">
								<div class="widget-main">
									<form class="form-horizontal" role="form" method="POST" name="formku" action="<?php echo $_SESSION['url'];?>">
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Disposisikan ke</label>
											<div class="col-sm-4">
												<select class="chosen-select form-control" id="form-field-select-3" name="bagian" data-placeholder="Pilih bagian..." required>
													<option value="">Pilih bagian...</option><?php
													foreach($dump_bagian as $key => $object){
														if($cek_memo->rowCount() >= 1){
															if($data_cek->id_sm == $object->id_bag){?>
																<option value="<?php echo $object->id_bag;?>" selected><?php echo $object->nama_bagian;?></option><?php
															}else{?>
																<option value="<?php echo $object->id_bag;?>"><?php echo $object->nama_bagian;?></option><?php
															}
														}else{?>
															<option value="<?php echo $object->id_bag;?>"><?php echo $object->nama_bagian;?></option><?php
														}
													}?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Catatan</label>
											<div class="col-sm-9"><?php
												if($cek_memo->rowCount() >= 1){?>
													<textarea class="form-control limited" placeholder="Catatan/keterangan disposisi surat" name="note" id="form-field-9" maxlength="150" required><?php echo $data_cek->note;?></textarea><?php
												}else{?>
													<textarea class="form-control limited" placeholder="Catatan/keterangan disposisi surat" name="note" id="form-field-9" maxlength="150" required></textarea><?php
												}?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tembusan ke</label>
											<div class="col-sm-4">											
												<select multiple="" class="chosen-select form-control" name="tembusan[]" id="form-field-select-3" data-placeholder="Pilih user..."><?php
													$Tembusan = $this->model->selectprepare("bagian", $field=null, $params=null, $where=null, "ORDER BY nama_bagian ASC");
													if($Tembusan->rowCount() >= 1){
														while($data_Tembusan = $Tembusan->fetch(PDO::FETCH_OBJ)){
															if(false !== array_search($data_Tembusan->id_bag, $cek_tembusan)){?>
																<option value="<?php echo $data_Tembusan->id_bag;?>" selected><?php echo $data_Tembusan->nama_bagian;?></option><?php
															}else{?>
																<option value="<?php echo $data_Tembusan->id_bag;?>"><?php echo $data_Tembusan->nama_bagian;?></option><?php
															}
														}								
													}else{?>
														<option value="">Not Found</option><?php
													}?>
												</select>
											</div>
										</div>
										<div class="clearfix form-actions">
											<div class="col-md-offset-3 col-md-9">
												<div class="col-sm-2">
													<button type="submit" class="btn btn-info" type="button">
														<i class="ace-icon fa fa-check bigger-110"></i>
														Submit
													</button>
												</div>
												&nbsp; &nbsp; &nbsp;
												<div class="col-sm-2">
												<button class="btn" type="reset">
													<i class="ace-icon fa fa-undo bigger-110"></i>
													Reset
												</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div><?php
					}
				}
			}else{?>
			<ul class="pager">
				<li class="previous">
					<a href="./berkas/<?php echo $data_sm->file;?>" target="_blank" class="btn btn-primary">Lihat Surat<i class="ace-icon fa fa-file-pdf-o align-top bigger-125 icon-on-right"></i></a>
				</li><?php
				if($cek_memo->rowCount() >= 1){ ?>
					<li class="next">
						<a href="./index.php?op=sm&smid=<?php echo $data_sm->id_sm;?>&act=disposisi" class="btn btn-success">Telah di-Disposisi ke: <b><?php echo $data_cek->nama_bagian;?></b><i class="ace-icon fa fa-pencil align-top bigger-125 icon-on-right"></i></a>
					</li><?php
				}else{ ?>
					<li class="next">
						<a href="./index.php?op=sm&smid=<?php echo $data_sm->id_sm;?>&act=disposisi" class="btn btn-danger">Disposisi<i class="ace-icon fa fa-share align-top bigger-125 icon-on-right"></i></a>
					</li><?php
				} ?>
			</ul><?php
			}?>
		</div>

	</div><?php
}else{?>
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">
			<i class="ace-icon fa fa-times"></i>
		</button>
		<p>
			<strong><i class="ace-icon fa fa-check"></i>Perhatian!</strong>
			Data Surat masuk tidak ditemukan. Terimakasih.
		</p>
		<p>
			<a href="./index.php?op=sm"><button class="btn btn-minier btn-danger">Kembali</button></a>
		</p>
	</div>
	
	
	
	
	
	<?php
}?>