<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$result = mysqli_query($connection, "SELECT * FROM paket");
?>

<style>
/* ===== TABLE STYLE (SELARAS HOME & DASHBOARD) ===== */

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
  font-size: 13px;
  font-weight: 700;
  color: #374151;
  background-color: #f9fafb;
  border-bottom: none;
}

.table tbody td {
  font-size: 14px;
  vertical-align: middle;
}

/* PRICE */
.price-text {
  font-weight: 700;
  color: #16a34a;
}

/* BUTTON */
.btn-add {
  background: linear-gradient(135deg, #22c55e, #16a34a);
  color: #fff;
  border-radius: 999px;
  padding: 8px 20px;
  font-weight: 600;
}

.btn-add:hover {
  opacity: 0.9;
}

.btn-icon {
  border-radius: 999px;
  padding: 6px 10px;
}

/* ICON COLOR */
.icon-green {
  color: #16a34a;
}

.icon-blue {
  color: #2563eb;
}

.icon-red {
  color: #dc2626;
}
</style>

<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>
      <i class="fas fa-box-open icon-green mr-2"></i>
      Daftar Paket
    </h1>

    <?php if ($_SESSION['role'] != 'fotografer') : ?>
      <a href="./create.php" class="btn btn-add">
        <i class="fas fa-plus mr-1"></i> Tambah Paket
      </a>
    <?php endif ?>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="table-responsive">
            <table class="table table-hover w-100" id="table-1">
              <thead>
                <tr>
                  <th>ID Paket</th>
                  <th>Nama Paket</th>
                  <th>Deskripsi</th>
                  <th>Harga</th>
                  <th style="width:120px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($data = mysqli_fetch_array($result)) : ?>
                <tr>
                  <td><?= $data['id_paket'] ?></td>
                  <td><?= htmlspecialchars($data['nama_paket']) ?></td>
                  <td><?= htmlspecialchars($data['deskripsi']) ?></td>
                  <td class="price-text">
                    Rp <?= number_format($data['harga_paket'], 0, ',', '.') ?>
                  </td>
                  <td>
                    <?php if ($_SESSION['role'] != 'fotografer') : ?>
                      <a href="delete.php?id_paket=<?= $data['id_paket'] ?>"
                         class="btn btn-sm btn-danger btn-icon mb-1"
                         onclick="return confirm('Yakin ingin menghapus paket ini?')">
                        <i class="fas fa-trash"></i>
                      </a>
                    <?php endif ?>

                    <a href="edit.php?id_paket=<?= $data['id_paket'] ?>"
                       class="btn btn-sm btn-info btn-icon">
                      <i class="fas fa-edit"></i>
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

<!-- NOTIF -->
<?php if (isset($_SESSION['info'])) : ?>
<script>
  iziToast.<?= $_SESSION['info']['status'] == 'success' ? 'success' : 'error' ?>({
    title: '<?= $_SESSION['info']['status'] == 'success' ? 'Sukses' : 'Gagal' ?>',
    message: `<?= $_SESSION['info']['message'] ?>`,
    position: 'topCenter',
    timeout: 5000
  });
</script>
<?php
  unset($_SESSION['info']);
endif;
?>

<script src="../assets/js/page/modules-datatables.js"></script>
