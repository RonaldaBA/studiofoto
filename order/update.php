<?php
session_start();
require_once '../helper/connection.php';

$id = $_POST['id_pemesanan'];
$tglpesan = $_POST['tgl_pemesanan'];
$status = $_POST['status_pemesanan'];
$ringkasan = $_POST['ringkasan_biaya'];
$iduser = $_POST['id_customer'];
$idpaket = $_POST['id_paket'];

$query = mysqli_query($connection, "UPDATE pemesanan SET tgl_pemesanan = '$tglpesan', status_pemesanan = '$status', ringkasan_biaya = '$ringkasan', id_customer = '$iduser', id_paket = '$idpaket' WHERE id_pemesanan = '$id'");
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
