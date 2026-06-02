<?php
    session_start();
    require_once '../config/database.php';
    require_once '../models/user.php';

    $db = (new Database())-> connect();
    $user = new User($db);

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $resLogin = $user->login($username, $password);

        if ($resLogin) {
            $_SESSION['id_user'] = $resLogin['id_user'];
            $_SESSION['nama'] = $resLogin['nama'];
            $_SESSION['username'] = $resLogin['username'];
            $_SESSION['role'] = $resLogin['role'];

            $_SESSION['Success Login'] = True;
    
            if ($_SESSION['role'] === 'admin') {
                header("Location: ../templates/admin.php");
            } elseif ($_SESSION['role'] === 'petugas') {
                header("Location: ../templates/petugas.php");
            } elseif ($_SESSION['role'] === 'sekolah') {
                header("Location: ../templates/sekolah.php");
            }
            else {
                header("Location: ../templates/dashboard.php");
            }
            exit;
        } else {
            echo "
            <script>
                if(confirm('Password salah! Klik OK untuk reset password.')){
                    window.location='resetPass.php';
                }
            </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login MBG</title>
    <link rel="icon" href="/CRUD-DAPUR-MBG/asset/MBG1.png" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-sm" style="width:350px;border-radius:20px;">
        <h4 class="fw-bold mb-3 text-center">Login MBG</h4>
        <form method="POST">

            <input type="text"
                    name="username"
                    class="form-control mb-3"
                    placeholder="Username"
                    required>

            <input type="password"
                    name="password"
                    class="form-control mb-2"
                    placeholder="Password"
                    required>

            <div class="text-end mb-3">
                <a href="resetPass.php">Lupa Password?</a>
            </div>

            <button class="btn btn-success w-100" name="login">
                Login
            </button>

        </form>

        <a href="register.php" class="text-center mt-3 d-block">
            Register jika belum memiliki akun!!!
        </a>
    </div>
</body>
</html>