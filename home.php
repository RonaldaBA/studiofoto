<?php
session_start();

$bookingLink = isset($_SESSION['login'])
    ? 'dashboard_customer/dashboard_customer.php'
    : 'guest/booking.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>RichArt Studio | Photo Studio</title>
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

/* HERO */
.hero {
    min-height: 75vh; /* lebih ringkas */
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f8fafc, #e5e7eb);
    text-align: center;
    padding: 40px 20px;
}

.hero h1 {
    font-size: 40px;
    font-weight: 700;
}

.hero p {
    font-size: 16px;
    color: #6b7280;
    margin-top: 10px;
}

/* SECTION */
section {
    padding: 60px 0; /* diperkecil */
}

h2 {
    font-weight: 700;
    margin-bottom: 12px;
}

/* GALLERY */
.gallery-card {
    border-radius: 16px;
    background: #fff;
    padding: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    transition: transform .25s ease, box-shadow .25s ease;
}

.gallery-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 35px rgba(0,0,0,0.12);
}

.gallery-card img {
    width: 100%;
    height: auto;
    display: block;
}

/* CTA */
.cta {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: #fff;
    border-radius: 20px;
    padding: 45px 25px; /* lebih hemat */
    box-shadow: 0 15px 30px rgba(34,197,94,0.35);
}

.cta h4 {
    font-size: 24px;
    font-weight: 700;
}

.cta p {
    color: #ecfdf5;
    font-size: 15px;
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
                <a class="nav-link active font-weight-bold" href="home.php">Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pricelist.php">Daftar Harga</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Kontak</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tracking.php">
                    Lacak Pesanan
                </a>
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

<!-- HERO -->
<section class="hero">
    <div>
        <h1>Framing Your Moment Perfectly</h1>
        <p>Photo studio modern dengan konsep minimalis & pencahayaan profesional</p>
        <a href="<?= $bookingLink ?>" class="btn btn-success mt-3 px-4 py-2 rounded-pill">
            Booking Sekarang
        </a>
    </div>
</section>

<!-- INFO -->
<section class="container text-center">
    <h2>Tentang RichArt Studio</h2>
    <p class="text-muted">
        RichArt Studio adalah photo studio modern dengan suasana nyaman dan konsep minimalis.
        Cocok untuk foto personal, pasangan, sahabat, maupun keluarga.
    </p>
</section>

<!-- GALLERY -->
<section class="container">
    <h2 class="text-center mb-4">Gallery Studio</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="gallery-card">
                <img src="assets/img/gallery1.jpg" alt="Gallery 1">
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="gallery-card">
                <img src="assets/img/gallery2.jpg" alt="Gallery 2">
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="gallery-card">
                <img src="assets/img/gallery3.jpg" alt="Gallery 3">
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="container text-center">
    <div class="cta">
        <h4>Siap mengabadikan momen terbaikmu?</h4>
        <p class="mt-2">Booking sekarang dan rasakan pengalaman photo studio modern</p>
        <a href="<?= $bookingLink ?>" class="btn btn-success mt-3 px-4 rounded-pill">
            Mulai Booking
        </a>
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
