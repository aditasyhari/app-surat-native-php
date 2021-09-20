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
    $id_ttd = $_POST['id_ttd'];

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

    $users = mysqli_query($conn, "SELECT * FROM user WHERE id_user='$pembuat'");
    while($rowUser = $users->fetch_assoc()) {
        $nama_pembuat = $rowUser['nama'];
        $email_pembuat = $rowUser['email'];
        $id_jabatan = $rowUser['jabatan'];
    }

    $jabatan = mysqli_query($conn, "SELECT * FROM user_jabatan WHERE id_jab='$id_jabatan'");
    while($rowJabatan = $jabatan->fetch_assoc()) {
        $kode_jabatan = $rowJabatan['kode_jabatan'];
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

    $max_kode = mysqli_query($conn, "SELECT max(urutan) as maxKode FROM surat_keluar WHERE jenis_surat='$jenis_surat' AND pembuat='$pembuat'");
    $data_max  = mysqli_fetch_array($max_kode);
    $max = $data_max['maxKode'];
    // $noUrut = (int) substr($max, 0, 4);
    if($max >= $no_surat_sk_start) {
        $max++;
    }else {
        $max = $no_surat_sk_start;
    }

    include_once('bulan-romawi.php');

    $bulan = date('n');
    $bulanRomawi = getRomawi($bulan);

    $noSurat = $max.'/'.$no_surat_sk;

    
    $var = array('=KodeJab=', '=KodeSurat=', '=Bulan=', '=Tahun=');
    $rep = array($kode_jabatan, $kode, $bulanRomawi, date('Y'));
    $nomor_surat = str_replace($var, $rep, $noSurat);
    
    $variabel = array('=NoSurat=', '=Nama=', '=Email=', '=Perihal=', '=TglSurat=', '=Tujuan=', '=Karakteristik=', '=Derajat=');
    $replace = array($nomor_surat, $nama_pembuat, $email_pembuat, $perihal, tgl_indo($tgl_fisik), $tujuan, $nama_kar, $nama_der);

    $konten_surat = str_replace($variabel, $replace, $konten_surat);
    
    $field = array('urutan'=>$max,'nomor_surat'=>$nomor_surat, 'jenis_surat'=>$jenis_surat, 'pembuat'=>$pembuat, 'tujuan'=>$tujuan, 'tgl_surat_fisik'=>$tgl_fisik, 'perihal'=>$perihal, 'karakteristik'=>$karakteristik, 'derajat'=>$derajat, 'layout_konten'=>$konten_surat, 'created'=>$created);
    $params = array(':urutan'=>$max,':nomor_surat'=>$nomor_surat, ':jenis_surat'=>$jenis_surat, ':pembuat'=>$pembuat, ':tujuan'=>$tujuan, ':tgl_surat_fisik'=>$tgl_fisik, ':perihal'=>$perihal, ':karakteristik'=>$karakteristik, ':derajat'=>$derajat, ':layout_konten'=>$konten_surat, ':created'=>$created);
    $insert = $this->model->insertprepare("surat_keluar", $field, $params);
    if($insert->rowCount() >= 1){
        echo "<script type=\"text/javascript\">alert('Surat keluar Berhasil Tersimpan...!!');window.location.href=\"./index.php?op=surat_keluar\";</script>";
    }else{
        die("<script>alert('Data Gagal di simpan ke Database, Silahkan Coba Kembali..!!');window.history.go(-1);</script>");
    }
}else { ?>
    <?php 
        if(isset($_GET['id_surat']) && empty($_GET['act'])){
            $pembuat = $_SESSION['id_user'];
		    $jenis_surat = htmlspecialchars($purifier->purify(trim($_GET['id_surat'])), ENT_QUOTES);

            $params = array(':id' => 1);
            $CekSetting = $this->model->selectprepare("pengaturan", $field=null, $params, "id=:id");
            if($CekSetting->rowCount() >= 1){
                $dataCekSetting = $CekSetting->fetch(PDO::FETCH_OBJ);
                $no_surat_sk_start = $dataCekSetting->no_surat_sk_start;
                $no_surat_sk = $dataCekSetting->no_surat_sk;
            }

            $users = mysqli_query($conn, "SELECT * FROM user WHERE id_user='$pembuat'");
            while($rowUser = $users->fetch_assoc()) {
                $id_jabatan = $rowUser['jabatan'];
            }

            $jabatan = mysqli_query($conn, "SELECT * FROM user_jabatan WHERE id_jab='$id_jabatan'");
            while($rowJabatan = $jabatan->fetch_assoc()) {
                $kode_jabatan = $rowJabatan['kode_jabatan'];
            }

            $jenisS = mysqli_query($conn, "SELECT * FROM klasifikasi_sk WHERE id_klas='$jenis_surat'");
            while($rowSK = $jenisS->fetch_assoc()) {
                $kode = $rowSK['kode'];
            }

            $p = array(':jenis_surat' => $jenis_surat);
            $CekSurat = $this->model->selectprepare("surat_keluar", $field=null, $p, "jenis_surat=:jenis_surat");

            $max_kode = mysqli_query($conn, "SELECT max(urutan) as maxKode FROM surat_keluar WHERE jenis_surat='$jenis_surat' AND pembuat='$pembuat'");
            $data_max  = mysqli_fetch_array($max_kode);
            $max = $data_max['maxKode'];
            // $noUrut = (int) substr($max, 0, 4);
            if($max >= $no_surat_sk_start) {
                $max++;
            }else {
                $max = $no_surat_sk_start;
            }

            include_once('bulan-romawi.php');

            $bulan = date('n');
            $bulanRomawi = getRomawi($bulan);

            $noSurat = $max.'/'.$no_surat_sk;
            // $noSurat = sprintf("%04s", $noUrut).'/'.$no_surat_sk;

            $var = array('=KodeJab=', '=KodeSurat=', '=Bulan=', '=Tahun=');
            $rep = array($kode_jabatan, $kode, $bulanRomawi, date('Y'));
            $nomor_surat = str_replace($var, $rep, $noSurat);

        } else {
            $nomor_surat = '';
        }
    ?>
    <div class="card-title">Entri Surat Keluar</div>
    <div class="card-description">Lengkapi data-data surat keluar berikut.</div>
    <hr>
    <form action="<?php echo $_SESSION['url'];?>" method="post" id="form-surat" class="mt-4" enctype="multipart/form-data">
        <div class="form-group row">
            <div class="col-lg-2">
                <label class="col-form-label">Nomor Surat</label>
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" name="noSurat" value="<?php echo $nomor_surat ?>" disabled>
            </div>
            <input type="hidden" class="form-control" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
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
                <select class="js-example-basic-single w-100" placeholder="Forward" name="jenis_surat" id="jenis_surat" onchange="nomor_surat(this.value)" required>
                    <option value="" selected disabled>None</option>
                    <?php while($data = $jenis->fetch()) { ?>
                        <option value=<?php echo $data['id_klas']; ?> <?php if($data['id_klas'] == $jenis_surat){ echo 'selected'; } ?>><?php echo $data['nama']; ?></option>
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
                    <div class="form-check form-check-flat form-check-primary mt-3">    
                        <label class="form-check-label mt-4">
                            <input type="checkbox" class="form-check-input" id="centang" onclick="cek()">
                            Data yang saya inputkan diatas sudah benar
                        </label>
                    </div>
                    <button class="btn btn-primary btn-icon-text mt-3" type="button" onclick="windowSubmit()" name="sumbit_sk_non" id="btn-submit" disabled>
                        <i class="btn-icon-prepend" data-feather="save"></i> Submit
                    </button>
                    <button class="btn btn-warning btn-icon-text mt-3" type="button" onclick="windowPreview()">
                        Preview
                    </button>
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
                        <p class="card-description">Klik tombol dibawah untuk memilih Tanda Tangan.</p>
                        <select class="js-example-basic-multiple w-100"  name="ttd_user" id="ttd_user" data-placeholder="Pilih TTD" onchange="addTtd(this.value)">
                            <option selected disabled>Pilih TTD</option>
							<?php
                                $GetUser = $this->model->selectprepare("user a join user_jabatan b on a.jabatan=b.id_jab", $field=null, $params=null, $where=null, "ORDER BY a.nama ASC");
                                if($GetUser->rowCount() >= 1){
                                    while($dataUser = $GetUser->fetch(PDO::FETCH_OBJ)){
                                        $NamaUser = $dataUser->nama ." (".$dataUser->nama_jabatan .")";
                                        if(false !== array_search($dataUser->id_user, $cekDisposisi)){?>
                                            <option value="<?php echo $dataUser->id_user;?>"><?php echo $NamaUser;?></option><?php
                                        }else{?>
                                            <option value="<?php echo $dataUser->id_user;?>"><?php echo $NamaUser;?></option><?php
                                        }
                                    }								
                                }else{?>
                                    <option value="">Not Found</option><?php
                                }?>
                        </select>
                        <div id="hiden"></div>
                        <div id="tanda"></div>
                    </li>
                    <li class="list-group-item">
                        <p class="card-description ">Untuk settingan surat default.</p>
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
            function variabel(a, b){
                var input = document.createElement('input');
                input.type = 'hidden';
                input.value = b;
                input.name = 'id_ttd[]';
                
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
                    case 'ttd': 
                        tinymce.get("kontenTemplate").execCommand('mceInsertContent', false, '=TTD:'+b+'=');
                        document.getElementById('hiden').appendChild(input);
                        break;
                    default:
                        break;
                }
            }

            function addTtd(x) {
                document.getElementById("tanda").innerHTML = `
                <div class="btn btn-light m-2" id="ttd" onclick="variabel('ttd',`+x+`)">TTD</div>
                `;
                // console.log(x);
            }
        </script>

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
            });

            function nomor_surat(id) {
                window.location.href="./index.php?op=entri_surat&surat-non-template&id_surat="+id;
            }

            function windowSubmit() {
                form_surat.action = "<?php echo $_SESSION['url'];?>";
                form_surat.target = "";
                form_surat.submit();
            }

            function windowPreview() {
                form_surat.action = "view/preview.php?act=pdf";
                form_surat.target = "_blank";
                form_surat.submit();
            }

        </script>

    </form>

<?php
}
?>