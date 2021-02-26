<?php
require_once "db/db2.php";

if(isset($_GET['tpid'])){
	require_once "view_template_detail.php";
}elseif(isset($_GET['editid'])) {
	require_once "view_edit_template.php";
}else{ ?>
	<h6 class="card-title">Daftar Template</h6>
	<?php
    $template = mysqli_query($conn, "select * from template where id_pembuat='$_SESSION[id_user]' ORDER BY tgl_dibuat DESC");
    $row = mysqli_num_rows($template);
	
	if($row >= 1){?>
	<table class="table table-bordered">
            <th>No</th>
            <th>Nama Template</th>
            <th>Status</th>
            <th>Tanggal dibuat</th>
            <th>ACT</th>

			<?php
			$no=1+$posisi;
			while($data = $template->fetch_assoc()){ ?>
            <tr>
                <td width="10"><?php echo $no;?></td>
                <td>
					<a href="./index.php?op=template&tpid=<?php echo $data['id_template'];?>">
						<?php echo $data['nama_template'];?>
					</a>
				</td>
                <td>
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
                </td>
                <td><?php echo tgl_indo($data['tgl_dibuat']);?></td>
                <td width="100">
					<span class="btn btn-warning btn-xs btn-icon">
						<a href="./view/view_template_print.php?tpid=<?php echo $data['id_template'];?>&act=pdf" target="_blank" class="text-white mt-2" title="View">
							<i data-feather="eye" class="mt-2 mb-2"></i>
						</a>
					</span>
					<span class="btn btn-primary btn-xs btn-icon">
						<a href="./index.php?op=template&editid=<?php echo $data['id_template'];?>" class="text-white mt-2" title="Edit">
							<i data-feather="edit-2" class="mt-2 mb-2"></i>
						</a>
					</span>
					<span class="btn btn-danger btn-xs btn-icon" onclick="confirm('Yakin dihapus?')">
						<a href="view/delete_template.php?id_template=<?php echo $data['id_template']; ?>" class="text-white mt-2" title="Hapus">
							<i data-feather="trash" class="mt-2 mb-2"></i>
						</a>
					</span>
                </td>
            </tr>
			<?php
			$no++;
			}?>
        </table>

		<?php
	}else{?>
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert">
				<i class="ace-icon fa fa-times"></i>
			</button>
			<p>
				<strong><i class="ace-icon fa fa-check"></i>Perhatian!</strong>
				Belum ada data template yang dibuat. Terimakasih.
			</p>
		</div><?php
	}
	
}?>
