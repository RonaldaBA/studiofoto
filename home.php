<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>RichArt Studio | Self Photo Studio</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }
    .hero {
      padding: 100px 20px;
      background: linear-gradient(to bottom, #ffffff, #f3f4f6);
      text-align: center;
    }
    .hero h1 {
      font-size: 38px;
      font-weight: bold;
    }
    .hero p {
      font-size: 16px;
      color: #666;
    }
    .gallery img {
      width: 100%;
      border-radius: 12px;
      object-fit: cover;
    }
    footer {
      background: #f1f5f9;
      padding: 20px;
      text-align: center;
      margin-top: 50px;
    }
  </style>
</head>

<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <a class="navbar-brand font-weight-bold" href="home.php">RichArt Studio</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="home.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pricelist.php">Pricelist</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>

      <?php if(isset($_SESSION['login'])): ?>
        <li class="nav-item">
          <a class="nav-link btn btn-success text-white ml-3" href="dashboard/index.php">
            Dashboard
          </a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link btn btn-success text-white ml-3" href="login.php">
            Sign In
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

<!-- ===== HERO ===== -->
<section class="hero">
  <h1>Capture Your Best Moment</h1>
  <p>Self Photo Studio modern dengan pencahayaan profesional</p>
</section>

<!-- ===== STUDIO INFO ===== -->
<section class="container text-center mt-5">
  <h2>Tentang RichArt Studio</h2>
  <p class="mt-3 text-muted">
    RichArt Studio adalah self photo studio dengan konsep minimalis dan nyaman.
    Cocok untuk foto personal, pasangan, sahabat, maupun keluarga.
  </p>
</section>

<!-- ===== GALLERY ===== -->
<section class="container mt-5 gallery">
  <h2 class="text-center mb-4">Gallery Studio</h2>
  <div class="row">
    <div class="col-md-4 mb-4">
      <img src="assets/images/gallery1.jpg" alt="Gallery 1">
    </div>
    <div class="col-md-4 mb-4">
      <img src="assets/images/gallery2.jpg" alt="Gallery 2">
    </div>
    <div class="col-md-4 mb-4">
      <img src="assets/images/gallery3.jpg" alt="Gallery 3">
    </div>
  </div>
</section>

<!-- ===== CTA ===== -->
<section class="text-center mt-5">
  <h4>Siap mengabadikan momen terbaikmu?</h4>
  <a href="login.php" class="btn btn-primary mt-3">Booking Sekarang</a>
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
