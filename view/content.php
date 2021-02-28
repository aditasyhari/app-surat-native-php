<!-- <nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Jenis Surat</li>
  </ol>
</nav> -->

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            
                <!-- PAGE CONTENT BEGINS --><?php
                if(isset($_GET['op']) AND $_GET['op'] == "add_sm"){
                    if($HakAkses->sm == "W"){
                        require_once "entry_sm.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "sm"){
                    if($HakAkses->sm == "W" OR $HakAkses->sm == "R"){
                        require_once "view_sm.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "add_sk"){
                    if($HakAkses->sk == "W"){
                        require_once "entry_sk.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "sk"){
                    if($HakAkses->sk == "W" OR $HakAkses->sk == "R"){
                        require_once "view_sk.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "klasifikasi"){
                    if($HakAkses->atur_klasifikasi_sm == "Y"){
                        require_once "klasifikasi.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "klasifikasi_sk"){
                    if($HakAkses->atur_klasifikasi_sk == "Y"){
                        require_once "klasifikasi_sk.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "arsip_sm"){
                    if($HakAkses->sm == "W" OR $HakAkses->sm == "R"){
                        require_once "view_arsip_sm.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "arsip_sk"){
                    if($HakAkses->sk == "W" OR $HakAkses->sk == "R"){
                        require_once "view_arsip_sk.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "user"){
                    if($HakAkses->atur_user == "Y"){
                        require_once "user.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "report_sm"){
                    if($HakAkses->report_sm == "Y"){
                        require_once "sm_report.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "report_sk"){
                    if($HakAkses->report_sk == "Y"){
                        require_once "sk_report.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "setting"){
                    if($HakAkses->atur_layout == "Y"){
                        require_once "setting.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "karakteristik"){
                    if($HakAkses->atur_layout == "Y"){
                        require_once "karakteristik.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "derajat"){
                    if($HakAkses->atur_layout == "Y"){
                        require_once "derajat.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "memo"){
                    require_once "view_memo.php";
                }elseif(isset($_GET['op']) AND $_GET['op'] == "surat_keluar"){
                    require_once "view_surat_keluar.php";
                }elseif(isset($_GET['op']) AND $_GET['op'] == "entri_surat"){
                    require_once "view_entri_surat.php";
                }elseif(isset($_GET['op']) AND $_GET['op'] == "disposisi"){
                    require_once "view_disposisi.php";
                }elseif(isset($_GET['op']) AND $_GET['op'] == "tembusan"){
                    require_once "view_tembusan.php";
                }elseif(isset($_GET['op']) AND $_GET['op'] == "profil"){
                    require_once "profile.php";
                }elseif(isset($_GET['op']) AND $_GET['op'] == "cari_sm"){
                    if($HakAkses->cari_surat_masuk == "Y"){
                        require_once "cari_surat.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                // ===============================
                }elseif(isset($_GET['op']) AND $_GET['op'] == "view_event"){
                            require_once "view_agenda.php";

                }elseif(isset($_GET['op']) AND $_GET['op'] == "add_event"){
                            require_once "add_agenda.php";
                }elseif(isset($_GET['op']) AND $_GET['op'] == "tracking_"){
                            require_once "tracking_.php";
                }elseif(isset($_GET['op']) AND $_GET['op'] == "statistik"){
                            require_once "statistik_surat.php";
                 }elseif(isset($_GET['op']) AND $_GET['op'] == "statistik_unit"){
                            require_once "statistik_unit.php";
                }elseif(isset($_GET['op']) AND $_GET['op'] == "pekanan"){
                            require_once "libur_pekanan.php";
                }elseif(isset($_GET['op']) AND $_GET['op'] == "add_pekanan"){
                            require_once "entry_pekanan.php";

                // ===============================
                }elseif(isset($_GET['op']) AND $_GET['op'] == "cari_sk"){
                    if($HakAkses->cari_surat_keluar == "Y"){
                        require_once "cari_surat.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "cari_arsip" OR $_GET['op'] == "report_arsip"){
                    if($HakAkses->report_arsip == "Y" OR $HakAkses->arsip == "W"){
                        require_once "cari_arsip.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "view_surat"){
                    require_once "cari_surat_view.php";
                }elseif(isset($_GET['op']) AND $_GET['op'] == "arsip_file"){
                    if($HakAkses->arsip == "W" OR $HakAkses->arsip == "R"){
                        require_once "view_arsip_file.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "add_arsip"){
                    if($HakAkses->arsip == "W"){
                        require_once "entry_filearsip.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "klasifikasi_file"){
                    if($HakAkses->atur_klasifikasi_arsip == "Y"){
                        require_once "klasifikasi_arsip_file.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "report_disposisi"){
                    if($HakAkses->report_dispo == "Y"){
                        require_once "disposisi_report.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "report_progress"){
                    if($HakAkses->report_dispo == "Y"){
                        require_once "progress_report.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "info"){
                    require_once "view_info.php";
                }elseif(isset($_GET['op']) AND $_GET['op'] == "add_memo" OR $_GET['op'] == "data_memo"){
                    if($HakAkses->info == "Y" AND $_GET['op'] == "add_memo"){
                        require_once "entry_info.php";
                    }elseif($HakAkses->info == "Y" AND $_GET['op'] == "data_memo"){
                        require_once "view_data_memo.php";
                    }else{
                        require_once "invalid_akses.php";
                    }
                }elseif(isset($_GET['op']) AND $_GET['op'] == "template"){
                    require_once "view_template.php";
                }elseif(isset($_GET['op']) AND $_GET['op'] == "add_template"){
                    require_once "view_add_template.php";
                }elseif(isset($_GET['op']) AND $_GET['op'] == "approval_template"){
                    require_once "view_approval_template.php";
                }else{
                    require_once "dashboard.php";
                } ?>
                <!-- PAGE CONTENT ENDS -->

            </div>
        </div>
    </div>
</div>