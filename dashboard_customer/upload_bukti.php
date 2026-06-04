<?php
include "../helper/auth.php";
include "../helper/connection.php";
isLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: riwayat_transaksi.php");
    exit;
}

$id_pemesanan = $_POST['id_pemesanan'];
$id_customer  = $_SESSION['id_customer'];

// Validasi: pesanan milik customer yang login
$q = mysqli_query($connection, "
    SELECT id_pemesanan, status_pemesanan, metode_pembayaran, bukti_pembayaran
    FROM pemesanan
    WHERE id_pemesanan = '$id_pemesanan' AND id_customer = '$id_customer'
");

if (mysqli_num_rows($q) == 0) {
    header("Location: riwayat_transaksi.php");
    exit;
}

$pesanan = mysqli_fetch_assoc($q);

// Hanya boleh upload kalau QRIS & masih Menunggu Pembayaran
if (
    $pesanan['metode_pembayaran'] !== 'QRIS' ||
    $pesanan['status_pemesanan'] !== 'Menunggu Pembayaran'
) {
    header("Location: struk_pembayaran.php?id=$id_pemesanan");
    exit;
}

// Validasi file
if (!isset($_FILES['bukti_pembayaran']) || $_FILES['bukti_pembayaran']['error'] !== UPLOAD_ERR_OK) {
    header("Location: struk_pembayaran.php?id=$id_pemesanan&upload_error=Gagal+upload+file.");
    exit;
}

$file     = $_FILES['bukti_pembayaran'];
$maxSize  = 2 * 1024 * 1024; // 2MB
$allowed  = ['image/jpeg', 'image/jpg', 'image/png'];

if ($file['size'] > $maxSize) {
    header("Location: struk_pembayaran.php?id=$id_pemesanan&upload_error=Ukuran+file+melebihi+2MB.");
    exit;
}

if (!in_array($file['type'], $allowed)) {
    header("Location: struk_pembayaran.php?id=$id_pemesanan&upload_error=Format+file+harus+JPG+atau+PNG.");
    exit;
}

// Simpan file
$uploadDir = "../assets/img/bukti/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = "bukti-" . $id_pemesanan . "-" . time() . "." . $ext;
$dest     = $uploadDir . $filename;

if (!move_uploaded_file($file['tmp_name'], $dest)) {
    header("Location: struk_pembayaran.php?id=$id_pemesanan&upload_error=Gagal+menyimpan+file.");
    exit;
}

// Hapus file lama kalau ada
if (!empty($pesanan['bukti_pembayaran'])) {
    $oldFile = $uploadDir . $pesanan['bukti_pembayaran'];
    if (file_exists($oldFile)) {
        unlink($oldFile);
    }
}

// Update database
$now = date('Y-m-d H:i:s');
mysqli_query($connection, "
    UPDATE pemesanan
    SET bukti_pembayaran = '$filename', tgl_upload_bukti = '$now'
    WHERE id_pemesanan = '$id_pemesanan'
");

header("Location: struk_pembayaran.php?id=$id_pemesanan&upload_success=1");
exit;