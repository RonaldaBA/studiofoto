<?php
session_start();
require_once '../helper/connection.php';

$idcs = $_POST['id_cs'];
$nama = $_POST['nama'];
$nohp = $_POST['no_hp'];

$query = mysqli_query($connection, "insert into customer_service(id_cs, nama, no_hp) value('$idcs', '$nama', '$nohp')");
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
