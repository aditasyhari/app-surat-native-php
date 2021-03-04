<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	// $kode = htmlspecialchars($purifier->purify(trim($_POST['kode'])), ENT_QUOTES);
	$nama = htmlspecialchars($purifier->purify(trim($_POST['nama'])), ENT_QUOTES);
	$tgl = date("Y-m-d H:i:s", time());
	if(isset($_GET['idkarakteristik'])){
		$id_karakteristik = htmlspecialchars($purifier->purify(trim($_GET['idkarakteristik'])), ENT_QUOTES);
		$params = array(':id_karakteristik' => $id_karakteristik);
		$Karakteristik = $this->model->selectprepare("karakteristik", $field=null, $params, "id_karakteristik=:id_karakteristik");
		if($Karakteristik->rowCount() >= 1){
			$data_Karakteristik= $Karakteristik->fetch(PDO::FETCH_OBJ);
			$idkarakteristik = $data_Karakteristik->id_karakteristik;
			$field = array('nama' => $nama, 'updated' => $tgl);
			$params = array(':id_karakteristik' => $id_karakteristik);
			$update = $this->model->updateprepare("karakteristik", $field, $params, "id_karakteristik=:id_karakteristik");
			if($update){
				echo "<script type=\"text/javascript\">alert('Data Berhasil diperbaharui...!!');window.location.href=\"./index.php?op=karakteristik\";</script>";
			}else{
				die("<script>alert('Data menyimpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
			}
		}
	}else{
		$field = array('nama' => $nama, 'created'=>$tgl);
		$params = array(':nama'=>$nama, ':created'=>$tgl);
		$insert = $this->model->insertprepare("karakteristik", $field, $params);
		if($insert->rowCount() >= 1){
			echo "<script type=\"text/javascript\">alert('Data Berhasil Tersimpan...!!');window.location.href=\"./index.php?op=karakteristik\";</script>";
		}else{
			die("<script>alert('Data Gagal di simpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
		}
	}
}else{
	if(isset($_GET['idkarakteristik']) && empty($_GET['act'])){
		$id_karakteristik = htmlspecialchars($purifier->purify(trim($_GET['idkarakteristik'])), ENT_QUOTES);
		$params = array(':id_karakteristik' => $id_karakteristik);
		$cek_klas = $this->model->selectprepare("karakteristik", $field=null, $params, "id_karakteristik=:id_karakteristik");
		if($cek_klas->rowCount() >= 1){
			$data_cek_kar = $cek_klas->fetch(PDO::FETCH_OBJ);
			$title= "Edit Data Karakteristik Surat";
			// $kode = 'value="'.$data_cek_klas->kode .'" disabled';
			$nama = 'value="'.$data_cek_kar->nama .'"';
		}else{
			$title= "Entri Data Karakteristik Surat";
		}
	}else{
		$title= "Entri Data Karakteristik Surat";
	}
	if(isset($_GET['idkarakteristik']) && (isset($_GET['act']) && $_GET['act'] == "del")){
		$id_karakteristik = htmlspecialchars($purifier->purify(trim($_GET['idkarakteristik'])), ENT_QUOTES);
		// $params = array(':klasifikasi' => $id_klas);
		// $lihat_sm = $this->model->selectprepare("arsip_sk", $field=null, $params, "klasifikasi=:klasifikasi");
		// if($lihat_sm->rowCount() >= 1){
		// 	die("<script>alert('Nama klasifikasi ini tidak dapat dihapus karena terkait dengan data Surat Keluar. Jika tetap ingin menghapus, silahkan hapus data Surat Keluar terkait terlebih dahulu. Terimakasih');window.history.go(-1);</script>");
		// }else{
			$params = array(':id_karakteristik' => $id_karakteristik);
			$delete = $this->model->hapusprepare("karakteristik", $params, "id_karakteristik=:id_karakteristik");
			if($delete){
				echo "<script type=\"text/javascript\">alert('Data Berhasil di Hapus...!!');window.location.href=\"./index.php?op=karakteristik\";</script>";
			}else{
				die("<script>alert('Gagal menghapus data karakteristik surat, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
			}
		// }
	}?>
	
    <h5 class="card-title"><?php echo $title;?></h5>
    <hr>

    <form class="form-horizontal" role="form" method="POST" name="formku" action="<?php echo $_SESSION['url'];?>">
        <div class="form-group">
            <label class="col-sm-2" for="form-field-mask-1">Nama Karakteristik</label>
            <div class="col-sm-4">
                <input class="form-control" placeholder="Nama/ket karakteristik surat" type="text" name="nama" <?php if(isset($nama)){ echo $nama; }?> id="form-field-mask-1" required/>
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
	$GetKarakteristik = $this->model->selectprepare("karakteristik", $field=null, $params=null, $where=null, "order by nama ASC");
	if($GetKarakteristik->rowCount() >= 1){
		while($data_GetKarakteristik = $GetKarakteristik->fetch(PDO::FETCH_OBJ)){
			$dump_karakteristik[]=$data_GetKarakteristik;
		}?>

        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama/Ket karakteristik</th>
                    <th width="100">ACT</th>
                </tr>
            </thead>
            <tbody><?php
                $no=1;
                foreach($dump_karakteristik as $key => $object){?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $object->nama;?></td>
                        <td><center>
                            <div class="btn-group">
                                <a href="./index.php?op=karakteristik&idkarakteristik=<?php echo $object->id_karakteristik;?>">								
                                    <button class="btn btn-secondary mr-1">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </a>
                                <a href="./index.php?op=karakteristik&idkarakteristik=<?php echo $object->id_karakteristik;?>&act=del" onclick="return confirm('Anda yakin akan menghapus data ini??')">
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