<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/database.php';
include '../models/dapur.php';

$db = (new Database())->connect();
$dapur = new Dapur($db);

if(isset($_POST['submit'])){
    $dapur->tambahDapur($_POST);
    header("Location: read.php");
    exit;
} else {
    header("Location: read.php");
    exit;
}
?>