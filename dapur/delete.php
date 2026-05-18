<?php
    require_once '../config/database.php';
    require_once '../models/dapur.php';

    $db = (new Database())->connect();
    $dapur = new Dapur($db);

    $id = $_GET['id'] ?? null;

    if ($id) {
        if ($dapur->delete($id)) {
            // Jika terhapus, nanti akan kembali ke halaman read
            heaeder("Location: read.php?status=success_deleted");
        } else {
            // Jika gagal
            header("Location: read.php");
        }
    } else {
        // Jika file diakses tanpa ID, otomatis balik ke halaman read
        header("Location: read.php");
    }
    exit;
?>