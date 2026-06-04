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

    $data['status_pemesanan'] = 'Dibatalkan';
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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

        /* =====================
           UPLOAD SECTION STYLES
           ===================== */
        .upload-section {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin-top: 6px;
        }

        /* Instruksi */
        .upload-instruction {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 16px;
        }
        .upload-instruction-icon {
            font-size: 20px;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .upload-instruction-title {
            font-size: 13px;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 2px;
        }
        .upload-instruction p {
            font-size: 13px;
            color: #78350f;
            margin: 0;
            line-height: 1.5;
        }

        /* Error alert */
        .upload-alert-error {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 13px;
            font-weight: 600;
            color: #dc2626;
            margin-bottom: 14px;
        }

        /* Dropzone */
        .upload-dropzone {
            position: relative;
            border: 2px dashed #d1d5db;
            border-radius: 14px;
            padding: 28px 20px 22px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            background: #fafafa;
            overflow: hidden;
        }
        .upload-dropzone:hover,
        .upload-dropzone.drag-over {
            border-color: #22c55e;
            background: #f0fdf4;
        }
        .upload-dropzone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }
        .dz-icon {
            width: 52px;
            height: 52px;
            background: #f0fdf4;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 24px;
            border: 1px solid #bbf7d0;
            transition: transform 0.2s;
        }
        .upload-dropzone:hover .dz-icon { transform: scale(1.08); }
        .dz-main {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 3px;
        }
        .dz-sub {
            font-size: 12px;
            color: #9ca3af;
        }
        .dz-preview {
            display: none;
            margin-top: 14px;
        }
        .dz-preview img {
            max-width: 100%;
            max-height: 180px;
            border-radius: 10px;
            object-fit: contain;
            border: 1px solid #e5e7eb;
        }
        .dz-preview-name {
            font-size: 12px;
            font-weight: 600;
            color: #16a34a;
            margin-top: 8px;
        }

        /* Submit button */
        .btn-kirim-bukti {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            margin-top: 12px;
            padding: 13px 20px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            letter-spacing: 0.1px;
        }
        .btn-kirim-bukti:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-kirim-bukti:active { transform: translateY(0); }

        /* Bukti sudah terkirim */
        .bukti-sent-card {
            border: 1.5px solid #bbf7d0;
            border-radius: 14px;
            overflow: hidden;
            margin-top: 6px;
        }
        .bukti-sent-header {
            background: #f0fdf4;
            padding: 13px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .bukti-sent-check {
            width: 34px;
            height: 34px;
            background: #16a34a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            flex-shrink: 0;
        }
        .bukti-sent-title {
            font-size: 14px;
            font-weight: 700;
            color: #15803d;
            margin: 0 0 2px;
        }
        .bukti-sent-sub {
            font-size: 12px;
            color: #4b7c5a;
            margin: 0;
        }
        .bukti-sent-body {
            padding: 14px 16px;
            background: white;
        }
        .bukti-sent-body img {
            width: 100%;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            display: block;
        }
        .bukti-sent-time {
            font-size: 12px;
            color: #9ca3af;
            text-align: right;
            margin-top: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
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
     SECTION PEMBAYARAN
======================= -->

<?php if ($data['metode_pembayaran'] === 'QRIS'): ?>

    <?php if ($data['status_pemesanan'] === 'Menunggu Pembayaran'): ?>
    <div class="qris-box">
        <h6>⏳ Selesaikan Pembayaran Dalam</h6>
        <h4 id="countdown" style="color:red;"></h4>

        <p>Scan QRIS di bawah ini:</p>
        <img src="../assets/img/Qris.jpeg" alt="QRIS">
    </div>

    <div class="divider"></div>

    <!-- UPLOAD SECTION -->
    <?php if (!empty($data['bukti_pembayaran'])): ?>

        <!-- Bukti sudah dikirim -->
        <div class="bukti-sent-card">
            <div class="bukti-sent-header">
                <div class="bukti-sent-check">✓</div>
                <div>
                    <p class="bukti-sent-title">Bukti Pembayaran Terkirim</p>
                    <p class="bukti-sent-sub">Menunggu konfirmasi dari Customer Service</p>
                </div>
            </div>
            <div class="bukti-sent-body">
                <a href="../assets/img/bukti/<?= htmlspecialchars($data['bukti_pembayaran']) ?>" target="_blank">
                    <img src="../assets/img/bukti/<?= htmlspecialchars($data['bukti_pembayaran']) ?>" alt="Bukti Pembayaran">
                </a>
                <p class="bukti-sent-time">
                    🕐 Diupload: <?= date('d M Y, H:i', strtotime($data['tgl_upload_bukti'])) ?>
                </p>
            </div>
        </div>
        <p style="font-size:12px;color:#9ca3af;text-align:center;margin-top:10px;font-family:'Plus Jakarta Sans',sans-serif;">
            Ada kendala? Hubungi Customer Service di bawah.
        </p>

    <?php else: ?>

        <!-- Form upload -->
        <div class="upload-section">

            <div class="upload-instruction">
                <div class="upload-instruction-icon">📋</div>
                <div>
                    <p class="upload-instruction-title">Langkah selanjutnya</p>
                    <p>Setelah melakukan pembayaran via QRIS, upload bukti transfer di bawah agar pesananmu segera diproses.</p>
                </div>
            </div>

            <?php if (isset($_GET['upload_error'])): ?>
                <div class="upload-alert-error">
                    ⚠️ <?= htmlspecialchars($_GET['upload_error']) ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['upload_success'])): ?>
                <div class="alert alert-success">✅ Bukti berhasil dikirim! Halaman akan diperbarui...</div>
                <script>setTimeout(() => location.reload(), 1500);</script>
            <?php endif; ?>

            <form action="upload_bukti.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_pemesanan" value="<?= $data['id_pemesanan'] ?>">

                <div class="upload-dropzone" id="dropzone">
                    <input type="file" name="bukti_pembayaran" id="fileInput"
                           accept="image/jpeg,image/png,image/jpg" required>
                    <div class="dz-icon" id="dzIcon">📷</div>
                    <p class="dz-main" id="dzMain">Pilih atau drag foto bukti bayar</p>
                    <p class="dz-sub" id="dzSub">JPG / PNG &middot; Maks. 2MB</p>
                    <div class="dz-preview" id="previewWrap">
                        <img id="previewImg" src="" alt="Preview">
                        <p class="dz-preview-name" id="previewName"></p>
                    </div>
                </div>

                <button type="submit" class="btn-kirim-bukti">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Kirim Bukti Pembayaran
                </button>
            </form>
        </div>

    <?php endif; ?>


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



