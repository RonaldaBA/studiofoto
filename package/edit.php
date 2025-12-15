<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$id = $_GET['id_paket'];
$query = mysqli_query($connection, "SELECT * FROM paket WHERE id_paket='$id'");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data Paket</h1>
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
              <input type="hidden" name="id_paket" value="<?= $row['id_paket'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>ID Paket</td>
                  <td><input class="form-control" type="number" name="id_paket" size="20" required value="<?= $row['id_paket'] ?>" disabled></td>
                </tr>
                <tr>
                  <td>Nama</td>
                  <td><input class="form-control" type="text" name="nama_paket" size="20" required value="<?= $row['nama_paket'] ?>"></td>
                </tr>
                <tr>
                  <td>Deskripsi</td>
                  <td>
                    <textarea class="form-control" name="deskripsi" rows="4" required><?= htmlspecialchars($row['deskripsi']) ?></textarea>
                  </td>
                </tr>
                <tr>
                  <td>Harga</td>
                  <td><input class="form-control" type="number" name="harga_paket" size="20" required value="<?= $row['harga_paket'] ?>"></td>
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