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

    $params = array(':id' => 1);
    $CekSetting = $this->model->selectprepare("pengaturan", $field=null, $params, "id=:id");
    if($CekSetting->rowCount() >= 1){
		$dataCekSetting = $CekSetting->fetch(PDO::FETCH_OBJ);
		$no_surat_sk_start = $dataCekSetting->no_surat_sk_start;
		$no_surat_sk = $dataCekSetting->no_surat_sk;
	}

    $p = array(':jenis_surat' => $jenis_surat);
    $CekSurat = $this->model->selectprepare("surat_keluar", $field=null, $p, "jenis_surat=:jenis_surat");

    $max_kode = mysqli_query($conn, "SELECT max(nomor_surat) as maxKode FROM surat_keluar WHERE jenis_surat='$jenis_surat'");
    $data_max  = mysqli_fetch_array($max_kode);
    $max = $data_max['maxKode'];
    $noUrut = (int) substr($max, 0, 4);
    if($noUrut >= $no_surat_sk_start) {
        $noUrut++;
    }else {
        $noUrut = $no_surat_sk_start;
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

    $noSurat = sprintf("%04s", $noUrut).'/'.$no_surat_sk;

    $var = array('=KodeSurat=', '=Bulan=', '=Tahun=');
    $rep = array($kode, $bulanRomawi, date('Y'));
    $nomor_surat = str_replace($var, $rep, $noSurat);
    
    // $nomor_surat = sprintf("%03s", $noUrut).'/'.$kode.'/'.$bulanRomawi.'/'.date('Y');

    $variabel = array('=NoSurat=', '=Nama=', '=Email=', '=Perihal=', '=TglSurat=', '=Tujuan=', '=Karakteristik=', '=Derajat=');
    $replace = array($nomor_surat, $nama_pembuat, $email_pembuat, $perihal, tgl_indo($tgl_fisik), $tujuan, $nama_kar, $nama_der);

    $konten_surat = str_replace($variabel, $replace, $layout_konten);
    
    $field = array('nomor_surat'=>$nomor_surat, 'jenis_surat'=>$jenis_surat, 'pembuat'=>$pembuat, 'tujuan'=>$tujuan, 'tgl_surat_fisik'=>$tgl_fisik, 'perihal'=>$perihal, 'karakteristik'=>$karakteristik, 'derajat'=>$derajat, 'layout_konten'=>$konten_surat, 'created'=>$created);
    $params = array(':nomor_surat'=>$nomor_surat, ':jenis_surat'=>$jenis_surat, ':pembuat'=>$pembuat, ':tujuan'=>$tujuan, ':tgl_surat_fisik'=>$tgl_fisik, ':perihal'=>$perihal, ':karakteristik'=>$karakteristik, ':derajat'=>$derajat, ':layout_konten'=>$konten_surat, ':created'=>$created);
    $insert = $this->model->insertprepare("surat_keluar", $field, $params);
    if($insert->rowCount() >= 1){
        echo "<script type=\"text/javascript\">alert('Surat keluar Berhasil Tersimpan...!!');window.location.href=\"./index.php?op=surat_keluar\";</script>";
    }else{
        die("<script>alert('Data Gagal di simpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
    }
}else { ?>

    <div class="card-title">Entri Surat Keluar</div>
    <div class="card-description">Lengkapi data-data surat keluar berikut.</div>
    <hr>
    <form action="<?php echo $_SESSION['url'];?>" method="post" id="form-surat" class="mt-4" enctype="multipart/form-data">
        <div class="form-group row">
            <div class="col-lg-2">
                <label class="col-form-label">Nomor Surat</label>
            </div>
            <div class="col-lg-6">
                <p class="card-description">Inputkan variabel =NoSurat= pada isi surat, jika ingin menambahkan Nomor Surat. Nomor Surat akan di generate secara otomatis.</p>
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
                ?>
                <select class="js-example-basic-single w-100" placeholder="Forward" name="jenis_surat" required >
                    <option value="" selected disabled>None</option>
                    <?php while($data = $jenis->fetch()) { ?>
                        <option value=<?php echo $data['id_klas']; ?>><?php echo $data['nama']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group mb-0 row">
            <div class="col-lg-2">
                <label class="col-form-label">Tanggal Surat Fisik</label>
            </div>
            <div class="col-lg-6">
                <input class="form-control" type="date" name="tgl_surat_fisik" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-2">
                <label class="col-form-label">Tujuan Surat</label>
            </div>
            <div class="col-lg-6">
                <input class="form-control" name="tujuan_surat" type="text" placeholder="Tujuan surat" required>
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
                    
                    $noK = 1;
                    while($data_kar = $kar->fetch()) { ?>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                            <?php 
                                if($noK == 1) { ?>
                                    <input type="radio" class="form-check-input" name="karakteristik_surat" id="karakteristik_surat" value="<?php echo $data_kar['id_karakteristik']; ?>" checked>
                                    <?php echo $data_kar['nama']; ?>
                            <?php
                                }else { ?>
                                    <input type="radio" class="form-check-input" name="karakteristik_surat" id="karakteristik_surat" value="<?php echo $data_kar['id_karakteristik']; ?>">
                                    <?php echo $data_kar['nama']; ?>
                            <?php
                                }
                                $noK++;
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

                    $noD = 1;
                    while($data_derajat = $derajat->fetch()) { ?>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                            <?php 
                                if($noD == 1) { ?>
                                    <input type="radio" class="form-check-input" name="derajat_surat" id="derajat_surat" value="<?php echo $data_derajat['id_derajat']; ?>" checked>
                                    <?php echo $data_derajat['nama']; ?>
                                <?php
                                }else { ?>
                                    <input type="radio" class="form-check-input" name="derajat_surat" id="derajat_surat" value="<?php echo $data_derajat['id_derajat']; ?>">
                                    <?php echo $data_derajat['nama']; ?>
                                <?php
                                }
                                $noD++;
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
                <input class="form-control" name="perihal_surat" type="text" placeholder="Perihal surat" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-form-label">
                Isi Surat
            </label>
            <div class="row">
                <div class="col-8">
                    <textarea class="form-control" name="layout_konten" id="kontenTemplate" rows="15"></textarea>
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