<?php
ini_set("error_reporting", 0);
session_start();
if(isset($_POST['submit'])){
  $data = array();
  $data['nama_pelanggan'] = $_POST['nama_pelanggan'];
  $data['nohp_pelanggan'] = $_POST['nohp_pelanggan'];
  $data['alamat_pelanggan'] = $_POST['alamat_pelanggan'];
  if($_SESSION['data_pelanggan']){
    $data_pelanggan = $_SESSION['data_pelanggan'];
    array_push($data_pelanggan,$data);
    $_SESSION['data_pelanggan'] = $data_pelanggan;
  }else{
    $_SESSION['data_pelanggan'][] = $data;
  }
  header("location: ./index.php");
}
if($_SESSION['data_pelanggan']){ ?>
  <a href='?act=add'>Tambah[+]</a><br>
  <table border="1">
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Nohp</th>
      <th>Alamat</th>
      <th colspan="2">Action</th>
    </tr>
  <?php $no=0; foreach ($_SESSION['data_pelanggan'] as $key => $value) { $no++; ?>
    <tr>
      <td><?php echo $no;?></td>
      <td><?php echo $value['nama_pelanggan'];?></td>
      <td><?php echo $value['nohp_pelanggan'];?></td>
      <td><?php echo $value['alamat_pelanggan'];?></td>
      <td><button type="button" onclick="window.location='index.php?act=delete&id=<?php echo $key;?>'">Hapus</button></td>
      <td><button type="button" onclick="window.location='index.php?act=edit&id=<?php echo $key;?>'">Edit</button></td>
    </tr>
  <?php } ?>
  </table>
<?php }else{
  echo "belum ada data! <a href='?act=add'>tambah[+]</a>";
}
switch($_GET['act']){
  case "add":
    $form = "<p><form action='' method='post'>";
    $form .= "Nama pelanggan: <input type='text' name='nama_pelanggan'><br>";
    $form .= "Nohp pelanggan: <input type='text' name='nohp_pelanggan'><br>";
    $form .= "Alamat pelanggan: <input type='text' name='alamat_pelanggan'><br>";
    $form .= "<input type='submit' name='submit'></form><br>";
    echo $form;
    break;
  case "delete":
    $id = $_GET['id'];
    unset($_SESSION['data_pelanggan'][$id]);
    header("location: ./index.php");
    break;
  case "update":
    $id = $_GET['id'];
    $_SESSION['data_pelanggan'][$id]['nama_pelanggan'] = $_POST['nama_pelanggan'];
    $_SESSION['data_pelanggan'][$id]['nohp_pelanggan'] = $_POST['nohp_pelanggan'];
    $_SESSION['data_pelanggan'][$id]['alamat_pelanggan'] = $_POST['alamat_pelanggan'];
    header("location: ./index.php");
    break;
  case "edit":
    $id = $_GET['id'];
    $data_pelanggan = $_SESSION['data_pelanggan'][$id];
    $form = "<p><form action='?act=update&id={$id}' method='post'>";
    $form .= "Nama pelanggan: <input type='text' name='nama_pelanggan' value='{$data_pelanggan["nama_pelanggan"]}'><br>";
    $form .= "Nohp pelanggan: <input type='text' name='nohp_pelanggan' value='{$data_pelanggan["nohp_pelanggan"]}'><br>";
    $form .= "Alamat pelanggan: <input type='text' name='alamat_pelanggan' value='{$data_pelanggan["alamat_pelanggan"]}'><br>";
    $form .= "<input type='submit' name='update'></form><br>";
    echo $form;
    break;
  case "default":
  break;
}
?>