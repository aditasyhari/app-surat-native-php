<?php
  // if(isset($_GET['op']) AND ($_GET['op'] == )) {

  // } else {

  // }
  if(isset($_GET['op']) AND ($_GET['op'] == "sm" OR $_GET['op'] == "add_sm")){
    $StatSM = 'active open';
    if($_GET['op'] == "sm"){ $StatDataSM = 'active'; }else{ $StatDataSM = ''; }
    if($_GET['op'] == "add_sm"){ $StatEntriSM = 'active'; }else{ $StatEntriSM = ''; }
  }else{
    $StatSM = '';
  }
  if(isset($_GET['op']) AND ($_GET['op'] == "sk" OR $_GET['op'] == "add_sk")){
    $StatSK = 'active open';
    if($_GET['op'] == "sk"){ $StatDataSK = 'active'; }else{ $StatDataSK = ''; }
    if($_GET['op'] == "add_sk"){ $StatEntriSK = 'active'; }else{ $StatEntriSK = ''; }
  }else{
    $StatSK = '';
  }
  if(isset($_GET['op']) AND ($_GET['op'] == "data_memo" OR $_GET['op'] == "add_memo")){
    $StatArsipMemo = 'active open';
    if($_GET['op'] == "data_memo"){ $StatDataMemo = 'active'; }else{ $StatDataMemo = ''; }
    if($_GET['op'] == "add_memo"){ $StatEntriMemo = 'active'; }else{ $StatEntriMemo = ''; }
  }else{
    $StatArsipMemo = '';
  }
  if(isset($_GET['op']) AND ($_GET['op'] == "report_sm" OR $_GET['op'] == "report_sk" OR $_GET['op'] == "report_disposisi" OR $_GET['op'] == "report_arsip" OR $_GET['op'] == "report_progress")){
    $StatReport = 'active open';
    if($_GET['op'] == "report_sm"){ $StatRSM = 'active'; }else{ $StatRSM = ''; }
    if($_GET['op'] == "report_sk"){ $StatRSK = 'active'; }else{ $StatRSK = ''; }
    if($_GET['op'] == "report_disposisi"){ $StatDIS = 'active'; }else{ $StatDIS = ''; }
    if($_GET['op'] == "cari_arsip"){ $StatCariArsip = 'active'; }else{ $StatCariArsip = ''; }
    if($_GET['op'] == "report_arsip"){ $StatReportArsip = 'active'; }else{ $StatReportArsip = ''; }
    if($_GET['op'] == "report_progress"){ $StatReportProgress = 'active'; }else{ $StatReportProgress = ''; }
  }else{
    $StatReport = $StatCariArsip = '';
  }
  if(isset($_GET['op']) AND ($_GET['op'] == "arsip_file")){
    $StatArsipLeader = 'active open';
    if($_GET['op'] == "arsip_file"){ $StatArsipFileView = 'active'; }else{ $StatArsipFileView = ''; }
  }else{
    $StatArsipLeader = '';
  }
  
  if(isset($_GET['op']) AND ($_GET['op'] == "arsip_file" OR $_GET['op'] == "add_arsip" OR $_GET['op'] == "cari_arsip")){
    $StatArsipFile = 'active open';
    
    if($_GET['op'] == "add_arsip"){ $StatArsipFileEntri = 'active'; }else{ $StatArsipFileEntri = ''; }
    if($_GET['op'] == "arsip_file"){ $StatArsipFileView = 'active'; }else{ $StatArsipFileView = ''; }
    
    if($_GET['op'] == "cari_arsip"){ $StatCariFile = 'active'; }else{ $StatCariFile = ''; }
  }else{
    $StatArsipFile = $StatArsipFileEntri = $StatArsipFileView = $StatCariFile = '';
  }
  
  if(isset($_GET['op']) AND ($_GET['op'] == "klasifikasi" OR $_GET['op'] == "klasifikasi_sk" OR $_GET['op'] == "user" OR $_GET['op'] == "setting" OR $_GET['op'] == "klasifikasi_file")){
    $StatAtur = 'active open';
  }else{
    $StatAtur = '';
  }
  
  if(isset($_GET['op']) AND $_GET['op'] == "arsip_sk"){ $StatArsipSK = 'active open'; }else{ $StatArsipSK = ''; }
  if(isset($_GET['op']) AND $_GET['op'] == "arsip_sm"){ $StatArsipSM = 'active open'; }else{ $StatArsipSM = ''; }
  if(isset($_GET['op']) AND $_GET['op'] == "user"){ $StatUser = 'active open'; }else{ $StatUser = ''; }
  if(isset($_GET['op']) AND $_GET['op'] == "setting"){ $StatSetting = 'active open'; }else{ $StatSetting = ''; }
  if(isset($_GET['op']) AND $_GET['op'] == "klasifikasi_file"){ $StatKlasFile = 'active open'; }else{ $StatKlasFile = ''; }
  if(isset($_GET['op']) AND $_GET['op'] == "klasifikasi"){ $StatKlasSM = 'active open'; }else{ $StatKlasSM = ''; }
  if(isset($_GET['op']) AND $_GET['op'] == "klasifikasi_sk"){ $StatKlasSK = 'active open'; }else{ $StatKlasSK = ''; }
  if(isset($_GET['op']) AND $_GET['op'] == "memo"){ $StatMemo = 'active open'; }else{ $StatMemo = ''; }
  if(isset($_GET['op']) AND $_GET['op'] == "disposisi"){ $StatDisposisi = 'active open'; }else{ $StatDisposisi = ''; }
  if(isset($_GET['op']) AND $_GET['op'] == "tembusan"){ $StatTembusan = 'active open'; }else{ $StatTembusan = ''; }
  if(isset($_GET['op']) AND $_GET['op'] == "info"){ $StatInfo = 'active open'; }else{ $StatInfo = ''; }
  if(isset($_GET['op']) AND $_GET['op'] == "info"){ $StatInfo = 'active open'; }else{ $StatInfo = ''; }
  if(!isset($_GET['op'])){
    $StatBeranda = 'active';
  }else{
    $StatBeranda = '';
  }
