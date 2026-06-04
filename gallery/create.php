<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';
?>

<style>
/* ===== FORM GALERI STYLE (SELARAS HOME & DASHBOARD) ===== */

.section-header h1 {
  font-weight: 700;
  color: #1f2937;
}

.card {
  border-radius: 18px;
  border: none;
  box-shadow: 0 12px 25px rgba(0,0,0,0.06);
}

/* FORM */
.form-group label {
  font-size: 14px;
  font-weight: 600;
  color: #374151;
}

.form-control {
  border-radius: 12px;
  height: 44px;
}

textarea.form-control {
  height: auto;
}

/* BUTTON */
.btn-green {
  background: linear-gradient(135deg, #22c55e, #16a34a);
  border: none;
  color: #fff;
  font-weight: 600;
  border-radius: 999px;
  padding: 10px 24px;
}

.btn-green:hover {
  opacity: 0.9;
}

.btn-outline {
  border-radius: 999px;
  padding: 10px 24px;
}

/* PREVIEW IMAGE */
.preview-box {
  margin-top: 12px;
}

.preview-box img {
  max-width: 220px;
  border-radius: 14px;
  box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}
</style>

<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>
      <i class="fas fa-images text-success mr-2"></i>
      Tambah Foto Galeri
    </h1>
    <a href="./index.php" class="btn btn-light rounded-pill px-4">
      ← Kembali
    </a>
  </div>

  <div class="row">
    <div class="col-lg-8 col-md-10 col-12">
      <div class="card">
        <div class="card-body">

          <form action="store.php" method="POST" enctype="multipart/form-data">

            <!-- ID PEMESANAN -->
            <div class="form-group">
              <label>ID Pemesanan</label>

              <div class="input-group mb-2">
                <input type="text" id="searchCustomer" class="form-control" placeholder="Cari ID Pemesanan / ID Customer / Nama">
                <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>

              <select class="form-control" name="id_pemesanan" id="customerSelect" required>
                <option value="">-- Pilih Pesanan --</option>
                <?php
                $query = mysqli_query($connection, "
                  SELECT p.id_pemesanan, c.id_customer, c.nama 
                  FROM pemesanan p 
                  JOIN customer c ON p.id_customer = c.id_customer
                  ORDER BY c.nama ASC
                ");
                while ($row = mysqli_fetch_assoc($query)) {
                  echo '<option value="'.$row['id_pemesanan'].'">'
                      .$row['id_pemesanan'].' • '.$row['id_customer'].' • '.$row['nama'].
                      '</option>';
                }
                ?>
              </select>
            </div>

            <!-- ID CUSTOMER -->
            <div class="form-group">
              <label>ID Customer</label>
              <select class="form-control" name="id_customer" required>
                <option value="">-- Pilih Customer --</option>
                <?php
                $query2 = mysqli_query($connection, "SELECT id_customer, nama FROM customer");
                while ($row2 = mysqli_fetch_assoc($query2)) {
                  echo '<option value="'.$row2['id_customer'].'">'
                      .$row2['id_customer'].' • '.$row2['nama'].
                      '</option>';
                }
                ?>
              </select>
            </div>

            <!-- FILE FOTO -->
            <div class="form-group">
              <label>Upload Foto</label>
              <input class="form-control" type="file" id="file_name" name="file_name"
                     accept=".jpg,.jpeg,.png" required>
              <small class="text-muted">Format didukung: JPG, JPEG, PNG</small>

              <div class="preview-box">
                <img id="preview" style="display:none;">
              </div>
            </div>

            <!-- TANGGAL -->
            <div class="form-group">
              <label>Tanggal Upload</label>
              <input class="form-control" type="date" value="<?= date('Y-m-d'); ?>" disabled>
              <input type="hidden" name="upload_date" value="<?= date('Y-m-d'); ?>">
            </div>

            <!-- BUTTON -->
            <div class="form-group mt-4">
              <button type="submit" name="proses" class="btn btn-green mr-2">
                <i class="fas fa-save mr-1"></i> Simpan
              </button>
              <button type="reset" class="btn btn-outline-danger rounded-pill px-4">
                Bersihkan
              </button>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
</section>

<script>
// SEARCH DROPDOWN
document.getElementById('searchCustomer').addEventListener('keyup', function () {
  const keyword = this.value.toLowerCase();
  const select = document.getElementById('customerSelect');

  for (let i = 0; i < select.options.length; i++) {
    if (select.options[i].text.toLowerCase().includes(keyword)) {
      select.selectedIndex = i;
      break;
    }
  }
});

// PREVIEW IMAGE
document.getElementById('file_name').addEventListener('change', function (e) {
  const file = e.target.files[0];
  if (file && file.type.startsWith('image/')) {
    const reader = new FileReader();
    reader.onload = function (evt) {
      const preview = document.getElementById('preview');
      preview.src = evt.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
  } else {
    alert('Format gambar tidak didukung');
  }
});
</script>

<?php require_once '../layout/_bottom.php'; ?>
