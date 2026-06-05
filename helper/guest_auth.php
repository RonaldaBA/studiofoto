<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "connection.php";

if(isset($_SESSION['guest_token'])){
    $token = $_SESSION['guest_token'];
}
elseif(isset($_COOKIE['guest_token'])){
    $token = $_COOKIE['guest_token'];

    $_SESSION['guest_token'] = $token;
}
else{
    header("Location: booking.php");
    exit;
}

$token = $_SESSION['guest_token'];

$query = mysqli_query(
    $connection,
    "SELECT *
     FROM guest_account
     WHERE guest_token='$token'
     LIMIT 1"
);

if(mysqli_num_rows($query) == 0){

    session_destroy();

    header("Location: ../guest/booking.php");
    exit;
}

$guest = mysqli_fetch_assoc($query);

if(
    $guest['status'] == 'inactive'
    ||
    strtotime($guest['expired_at']) < time()
){

    mysqli_query(
        $connection,
        "UPDATE guest_account
         SET status='inactive'
         WHERE id_guest='{$guest['id_guest']}'"
    );

    session_destroy();

    echo "
    <h2>Masa Aktif Guest Berakhir</h2>
    <p>Silahkan daftar akun untuk melanjutkan.</p>
    ";

    exit;
}

$guest_customer_id = $guest['id_customer'];