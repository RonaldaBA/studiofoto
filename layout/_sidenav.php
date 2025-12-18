<?php
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>

<style>
/* ===== SIDEBAR SELARAS HOME ===== */
.main-sidebar {
    background: #ffffff;
    border-right: 1px solid #e5e7eb;
}

.sidebar-brand {
    padding: 18px 0;
    background: #ffffff;
}

.sidebar-brand img {
    max-height: 42px;
}

.sidebar-menu {
    padding-top: 10px;
}

.sidebar-menu .menu-header {
    font-size: 11px;
    font-weight: 700;
    color: #9ca3af;
    margin-top: 18px;
    margin-bottom: 6px;
    letter-spacing: .5px;
}

.sidebar-menu li a {
    color: #374151;
    font-weight: 500;
    padding: 10px 16px;
    border-radius: 10px;
    margin: 4px 10px;
    transition: all .25s ease;
}

.sidebar-menu li a i {
    color: #16a34a;
}

/* Hover */
.sidebar-menu li a:hover {
    background: #ecfdf5;
    color: #16a34a;
}

/* Active */
.sidebar-menu li.active > a,
.sidebar-menu li a.active {
    background: #22c55e;
    color: #ffffff !important;
}

.sidebar-menu li.active > a i,
.sidebar-menu li a.active i {
    color: #ffffff;
}

/* Dropdown */
.sidebar-menu .dropdown-menu {
    background: transparent;
    box-shadow: none;
    padding-left: 12px;
}

.sidebar-menu .dropdown-menu li a {
    padding: 8px 14px;
    font-size: 14px;
    color: #4b5563;
}

.sidebar-menu .dropdown-menu li a:hover {
    background: #ecfdf5;
    color: #16a34a;
}

/* Sidebar kecil */
.sidebar-brand-sm {
    background: #ffffff;
    font-weight: 700;
    color: #16a34a;
}
</style>

<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">

    <div class="sidebar-brand text-center">
      <img src="../assets/img/richart_logo.jpg" alt="RichArt Studio">
    </div>

    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.php">R-Art</a>
    </div>

    <ul class="sidebar-menu">

<?php if ($role == 'manajer') : ?>
      <li class="menu-header">Dashboard</li>
      <li>
        <a class="nav-link" href="../dashboard/dashboard_manager.php">
          <i class="fas fa-home"></i><span>Beranda</span>
        </a>
      </li>

      <li class="menu-header">Fitur</li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-user"></i><span>Customer</span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="../customer/index.php">Daftar Customer</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-users"></i><span>Customer Service</span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="../cs/index.php">Daftar CS</a></li>
          <li><a href="../cs/create.php">Tambah Data</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-camera"></i><span>Fotografer</span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="../photographer/index.php">Daftar Fotografer</a></li>
          <li><a href="../photographer/create.php">Tambah Data</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-box-open"></i><span>Paket</span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="../package/index.php">Daftar Paket</a></li>
          <li><a href="../package/create.php">Tambah Paket</a></li>
        </ul>
      </li>

<?php elseif ($role == 'customer service') : ?>
      <li class="menu-header">Dashboard</li>
      <li>
        <a class="nav-link" href="../dashboard/dashboard_customerservice.php">
          <i class="fas fa-home"></i><span>Beranda</span>
        </a>
      </li>

      <li class="menu-header">Fitur</li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-clipboard-list"></i><span>Pesanan</span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="../order/index.php">Daftar Pesanan</a></li>
          <li><a href="../order/create.php">Tambah Pesanan</a></li>
        </ul>
      </li>

      <li>
        <a class="nav-link" href="../package/index.php">
          <i class="fas fa-box-open"></i><span>Paket</span>
        </a>
      </li>

<?php elseif ($role == 'fotografer') : ?>
      <li class="menu-header">Dashboard</li>
      <li>
        <a class="nav-link" href="../dashboard/dashboard_photographer.php">
          <i class="fas fa-home"></i><span>Beranda</span>
        </a>
      </li>

      <li class="menu-header">Fitur</li>

      <li>
        <a class="nav-link" href="../order/index.php">
          <i class="fas fa-clipboard-list"></i><span>Pesanan</span>
        </a>
      </li>

      <li>
        <a class="nav-link" href="../gallery/index.php">
          <i class="fas fa-image"></i><span>Galeri</span>
        </a>
      </li>

<?php else: ?>
      <li class="menu-header">Dashboard</li>
      <li>
        <a class="nav-link" href="../dashboard/dashboard_customer.php">
          <i class="fas fa-home"></i><span>Beranda</span>
        </a>
      </li>
<?php endif; ?>

    </ul>
  </aside>
</div>
