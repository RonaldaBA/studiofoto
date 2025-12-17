<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Foto</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="store.php" method="POST" enctype="multipart/form-data">
            <table cellpadding="8" class="w-100">

              <!-- <tr>
                <td>ID foto</td>
                <td><input class="form-control" type="number" name="id_photo" size="20" required></td>
              </tr> -->
              <tr>
                <td>ID Pemesanan</td>
                <td>
                  <!-- Input Search -->
                  <div class="input-group mb-2">
                    <input type="text" id="searchCustomer" class="form-control" placeholder="Cari ID Pemesanan / ID Customer">
                    <button type="button" class="btn btn-primary" onclick="searchCustomer()">Search</button>
                  </div>

                  <!-- Dropdown -->
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
                            .$row['id_pemesanan']. ' (ID_Pemesanan)'.' - '.$row['id_customer']. ' (ID_Customer)'.' - '.$row['nama']. ' (Nama Pengguna)'.
                            '</option>';
                    }
                    ?>
                  </select>
                </td>
              </tr>
              <script>
              document.getElementById('searchCustomer').addEventListener('keyup', function () {
                const keyword = this.value.toLowerCase();
                const select = document.getElementById('customerSelect');

                for (let i = 0; i < select.options.length; i++) {
                  if (select.options[i].text.toLowerCase().includes(keyword)) {
                    select.selectedIndex = i;
                    // update hidden input
                    document.getElementById('id_customer').value = select.options[i].getAttribute('data-idcustomer');
                    break;
                  }
                }
              });
              </script>

              <tr>
                <td>ID Customer</td>
                <td>
                  <select class="form-control" name="id_customer" required>
                    <option value="">-- Pilih ID Customer (Samakan dengan yang ada di ID_Pemesanan diatas) --</option>
                    <?php
                    // Query ke database
                    $query2 = mysqli_query($connection, "SELECT id_customer, nama FROM customer");

                    // Tampilkan semua id_pengguna sebagai opsi
                    while ($row2 = mysqli_fetch_assoc($query2)) {
                        echo '<option value="' . $row2['id_customer'] . '">' . $row2['id_customer'] . ' - ' . $row2['nama'] . '</option>';
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Foto</td>
                <td>
                  <input class="form-control" type="file" id="file_name" name="file_name" accept=".jpg, .jpeg, .png" required>* Format yang didukung: .png / .jpg / .jpeg
                  <img id="preview" src="" alt="" style="margin-top:10px; max-width: 200px; display: none;">

                <script>
                  document.getElementById('file_name').addEventListener('change', function(event) {
                    const file = event.target.files[0];

                    if (file && file.type.startsWith('image/')) {
                      const reader = new FileReader();
                      
                      reader.onload = function(e) {
                        const preview = document.getElementById('preview');
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                      }

                      reader.readAsDataURL(file);
                    } else {
                      alert('Format gambar tidak didukung, mohon gunakan format .jpg / .jpeg / .png');
                    }
                  });
                </script>
                </td>
              </tr>

              <tr>
                <td>Tanggal Upload</td>
                <td>
                  <input class="form-control" type="date" value="<?= date('Y-m-d'); ?>" disabled>
                  <input type="hidden" name="upload_date" value="<?= date('Y-m-d'); ?>">
                </td>
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