<?php
session_start();
require_once '../helper/connection.php';

$id = $_POST['id_paket'];
$nama = $_POST['nama_paket'];
$deskripsi = $_POST['deskripsi'];
$harga = $_POST['harga_paket'];

$query = mysqli_query($connection, "insert into paket(id_paket, nama_paket, deskripsi, harga_paket) value('$id', '$nama', '$deskripsi', '$harga')");
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
