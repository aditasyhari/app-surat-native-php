                
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
       
            $id = $_POST['tujuan'];
            $bulan = $_POST['bulan'];
            $tahun = $_POST['tahun'];
        

        // echo $id;

        $sql = "SELECT COUNT(*) as jumlah FROM arsip_sm INNER JOIN user ON arsip_sm.id_user = user.id_user INNER JOIN user_jabatan ON user.jabatan = user_jabatan.id_jab WHERE arsip_sm.id_user = '$id' AND MONTH(arsip_sm.created) = '$bulan' AND YEAR(arsip_sm.created) = '$tahun' GROUP BY MONTH(arsip_sm.created)";
        $sql2 = "SELECT COUNT(*) as jumlah FROM arsip_sk INNER JOIN user ON arsip_sk.id_user = user.id_user INNER JOIN user_jabatan ON user.jabatan = user_jabatan.id_jab WHERE arsip_sk.id_user = '$id' AND MONTH(arsip_sk.created) = '$bulan' AND YEAR(arsip_sk.created) = '$tahun' GROUP BY MONTH(arsip_sk.created)";
        $result = mysqli_query($conn, $sql);
        $result2 = mysqli_query($conn, $sql2);
        $numRow = mysqli_num_rows($result);
        $numRow2 = mysqli_num_rows($result2);

        if ($numRow > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {
                $data = $row['jumlah'];
            }
            // echo $data;
        } else {
            // echo "0 results";
        }

        if ($numRow2 > 0) {
            // output data of each row
                while($row2 = $result2->fetch_assoc()) {
                    $data2 = $row2['jumlah'];
                }
                // echo $data2;
            } else {
                // echo "0 results";
            }

        $conn->close();
    ?>
                <form class="form-sample" role="form" enctype="multipart/form-data" method="POST" name="formku" action="<?php echo $_SESSION['url'];?>">
                    <div class="row justify-content-center">
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
                                    
					             </select> 
                                <select class="js-example-basic-multiple w-100 form-control" name="bulan" data-placeholder="Pilih Tanggal...">
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
                            </div> &nbsp
                            <div class="form-group">
                                <select id='year' class="js-example-basic-multiple w-100 form-control" name="tahun"  data-placeholder="Pilih Tanggal...">
								</select>
                                <button name = 'pilih' type ='submit' class = 'btn btn-primary'> PILIH </button>
                            </div>
                            
                    </div>
                </form>
                <hr>
            




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
        categories: [' '],
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
      series: [
          {
                name:['surat masuk'],
                data: [<?= $data?>],
                color: "#6163fc"
          },

          {
                name:['surat keluar'],
                data: [<?= $data2?>],
                color: "#c70039"
          },
        //   {
        //         name:['surat keluar'],
        //         data: [<?= $suratKeluar?>],
        //   },
      ],
      
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