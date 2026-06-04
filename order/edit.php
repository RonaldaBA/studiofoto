<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$id = $_GET['id_pemesanan'];
$query = mysqli_query($connection, "SELECT * FROM pemesanan WHERE id_pemesanan='$id'");
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
      <i class="fas fa-clipboard-list text-success mr-2"></i>
      Ubah Data Pesanan
    </h1>
    <a href="./index.php" class="btn btn-light btn-rounded">
      <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8 col-12">
      <div class="card">
        <div class="card-body">

          <form action="./update.php" method="POST">

            <!-- ID PEMESANAN (HIDDEN) -->
            <input type="hidden" name="id_pemesanan" value="<?= $data['id_pemesanan'] ?>">

            <!-- ID PEMESANAN -->
            <div class="form-group">
              <label class="form-label">ID Pemesanan</label>
              <input type="text" class="form-control" value="<?= $data['id_pemesanan'] ?>" disabled>
            </div>

            <!-- STATUS -->
            <div class="form-group">
              <label class="form-label">Status Pemesanan</label>
              <select class="form-control" name="status_pemesanan" required>
                <option value="Menunggu Pembayaran" <?= $data['status_pemesanan']=='Menunggu Pembayaran'?'selected':'' ?>>
                  Menunggu Pembayaran
                </option>
                <option value="Pemesanan Aktif" <?= $data['status_pemesanan']=='Pemesanan Aktif'?'selected':'' ?>>
                  Pemesanan Aktif
                </option>
                <option value="Pemesanan Selesai" <?= $data['status_pemesanan']=='Pemesanan Selesai'?'selected':'' ?>>
                  Pemesanan Selesai
                </option>
              </select>
            </div>

            <!-- RINGKASAN BIAYA -->
            <div class="form-group">
              <label class="form-label">Ringkasan Biaya (Rp)</label>
              <input type="number" name="ringkasan_biaya" class="form-control"
                     value="<?= $data['ringkasan_biaya'] ?>" required>
            </div>

            <!-- ID CUSTOMER -->
            <div class="form-group">
              <label class="form-label">ID Customer</label>
              <input type="number" name="id_customer" class="form-control"
                     value="<?= $data['id_customer'] ?>" required>
            </div>

            <!-- ID PAKET -->
            <div class="form-group">
              <label class="form-label">ID Paket</label>
              <input type="number" name="id_paket" class="form-control"
                     value="<?= $data['id_paket'] ?>" required>
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
