<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';
?>

<style>
/* ===== FORM STYLE (SELARAS HOME & DASHBOARD) ===== */

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

/* FORM LABEL */
.form-label {
  font-size: 14px;
  font-weight: 600;
  color: #374151;
  margin-bottom: 6px;
}

/* INPUT */
.form-control {
  border-radius: 12px;
  font-size: 14px;
  padding: 10px 14px;
}

.form-control:focus {
  border-color: #22c55e;
  box-shadow: 0 0 0 0.15rem rgba(34,197,94,.25);
}

/* BUTTON */
.btn-rounded {
  border-radius: 999px;
  padding: 8px 22px;
  font-size: 14px;
}
</style>

<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>
      <i class="fas fa-camera-retro text-success mr-2"></i>
      Tambah Fotografer
    </h1>
    <a href="./index.php" class="btn btn-light btn-rounded">
      <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8 col-12">
      <div class="card">
        <div class="card-body">

          <form action="./store.php" method="POST">

            <!-- ID -->
            <div class="form-group">
              <label class="form-label">ID Fotografer</label>
              <input type="number" name="id_photographer" class="form-control" placeholder="Contoh: 101" required>
            </div>

            <!-- NAMA -->
            <div class="form-group">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" name="nama" class="form-control" placeholder="Nama fotografer" required>
            </div>

            <!-- EMAIL -->
            <div class="form-group">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" placeholder="email@domain.com" required>
            </div>

            <!-- NO HP -->
            <div class="form-group">
              <label class="form-label">Nomor HP</label>
              <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required>
            </div>

            <!-- ACTION -->
            <div class="d-flex justify-content-end mt-4">
              <button type="reset" class="btn btn-danger btn-rounded mr-2">
                <i class="fas fa-eraser mr-1"></i> Bersihkan
              </button>
              <button type="submit" name="proses" class="btn btn-success btn-rounded">
                <i class="fas fa-save mr-1"></i> Simpan
              </button>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>
