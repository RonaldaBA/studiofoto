<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Harga | RichArt Studio</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<style>
body {
    font-family: 'Segoe UI', system-ui, sans-serif;
    background-color: #f8fafc;
    color: #1f2937;
}

/* NAVBAR */
.navbar {
    padding: 14px 32px;
}

.navbar-brand {
    font-weight: 700;
}

/* HEADER */
.page-header {
    text-align: center;
    padding: 70px 20px 40px; /* dipadatkan */
    background: linear-gradient(135deg, #f8fafc, #e5e7eb);
}

.page-header h1 {
    font-size: 36px;
    font-weight: 700;
}

.page-header p {
    color: #6b7280;
    font-size: 15px;
    margin-top: 8px;
}

/* SECTION */
section {
    padding: 50px 0;
}

/* PRICE CARD */
.price-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 30px 25px;
    box-shadow: 0 12px 25px rgba(0,0,0,0.06);
    transition: transform .25s ease, box-shadow .25s ease;
    height: 100%;
}

.price-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 35px rgba(0,0,0,0.12);
}

.price-title {
    font-size: 20px;
    font-weight: 700;
}

.price {
    font-size: 30px;
    font-weight: 800;
    color: #16a34a;
    margin: 12px 0;
}

.price span {
    font-size: 13px;
    font-weight: 500;
    color: #6b7280;
}

.price-list {
    list-style: none;
    padding-left: 0;
    margin-top: 18px;
}

.price-list li {
    padding: 7px 0;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
}

.price-list li:last-child {
    border-bottom: none;
}

.price-card .btn {
    margin-top: 22px;
    border-radius: 999px;
    padding: 9px;
}

/* FOOTER */
footer {
    background: #0f172a;
    color: #cbd5f5;
    padding: 18px;
    text-align: center;
    font-size: 13px;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <img src="assets/img/richart_logo.jpg" alt="RichArt Studio" style="height:36px;margin-right:10px;">
    <a class="navbar-brand" href="home.php">RichArt Studio</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto align-items-lg-center">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active font-weight-bold" href="pricelist.php">Daftar Harga</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Kontak</a>
            </li>

            <?php if(!isset($_SESSION['login'])): ?>
                <li class="nav-item ml-lg-3">
                    <a class="btn btn-outline-success rounded-pill px-3 mr-2" href="signup.php">Daftar</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-success rounded-pill px-3" href="login.php">Masuk</a>
                </li>
            <?php else: ?>
                <li class="nav-item ml-lg-3">
                    <a class="btn btn-danger rounded-pill px-3"
                       href="logout.php"
                       onclick="return confirm('Yakin ingin logout?')">
                        Logout
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<!-- HEADER -->
<div class="page-header">
    <h1>Daftar Harga</h1>
    <p>Pilih paket photo studio sesuai kebutuhanmu</p>
</div>

<!-- PRICELIST -->
<section class="container">
    <div class="row">

        <div class="col-md-4 mb-4">
            <div class="price-card">
                <div class="price-title">Basic Package</div>
                <div class="price">Rp 50.000 <span>/ sesi</span></div>
                <ul class="price-list">
                    <li>⏱ 15 menit sesi foto</li>
                    <li>📷 Unlimited shoot</li>
                    <li>👥 Maks. 2 orang</li>
                    <li>🖼 3 foto edit</li>
                </ul>
                <a href="login.php" class="btn btn-success btn-block">Booking</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="price-card">
                <div class="price-title">Standard Package</div>
                <div class="price">Rp 75.000 <span>/ sesi</span></div>
                <ul class="price-list">
                    <li>⏱ 20 menit sesi foto</li>
                    <li>📷 Unlimited shoot</li>
                    <li>👥 Maks. 4 orang</li>
                    <li>🖼 5 foto edit</li>
                </ul>
                <a href="login.php" class="btn btn-success btn-block">Booking</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="price-card">
                <div class="price-title">Premium Package</div>
                <div class="price">Rp 100.000 <span>/ sesi</span></div>
                <ul class="price-list">
                    <li>⏱ 30 menit sesi foto</li>
                    <li>📷 Unlimited shoot</li>
                    <li>👥 Maks. 6 orang</li>
                    <li>🖼 8 foto edit</li>
                </ul>
                <a href="login.php" class="btn btn-success btn-block">Booking</a>
            </div>
        </div>

    </div>
</section>

<!-- FOOTER -->
<footer>
    &copy; <?= date('Y'); ?> RichArt Studio. All rights reserved.
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
