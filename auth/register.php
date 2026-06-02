<?php
    require_once '../config/database.php';
    require_once '../models/user.php';

    $db = (new Database())->connect();
    $user = new User($db);

    if (isset($_POST['username'])) {
        $register = $user->register(
            $_POST['nama'],
            $_POST['username'],
            $_POST['password'],
            $_POST['role']
        );
        
        if ($register) {
            header("Location: login.php");
            exit;
        } else {
            echo "Pendaftaran gagal! Username mungkiin telah digunakan.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register MBG</title>
    <link rel="icon" href="/CRUD-DAPUR-MBG/asset/MBG1.png" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-sm" style="width:350px;border-radius:20px;">
        <h4 class="fw-bold mb-3 text-center">Register</h4>
        <form method="POST">
            <input type="text" name="nama" class="form-control mb-3" placeholder="Nama Lengkap" required>
            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <select name="role" class="form-control mb-3" required>
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="petugas">Petugas</option>
                <option value="dapur">Dapur</option>
                <option value="sekolah">Sekolah</option>
            </select>
            <button class="btn btn-primary w-100" name="register">Register</button>
        </form>

        <a href="login.php" class="text-center mt-3 d-block">
            Login jika sudah memiliki akun
        </a>

    </div>
</body>
</html>