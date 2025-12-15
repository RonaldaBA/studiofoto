<?php
session_start();
require_once '../helper/connection.php';

$id_user = $_GET['id_user'];

$result = mysqli_query($connection, "DELETE FROM customer WHERE id_user='$id_user'");

if (mysqli_affected_rows($connection) > 0) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menghapus data'
  ];
  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}
