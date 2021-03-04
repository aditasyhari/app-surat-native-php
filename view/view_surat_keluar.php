<?php
require_once 'db/db2.php';
if(isset($_GET['idsk']) && (isset($_GET['act']) && $_GET['act'] == "edit")) {
    require_once 'view/view_skeluar_edit.php';
}elseif(isset($_GET['idsk']) && empty($_GET['act'])) {
    require_once 'view/view_skeluar_detail.php';
}elseif(isset($_GET['idsk']) && (isset($_GET['act']) && $_GET['act'] == "del")){
    $id_sk = htmlspecialchars($purifier->purify(trim($_GET['idsk'])), ENT_QUOTES);
    $params = array(':id_skeluar' => $id_sk);
    $delete = $this->model->hapusprepare("surat_keluar", $params, "id_skeluar=:id_skeluar");
    if($delete){
        echo "<script type=\"text/javascript\">alert('Data Berhasil di Hapus...!!');window.location.href=\"./index.php?op=surat_keluar\";</script>";
    }else{
        die("<script>alert('Gagal menghapus data surat keluar, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
    }
}else { ?>

<h5 class="card-title">Daftar Surat keluar</h5>
<div class="mt-4"><?php
    $userid = $_SESSION['id_user'];
    $params = array(':pembuat' => $userid);
	$GetSK = $this->model->selectprepare("surat_keluar", $field=null, $params, "pembuat=:pembuat", "order by updated DESC");
	if($GetSK->rowCount() >= 1){
		while($data_GetSK = $GetSK->fetch(PDO::FETCH_OBJ)){
			$dump_sk[]=$data_GetSK;
		}?>

        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
            <thead>
                <tr>
                    <th width="10">No</th>
                    <th>Nomor Surat</th>
                    <th>Tujuan</th>
                    <th>Perihal</th>
                    <th>Tanggal Surat</th>
                    <th width="100">ACT</th>
                </tr>
            </thead>
            <tbody><?php
                
                
                $no=1;
                foreach($dump_sk as $key => $object){?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td>
                            <a href="./index.php?op=surat_keluar&idsk=<?php echo $object->id_skeluar; ?>">
                                <?php echo $object->nomor_surat;?>
                            </a>
                        </td>
                        <td><?php echo $object->tujuan;?></td>
                        <td><?php echo $object->perihal;?></td>
                        <td><?php echo tgl_indo($object->tgl_surat_fisik);?></td>
                        <td><center>
                            <div class="btn-group">
                                <a href="./view/surat_keluar_print.php?idsk=<?php echo $object->id_skeluar;?>&act=pdf" target="_blank" title="Lihat Surat">								
                                    <button class="btn btn-warning btn-icon mr-1 text-white">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a>
                                <a href="./index.php?op=surat_keluar&idsk=<?php echo $object->id_skeluar;?>&act=edit" title="Edit">								
                                    <button class="btn btn-secondary btn-icon mr-1">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </a>
                                <a href="./index.php?op=surat_keluar&idsk=<?php echo $object->id_skeluar;?>&act=del" title="Hapus" onclick="return confirm('Anda yakin akan menghapus data ini??')">
                                    <button class="btn btn-danger btn-icon">
                                        <i class="fa fa-trash-o"></i>
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