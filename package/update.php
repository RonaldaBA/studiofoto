<?php
session_start();
require_once '../helper/connection.php';

$id = $_POST['id_paket'];
$nama = $_POST['nama_paket'];
$deskripsi = $_POST['deskripsi'];
$harga = $_POST['harga_paket'];

$query = mysqli_query($connection, "UPDATE paket SET nama_paket = '$nama', deskripsi = '$deskripsi', harga_paket = '$harga' WHERE id_paket = '$id'");
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
