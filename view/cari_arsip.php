<!-- PAGE CONTENT BEGINS -->

	<div class="row">
		<div class="col-sm-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Report Arsip Digital</h4>
				</div>
				<div class="card">
					<div class="card-body">
						<form class="form-horizontal" role="form" method="POST" name="formku" action="<?php echo $_SESSION['url'];?>">
							<label class="tx-14 font-weight-bold mb-0 text-uppercase" for="id-date-range-picker-1">Filter Nomor Arsip</label>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<input class="form-control" placeholder="Nomor arsip" type="text" name="noarsip" id="form-field-1" data-placement="bottom" />
									</div>
								</div>

								<div class="form-check form-check-flat form-check-primary mt-0">
									<label class="form-check-label">
									<input name="filterNoArsip" type="checkbox" class="form-check-input" value="1">
									</label>
								</div>
							</div>

							<label class="tx-14 font-weight-bold mb-0 text-uppercase" for="id-date-range-picker-1">Filter Tanggal</label>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<div class="input-group input-daterange" id="datePickerExample">
											<input type="text" class="form-control" name="rangetgl1" value="">
											<div class="input-group-addon"> to </div>
											<input type="text" class="form-control" name="rangetgl2" value="">
										</div>
								
									</div>
								</div>

								<div class="form-check form-check-flat form-check-primary mt-0">
									<label class="form-check-label">
										<input name="filterTgl" type="checkbox" class="form-check-input" value="1">
									</label>
								</div>
							</div>

							<label class="tx-14 font-weight-bold mb-0 text-uppercase" for="form-field-mask-1">Filter Klasifikasi</label>
							<select class="js-example-basic-single w-100" name="klasifikasi" require data-placeholder="Pilih Klasifikasi...">
									<option value="">Pilih klasifikasi...</option>
									<?php 
										$klasArsip = $this->model->selectprepare("klasifikasi_arsip", $field=null, $params=null, $where=null, "ORDER BY nama_klasifikasi ASC");
										while($dataKlasArsip= $klasArsip->fetch(PDO::FETCH_OBJ)){?>
											<option value="<?php echo $dataKlasArsip->id_klasifikasi;?>"><?php echo $dataKlasArsip->nama_klasifikasi;?></option><?php
										}?>
									</select>
							</select>
							</div>
							</div>



							<!-- <label>Filter Klasifikasi</label><span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Checklist pada tombol yang tersedia untuk mengaktifkan filter ini. Pilih klasifikasi arsip." title="Filter Klasifikasi">?</span>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<select class="js-example-basic-single w-100" name="klasifikasi" require data-placeholder="Pilih Klasifikasi...">
											<option value="">Pilih klasifikasi...</option>
											<?php 
											$klasArsip = $this->model->selectprepare("klasifikasi_arsip", $field=null, $params=null, $where=null, "ORDER BY nama_klasifikasi ASC");
											while($dataKlasArsip= $klasArsip->fetch(PDO::FETCH_OBJ)){?>
												<option value="<?php echo $dataKlasArsip->id_klasifikasi;?>"><?php echo $dataKlasArsip->nama_klasifikasi;?></option><?php
											}?>
											
										</select>
									</div>
								</div>
								<div class="form-check form-check-flat form-check-primary mt-0">
									<label class="form-check-label">
										<input name="filterKlas" type="checkbox" class="form-check-input" value="1">
									</label>
								</div>
							</div>

							<div class="space-6"></div>
							<div class="row">
								<div class="col-xs-8 col-sm-2">
									<div class="input-group">
										<button type="submit" class="btn btn-primary" type="button">
											<i class="ace-icon fa fa-check bigger-110"></i>
											Submit
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){?>
	<br><div class="row">
		<div class="col-sm-12">
			<div class="widget-box">
				<div class="card">
					<div class="card-body"><?php
						//print_r($_POST);
						$from = explode("/", substr($_POST['rangetgl1'],0,10));
						$tglfrom = htmlspecialchars($from[2]."-".$from[0]."-".$from[1]);
						$to = explode("/", substr($_POST['rangetgl2'],-10));
						$tglto = htmlspecialchars($to[2]."-".$to[0]."-".$to[1]); 
						$noarsip = htmlspecialchars($purifier->purify(intval(trim($_POST['noarsip']))), ENT_QUOTES);
						$OtherWhere = "";
						$klasifikasi = htmlspecialchars($purifier->purify(trim($_POST['klasifikasi'])), ENT_QUOTES);
						if(isset($_POST['filterNoArsip'])){
							$OtherWhere .= "AND a.no_arsip = '$noarsip'";
						}
						if(isset($_POST['filterKlas'])){
							$OtherWhere .= "AND a.id_klasifikasi = '$klasifikasi'";
						}
						if(isset($_POST['filterTgl'])){
							$OtherWhere .= "AND a.tgl_arsip between '$tglfrom' and '$tglto'";
						}
						$ArsipFile = $this->model->selectprepare("arsip_file a JOIN klasifikasi_arsip b on a.id_klasifikasi=b.id_klasifikasi", $field=null, $params=null, $where=null, "where a.id_klasifikasi !='' $OtherWhere order by a.tgl_arsip DESC");
						//print_r($_POST);
						
						if($ArsipFile->rowCount() >= 1){
							while($dataArsipFile = $ArsipFile->fetch(PDO::FETCH_OBJ)){
								$dump_ArsipFile[]=$dataArsipFile;
							}?>
							<center><h4>Hasil Pencarian Data Arsip</h4><?php
								if(isset($_POST['klasifikasi']) AND $_POST['klasifikasi'] !=''){
									$params = array(':id_klasifikasi' => trim($_POST['klasifikasi']));
									$DataKlas = $this->model->selectprepare("klasifikasi_arsip", $field=null, $params, "id_klasifikasi=:id_klasifikasi", $other=null);
									$dataDataKlas = $DataKlas->fetch(PDO::FETCH_OBJ);?>
										(Klasifikasi : <b><?php echo $dataDataKlas->nama_klasifikasi;?></b>) <br/><small><?php
								}
								if(isset($_POST['filterTgl'])){?>
									(Tanggal <b><?php echo tgl_indo($tglfrom);?></b> s/d <b><?php echo tgl_indo($tglto);?></b>)<?php
								}?></small>
							</center>
							<table id="simple-table" class="table  table-bordered table-hover">
								<thead>
									<tr>
										<th width="10">No</th>
										<th width="100">Nomor Arsip</th>
										<th width="160">Keamanan</th>
										<th width="190">Klasifikasi</th>
										<th width="120">Tanggal Arsip</th>
										<th width="120">Tanggal Upload</th>
										<th>Ket</th>
										<th width="20">File</th>
									</tr>
								</thead>
								<tbody><?php
									$no=1;
									foreach($dump_ArsipFile as $key => $object){
										$tglFile = explode("-", $object->tgl_upload);
										$tglFile = $tglFile[2]."-".$tglFile[1]."-".$tglFile[0];
										$tgl_arsip = explode("-", $object->tgl_arsip);
										$tgl_arsip = $tgl_arsip[2]."-".$tgl_arsip[1]."-".$tgl_arsip[0];
										/* $UnitKerja = $this->model->selectprepare("unit_kerja", $field=null, $params=null, $where=null, "where id_unit='$object->id_unit'");
										$dataUnitKerja = $UnitKerja->fetch(PDO::FETCH_OBJ); */?>
										<tr>
											<td><center><?php echo $no;?></center></td>
											<td><?php echo sprintf("%04d", $object->no_arsip);?></td>
											<td><?php echo $object->keamanan;?></td>
											<td><?php echo $object->nama_klasifikasi;?></td>
											<td><?php echo $tgl_arsip;?></td>
											<td><?php echo $tglFile;?></td>
											<td><?php echo $object->ket;?></td>
											<td><a href="./berkas/<?php echo $object->file_arsip;?>" target="_blank"><button class="btn btn-minier btn-success">view</button></a>
										</tr><?php
									$no++;
									}?>
									<tr>
										<td colspan=8>
											<span class="label label-xs label-primary label-white middle">
												<a href="./index.php?op=report_arsip_print&start=<?php echo $tglfrom;?>&to=<?php echo $tglto;?>&noarsip=<?php echo trim($_POST['noarsip']);?>&filno=<?php echo $_POST['filterNoArsip'];?>&klas=<?php echo $klasifikasi;?>&fil_klas=<?php echo $_POST['filterKlas'];?>&fil_tgl=<?php echo $_POST['filterTgl'];?>" target="_blank"><b>Print</b> <i class="ace-icon fa fa-print align-top bigger-125 icon-on-right"></i></a>
											</span>
											<span class="label label-xs label-danger label-white middle">
											<a href="./index.php?op=report_arsip_print&start=<?php echo $tglfrom;?>&to=<?php echo $tglto;?>&noarsip=<?php echo $noarsip;?>&filno=<?php echo $_POST['filterNoArsip'];?>&klas=<?php echo $klasifikasi;?>&fil_klas=<?php echo $_POST['filterKlas'];?>&fil_tgl=<?php echo $_POST['filterTgl'];?>&act=pdf" target="_blank"><b>Pdf</b> <i class="ace-icon fa fa-file-pdf-o align-top bigger-125 icon-on-right"></i></a>
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
								</p>
							</div><?php
						}?>
					</div>
				</div>
			</div>
		</div>
	</div><?php
}?>