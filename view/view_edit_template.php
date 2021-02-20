
<?php 
require_once "db/db2.php"; 
$id_template = $_GET['editid'];

$sql = mysqli_query($conn, "SELECT * FROM template WHERE id_template='$id_template'");

while($row = $sql->fetch_assoc()) {
    $nama_template = $row['nama_template'];
    $id_klasifikasi = $row['id_klasifikasi'];
    $id_validator = $row['id_validator'];
    $layout_kop = $row['layout_kop'];
    $logo_kop = $row['logo_kop'];
    $ukuran_hal = $row['ukuran_hal'];
    $orientasi_hal = $row['orientasi_hal'];
    $m_atas = $row['m_atas'];
    $m_bawah = $row['m_bawah'];
    $m_kiri = $row['m_kiri'];
    $m_kanan = $row['m_kanan'];
    $layout_konten = $row['layout_konten'];
}
?>
    <h4 class="card-title">Edit Template Surat</h4>
    <p class="card-description ">Edit data template</p>

    <form action="view/proses_template.php" method="POST" enctype="multipart/form-data">
        <br>
        <input type="hidden" value=<?php echo $id_template; ?> name="id_template">
        <input type="hidden" value=<?php echo $_SESSION['id_user']; ?> name="id_pembuat">
        <div class="row">
            <div class="col-4">
                <div class="form-check">
                    <label>Jenis Surat</label>

                    <?php 
                        $jenis = $dbpdo->prepare("select * from klasifikasi_sk"); 
                        $jenis->execute();
                    ?>

                    <select class="js-example-basic-single w-100" name="id_klasifikasi" required>
                        <option value="" disabled>None</option>
                        <?php 
                        while($data = $jenis->fetch()) { 
                            if($id_klasifikasi == $data['id_klas']) { ?>
                                <option value=<?php echo $data['id_klas']; ?> selected><?php echo $data['nama']; ?></option>
                        <?php
                            }else { ?>
                                <option value=<?php echo $data['id_klas']; ?>><?php echo $data['nama']; ?></option>
                        <?php
                            }
                        ?>
                        <?php } ?>
                    </select>
                </div>

                <?php 
                    $validator = $dbpdo->prepare(
                        "select * from user_jabatan INNER JOIN user ON user_jabatan.id_jab = user.jabatan"
                    ); 
                    $validator->execute();
                ?>

                <div class="form-group">
                    <label>Validator</label>
                    <select class="js-example-basic-single w-100" name="id_validator" required>
                        <option value="" selected disabled>None</option>
                        <?php 
                        while($data = $validator->fetch()) { 
                            if($id_validator == $data['id_jab']) { ?>
                                <option value=<?php echo $data['id_jab']; ?> selected><?php echo $data['nama_jabatan']; ?></option>
                        <?php
                            }else { ?>
                                <option value=<?php echo $data['id_jab']; ?>><?php echo $data['nama_jabatan']; ?></option>
                        <?php
                            }
                        ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Nama Template</label>
                    <input type="text" class="form-control" value="<?php echo $nama_template; ?>" name="nama_template" required>
                </div>
                <div class="form-group">
                    <label>Logo Kop Surat</label>
                    <p class="card-description ">*Abaikan form ini jika tidak mengganti logo kop.</p>
                    <input type="file" name="logo_kop" class="" accept=".jpg,.jpeg,.png">
                </div>
            </div>

            <div class="col-8">
                <div class="form-check form-check-flat form-check-primary">
                    <label class="form-check-label">
                        Kop Surat
                        <input type="checkbox" class="form-check-input" name="kop_surat" id="kop_surat" onclick="check(this.checked); return true;" checked>
                    </label>
                </div>

                <textarea class="form-control" name="layout_kop" id="tinymceExample" rows="15"><?php echo $layout_kop; ?></textarea>
            </div>
        </div>

        <br>
        <div class="col-4">
            <div class="form-group">
                <label>Ukuran Halaman</label>
                <select class="form-control" name="ukuran_hal" id="">
                <?php 
                    if($ukuran_hal == 'A4') { ?>
                        <option value="A4" selected>A4</option>
                        <option value="Letter">Letter</option>
                <?php
                    }else { ?>
                        <option value="A4">A4</option>
                        <option value="Letter" selected>Letter</option>
                <?php
                    }
                ?>
                </select>
            </div>

            <br>
            <label class="mr-3">Orientasi Halaman</label>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                    <?php 
                        if($orientasi_hal == 'P') { ?>
                            <input type="radio" class="form-check-input" name="orientasi_hal" value="P" checked>
                            Potrait
                    <?php
                        }else { ?>
                            <input type="radio" class="form-check-input" name="orientasi_hal" value="P">
                            Potrait
                    <?php
                        }
                    ?>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                    <?php 
                        if($orientasi_hal == 'L') { ?>
                            <input type="radio" class="form-check-input" name="orientasi_hal" value="L" checked>
                            Landscape
                    <?php
                        }else { ?>
                            <input type="radio" class="form-check-input" name="orientasi_hal" value="L">
                            Landscape
                    <?php
                        }
                    ?>
                    </label>
                </div>
            </div>

        </div>

        <div class="col-12">
            <div class="form-group text-sm">
                <label for="">Margin (satuan mm)</label>
                <div class="row">
                    <div class="col-2">
                        <div class="input-group">
                            <input type="number" class="form-control" min="2" value=<? echo $m_atas; ?> name="m_atas">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="button">Atas</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="input-group">
                            <input type="number" class="form-control" min="2" value=<? echo $m_bawah; ?> name="m_bawah">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="button">Bawah</button>
                            </span>
                        </div>
                    </div>
                <!-- </div> -->
                <!-- <div class="row"> -->
                    <div class="col-2">
                        <div class="input-group">
                            <input type="number" class="form-control" min="2" value=<? echo $m_kiri; ?> name="m_kiri">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="button">Kiri</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="input-group">
                            <input type="number" class="form-control" min="2" value=<? echo $m_kanan; ?> name="m_kanan">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="button">Kanan</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="col-12">
            <label for="">Konten Surat</label>
            <div class="row">
                <div class="col-8">
                    <textarea class="form-control" name="layout_konten" id="kontenTemplate" rows="15"><? echo $layout_konten; ?></textarea>
                </div>
                <div class="col-4">
                    <li class="list-group-item">
                        <p class="card-description">Klik tombol dibawah ini untuk menyisipkan variabel kedalam template.</p>
                        <div class="row mt-4">
                            <div class="btn btn-light m-2" id="nama" onclick="variabel('nama')">Nama</div>
                            <div class="btn btn-light m-2" id="email" onclick="variabel('email')">Email</div>
                            <div class="btn btn-light m-2" id="perihal" onclick="variabel('perihal')">Perihal</div>
                        </div>
                        <div class="row">
                            <div class="btn btn-light m-2" id="nosurat" onclick="variabel('nosurat')">No Surat</div>
                            <div class="btn btn-light m-2" id="tglsurat" onclick="variabel('tglsurat')">Tgl Surat</div>
                        </div>
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
                    default:
                        break;
                }
            }
        </script>

        <center>
            <button type="submit" value="submit_edit_template" name="submit_edit_template" class="btn btn-primary mt-5">Submit</button>
        </center>
    </form>
