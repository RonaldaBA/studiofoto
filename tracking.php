<?php
require_once "helper/connection.php";

$dataPesanan = null;

if(isset($_POST['cari'])){

    $keyword = mysqli_real_escape_string(
        $connection,
        $_POST['keyword']
    );

    $query = mysqli_query(
        $connection,
        "SELECT
            p.*,
            c.nama,
            c.email,
            pk.nama_paket
        FROM pemesanan p
        JOIN customer c
            ON p.id_customer = c.id_customer
        JOIN paket pk
            ON p.id_paket = pk.id_paket
        WHERE
            p.id_pemesanan = '$keyword'
            OR c.email = '$keyword'
        LIMIT 1"
    );

    if(mysqli_num_rows($query) > 0){
        $dataPesanan = mysqli_fetch_assoc($query);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Lacak Pesanan | RichArt Studio</title>

<link rel="stylesheet"
href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<style>

body{
    background:#f8fafc;
}

.card-tracking{
    border:none;
    border-radius:20px;
    box-shadow:0 15px 30px rgba(0,0,0,.08);
}

.status-badge{
    padding:10px 20px;
    border-radius:50px;
    font-weight:600;
}

.status-menunggu{
    background:#fef3c7;
    color:#92400e;
}

.status-aktif{
    background:#dbeafe;
    color:#1d4ed8;
}

.status-selesai{
    background:#dcfce7;
    color:#166534;
}

.status-batal{
    background:#fee2e2;
    color:#991b1b;
}

</style>

</head>

<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card card-tracking">

                <div class="card-body p-4">

                    <h2 class="mb-4 text-center">
                        Lacak Pesanan
                    </h2>

                    <form method="POST">

                        <div class="input-group">

                            <input
                                type="text"
                                name="keyword"
                                class="form-control"
                                placeholder="Masukkan ID Pesanan atau Email"
                                required>

                            <div class="input-group-append">

                                <button
                                    class="btn btn-success"
                                    name="cari">

                                    Cari

                                </button>

                            </div>

                        </div>

                    </form>

                    <?php if(isset($_POST['cari']) && !$dataPesanan): ?>

                        <div class="alert alert-danger mt-4">
                            Pesanan tidak ditemukan.
                        </div>

                    <?php endif; ?>

                    <?php if($dataPesanan): ?>

                        <hr>

                        <h4>Detail Pesanan</h4>

                        <table class="table">

                            <tr>
                                <th>ID Pesanan</th>
                                <td><?= $dataPesanan['id_pemesanan']; ?></td>
                            </tr>

                            <tr>
                                <th>Nama Customer</th>
                                <td><?= $dataPesanan['nama']; ?></td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td><?= $dataPesanan['email']; ?></td>
                            </tr>

                            <tr>
                                <th>Paket</th>
                                <td><?= $dataPesanan['nama_paket']; ?></td>
                            </tr>

                            <tr>
                                <th>Tanggal</th>
                                <td><?= $dataPesanan['tgl_pemesanan']; ?></td>
                            </tr>

                            <tr>
                                <th>Total Biaya</th>
                                <td>
                                    Rp <?= number_format(
                                        $dataPesanan['ringkasan_biaya'],
                                        0,
                                        ',',
                                        '.'
                                    ); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>

                                    <?php

                                    $status =
                                    $dataPesanan['status_pemesanan'];

                                    $class = '';

                                    if($status == 'Menunggu Pembayaran'){
                                        $class = 'status-menunggu';
                                    }
                                    elseif($status == 'Pemesanan Aktif'){
                                        $class = 'status-aktif';
                                    }
                                    elseif($status == 'Pemesanan Selesai'){
                                        $class = 'status-selesai';
                                    }
                                    else{
                                        $class = 'status-batal';
                                    }

                                    ?>

                                    <span class="status-badge <?= $class ?>">

                                        <?= $status ?>

                                    </span>

                                </td>

                            </tr>

                        </table>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>