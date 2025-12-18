<?php
require_once __DIR__ . '/helper/connection.php';
session_start();

if (isset($_POST['submit'])) {
    $input    = $_POST['username'];
    $password = $_POST['password'];

    // ===== LOGIN STAFF =====
    $sqlUser = "SELECT * FROM user WHERE username='$input' LIMIT 1";
    $resultUser = mysqli_query($connection, $sqlUser);
    $user = mysqli_fetch_assoc($resultUser);

    if ($user && $password === $user['password']) {
        $_SESSION['login']    = true;
        $_SESSION['role']     = strtolower($user['role']);
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id']  = $user['id'];

        if ($_SESSION['role'] === 'manajer') {
            header('Location: dashboard/dashboard_manager.php');
        } elseif ($_SESSION['role'] === 'customer service') {
            header('Location: dashboard/dashboard_customerservice.php');
        } elseif ($_SESSION['role'] === 'fotografer') {
            header('Location: dashboard/dashboard_photographer.php');
        }
        exit;
    }

    // ===== LOGIN CUSTOMER =====
    $sqlCustomer = "SELECT * FROM customer WHERE nama='$input' LIMIT 1";
    $resultCustomer = mysqli_query($connection, $sqlCustomer);
    $customer = mysqli_fetch_assoc($resultCustomer);

    if ($customer && $password === $customer['password']) {
        $_SESSION['login'] = true;
        $_SESSION['id_customer'] = $customer['id_customer'];
        $_SESSION['nama'] = $customer['nama'];

        header('Location: dashboard_customer/dashboard_customer.php');
        exit;
    }

    $error = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Masuk | RichArt Studio</title>
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
.login-card {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    padding: 40px;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 30px 60px rgba(0,0,0,0.12);
}

/* LOGO */
.login-logo {
    text-align: center;
    margin-bottom: 20px;
}

.login-logo img {
    height: 110px;
}

/* TITLE */
.login-card h4 {
    font-weight: 700;
    text-align: center;
}

.login-card p {
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
.btn-login {
    background: #22c55e;
    border: none;
    padding: 12px;
    font-weight: 600;
    border-radius: 999px;
}

.btn-login:hover {
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

/* ERROR */
.alert {
    border-radius: 12px;
}
</style>
</head>

<body>

<div class="login-card">

    <a href="home.php" class="back-link">&larr; Kembali ke Beranda</a>

    <div class="login-logo">
        <img src="assets/img/richart_logo.jpg" alt="RichArt Studio">
    </div>

    <h4>Selamat Datang</h4>
    <p>Masuk untuk melanjutkan ke akun Anda</p>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center">
            Nama pengguna atau kata sandi salah
        </div>
    <?php endif; ?>

    <form method="POST" class="mt-3">
        <div class="form-group">
            <label>Nama Pengguna</label>
            <input type="text" name="username" class="form-control" required autofocus>
        </div>

        <div class="form-group">
            <label>Kata Sandi</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" name="submit" class="btn btn-login btn-block">
            Masuk
        </button>
    </form>

    <div class="text-center mt-4">
        Belum punya akun?
        <a href="signup.php" class="font-weight-bold">Daftar</a>
    </div>
</div>

</body>
</html>
