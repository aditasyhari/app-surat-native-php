<?php
//   require ('db.php');
$data = include('data-statistik.php'); 
// $connect = new PDO('mysql:host=localhost;dbname=surat', 'root', '');
// $sth = $connect->prepare("SELECT count(*) as total  from arsip_sm WHERE id_user = '1' GROUP BY DATE(created)");
// $sth->execute();
//     $json = [(int)$sth->fetchColumn()];

// // echo json_encode($json);
// // echo json_encode($sth->fetchColumn());
// echo $data;
?>

<div id="container"></div>

<script type="text/javascript">
    // var data = <?php echo json_encode($json);?>
    

    
  Highcharts.chart('container', {
    chart: {
            type: 'column'
        },
      title: {
          text: 'STATISTIK PEREDARAN SURAT'
      },
      subtitle: {
          text: ''
      },
      xAxis: {
        categories: ["SURAT MASUK"],
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
      series:<?= $data ?> ,
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