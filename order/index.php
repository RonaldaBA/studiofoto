<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$result = mysqli_query($connection, "SELECT * FROM pemesanan");
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
                  <th>ID Pengguna</th>
                  <th>ID Paket</th>
                  <th style="width: 150">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($data = mysqli_fetch_array($result)) :
                ?>

                  <tr>
                    <td><?= $data['id_pemesanan'] ?></td>
                    <td><?= $data['tgl_pemesanan'] ?></td>
                    <td>
                      <?php if ($data['status_pemesanan'] == 'Selesai'): ?>
                          <span class="badge bg-success text-light rounded-pill px-3 py-2">
                              <?= htmlspecialchars($data['status_pemesanan']) ?>
                          </span>
                      <?php elseif ($data['status_pemesanan'] == 'Belum Selesai'): ?>
                          <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                              <?= htmlspecialchars($data['status_pemesanan']) ?>
                          </span>
                      <?php else: ?>
                          <span class="badge bg-secondary text-dark rounded-pill px-3 py-2">
                              <?= htmlspecialchars($data['status_pemesanan']) ?>
                          </span>
                      <?php endif; ?>
                    </td>
                    <td><?= $data['ringkasan_biaya'] ?></td>
                    <td><?= $data['id_user'] ?></td>
                    <td><?= $data['id_paket'] ?></td>
                    <td>
                      <a class="btn btn-sm btn-danger mb-md-0 mb-1" href="delete.php?id_pemesanan=<?= $data['id_pemesanan'] ?>">
                        <i class="fas fa-trash fa-fw"></i>
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