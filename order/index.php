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
        c.nama,
        pk.nama_paket,
        pk.deskripsi,
        p.id_paket,
        pk.harga_paket
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

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Daftar Pesanan</h1>
    <!-- <a href="./create.php" class="btn btn-primary"><i class="fas fa-plus-square mr-2"></i>Tambah Data</a> -->
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
                <tr>
                  <th>ID Pemesanan</th>
                  <th>Tanggal Pemesanan</th>
                  <th>Status Pemesanan</th>
                  <th>Ringkasan Biaya</th>
                  <th>ID Customer</th>
                  <th>Nama Customer</th>
                  <th>ID Paket</th>
                  <th>Nama Paket</th>
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
</section>

<?php
require_once '../layout/_bottom.php';
?>
<!-- Page Specific JS File -->
<?php
if (isset($_SESSION['info'])) :
  if ($_SESSION['info']['status'] == 'success') {
?>
    <script>
      iziToast.success({
        title: 'Sukses',
        message: `<?= $_SESSION['info']['message'] ?>`,
        position: 'topCenter',
        timeout: 5000
      });
    </script>
  <?php
  } else {
  ?>
    <script>
      iziToast.error({
        title: 'Gagal',
        message: `<?= $_SESSION['info']['message'] ?>`,
        timeout: 5000,
        position: 'topCenter'
      });
    </script>
<?php
  }

  unset($_SESSION['info']);
  $_SESSION['info'] = null;
endif;
?>
<script src="../assets/js/page/modules-datatables.js"></script>