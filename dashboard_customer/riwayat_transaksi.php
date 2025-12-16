<?php
include "../helper/auth.php";
include "../helper/connection.php";

// Ambil id_customer dari session
$id_customer = $_SESSION['id_customer'];

$bulan = [
    1 => 'Januari', 'Februari', 'Maret', 'April',
    'Mei', 'Juni', 'Juli', 'Agustus',
    'September', 'Oktober', 'November', 'Desember'
];

// Query untuk mengambil data pemesanan customer
$query = mysqli_query($connection, "
    SELECT 
        p.id_pemesanan,
        p.tgl_pemesanan, 
        p.status_pemesanan, 
        p.ringkasan_biaya, 
        pk.nama_paket
    FROM pemesanan p
    JOIN paket pk ON p.id_paket = pk.id_paket
    WHERE p.id_customer = '$id_customer'
    ORDER BY p.tgl_pemesanan DESC
");

// Cek apakah query berhasil
if (!$query) {
    die("Query Error: " . mysqli_error($connection));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi - Richart Studio</title>

    <!-- Bootstrap -->
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
            font-size: 13px;
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

        .table {
            background: white;
        }

        .table thead {
            background: #f1f5f9;
        }

        .table thead th {
            border: none;
            color: #64748b;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px;
        }

        .table tbody td {
            padding: 16px;
            vertical-align: middle;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background: #f9fafb;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
        }
    </style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="container py-5">
    <h2 class="page-title mb-4">Riwayat Transaksi</h2>

    <!-- TABLE -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Paket</th>
                        <th>Status</th>
                        <th>Total Biaya</th>
                    </tr>
                </thead>
                <tbody>

                <?php 
                $no = 1;
                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                        // Format tanggal Indonesia
                        $tgl = date('d M Y', strtotime($row['tgl_pemesanan']));
                        
                        // Format harga
                        $harga = number_format($row['ringkasan_biaya'], 0, ',', '.');
                        
                        // Badge status
                        $status = $row['status_pemesanan'];
                        $badgeClass = ($status == 'Selesai') ? 'badge-selesai' : 'badge-proses';
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <?php
                            if (!empty($terakhir['tgl_pemesanan'])) {
                                $tanggal = strtotime($terakhir['tgl_pemesanan']);
                                $hari = date('d', $tanggal);
                                $bulanIndo = $bulan[(int)date('m', $tanggal)];
                                $tahun = date('Y', $tanggal);
                            } else {
                                $hari = '-';
                                $bulanIndo = '-';
                                $tahun = '-';
                            }
                            ?>
                            <td><?= $hari . ' ' . $bulanIndo . ' ' . $tahun ?></td>
                            <td><?= htmlspecialchars($row['nama_paket']); ?></td>
                            <td>
                                <span class="badge badge-status <?= $badgeClass; ?>">
                                    <?= htmlspecialchars($status); ?>
                                </span>
                            </td>
                            <td>Rp <?= $harga; ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    // Jika tidak ada data
                    ?>
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h5>Belum Ada Transaksi</h5>
                                <p class="mb-0 text-muted">Anda belum melakukan pemesanan</p>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>