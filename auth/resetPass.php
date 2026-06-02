<?php
    session_start();

    require_once '../config/database.php';
    include '../models/user.php';

    $error = '';
    $success = '';

    if(isset($_POST['reset'])) {
        $db = (new Database())->connect();
        $userModel = new User($db);

        $username = $_POST['username'];
        $newPass = $_POST['newpass'];
        $konfirmasi = $_POST['confpass'];

        if (!$userModel->cekUsername($username)) {
            $error = "Username tidak terdaftar di sistem!";
        } elseif ($newPass !== $konfirmasi) {
            $error = "Konfirmasi password tidak cocok!";
        } else {
            if ($userModel->resetPass($username, $newPass)) {
                $success = "Password berhasil direset! Silakan login kembali.";
            } else {
                $error = "Gagal mereset password. Terjadi kesalahan pada sistem.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password MBG</title>
    <link rel="icon" href="../asset/MBG1.png" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-sm" style="width:350px;border-radius:20px;">
        <h4 class="fw-bold mb-3 text-center">Lupa Password</h4>
        
        <?php if($error !== "") : ?>
            <div class="alert alert-danger py-2 text-center" style="font-size: 0.9rem;">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <?php if($success !== "") : ?>
            <div class="alert alert-success py-2 text-center" style="font-size: 0.9rem;">
                <?= $success; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="text"
                    name="username"
                    class="form-control mb-3"
                    placeholder="Masukkan Username"
                    required>

            <input type="password"
                    name="newpass"
                    class="form-control mb-3"
                    placeholder="Password Baru"
                    required>

            <input type="password"
                    name="confpass"
                    class="form-control mb-3"
                    placeholder="Konfirmasi Password"
                    required>

            <button type="submit"
                    name="reset"
                    class="btn btn-warning w-100 fw-semibold">
                Reset Password
            </button>

        </form>
        <a href="login.php" class="text-center mt-3 d-block text-decoration-none">
            Kembali ke Login
        </a>
    </div>
</body>
</html>