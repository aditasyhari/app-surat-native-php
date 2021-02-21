<?php 
    require_once 'db/db2.php';
    $id_template = $_GET['tpid'];
    $read_validator = 1;

    mysqli_query($conn, "UPDATE template SET read_validator='$read_validator' WHERE id_template='$id_template'");

    $sql = mysqli_query($conn, "SELECT * FROM template WHERE id_template='$id_template'");
    $sql2 = mysqli_query($conn, "SELECT * FROM template WHERE id_template='$id_template'");
    while($temp = $sql2->fetch_assoc()){
        $id_validator = $temp['id_validator'];
    }

    $user_jabatan = mysqli_query($conn, "SELECT * FROM user_jabatan WHERE id_jab='$id_validator'");
    while($val = $user_jabatan->fetch_assoc()) {
        $validator_jabatan = $val['nama_jabatan'];
    }

    $user = mysqli_query($conn, "SELECT * FROM user WHERE id_user='$_SESSION[id_user]'");
    while($userjab = $user->fetch_assoc()) {
        $user_idjab = $userjab['jabatan'];
    }
?>

<h6 class="card-title">Detail Template </h6>
<ul class="list-group">
<?php while($data = $sql->fetch_assoc()) {?>
    <li class="list-group-item">
        <h6><?php echo $data['nama_template']; ?></h6>
        <?php 
            $user = mysqli_query($conn, "SELECT * FROM user WHERE id_user='$data[id_pembuat]'");
            while($pembuat = $user->fetch_assoc()) { ?>
                Oleh : <span class="text-warning"><?php echo $pembuat['nama'] ?></span>
            <?php
            } 
        ?>
        |
        <span class="text-primary"><?php echo $data['tgl_dibuat']; ?></span>
        <hr>

        <?php 
            $jenis = mysqli_query($conn, "SELECT * FROM klasifikasi_sk WHERE id_klas='$data[id_klasifikasi]'");
            while($klasifikasi = $jenis->fetch_assoc()) { ?>
                <div class="text-uppercase">
                    <p class="font-weight-bold">Jenis Surat :</p>
                    <span><?php echo $klasifikasi['nama'] ?></span>
                </div>
            <?php
            } 
        ?>

        <br>
        <div class="text-uppercase">
            <p class="font-weight-bold">Validator :</p>
            <span><?php echo $validator_jabatan; ?></span>
        </div>

        <br>
        <div class="text-uppercase">
            <p class="font-weight-bold">Ukuran :</p>
            <span><?php echo $data['ukuran_hal']; ?></span>
        </div>

        <br>
        <div class="text-uppercase">
            <p class="font-weight-bold">Orientasi :</p>
            <?php if($data['orientasi_hal'] == 'P') { ?>
                <span>Portrait</span>
            <?php
            }else { ?>
                <span>Landscape</span>
            <?php
            } ?>
        </div>

        <br>
        <div class="form-group">
            <p for="" class="font-weight-bold text-uppercase">Margin (mm)</p>
            <div class="row">
                <div class="col-2">
                    <div class="input-group">
                        <input type="number" class="form-control" min="2" value=<?php echo $data['m_atas']; ?> name="m_atas" disabled>
                        <span class="input-group-append">
                            <button class="btn btn-secondary" type="button">Atas</button>
                        </span>
                    </div>
                </div>
                <div class="col-2">
                    <div class="input-group">
                        <input type="number" class="form-control" min="2" value=<?php echo $data['m_bawah']; ?> name="m_bawah" disabled>
                        <span class="input-group-append">
                            <button class="btn btn-secondary" type="button">Bawah</button>
                        </span>
                    </div>
                </div>
                <div class="col-2">
                    <div class="input-group">
                        <input type="number" class="form-control" min="2" value=<?php echo $data['m_kiri']; ?> name="m_kiri" disabled>
                        <span class="input-group-append">
                            <button class="btn btn-secondary" type="button">Kiri</button>
                        </span>
                    </div>
                </div>
                <div class="col-2">
                    <div class="input-group">
                        <input type="number" class="form-control" min="2" value=<?php echo $data['m_kanan']; ?> name="m_kanan" disabled>
                        <span class="input-group-append">
                            <button class="btn btn-secondary" type="button">Kanan</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="text-uppercase">
            <p class="font-weight-bold">Status Template :</p>
            <span><?php echo $data['status_temp']; ?></span>
        </div>

        <br>
        <?php 
        if($data['status_temp'] == 'revisi') { ?>
            <div class="text-uppercase">
                <p class="font-weight-bold">Revisi :</p>
                <textarea name="" id="" cols="50" rows="7"><?php echo $data['revisi']; ?></textarea>
            </div>
        <?php
        } ?>

        <hr>
        <a href="./view/view_template_print.php?tpid=<?php echo $data['id_template'];?>&act=pdf" target="_blank">
            <button class="btn btn-success btn-minier ">
                Lihat Template
                <i class="ml-1 fa fa-book"></i>
            </button>
        </a>

        <?php 
            if($data['id_validator'] == $user_idjab) { ?>
                <hr>
                <form action="view/proses_template.php" method="POST">
                    <input type="hidden" value=<?php echo $id_template ?> name="id_template">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="" class="text-uppercase font-weight-bold">Persetujuan</label>
                            <select name="persetujuan" id="persetujuan" onchange="val()">
                                <option value="">Pilih</option>
                                <option value="revisi">Revisi</option>
                                <option value="disetujui">Disetujui & Publish</option>
                                <option value="tolak">Ditolak</option>
                            </select>
                            <div class="mt-2" id="formtext">
                                
                            </div>
                        </div>
                        
                        <button type="submit" name="submit_status" value="submit_status" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

                <script>
                    function val() {
                        var formtext = document.getElementById('formtext');
                        var p = document.getElementById('persetujuan');
                        
                        if(p.value == 'revisi') {
                            formtext.innerHTML = `
                                <textarea class="form-control" name="revisi" id="" cols="43" rows="5" placeholder="catatan revisi.."></textarea>
                            `;
                        }else {
                            formtext.innerHTML = ``;
                        }
                    }
                </script>
        <?php     
            }
        ?>
    </li>
    <?php
} ?>
</ul>