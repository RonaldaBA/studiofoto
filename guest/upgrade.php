<?php

require_once "../layout/_top_guest.php";
require_once "../helper/connection.php";

$token = $_SESSION['guest_token'];

$query = mysqli_query(
    $connection,
    "SELECT ga.*, c.*
     FROM guest_account ga
     JOIN customer c
     ON ga.id_customer = c.id_customer
     WHERE ga.guest_token='$token'
     LIMIT 1"
);

if(mysqli_num_rows($query) == 0){
    die("Guest tidak ditemukan");
}

$data = mysqli_fetch_assoc($query);

if(isset($_POST['upgrade'])){

    $password  = $_POST['password'];
    $password2 = $_POST['password2'];

    if($password != $password2){

        $error = "Konfirmasi password tidak sama";

    }else{

        $hash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        mysqli_query(
            $connection,
            "UPDATE customer
             SET
             password='$hash',
             account_type='registered'
             WHERE id_customer='{$data['id_customer']}'"
        );

        mysqli_query(
            $connection,
            "UPDATE guest_account
             SET status='inactive'
             WHERE id_guest='{$data['id_guest']}'"
        );

        session_destroy();

        echo "
        <script>
            alert('Upgrade akun berhasil!');
            window.location='../login.php';
        </script>
        ";
        exit;
    }
}
?>

<!-- <!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Upgrade Akun</title>

<link rel="stylesheet"
href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<style>

body{
    background:#f8fafc;
}

.upgrade-card{
    border:none;
    border-radius:20px;
    box-shadow:0 15px 30px rgba(0,0,0,.08);
}

.btn-success{
    background:#22c55e;
    border:none;
}

.btn-success:hover{
    background:#16a34a;
}

</style>

</head>
<body> -->

<div>

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card upgrade-card">

                <div class="card-body p-4">

                    <h3 class="mb-3">
                        Upgrade Akun
                    </h3>

                    <p class="text-muted">
                        Halo <?= htmlspecialchars($data['nama']) ?>,
                        aktifkan akun permanen agar dapat
                        mengakses pesanan dan galeri kapan saja.
                    </p>

                    <?php if(isset($error)): ?>

                    <div class="alert alert-danger">
                        <?= $error ?>
                    </div>

                    <?php endif; ?>

                    <form method="POST">

                        <div class="form-group">
                            <label>Email</label>
                            <input
                                type="email"
                                class="form-control"
                                value="<?= htmlspecialchars($data['email']) ?>"
                                readonly>
                        </div>

                        <div class="form-group">
                            <label>Password Baru</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input
                                type="password"
                                name="password2"
                                class="form-control"
                                required>
                        </div>

                        <button
                            type="submit"
                            name="upgrade"
                            class="btn btn-success btn-block">

                            Upgrade Menjadi Member

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<?php
require_once "../layout/_bottom_guest.php";
?>