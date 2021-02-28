<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "surat";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id =$_SESSION['id_user'];
echo $id;

$sql = "SELECT created,COUNT(*) as jumlah FROM arsip_sm WHERE id_user = '$id' GROUP BY MONTH(created)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {

    // echo "<pre>";print_r($row);echo "</pre>";
    $date = $row['created'];
    $bulan = date("F-Y",strtotime($date));
    $arr = array(
        'name' => $bulan,
        'data' => array_map('intval',explode(',',$row['jumlah']))
    );
    $series_arr[] = $arr;
  }
  return json_encode($series_arr);
} else {
  echo "0 results";
}
$conn->close();
?>