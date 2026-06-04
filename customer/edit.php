<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$id_customer = $_GET['id_customer'];
$query = mysqli_query($connection, "SELECT * FROM customer WHERE id_customer='$id_customer'");
$data = mysqli_fetch_assoc($query);
?>

<style>
/* ===== FORM STYLE SELARAS DASHBOARD ===== */
.section-header h1 {
  font-weight: 700;
  color: #1f2937;
}

.card {
  border-radius: 18px;
  border: none;
  box-shadow: 0 12px 25px rgba(0,0,0,0.06);
}

.form-label {
  font-size: 14px;
  font-weight: 600;
  color: #374151;
  margin-bottom: 6px;
}

.form-control {
  border-radius: 12px;
  font-size: 14px;
  padding: 10px 14px;
}

.form-control:focus {
  border-color: #22c55e;
  box-shadow: 0 0 0 0.15rem rgba(34,197,94,.25);
}

.btn-rounded {
  border-radius: 999px;
  padding: 8px 22px;
  font-size: 14px;
}
</style>

<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>
      <i class="fas fa-user-edit text-success mr-2"></i>
      Ubah Data Customer
    </h1>
    <a href="./index.php" class="btn btn-light btn-rounded">
      <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-7 col-md-9 col-12">
      <div class="card">
        <div class="card-body">

          <form action="./update.php" method="POST">

            <!-- ID CUSTOMER (HIDDEN) -->
            <input type="hidden" name="id_customer" value="<?= $data['id_customer'] ?>">

            <!-- ID CUSTOMER -->
            <div class="form-group">
              <label class="form-label">ID Customer</label>
              <input type="text" class="form-control" value="<?= $data['id_customer'] ?>" disabled>
            </div>

            <!-- NAMA -->
            <div class="form-group">
              <label class="form-label">Nama Customer</label>
              <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
            </div>

            <!-- EMAIL -->
            <div class="form-group">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>" required>
            </div>

            <!-- PASSWORD -->
            <div class="form-group">
              <label class="form-label">Kata Sandi</label>
              <input type="password" name="password" class="form-control" value="<?= $data['password'] ?>" required>
            </div>

            <!-- NO HP -->
            <div class="form-group">
              <label class="form-label">Nomor HP</label>
              <input type="text" name="no_hp" class="form-control" value="<?= $data['no_hp'] ?>" required>
            </div>

            <!-- ACTION -->
            <div class="d-flex justify-content-end mt-4">
              <a href="./index.php" class="btn btn-danger btn-rounded mr-2">
                <i class="fas fa-times mr-1"></i> Batal
              </a>
              <button type="submit" name="proses" class="btn btn-success btn-rounded">
                <i class="fas fa-save mr-1"></i> Simpan Perubahan
              </button>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>
