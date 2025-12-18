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

<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">Customer Service</div>
    </div>
  </div>

  <div class="row">

    <!-- CUSTOMER -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1 shadow-sm">
        <div class="card-icon bg-primary">
          <i class="fas fa-user-friends"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Customer</h4>
          </div>
          <div class="card-body">
            <?= $total_customer ?>
          </div>
        </div>
      </div>
    </div>

    <!-- PAKET -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1 shadow-sm">
        <div class="card-icon bg-success">
          <i class="fas fa-box-open"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Paket</h4>
          </div>
          <div class="card-body">
            <?= $total_package ?>
          </div>
        </div>
      </div>
    </div>

    <!-- PESANAN -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1 shadow-sm">
        <div class="card-icon bg-warning">
          <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Pesanan</h4>
          </div>
          <div class="card-body">
            <?= $total_order ?>
          </div>
        </div>
      </div>
    </div>

    <!-- FOTOGRAFER -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1 shadow-sm">
        <div class="card-icon bg-danger">
          <i class="fas fa-camera-retro"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Fotografer</h4>
          </div>
          <div class="card-body">
            <?= $total_pg ?>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>
