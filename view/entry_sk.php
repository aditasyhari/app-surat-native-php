<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "library/PHPMailer.php";
require_once "library/Exception.php";
require_once "library/OAuth.php";
require_once "library/POP3.php";
require_once "library/SMTP.php";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$noagenda = htmlspecialchars($purifier->purify(trim($_POST['noagenda'])), ENT_QUOTES);
	$noagenda_custom = trim($_POST['noagenda_custom']);
	$nosk = htmlspecialchars($purifier->purify(trim($_POST['nosk'])), ENT_QUOTES);
	$tglsk = $_POST['tglsk'];
	// $tglsk = htmlspecialchars($purifier->purify(trim($_POST['tglsk'])), ENT_QUOTES);
	// $tglsk = explode("-",$tglsk);
	// $tglskdb = $tglsk[2]."-".$tglsk[1]."-".$tglsk[0];
	$pengolah = htmlspecialchars($purifier->purify(trim($_POST['pengolah'])), ENT_QUOTES);
	$klasifikasi = htmlspecialchars($purifier->purify(trim($_POST['id_klasifikasi'])), ENT_QUOTES);
	$tujuan = htmlspecialchars($purifier->purify(trim($_POST['tujuan'])), ENT_QUOTES);
	$email_tujuan = json_encode($_POST['email_tujuan']);
	$perihal = htmlspecialchars($purifier->purify(trim($_POST['perihal'])), ENT_QUOTES);
	$ket = htmlspecialchars($purifier->purify(trim($_POST['ket'])), ENT_QUOTES);
	
	$fileName = htmlspecialchars($_FILES['filesk']['name'], ENT_QUOTES);
	$tipefile = pathinfo($fileName,PATHINFO_EXTENSION);
	$extensionList = array("pdf","jpg","jpeg","png","PNG", "JPG", "JPEG","PDF");
	$namaDir = 'berkas/';
	$filesk = $namaDir."SK"."_".$tglsk."_". slugify($perihal)."_". date("d-m-Y_H-i-s", time()) .".".$tipefile;
	// $filesk = $namaDir."SK"."_".$tglskdb."_". slugify($perihal)."_". date("d-m-Y_H-i-s", time()) .".".$tipefile;
	if(empty($fileName)){
		$filedb = "";
	}else{
		$filedb = "SK"."_".$tglsk."_". slugify($perihal)."_". date("d-m-Y_H-i-s", time()) .".".$tipefile;
	}
	$tgl_upload = date("Y-m-d H:i:s", time());
	
	//echo "$filesk <br/>";
	//print_r($_POST);
	if(isset($_GET['skid'])){
		$skid = htmlspecialchars($purifier->purify(trim($_GET['skid'])), ENT_QUOTES);
		$params = array(':id_sk' => $skid);
		$lihat_sk = $this->model->selectprepare("arsip_sk", $field=null, $params, "id_sk=:id_sk");
		if($lihat_sk->rowCount() >= 1){
			$data_lihat_sk = $lihat_sk->fetch(PDO::FETCH_OBJ);
			$idsk = $data_lihat_sk->id_sk;
			if(empty($fileName)){
				//echo "No Update File";
				$field = array('no_sk' => $nosk, 'tgl_surat' => $tglsk, 'pengolah' => $pengolah, 'tujuan_surat' => $tujuan, 'perihal' => $perihal, 'ket' => $ket);
			}else{
				//if(in_array($tipefile, $extensionList)){
					@unlink($namaDir.$data_lihat_sk->file);
					$field = array('no_sk' => $nosk, 'tgl_surat' => $tglsk, 'pengolah' => $pengolah, 'tujuan_surat' => $tujuan, 'perihal' => $perihal, 'ket' => $ket, 'file' => $filedb);
					move_uploaded_file($_FILES['filesk']['tmp_name'], $filesk);
				/*}else{
					echo "<script type=\"text/javascript\">alert('File gagal di Upload, Format file tidak di dukung!!!');window.location.href=\"./index.php?op=add_sk&skid=$idsk\";</script>";
				}*/
			}
			$params = array(':id_sk' => $idsk);
			$update = $this->model->updateprepare("arsip_sk", $field, $params, "id_sk=:id_sk");
			if($update){
				echo "<script type=\"text/javascript\">alert('Data Berhasil diperbaharui...!!');window.location.href=\"./index.php?op=sk&skid=$idsk\";</script>";
			}else{
				die("<script>alert('Data menyimpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
			}
		}
	}else{
		$params = array(':no_sk' => $nosk);
		$cek_nosk = $this->model->selectprepare("arsip_sk", $field=null, $params, "no_sk=:no_sk");
		if($cek_nosk->rowCount() <= 0){
			$field = array('id_user' => $_SESSION['id_user'], 'no_sk'=>$nosk, 'klasifikasi' => $klasifikasi, 'tgl_surat'=>$tglsk, 'pengolah'=>$pengolah, 'tujuan_surat'=>$tujuan, 'perihal'=>$perihal, 'no_agenda' => $noagenda, 'custom_noagenda' => $noagenda_custom, 'ket'=>$ket, 'file'=>$filedb, 'created'=>$tgl_upload);
			$params = array(':id_user' => $_SESSION['id_user'], ':no_sk'=>$nosk, ':klasifikasi' => $klasifikasi, ':tgl_surat'=>$tglsk, ':pengolah'=>$pengolah, ':tujuan_surat'=>$tujuan, ':perihal'=>$perihal, ':no_agenda' => $noagenda, ':custom_noagenda' => $noagenda_custom, ':ket'=>$ket, ':file'=>$filedb, ':created'=>$tgl_upload);
			if(empty($fileName)){
				$insert = $this->model->insertprepare("arsip_sk", $field, $params);
				
				if($insert->rowCount() >= 1){
					//Kirim Email
					$EmailAccount = $this->model->selectprepare("pengaturan", $field=null, $params=null, $where=null, "WHERE id='1' AND email !='' AND pass_email !=''");
					$AktifEmail = $this->model->selectprepare("email_setting", $field=null, $params=null, $where=null, "WHERE id_kop='2' AND status='Y'");
					if($EmailAccount->rowCount() >= 1 AND $AktifEmail->rowCount() >= 1){
						$dataEmailAccount = $EmailAccount->fetch(PDO::FETCH_OBJ);
						$dataAktifEmail = $AktifEmail->fetch(PDO::FETCH_OBJ);
						
						$dataTujuan = json_decode($email_tujuan, true);

						$isi = $dataAktifEmail->layout;
						$Rlayout = $isi;
						$arr = array("=NoAgenda=" =>$noagenda_custom, "=NoSurat=" => $nosk, "=Perihal=" => $perihal, "=TujuanSurat=" => $tujuan, "=TglSurat=" => tgl_indo($tglsk), "=TglTerima=" => '-', "=AsalSurat=" =>$_SESSION['nama'], "=Keterangan=" => $ket);
						foreach($arr as $nama => $value){
							if(strpos($isi, $nama) !== false) {
								$Rlayout = str_replace($nama, $value, $isi);
								$isi = $Rlayout;
							}
						}
						
						if(isset($_POST['email_tujuan'])){
							$mail = new PHPMailer;
							$mail->isSMTP();
							$mail->SMTPDebug = 0;
							$mail->Debugoutput = 'html';
							$mail->Host = 'smtp.gmail.com';
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

							while (list ($key, $val) = each ($dataTujuan)) {
								$mail->addAddress($val);
							}

							$mail->isHTML(true);
							$topik = "Kirim Surat: ".$perihal;
							$mail->Subject = $topik;
							$mail->Body = $isi;
							$mail->AltBody = $perihal;
							if(!$mail->send()) {
								// echo $isi;
								// echo "Mailer Error: " . $mail->ErrorInfo;
								echo "<script type=\"text/javascript\">alert('Data Berhasil disimpan. Email notifikasi gagal dikirim!');window.location.href=\"./index.php?op=add_sk\";</script>";
							}else{
								echo "<script type=\"text/javascript\">alert('Data Berhasil disimpan, Email notifikasi dikirim!');window.location.href=\"./index.php?op=add_sk\";</script>";
							}
						}else{
							echo "<script type=\"text/javascript\">alert('Data Berhasil disimpan!');window.location.href=\"./index.php?op=add_sk\";</script>";
						}
					}else{
						echo "<script type=\"text/javascript\">alert('Data Berhasil disimpan!');window.location.href=\"./index.php?op=add_sk\";</script>";
					}
				}else{
					die("<script>alert('Data Gagal di simpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
				}
			}else{
				//if(in_array($tipefile, $extensionList)){
					if(move_uploaded_file($_FILES['filesk']['tmp_name'], $filesk)){
						$insert = $this->model->insertprepare("arsip_sk", $field, $params);
						if($insert->rowCount() >= 1){
							//Kirim Email
							$EmailAccount = $this->model->selectprepare("pengaturan", $field=null, $params=null, $where=null, "WHERE id='1' AND email !='' AND pass_email !=''");
							$AktifEmail = $this->model->selectprepare("email_setting", $field=null, $params=null, $where=null, "WHERE id_kop='2' AND status='Y'");
							if($EmailAccount->rowCount() >= 1 AND $AktifEmail->rowCount() >= 1){
								$dataEmailAccount = $EmailAccount->fetch(PDO::FETCH_OBJ);
								$dataAktifEmail = $AktifEmail->fetch(PDO::FETCH_OBJ);
								
								$dataTujuan = json_decode($email_tujuan, true);
		
								$isi = $dataAktifEmail->layout;
								$Rlayout = $isi;
								$arr = array("=NoAgenda=" =>$noagenda_custom, "=NoSurat=" => $nosk, "=Perihal=" => $perihal, "=TujuanSurat=" => $tujuan, "=TglSurat=" => tgl_indo($tglsk), "=TglTerima=" => '-', "=AsalSurat=" =>$_SESSION['nama'], "=Keterangan=" => $ket);
								foreach($arr as $nama => $value){
									if(strpos($isi, $nama) !== false) {
										$Rlayout = str_replace($nama, $value, $isi);
										$isi = $Rlayout;
									}
								}
								
								if(isset($_POST['email_tujuan'])){
									$mail = new PHPMailer;
									$mail->isSMTP();
									$mail->SMTPDebug = 0;
									$mail->Debugoutput = 'html';
									$mail->Host = 'smtp.gmail.com';
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
		
									while (list ($key, $val) = each ($dataTujuan)) {
										$mail->addAddress($val);
									}
		
									$mail->isHTML(true);
									$topik = "Kirim Surat: ".$perihal;
									$mail->Subject = $topik;
									$mail->Body = $isi;
									$mail->AltBody = $perihal;
									$lokasi = "berkas/$filedb";
									if(file_exists($lokasi)){
										$mail->addAttachment($lokasi);
									}
									if(!$mail->send()) {
										echo "<script type=\"text/javascript\">alert('Data Berhasil disimpan. Email notifikasi gagal dikirim!');window.location.href=\"./index.php?op=add_sk\";</script>";
									}else{
										echo "<script type=\"text/javascript\">alert('Data Berhasil disimpan, Email notifikasi dikirim!');window.location.href=\"./index.php?op=add_sk\";</script>";
									}
								}else{
									echo "<script type=\"text/javascript\">alert('Data Berhasil disimpan!');window.location.href=\"./index.php?op=add_sk\";</script>";
								}
							}else{
								echo "<script type=\"text/javascript\">alert('Data Berhasil disimpan!');window.location.href=\"./index.php?op=add_sk\";</script>";
							}
						}else{
							die("<script>alert('Data Gagal di simpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
						}
					}else{
						echo "<script type=\"text/javascript\">alert('File gagal di Upload ke Folder, Silahkan ulangi!!!');window.history.go(-1);</script>";
					}
				/*}else{
					echo "<script type=\"text/javascript\">alert('File gagal di Upload, Format file tidak di dukung!!!');window.history.go(-1);</script>";
				}*/
			}
		}else{
			echo "<script type=\"text/javascript\">alert('PERHATIAN..! Nomor Surat Keluar yang dimasukkan sudah pernah terdata di Sistem. Silahkan Ulangi.');window.history.go(-1);</script>";
		}
	}
}else{
	if(isset($_GET['skid'])){
		$skid = htmlspecialchars($purifier->purify(trim($_GET['skid'])), ENT_QUOTES);
		$params = array(':id_sk' => $skid);
		$cek_sk = $this->model->selectprepare("arsip_sk", $field=null, $params, "id_sk=:id_sk");
		if($cek_sk->rowCount() >= 1){
			$data_sk = $cek_sk->fetch(PDO::FETCH_OBJ);
			$title= "Edit Data Surat Keluar";
			$ketfile = "File Surat ";
			$pengolah = 'value="'.$data_sk->pengolah .'"';
			$nosk = 'value="'.$data_sk->no_sk .'"';
			$noagenda = $data_sk->no_agenda;
			$id_klasifikasi = $data_sk->klasifikasi;
			$tgl_surat = explode("-", $data_sk->tgl_surat);
			$tgl_surat = $tgl_surat[2]."-".$tgl_surat[1]."-".$tgl_surat[0];
			$tgl_surat = 'value="'.$tgl_surat.'"';
			$tujuan_surat = 'value="'.$data_sk->tujuan_surat .'"';
			$perihal = $data_sk->perihal;
			$ket = $data_sk->ket;
		}else{
			$title= "Entri Surat Keluar";
			$ketfile = "File Surat";
			$validasifile = "required";
		}
	}else{
		$title= "Entri Surat Keluar";
		$ketfile = "File Surat";
	}

	$params = array(':id' => 1);
	$cek_noagenda_custom = $this->model->selectprepare("pengaturan", $field=null, $params, "id=:id")->fetch(PDO::FETCH_OBJ);

	if(isset($_GET['id_klasifikasi'])){
		$id_klasifikasi = htmlspecialchars($purifier->purify(trim($_GET['id_klasifikasi'])), ENT_QUOTES);
	}

	
	if(isset($data_sk->no_agenda)){
		$noAgenda = sprintf("%04d", $data_sk->no_agenda);
		$nonoAgendaShow = $data_sk->custom_noagenda;
	}else{
		if(isset($_GET['id_klasifikasi']) && $_GET['id_klasifikasi'] != ''){ 
			$kode_jenis_surat = htmlspecialchars($purifier->purify(trim($_GET['id_klasifikasi'])), ENT_QUOTES);
			
			$kondisi1 = array(':id_klas' => $kode_jenis_surat);
			$klasifikasi_surat = $this->model->selectprepare("klasifikasi_sk", $field=null, $kondisi1,  "id_klas=:id_klas", $order=null);
			$data_klasifikasi_surat = $klasifikasi_surat->fetch(PDO::FETCH_OBJ);

			$DataValueSet = array(
				"=KodeSurat=" => $data_klasifikasi_surat->kode,
				"=Tahun=" => date("Y"));

			$format_no_agenda = $cek_noagenda_custom->no_agenda_sm;
			if(isset($DataValueSet)){
				foreach($DataValueSet as $nama => $value){
					if(strpos($format_no_agenda, $nama) !== false) {
						$Rlayout = str_replace($nama, $value, $format_no_agenda);
						$format_no_agenda = $Rlayout;
					}
				}
			}

			$kondisi = array(':klasifikasi' => $kode_jenis_surat);
			$cek_noaagenda = $this->model->selectprepare("arsip_sk", $field=null, $kondisi,  "klasifikasi=:klasifikasi", "ORDER BY id_sk DESC LIMIT 1");
			if($cek_noaagenda->rowCount() >= 1){
				$data_cek_noaagenda = $cek_noaagenda->fetch(PDO::FETCH_OBJ);
				if(isset($data_cek_noaagenda->no_agenda)){
					$thn_data_surat = substr($data_cek_noaagenda->created,0,4);
					if($thn_data_surat == date('Y')){
						$noAgenda = sprintf("%04d", $data_cek_noaagenda->no_agenda+1);
						$nonoAgendaShow = $data_cek_noaagenda->no_agenda+1;
					}else{
						if($cek_noagenda_custom->no_agenda_sk_start != ''){
							$noAgenda = sprintf("%04d", $cek_noagenda_custom->no_agenda_sk_start);
							$nonoAgendaShow = $cek_noagenda_custom->no_agenda_sk_start;
						}else{
							$noAgenda = sprintf("%04d", 1);
							$nonoAgendaShow = 1;
						}
					}
				}else{
					if($cek_noagenda_custom->no_agenda_sk_start != ''){
						$noAgenda = sprintf("%04d", $cek_noagenda_custom->no_agenda_sk_start);
						$nonoAgendaShow = $cek_noagenda_custom->no_agenda_sk_start;
					}else{
						$noAgenda = sprintf("%04d", 1);
						$nonoAgendaShow = 1;
					}
				}
			}else{
				if($cek_noagenda_custom->no_agenda_sk_start != ''){
					$noAgenda = sprintf("%04d", $cek_noagenda_custom->no_agenda_sk_start);
					$nonoAgendaShow = $cek_noagenda_custom->no_agenda_sk_start;
				}else{
					$noAgenda = sprintf("%04d", 1);
					$nonoAgendaShow = 1;
				}
			}
		}
	}?>
	<div class="widget-box">
		<div class="widget-header">
			<h4 class="widget-title"><?php echo $title;?></h4>
		</div>
		<div class="card">
			<div class="card-body">
				<form class="form-horizontal" role="form" enctype="multipart/form-data" method="GET" name="formku" action="./index.php?op=add_sk">
					<div class="form-group">
						<label class="tx-11 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1">Jenis Naskah </label>
						<div class="col-sm-6">
							<input type="hidden" name="op" value="add_sk"/>
							<select class="js-example-basic-single w-100" id="form-field-select-3" name="id_klasifikasi" data-placeholder="Pilih Klasifikasi..." required onchange="this.form.submit()" <?php if(isset($_GET['skid'])){ echo 'disabled'; } ?>>
								<option value="">Pilih Klasifikasi</option><?php
								$KlasArsip= $this->model->selectprepare("klasifikasi_sk", $field=null, $params=null, $where=null, "ORDER BY nama ASC");
								if($KlasArsip->rowCount() >= 1){
									while($dataKlasArsip = $KlasArsip->fetch(PDO::FETCH_OBJ)){
										if(isset($id_klasifikasi) && $id_klasifikasi == $dataKlasArsip->id_klas){?>
											<option value="<?php echo $dataKlasArsip->id_klas;?>" selected><?php echo $dataKlasArsip->nama;?></option><?php
										}else{?>
											<option value="<?php echo $dataKlasArsip->id_klas;?>"><?php echo $dataKlasArsip->nama;?></option><?php
										}
									}
								}else{?>
									<option value="">Data klasifikasi belum ada</option><?php
								}?>
							</select>
						</div>
					</div>
					<div class="space-4"></div>
				</form><?php
				if((isset($_GET['id_klasifikasi']) && $_GET['id_klasifikasi'] != '') OR (isset($_GET['skid'])  && $_GET['skid'] != '')){ ?>
					<form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" name="formku" action="<?php echo $_SESSION['url'];?>">
						<div class="form-group">
							<label class="tx-11 font-weight-bold mb-0 text-uppercase" for="form-field-1"> No. Agenda </label>
							<div class="col-sm-6"><?php 
								$params = array(':id' => 1);
								$cek_noagenda_custom = $this->model->selectprepare("pengaturan", $field=null, $params, "id=:id")->fetch(PDO::FETCH_OBJ);
								if($cek_noagenda_custom->no_agenda_sm != '' && !isset($data_sk->no_agenda)){
									$noAgenda = $noAgenda."/$format_no_agenda";								
								}else{
									$noAgenda = $nonoAgendaShow;
								} ?>
								<input class="form-control" placeholder="Nomor Agenda Surat" type="text" name="noagenda" <?php if(isset($noAgenda)){ echo 'value="'.$noAgenda .'"'; } ?> id="form-field-mask-1" required disabled />
								<input type="hidden" name="noagenda" value="<?php echo $nonoAgendaShow;?>"/>
								<input type="hidden" name="noagenda_custom" value="<?php echo $noAgenda;?>"/>
								<input type="hidden" name="id_klasifikasi" value="<?php echo $id_klasifikasi;?>"/>
							</div>
						</div>
						<div class="space-4"></div>
						<div class="form-group">
							<label class="tx-11 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1"> Nomor Surat </label>
							<div class="col-sm-6">
								<input class="form-control" placeholder="Nomor surat keluar" type="text" name="nosk" <?php if(isset($nosk)){ echo $nosk; }?> id="form-field-mask-1" required/>
							</div>
						</div>
						<div class="space-4"></div>
						<div class="form-group">
							<label class="tx-11 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1"> Tanggal Surat </label>
							<div class="col-sm-6">
								<input class="form-control date "   placeholder="Tanggal surat keluar" type="date" name="tglsk" <?php if(isset($tgl_surat)){ echo $tgl_surat; }?> id="form-field-mask-1" required/>
							</div>
						</div>
						<div class="space-4"></div>
						<div class="form-group"> 
							<label class="tx-11 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1"> Pengolah </label>
							<div class="col-sm-6">
								<input class="form-control" data-rel="tooltip" placeholder="Nama atau bagian pengolah surat" type="text" name="pengolah" <?php if(isset($pengolah)){ echo $pengolah; }?> title="Di isi dengan nama atau bagian yang mengolah surat(nama perorangan/bagian)." data-placement="bottom" id="form-field-mask-1" required/>
							</div>
						</div>
						<div class="space-4"></div>
						<div class="form-group">
							<label class="tx-11 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1"> Tujuan Surat </label>
							<div class="col-sm-6">
								<input class="form-control" placeholder="Nama lembaga / Perorangan" type="text" name="tujuan" <?php if(isset($tujuan_surat)){ echo $tujuan_surat; }?> id="form-field-mask-1" required/>
							</div>
						</div>
						<div class="form-group">
							<label class="tx-11 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1"> Dikirim ke </label>
							<div class="col-sm-6">
								<div class="space-2"></div>
								<select multiple="" class="js-example-basic-multiple w-100 form-control" name="email_tujuan[]"  data-placeholder="Pilih kontak (optional)">
									<?php
									$id = $_SESSION['id_user'];
									$users = mysqli_query($conn, "SELECT * FROM kontak WHERE id_user='$id'");
									foreach($users as $user):?>
										<option value="<?php echo $user['email'];?>">
											<?php echo $user['nama'].' - '.$user['email']  ; ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="space-4"></div>
						<div class="form-group">
							<label class="tx-11 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1"> Perihal </label>
							<div class="col-sm-6">
								<textarea class="form-control limited" placeholder="Perihal/subjek surat" name="perihal" id="form-field-9" maxlength="150" required><?php if(isset($perihal)){ echo $perihal; }?></textarea>
							</div>
						</div>
						<div class="space-4"></div>
						<div class="form-group">
							<label class="tx-11 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1"> Konseptor dari </label>
							<div class="col-sm-6">
								<textarea class="form-control limited" placeholder="Keterangan tambahan (jika ada)" name="ket" id="form-field-9" maxlength="150"><?php if(isset($ket)){ echo $ket; }?></textarea>
							</div>
						</div>


						<div class="col-md-6 stretch-card">
						<div class="card">
						<div class="card-body">
							<h6 class="card-title"><?php echo $ketfile;?></h6>
							<p class="card-description">Pilih file yang ingin di upload. Caranya klik menu Pilih File. Tipe file : .pdf, .jpeg, .jpg, .png</p>
							<input type="file" name="filesk" id="myDropify" class="border" data-allowed-file-extensions="pdf jpeg jpg png" <?php if(isset($validasifile)){ echo $validasifile; }?>/>
						</div>
						</div>
						</div><br>


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
					</form> <?php
				} ?>
			</div>
		</div>
	</div><?php
}?>