<?php
require_once 'db/db2.php';
if(isset($_GET['tpid'])) {
    require_once 'view/view_skeluar_edit.php';
}else { ?>

<h5 class="card-title">Pilih Template Surat</h5>
<p class="card-description">Template yang bisa digunakan merupakan template yang sudah disetujui oleh validator.</p>

<div class="mt-4"><?php
    $userid = $_SESSION['id_user'];
    $params = array(':pembuat' => $userid);
    $GetTemplate = $dbpdo->prepare("SELECT * FROM template WHERE status_temp='disetujui'");
    // $GetTemplate = $dbpdo->prepare("SELECT * FROM template WHERE (id_pembuat='$userid' AND status_temp='disetujui')");
    $GetTemplate->execute();
    if($GetTemplate->rowCount() >= 1){
		while($data_GetTemplate = $GetTemplate->fetch(PDO::FETCH_OBJ)){
			$dump_template[] = $data_GetTemplate;
		}?>

        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
            <thead>
                <tr>
                    <th width="10">No</th>
                    <th>Nama Template</th>
                    <th>Jenis</th>
                    <th width="100">ACT</th>
                </tr>
            </thead>
            <tbody><?php
                
                $no=1;
                foreach($dump_template as $key => $object){
                    $GetJenis = $dbpdo->prepare("SELECT * FROM klasifikasi_sk WHERE id_klas='$object->id_klasifikasi'"); 
                    $GetJenis->execute();
                    while($dataJenis = $GetJenis->fetch()) {
                        $jenis = $dataJenis['nama'];
                    }
                    ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $object->nama_template;?></td>
                        <td><?php echo $jenis;?></td>
                        <td><center>
                            <div class="btn-group">
                                <a href="./view/view_template_print.php?tpid=<?php echo $object->id_template;?>&act=pdf" target="_blank" title="Preview">								
                                    <button class="btn btn-warning btn-sm btn-icon mr-1 text-white">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a>
                                <a href="./index.php?op=surat_keluar&idsk=<?php echo $object->id_skeluar;?>&act=edit" title="Buat Surat">								
                                    <button class="btn btn-info btn-sm text-white">
                                        Buat Surat
                                    </button>
                                </a>
                            </div></center>
                        </td>
                    </tr><?php
                    $no++;
                }?>
            </tbody>
        </table>
        <?php
	}?>
</div>

<?php
}
?>