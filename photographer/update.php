<?php
session_start();
require_once '../helper/connection.php';

$idpg = $_POST['id_photographer'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$nohp = $_POST['no_hp'];

$query = mysqli_query($connection, "UPDATE photographer SET nama = '$nama', email = '$email', no_hp = '$nohp' WHERE id_photographer = '$idpg'");
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
