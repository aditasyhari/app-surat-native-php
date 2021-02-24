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
    $tujuan = $data['tujuan'];
    $tgl = tgl_indo($data['tgl_surat_fisik']);
}

if($row > 0) {

    $html = "
    <html>
        <style>
            @page{
                margin-top: 10 mm;
                margin-bottom: 10 mm;
                margin-left: 15 mm;
                margin-right: 10 mm;
            }
            .konten{
                width: 100%;
            }
        </style>
    ";

    $html .= '
        <div class="konten">
            '.$layout_konten.'
        </div>
    ';

    $html .= "</html>";

    if(isset($_GET['act']) AND $_GET['act'] == "pdf"){
        $dompdf->loadHtml($html);
        // Setting ukuran dan orientasi kertas
        $dompdf->setPaper('A4', 'potrait');
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