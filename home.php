<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>RichArt Studio | Photo Studio</title>
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
      letter-spacing: 0.5px;
    }

    /* HERO */
    .hero {
      min-height: 90vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #f8fafc, #e5e7eb);
      text-align: center;
    }

    .hero h1 {
      font-size: 44px;
      font-weight: 700;
    }

    .hero p {
      font-size: 18px;
      color: #6b7280;
      margin-top: 12px;
    }

    /* SECTION */
    section {
      padding: 80px 0;
    }

    h2 {
      font-weight: 700;
    }

    /* GALLERY */
    .gallery-card {
      border-radius: 16px;
      overflow: hidden;
      background: #fff;
      box-shadow: 0 10px 25px rgba(0,0,0,0.06);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .gallery-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }

    .gallery-card img {
      width: 100%;
      height: auto;
      object-fit: contain;
      display: block;
    }


    /* CTA */
    .cta {
      background: linear-gradient(135deg, #22c55e, #16a34a);
      color: #fff;
      border-radius: 20px;
      padding: 60px 30px;
      box-shadow: 0 15px 30px rgba(34,197,94,0.35);
    }

    .cta h4 {
      font-size: 26px;
      font-weight: 700;
    }

    .cta p {
      color: #ecfdf5;
    }

    .cta a {
      padding: 12px 30px;
      font-size: 16px;
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
    <img src="assets/img/richart_logo.jpg" alt="RichArt Studio" href="home.php" style="height:40px; margin-right:10px;">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link active font-weight-bold" href="home.php">Beranda</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pricelist.php">Daftar Harga</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Kontak</a>
      </li>

    <?php if (isset($_SESSION['login'])): ?>
      <li class="nav-item ml-lg-3">
          <a class="btn btn-success rounded-pill px-4" href="signup.php">
            Dashboard
          </a>
      </li>

      <?php else: ?>
        <li class="nav-item ml-lg-3">
          <a class="btn btn-success rounded-pill px-4" href="signup.php">
            Daftar
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

<!-- ===== HERO ===== -->
<section class="hero">
  <div>
    <h1>Framing Your Moment Perfectly</h1>
    <p>Photo studio modern dengan konsep minimalis & pencahayaan profesional</p>
    <a href="login.php" class="btn btn-success mt-4 px-5 py-2 rounded-pill">
      Booking Sekarang
    </a>
  </div>
</section>

<!-- ===== STUDIO INFO ===== -->
<section class="container text-center">
  <h2>Tentang RichArt Studio</h2>
  <p class="mt-3 text-muted">
    RichArt Studio adalah photo studio modern dengan suasana nyaman dan konsep minimalis.
    Cocok untuk foto personal, pasangan, sahabat, maupun keluarga.
  </p>
</section>

<!-- ===== GALLERY ===== -->
<section class="container gallery">
  <h2 class="text-center mb-5">Gallery Studio</h2>
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

<!-- ===== CTA ===== -->
<section class="container text-center">
  <div class="cta">
    <h4>Siap mengabadikan momen terbaikmu?</h4>
    <p class="mt-2">Booking sekarang dan rasakan pengalaman photo studio modern</p>
    <a href="login.php" class="btn btn-light mt-3">Mulai Booking</a>
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
