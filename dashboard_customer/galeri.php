<?php
include "../helper/auth.php";
include "../helper/connection.php";
isLogin();

/* =============================
   AMBIL ID CUSTOMER DARI SESSION
   ============================= */
if (isset($_SESSION['id_customer'])) {
    $id_customer = $_SESSION['id_customer'];
}

if ($id_customer === null) {
    header("Location: ../login.php");
    exit();
}

$bulan = [
    1 => 'Januari', 'Februari', 'Maret', 'April',
    'Mei', 'Juni', 'Juli', 'Agustus',
    'September', 'Oktober', 'November', 'Desember'
];

/* =============================
   QUERY FOTO HASIL CUSTOMER
   ============================= */
$query = "
    SELECT 
        g.id_photo,
        g.file_name,
        g.upload_date,
        p.tgl_pemesanan
    FROM gallery g
    LEFT JOIN pemesanan p 
        ON g.id_pemesanan = p.id_pemesanan
    WHERE g.id_customer = ?
    ORDER BY p.tgl_pemesanan DESC, g.id_photo DESC
";

$stmt = $connection->prepare($query);
$stmt->bind_param("i", $id_customer);
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
        html { overflow-y: scroll; }

        body {
            background: #f8fafc;
            font-family: Arial, sans-serif;
        }

        .page-wrapper {
            max-width: 1200px;
            margin: auto;
            padding: 40px 20px;
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
            transition: 0.2s;
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
        }

        .gallery-caption {
            padding: 14px 16px;
        }

        .gallery-caption h6 {
            font-size: 15px;
            font-weight: 600;
            margin: 0;
        }

        .gallery-date {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 6px;
        }

        .modal-body img {
            width: 100%;
            border-radius: 8px;
        }

        .btn-download {
            background: #3b82f6;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
        }

        .btn-download:hover {
            background: #2563eb;
            color: #fff;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
    </style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="page-wrapper">

    <h2 class="page-title">Galeri Foto Saya</h2>
    <p class="page-desc">Semua hasil foto Anda</p>

    <?php if ($result->num_rows > 0): ?>
        <div class="gallery-grid">

            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                $photoUrl = "../assets/img/data/" . $row['file_name'];
                $modalId = "photoModal" . $row['id_photo'];
                ?>

                <div class="gallery-item" data-toggle="modal" data-target="#<?= $modalId ?>">
                    <img src="<?= htmlspecialchars($photoUrl) ?>" alt="Hasil Foto">
                    <div class="gallery-caption">
                        <h6>RichArt Studio</h6>
                        <?php if (!empty($row['upload_date'])): ?>
                        <?php
                            if (!empty($row['tgl_pemesanan'])) {
                                $tanggal = strtotime($row['tgl_pemesanan']);
                                $hari = date('d', $tanggal);
                                $bulanIndo = $bulan[(int)date('m', $tanggal)];
                                $tahun = date('Y', $tanggal);
                            } else {
                                $hari = '-';
                                $bulanIndo = '-';
                                $tahun = '-';
                            }

                            if (!empty($row['tgl_pemesanan'])) {
                                $tanggalupload = strtotime($row['tgl_pemesanan']);
                                $hariupload = date('d', $tanggalupload);
                                $bulanIndoupload = $bulan[(int)date('m', $tanggalupload)];
                                $tahunupload = date('Y', $tanggalupload);
                            } else {
                                $hari = '-';
                                $bulanIndo = '-';
                                $tahun = '-';
                            }
                        ?>
                            Dipesan pada <?= $hari . ' ' . $bulanIndo . ' ' . $tahun ?><br>
                            <!-- Diunggah pada <?= $hariupload . ' ' . $bulanIndoupload . ' ' . $tahunupload ?> -->
                        <?php else: ?>
                            Dipesan pada <?= $hari . ' ' . $bulanIndo . ' ' . $tahun ?><br>
                            <!-- Foto masih dalam proses -->
                        <?php endif; ?>
                    </div>
                </div>

                <!-- MODAL -->
                <div class="modal fade" id="<?= $modalId ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pratinjau Foto</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="<?= htmlspecialchars($photoUrl) ?>" alt="Hasil Foto">
                                <p class="gallery-date mt-2">
                                <h6>RichArt Studio</h6>
                                <?php if (!empty($row['upload_date'])): ?>
                                <?php
                                    if (!empty($row['tgl_pemesanan'])) {
                                        $tanggal = strtotime($row['tgl_pemesanan']);
                                        $hari = date('d', $tanggal);
                                        $bulanIndo = $bulan[(int)date('m', $tanggal)];
                                        $tahun = date('Y', $tanggal);
                                    } else {
                                        $hari = '-';
                                        $bulanIndo = '-';
                                        $tahun = '-';
                                    }

                                    if (!empty($row['tgl_pemesanan'])) {
                                        $tanggalupload = strtotime($row['tgl_pemesanan']);
                                        $hariupload = date('d', $tanggalupload);
                                        $bulanIndoupload = $bulan[(int)date('m', $tanggalupload)];
                                        $tahunupload = date('Y', $tanggalupload);
                                    } else {
                                        $hari = '-';
                                        $bulanIndo = '-';
                                        $tahun = '-';
                                    }
                                ?>
                                    Dipesan pada <?= $hari . ' ' . $bulanIndo . ' ' . $tahun ?><br>
                                    <!-- Diunggah pada <?= $hariupload . ' ' . $bulanIndoupload . ' ' . $tahunupload ?> -->
                                <?php else: ?>
                                    Dipesan pada <?= $hari . ' ' . $bulanIndo . ' ' . $tahun ?><br>
                                    <!-- Foto masih dalam proses -->
                                <?php endif; ?>
                                </p>
                                <a href="<?= htmlspecialchars($photoUrl) ?>" download class="btn-download">
                                    ⬇️ Download Foto
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>

        </div>
    <?php else: ?>
        <div class="empty-state">
            <h5>Belum Ada Foto</h5>
            <p>Foto hasil Anda akan muncul di sini.</p>
        </div>
    <?php endif; ?>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>