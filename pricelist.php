<?php
session_start();
require_once 'helper/connection.php';

/* =======================
   SEARCH & FILTER LOGIC
======================= */
$search   = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';
$kategori = isset($_GET['kategori']) ? mysqli_real_escape_string($connection, $_GET['kategori']) : '';

$where = [];

if ($search !== '') {
    $where[] = "(nama_paket LIKE '%$search%' OR deskripsi LIKE '%$search%')";
}

if ($kategori !== '') {
    $where[] = "nama_paket LIKE '%$kategori%'";
}

$whereSQL = '';
if (!empty($where)) {
    $whereSQL = 'WHERE ' . implode(' AND ', $where);
}

$paket = mysqli_query(
    $connection,
    "SELECT * FROM paket $whereSQL ORDER BY nama_paket ASC"
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Harga | RichArt Studio</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<style>
body{
font-family:'Segoe UI',system-ui,sans-serif;
background:#f8fafc;
color:#1f2937;
}

/* NAVBAR */
.navbar{
padding:14px 32px;
}

.navbar-brand{
font-weight:700;
}

/* HEADER */
.page-header{
text-align:center;
padding:60px 20px;
background:linear-gradient(135deg,#f8fafc,#e5e7eb);
margin-bottom:30px;
}

.page-header h1{
font-size:48px;
font-weight:700;
margin-bottom:10px;
}

.page-header p{
color:#6b7280;
font-size:16px;
}

/* FILTER */
.filter-box{
background:#fff;
border-radius:22px;
padding:20px;
box-shadow:0 10px 25px rgba(0,0,0,.05);
margin-top:-10px;
}

.filter-box .form-control{
border-radius:14px;
height:50px;
}

/* CARD */
.price-card{
    background:#fff;
    border:none;
    border-radius:24px;
    padding:24px;
    box-shadow:0 10px 25px rgba(0,0,0,.05);
    transition:.3s;
    height:100%;

    display:flex;
    flex-direction:column;
}

.price-card:hover{
    transform:translateY(-8px);
    box-shadow:0 20px 40px rgba(0,0,0,.10);
}

.price-title{
    font-size:20px;
    font-weight:700;
    color:#0f172a;
    line-height:1.4;
    min-height:60px;
}

.price{
    font-size:36px;
    font-weight:800;
    color:#16a34a;
    margin:12px 0 18px;
}

.price-list{
    list-style:none;
    padding:0;
    margin:0;
    flex-grow:1;
}

.price-list li{
    padding:10px 0;
    border-bottom:1px solid #e5e7eb;
    font-size:14px;
    color:#475569;
    line-height:1.6;
}

.price-list li:last-child{
    border-bottom:none;
}

.price-note{
    margin-top:15px;
    font-size:13px;
    color:#64748b;
    min-height:45px;
}

.btn-book{
    margin-top:20px;
    width:100%;
    border:none;
    border-radius:12px;
    padding:12px;
    font-weight:600;
    background:#16a34a;
}

.btn-book:hover{
    background:#15803d;
}

/* FOOTER */
footer{
margin-top:40px;
background:#0f172a;
color:#cbd5f5;
padding:20px;
text-align:center;
font-size:13px;
}

</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <img src="assets/img/richart_logo.jpg" style="height:36px;margin-right:10px">
    <a class="navbar-brand" href="home.php">RichArt Studio</a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto align-items-lg-center">
            <li class="nav-item"><a class="nav-link" href="home.php">Beranda</a></li>
            <li class="nav-item"><a class="nav-link active font-weight-bold" href="pricelist.php">Daftar Harga</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Kontak</a></li>

            <?php if(!isset($_SESSION['login'])): ?>
                <li class="nav-item ml-lg-3">
                    <a class="btn btn-outline-success rounded-pill px-3 mr-2" href="signup.php">Daftar</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-success rounded-pill px-3" href="login.php">Masuk</a>
                </li>
            <?php else: ?>
                <li class="nav-item ml-lg-3">
                    <a class="btn btn-danger rounded-pill px-3"
                       href="logout.php"
                       onclick="return confirm('Yakin ingin logout?')">
                        Logout
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<!-- HEADER -->
<div class="page-header">
    <h1>Daftar Harga</h1>
    <p>Pilih paket sesuai kebutuhanmu</p>
</div>

<!-- SEARCH & FILTER -->
<section class="container mb-4">
    <div class="filter-box">
        <form method="GET" class="row">
            <div class="col-md-5 mb-2">
                <input type="text" name="search"
                       value="<?= htmlspecialchars($search) ?>"
                       class="form-control rounded-pill"
                       placeholder="Cari paket foto, cetak, studio...">
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <select name="kategori" class="form-control rounded-pill">
                    <option value="">Semua Kategori</option>
                    <option value="Cetak" <?= $kategori=='Cetak'?'selected':'' ?>>Cetak Foto</option>
                    <option value="Studio" <?= $kategori=='Studio'?'selected':'' ?>>Studio</option>
                    <option value="Prewedding" <?= $kategori=='Prewedding'?'selected':'' ?>>Prewedding</option>
                    <option value="Engagement" <?= $kategori=='Engagement'?'selected':'' ?>>Engagement</option>
                    <option value="Pas Foto" <?= $kategori=='Pas Foto'?'selected':'' ?>>Pas Foto</option>
                    <option value="Richbooth" <?= $kategori=='Richbooth'?'selected':'' ?>>Richbooth</option>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <button class="btn btn-success rounded-pill btn-block">Terapkan</button>
            </div>
        </form>
    </div>
</section>

<!-- LIST PAKET -->
<section class="container mb-5">
    <div class="row">

    <?php if(mysqli_num_rows($paket) > 0): ?>

        <?php while($row = mysqli_fetch_assoc($paket)): ?>

        <div class="col-xl-3 col-lg-4 col-md-6 mb-4 d-flex">

            <div class="price-card w-100">

                <div class="price-title">
                    <?= htmlspecialchars($row['nama_paket']) ?>
                </div>

                <div class="price">
                    Rp <?= number_format($row['harga_paket'],0,',','.') ?>
                </div>

                <ul class="price-list">

                    <?php
                    $desc = explode("\n", $row['deskripsi']);

                    foreach($desc as $item):

                        if(trim($item) != ''):
                    ?>

                    <li>
                        ✓ <?= htmlspecialchars(trim($item)) ?>
                    </li>

                    <?php
                        endif;
                    endforeach;
                    ?>

                </ul>

                <?php if(!empty($row['note'])): ?>

                    <div class="price-note">
                        <?= nl2br(htmlspecialchars($row['note'])) ?>
                    </div>

                <?php endif; ?>

                <a href="guest/booking.php"
                   class="btn btn-success btn-book">

                    Booking Sebagai Tamu

                </a>

            </div>

        </div>

        <?php endwhile; ?>

    <?php else: ?>

        <div class="col-12 text-center py-5">

            <h5 class="text-muted">
                Paket tidak ditemukan
            </h5>

        </div>

    <?php endif; ?>

    </div>
</section>

<footer>
    &copy; <?= date('Y'); ?> RichArt Studio. All rights reserved.
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
