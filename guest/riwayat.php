<?php

require_once "../layout/_top_guest.php";
require_once "../helper/connection.php";

$result = mysqli_query(
    $connection,
    "SELECT *
     FROM pemesanan
     WHERE id_customer='$guest_customer_id'
     ORDER BY id_pemesanan DESC"
);

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="mb-1">
            Riwayat Pesanan
        </h2>

        <p class="text-muted mb-0">
            Daftar seluruh booking yang pernah dilakukan
        </p>

    </div>

</div>

<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead class="thead-light">

                    <tr>
                        <th>No</th>
                        <th>ID Booking</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Total Biaya</th>
                    </tr>

                </thead>

                <tbody>

                <?php

                $no = 1;

                while($row = mysqli_fetch_assoc($result)):

                    $badge = "secondary";

                    if($row['status_pemesanan'] == "Menunggu Pembayaran"){
                        $badge = "warning";
                    }

                    if($row['status_pemesanan'] == "Diproses"){
                        $badge = "info";
                    }

                    if($row['status_pemesanan'] == "Selesai"){
                        $badge = "success";
                    }

                    if($row['status_pemesanan'] == "Dibatalkan"){
                        $badge = "danger";
                    }

                ?>

                    <tr>

                        <td><?= $no++ ?></td>

                        <td>
                            #<?= $row['id_pemesanan'] ?>
                        </td>

                        <td>

                            <?= date(
                                'd M Y H:i',
                                strtotime($row['tgl_pemesanan'])
                            ) ?>

                        </td>

                        <td>

                            <span class="badge badge-<?= $badge ?>">

                                <?= $row['status_pemesanan'] ?>

                            </span>

                        </td>

                        <td>

                            Rp <?= number_format(
                                $row['ringkasan_biaya'],
                                0,
                                ',',
                                '.'
                            ) ?>

                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php
require_once "../layout/_bottom_guest.php";
?>