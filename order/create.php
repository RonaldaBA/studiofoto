<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Paket</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="./store.php" method="POST">
            <table cellpadding="8" class="w-100">

              <tr>
                <td>ID Pemesanan</td>
                <td><input class="form-control" type="number" name="id_pemesanan" size="20" required></td>
              </tr>

              <tr>
                <td>Tanggal Pemesanan</td>
                <td><input class="form-control" type="date" name="tgl_pemesanan" size="20" required></td>
              </tr>

              <tr>
                <td>Status</td>
                <td>
                  <select class="form-control" name="status_pemesanan" required>
                    <option value="" disabled selected>Pilih status</option>
                    <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                    <option value="Pemesanan Aktif">Pemesanan Aktif</option>                    
                    <option value="Pemesanan Selesai">Pemesanan Selesai</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Ringkasan Biaya</td>
                <td><input class="form-control" type="number" name="ringkasan_biaya" size="20" required></td>
              </tr>
              
              <tr>
                <td>ID Customer</td>
                <td><input class="form-control" type="number" name="id_customer" size="20" required></td>
              </tr>

              <tr>
                <td>ID Paket</td>
                <td><input class="form-control" type="number" name="id_paket" size="20" required></td>
              </tr>

              <tr>
                <td>
                  <input class="btn btn-primary" type="submit" name="proses" value="Simpan">
                  <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan"></td>
              </tr>

            </table>
          </form>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>