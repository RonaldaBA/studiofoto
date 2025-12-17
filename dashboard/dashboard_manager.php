<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'manajer') {
    header("Location: login.php");
    exit;
}

$customer = mysqli_query($connection, "SELECT COUNT(*) FROM customer");
$cs = mysqli_query($connection, "SELECT COUNT(*) FROM customer_service");
$user = mysqli_query($connection, "SELECT COUNT(*) FROM user");
$pg = mysqli_query($connection, "SELECT COUNT(*) FROM photographer");
$package = mysqli_query($connection, "SELECT COUNT(*) FROM paket");
$order = mysqli_query($connection, "SELECT COUNT(*) FROM pemesanan");

$total_customer = mysqli_fetch_array($customer)[0];
$total_cs = mysqli_fetch_array($cs)[0];
$total_user = mysqli_fetch_array($user)[0];
$total_pg = mysqli_fetch_array($pg)[0];
$total_package = mysqli_fetch_array($package)[0];
$total_order = mysqli_fetch_array($order)[0];
?>

<section class="section">
  <div class="section-header">
    <h1>Beranda</h1>
  </div>
  <div class="column">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-user"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Jumlah Customer</h4>
            </div>
            <div class="card-body">
              <?= $total_customer ?>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Jumlah Customer Service</h4>
            </div>
            <div class="card-body">
              <?= $total_cs ?>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Jumlah Fotografer</h4>
            </div>
            <div class="card-body">
              <?= $total_pg ?>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-info">
            <i class="fas fa-user-shield"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Jumlah Pengguna</h4>
            </div>
            <div class="card-body">
              <?= $total_user ?>
            </div>
          </div>
        </div>
      </div>

    </div>
    
    <div class=row>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-book"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Jumlah Paket</h4>
            </div>
            <div class="card-body">
              <?= $total_package ?>
            </div>
          </div>
        </div>
      </div>
 
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-secondary">
            <i class="fas fa-book"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Jumlah Pesanan</h4>
            </div>
            <div class="card-body">
              <?= $total_order ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    </div>
    </div>
  </div>

</section>

<?php
require_once '../layout/_bottom.php';
?>