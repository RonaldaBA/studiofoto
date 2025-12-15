<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$id = $_GET['id'];
$query = mysqli_query($connection, "SELECT * FROM user WHERE id='$id'");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data Pengguna</h1>
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
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>ID Pengguna</td>
                  <td><input class="form-control" type="number" name="id" size="20" required value="<?= $row['id'] ?>" disabled></td>
                </tr>
                <tr>
                  <td>Nama</td>
                  <td><input class="form-control" type="text" name="username" size="20" required value="<?= $row['username'] ?>"></td>
                </tr>
                <tr>
                  <td>Kata Sandi</td>
                  <td><input class="form-control" type="text" name="password" size="20" required value="<?= $row['password'] ?>"></td>
                </tr>
                <tr>
                  <td>Role</td>
                  <td><input class="form-control" type="text" name="role" size="20" required value="<?= $row['role'] ?>"></td>
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