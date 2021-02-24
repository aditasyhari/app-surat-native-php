<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	// $kode = htmlspecialchars($purifier->purify(trim($_POST['kode'])), ENT_QUOTES);
	$nama = htmlspecialchars($purifier->purify(trim($_POST['nama'])), ENT_QUOTES);
	$tgl = date("Y-m-d H:i:s", time());
	if(isset($_GET['idderajat'])){
		$id_derajat = htmlspecialchars($purifier->purify(trim($_GET['idderajat'])), ENT_QUOTES);
		$params = array(':id_derajat' => $id_derajat);
		$Derajat = $this->model->selectprepare("derajat", $field=null, $params, "id_derajat=:id_derajat");
		if($Derajat->rowCount() >= 1){
			$data_Derajat= $Derajat->fetch(PDO::FETCH_OBJ);
			$idDerajat = $data_Derajat->id_derajat;
			$field = array('nama' => $nama, 'updated' => $tgl);
			$params = array(':id_derajat' => $id_derajat);
			$update = $this->model->updateprepare("derajat", $field, $params, "id_derajat=:id_derajat");
			if($update){
				echo "<script type=\"text/javascript\">alert('Data Berhasil diperbaharui...!!');window.location.href=\"./index.php?op=derajat\";</script>";
			}else{
				die("<script>alert('Data menyimpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
			}
		}
	}else{
		$field = array('nama' => $nama, 'created'=>$tgl);
		$params = array(':nama'=>$nama, ':created'=>$tgl);
		$insert = $this->model->insertprepare("derajat", $field, $params);
		if($insert->rowCount() >= 1){
			echo "<script type=\"text/javascript\">alert('Data Berhasil Tersimpan...!!');window.location.href=\"./index.php?op=derajat\";</script>";
		}else{
			die("<script>alert('Data Gagal di simpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
		}
	}
}else{
	if(isset($_GET['idderajat']) && empty($_GET['act'])){
		$id_derajat = htmlspecialchars($purifier->purify(trim($_GET['idderajat'])), ENT_QUOTES);
		$params = array(':id_derajat' => $id_derajat);
		$cek_derajat = $this->model->selectprepare("derajat", $field=null, $params, "id_derajat=:id_derajat");
		if($cek_derajat->rowCount() >= 1){
			$data_cek_der = $cek_derajat->fetch(PDO::FETCH_OBJ);
			$title= "Edit Data Derajat Surat";
			// $kode = 'value="'.$data_cek_klas->kode .'" disabled';
			$nama = 'value="'.$data_cek_der->nama .'"';
		}else{
			$title= "Entri Data Derajat Surat";
		}
	}else{
		$title= "Entri Data Derajat Surat";
	}
	if(isset($_GET['idderajat']) && (isset($_GET['act']) && $_GET['act'] == "del")){
		$id_derajat = htmlspecialchars($purifier->purify(trim($_GET['idderajat'])), ENT_QUOTES);
		// $params = array(':klasifikasi' => $id_klas);
		// $lihat_sm = $this->model->selectprepare("arsip_sk", $field=null, $params, "klasifikasi=:klasifikasi");
		// if($lihat_sm->rowCount() >= 1){
		// 	die("<script>alert('Nama klasifikasi ini tidak dapat dihapus karena terkait dengan data Surat Keluar. Jika tetap ingin menghapus, silahkan hapus data Surat Keluar terkait terlebih dahulu. Terimakasih');window.history.go(-1);</script>");
		// }else{
			$params = array(':id_derajat' => $id_derajat);
			$delete = $this->model->hapusprepare("derajat", $params, "id_derajat=:id_derajat");
			if($delete){
				echo "<script type=\"text/javascript\">alert('Data Berhasil di Hapus...!!');window.location.href=\"./index.php?op=derajat\";</script>";
			}else{
				die("<script>alert('Gagal menghapus data derajat surat, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
			}
		// }
	}?>
	
    <h5 class="card-title"><?php echo $title;?></h5>
    <hr>

    <form class="form-horizontal" role="form" method="POST" name="formku" action="<?php echo $_SESSION['url'];?>">
        <div class="form-group">
            <label class="col-sm-2" for="form-field-mask-1">Nama Derajat</label>
            <div class="col-sm-4">
                <input class="form-control" placeholder="Nama/ket derajat surat" type="text" name="nama" <?php if(isset($nama)){ echo $nama; }?> id="form-field-mask-1" required/>
            </div>
        </div>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-check bigger-110"></i>
                Submit
            </button>
        </div>
    </form>

	<div class="mt-4"><?php
	$GetDerajat = $this->model->selectprepare("derajat", $field=null, $params=null, $where=null, "order by nama ASC");
	if($GetDerajat->rowCount() >= 1){
		while($data_GetDerajat = $GetDerajat->fetch(PDO::FETCH_OBJ)){
			$dump_derajat[]=$data_GetDerajat;
		}?>

        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama/Ket derajat</th>
                    <th width="100">ACT</th>
                </tr>
            </thead>
            <tbody><?php
                $no=1;
                foreach($dump_derajat as $key => $object){?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $object->nama;?></td>
                        <td><center>
                            <div class="btn-group">
                                <a href="./index.php?op=derajat&idderajat=<?php echo $object->id_derajat;?>">								
                                    <button class="btn btn-secondary mr-1">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </a>
                                <a href="./index.php?op=derajat&idderajat=<?php echo $object->id_derajat;?>&act=del" onclick="return confirm('Anda yakin akan menghapus data ini??')">
                                    <button class="btn btn-danger">
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
	</div><?php
}?>