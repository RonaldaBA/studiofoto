<?php
session_start();
require_once '../helper/connection.php';

$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$query = mysqli_query($connection, "insert into user(id, username, password, role) value('$id', '$username', '$password', '$role')");
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
