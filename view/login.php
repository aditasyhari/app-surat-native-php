<?php
ini_set('date.timezone', 'Asia/Jakarta');
require_once "view/indo_tgl.php";
require_once "htmlpurifier/library/HTMLPurifier.auto.php";
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);
if($_SERVER["REQUEST_METHOD"] == "POST"){
	/* print_r($_POST);
	$pass = md5(htmlspecialchars($purifier->purify($_POST['password']), ENT_QUOTES));
	echo $pass; */
	$user = htmlspecialchars($purifier->purify(trim($_POST['username'])), ENT_QUOTES);
	$pass = md5(htmlspecialchars($purifier->purify(trim($_POST['password'])), ENT_QUOTES));
	$params = array(':user' => $user, ':pass' => $pass);
	$cek = $this->model->selectprepare("user", $field=null, $params, "uname=:user AND upass=:pass");
	if($cek->rowCount() >= 1){
		$data = $cek->fetch(PDO::FETCH_OBJ);
		$_SESSION['id_user'] = $data->id_user;
		$_SESSION['nama'] = $data->nama;
		$_SESSION['atra_id'] = $data->uname;
		$_SESSION['atra_pass'] = $data->upass;
		$_SESSION['hakakses'] = $data->level;
		//$_SESSION['nsalt'] = $data->salt;
		$_SESSION['picture'] = $data->picture;
		echo "<script type=\"text/javascript\">window.location.href=\"./\";</script>";
	}else{
		echo "<script type=\"text/javascript\">alert('Username / Password Anda Salah. Silahkan Ulangi Kembali..!!');window.history.go(-1);</script>";
	}
}
//session_destroy();?>

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
				<div class="col-md-8 col-xl-6 mx-auto">
					<div class="card">
					<div class="row">
						<div class="col-md-4 pr-md-0">
						<div class="auth-left-wrapper" style="background-image: url('https://via.placeholder.com/219x452')">
						</div>
						</div>
						<div class="col-md-8 pl-md-0">
						<div class="auth-form-wrapper px-4 py-5">
							<a href="#" class="noble-ui-logo d-block mb-2"><span>E</span>-OFFICE <?php echo date('Y'); ?></a>
							<h5 class="text-muted font-weight-normal mb-4">Selamat Datang!.. Silahkan Log in untuk Akun Anda.</h5>
							<form class="forms-sample" method="POST" autocomplete="off" action ="<?php echo $_SESSION['url'];?>">
							<div class="form-group">
								<label for="Username">Username</label>
								<input type="text" name="username" class="form-control" placeholder="Username">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Password</label>
								<input type="password" name="password" class="form-control" placeholder="Password"">
							</div>
							<div class="mt-3">
								<button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0">Login</button>
								<a href="./tracking" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
								<i class="btn-icon-prepend" data-feather="truck"></i>
								Tracking
								</a>
							</div>
							</form>
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

	</html>

























