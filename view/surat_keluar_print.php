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

$query = mysqli_query($conn, "SELECT * FROM surat_keluar WHERE id_skeluar='".$_GET['idsk']."'");
$row = mysqli_num_rows($query);

while($data = mysqli_fetch_array($query))
{
    $layout_konten = $data['layout_konten'];
    $layout_kop = $data['layout_kop'];
    $logo_kop = $data['logo_kop'];
    $tujuan = $data['tujuan'];
    $id_template = $data['id_template'];
    $tgl = tgl_indo($data['tgl_surat_fisik']);

    if($id_template == '') {
        $m_atas = 10;
        $m_bawah = 10;
        $m_kiri = 15;
        $m_kanan = 10;
    }else {
        $querytp = mysqli_query($conn, "SELECT * FROM template WHERE id_template='$id_template'");
        while($datatp = $querytp->fetch_assoc()) {
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
}

if($row > 0) {

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

    if($id_template == '') {
        $html .= '
            <div class="konten">
                '.$layout_konten.'
            </div>
        ';
    }else {
        $html .= '
        <table>
            <tr>
                <td>
                    <img src="http://localhost/app-surat/foto/kop/'.$logo_kop.'" style="max-width:100px; max-height:100px">
                </td>
                <td>
                    '.$layout_kop.'
                </td>
            </tr>
        </table>
        <hr>
        '.$layout_konten.'
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
        $dompdf->stream('SuratKeluar_'.$tujuan.'_'.$tgl.'.pdf', array("Attachment" => 0));
        exit;
    }

}else {
    echo 'Belum ada data';
}
?>