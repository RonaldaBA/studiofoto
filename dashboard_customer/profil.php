<?php
include "../helper/auth.php";
include "../helper/connection.php";
isLogin();

$id_user = $_SESSION['id_user'];
$editMode = isset($_GET['edit']);

// ambil data customer
$result = mysqli_query($connection, "
    SELECT * FROM customer WHERE id_user = '$id_user' LIMIT 1
");
$customer = mysqli_fetch_assoc($result);

// UPDATE DATA
if (isset($_POST['update'])) {
    $nama  = $_POST['nama'];
    $email = $_POST['email'];
    $no_wa = $_POST['no_wa'];
    $pass  = $_POST['password'];

    if (!empty($pass)) {
        $query = "
            UPDATE customer SET
                nama = '$nama',
                email = '$email',
                no_hp = '$no_wa',
                password = '$pass'
            WHERE id_user = '$id_user'
        ";
    } else {
        $query = "
            UPDATE customer SET
                nama = '$nama',
                email = '$email',
                no_hp = '$no_wa'
            WHERE id_user = '$id_user'
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

<div class="page-wrapper">
    <div class="profile-card">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="profile-title mb-0">Profil Saya</h4>

            <?php if (!$editMode): ?>
                <a href="profil.php?edit=1" class="btn btn-outline-success btn-sm">
                    Edit Profil
                </a>
            <?php endif; ?>
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

            <?php if ($editMode): ?>
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Kosongkan jika tidak ingin ganti">
                </div>

                <div class="mt-4">
                    <button name="update" class="btn btn-success px-4">
                        Simpan
                    </button>
                    <a href="profil.php" class="btn btn-secondary ml-2">
                        Batal
                    </a>
                </div>
            <?php endif; ?>
        </form>

    </div>
</div>

</body>
</html>
