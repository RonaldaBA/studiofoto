<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$result = mysqli_query($connection, "SELECT * FROM customer");
?>

<style>
/* ===== TABLE UI (SELARAS HOME & DASHBOARD) ===== */

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
  background: #f9fafb;
  font-size: 13px;
  font-weight: 700;
  color: #374151;
  border-bottom: none;
}

.table tbody td {
  font-size: 14px;
  vertical-align: middle;
}

/* EMAIL */
.email-text {
  color: #2563eb;
  font-weight: 600;
}

/* PASSWORD (MASKED STYLE) */
.password-text {
  letter-spacing: 2px;
  color: #6b7280;
}

/* BUTTON */
.btn-icon {
  border-radius: 999px;
  padding: 6px 10px;
}

/* ICON COLOR */
.icon-green { color: #16a34a; }
.icon-blue  { color: #2563eb; }
.icon-red   { color: #dc2626; }
</style>

<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>
      <i class="fas fa-users icon-green mr-2"></i>
      Daftar Customer
    </h1>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="table-responsive">
            <table class="table table-hover w-100" id="table-1">
              <thead>
                <tr>
                  <th>ID Customer</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Password</th>
                  <th>No. HP</th>
                  <th style="width:120px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($data = mysqli_fetch_array($result)) : ?>
                <tr>
                  <td><?= $data['id_customer'] ?></td>
                  <td><?= htmlspecialchars($data['nama']) ?></td>
                  <td class="email-text"><?= htmlspecialchars($data['email']) ?></td>
                  <td class="password-text">••••••••</td>
                  <td><?= htmlspecialchars($data['no_hp']) ?></td>
                  <td>
                    <a href="delete.php?id_customer=<?= $data['id_customer'] ?>"
                       class="btn btn-sm btn-danger btn-icon mb-1"
                       onclick="return confirm('Yakin ingin menghapus data customer ini?')">
                      <i class="fas fa-trash"></i>
                    </a>
                    <a href="edit.php?id_customer=<?= $data['id_customer'] ?>"
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

<!-- NOTIFIKASI -->
<?php if (isset($_SESSION['info'])) : ?>
<script>
  iziToast.<?= $_SESSION['info']['status']=='success'?'success':'error' ?>({
    title: '<?= $_SESSION['info']['status']=='success'?'Sukses':'Gagal' ?>',
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
