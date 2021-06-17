
<?php 
require_once "db/db2.php"; 
?>
    <h4 class="card-title">Buat Template Surat Baru</h4>
    <p class="card-description ">Lengkapi data yang dibutuhkan</p>

    <form action="view/proses_template.php" method="POST" enctype="multipart/form-data">
        <br>
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
                        <option value="" selected disabled>None</option>
                        <?php while($data = $jenis->fetch()) { ?>
                            <option value=<?php echo $data['id_klas']; ?>><?php echo $data['nama']; ?></option>
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
                        <?php while($data = $validator->fetch()) { ?>
                            <option value=<?php echo $data['id_jab']; ?>><?php echo $data['nama_jabatan']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Nama Template</label>
                    <input type="text" class="form-control" name="nama_template" required>
                </div>
                <div class="form-group">
                    <div class="card-description text-primary">*Pastikan total size image yang digunakan pada kop surat kurang dari 1 mb.</div>
                </div>
            </div>

            <div class="col-8">
                <div class="form-check form-check-flat form-check-primary">
                    <label class="form-check-label">
                        Kop Surat
                        <input type="checkbox" class="form-check-input" name="kop_surat" id="kop_surat" onclick="check(this.checked); return true;" checked>
                    </label>
                </div>

                <textarea class="form-control" name="layout_kop" id="tinymceExample" rows="15"></textarea>
            </div>
        </div>

        <br>
        <div class="col-4">
            <div class="form-group">
                <label>Ukuran Halaman</label>
                <select class="form-control" name="ukuran_hal" id="">
                    <option value="A4" selected>A4</option>
                    <option value="Letter">Letter</option>
                </select>
            </div>

            <br>
            <label class="mr-3">Orientasi Halaman</label>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="orientasi_hal" value="P" checked>
                        Potrait
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="orientasi_hal" value="L">
                        Landscape
                    </label>
                </div>
            </div>

        </div>

        <div class="col-12">
            <div class="form-group text-sm">
                <label for="">Margin (satuan mm)</label>
                <div class="row text-uppercase">
                    <div class="col-2">
                        <div class="input-group">
                            <label for="" class="btn btn-secondary btn-xs">Atas</label>
                            <input type="number" class="form-control" min="2" value=10 name="m_atas">
                            
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="input-group">
                            <label for="" class="btn btn-secondary btn-xs">Bawah</label>
                            <input type="number" class="form-control" min="2" value=10 name="m_bawah">
                            
                        </div>
                    </div>
                <!-- </div> -->
                <!-- <div class="row"> -->
                    <div class="col-2">
                        <div class="input-group">
                            <label for="" class="btn btn-secondary btn-xs">Kiri</label>
                            <input type="number" class="form-control" min="2" value=10 name="m_kiri">
                            <!-- <span class="input-group-append">
                                <button class="btn btn-secondary" type="button">Kiri</button>
                            </span> -->
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="input-group">
                            <label for="" class="btn btn-secondary btn-xs">Kanan</label>
                            <input type="number" class="form-control" min="2" value=10 name="m_kanan">
                            <!-- <span class="input-group-append">
                                <button class="btn btn-secondary" type="button">Kanan</button>
                            </span> -->
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
                    <textarea class="form-control" name="layout_konten" id="kontenTemplate" rows="15"></textarea>
                </div>
                <div class="col-4">
                    <li class="list-group-item">
                        <p class="card-description">Klik tombol dibawah ini untuk menyisipkan variabel kedalam template.</p>
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

        <center>
            <button type="submit" value="submit_template" name="submit_template" class="btn btn-primary mt-5">Submit</button>
        </center>
    </form>
