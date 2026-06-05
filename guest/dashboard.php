<?php

require_once "../layout/_top_guest.php";
require_once "../helper/connection.php";

$id_customer = $guest_customer_id;

$customer = mysqli_fetch_assoc(
    mysqli_query(
        $connection,
        "SELECT *
         FROM customer
         WHERE id_customer='$id_customer'"
    )
);

$totalPesanan = mysqli_fetch_assoc(
    mysqli_query(
        $connection,
        "SELECT COUNT(*) total
         FROM pemesanan
         WHERE id_customer='$id_customer'"
    )
);

$lastOrder = mysqli_fetch_assoc(
    mysqli_query(
        $connection,
        "SELECT *
         FROM pemesanan
         WHERE id_customer='$id_customer'
         ORDER BY id_pemesanan DESC
         LIMIT 1"
    )
);

$guestData = mysqli_fetch_assoc(
    mysqli_query(
        $connection,
        "SELECT *
         FROM guest_account
         WHERE id_customer='$id_customer'
         LIMIT 1"
    )
);

$expired = strtotime($guestData['expired_at']);
$today = time();

$sisaHari = ceil(
    ($expired - $today)
    /
    (60*60*24)
);

?>

<div>

    <h2>Dashboard Guest</h2>

    <div class="alert alert-info">
        Selamat datang,
        <strong><?= $customer['nama']; ?></strong>
    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="card">

                <div class="card-body">

                    <h5>Total Pesanan</h5>

                    <h2>
                        <?= $totalPesanan['total']; ?>
                    </h2>

                </div>

            </div>
        </div>

        <div class="col-md-4">

            <div class="card">

                <div class="card-body">

                    <h5>Status Terakhir</h5>

                    <h4>
                        <?= $lastOrder['status_pemesanan'] ?? '-'; ?>
                    </h4>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card">

                <div class="card-body">

                    <h5>Masa Aktif Guest</h5>

                    <h2>
                        <?= $sisaHari ?> Hari
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="mt-4">

        <a href="riwayat.php"
           class="btn btn-primary">
            Lihat Riwayat Pesanan
        </a>

        <a href="upgrade.php"
           class="btn btn-success">
            Upgrade Menjadi Member
        </a>

    </div>

</div>

<?php
require_once "../layout/_bottom_guest.php";
?>
