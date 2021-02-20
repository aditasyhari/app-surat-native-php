<?php 
    require_once 'db/db2.php';
    $id_template = $_GET['tpid'];
    // echo $id_template;

    $sql = mysqli_query($conn, "SELECT * FROM template WHERE id_template='$id_template'");
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
            <p for="" class="font-weight-bold text-uppercase">Margin</p>
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

    </li>
    <?php
} ?>
</ul>