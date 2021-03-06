<nav class="navbar">
  <a href="#" class="sidebar-toggler">
    <i data-feather="menu"></i>
  </a>
  <div class="navbar-content" id="nav-search">

                    <?php
                    if(isset($_GET['op']) AND $_GET['op'] == "sm"){
                        $titlePlace = "Cari Surat Masuk ...";     
                        $value = "sm";
                    }elseif(isset($_GET['op']) AND $_GET['op'] == "arsip_sm"){
                        $titlePlace = "Cari Surat Masuk ...";
                        $value = "arsip_sm";
                    }elseif(isset($_GET['op']) AND $_GET['op'] == "arsip_sk"){
                        $titlePlace = "Cari Surat Keluar ...";
                        $value = "arsip_sk";
                    }elseif(isset($_GET['op']) AND $_GET['op'] == "sk"){
                        $titlePlace = "Cari Surat Keluar ...";
                        $value = "sk";
                    }elseif(isset($_GET['op']) AND $_GET['op'] == "memo"){
                        $titlePlace = "Cari Surat Masuk ...";
                        $value = "memo";
                    }elseif(isset($_GET['op']) AND $_GET['op'] == "disposisi"){
                        $titlePlace = "Cari Disposisi ...";
                        $value = "disposisi";
                    }elseif(isset($_GET['op']) AND $_GET['op'] == "tembusan"){
                        $titlePlace = "Cari Tembusan ...";
                        $value = "tembusan";
                    }elseif(isset($_GET['op']) AND $_GET['op'] == "arsip_file"){
                        $titlePlace = "Cari Arsip ...";
                        $value = "arsip_file";
                    }elseif(isset($_GET['op']) AND $_GET['op'] == "info"){
                        $titlePlace = "Cari Memo ...";
                        $value = "info";
                    }elseif(isset($_GET['op']) AND $_GET['op'] == "data_memo"){
                        $titlePlace = "Cari Arsip Memo ...";
                        $value = "data_memo";
                    }else{
                        $titlePlace = null;
                    }
                    if($titlePlace != null){?>
                        <!-- <div class="navbar-content" id="nav-search"> -->
                            <form class="search-form" method="GET" action="<?php echo $_SESSION['url'];?>">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="height: 35px;">
                                        <div class="input-group-text">
                                            <i data-feather="search"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="op" value="<?php echo $value;?>"/>
                                    <input type="text" class="form-control" id="navbarForm" placeholder="<?php echo $titlePlace;?>" name="keyword" autocomplete="off" />
                                </div>
                            </form>
                        <!-- </div> -->
                        <?php
                    }?>
                

                    
    
    <ul class="navbar-nav">
      <?php
        require_once 'db/db2.php';

        $user = mysqli_query($conn, "SELECT * FROM user WHERE id_user='$_SESSION[id_user]'");
        while($userjab = $user->fetch_assoc()) {
            $user_idjab = $userjab['jabatan'];
        }

        $read = 0;
        // $id_user = $_SESSION['id_user'];
        // echo $id_user;
        $cekApproval = mysqli_query($conn, "SELECT * FROM template JOIN user_jabatan ON template.id_validator=user_jabatan.id_jab WHERE user_jabatan.id_jab='$user_idjab' AND template.read_validator='$read'");
        $rowApproval = mysqli_num_rows($cekApproval);
        // echo $rowApproval;
        // $cekApproval = $this->model->selectprepare("template a", $field=null, $params=null, $where=null, "WHERE a.id_validator LIKE '%\"$_SESSION[id_user]\"%' AND a.read_validator=$read");
          
        // $cekSM2 = $this->model->selectprepare("arsip_sm a", $field=null, $params=null, $where=null, "WHERE a.tujuan_surat LIKE '%\"$_SESSION[id_user]\"%' AND a.id_sm NOT IN (SELECT b.id_sm FROM surat_read b WHERE b.id_user='$_SESSION[id_user]' AND b.kode='SM')", "ORDER BY a.tgl_terima DESC LIMIT 3");
        // while($dataApproval= $cekApproval->fetch(PDO::FETCH_OBJ)){
        //   $dumpApproval[]=$dataApproval;
        // }
        if ($rowApproval >= 1) {
          $linkApproval="./index.php?op=approval_template";
        } else {
          $linkApproval="#";
        }
      ?>

      <?php
        $cekSM = $this->model->selectprepare("arsip_sm a", $field=null, $params=null, $where=null, "WHERE a.tujuan_surat LIKE '%\"$_SESSION[id_user]\"%' AND a.id_sm NOT IN (SELECT b.id_sm FROM surat_read b WHERE b.id_user='$_SESSION[id_user]' AND b.kode='SM')");
          
        $cekSM2 = $this->model->selectprepare("arsip_sm a", $field=null, $params=null, $where=null, "WHERE a.tujuan_surat LIKE '%\"$_SESSION[id_user]\"%' AND a.id_sm NOT IN (SELECT b.id_sm FROM surat_read b WHERE b.id_user='$_SESSION[id_user]' AND b.kode='SM')", "ORDER BY a.tgl_terima DESC LIMIT 3");
        while($dataSM= $cekSM2->fetch(PDO::FETCH_OBJ)){
          $dumpSM[]=$dataSM;
        }
        if ($cekSM->rowCount() >= 1) {
          $link="./index.php?op=memo";
        } else {
          $link="#";
        }
      ?>

      <?php
        $field = array("a.id_user as userDis","a.*","b.*");
        $cekDispo = $this->model->selectprepare("memo a join arsip_sm b on a.id_sm=b.id_sm", $field, $params=null, $where=null, "WHERE a.disposisi LIKE '%\"$_SESSION[id_user]\"%' AND a.id_sm NOT IN (SELECT c.id_sm FROM surat_read c WHERE c.id_user='$_SESSION[id_user]' AND c.kode='DIS')");
        
        $cekDispo2 = $this->model->selectprepare("memo a join arsip_sm b on a.id_sm=b.id_sm", $field, $params=null, $where=null, "WHERE a.disposisi LIKE '%\"$_SESSION[id_user]\"%' AND a.id_sm NOT IN (SELECT c.id_sm FROM surat_read c WHERE c.id_user='$_SESSION[id_user]' AND c.kode='DIS') ORDER BY b.tgl_terima DESC LIMIT 3");
        
        while($dataDispo= $cekDispo2->fetch(PDO::FETCH_OBJ)){
          $dumpDispo[]=$dataDispo;
        }
        if($cekDispo->rowCount() >= 1){
          $linkDispo="./index.php?op=disposisi";
        }else{
          $linkDispo="#";
        }
      ?>

      <?php
        $field = array("a.id_user as userDis","a.*","b.*");
        $cekTembusan = $this->model->selectprepare("memo a join arsip_sm b on a.id_sm=b.id_sm", $field, $params=null, $where=null, "WHERE a.tembusan LIKE '%\"$_SESSION[id_user]\"%' AND a.id_sm NOT IN (SELECT c.id_sm FROM surat_read c WHERE c.id_user='$_SESSION[id_user]' AND c.kode='CC')");
        
        $cekTembusan2 = $this->model->selectprepare("memo a join arsip_sm b on a.id_sm=b.id_sm", $field, $params=null, $where=null, "WHERE a.tembusan LIKE '%\"$_SESSION[id_user]\"%' AND a.id_sm NOT IN (SELECT c.id_sm FROM surat_read c WHERE c.id_user='$_SESSION[id_user]' AND c.kode='CC') ORDER BY a.tgl DESC LIMIT 3");
        while($dataTembusan = $cekTembusan2->fetch(PDO::FETCH_OBJ)){
          $dumpTembusan[]=$dataTembusan;
        }
        if($cekTembusan->rowCount() >= 1){
          $linkTembusan="./index.php?op=sm";
        }else{
          $linkTembusan="#";
        }
      ?>

      <?php 
        if($cekSM->rowCount() >= 1 OR $cekDispo->rowCount() >= 1 OR $cekTembusan->rowCount() >= 1 OR $rowApproval >= 1) { ?>
          <audio autoplay src="./view/notif.mp3"></audio> <?php
        } 
      ?>

      <?php 
        if($cekSM->rowCount() >= 1 OR $cekDispo->rowCount() >= 1 OR $cekTembusan->rowCount() >= 1 OR $rowApproval >= 1) {
          $indicator = "indicator";
        } else {
          $indicator = "";
        }
      ?>

      <li class="nav-item dropdown nav-notifications">
        <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="bell"></i>
          <div id="indicator" class="<?php echo $indicator; ?>">
            <div class="circle"></div>
          </div>
        </a>

        <div class="dropdown-menu" aria-labelledby="notificationDropdown">
          <div class="dropdown-body">
            <a href="<?php echo $link; ?>" class="dropdown-item">
              <div class="icon">
                <i data-feather="mail"></i>
              </div>
                <?php
                if($cekSM->rowCount() >= 1){?>
                  <div class="content">
                    <p>Surat Masuk</p>
                    <p class="sub-text text-warning">
                      <?php echo $cekSM->rowCount();?>
                      Surat masuk baru
                    </p>
                  </div>
                  <?php
                }else{?>
                  <div class="content">
                    <p>Surat Masuk</p>
                    <p class="sub-text text-muted">Tidak ada surat masuk baru</p>
                  </div>
                  <?php
                }?>
            </a>
            <a href="<?php echo $linkDispo; ?>" class="dropdown-item">
              <div class="icon">
                <i data-feather="message-square"></i>
              </div>
              <?php 
              if($cekDispo->rowCount() >= 1) { ?>
                <div class="content">
                  <p>Disposisi</p>
                  <p class="sub-text text-warning">
                    <?php echo $cekDispo->rowCount(); ?>
                    Disposisi baru
                  </p>
                </div>
              <?php
              } else {?>
                <div class="content">
                  <p>Disposisi</p>
                  <p class="sub-text text-muted">Tidak ada disposisi baru</p>
                </div>
              <?php
              }?>
            </a>
            <a href="<?php echo $linkTembusan; ?>" class="dropdown-item">
              <div class="icon">
                <i data-feather="user-plus"></i>
              </div>

              <?php 
                if ($cekTembusan->rowCount() >= 1) {?>
                  <div class="content">
                    <p>Tembusan</p>
                    <p class="sub-text text-warning">
                      <?php echo $cekTembusan->rowCount(); ?>
                      Tembusan baru
                    </p>
                  </div>
                <?php
                } else {?>
                  <div class="content">
                    <p>Tembusan</p>
                    <p class="sub-text text-muted">Tidak ada tembusan baru</p>
                  </div>
                <?php
                }?>
            </a>
            <a href="<?php echo $linkApproval; ?>" class="dropdown-item">
              <div class="icon">
                <i data-feather="user-plus"></i>
              </div>

              <?php 
                if ($rowApproval >= 1) {?>
                  <div class="content">
                    <p>Approval Template</p>
                    <p class="sub-text text-warning">
                      <?php echo $rowApproval; ?>
                      Approval baru
                    </p>
                  </div>
                <?php
                } else {?>
                  <div class="content">
                    <p>Approval Template</p>
                    <p class="sub-text text-muted">Tidak ada approval baru</p>
                  </div>
                <?php
                }?>
            </a>

          </div>
          
        </div>
      </li>



      <li class="nav-item dropdown nav-profile">
        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="assets/images/avatars/<?php echo $_SESSION['picture'];?>" alt="profile">
        </a>
        <div class="dropdown-menu" aria-labelledby="profileDropdown">
          <div class="dropdown-header d-flex flex-column align-items-center">
            <!-- <div class="figure mb-3">
              <img src="{{asset('img/' . Auth::user()->gambar)}}" alt="">
            </div> -->
            <div class="info text-center">
              <p class="name font-weight-bold mb-0">Welcome</p>
              <p class="email text-muted mb-3"><?php echo $_SESSION['nama'];?></p>
            </div>
          </div>
          <div class="dropdown-body">
            <ul class="profile-nav p-0 pt-3">
              <li class="nav-item">
                <a href="./index.php?op=profil" class="nav-link">
                  <i data-feather="edit"></i>
                  <span>Edit Profile</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="./keluar"  onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" class="nav-link">
                  <i data-feather="log-out"></i>
                  <span>Log Out</span>
                </a>

                <form id="logout-form" action="./keluar" method="POST" class="d-none">
                  @csrf
                </form>
              </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </div>
</nav>