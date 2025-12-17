<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$result = mysqli_query($connection, "SELECT * FROM gallery");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Daftar Galeri</h1>
    <a href="./create.php" class="btn btn-primary"><i class="fas fa-plus-square mr-2"></i>Tambah Data</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
                <tr>
                  <th>ID Foto</th>
                  <th>ID Customer</th>
                  <th>ID Pemesanan</th>
                  <th>Foto</th>
                  <th>Tanggal Upload</th>
                  <th style="width: 150">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($data = mysqli_fetch_array($result)) :
                ?>

                  <tr>
                    <td><?= $data['id_photo'] ?></td>
                    <td><?= $data['id_customer'] ?></td>
                    <td><?= $data['id_pemesanan'] ?></td>
                    <td><img src="../assets/img/data/<?php echo htmlspecialchars($data['file_name']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($data['file_name']); ?>" style="max-width: 50px;">
                    <td><?= $data['upload_date'] ?></td>
                    <td>
                      <a class="btn btn-sm btn-danger mb-md-0 mb-1" href="delete.php?id_photo=<?= $data['id_photo'] ?>">
                        <i class="fas fa-trash fa-fw"></i>
                      </a>
                    </td>
                  </tr>
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