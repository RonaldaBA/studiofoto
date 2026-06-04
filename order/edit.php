<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$id = $_GET['id_pemesanan'];
$query = mysqli_query($connection, "SELECT * FROM pemesanan WHERE id_pemesanan='$id'");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data Pesanan</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="./update.php" method="post">
            <?php
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <input type="hidden" name="id_pemesanan" value="<?= $row['id_pemesanan'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>ID Pemesanan</td>
                  <td><input class="form-control" type="number" name="id_pemesanan" size="20" required value="<?= $row['id_pemesanan'] ?>" disabled></td>
                </tr>
                <tr>
                  <td>Status</td>
                  <td>
                    <select class="form-control" name="status_pemesanan" required>
                      <option value="" disabled <?= empty($row['status_pemesanan']) ? 'selected' : '' ?>>Pilih status</option>
                      <option value="Menunggu Pembayaran" <?= ($row['status_pemesanan'] == 'Menunggu Pembayaran') ? 'selected' : '' ?>>Menunggu Pembayaran</option>
                      <option value="Pemesanan Aktif" <?= ($row['status_pemesanan'] == 'Pemesanan Aktif') ? 'selected' : '' ?>>Pemesanan Aktif</option>
                      <option value="Pemesanan Selesai" <?= ($row['status_pemesanan'] == 'Pemesanan Selesai') ? 'selected' : '' ?>>Pemesanan Selesai</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Ringkasan Biaya</td>
                  <td><input class="form-control" type="number" name="ringkasan_biaya" size="20" required value="<?= $row['ringkasan_biaya'] ?>"></td>
                </tr>
                <tr>
                  <td>ID Customer</td>
                  <td><input class="form-control" type="number" name="id_customer" size="20" required value="<?= $row['id_customer'] ?>"></td>
                </tr>
                <tr>
                  <td>ID Paket</td>
                  <td><input class="form-control" type="text" name="id_paket" size="20" required value="<?= $row['id_paket'] ?>"></td>
                </tr>

                <?php if ($row['metode_pembayaran'] === 'QRIS'): ?>
                <tr>
                  <td valign="top" style="padding-top:12px;">Bukti Pembayaran</td>
                  <td>
                    <?php if (!empty($row['bukti_pembayaran'])): ?>
                      <p class="text-muted mb-1" style="font-size:13px;">
                        Diupload: <?= date('d M Y H:i', strtotime($row['tgl_upload_bukti'])) ?>
                      </p>
                      <a href="../assets/img/bukti/<?= htmlspecialchars($row['bukti_pembayaran']) ?>"
                         target="_blank">
                        <img src="../assets/img/bukti/<?= htmlspecialchars($row['bukti_pembayaran']) ?>"
                             alt="Bukti Pembayaran"
                             style="max-width:300px; border-radius:8px; border:1px solid #dee2e6; cursor:pointer;"
                             title="Klik untuk lihat penuh">
                      </a>
                      <p class="text-muted mt-1" style="font-size:12px;">Klik gambar untuk memperbesar</p>
                    <?php else: ?>
                      <span class="text-muted">⏳ Customer belum upload bukti pembayaran</span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endif; ?>

                <tr>
                  <td>
                    <input class="btn btn-primary d-inline" type="submit" name="proses" value="Ubah">
                    <a href="./index.php" class="btn btn-danger ml-1">Batal</a>
                  <td>
                </tr>
              </table>

            <?php } ?>
          </form>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>