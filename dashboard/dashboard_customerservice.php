<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'customer service') {
    header("Location: login.php");
    exit;
}

$total_customer = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(*) FROM customer"))[0];
$total_pg       = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(*) FROM photographer"))[0];
$total_package  = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(*) FROM paket"))[0];
$total_order    = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(*) FROM pemesanan"))[0];
?>

<style>
/* ===== GLOBAL (SELARAS HOME.PHP) ===== */
.section {
    background-color: #f8fafc;
}

.section-header h1 {
    font-weight: 700;
    color: #1f2937;
}

.section-header-breadcrumb {
    color: #6b7280;
    font-size: 14px;
}

/* ===== DASHBOARD CARD ===== */
.dashboard-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 26px 24px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    transition: transform .25s ease, box-shadow .25s ease;
    height: 100%;
}

.dashboard-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 35px rgba(0,0,0,0.12);
}

/* ===== ICON STYLE ===== */
.dashboard-icon {
    width: 54px;
    height: 54px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #ffffff;
    margin-bottom: 14px;
}

/* WARNA SESUAI HOME */
.icon-green {
    background: linear-gradient(135deg, #22c55e, #16a34a);
}

.icon-blue {
    background: linear-gradient(135deg, #f8fafc, #e5e7eb);
    color: #1f2937;
    border: 1px solid #e5e7eb;
}

.icon-orange {
    background: linear-gradient(135deg, #f8fafc, #e5e7eb);
    color: #1f2937;
    border: 1px solid #e5e7eb;
}

.icon-red {
    background: linear-gradient(135deg, #f8fafc, #e5e7eb);
    color: #1f2937;
    border: 1px solid #e5e7eb;
}

/* ===== TEXT ===== */
.dashboard-title {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 4px;
}

.dashboard-value {
    font-size: 30px;
    font-weight: 800;
    color: #1f2937;
}
</style>

<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
    <div class="section-header-breadcrumb">
      Customer Service
    </div>
  </div>

  <div class="row">

    <!-- CUSTOMER -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
      <div class="dashboard-card">
        <div class="dashboard-icon icon-blue">
          <i class="fas fa-user-friends"></i>
        </div>
        <div class="dashboard-title">Total Customer</div>
        <div class="dashboard-value"><?= $total_customer ?></div>
      </div>
    </div>

    <!-- PAKET -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
      <div class="dashboard-card">
        <div class="dashboard-icon icon-green">
          <i class="fas fa-box-open"></i>
        </div>
        <div class="dashboard-title">Total Paket</div>
        <div class="dashboard-value"><?= $total_package ?></div>
      </div>
    </div>

    <!-- PESANAN -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
      <div class="dashboard-card">
        <div class="dashboard-icon icon-orange">
          <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="dashboard-title">Total Pesanan</div>
        <div class="dashboard-value"><?= $total_order ?></div>
      </div>
    </div>

    <!-- FOTOGRAFER -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
      <div class="dashboard-card">
        <div class="dashboard-icon icon-red">
          <i class="fas fa-camera-retro"></i>
        </div>
        <div class="dashboard-title">Total Fotografer</div>
        <div class="dashboard-value"><?= $total_pg ?></div>
      </div>
    </div>

  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>
