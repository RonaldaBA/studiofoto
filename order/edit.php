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
                      <option value="Belum Selesai" <?= ($row['status_pemesanan'] == 'Belum Selesai') ? 'selected' : '' ?>>Belum Selesai</option>
                      <option value="Proses" <?= ($row['status_pemesanan'] == 'Proses') ? 'selected' : '' ?>>Proses</option>
                      <option value="Selesai" <?= ($row['status_pemesanan'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
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