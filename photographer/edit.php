<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$idpg = $_GET['id_photographer'];
$query = mysqli_query($connection, "SELECT * FROM photographer WHERE id_photographer='$idpg'");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data Fotografer</h1>
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
              <input type="hidden" name="id_photographer" value="<?= $row['id_photographer'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>ID Fotografer</td>
                  <td><input class="form-control" type="number" name="id_photographer" size="20" required value="<?= $row['id_photographer'] ?>" disabled></td>
                </tr>
                <tr>
                  <td>Nama</td>
                  <td><input class="form-control" type="text" name="nama" size="20" required value="<?= $row['nama'] ?>"></td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td><input class="form-control" type="text" name="email" size="20" required value="<?= $row['email'] ?>"></td>
                </tr>
                <tr>
                  <td>Nomor HP</td>
                  <td><input class="form-control" type="text" name="no_hp" size="20" required value="<?= $row['no_hp'] ?>"></td>
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