<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$result = mysqli_query($connection, "SELECT * FROM gallery");
?>

<style>
/* ===== GALERI STYLE (SELARAS HOME & DASHBOARD) ===== */

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
  font-size: 14px;
  font-weight: 600;
  color: #6b7280;
  border-top: none;
}

.table tbody td {
  vertical-align: middle;
  font-size: 14px;
}

/* IMAGE */
.gallery-thumb {
  width: 56px;
  height: 56px;
  border-radius: 12px;
  object-fit: cover;
  box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

/* BUTTON */
.btn-add {
  background: linear-gradient(135deg, #22c55e, #16a34a);
  border: none;
  border-radius: 999px;
  padding: 10px 18px;
  font-weight: 600;
  color: #fff;
}

.btn-add:hover {
  opacity: 0.9;
}

.btn-delete {
  border-radius: 10px;
}

/* DATATABLE */
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: #22c55e !important;
  color: #fff !important;
  border-radius: 8px;
}
</style>

<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>
      <i class="fas fa-images text-success mr-2"></i>
      Daftar Galeri
    </h1>
    <a href="./create.php" class="btn btn-add">
      <i class="fas fa-plus mr-1"></i> Tambah Foto
    </a>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="table-responsive">
            <table class="table table-hover w-100" id="table-1">
              <thead>
                <tr>
                  <th>ID Foto</th>
                  <th>ID Customer</th>
                  <th>ID Pemesanan</th>
                  <th>Foto</th>
                  <th>Tanggal Upload</th>
                  <th style="width:120px">Aksi</th>
                </tr>
              </thead>
              <tbody>

              <?php while ($data = mysqli_fetch_array($result)) : ?>
                <tr>
                  <td><?= $data['id_photo'] ?></td>
                  <td><?= $data['id_customer'] ?></td>
                  <td><?= $data['id_pemesanan'] ?></td>

                  <td>
                    <img 
                      src="../assets/img/data/<?= htmlspecialchars($data['file_name']) ?>"
                      alt="<?= htmlspecialchars($data['file_name']) ?>"
                      class="gallery-thumb">
                  </td>

                  <td><?= date('d M Y', strtotime($data['upload_date'])) ?></td>

                  <td>
                    <a 
                      href="delete.php?id_photo=<?= $data['id_photo'] ?>"
                      class="btn btn-sm btn-danger btn-delete"
                      onclick="return confirm('Yakin ingin menghapus foto ini?')">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>

              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>

<!-- NOTIFIKASI -->
<?php if (isset($_SESSION['info'])) : ?>
<script>
  <?php if ($_SESSION['info']['status'] == 'success') : ?>
    iziToast.success({
      title: 'Sukses',
      message: '<?= $_SESSION['info']['message'] ?>',
      position: 'topCenter',
      timeout: 4000
    });
  <?php else : ?>
    iziToast.error({
      title: 'Gagal',
      message: '<?= $_SESSION['info']['message'] ?>',
      position: 'topCenter',
      timeout: 4000
    });
  <?php endif; ?>
</script>
<?php
  unset($_SESSION['info']);
endif;
?>

<script src="../assets/js/page/modules-datatables.js"></script>