?>


<nav class="sidebar" id="sidebar">
  <script type="text/javascript">
    try{ace.settings.loadState('sidebar')}catch(e){}
  </script>
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
     <span>E - </span>OFFICE
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
    
      <li class="nav-item nav-category">Home</li>
      <li class="nav-item <?php echo $StatBeranda;?>">
        <a href="./" class="nav-link">
          <i class="link-icon" data-feather="home"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item nav-category">web apps</li>
      <li class="nav-item {{active class}}">
        <a class="nav-link" data-toggle="collapse" href="#surat" role="button" aria-controls="surat">
          <i class="link-icon" data-feather="mail"></i>
          <span class="link-title">Surat</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="surat">
          <ul class="nav sub-menu">
            <li class="nav-item">
             <a href="{{ url('/surat/surat-masuk') }}" class="nav-link ">Surat Baru</a>
            </li>
            <li class="nav-item">
             <a href="index.php?op=memo" class="nav-link <?php echo $StatMemo;?>">Surat Masuk</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/surat/surat-keluar') }}" class="nav-link {{ active_class(['surat/surat-keluar']) }}">Surat Keluar</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo $StatDisposisi;?>">
        <a href="index.php?op=disposisi" class="nav-link">
          <i class="link-icon" data-feather="message-square"></i>
          <span class="link-title">Disposisi Surat</span>
        </a>
      </li>
      <li class="nav-item <?php echo $StatTembusan;?>">
        <a href="index.php?op=tembusan" class="nav-link">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">Tembusan</span>
        </a>
      </li>
      <li class="nav-item <?php echo $StatInfo;?>">
        <a class="nav-link" href="index.php?op=info" role="button" aria-expanded="{{ is_active_route(['perihal-surat/*']) }}" aria-controls="perihal-surat">
          <i class="link-icon" data-feather="copy"></i>
          <span class="link-title">Pengingat Masuk</span>
        </a>
      </li>

      <?php 
      if($HakAkses->sm == "W") {?>
        <li class="nav-item <?php echo $StatSM;?>">
          <a class="nav-link" data-toggle="collapse" href="#arsip-sm" role="button" aria-expanded="{{ is_active_route(['arsip/*']) }}" aria-controls="arsip">
            <i class="link-icon" data-feather="folder"></i>
            <span class="link-title">Arsip Surat Masuk</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="arsip-sm">
            <ul class="nav sub-menu">
              <li class="nav-item">
              <a href="./index.php?op=add_sm" class="nav-link <?php echo $StatEntriSM;?>">Entri Baru</a>
              </li>
              <li class="nav-item">
                <a href="./index.php?op=sm" class="nav-link <?php echo $StatDataSM;?>">Data Surat Masuk</a>
              </li>
            </ul>
          </div>
        </li>
      <?php
      } 
      if($HakAkses->sm == "R") { ?>
        <li class="nav-item <?php echo $StatArsipSM;?>">
          <a class="nav-link" href="./index.php?op=arsip_sm" role="button" aria-expanded="{{ is_active_route(['perihal-surat/*']) }}" aria-controls="perihal-surat">
            <i class="link-icon" data-feather="inbox"></i>
            <span class="link-title">Arsip Surat Masuk</span>
          </a>
        </li>
      <?php
      } ?>

      <?php 
      if($HakAkses->sk == "W") {?>
        <li class="nav-item <?php echo $StatSK;?>">
          <a class="nav-link" data-toggle="collapse" href="#keluar" role="button" aria-expanded="{{ is_active_route(['arsip/*']) }}" aria-controls="arsip">
            <i class="link-icon" data-feather="folder"></i>
            <span class="link-title">Arsip Surat Keluar</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="keluar">
            <ul class="nav sub-menu">
              <li class="nav-item">
              <a href="./index.php?op=add_sk" class="nav-link <?php echo $StatEntriSK;?>">Entri Baru</a>
              </li>
              <li class="nav-item">
                <a href="./index.php?op=sk" class="nav-link <?php echo $StatDataSK;?>">Data Surat Keluar</a>
              </li>
            </ul>
          </div>
        </li>
      <?php
      }
      if($HakAkses->sk == "R") {?>
        <li class="nav-item <?php echo $StatArsipSK;?>">
          <a class="nav-link" href="./index.php?op=arsip_sk" role="button" aria-expanded="{{ is_active_route(['perihal-surat/*']) }}" aria-controls="perihal-surat">
            <i class="link-icon" data-feather="inbox"></i>
            <span class="link-title">Arsip Surat Keluar</span>
          </a>
        </li>
      <?php
      } ?>

      <?php
      if($HakAkses->arsip == "W") { ?>
        <li class="nav-item <?php echo $StatArsipFile;?>">
          <a class="nav-link" data-toggle="collapse" href="#digital" role="button" aria-expanded="{{ is_active_route(['arsip/*']) }}" aria-controls="arsip">
            <i class="link-icon" data-feather="archive"></i>
            <span class="link-title">Arsip Digital</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse {{ show_class(['arsip/*']) }}" id="digital">
            <ul class="nav sub-menu">
              <li class="nav-item">
              <a href="./index.php?op=add_arsip" class="nav-link <?php echo $StatArsipFileEntri;?>">Entri Baru</a>
              </li>
              <li class="nav-item">
                <a href="./index.php?op=arsip_file" class="nav-link <?php echo $StatArsipFileView;?>">Data File Arsip</a>
              </li>
              <li class="nav-item">
                <a href="./index.php?op=cari_arsip" class="nav-link <?php echo $StatCariFile;?>">Pencarian Arsip Surat</a>
              </li>
            </ul>
          </div>
        </li>
      <?php
      }
      if($HakAkses->arsip == "R") { ?>
        <li class="nav-item <?php echo $StatArsipFileView;?>">
          <a class="nav-link" href="./index.php?op=arsip_file" role="button" aria-expanded="{{ is_active_route(['perihal-surat/*']) }}" aria-controls="perihal-surat">
            <i class="link-icon" data-feather="archive"></i>
            <span class="link-title">Data Arsip Digital</span>
          </a>
        </li>
      <?php
      }
      ?>

      <?php
      if($HakAkses->info == "Y") { ?>
        <li class="nav-item <?php echo $StatArsipMemo;?>">
          <a class="nav-link" data-toggle="collapse" href="#memo" role="button" aria-expanded="{{ is_active_route(['organisasi/*']) }}" aria-controls="arsip">
            <i class="link-icon" data-feather="book"></i>
            <span class="link-title">Memo</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="memo">
            <ul class="nav sub-menu">
              <li class="nav-item">
              <a href="./index.php?op=add_memo" class="nav-link <?php echo $StatEntriMemo;?>">Entri Baru</a>
              </li>
              <li class="nav-item">
              <a href="./index.php?op=data_memo" class="nav-link <?php echo $StatDataMemo;?>">Data Correction</a>
              </li>
            </ul>
          </div>
        </li>
      <?php
      }
      ?>

      <li class="nav-item {{ active_class(['agenda/*']) }}">
        <a class="nav-link" data-toggle="collapse" href="#agenda" role="button" aria-expanded="{{ is_active_route(['agenda/*']) }}" aria-controls="agenda">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Agenda</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['agenda/*']) }}" id="agenda">
          <ul class="nav sub-menu">
            <li class="nav-item">
             <a href="{{ url('/agenda/buat-agenda') }}" class="nav-link {{ active_class(['agenda/buat-agenda']) }}">Buat Agenda</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/agenda/lihat-agenda') }}" class="nav-link {{ active_class(['agenda/lihat-agenda']) }}">Lihat Agenda</a>
             </li>
            <li class="nav-item">
              <a href="{{ url('/agenda/libur-pekanan') }}" class="nav-link {{ active_class(['agenda/libur-pekanan']) }}">Libur Pekanan</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item {{ active_class(['tracking/chat']) }}">
        <a href="{{ url('/tracking/chat') }}" class="nav-link">
          <i class="link-icon" data-feather="truck"></i>
          <span class="link-title">Tracking Surat</span>
        </a>
      </li>

      <li class="nav-item {{ active_class(['statistik/*']) }}">
        <a class="nav-link" data-toggle="collapse" href="#statistik" role="button" aria-expanded="{{ is_active_route(['statistik/*']) }}" aria-controls="statistik">
          <i class="link-icon" data-feather="trending-up"></i>
          <span class="link-title">Statistik</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['statistik/*']) }}" id="statistik">
          <ul class="nav sub-menu">
            <li class="nav-item">
             <a href="{{ url('/statistik/statistik-surat') }}" class="nav-link {{ active_class(['statistik/inbox']) }}">Statistik Peredaran Surat</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/statistik/read') }}" class="nav-link {{ active_class(['statistik/read']) }}">Daftar Nomer Pesanan</a>
            </li>
          </ul>
        </div>
      </li>

      <?php
      if($HakAkses->atur_layout == "Y" OR $HakAkses->atur_klasifikasi_sm == "Y" OR $HakAkses->atur_klasifikasi_sk == "Y" OR $HakAkses->atur_klasifikasi_arsip == "Y" OR $HakAkses->atur_user == "Y"){?>
        <li class="nav-item <?php echo $StatAtur;?>">
          <a class="nav-link" data-toggle="collapse" href="#setting" role="button" aria-expanded="{{ is_active_route(['setting/*']) }}" aria-controls="setting">
            <i class="link-icon" data-feather="settings"></i>
            <span class="link-title">Pengaturan</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse {{ show_class(['setting/*']) }}" id="setting">
            <ul class="nav sub-menu">
              <?php
              if($HakAkses->atur_layout == "Y"){?>
                <li class="nav-item" >
                  <a href="./index.php?op=setting" class="nav-link <?php echo $StatSetting;?>">Atur Layout</a>
                </li>
              <?php
              }
              if($HakAkses->atur_klasifikasi_sm == "Y"){?>
                <li class="nav-item">
                  <a href="./index.php?op=klasifikasi" class="nav-link <?php echo $StatKlasSM;?>">Klasifikasi Surat Masuk</a>
                </li>
							<?php
							}
              if($HakAkses->atur_klasifikasi_sk == "Y"){?>
                <li class="nav-item">
                  <a href="./index.php?op=klasifikasi_sk" class="nav-link <?php echo $StatKlasSK;?>">Klasifikasi Surat Keluar</a>
                </li>
							<?php
							}
              if($HakAkses->atur_klasifikasi_arsip == "Y"){?>
                <li class="nav-item">
                  <a href="./index.php?op=klasifikasi_file" class="nav-link <?php echo $StatKlasFile;?>">Klasifikasi File Arsip</a>
                </li>
							<?php
							}
              if($HakAkses->atur_user == "Y"){?>
                <li class="nav-item" >
                  <a href="./index.php?op=user" class="nav-link <?php echo $StatUser;?>">Data user</a>
                </li>
              <?php
              }?>
              
            </ul>
          </div>
        </li>
      <?php
      }
      ?>

      <?php
			if($HakAkses->report_sm == "Y" OR $HakAkses->report_sk == "Y" OR $HakAkses->report_arsip == "Y"){?>	
        <li class="nav-item <?php echo $StatReport;?>">
          <a class="nav-link" data-toggle="collapse" href="#laporan" role="button" aria-expanded="{{ is_active_route(['setting/*']) }}" aria-controls="setting">
            <i class="link-icon" data-feather="clipboard"></i>
            <span class="link-title">Laporan</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="laporan">
            <ul class="nav sub-menu">
              <?php
              if($HakAkses->report_dispo == "Y"){?>
                <li class="nav-item" >
                  <a href="./index.php?op=report_disposisi" class="nav-link <?php echo $StatDIS;?>">Disposisi</a>
                </li>
              <?php
              }
              if($HakAkses->report_progress == "Y"){?>
                <li class="nav-item">
                  <a href="./index.php?op=report_progress" class="nav-link <?php echo $StatReportProgress;?>">Progress Surat</a>
                </li>
              <?php
              }
              if($HakAkses->report_sm == "Y"){?>
                <li class="nav-item" >
                  <a href="./index.php?op=report_sm" class="nav-link <?php echo $StatRSM;?>">Surat Masuk</a>
                </li>
              <?php
              }
              if($HakAkses->report_sk == "Y"){?>
                <li class="nav-item" >
                  <a href="./index.php?op=report_sk" class="nav-link <?php echo $StatRSK;?>">Surat Keluar</a>
                </li>
              <?php
              }
              if($HakAkses->report_arsip == "Y"){?>
                <li class="nav-item" >
                  <a href="./index.php?op=report_arsip" class="nav-link <?php echo $StatReportArsip;?>">Data Arsip Digital</a>
                </li>
              <?php
              } ?>
              
            </ul>
          </div>
        </li>
      <?php
      } ?>

    </ul>
  </div>
</nav>

<nav class="settings-sidebar">
  <div class="sidebar-body">
    <a href="#" class="settings-sidebar-toggler">
      <i data-feather="settings"></i>
    </a>
    <h6 class="text-muted">Sidebar:</h6>
    <div class="form-group border-bottom">
      <div class="form-check form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarLight" value="sidebar-light" checked>
          Light
        </label>
      </div>
      <div class="form-check form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarDark" value="sidebar-dark">
          Dark
        </label>
      </div>
    </div>
  </div>
</nav>