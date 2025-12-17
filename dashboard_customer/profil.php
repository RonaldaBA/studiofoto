<?php
include "../helper/auth.php";
include "../helper/connection.php";
isLogin();

$id_customer = $_SESSION['id_customer'];
$editMode = isset($_GET['edit']);

// ambil data customer
$result = mysqli_query($connection, "
    SELECT * FROM customer WHERE id_customer = '$id_customer' LIMIT 1
");
$customer = mysqli_fetch_assoc($result);


// UPDATE DATA
if (isset($_POST['update'])) {
    $nama  = $_POST['nama'];
    $email = $_POST['email'];
    $no_wa = $_POST['no_wa'];
    $pass  = $_POST['password'];

    // JIKA PASSWORD DIISI → HASH
    if (!empty($pass)) {
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        $query = "
            UPDATE customer SET
                nama = '$nama',
                email = '$email',
                no_hp = '$no_wa',
                password = '$hashed_password'
            WHERE id_customer = '$id_customer'
        ";
    } 
    // JIKA PASSWORD KOSONG → TIDAK DIUBAH
    else {
        $query = "
            UPDATE customer SET
                nama = '$nama',
                email = '$email',
                no_hp = '$no_wa'
            WHERE id_customer = '$id_customer'
        ";
    }

    mysqli_query($connection, $query);
    $_SESSION['nama'] = $nama;

    header("Location: profil.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        html { overflow-y: scroll; }

        body {
            background: #f8fafc;
            font-family: Arial, sans-serif;
        }

        .page-wrapper {
            max-width: 700px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .profile-card {
            background: #fff;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }

        .profile-title {
            font-weight: 700;
            margin-bottom: 25px;
            color: #111827;
        }

        .form-control[readonly] {
            background: #f1f5f9;
            cursor: not-allowed;
        }
    </style>
</head>

<body>

<?php include "navbar.php"; ?>

]<div class="page-wrapper">
    <div class="profile-card">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Profil Saya</h4>

            <div>
                <?php if (!$editMode): ?>
                    <a href="profil.php?edit=1"
                    class="btn btn-outline-success btn-sm mr-2">
                        Edit Profil
                    </a>
                <?php endif; ?>

                <a href="logout.php"
                class="btn btn-outline-danger btn-sm"
                onclick="return confirm('Yakin ingin keluar?')">
                    Keluar
                </a>
            </div>
        </div>


        <form method="POST">

            <div class="form-group">
                <label>Nama</label>
                <input type="text"
                       name="nama"
                       class="form-control"
                       value="<?= htmlspecialchars($customer['nama']); ?>"
                       <?= $editMode ? '' : 'readonly'; ?>>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="<?= htmlspecialchars($customer['email']); ?>"
                       <?= $editMode ? '' : 'readonly'; ?>>
            </div>

            <div class="form-group">
                <label>No WhatsApp</label>
                <input type="text"
                       name="no_wa"
                       class="form-control"
                       value="<?= htmlspecialchars($customer['no_hp']); ?>"
                       <?= $editMode ? '' : 'readonly'; ?>>
            </div>

            <!-- PASSWORD -->
            <div class="form-group">
                <label>Password</label>

                <?php if (!$editMode): ?>
                    <!-- MODE LIHAT -->
                    <input type="password"
                           class="form-control"
                           value="********"
                           readonly>
                <?php else: ?>
                    <!-- MODE EDIT -->
                    <div class="input-group">
                        <input type="password"
                               id="oldPassword"
                               class="form-control"
                               value="<?= htmlspecialchars($customer['password']); ?>"
                               readonly>

                        <div class="input-group-append">
                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="toggleOldPassword()">
                                👁
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($editMode): ?>
                <!-- PASSWORD BARU -->
                <div class="form-group">
                    <label>Password Baru</label>
                    <div class="input-group">
                        <input type="password"
                               name="password"
                               id="newPassword"
                               class="form-control"
                               placeholder="Kosongkan jika tidak ingin ganti">

                        <div class="input-group-append">
                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="toggleNewPassword()">
                                👁
                            </button>
                        </div>
                    </div>
                </div>

                <!-- TOMBOL -->
                <div class="mt-4">
                    <button type="submit"
                            name="update"
                            class="btn btn-success px-4">
                        Simpan
                    </button>

                    <a href="profil.php"
                       class="btn btn-secondary ml-2">
                        Batal
                    </a>
                </div>
            <?php endif; ?>

        </form>

    </div>
</div>



<script>
function toggleOldPassword() {
    const input = document.getElementById("oldPassword");
    input.type = input.type === "password" ? "text" : "password";
}

function toggleNewPassword() {
    const input = document.getElementById("newPassword");
    input.type = input.type === "password" ? "text" : "password";
}
</script>
</body>

</html>
