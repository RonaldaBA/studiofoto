<?php
require_once '../helper/auth.php';

isLogin();
?>

<!DOCTYPE html>
<html lang="en">

<style>
/* ===============================
   GLOBAL UI – SELARAS HOME
================================ */
body {
    background-color: #f8fafc;
    color: #1f2937;
    font-family: 'Segoe UI', system-ui, sans-serif;
}

/* ===============================
   SIDENAV MODERN
================================ */
.main-sidebar {
    background: #ffffff !important;
    box-shadow: 4px 0 20px rgba(0,0,0,0.04);
}

.sidebar-brand {
    padding: 22px 0;
}

.sidebar-brand img {
    max-height: 45px;
}

.sidebar-menu .menu-header {
    color: #9ca3af;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .6px;
    margin: 18px 12px 6px;
}

/* ITEM */
.sidebar-menu li a {
    padding: 12px 16px;
    border-radius: 14px;
    margin: 4px 10px;
    color: #1f2937;
    font-weight: 500;
    transition: all .25s ease;
}

/* ICON WRAPPER */
.sidebar-menu li a i {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-size: 14px;
    color: #fff;
}

/* DEFAULT ICON COLOR */
.icon-green {
    background: linear-gradient(135deg, #22c55e, #16a34a);
}
.icon-blue {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}
.icon-orange {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}
.icon-red {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}
.icon-gray {
    background: linear-gradient(135deg, #94a3b8, #64748b);
}

/* HOVER */
.sidebar-menu li a:hover {
    background: #f0fdf4;
    color: #16a34a;
}

/* ACTIVE */
.sidebar-menu li.active > a {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: #ffffff !important;
}

.sidebar-menu li.active > a i {
    background: rgba(255,255,255,0.25);
}

/* DROPDOWN */
.sidebar-menu li ul.dropdown-menu {
    background: transparent;
    padding-left: 10px;
}

.sidebar-menu li ul.dropdown-menu li a {
    font-size: 14px;
}
</style>


<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Dashboard &mdash;</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../assets/modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="../assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="../assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="../assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="../assets/modules/datatables/datatables.min.css">
  <link rel="stylesheet" href="../assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/modules/izitoast/css/iziToast.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/components.css">
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php
      require_once '_header.php';
      require_once '_sidenav.php';
      ?>
      <!-- Main Content -->
      <div class="main-content">