<?php
    session_start();
    require_once '../config/database.php';
    require_once '../models/user.php';

    $db = (new Database())-> connect();
    $user = new User($db);

    $error_login = false;

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
    
            header("Location: ../templates/dashboard.php");
            exit;
        } else {
            $error_login = True;
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login MBG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-sm" style="width:350px;border-radius:20px;">
        <h4 class="fw-bold mb-3 text-center">Login MBG</h4>
        <form method="POST">
            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button class="btn btn-success w-100" name="login">Login</button>
        </form>

        <a href="register.php" class="text-center mt-3 d-block">
            Register jika belum memiliki akun
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if($error_login): ?>
    <script>
        Swal.fire ({
            icon: 'error',
            title: 'Oops...',
            text: 'Userame atau Password Salah!',
            confirmButtonColor: '#d33'
        });
    </script>
    <?php endif; ?>
</body>
</html>