<?php
include "../helper/auth.php";
include "../helper/connection.php";
isLogin();

$id_customer = $_SESSION['id_customer'];

// ===== CREATE =====
if (isset($_POST['simpan'])) {
    $nama       = $_POST['nama'];
    $no_wa      = $_POST['no_wa'];
    $email      = $_POST['email'];
    $paket      = $_POST['paket'];
    $tanggal    = $_POST['tanggal'];
    $jam        = $_POST['jam'];
    $jumlah     = $_POST['jumlah_orang'];

    $tgl_jam = $tanggal . ' ' . $jam;

    mysqli_query($connection, "
        INSERT INTO pemesanan 
        (id_customer, tgl_pemesanan, status_pemesanan, ringkasan_biaya, id_paket)
        VALUES
        ('$id_customer', '$tgl_jam', 'Proses', 0, '$paket')
    ");

    header("Location: pesan_sekarang.php");
    exit;
}

// ===== READ =====
$data = mysqli_query($connection, "
    SELECT p.*, pk.nama_paket
    FROM pemesanan p
    JOIN paket pk ON p.id_paket = pk.id_paket
    WHERE p.id_customer = '$id_customer'
    ORDER BY p.id_pemesanan DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Sekarang</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        html { overflow-y: scroll; }

        body {
            background: #f8fafc;
            font-family: Arial, sans-serif;
        }

        .page-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .form-card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
            margin-bottom: 40px;
        }

        .form-title {
            font-weight: 700;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="page-wrapper">

    <!-- ===== FORM PESAN ===== -->
    <div class="form-card">
        <h4 class="form-title">Pesan Sekarang</h4>

        <form method="POST">
            <div class="row">

                <div class="col-md-6 form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="col-md-6 form-group">
                    <label>No WhatsApp</label>
                    <input type="text" name="no_wa" class="form-control" required>
                </div>

                <div class="col-md-6 form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="col-md-6 form-group">
                    <label>Paket</label>
                    <select name="paket" class="form-control" required>
                        <option value="">-- Pilih Paket --</option>
                        <?php
                        $paket = mysqli_query($connection, "SELECT * FROM paket");
                        while ($p = mysqli_fetch_assoc($paket)) {
                            echo "<option value='{$p['id_paket']}'>{$p['nama_paket']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4 form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>

                <div class="col-md-4 form-group">
                    <label>Jam</label>
                    <input type="time" name="jam" class="form-control" required>
                </div>

                <div class="col-md-4 form-group">
                    <label>Jumlah Orang</label>
                    <input type="number" name="jumlah_orang" class="form-control" min="1" required>
                </div>

            </div>

            <button name="simpan" class="btn btn-success px-4">
                Pesan Sekarang
            </button>
        </form>
    </div>

    <!-- ===== DATA PESANAN ===== -->
    <h4 class="mb-3">Pesanan Saya</h4>

    <table class="table table-bordered bg-white">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Paket</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($data) > 0) {
                while ($row = mysqli_fetch_assoc($data)) {
                    echo "
                    <tr>
                        <td>{$no}</td>
                        <td>{$row['tgl_pemesanan']}</td>
                        <td>{$row['nama_paket']}</td>
                        <td>{$row['status_pemesanan']}</td>
                    </tr>
                    ";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='4' class='text-center text-muted'>Belum ada pesanan</td></tr>";
            }
            ?>
        </tbody>
    </table>

</div>

</body>
</html>
