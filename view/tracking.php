<?php
//error_reporting(0);
ini_set('date.timezone', 'Asia/Jakarta');
require_once "view/indo_tgl.php";
require_once "htmlpurifier/library/HTMLPurifier.auto.php";
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$cari = htmlspecialchars($purifier->purify(trim($_POST['cari'])), ENT_QUOTES);
	$params = array(':no_agenda' => $cari, ':no_sm' => $cari);
	$cek = $this->model->selectprepare("arsip_sm", $field=null, $params, "custom_noagenda =:no_agenda OR no_sm=:no_sm");
	if($cek->rowCount() >= 1){
		$dataSurat = $cek->fetch(PDO::FETCH_OBJ);
	}else{
		$dataSurat = 0;
	}
	$layout = "error-container";
	$title = "Hasil Tracking Status Surat";
}else{
	$layout = "login-container";
	$title = "Tracking Status Surat";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="UTF-8">
		<meta name="description" content="">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>E - Office | Aplikasi Surat</title>

		<!-- Favicon  -->
		<!-- <link rel="icon" href="img/core-img/favicon.ico"> -->

		<!-- plugin css -->
		<link href="assets/assets/fonts/feather-font/css/iconfont.css" rel="stylesheet" />
		<link href="assets/assets/plugins/flag-icon-css/css/flag-icon.min.css" rel="stylesheet" />
		<link href="assets/assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
		<link href="assets/assets/plugins/dropify/css/dropify.min.css" rel="stylesheet" />
		<link href="assets/assets/plugins/select2/select2.min.css" rel="stylesheet" />
		<link href="assets/assets/plugins/datatables-net/dataTables.bootstrap4.css" rel="stylesheet" />
		<link rel="stylesheet" href="assets/assets/fullcalendar/fullcalendar.min.css" />
		<!-- end plugin css -->

		<!-- common css -->
		<link href="assets/css/app.css" rel="stylesheet" />
		<!-- end common css -->

	</head>

	
	<body>

		<script src="assets/assets/js/spinner.js"></script>

		<div class="main-wrapper" id="app">
		<div class="page-wrapper full-page">
			<div class="page-content d-flex align-items-center justify-content-center">
				<div class="row w-100 mx-0 auth-page">
				<div class="col-md-9 col-xl-6 mx-auto">
					<div class="card">
					<div class="row">
						<div class="col-md-4 pr-md-0">
						<div class="auth-left-wrapper" style="background-image: url('https://via.placeholder.com/219x452')">
						</div>
						</div>
						<div class="col-md-8 pl-md-0">
						<div class="auth-form-wrapper px-4 py-5">
							<a href="#" class="noble-ui-logo d-block mb-2"><span>E</span>-OFFICE <?php echo date('Y'); ?></a>
							<!-- <h5 class="text-muted font-weight-normal mb-4">Selamat Datang!.. Silahkan Log in untuk Akun Anda.</h5> -->
							<div class="widgdiv">
										<div class="widget-main">
											<h4 class="text-muted font-weight-normal mb-4">
												<?php echo $title;?>
												<i data-feather="search"></i>
											</h4>
											<?php
											if(isset($dataSurat) && !is_numeric($dataSurat)){
												$ListUser = $this->model->selectprepare("user a join user_jabatan b on a.jabatan=b.id_jab", $field=null, $params=null, $where=null, "ORDER BY a.nama ASC");
												$TujuanSurat = "";
												$TargetDisposisi = "";
												while($dataListUser = $ListUser->fetch(PDO::FETCH_OBJ)){
													if(false !== array_search($dataListUser->id_user, json_decode($dataSurat->tujuan_surat, true))){
														$TujuanSurat .= '- '.$dataListUser->nama .' ('.$dataListUser->nama_jabatan .')<br/>';
													}
													
												}
												$tgl_diteruskan = substr($dataSurat->created,0,10);?>
												<p><center>NoAgenda / NoSurat : <b><?php echo $cari;?></b>, Pengirim: <b><?php echo $dataSurat->pengirim;?></b></center></p>
												<table id="dynamic-table" class="table table-striped table-bordered table-hover">
													<thead>
														<tr>
															<td width="250">Status surat</td>
															<td width="140">update</td>
														</tr>
													</thead>
													<tbody>	
														<tr>
															<td colspan="2"><b><center>SURAT DITERUSKAN KE</center></b></td>
														</tr>
														<tr>
															<td><?php if($TujuanSurat != ''){ echo "$TujuanSurat"; }?></td>
															<td><?php echo tgl_indo1($tgl_diteruskan);?>, <?php echo substr($dataSurat->created,-9,-3);?> WIB</td>
														</tr>
														<tr>
															<td colspan="2"><b><center>RIWAYAT DISPOSISI</center></b></td>
														</tr><?php
														$params = array(':id_sm' => $dataSurat->id_sm);
														$cekDisposisi = $this->model->selectprepare("memo a join user b on a.id_user=b.id_user", $field=null, $params, "a.id_sm=:id_sm", "ORDER BY a.tgl ASC");
														if($cekDisposisi->rowCount() >= 1){
															while($dataDisposisi= $cekDisposisi->fetch(PDO::FETCH_OBJ)){
																$ListDisposisi2 = json_decode($dataDisposisi->disposisi, true);
																$tgl_dispolevel = substr($dataDisposisi->tgl,0,10);?>
																<tr>
																	<td><?php
																	echo "Disposisi dari <b>".$dataDisposisi->nama."</b> ke <br/>";
																		foreach($ListDisposisi2 as $listdispo){
																			$TampilUser = $this->model->selectprepare("user a join user_jabatan b on a.jabatan=b.id_jab", $field=null, $params=null, $where=null, "WHERE a.id_user='$listdispo'")->fetch(PDO::FETCH_OBJ);
																			echo "- ".$TampilUser->nama." ($TampilUser->nama_jabatan)<br/>";?><?php
																		}?>
																	</td>
																	<td><?php echo tgl_indo1($tgl_dispolevel);?>, <?php echo substr($dataDisposisi->tgl,-9,-3);?> WIB</td>
																</tr><?php
															}
														}
														$CekProgress = $this->model->selectprepare("status_surat", $field=null, $params=null, $where=null, "WHERE id_sm = '$dataSurat->id_sm' order by statsurat ASC");
														if($CekProgress->rowCount() >= 1){?>
															<tr>
																<td colspan="2"><b><center>PROGRESS SURAT</center></b></td>
															</tr><?php
															while($dataCekProgress = $CekProgress->fetch(PDO::FETCH_OBJ)){
																$CekUser = $this->model->selectprepare("user", $field=null, $params=null, $where=null, "WHERE id_user = '$dataCekProgress->id_user'")->fetch(PDO::FETCH_OBJ);
																if($dataCekProgress->statsurat == 1){
																	$statusSirat = "Sedang diproses";
																}elseif($dataCekProgress->statsurat == 2){
																	$statusSirat = "Selesai";
																}elseif($dataCekProgress->statsurat == 0){
																	$statusSirat = "Dibatalkan";
																}?>
																<tr>
																	<td>
																		<b><?php echo $CekUser->nama;?></b> status : <b><?php echo $statusSirat;?></b> <br/><?php echo $dataCekProgress->ket;?>
																	</td>
																	<td>
																		<?php echo tgl_indo1($dataCekProgress->created);?>, <?php echo substr($dataCekProgress->created,-9,-3);?> WIB
																	</td>
																</tr><?php
															}
														}?>
													</tbody>
												</table><?php
											}else{
												if(isset($dataSurat) && $dataSurat == 0){?>
													<div class="alert alert-danger">
														<p>
															<strong><i class="ace-icon fa fa-check"></i>Perhatian!</strong>
															Data status surat tidak ditemukan. Cek kembali nomor surat yang anda masukkan. Terimakasih.
														</p>
													</div><?php
												}else{?>
													<form class="form-sample" method="POST" autocomplete="off" action="<?php echo $_SESSION['url'];?>">
														<div class="col-sm-12 justify-content-center">
																<div class="form-group">
															
															<span class="block input-icon input-icon-right">
																			<input type="text" name="cari" class="form-control" placeholder="Masukan Nomor Surat" />
																</span><br>

																<button type="submit"class="btn btn-xs btn-primary btn-block btn-icon-text">
																<i data-feather="search"></i>
																		Cari
																</button>
													</div>
												
														</div>
													</form>
													<?php
												}
											}?>
										</div><br>
										

										<div class="mt-3">
										<a href="./tracking" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
											<i class="btn-icon-prepend" data-feather="truck"></i>
											Tracking
										</a>
										<a href="./login" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0 pull-right">
											<i class="btn-icon-prepend" data-feather="truck"></i>
											Kembali Ke Login
										</a>
										</div>	
										


										<!-- <div class="toolbar clearfix">
											<div>
												<a href="./tracking" class="forgot-password-link">
													<i class="ace-icon fa fa-arrow-left"></i>
													Kembali
												</a>
											</div>
											<div>
												<a href="./login" class="user-signup-link">
													Login
													<i class="ace-icon fa fa-arrow-right"></i>
												</a>
											</div>
										</div> -->
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->
								
						</div>
						</div>
					</div>
					</div>
				</div>
				</div>

				</div>
				</div>
		</div>



		<!-- base js -->
		<script src="assets/js/app.js"></script>
		<script src="assets/assets/plugins/feather-icons/feather.min.js"></script>
		<script src="assets/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/moment@2.27.0/moment.min.js"></script>
		


		<!-- plugin script -->
		<script src="assets/assets/plugins/chartjs/Chart.min.js"></script>
		<script src="assets/assets/plugins/jquery.flot/jquery.flot.js"></script>
		<script src="assets/assets/plugins/jquery.flot/jquery.flot.resize.js"></script>
		<script src="assets/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/assets/plugins/apexcharts/apexcharts.min.js"></script>
		<script src="assets/assets/plugins/progressbar-js/progressbar.min.js"></script>
		<script src="assets/assets/plugins/dropify/js/dropify.min.js"></script>
		<script src="assets/assets/js/dropify.js"></script>
		<script src="assets/assets/js/dashboard.js"></script>
		<script src="assets/assets/js/datepicker.js"></script>
		<script src="assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="assets/assets/js/datepicker.js"></script>
 		<script src="assets/assets/js/timepicker.js"></script>
		<script src="assets/assets/plugins/select2/select2.min.js"></script>
		<script src="assets/assets/js/select2.js"></script>
		<script src="assets/assets/plugins/datatables-net/jquery.dataTables.js"></script>
  		<script src="assets/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js"></script>
		<script src="assets/assets/js/data-table.js"></script>
		<script src="assets/assets/fullcalendar/lib/jquery.min.js"></script>
		<script	src="assets/assets/fullcalendar/lib/moment.min.js"></script>
		<script src="assets/assets/fullcalendar/fullcalendar.min.js"></script>


		
		<!-- end plugin script -->

		<!-- common js -->
		<script src="assets/assets/js/template.js"></script>
		<!-- end common js -->

	</body>
</html><?php
//}?>
