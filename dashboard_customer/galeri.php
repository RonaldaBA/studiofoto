<?php
include "../helper/auth.php";
include "../helper/connection.php";
isLogin();

// Coba ambil dari berbagai kemungkinan session key
$userId = null;
if (isset($_SESSION['id_customer'])) {
    $userId = $_SESSION['id_customer'];
} elseif (isset($_SESSION['id_user'])) {
    $userId = $_SESSION['id_user'];
} elseif (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
}

// Kalau masih null, redirect ke login
if ($userId === null) {
    header("Location: ../login.php");
    exit();
}

// Query untuk ambil pemesanan yang sudah selesai
$query = "SELECT p.*, pk.nama_paket, pk.deskripsi 
          FROM pemesanan p 
          JOIN paket pk ON p.id_paket = pk.id_paket 
          WHERE p.id_user = ? 
          AND p.status_pemesanan = 'Selesai'
          ORDER BY p.tgl_pemesanan DESC";

$stmt = $connection->prepare($query);
$stmt->bind_param("s", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Galeri Foto Saya - RichArt Studio</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        /* FIX SCROLLBAR (BIAR NAVBAR TIDAK GERAK) */
        html {
            overflow-y: scroll;
        }

        body {
            background: #f8fafc;
            font-family: Arial, sans-serif;
        }

        .page-title {
            font-weight: 700;
            color: #111827;
            margin-bottom: 10px;
        }

        .page-desc {
            color: #6b7280;
            margin-bottom: 30px;
        }

        /* GALLERY GRID */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
        }

        .gallery-item {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }

        .gallery-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 30px rgba(0,0,0,0.12);
        }

        .gallery-item img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            display: block;
        }

        .gallery-caption {
            padding: 16px;
        }

        .gallery-caption h6 {
            margin: 0;
            font-weight: 600;
            font-size: 16px;
            color: #111827;
        }

        .gallery-caption p {
            margin: 6px 0 0;
            font-size: 13px;
            color: #6b7280;
        }

        .gallery-date {
            margin-top: 8px;
            font-size: 12px;
            color: #9ca3af;
        }

        /* WRAPPER KONTEN */
        .page-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .empty-state svg {
            width: 120px;
            height: 120px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state h5 {
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #9ca3af;
            margin-bottom: 20px;
        }

        .btn-pesan {
            background: #22c55e;
            color: #fff;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }

        .btn-pesan:hover {
            background: #16a34a;
            color: #fff;
            text-decoration: none;
        }

        /* MODAL */
        .modal-body img {
            width: 100%;
            border-radius: 8px;
        }

        .btn-download {
            background: #3b82f6;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-download:hover {
            background: #2563eb;
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="page-wrapper">

    <h2 class="page-title">Galeri Foto Saya</h2>
    <p class="page-desc">
        Koleksi hasil foto Anda di RichArt Studio
    </p>

    <?php if ($result->num_rows > 0): ?>
        <div class="gallery-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="gallery-item" data-toggle="modal" data-target="#modal<?= $row['id_pemesanan'] ?>">
                    <!-- Placeholder karena belum ada kolom foto_hasil -->
                    <img src="https://via.placeholder.com/280x260/22c55e/ffffff?text=<?= urlencode($row['nama_paket']) ?>" 
                         alt="<?= htmlspecialchars($row['nama_paket']) ?>">
                    <div class="gallery-caption">
                        <h6><?= htmlspecialchars($row['nama_paket']) ?></h6>
                        <p><?= htmlspecialchars($row['deskripsi']) ?></p>
                        <p class="gallery-date">
                            📅 <?= date('d M Y', strtotime($row['tgl_pemesanan'])) ?>
                        </p>
                    </div>
                </div>

                <!-- MODAL DETAIL -->
                <div class="modal fade" id="modal<?= $row['id_pemesanan'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= htmlspecialchars($row['nama_paket']) ?></h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img src="https://via.placeholder.com/800x600/22c55e/ffffff?text=<?= urlencode($row['nama_paket']) ?>" 
                                     alt="<?= htmlspecialchars($row['nama_paket']) ?>">
                                <p style="margin-top: 15px; color: #6b7280;">
                                    <?= htmlspecialchars($row['deskripsi']) ?>
                                </p>
                                <p style="color: #9ca3af; font-size: 14px;">
                                    Tanggal: <?= date('d M Y', strtotime($row['tgl_pemesanan'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    <?php else: ?>
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h5>Belum Ada Pemesanan Selesai</h5>
            <p>Anda belum memiliki pemesanan yang selesai. Pesan sekarang!</p>
            <a href="pesan_sekarang.php" class="btn-pesan">
                📸 Pesan Sekarang
            </a>
        </div>
    <?php endif; ?>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>