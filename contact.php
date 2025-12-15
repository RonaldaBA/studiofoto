<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Contact | RichArt Studio</title>
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

    /* CONTACT CARD */
    .contact-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 35px 30px;
      box-shadow: 0 15px 30px rgba(0,0,0,0.06);
      height: 100%;
    }

    .contact-item {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      font-size: 15px;
    }

    .contact-item span {
      font-size: 22px;
      margin-right: 15px;
    }

    /* MAP */
    .map-wrapper iframe {
      width: 100%;
      height: 100%;
      border: none;
      border-radius: 20px;
      min-height: 350px;
    }

    /* CTA */
    .cta-btn a {
      margin-right: 10px;
      border-radius: 50px;
      padding: 10px 24px;
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
      <li class="nav-item"><a class="nav-link" href="pricelist.php">Pricelist</a></li>
      <li class="nav-item">
        <a class="nav-link active font-weight-bold" href="contact.php">Contact</a>
      </li>

      <?php if(isset($_SESSION['login'])): ?>
        <li class="nav-item ml-lg-3">
          <a class="btn btn-success rounded-pill px-4" href="signup.php">Sign Up</a>
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
  <h1>Contact Us</h1>
  <p>Hubungi kami untuk informasi & pemesanan studio</p>
</div>

<!-- ===== CONTACT CONTENT ===== -->
<section class="container">
  <div class="row">

    <!-- INFO -->
    <div class="col-md-5 mb-4">
      <div class="contact-card">
        <h4 class="mb-4 font-weight-bold">RichArt Studio</h4>

        <div class="contact-item">
          <span>📍</span>
          <div>Jl. Contoh Alamat No. 123, Kota Anda</div>
        </div>

        <div class="contact-item">
          <span>🕒</span>
          <div>Setiap hari, 09.00 – 21.00 WIB</div>
        </div>

        <div class="contact-item">
          <span>📞</span>
          <div>+62 812-3456-7890</div>
        </div>

        <div class="contact-item">
          <span>📧</span>
          <div>richartstudio@email.com</div>
        </div>

        <div class="cta-btn mt-4">
          <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-success">
            Chat WhatsApp
          </a>
          <a href="login.php" class="btn btn-outline-success">
            Booking
          </a>
        </div>
      </div>
    </div>

    <!-- MAP -->
    <div class="col-md-7 mb-4">
      <div class="map-wrapper">
        <!-- GANTI embed MAP sesuai lokasi studio -->
        <iframe 
          src="https://www.google.com/maps?q=Jakarta&output=embed"
          loading="lazy">
        </iframe>
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
