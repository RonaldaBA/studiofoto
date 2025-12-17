<?php
include "../helper/auth.php";
include "../helper/connection.php";
isLogin();

if (!isset($_GET['id'])) {
    die("ID pemesanan tidak ditemukan");
}

$id_pemesanan = $_GET['id'];

// =======================
// AMBIL DATA PEMESANAN
// =======================
$q = mysqli_query($connection, "
    SELECT 
        p.*,
        pk.nama_paket,
        c.nama,
        c.no_hp,
        c.email
    FROM pemesanan p
    JOIN paket pk ON p.id_paket = pk.id_paket
    JOIN customer c ON p.id_customer = c.id_customer
    WHERE p.id_pemesanan = '$id_pemesanan'
");

if (mysqli_num_rows($q) == 0) {
    die("Data pemesanan tidak ditemukan");
}

$data = mysqli_fetch_assoc($q);

// =======================
// HITUNG WAKTU QRIS (24 JAM)
// =======================
date_default_timezone_set('Asia/Jakarta');

$createdAt = strtotime($data['created_at']);
$expiredAt = $createdAt + 86400; // 24 jam
$now = time();

$sisa_waktu = $expiredAt - $now;
$expired = $sisa_waktu <= 0;

// =======================
// AUTO BATAL JIKA QRIS EXPIRED
// =======================
if (
    $data['metode_pembayaran'] === 'QRIS'
    && $data['status_pemesanan'] === 'Menunggu Pembayaran'
    && $expired
) {
    mysqli_query($connection, "
        UPDATE pemesanan
        SET status_pemesanan = 'Dibatalkan'
        WHERE id_pemesanan = '$id_pemesanan'
    ");

    // update data lokal biar tampilan ikut berubah
    $data['status_pemesanan'] = 'Dibatalkan';
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        body {
            background: #f7fafc;
            font-family: Arial, sans-serif;
        }
        .struk-wrapper {
            max-width: 600px;
            margin: 40px auto;
        }
        .struk-card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        .struk-title {
            text-align: center;
            font-weight: 700;
            margin-bottom: 30px;
        }
        .struk-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 15px;
        }
        .divider {
            border-top: 1px dashed #cbd5e0;
            margin: 20px 0;
        }
        .total {
            font-size: 20px;
            font-weight: 700;
            color: #38a169;
        }
        .qris-box {
            text-align: center;
            margin-top: 25px;
        }
        .qris-box img {
            max-width: 260px;
            margin-top: 15px;
        }
        .btn-back {
            margin-top: 25px;
            width: 100%;
        }
    </style>
</head>

<body>

<div class="struk-wrapper">
<div class="struk-card">

<h4 class="struk-title">🧾 Struk Pembayaran</h4>

<div class="struk-row">
    <span>No Pesanan</span>
    <strong>#<?= $data['id_pemesanan'] ?></strong>
</div>

<div class="struk-row">
    <span>Jadwal Pemotretan</span>
    <strong><?= $data['tgl_pemesanan'] ?></strong>
</div>

<div class="struk-row">
    <span>Tanggal Pemesanan</span>
    <strong><?= $data['created_at'] ?></strong>
</div>

<div class="divider"></div>

<div class="struk-row">
    <span>Nama Pemesan</span>
    <strong><?= $data['nama'] ?></strong>
</div>

<div class="struk-row">
    <span>No WhatsApp</span>
    <strong><?= $data['no_hp'] ?></strong>
</div>

<div class="struk-row">
    <span>Email</span>
    <strong><?= $data['email'] ?></strong>
</div>

<div class="divider"></div>

<div class="struk-row">
    <span>Paket</span>
    <strong><?= $data['nama_paket'] ?></strong>
</div>

<div class="struk-row total">
    <span>Total Bayar</span>
    <span>Rp <?= number_format($data['ringkasan_biaya'], 0, ',', '.') ?></span>
</div>

<div class="divider"></div>

<!-- =======================
     STRUK PEMBAYARAN
======================= -->

<?php if ($data['metode_pembayaran'] === 'QRIS'): ?>

    <?php if ($data['status_pemesanan'] === 'Menunggu Pembayaran'): ?>
        <div class="qris-box">
            <h6>⏳ Selesaikan Pembayaran Dalam</h6>
            <h4 id="countdown" style="color:red;"></h4>

            <p>Scan QRIS di bawah ini:</p>
            <img src="../assets/img/Qris.jpeg" alt="QRIS">
        </div>

    <?php elseif (
        $data['status_pemesanan'] === 'Pemesanan Aktif'
        || $data['status_pemesanan'] === 'Pemesanan Selesai'
    ): ?>
        <div class="alert alert-success text-center">
            ✅ Anda telah menyelesaikan pembayaran dengan QRIS
        </div>

    <?php elseif ($data['status_pemesanan'] === 'Dibatalkan'): ?>
        <div class="alert alert-danger text-center">
            ⛔ Anda tidak menyelesaikan pembayaran dengan QRIS dalam 24 jam
        </div>
    <?php endif; ?>

<?php elseif ($data['metode_pembayaran'] === 'Cash'): ?>

    <div class="alert alert-info text-center">
        💵 Pembayaran dilakukan secara langsung (Cash) di studio
    </div>

<?php endif; ?>



<a href="riwayat_transaksi.php" class="btn btn-success btn-back">
    Kembali
</a>

</div>
</div>

<?php if (
    $data['metode_pembayaran'] === 'QRIS'
    && $data['status_pemesanan'] === 'Menunggu Pembayaran'
    && !$expired
): ?>

<script>
let sisa = <?= max(0, $sisa_waktu) ?>;

function format(sec) {
    let h = Math.floor(sec / 3600);
    let m = Math.floor((sec % 3600) / 60);
    let s = sec % 60;
    return `${h} jam ${m} menit ${s} detik`;
}

const el = document.getElementById('countdown');

setInterval(() => {
    if (sisa <= 0) {
        el.innerHTML = "⛔ QRIS Expired";
        return;
    }
    el.innerHTML = format(sisa);
    sisa--;
}, 1000);
</script>
<?php endif; ?>


</body>
</html>
