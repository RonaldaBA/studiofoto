<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kontak | RichArt Studio</title>
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
  <img src="assets/img/richart_logo.jpg" alt="RichArt Studio" style="height:40px; margin-right:10px;">
  <a class="navbar-brand" href="home.php">RichArt Studio</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="home.php">Beranda</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pricelist.php">Daftar Harga</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active font-weight-bold" href="contact.php">Kontak</a>
      </li>

      <?php if(!isset($_SESSION['login'])): ?>
        <li class="nav-item ml-lg-3">
          <a class="btn btn-outline-success rounded-pill px-4 mr-2" href="signup.php">
            Daftar
          </a>
        </li>
        <li class="nav-item">
          <a class="btn btn-success rounded-pill px-4" href="login.php">
            Masuk
          </a>
        </li>
        <?php else: ?>
          <li class="nav-item ml-lg-3">
            <a class="btn btn-danger rounded-pill px-4" 
              href="logout.php"
              onclick="return confirm('Yakin ingin logout?')">
              Logout
            </a>
          </li>
        <?php endif; ?>
    </ul>
  </div>
</nav>

<!-- ===== HEADER ===== -->
<div class="page-header">
  <h1>Kontak Kami</h1>
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
          <div>Jl. Panembahan Senopati No.214, Ngaliyan, Kec. Ngaliyan, Kota Semarang, Jawa Tengah 50181</div>
        </div>

        <div class="contact-item">
          <span>🕒</span>
          <div>Setiap hari, 09.00 – 21.00 WIB</div>
        </div>

        <div class="contact-item">
          <span>📞</span>
          <div>+62 851-5982-2523</div>
        </div>

        <div class="contact-item">
          <span>📧</span>
          <div>richartstudio@email.com</div>
        </div>

        <div class="cta-btn mt-4">
          <a href="https://wa.me/6285159822523" target="_blank" class="btn btn-success">
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
      <iframe
        src="https://www.google.com/maps?q=-6.997141281983134, 110.34987055016498&z=15&output=embed"
        width="100%"
        height="300"
        style="border:0;"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
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
