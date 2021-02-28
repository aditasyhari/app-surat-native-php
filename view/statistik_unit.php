            
   <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "surat";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        // $id =$_SESSION['id_user'];
        // if($_POST['pilih']){
        //     $id = $_POST['tujuan'];
        // }

        // echo $id;

        $sql = "SELECT * FROM arsip_sm INNER JOIN user ON arsip_sm.id_user = user.id_user INNER JOIN user_jabatan ON user.jabatan = user_jabatan.id_jab WHERE user_jabatan.nama_jabatan = 'ICT' GROUP BY MONTH(arsip_sm.created)";
        // $sql = "SELECT arsip_sm.created,COUNT(*) as jumlah FROM arsip_sm INNER JOIN user ON arsip_sm.id_user = user.id_user INNER JOIN user_jabatan ON user.jabatan = user_jabatan.id_jab WHERE user_jabatan.nama_jabatan = \'KAPOLDA\' GROUP BY MONTH(arsip_sm.created)";
        $result = mysqli_query($conn, $sql);
        $numRow = mysqli_num_rows($result);

        if ($numRow > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {

                // echo "<pre>";print_r($row);echo "</pre>";
                $date = $row['created'];
                $bulan = date("F-Y",strtotime($date));
                $arr = array(
                    'name' => $bulan,
                    'data' => array_map('intval',explode(',',$row['jumlah']))
                );
                echo $date.' '.$bulan;

                // $series_arr[] = $arr;
                // echo $arr;
            }
            // return json_encode($series_arr);
        // echo $series_arr;
        echo $numRow;
        } else {
            echo "0 results";
        }
        $conn->close();
    ?>
            <div class="row">

                <form class="" role="form" enctype="multipart/form-data" method="POST" name="formku" action="<?php echo $_SESSION['url'];?>">
                    <div class="form-group">
                        <select class="js-example-basic-multiple w-100 form-control" name="tujuan"  data-placeholder="Pilih user..." required><?php
									$Diteruskan = $this->model->selectprepare("user a join user_jabatan b on a.jabatan=b.id_jab", $field=null, $params=null, $where=null, "ORDER BY a.nama ASC");
									if($Diteruskan->rowCount() >= 1){
										while($dataDiteruskan = $Diteruskan->fetch(PDO::FETCH_OBJ)){
											$DiteruskanSurat = $dataDiteruskan->nama ." (".$dataDiteruskan->nama_jabatan .")";
											if(false !== array_search($dataDiteruskan->id_user, $cekDiteruskan)){?>
												<option value="<?php echo $dataDiteruskan->id_user;?>" selected><?php echo $DiteruskanSurat;?></option><?php
											}else{?>
												<option value="<?php echo $dataDiteruskan->id_user;?>"><?php echo $DiteruskanSurat;?></option><?php
											}
										}								
									}else{?>
										<option value="">Not Found</option><?php
									}?>
                                    
					    </select><br>
                    </div>
                            <div class="form-group">
                                <select class="js-example-basic-multiple w-100 form-control" name="tgl"  data-placeholder="Pilih Tanggal...">
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
								</select>
                            </div>
                            
                            <div class="form-group">
                                <select id='year' class="js-example-basic-multiple w-100 form-control" name="tahun"  data-placeholder="Pilih Tanggal...">
								</select>
                            </div>
                                <hr>
                                <button name = 'pilih' type ='submit' class = 'btn btn-primary pull-right'> PILIH </button>
                </form>
            </div>




<div id="chart">
</div>

<script type="text/javascript">
    var start = new Date().getFullYear();
    var end = 1999;
    var options = "";
    for(var year = start ; year >=end; year--){
    options += "<option>"+ year +"</option>";
    }
    document.getElementById("year").innerHTML = options;


    // var data = <?php echo json_encode($json);?>
    

    
  Highcharts.chart('chart', {
    chart: {
            type: 'column'
        },
      title: {
          text: 'STATISTIK PER UNIT'
      },
      subtitle: {
          text: ''
      },
      xAxis: {
        categories: [],
      },
      yAxis: {
          title: {
              text: 'Jumlah'
          }
      },
      legend: {
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'middle'
      },
      plotOptions: {
          series: {
              allowPointSelect: true
          }
      },
      series: [{
                data: [2, 5],
                lineWidth: 5}],
      responsive: {
          rules: [{
              condition: {
                  maxWidth: 500
              },
              chartOptions: {
                  legend: {
                      layout: 'horizontal',
                      align: 'center',
                      verticalAlign: 'bottom'
                  }
              }
          }]
      }
  });
</script>