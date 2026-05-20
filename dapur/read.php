<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    require_once '../config/database.php';
    include '../models/dapur.php';
    include '../models/mitra.php';
    
    $db = (new Database())->connect();
    $dapur = new Dapur($db);
    $mitra = new Mitra($db);

    $aksi = $_GET['aksi'] ?? 'read';

    if ($aksi == 'read') {
        $dataDapur = $dapur->tampilDapur();
    } elseif ($aksi == 'tambah') {
        $dataMitra = $mitra->getAll();
    } elseif ($aksi == 'edit') {
        $id = $_GET['id'];
        $dataEdit = $dapur->getById($id);
        $dataMitra = $mitra->getAll();
    }

    include_once '../templates/dapur.php';
?>