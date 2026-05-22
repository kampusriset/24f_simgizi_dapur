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
            echo "Register Gagal";
        }
    } else {
        header("Location: register.php");
        exit;
    }
?>