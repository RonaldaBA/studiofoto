<?php
include "../helper/auth.php";
include "../helper/connection.php";
isLogin();

$id_customer = $_SESSION['id_customer'];

$bulan = [
    1 => 'Januari','Februari','Maret','April','Mei','Juni',
    'Juli','Agustus','September','Oktober','November','Desember'
];

// QUERY RIWAYAT TRANSAKSI (PAKAI created_at)
$query = mysqli_query($connection, "
    SELECT 
        p.id_pemesanan,
        p.tgl_pemesanan,
        p.created_at,
        p.status_pemesanan,
        p.metode_pembayaran,
        p.ringkasan_biaya,
        pk.nama_paket
    FROM pemesanan p
    JOIN paket pk ON p.id_paket = pk.id_paket
    WHERE p.id_customer = '$id_customer'
    ORDER BY p.tgl_pemesanan DESC
");

if (!$query) {
    die("Query error: " . mysqli_error($connection));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        body {
            background: #f8fafc;
            font-family: Arial, sans-serif;
        }
        .page-title {
            font-weight: 700;
            color: #1f2937;
        }
        .badge-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-selesai {
            background: #dcfce7;
            color: #166534;
        }
        .badge-proses {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }
        .table {
            background: white;
        }
        .table thead {
            background: #f1f5f9;
        }
        .table thead th {
            border: none;
            font-weight: 600;
            font-size: 13px;
            color: #64748b;
            padding: 14px;
        }
        .table tbody td {
            padding: 14px;
            vertical-align: middle;
            border-bottom: 1px solid #e5e7eb;
        }
        .btn-sm {
            font-size: 13px;
            padding: 6px 10px;
        }
    </style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="container py-5">
    <h3 class="page-title mb-4">Riwayat Transaksi</h3>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pemotretan</th>
                        <th>Paket</th>
                        <th>Status Pesanan</th>
                        <th>Status Pembayaran</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $no = 1;
                if (mysqli_num_rows($query) > 0):
                    while ($row = mysqli_fetch_assoc($query)):

                        // === FORMAT TANGGAL ===
                        $tgl = strtotime($row['tgl_pemesanan']);
                        $hari = date('d', $tgl);
                        $bulanIndo = $bulan[(int)date('m', $tgl)];
                        $tahun = date('Y', $tgl);

                        // === STATUS PESANAN ===
                        if ($row['status_pemesanan'] === 'Selesai') {
                            $badgePesanan = 'badge-selesai';
                        } else {
                            $badgePesanan = 'badge-proses';
                        }

                        // === STATUS PEMBAYARAN ===
                        $now = time();
                        if ($row['metode_pembayaran'] === 'Cash') {

                            $statusBayar = 'Bayar di Tempat';
                            $badgeBayar  = 'badge-secondary';

                        } elseif ($row['metode_pembayaran'] === 'QRIS') {

                            if (!empty($row['created_at'])) {
                                $expired = strtotime($row['created_at']) + 86400;
                            } else {
                                $expired = 0;
                            }

                            if (time() <= $expired) {
                                $statusBayar = 'Menunggu Pembayaran';
                                $badgeBayar  = 'badge-warning';
                            } else {
                                $statusBayar = 'QRIS Expired';
                                $badgeBayar  = 'badge-danger';
                            }

                        } else {
                            $statusBayar = 'Tidak Diketahui';
                            $badgeBayar  = 'badge-secondary';
                        }

                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= "$hari $bulanIndo $tahun"; ?></td>
                        <td><?= htmlspecialchars($row['nama_paket']); ?></td>
                        <td>
                            <span class="badge badge-status <?= $badgePesanan ?>">
                                <?= $row['status_pemesanan']; ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-status <?= $badgeBayar ?>">
                                <?= $statusBayar; ?>
                            </span>
                        </td>
                        <td>Rp <?= number_format($row['ringkasan_biaya'],0,',','.'); ?></td>
                        <td>
                            <a href="struk_pembayaran.php?id=<?= $row['id_pemesanan']; ?>"
                               class="btn btn-success btn-sm">
                                Lihat Struk
                            </a>
                        </td>
                    </tr>
                <?php
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada transaksi
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
