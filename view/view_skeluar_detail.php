<?php 
require_once 'db/db2.php';
$idsk = $_GET['idsk']; 
$queryDetail = mysqli_query($conn, "SELECT * FROM surat_keluar WHERE id_skeluar='$idsk'");
while($data = $queryDetail->fetch_assoc()) { ?>

    <div class="card-title">Detail Surat Keluar</div>
    <hr>
    <?php 
    if($data['id_template'] == '') { ?>
        <span class="badge badge-secondary text-white">Non Template</span>
    <?php
    }else { ?>
        <span class="badge badge-primary text-white">Template</span>
    <?php
    }
    ?>
        <div class="form-group row">
            <div class="col-lg-2">
                <label class="col-form-label ">Nomor Surat</label>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label ">: <span class="text-success font-weight-bold"><?php echo $data['nomor_surat'] ?></span></label>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-2">
                <label class="col-form-label">Jenis Surat</label>
            </div>
            <div class="col-lg-6">
                <?php 
                    $jenis = $dbpdo->prepare("select * from klasifikasi_sk where id_klas='$data[jenis_surat]'"); 
                    $jenis->execute();
                ?>
                <?php while($jeniss = $jenis->fetch()) { ?>
                    <label class="col-form-label">: <?php echo $jeniss['nama']; ?></label>
                <?php } ?>
            </div>
        </div>

        <div class="form-group mb-0 row">
            <div class="col-lg-2">
                <label class="col-form-label">Tanggal Surat Fisik</label>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">: <?php echo tgl_indo($data['tgl_surat_fisik']); ?></label>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-2">
                <label class="col-form-label">Tujuan Surat</label>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">: <?php echo $data['tujuan'] ?></label>
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
                    $kar = $dbpdo->prepare("select * from karakteristik where id_karakteristik='$data[karakteristik]'"); 
                    $kar->execute();
                    
                    while($data_kar = $kar->fetch()) { ?>
                        <input type="text" class="form-control" value="<?php echo $data_kar['nama']; ?>" disabled>
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
                    $derajat = $dbpdo->prepare("select * from derajat where id_derajat='$data[derajat]'"); 
                    $derajat->execute();

                    $noD = 1;
                    while($data_derajat = $derajat->fetch()) { ?>
                        <input type="text" class="form-control" value="<?php echo $data_derajat['nama']; ?>" disabled>
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
                <label class="col-form-label"><?php echo $data['perihal'] ?></label>
            </div>
        </div>

        <a href="./view/surat_keluar_print.php?idsk=<?php echo $idsk;?>&act=pdf" target="_blank" class="btn btn-success btn-icon-text mt-3" type="submit" name="sumbit_sk_non" id="btn-submit">
            Lihat / Cetak Surat <i class="btn-icon-prepend" data-feather="file"></i>
        </a>

<?php
}
?>