<?php
ini_set('date.timezone', 'Asia/Jakarta');
require_once "view/indo_tgl.php";
require_once "htmlpurifier/library/HTMLPurifier.auto.php";

require_once("dompdf/autoload.inc.php");
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$dompdf = new Dompdf($options);

$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);

$params = array(':id_sm' => trim($_GET['smid']));
$memo = $this->model->selectprepare("arsip_sm", $field=null, $params, "id_sm=:id_sm", $order=null);
if($memo->rowCount() >= 1){
	$data_memo = $memo->fetch(PDO::FETCH_OBJ);
	$tgl_memo = $data_memo->tgl_surat;

	$params = array(':id' => 1);
	$pengaturan = $this->model->selectprepare("pengaturan", $field=null, $params, "id=:id", $other=null);
	if($pengaturan->rowCount() >= 1){
		$data_pengaturan= $pengaturan->fetch(PDO::FETCH_OBJ);
		$kop = $data_pengaturan->logo;
		$title = $data_pengaturan->title;
		$deskripsi = $data_pengaturan->deskripsi;
	}else{
		$kop = "default.jpg";
		$title = "E - Office";
		$deskripsi = "E - Office merupakan aplikasi surat menyurat";
	}
	
	$ListUser = $this->model->selectprepare("user a join user_jabatan b on a.jabatan=b.id_jab", $field=null, $params=null, $where=null, "ORDER BY a.nama ASC");
	$TujuanSurat = "";
	while($dataListUser = $ListUser->fetch(PDO::FETCH_OBJ)){
		if(false !== array_search($dataListUser->id_user, json_decode($data_memo->tujuan_surat, true))){
			$TujuanSurat .= '- '.$dataListUser->nama .'<br/>';
		}
	}
	
	$kopSet = $this->model->selectprepare("kop_setting", $field=null, $params=null, $where=null, "WHERE idkop='1'");
	$dataKopSet= $kopSet->fetch(PDO::FETCH_OBJ);
	$layout = $dataKopSet->layout;
	$Rlayout = $layout;
	
	$arr = array("=NoAgenda=" => $data_memo->custom_noagenda, "=NoSurat=" => $data_memo->no_sm, "=Perihal=" => $data_memo->perihal, "=TujuanSurat=" => $TujuanSurat, "=TglSurat=" =>tgl_indo($data_memo->tgl_surat), "=TglTerima=" => tgl_indo($data_memo->tgl_terima), "=AsalSurat=" =>$data_memo->pengirim, "=Keterangan=" => $data_memo->ket, "=Penerima=" => $_SESSION['nama']);
	foreach($arr as $nama => $value){
		if(strpos($layout, $nama) !== false) {
			$Rlayout = str_replace($nama, $value, $layout);
			$layout = $Rlayout;
		}
	}
	
	if($dataKopSet->status == "Y") {
		if($dataKopSet->kopdefault == "Y"){?>
			<?php $kopD = '<p style="text-align:center;"><img src="http://localhost/app-surat/foto/'.$kop.'" width="795"></p>' ?>
		<?php
		}
		$html = '
		<html>
			<head>
				<meta http-equiv="Content-Language" content="en-us">
				<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
				<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
				<meta name="ProgId" content="FrontPage.Editor.Document">
				
			</head>
			<body>
				'.$kopD.'
				'.$Rlayout.'
			</body>
		</html>
		';
	}else {
		if($dataKopSet->kopdefault == "Y"){?>
			<?php $kopD = '<p style="text-align:center;"><img src="http://localhost/app-surat/foto/'.$kop.'" width="795"></p>' ?>
		<?php
		}
		$html = '
		<html>
			<head>
				<meta http-equiv="Content-Language" content="en-us">
				<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
				<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
				<meta name="ProgId" content="FrontPage.Editor.Document">
				
			</head>
			<body>
				'.$kopD.'
				<h3 style="text-align:center;">TANDA TERIMA SURAT</h3>
				<table border="1" width="500" style="border-collapse:collapse;" align="center">
					<tr align=left>
						<td style="padding: 5px; vertical-align: top; width: 238.776px;" nowrap="nowrap">Telah terima dari</td>
						<td nowrap style="padding: 5px; vertical-align: top;">'.$data_memo->pengirim.'</td>
					</tr>
					<tr align=left>
						<td style="padding: 5px; vertical-align: top; width: 238.776px;" nowrap="nowrap">Nomor Surat </td>
						<td style="padding: 5px;">'.$data_memo->no_sm.'</td>
					</tr>
					<tr align=left>
						<td style="padding: 5px; vertical-align: top; width: 238.776px;" nowrap="nowrap">Nomor Agenda </td>
						<td style="padding: 5px;">'.$data_memo->custom_noagenda.'</td>
					</tr>
					<tr align=left>
						<td style="padding: 5px; vertical-align: top; width: 238.776px;" nowrap="nowrap">Tanggal Surat </td>
						<td style="padding: 5px;">'.tgl_indo($data_memo->tgl_surat).'</td>
					</tr>
					<tr align=left>
						<td style="padding: 5px; vertical-align: top; width: 238.776px;" nowrap="nowrap">Tujuan Surat </td>
						<td style="padding: 5px;">'.$TujuanSurat.'</td>
					</tr>
					<tr align=left>
						<td style="padding: 5px; vertical-align: top; width: 238.776px;" nowrap="nowrap">Tanggal Terima </td>
						<td style="padding: 5px;">'.tgl_indo($data_memo->tgl_terima).'</td>
					</tr>
					<tr align=left height="70">
						<td style="padding: 5px; vertical-align: top; width: 238.776px;" nowrap="nowrap">Perihal </td>
						<td style="padding: 5px; vertical-align: top;">'.$data_memo->perihal.'</td>
					</tr>
				</table><br/>
				<table border="0" width=400 style="border-collapse:collapse;" align="center">
					<tr align=left>
						<td style="padding: 5px; vertical-align: top; width: 238.776px;" nowrap>
							Yang Menyerahkan<br/><br/><br/><br/><br/><br/><b><u>'.$data_memo->pengirim.'</u></b>
						</td>
						<td width="160" nowrap style="padding: 5px;">
							Yang Menerima<br/><br/><br/><br/><br/><br/><b><u>'.$_SESSION['nama'].'</u></b>
						</td>
					</tr>
				</table>
			</body>
		</html>
		';
	}
	
	?>

	<?php
	if(isset($_GET['act']) AND $_GET['act'] == "pdf"){
		$dompdf->loadHtml($html);
		// Setting ukuran dan orientasi kertas
		$dompdf->setPaper('A4', 'potrait');
		// Rendering dari HTML Ke PDF
		$dompdf->render();
		ob_end_clean();
		// Melakukan output file Pdf, 1 = download, 0 = preview
		$dompdf->stream("Letter-".$data_memo->id_sm.'.pdf', array("Attachment" => 0));
		exit;

		// $filename="Letter-".$data_memo->id_sm.".pdf"; //ubah untuk menentukan nama file pdf yang dihasilkan nantinya
		// $content = ob_get_clean();
		// $content = '<page style="font-family: freeserif">'.nl2br($content).'</page>';
		// require_once 'html2pdf/html2pdf.class.php';
		// try{
		// 	$html2pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15',array(0, 5, 0, 0));
		// 	$html2pdf->setDefaultFont('Arial');
		// 	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		// 	$html2pdf->Output($filename);
		// }catch(HTML2PDF_exception $e){ 
		// 	echo "Terjadi Error kerena : ".$e; 
		// }
	}
	?>

<?php
}else{
	echo "Belum ada data";	
}

?>