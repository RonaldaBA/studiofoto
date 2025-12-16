<?php
include "../helper/auth.php";
include "../helper/connection.php";
isLogin();

/* =============================
   SESSION
============================= */
$id_customer = $_SESSION['id_customer'] ?? null;
if (!$id_customer) {
    header("Location: ../login.php");
    exit();
}

/* =============================
   BULAN INDONESIA
============================= */
$bulan = [
    1=>'Januari','Februari','Maret','April','Mei','Juni',
    'Juli','Agustus','September','Oktober','November','Desember'
];

/* =============================
   DOWNLOAD ZIP
============================= */
if (isset($_POST['download_zip']) && !empty($_POST['photos'])) {
    $zip = new ZipArchive();
    $zipName = "foto_pesanan_" . time() . ".zip";
    $zip->open($zipName, ZipArchive::CREATE);

    foreach ($_POST['photos'] as $file) {
        $path = "../assets/img/data/" . basename($file);
        if (file_exists($path)) {
            $zip->addFile($path, basename($file));
        }
    }

    $zip->close();
    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=$zipName");
    readfile($zipName);
    unlink($zipName);
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Galeri Foto Saya</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
body{background:#f8fafc}
.gallery-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
    gap:20px;
    margin-top:20px
}
.card-box{
    background:#fff;
    border-radius:12px;
    padding:16px;
    box-shadow:0 6px 16px rgba(0,0,0,.08);
    transition:transform .2s
}
.card-box:hover{transform:translateY(-4px)}

/* Photo Grid Item */
.photo-item{
    position:relative;
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 4px 12px rgba(0,0,0,.1);
    transition:transform .3s, box-shadow .3s
}
.photo-item:hover{
    transform:translateY(-5px);
    box-shadow:0 8px 24px rgba(0,0,0,.15)
}
.photo-item img{
    width:100%;
    height:280px;
    object-fit:cover;
    cursor:pointer;
    display:block
}

/* Checkbox Overlay */
.photo-checkbox{
    position:absolute;
    top:12px;
    right:12px;
    z-index:2
}
.photo-checkbox input[type="checkbox"]{
    width:24px;
    height:24px;
    cursor:pointer;
    accent-color:#007bff
}

/* Photo Actions */
.photo-actions{
    padding:12px;
    background:#fff;
    border-top:1px solid #eee
}
.photo-actions a{
    display:block;
    text-align:center;
    padding:8px;
    background:#007bff;
    color:#fff;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
    transition:background .2s
}
.photo-actions a:hover{
    background:#0056b3;
    color:#fff
}

/* Modal Lightbox */
.lightbox-modal{
    display:none;
    position:fixed;
    z-index:9999;
    left:0;
    top:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.95);
    overflow:auto
}
.lightbox-content{
    position:relative;
    margin:auto;
    padding:20px;
    max-width:90%;
    max-height:90vh;
    display:flex;
    align-items:center;
    justify-content:center;
    height:100vh
}
.lightbox-content img{
    max-width:100%;
    max-height:85vh;
    object-fit:contain;
    border-radius:8px
}
.close-lightbox{
    position:absolute;
    top:20px;
    right:40px;
    color:#fff;
    font-size:40px;
    font-weight:bold;
    cursor:pointer;
    z-index:10000;
    transition:color .2s
}
.close-lightbox:hover{color:#ccc}

/* Navigation Arrows */
.lightbox-nav{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    background:rgba(255,255,255,.2);
    color:#fff;
    font-size:40px;
    padding:20px 15px;
    cursor:pointer;
    user-select:none;
    border-radius:6px;
    transition:background .2s;
    z-index:10001
}
.lightbox-nav:hover{
    background:rgba(255,255,255,.4)
}
.lightbox-prev{left:20px}
.lightbox-next{right:20px}

/* Photo Counter */
.photo-counter{
    position:absolute;
    top:20px;
    left:50%;
    transform:translateX(-50%);
    background:rgba(0,0,0,.7);
    color:#fff;
    padding:8px 20px;
    border-radius:20px;
    font-size:14px;
    font-weight:600;
    z-index:10000
}

/* Download Bar */
.download-bar{
    position:fixed;
    bottom:0;
    left:0;
    right:0;
    background:#fff;
    padding:15px 20px;
    box-shadow:0 -4px 12px rgba(0,0,0,.1);
    display:none;
    align-items:center;
    justify-content:space-between;
    z-index:1000;
    border-top:3px solid #007bff
}
.download-bar.active{display:flex}
.download-bar .info{
    font-weight:600;
    color:#333
}
.download-bar button{
    padding:10px 30px;
    border:none;
    border-radius:6px;
    background:#28a745;
    color:#fff;
    font-weight:600;
    cursor:pointer;
    transition:background .2s
}
.download-bar button:hover{background:#218838}
.download-bar button:disabled{
    background:#ccc;
    cursor:not-allowed
}

/* Select All Button */
.select-controls{
    display:flex;
    gap:10px;
    margin-bottom:15px
}
.select-controls button{
    padding:8px 16px;
    border:1px solid #007bff;
    background:#fff;
    color:#007bff;
    border-radius:6px;
    cursor:pointer;
    transition:all .2s;
    font-size:14px
}
.select-controls button:hover{
    background:#007bff;
    color:#fff
}
</style>
</head>

<body>
<?php include "navbar.php"; ?>

<div class="container mt-5">

<h2>Galeri Foto Saya</h2>
<p>Semua hasil foto Anda</p>

<?php
/* =========================================================
   MODE 2 — ISI FOLDER (JIKA ADA ?id=)
========================================================= */
if (isset($_GET['id'])):
$id_pemesanan = $_GET['id'];

$query = "
    SELECT file_name
    FROM gallery
    WHERE id_pemesanan = ?
";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $id_pemesanan);
$stmt->execute();
$fotos = $stmt->get_result();
?>

<a href="galeri.php" class="btn btn-secondary btn-sm mb-3">
    <i class="fas fa-arrow-left"></i> Kembali
</a>

<div class="select-controls">
    <button type="button" id="selectAll">Pilih Semua</button>
    <button type="button" id="deselectAll">Batal Pilih</button>
</div>

<form method="post" id="downloadForm">
<div class="gallery-grid">
<?php while ($f = $fotos->fetch_assoc()): ?>
    <div class="photo-item">
        <div class="photo-checkbox">
            <input type="checkbox" name="photos[]" value="<?= $f['file_name'] ?>" class="photo-check">
        </div>
        <img src="../assets/img/data/<?= $f['file_name'] ?>" 
             onclick="openLightbox(this.src)" 
             alt="Foto">
        <div class="photo-actions">
            <a href="../assets/img/data/<?= $f['file_name'] ?>" download>
                <i class="fas fa-download"></i> Download
            </a>
        </div>
    </div>
<?php endwhile; ?>
</div>

<div class="download-bar" id="downloadBar">
    <div class="info">
        <span id="selectedCount">0</span> foto dipilih
    </div>
    <button type="submit" name="download_zip" id="downloadZipBtn">
        <i class="fas fa-file-archive"></i> Download ZIP
    </button>
</div>
</form>

<!-- Lightbox Modal -->
<div id="lightboxModal" class="lightbox-modal">
    <span class="close-lightbox" onclick="closeLightbox()">&times;</span>
    <div class="photo-counter" id="photoCounter"></div>
    <div class="lightbox-nav lightbox-prev" onclick="navigatePhoto(-1)">&#10094;</div>
    <div class="lightbox-nav lightbox-next" onclick="navigatePhoto(1)">&#10095;</div>
    <div class="lightbox-content" onclick="event.stopPropagation()">
        <img id="lightboxImg" src="">
    </div>
</div>

<script>
// Get all photo sources
let allPhotos = [];
let currentPhotoIndex = 0;

// Initialize photos array
function initPhotos() {
    const photoImages = document.querySelectorAll('.photo-item img');
    allPhotos = Array.from(photoImages).map(img => img.src);
}

// Lightbox Functions
function openLightbox(src) {
    initPhotos();
    currentPhotoIndex = allPhotos.indexOf(src);
    showPhoto(currentPhotoIndex);
    document.getElementById('lightboxModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightboxModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function showPhoto(index) {
    document.getElementById('lightboxImg').src = allPhotos[index];
    document.getElementById('photoCounter').textContent = `${index + 1} / ${allPhotos.length}`;
}

function navigatePhoto(direction) {
    currentPhotoIndex += direction;
    
    // Loop around
    if (currentPhotoIndex >= allPhotos.length) {
        currentPhotoIndex = 0;
    } else if (currentPhotoIndex < 0) {
        currentPhotoIndex = allPhotos.length - 1;
    }
    
    showPhoto(currentPhotoIndex);
}

// Checkbox Management
const checkboxes = document.querySelectorAll('.photo-check');
const downloadBar = document.getElementById('downloadBar');
const selectedCount = document.getElementById('selectedCount');
const downloadBtn = document.getElementById('downloadZipBtn');

function updateDownloadBar() {
    const checked = document.querySelectorAll('.photo-check:checked').length;
    selectedCount.textContent = checked;
    
    if (checked > 0) {
        downloadBar.classList.add('active');
        downloadBtn.disabled = false;
    } else {
        downloadBar.classList.remove('active');
        downloadBtn.disabled = true;
    }
}

checkboxes.forEach(cb => {
    cb.addEventListener('change', updateDownloadBar);
});

// Select/Deselect All
document.getElementById('selectAll').addEventListener('click', () => {
    checkboxes.forEach(cb => cb.checked = true);
    updateDownloadBar();
});

document.getElementById('deselectAll').addEventListener('click', () => {
    checkboxes.forEach(cb => cb.checked = false);
    updateDownloadBar();
});

// Keyboard navigation
document.addEventListener('keydown', (e) => {
    const modal = document.getElementById('lightboxModal');
    if (modal.style.display === 'block') {
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowRight') {
            navigatePhoto(1);
        } else if (e.key === 'ArrowLeft') {
            navigatePhoto(-1);
        }
    }
});

// Click outside to close
document.getElementById('lightboxModal').addEventListener('click', (e) => {
    if (e.target.id === 'lightboxModal') {
        closeLightbox();
    }
});
</script>

<?php
/* =========================================================
   MODE 1 — LIST PESANAN (DEFAULT)
========================================================= */
else:

$query = "
    SELECT 
        p.id_pemesanan,
        p.tgl_pemesanan,
        pk.nama_paket,
        COUNT(g.id_photo) total_foto
    FROM pemesanan p
    JOIN gallery g ON g.id_pemesanan = p.id_pemesanan
    JOIN paket pk ON p.id_paket = pk.id_paket
    WHERE p.id_customer = ?
      AND p.status_pemesanan = 'Selesai'
    GROUP BY p.id_pemesanan
    ORDER BY p.tgl_pemesanan DESC
";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $id_customer);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="gallery-grid">
<?php while ($row = $result->fetch_assoc()):
    $tgl = strtotime($row['tgl_pemesanan']);
?>
<div class="card-box">
    <h5><i class="fas fa-folder"></i> Pesanan <?= $row['id_pemesanan'] ?></h5>
    <p><strong><?= $row['nama_paket'] ?></strong></p>
    <small>
        <i class="far fa-calendar"></i> <?= date('d',$tgl).' '.$bulan[(int)date('m',$tgl)].' '.date('Y',$tgl) ?><br>
        <i class="far fa-images"></i> <?= $row['total_foto'] ?> Foto
    </small>
    <br>
    <a href="galeri.php?id=<?= $row['id_pemesanan'] ?>" class="btn btn-primary btn-sm mt-3">
        <i class="fas fa-eye"></i> Lihat Foto
    </a>
</div>
<?php endwhile; ?>
</div>

<?php endif; ?>

</div>
</body>
</html>