<?php
ini_set('date.timezone', 'Asia/Jakarta');
require_once "indo_tgl.php";
include_once('../db/db2.php');
require_once("../dompdf/autoload.inc.php");
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$dompdf = new Dompdf($options); 

$dompdf->set_option('defaultMediaType', 'print');

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    // $pembuat = $_POST['id_user'];
    if(isset($_GET['tpid'])){
        $idTemplate = $_GET['tpid'];
    }else {
        $idTemplate = '';
    }
	// $tujuan = $_POST['tujuan_surat'];
    // $perihal = $_POST['perihal_surat'];
    // $nomor_surat = $_POST['noSurat'];
    // $jenis_surat = $_POST['jenis_surat'];
    // $karakteristik = $_POST['karakteristik_surat'];
    // $derajat = $_POST['derajat_surat'];
    // $tgl_fisik = $_POST['tgl_surat_fisik'];
    $layout_konten = $_POST['layout_konten'];
    $created = date("Y-m-d H:i:s", time());
    if(isset($_POST['id_ttd'])) {
        $id_ttd = $_POST['id_ttd'];
    }else {
        $id_ttd = '';
    }

    if(is_array($id_ttd)){
        $varttd = array();
        $repttd = array();
        foreach($id_ttd as $field => $value){
            // TTD
            $dataTTD = mysqli_query($conn, "SELECT * FROM user WHERE id_user='$value'"); 
            while($rowTTD = $dataTTD->fetch_assoc()) {
                $img_ttd = $rowTTD['ttd'];
            }

            array_push($varttd, '=TTD:'.$value.'=');
            array_push($repttd,'<img style="max-width:222px"'." src=http://$_SERVER[HTTP_HOST]/app-surat/foto/ttd/$img_ttd>");

        }
        $konten_surat = str_replace($varttd, $repttd, $layout_konten);
        // print_r($varttd);
        // print_r($repttd);
    }else {
        $konten_surat = $layout_konten;
    }

    // $users = mysqli_query($conn, "SELECT * FROM user WHERE id_user='$pembuat'");
    // while($rowUser = $users->fetch_assoc()) {
    //     $nama_pembuat = $rowUser['nama'];
    //     $email_pembuat = $rowUser['email'];
    //     $id_jabatan = $rowUser['jabatan'];
    // }

    // $jabatan = mysqli_query($conn, "SELECT * FROM user_jabatan WHERE id_jab='$id_jabatan'");
    // while($rowJabatan = $jabatan->fetch_assoc()) {
    //     $kode_jabatan = $rowJabatan['kode_jabatan'];
    // }

    // $jenisS = mysqli_query($conn, "SELECT * FROM klasifikasi_sk WHERE id_klas='$jenis_surat'");
    // while($rowSK = $jenisS->fetch_assoc()) {
    //     $kode = $rowSK['kode'];
    // }

    // $kar = mysqli_query($conn, "SELECT * FROM karakteristik WHERE id_karakteristik='$karakteristik'");
    // while($rowKar = $kar->fetch_assoc()) {
    //     $nama_kar = $rowKar['nama'];
    // }

    // $der = mysqli_query($conn, "SELECT * FROM derajat WHERE id_derajat='$derajat'");
    // while($rowDer = $der->fetch_assoc()) {
    //     $nama_der = $rowDer['nama'];
    // }

    // // $params = array(':id' => 1);
    // // $CekSetting = $this->model->selectprepare("pengaturan", $field=null, $params, "id=:id");
    // $CekSetting = mysqli_query($conn, "SELECT * FROM pengaturan WHERE id=1");
    // if(mysqli_num_rows($CekSetting) >= 1){
	// 	// $dataCekSetting = $CekSetting->fetch(PDO::FETCH_OBJ);
    //     while($dataCekSetting = $CekSetting->fetch_assoc()) {
    //         $no_surat_sk_start = $dataCekSetting['no_surat_sk_start'];
    //         $no_surat_sk = $dataCekSetting['no_surat_sk'];
    //     }
	// }

    // // $p = array(':jenis_surat' => $jenis_surat);
    // // $CekSurat = $this->model->selectprepare("surat_keluar", $field=null, $p, "jenis_surat=:jenis_surat");

    // $max_kode = mysqli_query($conn, "SELECT max(urutan) as maxKode FROM surat_keluar WHERE jenis_surat='$jenis_surat' AND pembuat='$pembuat'");
    // $data_max  = mysqli_fetch_array($max_kode);
    // $max = $data_max['maxKode'];
    // // $noUrut = (int) substr($max, 0, 4);
    // if($max >= $no_surat_sk_start) {
    //     $max++;
    // }else {
    //     $max = $no_surat_sk_start;
    // }

    // include_once('bulan-romawi.php');

    // $bulan = date('n');
    // $bulanRomawi = getRomawi($bulan);

    // $noSurat = $max.'/'.$no_surat_sk;

    
    // $var = array('=KodeJab=', '=KodeSurat=', '=Bulan=', '=Tahun=');
    // $rep = array($kode_jabatan, $kode, $bulanRomawi, date('Y'));
    // $nomor_surat = str_replace($var, $rep, $noSurat);
    
    // $variabel = array('=NoSurat=', '=Nama=', '=Email=', '=Perihal=', '=TglSurat=', '=Tujuan=', '=Karakteristik=', '=Derajat=');
    // $replace = array($nomor_surat, $nama_pembuat, $email_pembuat, $perihal, tgl_indo($tgl_fisik), $tujuan, $nama_kar, $nama_der);

    // // $konten_surat = str_replace($variabel, $replace, $konten_surat);
    
    if($idTemplate == '') {
        $m_atas = 10;
        $m_bawah = 10;
        $m_kiri = 15;
        $m_kanan = 10;
    }else {
        $querytp = mysqli_query($conn, "SELECT * FROM template WHERE id_template='$idTemplate'");
        while($datatp = $querytp->fetch_assoc()) {
            $layout_kop = $datatp['layout_kop'];
            $m_atas = $datatp['m_atas'];
            $m_bawah = $datatp['m_bawah'];
            $m_kiri = $datatp['m_kiri'];
            $m_kanan = $datatp['m_kanan'];
            if($datatp['orientasi_hal'] == 'P') {
                $orientasi = 'potrait';
            }else {
                $orientasi = 'landscape';
            }
            if($datatp['ukuran_hal'] == 'A4') {
                $ukuran = 'A4';
            }else {
                $ukuran = 'Letter';
            }
        }
    }

    $html = "
    <html>
        <style>
            @page{
                margin-top: $m_atas mm;
                margin-bottom: $m_bawah mm;
                margin-left: $m_kiri mm;
                margin-right: $m_kanan mm;
            }
            .konten{
                width: 100%;
            }
        </style>
    ";

    if($idTemplate == '') {
        $html .= '
            <div>
                '.$konten_surat.'
            </div>
        ';
    }else {
        $html .= '
            <div>
                '.$layout_kop.'
            </div>
            '.$konten_surat.'
        ';
    }

    $html .= "</html>";

    if(isset($_GET['act']) AND $_GET['act'] == "pdf"){

        $dompdf->loadHtml($html);
        // Setting ukuran dan orientasi kertas
        $dompdf->setPaper($orientasi, $ukuran);
        // Rendering dari HTML Ke PDF
        $dompdf->render();

        ob_end_clean();
        
        // Melakukan output file Pdf, 1 = download, 0 = preview
        $dompdf->stream('SuratKeluar_Preview.pdf', array("Attachment" => false));
        exit;
    }

}else {
    echo 'Belum ada data';
}

?>