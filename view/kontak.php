<?php 
 require_once 'db/db2.php';



if(isset($_GET['editid'])) {
	require_once "edit_kontak.php";
}else{

$id = $_SESSION['id_user'];
$users = mysqli_query($conn, "SELECT * FROM kontak WHERE id_user='$id'");



$id_del = $_GET['id'];
$delete = mysqli_query($conn, "DELETE FROM kontak WHERE id_kt='$id_del'");
?>

<div class="row justify-content-center">
<h3 class="card-title">List Kontak</h3>
  <div class="col-md-12 ">
    <div class="card">
      <div class="card-body">
        <a href="./index.php?op=add_kontak" class = 'btn btn-sm btn-primary float-md-right'>Add Contact</a>
        <br>
        <div class="table-responsive"><br>
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>No Telp</th>
                <th></th>
                
              </tr>
            </thead>
            <tbody>
            <?php foreach($users as $user):?>
              <tr>
                <td><?=$user['nama'];?></td>
                <td><a href="mailto:<?=$user['email'];?>"><?=$user['email'];?></a></td>
                <td><?=$user['alamat'];?></td>
                <td> <a href="tel:<?=$user['telepon'];?>"> <?=$user['telepon'];?></a></td>
                <td>
                    <a href="./index.php?op=kontak&editid=<?php echo $user['id_kt'];?> " class="btn btn-behance btn-icon">
                        <i class="ace-icon fa fa-pencil bigger-100"></i>
                    </a>
                    <a href="view/delete_kontak.php?id=<?php echo $user['id_kt']; ?>" class="btn btn-danger btn-icon" >
                        <i data-feather='trash' ></i>
                    </a>
                </td>
               
              </tr>
              <?php endforeach;?>
              
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
</div>
<?php 
}
?>