<div class="navbar-bg" style="background:#f8fafc"></div>

<style>
/* ===== NAVBAR SELARAS HOME ===== */
.main-navbar {
    background: #ffffff !important;
    box-shadow: 0 4px 18px rgba(0,0,0,0.06);
}

.main-navbar .nav-link {
    color: #1f2937 !important;
    font-weight: 500;
}

.main-navbar .nav-link:hover {
    color: #16a34a !important;
}

/* USER DROPDOWN */
.navbar .nav-link-user {
    padding: 6px 12px;
    border-radius: 999px;
    transition: background .2s ease;
}

.navbar .nav-link-user:hover {
    background: #f1f5f9;
}

/* AVATAR */
.navbar .rounded-circle {
    border: 2px solid #22c55e;
}

/* DROPDOWN */
.dropdown-menu {
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    border: none;
}

.dropdown-item {
    font-size: 14px;
    padding: 10px 16px;
}

.dropdown-item:hover {
    background: #f8fafc;
}

.dropdown-item.text-danger {
    color: #dc2626 !important;
}

.dropdown-item.text-danger:hover {
    background: #fee2e2;
}
</style>

<nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li>
        <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>
  </form>

  <ul class="navbar-nav navbar-right">
    <li class="dropdown">
      <a href="#" data-toggle="dropdown"
         class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image"
             src="../assets/img/avatar/avatar-1.png"
             class="rounded-circle mr-2"
             width="36">
        <span class="d-none d-lg-inline-block">
          Halo, <strong><?= $_SESSION['username'] ?></strong>
        </span>
      </a>

      <div class="dropdown-menu dropdown-menu-right">
        <a href="../logout.php"
           class="dropdown-item has-icon text-danger"
           onclick="return confirm('Yakin ingin logout?')">
          <i class="fas fa-sign-out-alt"></i> Keluar
        </a>
      </div>
    </li>
  </ul>
</nav>
