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

/* ===== DATA CHART - Pesanan per Bulan (6 bulan terakhir) ===== */
$chartData = mysqli_query($connection, "
    SELECT 
        DATE_FORMAT(tgl_pemesanan, '%Y-%m') as bulan,
        COUNT(*) as jumlah
    FROM pemesanan 
    WHERE id_customer='$id_customer'
    AND tgl_pemesanan >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY DATE_FORMAT(tgl_pemesanan, '%Y-%m')
    ORDER BY bulan ASC
");

$bulanChart = [];
$jumlahChart = [];
$bulanNama = [
    '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
    '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu',
    '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'
];

while ($row = mysqli_fetch_assoc($chartData)) {
    $bulanAngka = substr($row['bulan'], 5, 2);
    $bulanChart[] = $bulanNama[$bulanAngka];
    $jumlahChart[] = $row['jumlah'];
}

$bulan = [
    1 => 'Januari', 'Februari', 'Maret', 'April',
    'Mei', 'Juni', 'Juli', 'Agustus',
    'September', 'Oktober', 'November', 'Desember'
];

/* ===== PESANAN TERAKHIR ===== */
$pesananTerakhir = mysqli_query($connection, "
    SELECT p.tgl_pemesanan, pk.nama_paket, p.status_pemesanan, p.ringkasan_biaya
    FROM pemesanan p
    JOIN paket pk ON p.id_paket = pk.id_paket
    WHERE p.id_customer='$id_customer'
    ORDER BY p.tgl_pemesanan DESC
    LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Customer - Richart Studio</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: #fafafa;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    color: #1a1a1a;
    line-height: 1.6;
}

.page-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 24px;
}

/* WELCOME SECTION */
.welcome-section {
    margin-bottom: 48px;
}

.welcome-section h1 {
    font-size: 32px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 8px;
}

.welcome-section p {
    font-size: 16px;
    color: #666;
}

/* STATS GRID */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

.stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 28px 24px;
    border: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    border-color: #22c55e;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 16px;
}

.stat-card.total .stat-icon {
    background: #e8f5e9;
    color: #22c55e;
}

.stat-card.proses .stat-icon {
    background: #fff3e0;
    color: #fb8c00;
}

.stat-card.selesai .stat-icon {
    background: #e3f2fd;
    color: #2196f3;
}

.stat-card.terakhir .stat-icon {
    background: #f3e5f5;
    color: #9c27b0;
}

.stat-label {
    font-size: 13px;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.stat-value {
    font-size: 32px;
    font-weight: 600;
    color: #1a1a1a;
}

.stat-date {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a1a;
}

/* CTA CARD */
.cta-card {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    border-radius: 20px;
    padding: 48px 40px;
    margin-bottom: 40px;
    position: relative;
    overflow: hidden;
}

.cta-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
}

.cta-content {
    position: relative;
    z-index: 2;
}

.cta-card h2 {
    font-size: 28px;
    font-weight: 600;
    color: #fff;
    margin-bottom: 12px;
}

.cta-card p {
    font-size: 16px;
    color: rgba(255,255,255,0.9);
    margin-bottom: 24px;
}

.cta-button {
    display: inline-block;
    background: #fff;
    color: #16a34a;
    padding: 14px 32px;
    border-radius: 100px;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    color: #16a34a;
    text-decoration: none;
}

/* CONTENT GRID */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 32px;
}

/* CHART CARD */
.chart-card {
    background: #fff;
    border-radius: 16px;
    padding: 32px 28px;
    border: 1px solid #f0f0f0;
}

.chart-card h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 24px;
}

#pesananChart {
    max-height: 280px;
}

/* TABLE CARD */
.table-card {
    background: #fff;
    border-radius: 16px;
    padding: 32px 28px;
    border: 1px solid #f0f0f0;
}

.table-card h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 24px;
}

.order-table {
    width: 100%;
}

.order-table thead th {
    font-size: 12px;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    padding-bottom: 16px;
    border-bottom: 1px solid #f0f0f0;
}

.order-table tbody td {
    padding: 16px 0;
    border-bottom: 1px solid #f8f8f8;
    font-size: 14px;
    color: #333;
}

.order-table tbody tr:last-child td {
    border-bottom: none;
}

.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 600;
}

.status-proses {
    background: #fff3e0;
    color: #fb8c00;
}

.status-selesai {
    background: #e8f5e9;
    color: #22c55e;
}

.status-belum {
    background: #f5f5f5;
    color: #666;
}

.price {
    font-weight: 600;
    color: #22c55e;
}

.empty-state {
    text-align: center;
    padding: 48px 20px;
    color: #999;
}

