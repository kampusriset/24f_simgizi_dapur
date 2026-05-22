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
            $_SESSION['id_user'] = $cek['id_user'];
            $_SESSION['nama'] = $cek['nama'];
            $_SESSION['username'] = $cek['username'];
            $_SESSION['role'] = $cek['role'];
        }
    }
?>