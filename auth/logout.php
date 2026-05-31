<?php
    session_start();

    // hapus semua session login
    $_SESSION = array();

    // destroy session
    session_destroy();

    // redirect ke login
    header("Location: ../login.php");
    exit();
?>