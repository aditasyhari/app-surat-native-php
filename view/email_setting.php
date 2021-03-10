<?php
	/* $params = array(':id_unit' => $_SESSION['id_unit']);
	$CekSetting = $this->model->selectprepare("kop_surat", $field=null, $params, "id_unit=:id_unit");
	if($CekSetting->rowCount() >= 1){
		$dataCekSetting = $CekSetting->fetch(PDO::FETCH_OBJ);
		$logo = $dataCekSetting->logo;
	} */
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$params = array(':id' => $_GET['GetId']);
		$KopEmail = $this->model->selectprepare("email_setting", $field=null, $params, "id=:id");
		if($KopEmail->rowCount() >= 1){
			$params1 = array(':id' => $_GET['GetId']);
			$status = htmlspecialchars($purifier->purify(trim($_POST['status'])), ENT_QUOTES);
			$layout = $_POST['layout'];
			$field = array('layout' => $layout, 'status' => $status);
			$update = $this->model->updateprepare("email_setting", $field, $params1, "id=:id");
			if($update){
				echo "<script type=\"text/javascript\">alert('Data Berhasil diperbaharui...!!');window.location.href=\"./index.php?op=setting&act=email_notif&GetId=".$_GET['GetId']."\";</script>";
			}else{
				die("<script>alert('Data menyimpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
			}
		}
	}else{?>
	<div class="widget-box"><?php
		$VarDinamis = "";
		$VarSetting = $this->model->selectprepare("kop_variabel", $field=null, $params=null, $where=null);
		while($dataVarSetting = $VarSetting->fetch(PDO::FETCH_OBJ)){
			$dinamasiVar = explode(',',$dataVarSetting->id_kop);
			$params = array(':id' => $_GET['GetId']);
			$IdKopEmail = $this->model->selectprepare("email_setting", $field=null, $params, "id=:id");
			$dataIdKopEmail = $IdKopEmail->fetch(PDO::FETCH_OBJ);
			if($dataIdKopEmail->id_kop == 1){
				$kop = 3;
			}else{
				$kop = $dataIdKopEmail->id_kop;
			}
			if($dinamasiVar[0] == $kop OR $dinamasiVar[1] == $kop OR $dinamasiVar[2] == $kop){
				$VarDinamis .= $dataVarSetting->variabel .' | '.$dataVarSetting->ket .'<br/>';
			}
		}?>
		
		<div class="widget-header">
			<h4 class="widget-title">Konfigurasi Email <?php
			$params = array(':id' => $_GET['GetId']);
			$KopEmail = $this->model->selectprepare("email_setting", $field=null, $params, "id=:id");
			if($KopEmail->rowCount() >= 1){
				$dataKopEmail = $KopEmail->fetch(PDO::FETCH_OBJ);
				echo $dataKopEmail->ket;
			}?>
			</h4>
		</div>
		<div class="card">
			<div class="card-body"><?php?>
				<!-- <script src="./tinymce/tinymce.min.js"></script>
				<script>
					tinymce.init({
					  selector: 'textarea',
					  height: 200,
					  theme: 'modern',
					  plugins: [
						'advlist autolink lists link image charmap print preview hr anchor pagebreak',
						'searchreplace wordcount visualblocks visualchars code fullscreen',
						'insertdatetime media nonbreaking save table contextmenu directionality',
						'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
					  ],
					  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
					  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
					  image_advtab: true,
					  templates: [
						{ title: 'Test template 1', content: 'Test 1' },
						{ title: 'Test template 2', content: 'Test 2' }
					  ]
					 });
				</script> -->
				<form class="form-horizontal" role="form" name="formku" method="GET">	
					<input type="hidden" name="op" value="setting"/>
					<input type="hidden" name="act" value="email_notif"/>
					<div class="form-group">
						<label class="tx-11 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1" for="form-field-mask-1">Pilih jenis kop email</label>
						<div class="col-sm-6">
						<select class="js-example-basic-single w-100" name="GetId"  data-placeholder="Pilih Kop..." onchange='this.form.submit()'>
						<option value="">Pilih Kop</option><?php
								$KopEmail = $this->model->selectprepare("email_setting", $field=null, $params=null, $where=null);
								if($KopEmail->rowCount() >= 1){
									while($dataKopEmail = $KopEmail->fetch(PDO::FETCH_OBJ)){
										if(isset($_GET['GetId']) && $_GET['GetId'] == $dataKopEmail->id){?>
											<option value="<?php echo $dataKopEmail->id;?>" selected><?php echo $dataKopEmail->ket;?></option><?php
										}else{?>
											<option value="<?php echo $dataKopEmail->id;?>"><?php echo $dataKopEmail->ket;?></option><?php
										}
									}
								}?>
						</select>




						<!-- <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left"  data-content="Pilih kop email yang tersedia" title="Jenis kop email">?</span>
						<div class="col-sm-5">
							<select class="form-control" id="form-field-select-3" name="GetId" data-placeholder="Pilih Kop..." onchange='this.form.submit()'>
								<option value="">Pilih Kop</option><?php
								$KopEmail = $this->model->selectprepare("email_setting", $field=null, $params=null, $where=null);
								if($KopEmail->rowCount() >= 1){
									while($dataKopEmail = $KopEmail->fetch(PDO::FETCH_OBJ)){
										if(isset($_GET['GetId']) && $_GET['GetId'] == $dataKopEmail->id){?>
											<option value="<?php echo $dataKopEmail->id;?>" selected><?php echo $dataKopEmail->ket;?></option><?php
										}else{?>
											<option value="<?php echo $dataKopEmail->id;?>"><?php echo $dataKopEmail->ket;?></option><?php
										}
									}
								}?>
							</select> -->


						</div>
					</div>
				</form><?php
				if(isset($_GET['GetId']) AND $_GET['GetId'] != ''){
					$params = array(':id' => $_GET['GetId']);
					$KopEmail = $this->model->selectprepare("email_setting", $field=null, $params, "id=:id");
					if($KopEmail->rowCount() >= 1){
						$dataKopEmail = $KopEmail->fetch(PDO::FETCH_OBJ);?>
						<form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" name="formku" action="<?php echo $_SESSION['url'];?>">
							<div class="form-group">
								<label class="tx-11 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1"> Aktifkan notif email </label><br>

								<div class="form-check form-check-inline"><?php
									if($dataKopEmail->status == "Y"){?>
										<label class="form-check-label">
											<input name="status" type="radio" value="Y"  class="form-check-input" required="required" id="optionsRadios" checked />
											 Ya<!-- <span class="lbl"> Ya</span> -->
										</label>
										<label class="form-check-label">
											<input name="status" type="radio" value="N" class="form-check-input" required="required" id="optionsRadios" />
											<span class="lbl"> Tidak</span>
										</label><?php
									}else{?>
										<label class="form-check-label">
											<input name="status" type="radio" value="Y" class="form-check-input" required="required" id="optionsRadios" />
											Ya <!-- <span class="lbl"> Ya</span> -->
										</label>
										<label class="form-check-label">
											<input name="status" type="radio" value="N" class="form-check-input" required="required" id="optionsRadios" checked />
											Tidak <!-- <span class="lbl"> Tidak</span> -->
										</label><?php
									}?>
								</div>
							</div>
							<div class="form-group">
								<label class="tx-11 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1"> Format notif EMail </label>
								<div class="col-sm-12">
									<textarea class="form-control limited" name="layout"><?php echo $dataKopEmail->layout;?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="tx-11 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1"> Variabel dinamis yang tersedia*</label>
								<div class="col-sm-6">
									<?php echo $VarDinamis;?>
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
									&nbsp; &nbsp; &nbsp;
									<div class="col-sm-2">
									<button class="btn btn-warning" type="reset">
										<i class="ace-icon fa fa-undo bigger-110"></i>
										Reset
									</button>
									</div>
								</div>
							</div>
						</form><?php
					}
				}?>
			</div>
		</div>
		<div class="space-4"></div>
		<hr/>
		<a href="./index.php?op=setting" title="Pengaturan Group User">
			<button class="btn btn-white btn-info btn-bold">
				<i class="ace-icon fa fa-cog bigger-120 blue"></i>Konfigurasi Umum
			</button>
		</a>
		<a href="./index.php?op=setting&act=kopterima&idkop=1" title="Pengaturan Kop Terima Surat">
			<button class="btn btn-white btn-info btn-bold">
				<i class="ace-icon fa fa-cog bigger-120 blue"></i>Kop Terima
			</button>
		</a>
		<a href="./index.php?op=setting&act=kopdetail&idkop=2" title="Pengaturan Kop Detail Surat">
			<button class="btn btn-white btn-info btn-bold">
				<i class="ace-icon fa fa-cog bigger-120 blue"></i>Kop Detail
			</button>
		</a>
		<a href="./index.php?op=setting&act=kopdisposisi&idkop=3" title="Pengaturan Kop Disposisi Surat">
			<button class="btn btn-white btn-info btn-bold">
				<i class="ace-icon fa fa-cog bigger-120 blue"></i>Kop Disposisi
			</button>
		</a>
		<a href="./index.php?op=setting&act=emailnotif&idkop=4" title="Pengaturan Email Notifikasi Surat">
			<button class="btn btn-white btn-info btn-bold">
				<i class="ace-icon fa fa-cog bigger-120 blue"></i>Email Notifikasi
			</button>
		</a>
	</div><?php
}?>