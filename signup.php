<?php
require_once 'helper/connection.php';
session_start();

if (isset($_SESSION['login'])) {
    header('Location: dashboard_customer/dashboard_customer.php');
    exit;
}

if (isset($_POST['submit'])) {
    $nama     = mysqli_real_escape_string($connection, $_POST['nama']);
    $email    = mysqli_real_escape_string($connection, $_POST['email']);
    $nohp     = mysqli_real_escape_string($connection, $_POST['nohp']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $confirm  = mysqli_real_escape_string($connection, $_POST['confirm']);

    if ($password !== $confirm) {
        $error = "Konfirmasi kata sandi tidak sesuai!";
    } else {
        $cek = mysqli_query($connection, "SELECT id_customer FROM customer WHERE email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            $query = "INSERT INTO customer (nama, email, password, no_hp) 
                      VALUES ('$nama', '$email', '$password', '$nohp')";
            mysqli_query($connection, $query);
            $success = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar | RichArt Studio</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<style>
body {
    font-family: 'Segoe UI', system-ui, sans-serif;
    background: linear-gradient(135deg, #f8fafc, #e5e7eb);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* CARD */
.signup-card {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    padding: 40px;
    width: 100%;
    max-width: 440px;
    box-shadow: 0 30px 60px rgba(0,0,0,0.12);
}

/* LOGO */
.signup-logo {
    text-align: center;
    margin-bottom: 15px;
}

.signup-logo img {
    height: 110px;
}

/* TITLE */
.signup-card h4 {
    font-weight: 700;
    text-align: center;
}

.signup-card p {
    text-align: center;
    color: #6b7280;
    font-size: 14px;
    margin-bottom: 30px;
}

/* INPUT */
.form-control {
    border-radius: 12px;
    padding: 12px 14px;
}

/* BUTTON */
.btn-signup {
    background: #22c55e;
    border: none;
    padding: 12px;
    font-weight: 600;
    border-radius: 999px;
}

.btn-signup:hover {
    background: #16a34a;
}

/* LINK */
.back-link {
    font-size: 14px;
    display: inline-block;
    margin-bottom: 15px;
    color: #6b7280;
    text-decoration: none;
}

.back-link:hover {
    color: #111827;
}

/* ALERT */
.alert {
    border-radius: 12px;
}
</style>
</head>

<body>

<div class="signup-card">

    <a href="home.php" class="back-link">&larr; Kembali ke Beranda</a>

    <div class="signup-logo">
        <img src="assets/img/richart_logo.jpg" alt="RichArt Studio">
    </div>

    <h4>Buat Akun</h4>
    <p>Daftar untuk mulai booking photo studio</p>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="alert alert-success text-center">
            Pendaftaran berhasil!
            <br>
            <a href="login.php" class="font-weight-bold">Masuk sekarang</a>
        </div>
    <?php else: ?>

    <form method="POST" class="mt-3">
        <div class="form-group">
            <label>Nama Pengguna</label>
            <input type="text" name="nama" class="form-control" required autofocus>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" name="nohp" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Kata Sandi</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Konfirmasi Kata Sandi</label>
            <input type="password" name="confirm" class="form-control" required>
        </div>

        <button type="submit" name="submit" class="btn btn-signup btn-block">
            Daftar
        </button>
    </form>

    <div class="text-center mt-4">
        Sudah punya akun?
        <a href="login.php" class="font-weight-bold">Masuk</a>
    </div>

    <?php endif; ?>

</div>

</body>
</html>
