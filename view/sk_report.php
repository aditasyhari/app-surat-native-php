<!-- PAGE CONTENT BEGINS -->
<form class="form-horizontal" role="form" method="POST" name="formku" action="<?php echo $_SESSION['url'];?>">
	<div class="row">
		<div class="col-sm-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Laporan Surat Keluar</h4>
				</div><br>
				<div class="widget-body">
					<div class="widget-main">
						<label for="id-date-range-picker-1">Filter berdasarkan Range Tanggal</label>

						<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
									<div class="input-group input-daterange" id="datePickerExample">
									<input type="text" class="form-control" name="rangetgl" value="">
										<div class="input-group-addon"> to </div>
										<input type="text" class="form-control" name="rangetgl" value="">
									</div>
									</div>
								</div>
								<div class="form-check form-check-flat form-check-primary mt-0">
									<label class="form-check-label">
									<input name="filterTgl" type="checkbox" class="form-check-input">
									</label>
								</div>
							</div>






						<!-- <div class="row">
							<div class=" col-sm-6">
								<div class="form-group">
								<div class="input-group date datepicker" id="datePickerExample">
									<input class="form-control" type="text" name="rangetgl" id="id-date-range-picker-1" /><span class="input-group-addon"><i data-feather="calendar"></i></span>
								</div>
								</div>
							</div>
						</div> -->
						<div class="space-6"></div>
						<div class="row">
							<div class=" col-sm-6">
								<div class="input-group">
									<button type="submit" class="btn btn-primary" type="button">
										<i class="ace-icon fa fa-check bigger-110"></i>
										Submit
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form><br>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){?>
	<div class="row">
		<div class="col-sm-6">
			<div class="widget-box">
				<div class="widget-body">
					<div class="widget-main"><?php
						//print_r($_POST);
						$from = explode("/", substr($_POST['rangetgl'],0,10));
						$tglfrom = htmlspecialchars($from[2]."-".$from[0]."-".$from[1]);
						$to = explode("/", substr($_POST['rangetgl'],-10));
						$tglto = htmlspecialchars($to[2]."-".$to[0]."-".$to[1]); 
						//echo "$tglfrom $tglto";
						$arsip_sm = $this->model->selectprepare("arsip_sk", $field=null, $params=null, $where=null, "where tgl_surat between '$tglfrom' and '$tglto' order by tgl_surat ASC");
						if($arsip_sm->rowCount() >= 1){
							while($data_sm = $arsip_sm->fetch(PDO::FETCH_OBJ)){
								$dump_sm[]=$data_sm;
							}?>
								<center><h4>Data Surat Keluar <b><?php echo tgl_indo($tglfrom);?></b> s/d <b><?php echo tgl_indo($tglto);?></b></h4></center>
								<table id="simple-table" class="table  table-bordered table-hover">
									<thead>
										<tr>
											<th>No</th>
											<th width="100">No Agenda</th>
											<th>No Surat</th>
											<th width="150">Tgl Surat</th>
											<th width="140">Pengolah</th>
											<th width="140">Klasifikasi</th>
											<th width="200">Tujuan Surat</th>
											<th width="200">Perihal</th>
										</tr>
									</thead>
									<tbody><?php
										$no=1;
										foreach($dump_sm as $key => $object){
											$tglsurat = explode("-", $object->tgl_surat);
											$tglsurat = $tglsurat[2]."/".$tglsurat[1]."/".$tglsurat[0];					
											$CekKlasifikasi = $this->model->selectprepare("klasifikasi_sk", $field=null, $params=null, $where=null, "WHERE id_klas='$object->klasifikasi'");
											$ViewKlasifikasi = $CekKlasifikasi->fetch(PDO::FETCH_OBJ);?>
											<tr>
												<td><center><?php echo $no;?></center></td>
												<td><?php echo $object->custom_noagenda;?></td>
												<td><?php echo $object->no_sk;?></td>
												<td><?php echo $tglsurat;?></td>
												<td><?php echo $object->pengolah;?></td>
												<td><?php echo $ViewKlasifikasi->nama;?></td>
												<td><?php echo $object->tujuan_surat;?></td>
												<td><?php echo $object->perihal;?></td>
											</tr><?php
										$no++;
										}?>
										<tr>
											<td colspan=7>
												<span class="label label-xs label-primary label-white middle">
													<a href="./index.php?op=report_sk_print&start=<?php echo $tglfrom;?>&to=<?php echo $tglto;?>" target="_blank"><b>Print</b> <i class="ace-icon fa fa-print align-top bigger-125 icon-on-right"></i></a>
												</span>
												<span class="label label-xs label-danger label-white middle">
												<a href="./index.php?op=report_sk_print&start=<?php echo $tglfrom;?>&to=<?php echo $tglto;?>&act=pdf" target="_blank"><b>Pdf</b> <i class="ace-icon fa fa-file-pdf-o align-top bigger-125 icon-on-right"></i></a>
												</span>
											</td>
										</tr>
									</tbody>
								</table><?php
						}else{?>
							<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert">
									<i class="ace-icon fa fa-times"></i>
								</button>
								<p>
									<strong><i class="ace-icon fa fa-check"></i>Perhatian!</strong>
									Data tidak ditemukan. Terimakasih.
								</p><br>
								<p>
									<a href="./index.php?op=report_sk"><button class="btn btn-minier btn-danger">Kembali</button></a>
								</p>
							</div><?php
						}?>
					</div>
				</div>
			</div>
		</div>
	</div><?php
}?>