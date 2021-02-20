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

$query = mysqli_query($conn, "select * from template where id_template='".$_GET['tpid']."'");
$row = mysqli_num_rows($query);

if($row > 0) {

    while($data = mysqli_fetch_array($query))
    {
        $m_atas = $data['m_atas'];
        $m_bawah = $data['m_bawah'];
        $m_kiri = $data['m_kiri'];
        $m_kanan = $data['m_kanan'];
        $logo_kop = $data['logo_kop'];
        $layout_kop = $data['layout_kop'];
        $layout_konten = $data['layout_konten'];
        $name = $data['nama_template'];
        $tgl = tgl_indo($data['tgl_dibuat']);
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
            .kop{
                width: 100%;
                height: auto;
                display: flex;
                flex-direction: column;
            }


        </style>
    ";


    $html .= '
        <div class="kop">
            <img src="http://localhost/app-surat/foto/kop/'.$logo_kop.'" style="width:120px;height:100px">
            <div>
                '.$layout_kop.'
            </div>
        </div>
        <hr>
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
        $dompdf->stream('Template_'.$name.'_'.$tgl.'.pdf', array("Attachment" => 0));
        exit;
    }

}else {
    echo 'Belum ada data';
}
?>