<?php
    require_once '../config/database.php';
    require_once '../models/dapur.php';
    require_once '../models/mitra.php';

    $db = (new Database())->connect();
    $dapur = new Dapur($db);
    $mitra = new Mitra($db);

    // Mengambil data lama untuk ditampilkan
    $id = $_GET['id'] ?? null;
    $dl = $dapur->getById($id);

    // Daftar data mitra untuk dropdown
    $listMitra = $mitra->getAll();
    
    if(!$id) {
        header("Location: read.php");
        exit;
    }

?>