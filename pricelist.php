<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pricelist | RichArt Studio</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <style>
    body {
      font-family: 'Segoe UI', system-ui, sans-serif;
      background-color: #f8fafc;
      color: #1f2937;
    }

    /* NAVBAR */
    .navbar {
      padding: 18px 40px;
    }

    .navbar-brand {
      font-weight: 700;
    }

    section {
      padding: 80px 0;
    }

    /* HEADER */
    .page-header {
      text-align: center;
      padding: 100px 20px 60px;
      background: linear-gradient(135deg, #f8fafc, #e5e7eb);
    }

    .page-header h1 {
      font-size: 40px;
      font-weight: 700;
    }

    .page-header p {
      color: #6b7280;
      font-size: 16px;
      margin-top: 10px;
    }

    /* PRICELIST CARD */
    .price-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 35px 30px;
      box-shadow: 0 15px 30px rgba(0,0,0,0.06);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      height: 100%;
    }

    .price-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 25px 45px rgba(0,0,0,0.12);
    }

    .price-title {
      font-size: 22px;
      font-weight: 700;
    }

    .price {
      font-size: 34px;
      font-weight: 800;
      color: #16a34a;
      margin: 15px 0;
    }

    .price span {
      font-size: 14px;
      font-weight: 500;
      color: #6b7280;
    }

    .price-list {
      list-style: none;
      padding-left: 0;
      margin-top: 25px;
    }

    .price-list li {
      padding: 8px 0;
      border-bottom: 1px solid #e5e7eb;
      font-size: 15px;
    }

    .price-list li:last-child {
      border-bottom: none;
    }

    .price-card a {
      margin-top: 30px;
      padding: 10px;
      border-radius: 50px;
    }

    /* FOOTER */
    footer {
      background: #0f172a;
      color: #cbd5f5;
      padding: 25px;
      text-align: center;
      font-size: 14px;
    }
  </style>
</head>

<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <a class="navbar-brand" href="home.php">RichArt Studio</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
      <li class="nav-item"><a class="nav-link active font-weight-bold" href="pricelist.php">Pricelist</a></li>
      <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>

      <?php if(isset($_SESSION['login'])): ?>
        <li class="nav-item ml-lg-3">
          <a class="btn btn-success rounded-pill px-4" href="dashboard/index.php">Dashboard</a>
        </li>
      <?php else: ?>
        <li class="nav-item ml-lg-3">
          <a class="btn btn-success rounded-pill px-4" href="login.php">Sign In</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

<!-- ===== HEADER ===== -->
<div class="page-header">
  <h1>Pricelist</h1>
  <p>Pilih paket photo studio sesuai kebutuhanmu</p>
</div>

<!-- ===== PRICELIST ===== -->
<section class="container">
  <div class="row">

    <!-- Paket Basic -->
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

    <!-- Paket Standard -->
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

    <!-- Paket Premium -->
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

<!-- ===== FOOTER ===== -->
<footer>
  <p>&copy; <?= date('Y'); ?> RichArt Studio. All rights reserved.</p>
</footer>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
