<?php
session_start();
require_once '../helper/connection.php';

$id_customer = $_POST['id_customer'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];
$nohp = $_POST['no_hp'];

$query = mysqli_query($connection, "UPDATE customer SET nama = '$nama', email = '$email', password = '$password', no_hp = '$nohp' WHERE id_customer = '$id_customer'");
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
