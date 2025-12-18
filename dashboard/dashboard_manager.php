<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'manajer') {
    header("Location: login.php");
    exit;
}

$total_customer = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(*) FROM customer"))[0];
$total_cs       = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(*) FROM customer_service"))[0];
$total_user     = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(*) FROM user"))[0];
$total_pg       = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(*) FROM photographer"))[0];
$total_package  = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(*) FROM paket"))[0];
$total_order    = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(*) FROM pemesanan"))[0];
?>

<style>
/* ===== DASHBOARD STYLE (SELARAS HOME & CS) ===== */
.section {
    background-color: #f8fafc;
}

.section-header h1 {
    font-weight: 700;
    color: #1f2937;
}

.section-header-breadcrumb {
    font-size: 14px;
    color: #6b7280;
}

/* CARD */
.dashboard-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 26px 24px;
    box-shadow: 0 12px 25px rgba(0,0,0,0.06);
    transition: transform .25s ease, box-shadow .25s ease;
    height: 100%;
}

.dashboard-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 35px rgba(0,0,0,0.12);
}

/* ICON */
.dashboard-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #fff;
    margin-bottom: 14px;
}

.bg-green  { background: linear-gradient(135deg, #22c55e, #16a34a); }
.bg-blue   { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.bg-orange { background: linear-gradient(135deg, #f59e0b, #d97706); }
.bg-red    { background: linear-gradient(135deg, #ef4444, #dc2626); }
.bg-purple { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.bg-gray   { background: linear-gradient(135deg, #64748b, #475569); }

/* TEXT */
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
      Manajer
    </div>
  </div>

  <div class="row">

    <!-- CUSTOMER -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
      <div class="dashboard-card">
        <div class="dashboard-icon bg-blue">
          <i class="fas fa-user"></i>
        </div>
        <div class="dashboard-title">Total Customer</div>
        <div class="dashboard-value"><?= $total_customer ?></div>
      </div>
    </div>

    <!-- CUSTOMER SERVICE -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
      <div class="dashboard-card">
        <div class="dashboard-icon bg-green">
          <i class="fas fa-headset"></i>
        </div>
        <div class="dashboard-title">Customer Service</div>
        <div class="dashboard-value"><?= $total_cs ?></div>
      </div>
    </div>

    <!-- FOTOGRAFER -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
      <div class="dashboard-card">
        <div class="dashboard-icon bg-red">
          <i class="fas fa-camera-retro"></i>
        </div>
        <div class="dashboard-title">Fotografer</div>
        <div class="dashboard-value"><?= $total_pg ?></div>
      </div>
    </div>

    <!-- USER -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
      <div class="dashboard-card">
        <div class="dashboard-icon bg-purple">
          <i class="fas fa-user-shield"></i>
        </div>
        <div class="dashboard-title">Pengguna Sistem</div>
        <div class="dashboard-value"><?= $total_user ?></div>
      </div>
    </div>

    <!-- PAKET -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
      <div class="dashboard-card">
        <div class="dashboard-icon bg-orange">
          <i class="fas fa-box-open"></i>
        </div>
        <div class="dashboard-title">Total Paket</div>
        <div class="dashboard-value"><?= $total_package ?></div>
      </div>
    </div>

    <!-- PESANAN -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
      <div class="dashboard-card">
        <div class="dashboard-icon bg-gray">
          <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="dashboard-title">Total Pesanan</div>
        <div class="dashboard-value"><?= $total_order ?></div>
      </div>
    </div>

  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>
