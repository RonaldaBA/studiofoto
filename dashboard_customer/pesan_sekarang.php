<?php


include "../helper/auth.php";
include "../helper/connection.php";
isLogin();

$id_customer = $_SESSION['id_customer'];

/* ================================
   AJAX CEK JAM (KALENDER JAM)
   ================================ */
if (isset($_GET['ajax']) && $_GET['ajax'] === 'cek_jam') {

    $tanggal  = $_GET['tanggal']; // YYYY-MM-DD
    $id_paket = $_GET['paket'];

    $jam_list = ['08:00','09:00','10:00','11:00','13:00','14:00','15:00','16:00'];

    // info paket
    $qPaket = mysqli_query($connection,"
        SELECT butuh_fotografer, jumlah_fotografer
        FROM paket WHERE id_paket='$id_paket'
    ");
    $paket = mysqli_fetch_assoc($qPaket);

    $result = [];

    // jika tidak butuh fotografer
    if ($paket['butuh_fotografer'] === 'Tidak') {
        foreach ($jam_list as $jam) $result[$jam] = true;
        echo json_encode($result); exit;
    }

    // total fotografer
    $qTotal = mysqli_query($connection,"SELECT COUNT(*) total FROM photographer");
    $total = mysqli_fetch_assoc($qTotal)['total'];

    foreach ($jam_list as $jam) {
        $datetime = $tanggal.' '.$jam.':00';

        $qBusy = mysqli_query($connection,"
            SELECT COUNT(DISTINCT id_photographer) sibuk
            FROM pemesanan
            WHERE tgl_pemesanan='$datetime'
            AND status_pemesanan IN ('Proses','Selesai')
            AND id_photographer IS NOT NULL
        ");

        $sibuk = mysqli_fetch_assoc($qBusy)['sibuk'];
        $result[$jam] = ($total - $sibuk) >= $paket['jumlah_fotografer'];
    }

    echo json_encode($result);
    exit;
}

// ===== CREATE =====
if (isset($_POST['simpan'])) {

    $nama       = $_POST['nama'];
    $no_wa      = $_POST['no_wa'];
    $email      = $_POST['email'];
    $paket_data = $_POST['paket_qty'] ?? [];
    $tanggal    = $_POST['tanggal'];
    $jam        = $_POST['jam'];
    $jumlah     = $_POST['jumlah_orang'];

    // CEK METODE PEMBAYARAN
    if (!isset($_POST['metode_pembayaran'])) {
        $error = "Pilih metode pembayaran terlebih dahulu";
    } else {
        $metode_pembayaran = $_POST['metode_pembayaran'];
    }

    // FILTER PAKET
    $selected_packages = array_filter($paket_data, fn($q) => $q > 0);

    if (empty($selected_packages)) {
        $error = "Pilih minimal 1 paket!";
    }

    // LANJUT JIKA TIDAK ADA ERROR
    if (!isset($error)) {

        $total = 0;
        $butuh_fotografer = 'Tidak';
        $id_paket = array_key_first($selected_packages); // AMBIL 1 PAKET

        foreach ($selected_packages as $pid => $qty) {
            $q = mysqli_query($connection,"
                SELECT harga_paket, butuh_fotografer 
                FROM paket 
                WHERE id_paket='$pid'
            ");
            $row = mysqli_fetch_assoc($q);

            $total += $row['harga_paket'] * $qty;
            $butuh_fotografer = $row['butuh_fotografer'];
        }

        $tgl_jam = $tanggal . ' ' . $jam . ':00';
        $id_photographer = NULL;

        // JIKA BUTUH FOTOGRAFER
        if ($butuh_fotografer === 'Ya') {

            $qTotal = mysqli_query($connection,"SELECT COUNT(*) total FROM photographer");
            $totalFoto = mysqli_fetch_assoc($qTotal)['total'];

            $qCek = mysqli_query($connection,"
                SELECT COUNT(DISTINCT id_photographer) total
                FROM pemesanan
                WHERE tgl_pemesanan='$tgl_jam'
                AND status_pemesanan IN ('Proses','Selesai')
            ");

            $terpakai = mysqli_fetch_assoc($qCek)['total'];

            if ($terpakai >= $totalFoto) {
                $error = "Jam sudah penuh, silakan pilih jam lain";
            } else {
                $qCari = mysqli_query($connection,"
                    SELECT id_photographer FROM photographer
                    WHERE id_photographer NOT IN (
                        SELECT id_photographer FROM pemesanan
                        WHERE tgl_pemesanan='$tgl_jam'
                        AND status_pemesanan IN ('Proses','Selesai')
                    )
                    LIMIT 1
                ");

                if (mysqli_num_rows($qCari) == 0) {
                    $error = "Fotografer tidak tersedia";
                } else {
                    $id_photographer = mysqli_fetch_assoc($qCari)['id_photographer'];
                }
            }
        }

        // INSERT
        if (!isset($error)) {

            mysqli_query($connection, "
                INSERT INTO pemesanan (
                    id_customer,
                    tgl_pemesanan,
                    status_pemesanan,
                    ringkasan_biaya,
                    id_paket,
                    id_photographer,
                    metode_pembayaran
                ) VALUES (
                    '$id_customer',
                    '$tgl_jam',
                    'Proses',
                    '$total',
                    '$id_paket',
                    " . ($id_photographer ? "'$id_photographer'" : "NULL") . ",
                    '$metode_pembayaran'
                )
            ");

            $id_pemesanan = mysqli_insert_id($connection);
            header("Location: struk_pembayaran.php?id=$id_pemesanan");
            exit;
        }
    }
}



// ===== READ =====
$data = mysqli_query($connection, "
    SELECT p.*, pk.nama_paket
    FROM pemesanan p
    JOIN paket pk ON p.id_paket = pk.id_paket
    WHERE p.id_customer = '$id_customer'
    ORDER BY p.id_pemesanan DESC
");

// GET PAKET DATA - Group by category
$paket_list = mysqli_query($connection, "SELECT * FROM paket ORDER BY nama_paket ASC");
$paket_by_category = [];

while ($p = mysqli_fetch_assoc($paket_list)) {
    // Kategorisasi yang lebih spesifik
    if (stripos($p['nama_paket'], 'Cetak Foto') !== false) {
        $category = 'Cetak Foto';
    } elseif (stripos($p['nama_paket'], 'Studio') !== false) {
        $category = 'Studio Session';
    } elseif (stripos($p['nama_paket'], 'Prewedding') !== false) {
        $category = 'Prewedding';
    } elseif (stripos($p['nama_paket'], 'Engagement') !== false) {
        $category = 'Engagement';
    } elseif (stripos($p['nama_paket'], 'Richbooth') !== false) {
        $category = 'Richbooth';
    } elseif (stripos($p['nama_paket'], 'Photobox') !== false || stripos($p['nama_paket'], 'Pas Foto') !== false) {
        $category = 'Photobox & Pas Foto';
    } elseif (stripos($p['addon'], 'Ya') !== false || stripos($p['note'], 'ADD-ON') !== false) {
        $category = 'Add-On';
    } else {
        $category = 'Paket Lainnya';
    }
    
    $paket_by_category[$category][] = $p;
}

// Urutkan kategori - Add-On di paling akhir
$category_order = [
    'Cetak Foto',
    'Studio Session', 
    'Prewedding',
    'Engagement',
    'Richbooth',
    'Photobox & Pas Foto',
    'Paket Lainnya',
    'Add-On'
];

$sorted_categories = [];
foreach ($category_order as $cat) {
    if (isset($paket_by_category[$cat])) {
        $sorted_categories[$cat] = $paket_by_category[$cat];
    }
}
$paket_by_category = $sorted_categories;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Sekarang</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        html { overflow-y: scroll; }

        body {
            background: #f8fafc;
            font-family: Arial, sans-serif;
        }

        .page-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .form-card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
            margin-bottom: 30px;
        }

        .form-title {
            font-weight: 700;
            margin-bottom: 25px;
            font-size: 24px;
            color: #2d3748;
        }

        .section-title {
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 18px;
            color: #2d3748;
        }

        /* Category Accordion */
        .category-section {
            margin-bottom: 20px;
        }

        .category-header {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            transition: all 0.3s;
            user-select: none;
        }

        .category-header:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.4);
        }

        .category-header i.toggle {
            transition: transform 0.3s;
        }

        .category-header.active i.toggle {
            transform: rotate(180deg);
        }

        .category-content {
            display: none;
            padding: 20px 10px;
            border: 2px solid #e2e8f0;
            border-top: none;
            border-radius: 0 0 8px 8px;
            background: #f7fafc;
        }

        .category-content.active {
            display: block;
        }

        /* Package Cards */
        .package-card {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            background: #fff;
            transition: all 0.3s;
        }

        .package-card:hover {
            border-color: #48bb78;
        }

        .package-card.has-selection {
            border-color: #48bb78;
            background: #f0fff4;
        }

        .package-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .package-info {
            flex: 1;
        }

        .package-name {
            font-size: 18px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 6px;
        }

        .package-desc {
            font-size: 14px;
            color: #718096;
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .package-price {
            font-size: 22px;
            font-weight: 700;
            color: #38a169;
        }

        .package-note {
            font-size: 12px;
            color: #a0aec0;
            margin-top: 8px;
            font-style: italic;
        }

        /* Quantity Control */
        .qty-control {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 20px;
        }

        .qty-btn {
            width: 36px;
            height: 36px;
            border: 2px solid #48bb78;
            background: #fff;
            color: #38a169;
            border-radius: 6px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .qty-btn:hover:not(:disabled) {
            background: #48bb78;
            color: #fff;
        }

        .qty-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .qty-display {
            min-width: 50px;
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            color: #2d3748;
        }

        /* Selected Summary - MOVED BELOW */
        .selected-summary {
            background: #f0fff4;
            border: 2px solid #48bb78;
            border-radius: 12px;
            padding: 25px;
            margin-top: 30px;
            display: none;
        }

        .selected-summary.active {
            display: block;
        }

        .summary-title {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 20px;
            font-size: 20px;
        }

        .summary-grid {
            display: grid;
            gap: 15px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .summary-item-info {
            flex: 1;
        }

        .summary-item-name {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 4px;
        }

        .summary-item-price {
            font-size: 14px;
            color: #718096;
        }

        .summary-item-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .summary-qty-control {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f7fafc;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .summary-qty-btn {
            width: 28px;
            height: 28px;
            border: none;
            background: #48bb78;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .summary-qty-btn:hover {
            background: #38a169;
        }

        .summary-qty-num {
            min-width: 30px;
            text-align: center;
            font-weight: 700;
            color: #2d3748;
        }

        .summary-subtotal {
            font-weight: 700;
            color: #38a169;
            font-size: 18px;
            min-width: 120px;
            text-align: right;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            padding-top: 20px;
            border-top: 2px solid #48bb78;
            margin-top: 20px;
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
        }

        .summary-total-amount {
            color: #38a169;
        }

        .clear-all-btn {
            background: #fff;
            border: 2px solid #e53e3e;
            color: #e53e3e;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            margin-top: 15px;
            transition: all 0.2s;
        }

        .clear-all-btn:hover {
            background: #e53e3e;
            color: #fff;
        }

        .alert {
            border-radius: 8px;
        }

        .btn-success {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            border: none;
            transition: all 0.3s;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.4);
        }

        /* Calendar Styles */
        .calendar-wrapper {
            background: #fff;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-month-year {
            font-size: 18px;
            font-weight: 700;
            color: #2d3748;
        }

        .calendar-nav {
            width: 36px;
            height: 36px;
            border: 2px solid #48bb78;
            background: #fff;
            color: #38a169;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .calendar-nav:hover {
            background: #48bb78;
            color: #fff;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
        }

        .calendar-day-header {
            text-align: center;
            font-weight: 600;
            font-size: 13px;
            color: #718096;
            padding: 10px 0;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
        }

        .calendar-day.empty {
            cursor: default;
        }

        .calendar-day.past {
            color: #cbd5e0;
            cursor: not-allowed;
            background: #f7fafc;
        }

        .calendar-day.available {
            background: #f0fff4;
            color: #38a169;
            border-color: #c6f6d5;
        }

        .calendar-day.available:hover {
            background: #48bb78;
            color: #fff;
            transform: scale(1.05);
        }

        .calendar-day.booked {
            background: #fff5f5;
            color: #e53e3e;
            border-color: #feb2b2;
            cursor: not-allowed;
            position: relative;
        }

        .calendar-day.booked::after {
            content: '';
            position: absolute;
            width: 4px;
            height: 4px;
            background: #e53e3e;
            border-radius: 50%;
            bottom: 6px;
        }

        .calendar-day.selected {
            background: #48bb78;
            color: #fff;
            border-color: #38a169;
            transform: scale(1.05);
        }

        .calendar-legend {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #718096;
        }

        .legend-box {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid;
        }

        .legend-box.available {
            background: #f0fff4;
            border-color: #c6f6d5;
        }

        .legend-box.booked {
            background: #fff5f5;
            border-color: #feb2b2;
        }

        .legend-box.selected {
            background: #48bb78;
            border-color: #38a169;
        }

        .selected-date-display {
            background: #ebf8ff;
            border: 2px solid #4299e1;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            font-weight: 600;
            color: #2c5282;
            display: none;
        }

        .selected-date-display.active {
            display: block;
        }

        .booking-info-box {
            background: #fffaf0;
            border: 2px solid #fbd38d;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .booking-info-box h6 {
            font-size: 14px;
            font-weight: 700;
            color: #744210;
            margin-bottom: 10px;
        }

        .booking-info-box ul {
            margin: 0;
            padding-left: 20px;
        }

        .booking-info-box li {
            font-size: 13px;
            color: #744210;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="page-wrapper">

    <!-- Success Message -->
    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> Pesanan berhasil dibuat!
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <!-- Error Message -->
    <?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <?= $error ?>
    </div>
    <?php endif; ?>

    <h4 class="form-title"><i class="fas fa-camera"></i> Pesan Sekarang</h4>

    <form method="POST" id="pesanForm">
        
        <!-- Customer Info -->
        <div class="form-card">
            <h5 class="section-title"><i class="fas fa-user"></i> Data Pemesan</h5>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="col-md-6 form-group">
                    <label>No WhatsApp</label>
                    <input type="text" name="no_wa" class="form-control" placeholder="08xxxxxxxxxx" required>
                </div>

                <div class="col-md-12 form-group mb-0">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
                </div>
            </div>
        </div>

        <!-- Package Selection -->
        <div class="form-card">
            <h5 class="section-title"><i class="fas fa-box"></i> Pilih Paket</h5>
            
            <?php foreach ($paket_by_category as $category => $packages): ?>
            <div class="category-section">
                <div class="category-header" onclick="toggleCategory(this)">
                    <span>
                        <i class="fas fa-folder-open"></i> <?= $category ?>
                        <span class="badge badge-light ml-2"><?= count($packages) ?> paket</span>
                    </span>
                    <i class="fas fa-chevron-down toggle"></i>
                </div>
                
                <div class="category-content">
                    <?php foreach ($packages as $p): ?>
                    <div class="package-card" id="card_<?= $p['id_paket'] ?>">
                        <div class="package-header">
                            <div class="package-info">
                                <div class="package-name">
                                    <?= $p['nama_paket'] ?>
                                </div>
                                
                                <div class="package-desc">
                                    <?= nl2br($p['deskripsi']) ?>
                                </div>
                                
                                <div class="package-price">
                                    Rp <?= number_format($p['harga_paket'], 0, ',', '.') ?>
                                </div>
                                
                                <?php if (!empty($p['note'])): ?>
                                <div class="package-note">
                                    <i class="fas fa-info-circle"></i> <?= $p['note'] ?>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="qty-control">
                                <button type="button" class="qty-btn" onclick="changeQty('<?= $p['id_paket'] ?>', -1)">−</button>
                                <div class="qty-display" id="qty_display_<?= $p['id_paket'] ?>">0</div>
                                <button type="button" class="qty-btn" onclick="changeQty('<?= $p['id_paket'] ?>', 1)">+</button>
                            </div>
                        </div>

                        <input type="hidden" 
                               name="paket_qty[<?= $p['id_paket'] ?>]" 
                               id="qty_<?= $p['id_paket'] ?>"
                               value="0"
                               data-name="<?= htmlspecialchars($p['nama_paket']) ?>"
                               data-price="<?= $p['harga_paket'] ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- SUMMARY MOVED HERE - BELOW PACKAGES -->
            <div class="selected-summary" id="selectedSummary">
                <div class="summary-title">
                    <i class="fas fa-shopping-cart"></i> Paket yang Dipilih
                </div>
                <div class="summary-grid" id="summaryList"></div>
                <div class="summary-total">
                    <span>Total Pembayaran</span>
                    <span class="summary-total-amount" id="totalPrice">Rp 0</span>
                </div>
                <button type="button" class="clear-all-btn" onclick="clearAll()">
                    <i class="fas fa-trash"></i> Hapus Semua Pesanan
                </button>
            </div>
        </div>

        <!-- Order Details -->
        <div class="form-card">
            <h5 class="section-title"><i class="fas fa-calendar-alt"></i> Detail Pemotretan</h5>
            
            <div class="row">
                <!-- CALENDAR SECTION -->
                <div class="col-md-7">
                    <label class="d-block mb-3"><strong>Pilih Tanggal Pemotretan</strong></label>
                    
                    <div class="calendar-wrapper">
                        <div class="calendar-header">
                            <button type="button" class="calendar-nav" onclick="changeMonth(-1)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <div class="calendar-month-year" id="monthYear"></div>
                            <button type="button" class="calendar-nav" onclick="changeMonth(1)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        
                        <div class="calendar-grid" id="calendarGrid"></div>
                        
                        <div class="calendar-legend">
                            <div class="legend-item">
                                <span class="legend-box available"></span>
                                <span>Tersedia</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-box booked"></span>
                                <span>Sudah Dipesan</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-box selected"></span>
                                <span>Dipilih</span>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="tanggal" id="tanggalInput" required>
                    <div id="selectedDateDisplay" class="selected-date-display"></div>
                </div>

                <!-- TIME & PEOPLE SECTION -->
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Jam Pemotretan</label>
                        <select name="jam" class="form-control" required>
                            <option value="">-- Pilih Jam --</option>
                            <option value="08:00">08:00 WIB</option>
                            <option value="09:00">09:00 WIB</option>
                            <option value="10:00">10:00 WIB</option>
                            <option value="11:00">11:00 WIB</option>
                            <option value="13:00">13:00 WIB</option>
                            <option value="14:00">14:00 WIB</option>
                            <option value="15:00">15:00 WIB</option>
                            <option value="16:00">16:00 WIB</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Orang</label>
                        <input type="number" name="jumlah_orang" class="form-control" min="1" value="1" required>
                    </div>

                    <div class="booking-info-box">
                        <h6><i class="fas fa-info-circle"></i> Informasi Booking</h6>
                        <ul>
                            <li>Pilih tanggal yang <strong>berwarna hijau</strong></li>
                            <li>Tanggal <strong>merah</strong> sudah penuh</li>
                            <li>Konfirmasi booking via WhatsApp setelah pesan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- ===== METODE PEMBAYARAN ===== -->
    <h5 class="section-title">
        <i class="fas fa-credit-card"></i> Metode Pembayaran
    </h5>

    <div class="form-group">
        <div class="custom-control custom-radio mb-2">
            <input type="radio" id="payCash" name="metode_pembayaran" value="Cash" 
                   class="custom-control-input" required>
            <label class="custom-control-label" for="payCash">
                💵 Bayar di Tempat (Cash)
            </label>
        </div>

        <div class="custom-control custom-radio">
            <input type="radio" id="payQris" name="metode_pembayaran" value="QRIS" 
                   class="custom-control-input" required>
            <label class="custom-control-label" for="payQris">
                📱 QRIS (Scan Pembayaran)
            </label>
        </div>
    </div>

            <button type="submit" name="simpan" class="btn btn-success px-5 btn-lg mt-3">
                <i class="fas fa-check-circle"></i> Pesan Sekarang
            </button>
        </div>

    

        
    </form>

    <!-- ===== DATA PESANAN ===== -->
    <h4 class="form-title mt-5"><i class="fas fa-list"></i> Pesanan Saya</h4>

    <div class="table-responsive">
        <table class="table table-bordered bg-white">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Paket</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (mysqli_num_rows($data) > 0) {
                    while ($row = mysqli_fetch_assoc($data)) {
                        $statusClass = '';
                        switch($row['status_pemesanan']) {
                            case 'Proses': $statusClass = 'badge-warning'; break;
                            case 'Selesai': $statusClass = 'badge-success'; break;
                            case 'Batal': $statusClass = 'badge-danger'; break;
                            default: $statusClass = 'badge-secondary';
                        }
                        
                        echo "
                        <tr>
                            <td>{$no}</td>
                            <td>{$row['tgl_pemesanan']}</td>
                            <td>{$row['nama_paket']}</td>
                            <td>Rp " . number_format($row['ringkasan_biaya'], 0, ',', '.') . "</td>
                            <td><span class='badge {$statusClass}'>{$row['status_pemesanan']}</span></td>
                        </tr>
                        ";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center text-muted py-4'>
                            <i class='fas fa-inbox fa-2x mb-2 d-block'></i>
                            Belum ada pesanan
                          </td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
const jamSelect = document.querySelector('select[name="jam"]');

function loadJam() {
    const tanggal = document.getElementById('tanggalInput').value;
    const paket   = document.querySelector('input[name^="paket_qty"][value!="0"]');

    if (!tanggal || !paket) return;

    fetch(`pesan_sekarang.php?ajax=cek_jam&tanggal=${tanggal}&paket=${paket.id.replace('qty_','')}`)
    .then(res => res.json())
    .then(data => {
        [...jamSelect.options].forEach(opt => {
            if (!opt.value) return;
            opt.disabled = !data[opt.value];
        });
    });
}



/* =========================
   GLOBAL
========================= */
let currentMonth = new Date().getMonth();
let currentYear  = new Date().getFullYear();
let selectedDate = null;

const monthNames = [
  'Januari','Februari','Maret','April','Mei','Juni',
  'Juli','Agustus','September','Oktober','November','Desember'
];
const dayNames = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];

/* =========================
   UTIL
========================= */
function formatDate(date) {
  const y = date.getFullYear();
  const m = String(date.getMonth()+1).padStart(2,'0');
  const d = String(date.getDate()).padStart(2,'0');
  return `${y}-${m}-${d}`;
}

/* =========================
   CALENDAR
========================= */
function renderCalendar() {
  const monthYearEl = document.getElementById('monthYear');
  const calendarGrid = document.getElementById('calendarGrid');

  monthYearEl.textContent = `${monthNames[currentMonth]} ${currentYear}`;
  calendarGrid.innerHTML = '';

  // header hari
  dayNames.forEach(d => {
    const h = document.createElement('div');
    h.className = 'calendar-day-header';
    h.textContent = d;
    calendarGrid.appendChild(h);
  });

  const firstDay = new Date(currentYear, currentMonth, 1).getDay();
  const daysInMonth = new Date(currentYear, currentMonth+1, 0).getDate();
  const today = new Date(); today.setHours(0,0,0,0);

  // padding awal
  for (let i=0;i<firstDay;i++) {
    const e = document.createElement('div');
    e.className = 'calendar-day empty';
    calendarGrid.appendChild(e);
  }

  // tanggal
  for (let d=1; d<=daysInMonth; d++) {
    const dateObj = new Date(currentYear,currentMonth,d);
    const dateStr = formatDate(dateObj);

    const el = document.createElement('div');
    el.className = 'calendar-day';
    el.textContent = d;

    if (dateObj < today) {
      el.classList.add('past');
    } else {
      el.classList.add('available');
      el.onclick = () => selectDate(dateStr, el);
    }

    if (selectedDate === dateStr) {
      el.classList.add('selected');
    }

    calendarGrid.appendChild(el);
  }
}

function selectDate(dateStr, el) {
  document.querySelectorAll('.calendar-day.selected').forEach(e=>{
    e.classList.remove('selected');
    e.classList.add('available');
  });

  el.classList.remove('available');
  el.classList.add('selected');

  selectedDate = dateStr;
  document.getElementById('tanggalInput').value = dateStr;

  loadJam(); // 🔥 INI KUNCI
}



function changeMonth(delta) {
  currentMonth += delta;
  if (currentMonth < 0) { currentMonth=11; currentYear--; }
  if (currentMonth > 11){ currentMonth=0; currentYear++; }
  renderCalendar();
}

/* =========================
   INIT
========================= */
document.addEventListener('DOMContentLoaded', () => {
  renderCalendar();
});


// ===== PACKAGE SELECTION FUNCTIONS =====
// Toggle category accordion
function toggleCategory(header) {
    const content = header.nextElementSibling;
    header.classList.toggle('active');
    content.classList.toggle('active');
}

// Change quantity from card
function changeQty(paketId, delta) {
    const qtyInput = document.getElementById('qty_' + paketId);
    const qtyDisplay = document.getElementById('qty_display_' + paketId);
    const card = document.getElementById('card_' + paketId);
    
    let currentQty = parseInt(qtyInput.value) || 0;
    let newQty = Math.max(0, currentQty + delta);
    
    qtyInput.value = newQty;
    qtyDisplay.textContent = newQty;
    
    if (newQty > 0) {
        card.classList.add('has-selection');
    } else {
        card.classList.remove('has-selection');
    }
    
    updateSummary();
}

// Change quantity from summary
function changeSummaryQty(paketId, delta) {
    changeQty(paketId, delta);
    loadJam();
}

// Update summary
function updateSummary() {
    const qtyInputs = document.querySelectorAll('input[name^="paket_qty"]');
    const summary = document.getElementById('selectedSummary');
    const summaryList = document.getElementById('summaryList');
    const totalPrice = document.getElementById('totalPrice');
    
    let total = 0;
    let html = '';
    let hasSelection = false;
    
    qtyInputs.forEach(input => {
        const qty = parseInt(input.value) || 0;
        if (qty > 0) {
            hasSelection = true;
            const paketId = input.id.replace('qty_', '');
            const name = input.dataset.name;
            const price = parseInt(input.dataset.price);
            const subtotal = price * qty;
            total += subtotal;
            
            html += `
                <div class="summary-item">
                    <div class="summary-item-info">
                        <div class="summary-item-name">${name}</div>
                        <div class="summary-item-price">Rp ${price.toLocaleString('id-ID')} × ${qty}</div>
                    </div>
                    <div class="summary-item-controls">
                        <div class="summary-qty-control">
                            <button type="button" class="summary-qty-btn" onclick="changeSummaryQty('${paketId}', -1)">−</button>
                            <span class="summary-qty-num">${qty}</span>
                            <button type="button" class="summary-qty-btn" onclick="changeSummaryQty('${paketId}', 1)">+</button>
                        </div>
                        <div class="summary-subtotal">Rp ${subtotal.toLocaleString('id-ID')}</div>
                    </div>
                </div>
            `;
        }
    });
    
    if (hasSelection) {
        summary.classList.add('active');
        summaryList.innerHTML = html;
        totalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
    } else {
        summary.classList.remove('active');
    }
}

// Clear all
function clearAll() {
    if (!confirm('Hapus semua pesanan?')) return;
    
    const qtyInputs = document.querySelectorAll('input[name^="paket_qty"]');
    qtyInputs.forEach(input => {
        const paketId = input.id.replace('qty_', '');
        input.value = 0;
        document.getElementById('qty_display_' + paketId).textContent = '0';
        document.getElementById('card_' + paketId).classList.remove('has-selection');
    });
    updateSummary();
}


// Form validation
document.getElementById('pesanForm').addEventListener('submit', function(e) {
    const qtyInputs = document.querySelectorAll('input[name^="paket_qty"]');
    let hasSelection = false;
    
    qtyInputs.forEach(input => {
        if (parseInt(input.value) > 0) {
            hasSelection = true;
        }
    });
    
    if (!hasSelection) {
        e.preventDefault();
        alert('Pilih minimal 1 paket!');
        document.querySelector('.category-section').scrollIntoView({ behavior: 'smooth' });
        return;
    }
    
    // Check if date is selected
    const tanggalInput = document.getElementById('tanggalInput');
    if (!tanggalInput.value) {
        e.preventDefault();
        alert('Pilih tanggal pemotretan terlebih dahulu!');
        document.querySelector('.calendar-wrapper').scrollIntoView({ behavior: 'smooth' });
    }
});
</script>

</body>
</html>