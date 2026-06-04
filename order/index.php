<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$result = mysqli_query($connection, "
    SELECT 
        p.id_pemesanan,
        p.tgl_pemesanan,
        p.status_pemesanan,
        p.ringkasan_biaya,
        p.id_customer,
        p.metode_pembayaran,
        p.bukti_pembayaran,
        c.nama,
        p.id_paket,
        pk.nama_paket
    FROM pemesanan p
    JOIN customer c ON p.id_customer = c.id_customer
    JOIN paket pk ON p.id_paket = pk.id_paket
");

$bulan = [
    1 => 'Januari', 'Februari', 'Maret', 'April',
    'Mei', 'Juni', 'Juli', 'Agustus',
    'September', 'Oktober', 'November', 'Desember'
];
?>

<style>
/* ===== TABLE UI (SELARAS HOME & DASHBOARD) ===== */

.section-header h1 {
  font-weight: 700;
  color: #1f2937;
}

/* CARD */
.card {
  border-radius: 18px;
  border: none;
  box-shadow: 0 12px 25px rgba(0,0,0,0.06);
}

/* TABLE */
.table thead th {
  background: #f9fafb;
  font-size: 13px;
  font-weight: 700;
  color: #374151;
  border-bottom: none;
}

.table tbody td {
  font-size: 14px;
  vertical-align: middle;
}

/* PRICE */
.price-text {
  font-weight: 700;
  color: #16a34a;
}

/* STATUS BADGE */
.badge-pill {
  font-size: 12px;
  padding: 6px 14px;
}

/* BUTTON */
.btn-icon {
  border-radius: 999px;
  padding: 6px 10px;
}

/* ICON COLOR */
.icon-green { color: #16a34a; }
.icon-blue  { color: #2563eb; }
.icon-red   { color: #dc2626; }
</style>

<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>
      <i class="fas fa-clipboard-list icon-green mr-2"></i>
      Daftar Pesanan
    </h1>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="table-responsive">
            <table class="table table-hover w-100" id="table-1">
              <thead>
                <tr>
                  <th>ID Pemesanan</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                  <th>Biaya</th>
                  <th>ID Customer</th>
                  <th>Nama Customer</th>
                  <th>ID Paket</th>
                  <th>Nama Paket</th>
                  <th>Bukti Pembayaran</th>
                  <th style="width: 150">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($data = mysqli_fetch_array($result)) :
                ?>

                  <tr>
                    <td><?= $data['id_pemesanan'] ?></td>
                    <?php
                      $tanggal = strtotime($data['tgl_pemesanan']);
                      $hari = date('d', $tanggal);
                      $bulanIndo = $bulan[(int)date('m', $tanggal)];
                      $tahun = date('Y', $tanggal);
                    ?>
                    <td><?= $hari . ' ' . $bulanIndo . ' ' . $tahun ?></td>
                    <td>
                      <?php if ($data['status_pemesanan'] == 'Pemesanan Selesai'): ?>
                          <span class="badge bg-success text-light rounded-pill px-3 py-2">
                              <?= htmlspecialchars($data['status_pemesanan']) ?>
                          </span>
                      <?php elseif ($data['status_pemesanan'] == 'Pemesanan Aktif'): ?>
                          <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                              <?= htmlspecialchars($data['status_pemesanan']) ?>
                          </span>
                      <?php elseif ($data['status_pemesanan'] == 'Dibatalkan'): ?>
                          <span class="badge bg-danger text-white rounded-pill px-3 py-2">
                              <?= htmlspecialchars($data['status_pemesanan']) ?>
                          </span>
                      <?php else: ?>
                          <span class="badge bg-secondary text-dark rounded-pill px-3 py-2">
                              <?= htmlspecialchars($data['status_pemesanan']) ?>
                          </span>
                      <?php endif; ?>
                    </td>
                    <td>Rp <?= number_format($data['ringkasan_biaya'], 0, ',', '.') ?></td>
                    <td><?= $data['id_customer'] ?></td>
                    <td><?= $data['nama'] ?></td>
                    <td><?= $data['id_paket'] ?></td>
                    <td><?= $data['nama_paket'] ?></td>
                    <td>
                      <?php
                      // Tampilkan badge kalau ada bukti & masih menunggu konfirmasi
                      if (
                          $data['metode_pembayaran'] === 'QRIS' &&
                          $data['status_pemesanan'] === 'Menunggu Pembayaran' &&
                          !empty($data['bukti_pembayaran'])
                      ): ?>
                        <span class="badge badge-success p-2">📎 Ada Bukti Baru</span>
                      <?php else: ?>
                        &mdash;
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php
                      $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
                      ?>
                      <?php if ($role == 'fotografer') : ?>
                        <!-- Tidak ada Tombol -->
                      <?php else: ?>
                      <a class="btn btn-sm btn-danger mb-md-0 mb-1" href="delete.php?id_pemesanan=<?= $data['id_pemesanan'] ?>">
                        <i class="fas fa-trash fa-fw"></i>
                      <?php endif ?>
                      </a>
                      <a class="btn btn-sm btn-info" href="edit.php?id_pemesanan=<?= $data['id_pemesanan'] ?>">
                        <i class="fas fa-edit fa-fw"></i>
                      </a>
                    </td>
                  </tr>

                <?php
                endwhile;
                ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>

<!-- NOTIF -->
<?php if (isset($_SESSION['info'])) : ?>
<script>
  iziToast.<?= $_SESSION['info']['status']=='success'?'success':'error' ?>({
    title: '<?= $_SESSION['info']['status']=='success'?'Sukses':'Gagal' ?>',
    message: `<?= $_SESSION['info']['message'] ?>`,
    position: 'topCenter',
    timeout: 5000
  });
</script>
<?php
  unset($_SESSION['info']);
endif;
?>

<script src="../assets/js/page/modules-datatables.js"></script>
