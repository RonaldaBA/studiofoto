<?php
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>

<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.php">
        <!-- <img src="../assets/img/logo.png" alt="logo" width="150"> -->
        <h3>RichArt Studio</h3>
      </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.php">Art</a>
    </div>
    <ul class="sidebar-menu">
      <!-- coba -->

<?php if ($role == 'manajer') : ?>
      <li class="menu-header">Dashboard</li>
      <li><a class="nav-link" href="../dashboard/dashboard_manager.php"><i class="fas fa-home"></i> <span>Beranda</span></a></li>
      <li class="menu-header">Fitur</li>
      
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-user"></i> <span>Customer</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../customer/index.php">Daftar Customer</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-users"></i> <span>Customer Service</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../cs/index.php">Daftar Customer Service</a></li>
          <li><a class="nav-link" href="../cs/create.php">Tambah Data</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-users"></i> <span>Fotografer</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../photographer/index.php">Daftar Fotografer</a></li>
          <li><a class="nav-link" href="../photographer/create.php">Tambah Data</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-user-shield"></i> <span>Pengguna</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../user/index.php">Daftar Pengguna</a></li>
          <li><a class="nav-link" href="../user/create.php">Tambah Data</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-book"></i> <span>Paket</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../package/index.php">Daftar Paket</a></li>
          <li><a class="nav-link" href="../package/create.php">Tambah Data</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-book"></i> <span>Pesanan</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../order/index.php">Daftar Pesanan</a></li>
          <!-- <li><a class="nav-link" href="../order/create.php">Tambah Data</a></li> -->
        </ul>
      </li>

<?php elseif ($role == 'customer service') : ?>
      <li class="menu-header">Dashboard</li>
      <li><a class="nav-link" href="../dashboard/dashboard_customerservice.php"><i class="fas fa-home"></i> <span>Beranda</span></a></li>
      <li class="menu-header">Fitur</li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-book"></i> <span>Pesanan</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../order/index.php">Daftar Pesanan</a></li>
          <li><a class="nav-link" href="../order/create.php">Tambah Data</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-book"></i> <span>Paket</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../package/index.php">Daftar Paket</a></li>
          <li><a class="nav-link" href="../package/create.php">Tambah Data</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-user"></i> <span>Customer</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../customer/index.php">Daftar Customer</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-users"></i> <span>Fotografer</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../photographer/index.php">Daftar Fotografer</a></li>
        </ul>
      </li>

<?php elseif ($role == 'fotografer') : ?>
      <li class="menu-header">Dashboard</li>
      <li><a class="nav-link" href="../dashboard/dashboard_photographer.php"><i class="fas fa-home"></i> <span>Beranda</span></a></li>
      <li class="menu-header">Fitur</li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-book"></i> <span>Pesanan</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../order/index.php">Daftar Pesanan</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-book"></i> <span>Paket</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../package/index.php">Daftar Paket</a></li>
          <li><a class="nav-link" href="../package/create.php">Tambah Data</a></li>
        </ul>
      </li>

<?php else: ?> <!--  Untuk Dashboard Customer -->
      <li class="menu-header">Dashboard</li>
      <li><a class="nav-link" href="../dashboard/dashboard_customer.php"><i class="fas fa-home"></i> <span>Beranda</span></a></li>
      <li class="menu-header">Fitur</li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
          <i class="fas fa-book"></i> <span>Pesanan</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="../order/index.php">Daftar Pesanan</a></li>
        </ul>
      </li>

<?php endif; ?>     
    </ul>
  </aside>
</div>