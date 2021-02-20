<?php
//error_reporting(0);
ini_set('date.timezone', 'Asia/Jakarta');
require_once "view/indo_tgl.php";
require_once "htmlpurifier/library/HTMLPurifier.auto.php";
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);
require 'PHPMailer-master/PHPMailerAutoload.php';
function slugify($text){
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);
  // trim
  $text = trim($text, '-');
  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);
  // lowercase
  $text = strtolower($text);
  if (empty($text)) {
    return 'n-a';
  }
  return $text;
}
if(isset($_SESSION['atra_id']) AND isset($_SESSION['atra_pass'])){
	$CekAkses = $this->model->selectprepare("user_level", $field=null, $params=null, $where=null, "WHERE id_user='$_SESSION[id_user]'");
	$HakAkses = $CekAkses->fetch(PDO::FETCH_OBJ);?>
	
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
		<link href="assets/assets/plugins/select2/select2.min.css" rel="stylesheet" />
		<link href="assets/assets/fonts/feather-font/css/iconfont.css" rel="stylesheet" />
		<link href="assets/assets/plugins/flag-icon-css/css/flag-icon.min.css" rel="stylesheet" />
		<link href="assets/assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
		<link href="assets/assets/plugins/dropify/css/dropify.min.css" rel="stylesheet" />

		<!-- end plugin css -->

		<!-- common css -->
		<link href="assets/css/app.css" rel="stylesheet" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" />
		<!-- end common css -->

		<link href="assets/css/add_template.css" rel="stylesheet">

	</head>

	<body>

		<script src="assets/assets/js/spinner.js"></script>

		<div class="main-wrapper" id="app">
			<?php require_once 'sidebar.php' ?>
			<div class="page-wrapper">
				<?php require_once 'header.php' ?>
				<div class="page-content">
					<?php require_once 'content.php' ?>
				</div>
				<?php require_once 'footer.php'  ?>
			</div>
		</div>



		<!-- base js -->
		<script src="assets/js/app.js"></script>
		<script src="assets/assets/plugins/feather-icons/feather.min.js"></script>
		<script src="assets/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/moment@2.27.0/moment.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>


		<!-- plugin script -->
		<script src="assets/assets/plugins/chartjs/Chart.min.js"></script>
		<script src="assets/assets/plugins/jquery.flot/jquery.flot.js"></script>
		<script src="assets/assets/plugins/jquery.flot/jquery.flot.resize.js"></script>
		<script src="assets/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/assets/plugins/apexcharts/apexcharts.min.js"></script>
		<script src="assets/assets/plugins/progressbar-js/progressbar.min.js"></script>
		<script src="assets/assets/plugins/dropify/js/dropify.min.js"></script>
  		<script src="assets/assets/plugins/moment/moment.min.js"></script>
		<script src="assets/assets/plugins/tinymce-dist/tinymce.min.js"></script>
  		<script src="assets/assets/plugins/select2/select2.min.js"></script>


		<script src="assets/assets/js/select2.js"></script>
		<script src="assets/assets/js/dashboard.js"></script>
		<script src="assets/assets/js/datepicker.js"></script>
		<script src="assets/assets/js/timepicker.js"></script>
		<!-- end plugin script -->

		<!-- common js -->
		<script src="assets/assets/js/dropify.js"></script>
		<script src="assets/assets/js/template.js"></script>
		<script src="assets/assets/js/tinymce.js"></script>

		<!-- end common js -->

	</body>

	</html>

	<?php
}else{
	/* echo "Sesssion belum ada<br/>";
	echo $_SESSION['atra_id']."  pass ".$_SESSION['hakakses']; */
	echo "<script type=\"text/javascript\">window.location.href=\"./login\";</script>";
}?>
