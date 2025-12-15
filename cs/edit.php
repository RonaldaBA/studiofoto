<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$idcs = $_GET['id_cs'];
$query = mysqli_query($connection, "SELECT * FROM customer_service WHERE id_cs='$idcs'");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data Customer Service</h1>
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
              <input type="hidden" name="id_cs" value="<?= $row['id_cs'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>ID Customer Service</td>
                  <td><input class="form-control" type="number" name="id_cs" size="20" required value="<?= $row['id_cs'] ?>" disabled></td>
                </tr>

                <tr>
                <td>Nama</td>
                <td><input class="form-control" type="text" name="nama" size="20" required value="<?= $row['nama'] ?>"></td>
              </tr>

              <tr>
                <td>Nomor HP</td>
                <td><input class="form-control" type="text" name="no_hp" size="20" required value="<?= $row['no_hp'] ?>"></td>
              </tr>

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