<?php
session_start();
require_once '../helper/connection.php';

$id = $_POST['id_pemesanan'];
$tglpesan = $_POST['tgl_pemesanan'];
$status = $_POST['status_pemesanan'];
$ringkasan = $_POST['ringkasan_biaya'];
$iduser = $_POST['id_user'];
$idpaket = $_POST['id_paket'];

$query = mysqli_query($connection, "insert into pemesanan(id_pemesanan, tgl_pemesanan, status_pemesanan, ringkasan_biaya, id_user, id_paket) value('$id', '$tglpesan', '$status', '$ringkasan', '$iduser', '$idpaket')");
if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menambah data'
  ];
  header('Location: ./index.php');
                                            } else {
                                              $_SESSION['info'] = [
                                                'status' => 'failed',
                                                'message' => mysqli_error($connection)
                                              ];
                                              header('Location: ./index.php');
                                            }
