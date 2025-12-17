<?php
session_start();
require_once '../helper/connection.php';

$id_customer  = intval($_POST['id_customer']);
$id_pemesanan = intval($_POST['id_pemesanan']);
$upload_date  = date('Y-m-d');

$photo_count = mysqli_query($connection, "
    SELECT COUNT(*) AS total
    FROM gallery
    WHERE id_pemesanan = $id_pemesanan
");

$row = mysqli_fetch_assoc($photo_count);
$total_photo = $row['total'] + 1;

// validasi upload
if (!isset($_FILES['file_name']) || $_FILES['file_name']['error'] !== 0) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'File foto wajib diupload'
    ];
    header('Location: ./index.php');
    exit;
}

// proses upload file
$ekstensi  = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
$file_name = 'richart-photo'. $total_photo . '-' . $id_pemesanan . '.' . $ekstensi;
$tmp       = $_FILES['file_name']['tmp_name'];
$tujuan    = "../assets/img/data/" . $file_name;

if (!move_uploaded_file($tmp, $tujuan)) {
    $_SESSION['info'] = [
        'status' => 'failed',
        'message' => 'Gagal upload foto'
    ];
    header('Location: ./index.php');
    exit;
}

// insert ke database
$query = mysqli_query($connection, "INSERT INTO gallery (id_customer, id_pemesanan, file_name, upload_date) VALUES ('$id_customer', '$id_pemesanan', '$file_name', '$upload_date')");
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
