<?php
require_once 'helper/connection.php';
session_start();

if (isset($_SESSION['login'])) {
    header('Location: dashboard_customer/dashboard_customer.php');
    exit;
}

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($connection, $_POST['nama']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);    
    $nohp = mysqli_real_escape_string($connection, $_POST['nohp']);
    $confirm  = mysqli_real_escape_string($connection, $_POST['confirm']);

    if ($password !== $confirm) {
        $error = "Konfirmasi kata sandi tidak sesuai!";
    } else {
        $cek = mysqli_query($connection, "SELECT id_customer FROM customer WHERE nama='$nama'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Username sudah digunakan!";
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

  <!-- Bootstrap -->
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

    .auth-card {
      background: #ffffff;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 420px;
    }

    .auth-card h3 {
      font-weight: 700;
      text-align: center;
      margin-bottom: 10px;
    }

    .auth-card p {
      text-align: center;
      color: #6b7280;
      margin-bottom: 30px;
    }

    .btn-success {
      border-radius: 50px;
      padding: 10px;
    }
  </style>
</head>

<body>

<div class="auth-card">
  <h3>Buat Akun</h3>
  <p>Daftar untuk melakukan booking studio</p>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error; ?></div>
  <?php endif; ?>

  <?php if (isset($success)): ?>
    <div class="alert alert-success">
      Pendaftaran berhasil!  
      <a href="login.php" class="font-weight-bold">Login sekarang</a>
    </div>
  <?php else: ?>

  <form method="POST">
    <div class="form-group">
      <label>Username</label>
      <input type="text" name="nama" class="form-control" required autofocus>
    </div>

    <div class="form-group">
      <label>Email</label>
      <input type="text" name="email" class="form-control" required autofocus>
    </div>

    <div class="form-group">
      <label>Nomor HP</label>
      <input type="text" name="nohp" class="form-control" required autofocus>
    </div>

    <div class="form-group">
      <label>Kata Sandi</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Konfirmasi Kata Sandi</label>
      <input type="password" name="confirm" class="form-control" required>
    </div>

    <button name="submit" class="btn btn-success btn-block">
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
