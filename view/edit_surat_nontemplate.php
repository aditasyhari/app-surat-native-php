<?php 
require_once "db/db2.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $pembuat = $_SESSION['id_user'];
	$tujuan = htmlspecialchars($purifier->purify(trim($_POST['tujuan_surat'])), ENT_QUOTES);
    $perihal = htmlspecialchars($purifier->purify(trim($_POST['perihal_surat'])), ENT_QUOTES);
    $jenis_surat = $_POST['jenis_surat'];
    $karakteristik = $_POST['karakteristik_surat'];
    $derajat = $_POST['derajat_surat'];
    $tgl_fisik = $_POST['tgl_surat_fisik'];
    $layout_konten = $_POST['layout_konten'];
    $created = date("Y-m-d H:i:s", time());
    $updated = date("Y-m-d H:i:s", time());

    $query = mysqli_query($conn, "SELECT * FROM surat_keluar WHERE id_skeluar='$idsk'"); 
    while($datatp = $query->fetch_assoc()) {
        $nomor_surat = $datatp['nomor_surat'];
    }

    $users = mysqli_query($conn, "SELECT * FROM user WHERE id_user='$pembuat'");
    while($rowUser = $users->fetch_assoc()) {
        $nama_pembuat = $rowUser['nama'];
        $email_pembuat = $rowUser['email'];
    }

    $jenisS = mysqli_query($conn, "SELECT * FROM klasifikasi_sk WHERE id_klas='$jenis_surat'");
    while($rowSK = $jenisS->fetch_assoc()) {
        $kode = $rowSK['kode'];
    }

    $kar = mysqli_query($conn, "SELECT * FROM karakteristik WHERE id_karakteristik='$karakteristik'");
    while($rowKar = $kar->fetch_assoc()) {
        $nama_kar = $rowKar['nama'];
    }

    $der = mysqli_query($conn, "SELECT * FROM derajat WHERE id_derajat='$derajat'");
    while($rowDer = $der->fetch_assoc()) {
        $nama_der = $rowDer['nama'];
    }

    function getRomawi($bln){
        switch ($bln){
            case 1: 
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }

    $bulan = date('n');
    $bulanRomawi = getRomawi($bulan);
    // echo $bulanRomawi;

    $variabel = array('=NoSurat=', '=Nama=', '=Email=', '=Perihal=', '=TglSurat=', '=Tujuan=', '=Karakteristik=', '=Derajat=');
    $replace = array($nomor_surat, $nama_pembuat, $email_pembuat, $perihal, tgl_indo($tgl_fisik), $tujuan, $nama_kar, $nama_der);

    $konten_surat = str_replace($variabel, $replace, $layout_konten);
    
    $field = array('tujuan'=>$tujuan, 'tgl_surat_fisik'=>$tgl_fisik, 'perihal'=>$perihal, 'karakteristik'=>$karakteristik, 'derajat'=>$derajat, 'layout_konten'=>$konten_surat, 'updated'=>$created);
    $params = array(':id_skeluar'=>$idsk);
    $insert = $this->model->updateprepare("surat_keluar", $field, $params, "id_skeluar=:id_skeluar");
    if($insert->rowCount() >= 1){
        echo "<script type=\"text/javascript\">alert('Surat keluar Berhasil Diupdate...!!');window.location.href=\"./index.php?op=surat_keluar\";</script>";
    }else{
        die("<script>alert('Data Gagal di simpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
    }
}else { ?>
<?php
$querySK = mysqli_query($conn, "SELECT * FROM surat_keluar WHERE id_skeluar='$idsk'"); 
while($sk = $querySK->fetch_assoc()) { ?>

    <div class="card-title">Edit Surat Keluar</div>
    <div class="card-description">Edit data-data surat keluar berikut.</div>
    <hr>
    <form action="<?php echo $_SESSION['url'];?>" method="post" id="form-surat" class="mt-4" enctype="multipart/form-data">
        <div class="form-group row">
            <div class="col-lg-2">
                <label class="col-form-label">Nomor Surat</label>
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" value="<?php echo $sk['nomor_surat'] ?>" disabled>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-2">
                <label class="col-form-label">Jenis Surat</label>
            </div>
            <div class="col-lg-6">
                <?php 
                    $jenis = $dbpdo->prepare("select * from klasifikasi_sk"); 
                    $jenis->execute();

                    $selected_jenis = $dbpdo->prepare("select * from klasifikasi_sk where id_klas='$sk[jenis_surat]'"); 
                    $selected_jenis->execute();
                    while($selected = $selected_jenis->fetch()) {
                        $id_jenis = $selected['id_klas'];
                    }
                ?>
                <select class="js-example-basic-single w-100" placeholder="Forward" name="jenis_surat" required disabled>
                    <?php 
                    while($jeniss = $jenis->fetch()) { 
                        if($jeniss['id_klas'] == $id_jenis) { ?>
                            <option value=<?php echo $jeniss['id_klas']; ?> selected><?php echo $jeniss['nama']; ?></option>
                        <?php
                        }else { ?>
                            <option value=<?php echo $jeniss['id_klas']; ?>><?php echo $jeniss['nama']; ?></option>
                        <?php
                        }
                    ?>
                    <?php 
                    } ?>
                </select>
            </div>
        </div>

        <div class="form-group mb-0 row">
            <div class="col-lg-2">
                <label class="col-form-label">Tanggal Surat Fisik</label>
            </div>
            <div class="col-lg-6">
                <input class="form-control" type="date" value="<?php echo $sk['tgl_surat_fisik'] ?>" name="tgl_surat_fisik" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-2">
                <label class="col-form-label">Tujuan Surat</label>
            </div>
            <div class="col-lg-6">
                <input class="form-control" name="tujuan_surat" type="text" placeholder="Tujuan surat" value="<?php echo $sk['tujuan']; ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-2">
                <label class="col-form-label">Status Surat</label>
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" value="Keluar" disabled>
            </div>
        </div>
        
        <div class="form-group row">
            <div class="col-lg-2">
                <label class="col-form-label">Karakteristik Surat</label>
            </div>
            <div class="col-lg-6">
                <?php 
                    $kar = $dbpdo->prepare("select * from karakteristik"); 
                    $kar->execute();

                    $selected_kar = $dbpdo->prepare("select * from karakteristik where id_karakteristik='$sk[karakteristik]'"); 
                    $selected_kar->execute();
                    while($kar_sel = $selected_kar->fetch()) {
                        $id_kar = $kar_sel['id_karakteristik'];
                    }

                    while($data_kar = $kar->fetch()) { ?>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                            <?php 
                                if($data_kar['id_karakteristik'] == $id_kar) { ?>
                                    <input type="radio" class="form-check-input" name="karakteristik_surat" id="karakteristik_surat" value="<?php echo $data_kar['id_karakteristik']; ?>" checked>
                                    <?php echo $data_kar['nama']; ?>
                            <?php
                                }else { ?>
                                    <input type="radio" class="form-check-input" name="karakteristik_surat" id="karakteristik_surat" value="<?php echo $data_kar['id_karakteristik']; ?>">
                                    <?php echo $data_kar['nama']; ?>
                            <?php
                                }
                            ?>
                            </label>
                        </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-2">
                <label class="col-form-label">Derajat Surat</label>
            </div>
            <div class="col-lg-6">
                <?php 
                    $derajat = $dbpdo->prepare("select * from derajat"); 
                    $derajat->execute();

                    $selected_der = $dbpdo->prepare("select * from derajat where id_derajat='$sk[derajat]'"); 
                    $selected_der->execute();
                    while($der_sel = $selected_der->fetch()) {
                        $id_der = $der_sel['id_derajat'];
                    }

                    while($data_derajat = $derajat->fetch()) { ?>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                            <?php 
                                if($data_derajat['id_derajat'] == $id_der) { ?>
                                    <input type="radio" class="form-check-input" name="derajat_surat" id="derajat_surat" value="<?php echo $data_derajat['id_derajat']; ?>" checked>
                                    <?php echo $data_derajat['nama']; ?>
                                <?php
                                }else { ?>
                                    <input type="radio" class="form-check-input" name="derajat_surat" id="derajat_surat" value="<?php echo $data_derajat['id_derajat']; ?>">
                                    <?php echo $data_derajat['nama']; ?>
                                <?php
                                }
                            ?>
                            </label>
                        </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-2">
                <label class="col-form-label">Perihal</label>
            </div>
            <div class="col-lg-6">
                <input class="form-control" name="perihal_surat" type="text" placeholder="Perihal surat" value="<?php  echo $sk['perihal']; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-form-label">
                Isi Surat
            </label>
            <div class="row">
                <div class="col-8">
                    <textarea class="form-control" name="layout_konten" id="kontenTemplate" rows="15"><?php echo $sk['layout_konten']; ?></textarea>
                </div>
                <div class="col-4">
                    <li class="list-group-item">
                        <p class="card-description">Klik tombol dibawah ini untuk menyisipkan variabel kedalam surat.</p>
                        <div class="row mt-4">
                            <div class="btn btn-light m-2" id="nama" onclick="variabel('nama')">Nama</div>
                            <div class="btn btn-light m-2" id="email" onclick="variabel('email')">Email</div>
                            <div class="btn btn-light m-2" id="perihal" onclick="variabel('perihal')">Perihal</div>
                            <div class="btn btn-light m-2" id="nosurat" onclick="variabel('nosurat')">No Surat</div>
                            <div class="btn btn-light m-2" id="tglsurat" onclick="variabel('tglsurat')">Tgl Surat</div>
                            <div class="btn btn-light m-2" id="tujuan" onclick="variabel('tujuan')">Tujuan</div>
                            <div class="btn btn-light m-2" id="karakteristik" onclick="variabel('karakteristik')">Karakteristik</div>
                            <div class="btn btn-light m-2" id="derajat" onclick="variabel('derajat')">Derajat</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <p class="card-description mt-3">Untuk settingan surat default.</p>
                        <table class="card-description w-100 table">
                            <tr>
                                <td>1.</td>
                                <td>Orientasi Ukuran</td>
                                <td>: Potrait A4</td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Margin</td>
                                <td>: 10 mm</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Margin Kiri</td>
                                <td>: 15 mm</td>
                            </tr>
                        </table>
                        
                    </li>
                </div>
            </div>
        </div>

        <script>
            function variabel(a){
                
                switch(a) {
                    case 'nama': tinymce.get("kontenTemplate").execCommand('mceInsertContent', false, '=Nama=');
                        break;
                    case 'email': tinymce.get("kontenTemplate").execCommand('mceInsertContent', false, '=Email=');
                        break;
                    case 'perihal': tinymce.get("kontenTemplate").execCommand('mceInsertContent', false, '=Perihal=');
                        break;
                    case 'nosurat': tinymce.get("kontenTemplate").execCommand('mceInsertContent', false, '=NoSurat=');
                        break;
                    case 'tglsurat': tinymce.get("kontenTemplate").execCommand('mceInsertContent', false, '=TglSurat=');
                        break;
                    case 'tujuan': tinymce.get("kontenTemplate").execCommand('mceInsertContent', false, '=Tujuan=');
                        break;
                    case 'karakteristik': tinymce.get("kontenTemplate").execCommand('mceInsertContent', false, '=Karakteristik=');
                        break;
                    case 'derajat': tinymce.get("kontenTemplate").execCommand('mceInsertContent', false, '=Derajat=');
                        break;
                    default:
                        break;
                }
            }
        </script>

        <div class="form-check form-check-flat form-check-primary mt-3">    
            <label class="form-check-label mt-4">
                <input type="checkbox" class="form-check-input" id="centang" onclick="cek()">
                Data yang saya inputkan diatas sudah benar
            </label>
        </div>
        <button class="btn btn-primary btn-icon-text mt-3" type="submit" name="sumbit_sk_non" id="btn-submit" disabled>
            <i class="btn-icon-prepend" data-feather="save"></i> Submit
        </button>

        <script>
            var btn = document.getElementById('btn-submit');

            function cek() {
                var centang = document.getElementById('centang');

                if(centang.checked == true) {
                    btn.removeAttribute('disabled');
                } else {
                    btn.disabled = true
                }
            }

            var form_surat = document.getElementById('form-surat');

            btn.addEventListener('click', function() {
                form_surat.submit()
            })

        
        </script>

    </form>

<?php
}
?>

<?php
}
?>