.empty-state svg {
    width: 64px;
    height: 64px;
    margin-bottom: 16px;
    opacity: 0.3;
}

/* RESPONSIVE */
@media (max-width: 968px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .page-wrapper {
        padding: 24px 16px;
    }
    
    .welcome-section h1 {
        font-size: 24px;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .stat-card {
        padding: 20px 16px;
    }
    
    .stat-value {
        font-size: 24px;
    }
    
    .cta-card {
        padding: 32px 24px;
    }
    
    .cta-card h2 {
        font-size: 22px;
    }
}
</style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="page-wrapper">

    <!-- WELCOME -->
    <div class="welcome-section">
        <h1>Halo, <?= htmlspecialchars($nama); ?>! 👋</h1>
        <p>
            <?= $dalamProses > 0 
                ? "Kamu punya <strong>$dalamProses pesanan</strong> yang sedang diproses"
                : "Semua pesanan kamu sudah selesai"
            ?>
        </p>
    </div>

    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon">📦</div>
            <div class="stat-label">Total Pesanan</div>
            <div class="stat-value"><?= $totalPesanan; ?></div>
        </div>
        
        <div class="stat-card proses">
            <div class="stat-icon">⏳</div>
            <div class="stat-label">Dalam Proses</div>
            <div class="stat-value"><?= $dalamProses; ?></div>
        </div>
        
        <div class="stat-card selesai">
            <div class="stat-icon">✓</div>
            <div class="stat-label">Selesai</div>
            <div class="stat-value"><?= $selesai; ?></div>
        </div>
        
        <div class="stat-card terakhir">
            <div class="stat-icon">📅</div>
            <div class="stat-label">Booking Terakhir</div>
            <div class="stat-date">
                <?php
                if (!empty($terakhir['tgl_pemesanan'])) {
                    $tanggal = strtotime($terakhir['tgl_pemesanan']);
                    $hari = date('d', $tanggal);
                    $bulanIndo = $bulan[(int)date('m', $tanggal)];
                    echo $hari . ' ' . $bulanIndo;
                } else {
                    echo '-';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="cta-card">
        <div class="cta-content">
            <h2>Siap mengabadikan momen terbaikmu?</h2>
            <p>Booking sekarang dan pilih paket favoritmu.</p>
            <a href="pesan_sekarang.php" class="cta-button">Pesan Sekarang</a>
        </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="content-grid">
        
        <!-- CHART -->
        <div class="chart-card">
            <h3>Statistik Pesanan</h3>
            <canvas id="pesananChart"></canvas>
        </div>

        <!-- RECENT ORDERS -->
        <div class="table-card">
            <h3>Pesanan Terbaru</h3>
            
            <?php if (mysqli_num_rows($pesananTerakhir) > 0): ?>
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Paket</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($pesananTerakhir)) {
                    $statusClass = 'status-belum';
                    if ($row['status_pemesanan'] == 'Proses') $statusClass = 'status-proses';
                    if ($row['status_pemesanan'] == 'Selesai') $statusClass = 'status-selesai';
                    ?>
                    <tr>
                        <td>
                            <div style="font-weight: 600; margin-bottom: 4px;">
                                <?= htmlspecialchars($row['nama_paket']) ?>
                            </div>
                            <div class="price">
                                Rp <?= number_format($row['ringkasan_biaya'], 0, ',', '.') ?>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge <?= $statusClass ?>">
                                <?= htmlspecialchars($row['status_pemesanan']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                </svg>
                <p>Belum ada pesanan</p>
            </div>
            <?php endif; ?>
        </div>

    </div>

</div>

<script>
// Chart Configuration
const ctx = document.getElementById('pesananChart').getContext('2d');
const pesananChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($bulanChart) ?>,
        datasets: [{
            label: 'Jumlah Pesanan',
            data: <?= json_encode($jumlahChart) ?>,
            borderColor: '#22c55e',
            backgroundColor: 'rgba(34, 197, 94, 0.1)',
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointRadius: 5,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#22c55e',
            pointBorderWidth: 2,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#1a1a1a',
                padding: 12,
                cornerRadius: 8,
                titleFont: {
                    size: 13
                },
                bodyFont: {
                    size: 14,
                    weight: 'bold'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    color: '#999',
                    font: {
                        size: 12
                    }
                },
                grid: {
                    color: '#f5f5f5',
                    drawBorder: false
                }
            },
            x: {
                ticks: {
                    color: '#999',
                    font: {
                        size: 12
                    }
                },
                grid: {
                    display: false,
                    drawBorder: false
                }
            }
        }
    }
});
</script>

</body>
</html>