<div class="mt-4">
    <a href="https://wa.me/6285159822523"
       target="_blank"
       class="btn btn-success btn-block mb-2">
        💬 Chat WhatsApp Customer Service
    </a>

    <a href="riwayat_transaksi.php"
       class="btn btn-outline-secondary btn-block">
        ⬅️ Kembali ke Riwayat Transaksi
    </a>
</div>

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

// File preview & drag drop
const fileInput = document.getElementById('fileInput');
const previewWrap = document.getElementById('previewWrap');
const previewImg = document.getElementById('previewImg');
const previewName = document.getElementById('previewName');
const dzIcon = document.getElementById('dzIcon');
const dzMain = document.getElementById('dzMain');
const dzSub = document.getElementById('dzSub');
const dropzone = document.getElementById('dropzone');

function showPreview(file) {
    const reader = new FileReader();
    reader.onload = e => {
        previewImg.src = e.target.result;
        previewName.textContent = '✓ ' + file.name;
        previewWrap.style.display = 'block';
        dzIcon.style.display = 'none';
        dzMain.style.display = 'none';
        dzSub.style.display = 'none';
    };
    reader.readAsDataURL(file);
}

fileInput.addEventListener('change', function() {
    if (this.files[0]) showPreview(this.files[0]);
});

dropzone.addEventListener('dragover', e => { e.preventDefault(); dropzone.classList.add('drag-over'); });
dropzone.addEventListener('dragleave', () => dropzone.classList.remove('drag-over'));
dropzone.addEventListener('drop', e => {
    e.preventDefault();
    dropzone.classList.remove('drag-over');
    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        showPreview(e.dataTransfer.files[0]);
    }
});
</script>
<?php endif; ?>


</body>
</html>