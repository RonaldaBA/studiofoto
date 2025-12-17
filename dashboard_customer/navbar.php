<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<style>
/* ===== NAVBAR STYLE (NO GLOBAL CSS) ===== */
.navbar {
    padding: 0 !important;
}

.navbar-container {
    width: 100%;
    padding: 18px 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* BRAND LEFT - POJOK KIRI */
.navbar-brand {
    font-weight: 700;
    font-size: 20px;
    color: #111827 !important;
}

/* RIGHT MENU - POJOK KANAN */
.nav-right {
    display: flex;
    align-items: center;
    gap: 20px;
}

/* PERBAIKAN: Set min-width dan text-align center agar tidak bergerak */
.nav-right .nav-link {
    color: #6b7280;
    font-weight: 500;
    font-size: 15px;
    padding: 6px 12px;
    transition: color 0.2s ease;
    white-space: nowrap;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    /* PENTING: Set min-width sesuai text terpanjang */
    min-width: fit-content;
}

/* Hover - HANYA ubah warna */
.nav-right .nav-link:hover {
    color: #111827;
}

/* Active - HANYA ubah warna */
.nav-right .nav-link.active {
    color: #111827;
}

/* MY ACCOUNT BUTTON */
.btn-account {
    background: #22c55e;
    color: #fff !important;
    padding: 8px 20px;
    border-radius: 999px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.2s ease;
    display: inline-block;
}

.btn-account:hover {
    background: #16a34a;
    color: #fff !important;
    text-decoration: none;
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .navbar-container {
        padding: 18px 20px;
    }
    
    .nav-right {
        gap: 15px;
    }
}

@media (max-width: 768px) {
    .navbar-container {
        flex-wrap: wrap;
    }
    
    .nav-right {
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 10px;
        width: 100%;
        justify-content: flex-end;
    }
}
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="navbar-container">

    <!-- LEFT: BRAND - POJOK KIRI -->
    <a class="navbar-brand" href="../home.php">
      <img src="../assets/img/richart_logo.jpg" 
           alt="RichArt Studio"
           style="height:40px;">
    </a>

    <!-- RIGHT: MENU - POJOK KANAN -->
    <div class="nav-right">

      <a class="nav-link <?= $currentPage == 'dashboard_customer.php' ? 'active' : '' ?>"
         href="dashboard_customer.php">
        Beranda
      </a>

      <a class="nav-link <?= $currentPage == 'riwayat_transaksi.php' ? 'active' : '' ?>"
         href="riwayat_transaksi.php">
        Riwayat Transaksi
      </a>

      <a class="nav-link <?= $currentPage == 'galeri.php' ? 'active' : '' ?>"
         href="galeri.php">
        Galeri
      </a>

      <a class="nav-link <?= $currentPage == 'pesan_sekarang.php' ? 'active' : '' ?>"
         href="pesan_sekarang.php">
        Pesan Sekarang
      </a>

      <a href="profil.php" class="btn-account">
        Profil Saya
      </a>

    </div>
  </div>
</nav>