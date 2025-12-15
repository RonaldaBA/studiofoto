<?php
session_start();
require_once '../helper/connection.php';

$idcs = $_POST['id_cs'];
$nama = $_POST['nama'];
$nohp = $_POST['no_hp'];

$query = mysqli_query($connection, "UPDATE customer_service SET nama = '$nama', no_hp = '$nohp' WHERE id_cs = '$idcs'");
if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil mengubah data'
  ];
  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}
