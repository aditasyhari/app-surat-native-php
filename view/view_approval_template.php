<?php
require_once "db/db2.php";

if(isset($_GET['tpid'])){
	require_once "view_template_detail.php";
}else{ ?>
	<h6 class="card-title">Daftar Approval Template</h6>
	<?php
    $user = mysqli_query($conn, "SELECT * FROM user WHERE id_user='$_SESSION[id_user]'");
    while($userjab = $user->fetch_assoc()) {
        $user_idjab = $userjab['jabatan'];
    }

    $template = mysqli_query($conn, "SELECT * FROM template JOIN user_jabatan ON template.id_validator=user_jabatan.id_jab WHERE user_jabatan.id_jab='$user_idjab'");
    
    // echo $_SESSION['id_user'];
    // echo $user_idjab;
    // echo var_dump($template2);
    $row = mysqli_num_rows($template);
	if($row >= 1){?>
		<ul class="list-group">
			<?php
			$no=1+$posisi;
			while($data = $template->fetch_assoc()){
				?>
					<li class="list-group-item d-flex justify-content-between align-items-center">
						<div>
							<span><?php echo $no;?>. </span>
							<span title="<?php echo $data['nama_template'];?>"> 
								<?php echo $data['nama_template'];?>
                            </span>
						</div>
						<div>
                            <?php  
                                if($data['status_temp'] == 'pengajuan'){ ?>
                                    <span class="badge badge-secondary">Pengajuan</span>
                                <?php
                                }elseif($data['status_temp'] == 'revisi') { ?>
                                    <span class="badge badge-primary">Revisi</span>
                                <?php
                                }elseif($data['status_temp'] == 'disetujui') { ?>
                                    <span class="badge badge-success">Disetujui & Publish</span>
                                <?php
                                }elseif($data['status_temp'] == 'tolak') { ?>
                                    <span class="badge badge-danger">Ditolak</span>
                                <?php
                                }
                            ?>
						</div>
						<span class="badge badge-primary"><?php echo tgl_indo($data['tgl_dibuat']);?></span>
                        <div>
							<span class="btn btn-warning btn-xs btn-icon">
                                <a href="./view/view_template_print.php?tpid=<?php echo $data['id_template'];?>&act=pdf" target="_blank" class="text-white mt-2" title="View">
                                    <i data-feather="eye" class="mt-2 mb-2"></i>
                                </a>
                            </span>
                            <span class="btn btn-info btn-text-icon">
                                <a href="./index.php?op=approval_template&tpid=<?php echo $data['id_template'];?>" class="text-white" title="Approval">
                                    Approval
                                </a>
                            </span>
                        </div>
					</li>
					
				<?php
				$no++;
			}?>
						
		</ul>
		<?php
	}else{?>
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert">
				<i class="ace-icon fa fa-times"></i>
			</button>
			<p>
				<strong><i class="ace-icon fa fa-check"></i>Perhatian!</strong>
				Belum ada data approval template untuk anda. Terimakasih.
			</p>
		</div><?php
	}
	
}?>
