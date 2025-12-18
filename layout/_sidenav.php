<?php
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>

<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">

    <div class="sidebar-brand">
      <img src="../assets/img/richart_logo.jpg" alt="RichArt Studio">
    </div>

    <div class="sidebar-brand sidebar-brand-sm">
      <a href="#">R-Art</a>
    </div>

    <ul class="sidebar-menu">

<?php if ($role == 'manajer') : ?>

      <li class="menu-header">Dashboard</li>
      <li class="active">
        <a class="nav-link" href="../dashboard/dashboard_manager.php">
          <i class="fas fa-home icon-green"></i>
          <span>Beranda</span>
        </a>
      </li>

      <li class="menu-header">Fitur</li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-user icon-blue"></i>
          <span>Customer</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../customer/index.php">Daftar Customer</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-headset icon-green"></i>
          <span>Customer Service</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../cs/index.php">Daftar CS</a></li>
          <li><a class="nav-link" href="../cs/create.php">Tambah Data</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-camera-retro icon-red"></i>
          <span>Fotografer</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../photographer/index.php">Daftar Fotografer</a></li>
          <li><a class="nav-link" href="../photographer/create.php">Tambah Data</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-box-open icon-orange"></i>
          <span>Paket</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../package/index.php">Daftar Paket</a></li>
          <li><a class="nav-link" href="../package/create.php">Tambah Data</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-clipboard-list icon-gray"></i>
          <span>Pesanan</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../order/index.php">Daftar Pesanan</a></li>
        </ul>
      </li>

<?php elseif ($role == 'customer service') : ?>

      <li class="menu-header">Dashboard</li>
      <li class="active">
        <a class="nav-link" href="../dashboard/dashboard_customerservice.php">
          <i class="fas fa-home icon-green"></i>
          <span>Beranda</span>
        </a>
      </li>

      <li class="menu-header">Fitur</li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-clipboard-list icon-orange"></i>
          <span>Pesanan</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../order/index.php">Daftar Pesanan</a></li>
          <li><a class="nav-link" href="../order/create.php">Tambah Data</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-box-open icon-green"></i>
          <span>Paket</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../package/index.php">Daftar Paket</a></li>
        </ul>
      </li>

<?php elseif ($role == 'fotografer') : ?>

      <li class="menu-header">Dashboard</li>
      <li class="active">
        <a class="nav-link" href="../dashboard/dashboard_photographer.php">
          <i class="fas fa-home icon-green"></i>
          <span>Beranda</span>
        </a>
      </li>

      <li class="menu-header">Fitur</li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-clipboard-list icon-orange"></i>
          <span>Pesanan</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../order/index.php">Daftar Pesanan</a></li>
        </ul>
      </li>

<?php else: ?>

      <li class="menu-header">Dashboard</li>
      <li class="active">
        <a class="nav-link" href="../dashboard/dashboard_customer.php">
          <i class="fas fa-home icon-green"></i>
          <span>Beranda</span>
        </a>
      </li>

<?php endif; ?>

    </ul>
  </aside>
</div>
