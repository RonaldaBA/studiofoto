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

    <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">

</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

            <div class="login-brand">
              <img src="assets/img/richart_logo.jpg" alt="RichArt Studio" style="height:150px;">
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Buat Akun</h4>
              </div>
              <div class="card-body">

                <?php if (isset($error)): ?>
                  <div class="alert alert-danger">
                    <?= $error; ?>
                  </div>
                <?php endif; ?>

                <?php if (isset($success)): ?>
                  <div class="alert alert-success">
                    Pendaftaran berhasil!
                    <a href="login.php" class="font-weight-bold">Login sekarang</a>
                  </div>
                <?php else: ?>

                <form method="POST" class="needs-validation" novalidate>

                  <div class="form-group">
                    <label>Nama Pengguna</label>
                    <input type="text" name="nama" class="form-control" required autofocus>
                    <div class="invalid-feedback">
                      Mohon isi nama pengguna
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                    <div class="invalid-feedback">
                      Mohon isi email
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Nomor HP</label>
                    <input type="text" name="nohp" class="form-control" required>
                    <div class="invalid-feedback">
                      Mohon isi nomor HP
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Kata Sandi</label>
                    <input type="password" name="password" class="form-control" required>
                    <div class="invalid-feedback">
                      Mohon isi kata sandi
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Konfirmasi Kata Sandi</label>
                    <input type="password" name="confirm" class="form-control" required>
                    <div class="invalid-feedback">
                      Mohon konfirmasi kata sandi
                    </div>
                  </div>

                  <div class="form-group">
                    <button name="submit" type="submit" class="btn btn-primary btn-lg btn-block">
                      Daftar
                    </button>
                  </div>

                  <div class="text-center mt-4">
                    Sudah punya akun?
                    <a href="login.php" class="font-weight-bold">Masuk</a>
                  </div>

                </form>
                <?php endif; ?>

              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>
    <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
