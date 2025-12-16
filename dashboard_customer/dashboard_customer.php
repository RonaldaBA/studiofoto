<?php
include "../helper/auth.php";
include "../helper/connection.php";
isLogin();

$id_customer = $_SESSION['id_customer'];
$nama    = $_SESSION['nama'];

/* ===== RINGKASAN ===== */
$totalPesanan = mysqli_fetch_assoc(
    mysqli_query($connection, "SELECT COUNT(*) total FROM pemesanan WHERE id_customer='$id_customer'")
)['total'];

$dalamProses = mysqli_fetch_assoc(
    mysqli_query($connection, "SELECT COUNT(*) total FROM pemesanan WHERE id_customer='$id_customer' AND status_pemesanan='Proses'")
)['total'];

$selesai = mysqli_fetch_assoc(
    mysqli_query($connection, "SELECT COUNT(*) total FROM pemesanan WHERE id_customer='$id_customer' AND status_pemesanan='Selesai'")
)['total'];

$terakhir = mysqli_fetch_assoc(
    mysqli_query($connection, "
        SELECT tgl_pemesanan 
        FROM pemesanan 
        WHERE id_customer='$id_customer'
        ORDER BY tgl_pemesanan DESC
        LIMIT 1
    ")
);

/* ===== PESANAN TERAKHIR ===== */
$pesananTerakhir = mysqli_query($connection, "
    SELECT p.tgl_pemesanan, pk.nama_paket, p.status_pemesanan
    FROM pemesanan p
    JOIN paket pk ON p.id_paket = pk.id_paket
    WHERE p.id_customer='$id_customer'
    ORDER BY p.tgl_pemesanan DESC
    LIMIT 3
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Customer</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<style>
html { overflow-y: scroll; }

body {
    background: #f8fafc;
    font-family: Arial, sans-serif;
}

/* WRAPPER */
.page-wrapper {
    max-width: 1100px;
    margin: 0 auto;
    padding: 50px 20px;
}

/* WELCOME */
.welcome {
    margin-bottom: 45px;
}

.welcome h3 {
    font-weight: 700;
    color: #111827;
    margin-bottom: 6px;
}

.welcome p {
    color: #6b7280;
    font-size: 15px;
}

/* STAT CARD */
.stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    height: 100%;
}

.stat-title {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-value {
    font-size: 30px;
    font-weight: 700;
    color: #111827;
}

/* CTA */
.action-card {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: #fff;
    border-radius: 18px;
    padding: 40px;
    margin-top: 25px;
}

.action-card h5 {
    font-weight: 700;
    font-size: 22px;
    margin-bottom: 8px;
}

.action-card p {
    opacity: 0.9;
    margin-bottom: 22px;
}

.action-card a {
    background: #fff;
    color: #16a34a;
    padding: 12px 30px;
    border-radius: 999px;
    text-decoration: none;
    font-weight: 600;
}

/* TABLE */
.table-wrapper {
    background: #fff;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    margin-top: 55px;
}

.table thead th {
    font-size: 13px;
    color: #6b7280;
    text-transform: uppercase;
    border-bottom: none;
}
</style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="page-wrapper">

    <!-- WELCOME -->
    <div class="welcome">
        <h3>Selamat Datang, <?= htmlspecialchars($nama); ?> 👋</h3>
        <p>
            <?= $dalamProses > 0 
                ? "Kamu punya <strong>$dalamProses</strong> pesanan yang sedang diproses."
                : "Belum ada pesanan yang sedang diproses."
            ?>
        </p>
    </div>

    <!-- STAT -->
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="stat-card">
                <div class="stat-title">Total Pesanan</div>
                <div class="stat-value"><?= $totalPesanan; ?></div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stat-card">
                <div class="stat-title">Dalam Proses</div>
                <div class="stat-value"><?= $dalamProses; ?></div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stat-card">
                <div class="stat-title">Selesai</div>
                <div class="stat-value"><?= $selesai; ?></div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stat-card">
                <div class="stat-title">Booking Terakhir</div>
                <div class="stat-value">
                    <?= $terakhir ? date('d M Y', strtotime($terakhir['tgl_pemesanan'])) : '-'; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="action-card">
        <h5>Siap mengabadikan momen terbaikmu?</h5>
        <p>Booking sekarang dan pilih paket favoritmu.</p>
        <a href="pesan_sekarang.php">Pesan Sekarang</a>
    </div>

    <!-- TABLE -->
    <div class="table-wrapper">
        <h5 class="mb-3">Pesanan Terakhir</h5>

        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Paket</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (mysqli_num_rows($pesananTerakhir) > 0) {
                while ($row = mysqli_fetch_assoc($pesananTerakhir)) {
                    echo "
                    <tr>
                        <td>".date('d M Y', strtotime($row['tgl_pemesanan']))."</td>
                        <td>{$row['nama_paket']}</td>
                        <td>{$row['status_pemesanan']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-center text-muted'>Belum ada pesanan</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
