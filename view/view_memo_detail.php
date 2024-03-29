<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "library/PHPMailer.php";
require_once "library/Exception.php";
require_once "library/OAuth.php";
require_once "library/POP3.php";
require_once "library/SMTP.php";

$params = array(':id_sm' => trim($_GET['memoid']));
$userLike = "'%\"$_SESSION[id_user]\"%'";
$memo = $this->model->selectprepare("arsip_sm", $field=null, $params, "id_sm=:id_sm", "AND tujuan_surat LIKE $userLike");
if($memo->rowCount() >= 1){
	$data_memo = $memo->fetch(PDO::FETCH_OBJ);
	$CekUser = $this->model->selectprepare("user", $field=null, $params=null, $where=null, "WHERE id_user = '$_SESSION[id_user]'");
	$DataUser = $CekUser->fetch(PDO::FETCH_OBJ);
	if(isset($DataUser->rule_disposisi) == '' OR $DataUser->rule_disposisi == "null"){
		$dummy_arr = '[""]';
		$RuleDisposisi = json_decode($dummy_arr, true);
	}else{
		$RuleDisposisi = json_decode($DataUser->rule_disposisi, true);
	}
	
	$tgl_memo = substr($data_memo->tgl_terima,0,10);
	$params = array(':id_user' => $_SESSION['id_user'], ':id_sm' => $data_memo->id_sm, ':kode' => 'SM');
	$lihat_sm = $this->model->selectprepare("surat_read", $field=null, $params, "id_sm=:id_sm AND id_user=:id_user AND kode=:kode");
	if($lihat_sm->rowCount() <= 0){
		$field = array('id_user' => $_SESSION['id_user'], 'id_sm' => $data_memo->id_sm, 'kode' => 'SM');
		$insert2 = $this->model->insertprepare("surat_read", $field, $params);
	}
	$params = array(':id_user' => $_SESSION['id_user'], ':id_sm' => $data_memo->id_sm);
	$cekDisposisi = $this->model->selectprepare("memo", $field=null, $params, "id_user=:id_user AND id_sm=:id_sm");
	$dataDisposisi= $cekDisposisi->fetch(PDO::FETCH_OBJ);
	
	if($cekDisposisi->rowCount() >= 1){
		if($dataDisposisi->tembusan == '' OR $dataDisposisi->tembusan == "null"){
			$dummy_arr = '[""]';
			$cekTembusan = json_decode($dummy_arr, true);
			//echo "dddd".$dataDisposisi->tembusan;
		}else{
			$cekTembusan = json_decode($dataDisposisi->tembusan, true);
		}
	}else{
		$dummy_arr = '[""]';
		$cekTembusan = json_decode($dummy_arr, true);
	}
	
	
	$ListUser = $this->model->selectprepare("user a join user_jabatan b on a.jabatan=b.id_jab", $field=null, $params=null, $where=null, "WHERE a.id_user != '$_SESSION[id_user]' ORDER BY a.nama ASC");
	while($dataListUser = $ListUser->fetch(PDO::FETCH_OBJ)){
		$dumpListUser[] = $dataListUser;
	}?>
	<div class="widget-box">
		
		<li class="list-group-item">
			<h6 class="card-title">Surat Masuk : <?php echo $data_memo->pengirim;?>, Ref: <?php echo $data_memo->custom_noagenda;?></h6>
			<img class="middle" alt="<?php echo $DataUser->nama;?>" src="assets/images/avatars/<?php echo $DataUser->picture;?>" width="32" />
			<a href="#" class="sender"><?php echo $DataUser->nama;?></a>
			<i class="ace-icon fa fa-clock-o text-warning"></i>
			<span class="time grey"><?php echo tgl_indo($tgl_memo);?></span>
		
			<hr>
		<div class="message-body">
			<p>
				Tgl terima/No agenda: <br/><b><?php echo tgl_indo($data_memo->tgl_terima);?> | <?php echo $data_memo->custom_noagenda;?></b>
			</p>
			<p class="mt-2">
				Dari: <br/><b><?php echo $data_memo->pengirim;?></b>
			</p>
			<p class="mt-2">
				Tgl/No surat: <br/><b><?php echo tgl_indo($data_memo->tgl_surat);?> | <?php echo $data_memo->no_sm;?></b>
			</p>
			<p class="mt-2">
				Perihal: <br/><b><?php echo $data_memo->perihal;?></b>
			</p>
			<?php
			if($data_memo->file != ''){?>
				<p class="mt-2">
					<a href="./berkas/<?php echo $data_memo->file;?>" target="_blank"><button class="btn btn-success btn-minier ">Lihat File Surat<i class="ace-icon fa fa-book align-top bigger-125 icon-on-right"></i></button></a>
				</p><?php
			}?>
			<p class="mt-2">
				Detail Surat:<br/>
				<!-- <span class="label label-xs label-primary label-white middle">
					<a href="./index.php?op=memoprint&memoid=<?php echo $data_memo->id_sm;?>" target="_blank"><b>Lihat</b></a>
				</span> -->
				<span class="label label-xs label-danger label-white middle">
					<a href="./index.php?op=memoprint&memoid=<?php echo $data_memo->id_sm;?>&act=pdf" target="_blank"><b>Lihat / Cetak</b> <i class="ace-icon fa fa-file-pdf-o align-top bigger-125 icon-on-right"></i></a>
				</span>
			</p>
			<hr/>
			<p>
				<a href="./index.php?op=memo&memoid=<?php echo $data_memo->id_sm;?>&act=progres"><button class="btn btn-primary btn-minier ">ENTRI PROGRESS SURAT <i class="ace-icon fa fa-arrow-right align-center bigger-100 icon-on-right"></i></button></a>
			</p><?php
			$params = array(':id_sm' => $data_memo->id_sm);
			$StatSurat = $this->model->selectprepare("status_surat a join user b on a.id_user=b.id_user", $field=null, $params, "a.id_sm=:id_sm", "ORDER BY a.id_status DESC");
			if($StatSurat->rowCount() >= 1){?>
				<div class="widget-body">
					<div class="widget-main padding-0">
						<div id="profile-feed-1" class="profile-feed">
						
						</div>
					</div>
				</div><?php
				$no=1;
				while($dataStatSurat= $StatSurat->fetch(PDO::FETCH_OBJ)){?>
					<div class="profile-activity clearfix"><?php
						if($no == 1){?>
							<b>PROGRES SURAT</b><?php
						}
						if($dataStatSurat->statsurat == 1){
							$statusSirat = "Sedang diproses";
						}elseif($dataStatSurat->statsurat == 2){
							$statusSirat = "Selesai";
						}elseif($dataStatSurat->statsurat == 0){
							$statusSirat = "Dibatalkan";
						}?>
						<div>
							<a class="user" href="#"><?php echo $dataStatSurat->nama; ?></a>
							update status surat : <span class="text-primary"><?php echo $statusSirat; ?></span><?php
							if($dataStatSurat->ket !==''){?>
								<?php echo '('.$dataStatSurat->ket .')';
								if($dataStatSurat->file_progress != ''){ ?>							
									&nbsp;<a href="./berkas/<?php echo $dataStatSurat->file_progress;?>" title="Dokumen Pendukung" target="_blank"><i class="ace-icon fa fa-file-pdf-o align-top bigger-125 icon-on-right"></i></a> <?php
								}
							}?>
							<div class="time">
								<?php echo tgl_indo1($dataStatSurat->created);?>, <?php echo substr($dataStatSurat->created,-9,-3);?> WIB
							</div>
						</div><?php
						if($dataStatSurat->id_user == $_SESSION['id_user']){?>
							<div class="tools action-buttons">
								<a href="./index.php?op=memo&memoid=<?php echo $data_memo->id_sm;?>&act=progres&id=<?php echo $dataStatSurat->id_status;?>" class="blue">
									<i class="fa fa-pencil"></i>
								</a>
								<a href="./index.php?op=memo&memoid=<?php echo $data_memo->id_sm;?>&act=progres&id=<?php echo $dataStatSurat->id_status;?>&do=delete" class="red">
									<i class="fa fa-times"></i>
								</a>
							</div><?php
						}?>
					</div>	
					<?php
				$no++;
				}
			}		
			if(isset($_GET['act']) && $_GET['act'] == "progres"){
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					$tgl = date("Y-m-d H:i:s", time());
					$progres = htmlspecialchars($purifier->purify(trim($_POST['progres'])), ENT_QUOTES);
					$file_progres_old = htmlspecialchars($purifier->purify(trim($_POST['file_progres_old'])), ENT_QUOTES);
					$ket = htmlspecialchars($purifier->purify(trim($_POST['ket'])), ENT_QUOTES);
					$fileName = htmlspecialchars($_FILES['file_progres']['name'], ENT_QUOTES);
					$tipefile = pathinfo($fileName,PATHINFO_EXTENSION);
					$extensionList = array("pdf","jpg","jpeg","png","PNG", "JPG", "JPEG","PDF");
					$namaDir = 'berkas/';
					$file_progress = $namaDir."Progress"."_".$data_memo->id_sm."_".$_SESSION['id_user']."_". date("d-m-Y_H-i-s", time()) .".".$tipefile;
					if(empty($fileName)){
						$filedb = "";
					}else{
						$filedb = "Progress"."_".$data_memo->id_sm."_".$_SESSION['id_user']."_". date("d-m-Y_H-i-s", time()) .".".$tipefile;
						if(in_array($tipefile, $extensionList)){
							move_uploaded_file($_FILES['file_progres']['tmp_name'], $file_progress);
							$field1 = array('file_progress' => $filedb);
							$params1 = array(':file_progress' => $filedb);
						}else{
							echo "<script type=\"text/javascript\">alert('File gagal di Upload, Format file tidak di dukung!!!');window.history.go(-1);</script>";
						}
					}

					if(isset($_GET['id'])){
						$id = htmlspecialchars($purifier->purify(trim($_GET['id'])), ENT_QUOTES);
						$params2 = array(':id_status' => $id, ':id_sm' => $data_memo->id_sm, ':id_user' => $_SESSION['id_user']);
						if(isset($params1)){
							@unlink($namaDir.$file_progres_old);
							$params = array_merge($params2,$params1);
						}
						$CekStatSurat = $this->model->selectprepare("status_surat", $field=null, $params2, "id_status=:id_status AND id_sm=:id_sm AND id_user=:id_user");
						if($CekStatSurat->rowCount() >= 1){
							$field = array('statsurat' => $progres, 'ket' => $ket);
							if(isset($field1)){
								$field = array_merge($field,$field1);
							}
							//$params = array(':id_sm' => $data_memo->id_sm, ':statsurat' => $progres, ':id_user' => $_SESSION['id_user'], ':ket' => $ket, ':created' => $tgl);
							$update = $this->model->updateprepare("status_surat", $field, $params2, "id_status=:id_status AND id_sm=:id_sm AND id_user=:id_user");
							if($update){
								echo "<script type=\"text/javascript\">alert('Data Berhasil diperbaharui...!!');window.location.href=\"./index.php?op=memo&memoid=$data_memo->id_sm\";</script>";
							}else{
								die("<script>alert('Data menyimpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
							}
						}
					}else{							
						$field = array('id_sm' => $data_memo->id_sm, 'statsurat' => $progres, 'id_user' => $_SESSION['id_user'], 'ket' => $ket, 'created' => $tgl);
						if(isset($field1)){
							$field = array_merge($field,$field1);
						}
						$params = array(':id_sm' => $data_memo->id_sm, ':statsurat' => $progres, ':id_user' => $_SESSION['id_user'], ':ket' => $ket, ':created' => $tgl);
						if(isset($params1)){
							$params = array_merge($params,$params1);
						}
						$insert = $this->model->insertprepare("status_surat", $field, $params);
						if($insert){
							echo "<script type=\"text/javascript\">alert('Data Berhasil disimpan...!!');window.location.href=\"./index.php?op=memo&memoid=$data_memo->id_sm\";</script>";
						}else{
							die("<script>alert('Data menyimpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
						}
					}
					//print_r($_POST);
				}else{
					if(isset($_GET['id'])){
						$id = htmlspecialchars($purifier->purify(trim($_GET['id'])), ENT_QUOTES);
						$params1 = array(':id_status' => $id, ':id_sm' => $data_memo->id_sm, ':id_user' => $_SESSION['id_user']);
						$CekStatSurat = $this->model->selectprepare("status_surat", $field=null, $params1, "id_status=:id_status AND id_sm=:id_sm AND id_user=:id_user");
						if($CekStatSurat->rowCount() >= 1){
							$dataCekStatSurat= $CekStatSurat->fetch(PDO::FETCH_OBJ);
							$DbStatProgres = $dataCekStatSurat->statsurat;
							$dbKetProgres =  $dataCekStatSurat->ket;
							$db_file_progress =  $dataCekStatSurat->file_progress;
						}
						$title = "EDIT PROGRES SURAT";
					}else{
						$title = "ISI PROGRES SURAT";
					}
					if(isset($_GET['id']) AND isset($_GET['do']) AND $_GET['do'] == "delete"){
						$id = htmlspecialchars($purifier->purify(trim($_GET['id'])), ENT_QUOTES);
						$params1 = array(':id_status' => $id, ':id_sm' => $data_memo->id_sm, ':id_user' => $_SESSION['id_user']);
						$CekStatSurat = $this->model->selectprepare("status_surat", $field=null, $params1, "id_status=:id_status AND id_sm=:id_sm AND id_user=:id_user");
						if($CekStatSurat->rowCount() >= 1){
							$show_Data = $CekStatSurat->fetch(PDO::FETCH_OBJ);
							$params1 = array(':id_sm' => $data_memo->id_sm, ':statsurat' => 2);
							$CekStatFinish = $this->model->selectprepare("status_surat", $field=null, $params1, "id_sm=:id_sm AND statsurat=:statsurat");
							if($CekStatFinish->rowCount() >= 1){?>
								<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
									<p>
										<strong><i class="ace-icon fa fa-check"></i>Perhatian!</strong>
										Anda tidak dapat menghapus progress surat karena progress surat sudah berstaus selesai.
									</p>
								</div><?php									
							}else{
								if($show_Data->file_progress != ''){
									@unlink('berkas/'.$show_Data->file_progress);
								}
								$params3 = array(':id_status' => $id);
								$delete = $this->model->hapusprepare("status_surat", $params3, "id_status=:id_status");
								if($delete){
									echo "<script type=\"text/javascript\">alert('Data Berhasil dihapus...!!');window.location.href=\"./index.php?op=memo&memoid=$data_memo->id_sm\";</script>";
								}else{
									die("<script>alert('Data gagal dihapus, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
								}
							}
						}else{?>
							<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert">
									<i class="ace-icon fa fa-times"></i>
								</button>
								<p>
									<strong><i class="ace-icon fa fa-check"></i>Perhatian!</strong>
									Anda hanya dibolehkan menghapus progress yang anda entri
								</p>
							</div><?php
						}
					}else{?>
						<hr/>
						<form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" name="formku" action="<?php echo $_SESSION['url'];?>">
							<label for="form-field-1"> <b><?php echo $title;?></b></label> <?php
							if(isset($db_file_progress) && $db_file_progress != ''){ ?>
								<input type="hidden" name="file_progres_old" value="<?php echo $db_file_progress;?>"/> <?php
							} ?>							
							<div class="form-group">
								<div class="col-sm-6">
									<select class="form-control" id="form-field-select-3" name="progres" data-placeholder="Pilih Progres..." required>
										<option value="">Pilih Progres...</option><?php
										$ArrStatProgres = array("Sedang diproses" => 1, "Selesai" => 2, "Dibatalkan" => 0);
										foreach($ArrStatProgres as $field => $value){
											if(isset($DbStatProgres) AND $DbStatProgres == $value){?>
												<option value="<?php echo $value;?>" selected><?php echo $field;?></option><?php
											}else{?>
												<option value="<?php echo $value;?>"><?php echo $field;?> </option><?php
											}
										}?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<textarea class="form-control limited" placeholder="Keterangan progress" name="ket" id="form-field-9" maxlength="150" required><?php if(isset($dbKetProgres)){ echo $dbKetProgres;}?></textarea>
								</div>
							</div>
							<div class="col-md-6 stretch-card">
								<div class="card">
									<div class="card-body">
										<!-- <h6 class="card-title">Dropify</h6> -->
										<p class="card-description">Lampirkan file.</p>
										<input type="file" id="myDropify" name="file_progres" class="border" required/>
									</div>
								</div>
							</div>
							<!-- <div class="form-group">
								<div class="col-sm-4">
									<input class="form-control" type="file" name="file_progres" id="id-input-file-1" />
								</div>
							</div> -->
							<div class="form-group mt-3">
								<div class="col-sm-2">
									<button class="btn btn-primary">
										Submit <i class="fa fa-arrow-right"></i>
									</button>
								</div>
							</div>
						</form>
						<hr/><?php
					}
				}
			}
			/*End Feedback Surat*/
			?>
			<p></p><?php
			if($cekDisposisi->rowCount() >= 1){
				$ListDisposisi = json_decode($dataDisposisi->disposisi, true);?>
				<p>
				<hr/><b>SURAT SUDAH DI DISPOSISI KE:</b><br/><?php
					foreach($ListDisposisi as $listdispo){
						$TampilUser = $this->model->selectprepare("user", $field=null, $params=null, $where=null, "WHERE id_user='$listdispo'")->fetch(PDO::FETCH_OBJ); ?>
						<span class="label label-xs label-primary label-white middle">
							<a href="./index.php?op=disposisiprint&smid=<?php echo $data_memo->id_sm;?>&iduser=<?php echo $TampilUser->id_user; ?>&dispo=<?php echo $dataDisposisi->id_user;?>" target="_blank"><b>Lihat</b></a>
						</span>
						<span class="label label-xs label-danger label-white middle">
							<a href="./index.php?op=disposisiprint&smid=<?php echo $data_memo->id_sm;?>&iduser=<?php echo $TampilUser->id_user; ?>&dispo=<?php echo $dataDisposisi->id_user;?>&act=pdf" target="_blank"><b>Cetak</b> <i class="ace-icon fa fa-file-pdf-o align-top bigger-125 icon-on-right"></i></a>
						</span> (<?php echo $TampilUser->nama;?>)<br/><?php
					}?>
				</p>
				<hr/><?php
			}
			if(isset($_GET['act']) && $_GET['act'] == "disposisi"){
				if(isset($_GET['act2']) && $_GET['act2'] == "del"){
					$params = array(':id_status' => $id_status);
					$delete = $this->model->hapusprepare("memo", $field=null, $params, "id_status=:id_status");
					if($delete){
						echo "<script type=\"text/javascript\">window.location.href = document.referrer;</script>";
					}
				}
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					$tgl = date("Y-m-d H:i:s", time());
					$tgl_memo = substr($tgl,0,10);
					$note = htmlspecialchars($purifier->purify(trim($_POST['note'])), ENT_QUOTES);
					$tujuan = json_encode($_POST['tujuan']);
					$tembusan = json_encode($_POST['tembusan']);
					if($cekDisposisi->rowCount() >= 1){
						$field = array('disposisi' => $tujuan, 'note' => $note, 'tembusan' => $tembusan);
						$params = array(':id_status' => $dataDisposisi->id_status);
						$update = $this->model->updateprepare("memo", $field, $params, "id_status=:id_status");
						if($update){
							echo "<script type=\"text/javascript\">alert('Data Disposisi berhasil diperbaharui...!!');window.location.href=\"$_SESSION[url]\";</script>";
						}else{
							die("<script>alert('Gagal memperbaharui data, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
						}
					}else{
						$field = array('id_user' => $_SESSION['id_user'], 'id_sm' => $data_memo->id_sm, 'disposisi' => $tujuan, 'note' => $note, 'tembusan' => $tembusan, 'tgl' => $tgl);
						$params = array(':id_user' => $_SESSION['id_user'], ':id_sm' => $data_memo->id_sm, ':disposisi' => $tujuan, ':note'=>$note, ':tgl' => $tgl);
						$insert = $this->model->insertprepare("memo", $field, $params);
						if($insert){
							//Kirim Email
							$EmailAccount = $this->model->selectprepare("pengaturan", $field=null, $params=null, $where=null, "WHERE id='1' AND email !='' AND pass_email !=''");
							$AktifEmail = $this->model->selectprepare("email_setting", $field=null, $params=null, $where=null, "WHERE id_kop='3' AND status='Y'");
							
							$AktifEmai2 = $this->model->selectprepare("email_setting", $field=null, $params=null, $where=null, "WHERE id_kop='1' AND status='Y'");
							if($EmailAccount->rowCount() >= 1 AND $AktifEmail->rowCount() >= 1){
								$dataEmailAccount = $EmailAccount->fetch(PDO::FETCH_OBJ);
								$dataAktifEmail = $AktifEmail->fetch(PDO::FETCH_OBJ);
								$dataAktifEmail2 = $AktifEmai2->fetch(PDO::FETCH_OBJ);
								
								$TujuanSurat = "";
								$TargetDisposisi = "";
								$DataTembusanVer = "";
								$DataTembusanHor = "";
								if($tujuan != ''){
									$ListUser = $this->model->selectprepare("user a join user_jabatan b on a.jabatan=b.id_jab", $field=null, $params=null, $where=null, "ORDER BY a.nama ASC");
									while($dataListUser = $ListUser->fetch(PDO::FETCH_OBJ)){
										if(is_array(json_decode($data_memo->tujuan_surat))){
											if(false !== array_search($dataListUser->id_user, json_decode($data_memo->tujuan_surat, true))){
												$TujuanSurat .= '- '.$dataListUser->nama .' ('.$dataListUser->nama_jabatan .')<br/>';
											}
										}
										if(is_array($_POST['tujuan'])){
											if(false !== array_search($dataListUser->id_user, json_decode($tujuan, true))){
												$TargetDisposisi .= '- '.$dataListUser->nama .' ('.$dataListUser->nama_jabatan .')<br/>';
											}
										}
										if(is_array($_POST['tembusan'])){
											if(false !== array_search($dataListUser->id_user, json_decode($tembusan, true))){
												$DataTembusanVer .= '- '.$dataListUser->nama .' ('.$dataListUser->nama_jabatan .')<br/>';
												$DataTembusanHor .='- '.$dataListUser->nama .' ('.$dataListUser->nama_jabatan .'), ';
											}
										}
									}
								}
					
								$isi = $dataAktifEmail->layout;
								$Rlayout = $isi;
								
								$isi2 = $dataAktifEmail2->layout;
								$Rlayout2 = $isi2;
								
								$arr = array("=NoAgenda=" => $data_memo->custom_noagenda, "=NoSurat=" => $data_memo->no_sm, "=Perihal=" => $data_memo->perihal, "=Disposisi=" => $TargetDisposisi, "=TglSurat=" =>tgl_indo($data_memo->tgl_surat), "=TglTerima=" => tgl_indo($data_memo->tgl_terima), "=AsalSurat=" =>$data_memo->pengirim, "=Keterangan=" => $data_memo->ket, "=DisposisiOleh=" =>$_SESSION['nama'], "=NoteDisposisi=" => $note, "=TglDisposisi=" =>tgl_indo($tgl_memo), "=TembusanH=" => $DataTembusanHor, "=TembusanV=" => $DataTembusanVer, "=TujuanSurat=" => $TujuanSurat);
								foreach($arr as $nama => $value){
									if(strpos($isi, $nama) !== false) {
										$Rlayout = str_replace($nama, $value, $isi);
										$isi = $Rlayout;
									}
								}
								
								$arr2 = array("=NoAgenda=" => $data_memo->custom_noagenda, "=NoSurat=" => $data_memo->no_sm, "=Perihal=" => $data_memo->perihal, "=Disposisi=" => $TargetDisposisi, "=TglSurat=" =>tgl_indo($data_memo->tgl_surat), "=TglTerima=" => tgl_indo($data_memo->tgl_terima), "=AsalSurat=" =>$data_memo->pengirim, "=Keterangan=" => $data_memo->ket, "=DisposisiOleh=" =>$_SESSION['nama'], "=NoteDisposisi=" => $note, "=TglDisposisi=" =>tgl_indo($tgl_memo), "=TembusanH=" => $DataTembusanHor, "=TembusanV=" => $DataTembusanVer, "=TujuanSurat=" => $TujuanSurat);
								foreach($arr2 as $nama2 => $value2){
									if(strpos($isi2, $nama2) !== false) {
										$Rlayout2 = str_replace($nama2, $value2, $isi2);
										$isi2 = $Rlayout2;
									}
								}
								
								if(is_array($_POST['tujuan'])){
									$mail = new PHPMailer;
									$mail->SMTPDebug = 0;                               
									$mail->isSMTP();                                 
									$mail->Host = "tls://smtp.gmail.com";
									$mail->SMTPAuth = true;  
									$mail->Username = $dataEmailAccount->email;
									$mail->Password = $dataEmailAccount->pass_email;  
									$mail->SMTPSecure = "tls";                           
									$mail->Port = 587;                                   
									$mail->From = $dataEmailAccount->email;
									$mail->FromName = $_SESSION['nama'];
									// $mail->smtpConnect(
									// 	array(
									// 		"ssl" => array(
									// 			"verify_peer" => false,
									// 			"verify_peer_name" => false,
									// 			"allow_self_signed" => true
									// 		)
									// 	)
									// );
									$dataTujuan = json_decode($tujuan, true);
									foreach($dataTujuan as $id_tujuan){
										$params = array(':id_user' => $id_tujuan);
										$user_tujuan = $this->model->selectprepare("user", $field=null, $params, "id_user=:id_user", $other=null);
										$data_user_tujuan= $user_tujuan->fetch(PDO::FETCH_OBJ);
										if($data_user_tujuan->email != ''){
											$mail->addAddress($data_user_tujuan->email, $data_user_tujuan->nama);
										}
									}
									$mail->isHTML(true);
									$topik = "Disposisi Surat : ".$data_memo->perihal;
									$mail->Subject = $topik;
									$mail->Body = $isi;
									$mail->AltBody = $data_memo->perihal;
									$lokasi = "berkas/$data_memo->file";
									if(file_exists($lokasi)){
										$mail->addAttachment($lokasi);
									}
									if(!$mail->send()) {
										//echo "Mailer Error: " . $mail->ErrorInfo;
										echo "<script type=\"text/javascript\">alert('Data Berhasil diSimpan. Email notifikasi gagal dikirim!');window.location.href=\"./index.php?op=add_sm\";</script>";
									}else{
										if(is_array($_POST['tembusan'])){
											$mail = new PHPMailer;
											$mail->SMTPDebug = 0;                               
											$mail->isSMTP();                                 
											$mail->Host = "tls://smtp.gmail.com";
											$mail->SMTPAuth = true;  
											$mail->Username = $dataEmailAccount->email;
											$mail->Password = $dataEmailAccount->pass_email;
											$mail->SMTPSecure = "tls";                           
											$mail->Port = 587;                                   
											$mail->From = $dataEmailAccount->email;
											$mail->FromName = $_SESSION['nama'];
											// $mail->smtpConnect(
											// 	array(
											// 		"ssl" => array(
											// 			"verify_peer" => false,
											// 			"verify_peer_name" => false,
											// 			"allow_self_signed" => true
											// 		)
											// 	)
											// );
											$dataTembusan = json_decode($tembusan, true);
											foreach($dataTembusan as $id_tembusan){
												$params = array(':id_user' => $id_tembusan);
												$user_tujuan = $this->model->selectprepare("user", $field=null, $params, "id_user=:id_user", $other=null);
												$data_user_tujuan= $user_tujuan->fetch(PDO::FETCH_OBJ);
												if($data_user_tujuan->email != ''){
													$mail->addAddress($data_user_tujuan->email, $data_user_tujuan->nama);
												}
											}
											$mail->isHTML(true);
											$topik = "Tembusan Surat: ".$data_memo->perihal;
											$mail->Subject = $topik;
											$mail->Body = $isi2;
											$mail->AltBody = $data_memo->perihal;
											$lokasi = "berkas/$data_memo->file";
											if(file_exists($lokasi)){
												$mail->addAttachment($lokasi);
											}
											if(!$mail->send()) {
												//echo "Mailer Error: " . $mail->ErrorInfo;
												echo "<script type=\"text/javascript\">alert('Data Disposisi Berhasil diSimpan. Email notifikasi gagal dikirim!');window.location.href=\"$_SESSION[url]\";</script>";
											}else{
												echo "<script type=\"text/javascript\">alert('Data Disposisi Berhasil diSimpan, Email notifikasi dikirim!');window.location.href=\"$_SESSION[url]\";</script>";
											}
										}
										//echo "<script type=\"text/javascript\">alert('Data Berhasil diSimpan, Email notifikasi dikirim!');window.location.href=\"./index.php?op=add_sm\";</script>";
									}
								}
							}
							//echo "<script type=\"text/javascript\">alert('Data Disposisi berhasil disimpan...!!');window.location.href=\"$_SESSION[url]\";</script>";
						}else{
							die("<script>alert('Gagal menyimpan data disposisi, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
						}
					}
				}else{
					if($cekDisposisi->rowCount() >= 1){?>
						<a href="./index.php?op=memo&memoid=<?php echo $data_memo->id_sm;?>&act=disposisi&act2=del" onclick="return confirm('Anda yakin akan menghapus data disposisi ini??')"><button class="btn btn-danger btn-minier ">Hapus Disposisi <i class="ace-icon fa fa-trash align-center bigger-100 icon-on-right"></i></button></a><p></p><?php
					}?>
					<div class="widget-box">
						<div class="widget-header">
							<h5 class="widget-title mt-3">Disposisi Surat</h5>
						</div>
						<div class="widget-body">
							<div class="widget-main">
								<form class="form-horizontal" role="form" method="POST" name="formku" action="<?php echo $_SESSION['url'];?>">
									<div class="form-group mt-3">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Disposisikan ke</label>
										<div class="col-sm-6">
											<select multiple="multiple" class="js-example-basic-multiple form-control" name="tujuan[]" id="form-field-mask-1" data-placeholder="Pilih user..." required>
												<!-- <option value="">Pilih</option> -->
											<?php
											foreach($dumpListUser as $key => $object){
												if(false !== array_search($object->id_user, $RuleDisposisi)){
													if($cekDisposisi->rowCount() >= 1){
														if(isset($dataDisposisi->disposisi) == '' OR $dataDisposisi->disposisi == "null"){
															$dummy_arr = '[""]';
															$TujuanDisposisi = json_decode($dummy_arr, true);
														}else{
															$TujuanDisposisi = json_decode($dataDisposisi->disposisi, true);
														}
														if(false !== array_search($object->id_user, $TujuanDisposisi)){?>
															<option value="<?php echo $object->id_user;?>" selected><?php echo $object->nama;?></option><?php
														}else{?>
															<option value="<?php echo $object->id_user;?>"><?php echo $object->nama;?></option><?php															
														}
													}else{?>
														<option value="<?php echo $object->id_user;?>"><?php echo $object->nama;?></option><?php
													}
												}
											}?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-mask-1"> Tembusan</label>
										<div class="col-sm-8">
											<div class="space-2"></div>
											<select multiple="multiple" class="js-example-basic-multiple form-control" name="tembusan[]" id="form-field-select-3" data-placeholder="Pilih user..."><?php
												$Ditembuskan = $this->model->selectprepare("user a join user_jabatan b on a.jabatan=b.id_jab", $field=null, $params=null, $where=null, "ORDER BY a.nama ASC");
												if($Ditembuskan->rowCount() >= 1){
													while($dataTembusan = $Ditembuskan->fetch(PDO::FETCH_OBJ)){
														$DitembuskanSurat = $dataTembusan->nama ." (".$dataTembusan->nama_jabatan .")";
														if(false !== array_search($dataTembusan->id_user, $cekTembusan)){?>
															<option value="<?php echo $dataTembusan->id_user;?>" selected><?php echo $DitembuskanSurat;?></option><?php
														}else{?>
															<option value="<?php echo $dataTembusan->id_user;?>"><?php echo $DitembuskanSurat;?></option><?php
														}
													}								
												}else{?>
													<option value="">Not Found</option><?php
												}?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Catatan</label>
										<div class="col-sm-7">
											<textarea class="form-control limited" placeholder="Catatan/keterangan disposisi surat" name="note" id="form-field-9" maxlength="450" required><?php if(isset($dataDisposisi->note)){ echo $dataDisposisi->note; }?></textarea>
										</div>
									</div>
									<div class="clearfix form-actions">
										<div class="col-md-offset-1 col-md-9">
											<div class="col-sm-2">
												<button type="submit" class="btn btn-info" type="button">
													<i class="ace-icon fa fa-check bigger-110"></i>
													Submit
												</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div><?php
				}
			}else{?>
				<ul class="pagination mt-2">
					<!-- <li class="page-item mr-1">
						<a href="./index.php?op=add_sm&smid=<?php echo $data_memo->id_sm;?>" class="btn btn-danger">Edit Surat <i class="fa fa-pencil"></i></a>
					</li>  -->
					<?php
					if($cekDisposisi->rowCount() >= 1){?>
						<li class="page-item"><a href="./index.php?op=memo&memoid=<?php echo $data_memo->id_sm;?>&act=disposisi" class="btn btn-success">Telah di-Disposisi<i class="fa fa-pencil"></i></a>
						</li><?php
					}else{?>
						<li class="page-item"><a href="./index.php?op=memo&memoid=<?php echo $data_memo->id_sm;?>&act=disposisi" class="btn btn-danger">Disposisi <i class="fa fa-share"></i></a>
						</li><?php
					}?>
				</ul><?php
			}?>
		</div>
		</li>

	</div><?php
}else{?>
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">
			<i class="ace-icon fa fa-times"></i>
		</button>
		<p>
			<strong><i class="ace-icon fa fa-check"></i>Perhatian!!!</strong>
			Belum ada data. Terimakasih.
		</p>
	</div><?php	
}
?>