<?php 
if(isset($_GET['surat-non-template'])) {
    require_once 'add_surat_nontemplate.php';
}elseif(isset($_GET['surat-template'])) {
    require_once 'add_surat_template.php';
}else { ?>

<div class="row ">
    <div class="col-lg-6">
        <a type="button" href="./index.php?op=entri_surat&surat-non-template" class="mt-3 mb-3 btn btn-primary btn-icon-text mx-auto d-flex justify-content-center align-items-center" style="height: 400px; width:430px;">
            <div class="w-100">
                <span data-feather="mail"></span>
                <h4 class="text mt-3">Surat Non Template</h4>
            </div>
        </a>
    </div>
    <div class="col-lg-6">
        <a type="button" href="./index.php?op=entri_surat&surat-template" class="mt-3 mb-3 btn btn-primary btn-icon-text mx-auto d-flex justify-content-center align-items-center" style="height: 400px; width:430px;">
            <div class="w-100">
                <span data-feather="file-text"></span>
                <h4 class="text mt-3">Surat Template</h4>
            </div>
        </a>
    </div>
</div>

<?php
}
?>