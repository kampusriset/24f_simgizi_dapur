<?php
    require_once '../config/database.php';
    include '../models/dapur.php';
    include '../models/mitra.php';

    $db = (new Database())->connect();
    $dapur = new Dapur($db);
    $mitra = new Mitra($db);

    $dataMitra = $mitra->tampilMitra();
    if(isset($_POST['submit'])){
        $dapur->tambahDapur($_POST);
        header("Location: read.php");
    }
?>